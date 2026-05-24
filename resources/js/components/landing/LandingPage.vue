<template>
  <div class="landing-wrapper overflow-hidden">
    <!-- HERO SECTION -->
    <section class="hero-section position-relative min-vh-100 d-flex align-items-center">
      <!-- Background Elements -->
      <div class="hero-bg position-absolute inset-0">
        <img :src="heroImage" alt="Hero Background" class="hero-img w-100 h-100 object-fit-cover" @error="handleImageError">
        <div class="hero-gradient-overlay"></div>
        <div class="hero-mesh-gradient"></div>
      </div>

      <div class="container position-relative z-1">
        <div class="row align-items-center">
          <div class="col-lg-7 text-start">
            <div class="hero-badge-container mb-4 fade-in-up">
              <span class="premium-badge">
                <i class="bi bi-stars text-accent me-2"></i>
                Wadah Resmi Alumni SD Muhammadiyah Birrul Walidain
              </span>
            </div>

            <h1 class="hero-title display-2 fw-800 text-white mb-3 fade-in-up" style="animation-delay: 0.1s">
              Temukan Kembali<br>
              <span class="text-accent text-glow">Jejaring Alumni</span> Anda
            </h1>

            <p class="hero-subtitle fs-5 text-white text-opacity-80 mb-5 fade-in-up" style="animation-delay: 0.2s; max-width: 600px;">
              Bersama membangun masa depan yang lebih cerah melalui kolaborasi, inspirasi, dan silaturahmi yang tak terputus.
            </p>

            <div class="hero-cta d-flex flex-wrap gap-3 fade-in-up" style="animation-delay: 0.3s">
              <template v-if="user">
                <a :href="dashboardUrl" class="btn btn-accent-premium btn-lg px-5 py-3 rounded-pill fw-bold">
                  <i class="bi bi-speedometer2 me-2"></i> Dashboard Panel
                </a>
              </template>
              <template v-else>
                <a :href="loginUrl" class="btn btn-accent-premium btn-lg px-5 py-3 rounded-pill fw-bold">
                  <i class="bi bi-box-arrow-in-right me-2"></i> Masuk Akun Alumni
                </a>
              </template>
            </div>
          </div>
          
          <div class="col-lg-5 d-none d-lg-block fade-in-up" style="animation-delay: 0.4s">
            <div class="hero-floating-card glass-card p-4 text-center p-5">
              <div class="card-icon-circle mx-auto mb-4">
                <i class="bi bi-mortarboard fs-1 text-primary"></i>
              </div>
              <h3 class="fw-bold mb-2">Pendidikan Berkualitas</h3>
              <p class="text-muted small">Mencetak generasi unggul yang berakhlak mulia dan berprestasi.</p>
              <div class="d-flex justify-content-center gap-2 mt-4">
                <div class="dot active"></div>
                <div class="dot"></div>
                <div class="dot"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Scroll Indicator -->
      <div class="scroll-indicator position-absolute bottom-0 start-50 translate-middle-x mb-5">
        <div class="mouse-icon"></div>
      </div>
    </section>

    <!-- STATS SECTION -->
    <section class="stats-grid py-5 mt-n5 position-relative z-2">
      <div class="container">
        <div class="row g-4 justify-content-center">
          <div class="col-6 col-lg-3" v-for="(stat, i) in statsItems" :key="i">
            <div class="stat-card-premium fade-in-up" :style="`animation-delay: ${0.2 + i*0.1}s`">
              <div class="stat-inner">
                <div class="stat-icon-wrap" :class="stat.bg">
                  <i :class="['bi', stat.icon, stat.color]"></i>
                </div>
                <div class="stat-content">
                  <div class="stat-number">{{ stat.value }}</div>
                  <div class="stat-label text-uppercase">{{ stat.label }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FEATURES -->
    <section class="features-section py-5 my-5">
      <div class="container py-5">
        <div class="text-center mb-5 fade-in-up">
          <h2 class="section-title h1 fw-bold mb-3">Layanan Untuk Alumni</h2>
          <p class="text-muted mx-auto" style="max-width: 600px;">Beberapa fitur utama yang dapat Anda akses setelah bergabung dalam sistem alumni kami.</p>
        </div>

        <div class="row g-4">
          <div class="col-md-4" v-for="(feature, i) in features" :key="i">
            <a :href="i === 0 ? '/direktori-alumni' : (user ? dashboardUrl : loginUrl)" class="text-decoration-none h-100 d-block">
              <div class="feature-card glass-card p-5 h-100 fade-in-up" :style="`animation-delay: ${0.4 + i*0.1}s`">
                <div class="feature-icon mb-4" :class="feature.bg">
                  <i :class="['bi', feature.icon]"></i>
                </div>
                <h4 class="fw-bold mb-3 text-dark">{{ feature.title }}</h4>
                <p class="text-muted mb-0 lh-lg">{{ feature.desc }}</p>
              </div>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- BERITA SECTION -->
    <section v-if="beritas && beritas.length > 0" class="berita-section py-5 my-3 bg-white position-relative">
      <div class="container py-5">
        <div class="text-center mb-5 fade-in-up">
          <div class="hero-badge-container mb-3">
            <span class="premium-badge text-primary bg-primary-subtle border-0">
              <i class="bi bi-newspaper text-primary me-2"></i> Berita & Informasi
            </span>
          </div>
          <h2 class="section-title h1 fw-bold mb-3">Kabar Terbaru Sekolah & Alumni</h2>
          <p class="text-muted mx-auto" style="max-width: 600px;">Ikuti berita, pengumuman, dan agenda kegiatan terbaru seputar SD Muhammadiyah Birrul Walidain.</p>
        </div>

        <div class="row g-4 justify-content-center">
          <div class="col-md-6 col-lg-4" v-for="(berita, i) in beritas" :key="berita.id">
            <div class="berita-card glass-card h-100 d-flex flex-column fade-in-up overflow-hidden position-relative" :class="{ 'featured-card-highlight': berita.is_featured }" :style="`animation-delay: ${0.2 + (i%3)*0.1}s`">
              <div v-if="berita.is_featured" class="featured-badge-modern">
                <i class="bi bi-star-fill me-1"></i> Unggulan
              </div>
              <div v-if="berita.image_url" class="berita-img-wrapper overflow-hidden" style="height: 200px; border-bottom: 1px solid rgba(226, 232, 240, 0.6); position: relative;">
                <img :src="berita.image_url" class="w-100 h-100 object-fit-cover berita-img-thumb" alt="Gambar Berita">
              </div>
              <div class="p-4 d-flex flex-column flex-grow-1">
                <div class="d-flex align-items-center justify-content-between mb-3 text-muted small">
                  <span><i class="bi bi-calendar3 me-1"></i>{{ formatDate(berita.created_at) }}</span>
                  <span class="d-flex align-items-center gap-1">
                    <i class="bi bi-eye me-1"></i>{{ berita.views_count || 0 }} dibaca
                  </span>
                </div>
                <h5 class="fw-bold mb-3 text-primary text-line-clamp-2">{{ berita.title }}</h5>
                <p class="text-muted small mb-4 flex-grow-1 text-line-clamp-4">{{ stripHtml(berita.excerpt || berita.content) }}</p>
                
                <!-- Link Detail Berita -->
                <a :href="'/berita/' + berita.slug" class="btn btn-outline-primary rounded-pill px-4 mt-auto align-self-start fw-bold shadow-sm">
                  Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="text-center mt-5 fade-in-up" style="animation-delay: 0.4s">
          <a href="/berita" class="btn btn-accent-premium btn-lg px-5 py-3 rounded-pill fw-bold">
            Lihat Semua Berita <i class="bi bi-arrow-right ms-2"></i>
          </a>
        </div>
      </div>
    </section>

    <!-- TESTIMONIALS -->
    <section v-if="testimonis && testimonis.length > 0" class="testimonials-section py-5 bg-light position-relative">
      <div class="container py-5">
        <div class="text-center mb-5 fade-in-up">
          <h2 class="section-title h1 fw-bold mb-3">Apa Kata Alumni?</h2>
          <p class="text-muted mx-auto" style="max-width: 600px;">Cerita inspiratif dari mereka yang telah lulus dan berkarya.</p>
        </div>
        <div class="row g-4">
          <div class="col-md-4" v-for="(testimoni, i) in testimonis" :key="testimoni.id">
            <div class="testimonial-card p-4 h-100 fade-in-up" :style="`animation-delay: ${0.2 + (i%3)*0.1}s`">
              <div class="d-flex align-items-center gap-3 mb-4">
                <div class="avatar-md rounded-circle overflow-hidden bg-white shadow-sm border" style="width: 55px; height: 55px;">
                  <img v-if="testimoni.alumni.fotos && testimoni.alumni.fotos.length > 0" :src="`/storage/${testimoni.alumni.fotos[0].path_file}`" class="w-100 h-100 object-fit-cover" alt="Foto">
                  <div v-else class="w-100 h-100 d-flex align-items-center justify-content-center bg-primary text-white fw-bold fs-5">
                    {{ testimoni.alumni.nama_lengkap.charAt(0).toUpperCase() }}
                  </div>
                </div>
                <div>
                  <h6 class="fw-bold mb-1 text-primary">{{ testimoni.alumni.nama_lengkap }}</h6>
                  <p class="text-muted small mb-0"><i class="bi bi-mortarboard-fill me-1 text-accent"></i>{{ testimoni.alumni.angkatan?.nama_angkatan || '-' }}</p>
                </div>
              </div>
              <div class="quote-icon mb-2"><i class="bi bi-quote fs-2 text-black-50 opacity-25"></i></div>
              <p class="fst-italic text-muted mb-0 lh-lg">"{{ testimoni.content }}"</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ -->
    <section v-if="faqs && faqs.length > 0" class="faq-section py-5 my-3">
      <div class="container py-5">
        <div class="row align-items-center">
          <div class="col-lg-5 mb-5 mb-lg-0 fade-in-up">
            <div class="hero-badge-container mb-3">
              <span class="premium-badge text-primary bg-primary-subtle border-0">
                <i class="bi bi-question-circle-fill text-primary me-2"></i> FAQ
              </span>
            </div>
            <h2 class="display-6 fw-bold mb-4">Pertanyaan Seputar<br><span class="text-primary">Alumni SDMBW</span></h2>
            <p class="text-muted mb-4 lh-lg">Temukan jawaban dari pertanyaan yang sering diajukan mengenai login sistem, pembaruan data profil, dan cara memberikan testimoni alumni.</p>
            <a :href="loginUrl" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-bold shadow-sm">Masuk ke Sistem <i class="bi bi-arrow-right ms-2"></i></a>
          </div>
          <div class="col-lg-7 fade-in-up" style="animation-delay: 0.2s">
            <div class="accordion accordion-flush custom-accordion" id="faqAccordion">
              <div class="accordion-item" v-for="(faq, index) in faqs" :key="faq.id">
                <h2 class="accordion-header" :id="'heading' + index">
                  <button 
                    class="accordion-button fw-bold" 
                    :class="{ 'collapsed': activeIndex !== index }"
                    type="button" 
                    @click="activeIndex = activeIndex === index ? null : index"
                  >
                    {{ faq.question }}
                  </button>
                </h2>
                <div 
                  class="accordion-collapse" 
                  v-show="activeIndex === index"
                >
                  <div class="accordion-body text-muted lh-lg">
                    {{ faq.answer }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA SECTION -->
    <section class="cta-section-modern py-5 mb-5">
      <div class="container py-4">
        <div class="cta-banner rounded-5 overflow-hidden position-relative p-5 text-center">
          <div class="cta-bg position-absolute inset-0"></div>
          <div class="position-relative z-1 py-4">
            <h2 class="display-5 fw-bold text-white mb-4">Siap Untuk Terhubung Kembali?</h2>
            <p class="text-white text-opacity-75 mb-5 mx-auto fs-5" style="max-width: 650px;">
              Jangan lewatkan kesempatan untuk saling berbagi peluang kerja, informasi pendidikan, dan silaturahmi.
            </p>
            <template v-if="!user">
              <a :href="loginUrl" class="btn btn-accent-premium btn-lg px-5 py-3 rounded-pill fw-bold shadow-lg">
                Masuk ke Akun Anda <i class="bi bi-chevron-right ms-2"></i>
              </a>
            </template>
            <template v-else>
              <div class="welcome-tag d-inline-flex align-items-center gap-3 px-4 py-3 rounded-pill glass-card border-white border-opacity-20 text-white">
                <div class="avatar-sm rounded-circle bg-accent text-primary fw-bold d-flex align-items-center justify-content-center">
                  {{ user.username?.charAt(0).toUpperCase() }}
                </div>
                <span>Selamat datang kembali, <strong>{{ user.username }}</strong>!</span>
              </div>
            </template>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
const activeIndex = ref(null);

const props = defineProps({
  user: { type: Object, default: null },
  stats: { type: Object, default: () => ({ total_alumni: 0, total_angkatan: 0, profil_lengkap: 0, total_instansi: 0 }) },
  faqs: { type: Array, default: () => [] },
  testimonis: { type: Array, default: () => [] },
  beritas: { type: Array, default: () => [] },
  heroImage: { type: String, required: true },
  dashboardUrl: { type: String, required: true },
  loginUrl: { type: String, required: true }
});

const formatDate = (dateStr) => {
  if (!dateStr) return '';
  const date = new Date(dateStr);
  return date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
};

const stripHtml = (html) => {
  if (!html) return '';
  const doc = new DOMParser().parseFromString(html, 'text/html');
  return doc.body.textContent || "";
};

const statsItems = computed(() => [
  { label: 'Alumni', value: props.stats?.total_alumni || 0, icon: 'bi-people-fill', color: 'text-primary', bg: 'bg-primary-subtle' },
  { label: 'Angkatan', value: props.stats?.total_angkatan || 0, icon: 'bi-mortarboard-fill', color: 'text-accent', bg: 'bg-accent-subtle' },
  { label: 'Profil Lengkap', value: props.stats?.profil_lengkap || 0, icon: 'bi-check-circle-fill', color: 'text-success', bg: 'bg-success-subtle' },
  { label: 'Instansi', value: props.stats?.total_instansi || 0, icon: 'bi-building-fill', color: 'text-danger', bg: 'bg-danger-subtle' }
]);

const features = [
  { title: 'Direktori Alumni', desc: 'Cari dan temukan teman lama berdasarkan angkatan, lokasi, atau nama dengan mudah.', icon: 'bi-search', bg: 'bg-primary' },
  { title: 'Update Profil', desc: 'Kelola data diri, riwayat pendidikan, dan pekerjaan Anda agar tetap terhubung dengan sekolah.', icon: 'bi-person-gear', bg: 'bg-accent' },
  { title: 'Berbagi Peluang', desc: 'Bagikan informasi peluang karir, pendidikan lanjutan, dan kontribusi nyata untuk almamater.', icon: 'bi-briefcase', bg: 'bg-success' }
];

const handleImageError = (e) => { e.target.style.display = 'none'; };
</script>

<style scoped>
.fw-800 { font-weight: 800; }
.inset-0 { top: 0; right: 0; bottom: 0; left: 0; }
.z-1 { z-index: 1; }
.z-2 { z-index: 2; }
.mt-n5 { margin-top: -5rem; }
.text-glow { text-shadow: 0 0 20px rgba(232, 200, 122, 0.4); }

.hero-section { min-height: 100vh; overflow: hidden; background: #112534; }
.hero-img { filter: brightness(0.4) contrast(1.1); }
.hero-gradient-overlay { 
  position: absolute; inset: 0;
  background: linear-gradient(to right, rgba(17,37,52,0.9) 0%, rgba(17,37,52,0.6) 50%, rgba(17,37,52,0.2) 100%);
}
.hero-mesh-gradient {
  position: absolute; top: -50%; right: -20%; width: 100%; height: 200%;
  background: radial-gradient(circle at center, rgba(42,83,120,0.2) 0%, transparent 60%);
  transform: rotate(-15deg);
}

.premium-badge {
  background: rgba(255,255,255,0.1);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(255,255,255,0.15);
  color: #fff;
  padding: 0.6rem 1.4rem;
  border-radius: 50px;
  font-weight: 700;
  font-size: 0.8rem;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.btn-accent-premium {
  background: var(--accent, #E8C87A);
  color: #112534;
  border: none;
  transition: all 0.3s ease;
  box-shadow: 0 10px 20px rgba(232, 200, 122, 0.2);
}
.btn-accent-premium:hover {
  background: #d9b75e;
  transform: translateY(-4px);
  box-shadow: 0 15px 30px rgba(232, 200, 122, 0.3);
}

.btn-outline-white-premium {
  background: transparent;
  color: #fff;
  border: 2px solid rgba(255,255,255,0.3);
}
.btn-outline-white-premium:hover {
  background: rgba(255,255,255,0.1);
  border-color: #fff;
  transform: translateY(-4px);
}

.hero-floating-card {
  border-radius: 30px;
  transform: perspective(1000px) rotateY(-5deg);
  box-shadow: 20px 20px 60px rgba(0,0,0,0.3);
  transition: all 0.5s ease;
}
.hero-floating-card:hover {
  transform: perspective(1000px) rotateY(0deg) translateY(-10px);
}
.card-icon-circle {
  width: 100px; height: 100px;
  background: #f1f5f9;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
}

.stat-card-premium {
  background: #fff;
  border-radius: 24px;
  padding: 2rem;
  box-shadow: 0 15px 35px rgba(0,0,0,0.06);
  transition: all 0.3s ease;
}
.stat-card-premium:hover {
  transform: translateY(-10px);
  box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}
.stat-inner { display: flex; align-items: center; gap: 1.5rem; }
.stat-icon-wrap {
  width: 60px; height: 60px;
  border-radius: 18px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.5rem;
}
.stat-number { font-size: 2rem; font-weight: 800; color: #1B3A52; line-height: 1; margin-bottom: 0.2rem; }
.stat-label { color: #64748b; font-size: 0.75rem; font-weight: 700; letter-spacing: 1px; }

.bg-primary-subtle { background: rgba(27, 58, 82, 0.1); }
.bg-accent-subtle { background: rgba(232, 200, 122, 0.1); }
.bg-success-subtle { background: rgba(25, 135, 84, 0.1); }
.bg-danger-subtle { background: rgba(220, 53, 69, 0.1); }

.feature-card {
  border-radius: 24px;
  transition: all 0.3s ease;
}
.feature-card:hover {
  background: #fff;
  transform: translateY(-10px);
  box-shadow: 0 20px 50px rgba(0,0,0,0.05);
}
.feature-icon {
  width: 50px; height: 50px;
  border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: 1.25rem;
}
.bg-primary { background: #1B3A52; }
.bg-accent { background: #E8C87A; }
.bg-success { background: #198754; }

.cta-banner {
  background: #112534;
}
.cta-bg {
  background: radial-gradient(circle at top right, rgba(232,200,122,0.1), transparent);
}
.avatar-sm { width: 40px; height: 40px; }

.mouse-icon {
  width: 30px; height: 50px;
  border: 2px solid rgba(255,255,255,0.3);
  border-radius: 20px;
  position: relative;
}
.mouse-icon::after {
  content: '';
  position: absolute; top: 8px; left: 50%;
  width: 4px; height: 8px;
  background: #fff;
  border-radius: 2px;
  transform: translateX(-50%);
  animation: mouseWheel 2s infinite;
}
@keyframes mouseWheel {
  0% { opacity: 1; top: 8px; }
  100% { opacity: 0; top: 30px; }
}

.dot { width: 8px; height: 8px; border-radius: 50%; background: #e2e8f0; }
.dot.active { background: #E8C87A; width: 24px; border-radius: 4px; }

/* Testimoni & FAQ Styles */
.testimonial-card {
  border-radius: 24px;
  background: white;
  border: 1px solid rgba(226, 232, 240, 0.8);
  box-shadow: 0 10px 30px rgba(0,0,0,0.03);
  transition: all 0.3s ease;
  position: relative;
  z-index: 1;
}
.testimonial-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 40px rgba(0,0,0,0.08);
  border-color: rgba(232,200,122,0.5);
}
.quote-icon { margin-top: -15px; }

.custom-accordion .accordion-item {
  border: none;
  background: transparent;
  margin-bottom: 1rem;
}
.custom-accordion .accordion-button {
  background: white;
  border-radius: 16px !important;
  box-shadow: 0 4px 15px rgba(0,0,0,0.02);
  padding: 1.25rem 1.5rem;
  color: #1B3A52;
  transition: all 0.3s;
  border: 1px solid rgba(226, 232, 240, 0.6);
}
.custom-accordion .accordion-button:focus { box-shadow: 0 0 0 3px rgba(27,58,82,0.1); }
.custom-accordion .accordion-button:not(.collapsed) {
  background: #1B3A52;
  color: white;
  box-shadow: 0 8px 25px rgba(27,58,82,0.15);
  border-color: #1B3A52;
}
.custom-accordion .accordion-button::after { filter: contrast(0.5); }
.custom-accordion .accordion-button:not(.collapsed)::after { filter: brightness(0) invert(1); }
.custom-accordion .accordion-collapse {
  background: white;
  border-radius: 0 0 16px 16px;
  margin-top: -10px;
  padding-top: 15px;
  border: 1px solid rgba(226, 232, 240, 0.6);
  border-top: none;
  box-shadow: 0 10px 15px rgba(0,0,0,0.02);
}

/* Berita Card & Clamp Styles */
.text-line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.text-line-clamp-4 {
  display: -webkit-box;
  -webkit-line-clamp: 4;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.berita-card {
  border-radius: 24px;
  background: white;
  border: 1px solid rgba(226, 232, 240, 0.8);
  box-shadow: 0 10px 30px rgba(0,0,0,0.03);
  transition: all 0.3s ease;
}
.berita-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 40px rgba(0,0,0,0.08);
  border-color: rgba(27, 58, 82, 0.3);
}
.berita-img-thumb {
  transition: transform 0.4s ease;
}
.berita-card:hover .berita-img-thumb {
  transform: scale(1.05);
}
.featured-badge-modern {
  position: absolute;
  top: 14px;
  left: 14px;
  z-index: 5;
  background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
  color: white;
  font-size: 0.72rem;
  font-weight: 800;
  padding: 5px 12px;
  border-radius: 50px;
  letter-spacing: 0.8px;
  text-transform: uppercase;
  box-shadow: 0 4px 10px rgba(217,119,6,0.3);
  display: flex;
  align-items: center;
  gap: 5px;
}
.berita-card.featured-card-highlight {
  border: 1.5px solid rgba(232, 200, 122, 0.6);
  background: linear-gradient(to bottom, #fff 0%, #fffbf2 100%);
}
</style>
