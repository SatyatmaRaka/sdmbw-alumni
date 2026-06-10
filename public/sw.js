const CACHE_NAME = 'sdmbw-alumni-cache-v2';
const urlsToCache = [
  '/',
  '/offline.html',
  '/site.webmanifest',
  '/favicon.ico',
  '/images/logo-sdmbw.png',
  '/css/custom.css',
  // Vite assets di-cache otomatis saat pertama diakses (Network-First strategy)
];

// Install event
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        // addAll akan gagal jika salah satu URL error; gunakan individual add untuk toleransi
        return Promise.allSettled(
          urlsToCache.map(url => cache.add(url).catch(() => {
            console.warn('[SW] Failed to cache:', url);
          }))
        );
      })
  );
  // Ambil alih segera tanpa menunggu tab lama ditutup
  self.skipWaiting();
});

// Activate event (bersihkan cache lama)
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (cacheName !== CACHE_NAME) {
            console.log('[SW] Deleting old cache:', cacheName);
            return caches.delete(cacheName);
          }
        })
      );
    }).then(() => self.clients.claim())
  );
});

// Fetch event (Network First strategy untuk halaman dinamis)
self.addEventListener('fetch', event => {
  // Hanya proses request GET
  if (event.request.method !== 'GET') return;

  event.respondWith(
    fetch(event.request)
      .then(response => {
        // Jika request sukses (online), simpan ke cache
        if (response && response.status === 200 && response.type === 'basic') {
          const responseToCache = response.clone();
          caches.open(CACHE_NAME)
            .then(cache => {
              cache.put(event.request, responseToCache);
            });
        }
        return response;
      })
      .catch(() => {
        // Jika offline, coba ambil dari cache terlebih dahulu
        return caches.match(event.request).then(cached => {
          if (cached) return cached;

          // Fallback ke offline.html untuk request navigasi (halaman HTML)
          if (event.request.mode === 'navigate') {
            return caches.match('/offline.html');
          }

          // Untuk asset lain yang tidak ter-cache, return empty response
          return new Response('', { status: 503, statusText: 'Service Unavailable' });
        });
      })
  );
});
