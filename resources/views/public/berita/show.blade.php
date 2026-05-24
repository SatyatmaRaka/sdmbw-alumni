@extends('layouts.landing')

@section('title', $berita->title)

@section('content')
@push('styles')
<style>
    :root {
        --primary:       #1B3A52;
        --primary-light: #2a5378;
        --primary-dark:  #112534;
        --accent:        #E8C87A;
        --accent-soft:   rgba(232,200,122,0.12);
        --bg:            #F7F5F0;
        --radius:        14px;
        --transition:    all 0.26s cubic-bezier(0.4,0,0.2,1);
        --shadow-card:   0 2px 0 rgba(255,255,255,0.7) inset, 0 8px 28px rgba(27,58,82,0.09);
    }

    /* ── BREADCRUMB ── */
    .breadcrumb-wrapper {
        background: white;
        border-bottom: 1px solid #e2e8f0;
        padding: 0.9rem 0;
    }

    .breadcrumb-custom {
        margin-bottom: 0;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .breadcrumb-custom a {
        color: var(--primary-light);
        text-decoration: none;
        transition: var(--transition);
    }

    .breadcrumb-custom a:hover {
        color: var(--primary);
    }

    .breadcrumb-custom .active {
        color: #64748b;
    }

    /* ── ARTICLE AREA ── */
    .article-container {
        padding: 3.5rem 0 5rem;
    }

    .article-card {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow-card);
        border: 1px solid rgba(226,232,240,0.8);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .article-hero-image {
        position: relative;
        height: 420px;
        width: 100%;
        background: var(--primary-dark);
    }

    .article-hero-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .article-badge-featured {
        position: absolute;
        top: 20px; left: 20px;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        font-size: 0.75rem;
        font-weight: 800;
        padding: 6px 14px;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        box-shadow: 0 4px 12px rgba(217,119,6,0.35);
    }

    .article-content-wrapper {
        padding: 2.5rem 3rem;
    }

    .article-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        font-size: 0.82rem;
        color: #64748b;
        margin-bottom: 1.5rem;
        font-weight: 500;
    }

    .article-meta span {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .article-meta i {
        font-size: 0.9rem;
        color: var(--primary-light);
    }

    .article-title {
        font-family: 'DM Serif Display', serif;
        font-size: clamp(1.8rem, 4vw, 2.5rem);
        color: var(--primary-dark);
        line-height: 1.25;
        margin-bottom: 1.5rem;
        font-weight: 400;
    }

    .article-excerpt-callout {
        background: #f8fafc;
        border-left: 4px solid var(--accent);
        padding: 1.25rem 1.5rem;
        border-radius: 0 8px 8px 0;
        font-size: 0.95rem;
        font-style: italic;
        color: #334155;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    /* Quill contents style styling compatibility */
    .article-body-content {
        font-size: 1.05rem;
        line-height: 1.8;
        color: #334155;
    }

    .article-body-content p {
        margin-bottom: 1.25rem;
    }

    .article-body-content h1, 
    .article-body-content h2, 
    .article-body-content h3 {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--primary-dark);
        font-weight: 700;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .article-body-content h1 { font-size: 1.6rem; }
    .article-body-content h2 { font-size: 1.4rem; }
    .article-body-content h3 { font-size: 1.2rem; }

    .article-body-content ul, 
    .article-body-content ol {
        margin-bottom: 1.25rem;
        padding-left: 1.5rem;
    }

    /* ── SHARE BOX ── */
    .share-box {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 3.5rem;
        border: 1px solid #e2e8f0;
    }

    .share-title {
        font-weight: 700;
        color: var(--primary);
        font-size: 0.9rem;
        margin-bottom: 0;
    }

    .btn-share-copy {
        background: white;
        border: 1.5px solid #cbd5e1;
        border-radius: 8px;
        padding: 0.5rem 1.25rem;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--primary);
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
    }

    .btn-share-copy:hover {
        border-color: var(--primary);
        background: var(--primary);
        color: white;
    }

    /* ── SIDEBAR RELATED ── */
    .sidebar-section-title {
        font-family: 'DM Serif Display', serif;
        font-size: 1.4rem;
        color: var(--primary-dark);
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 10px;
    }

    .sidebar-section-title::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0;
        width: 40px; height: 3px;
        background: var(--accent);
        border-radius: 2px;
    }

    .related-card {
        background: white;
        border-radius: var(--radius);
        border: 1px solid rgba(226,232,240,0.8);
        padding: 1.2rem;
        box-shadow: var(--shadow-card);
        margin-bottom: 1.25rem;
        transition: var(--transition);
        display: flex;
        gap: 12px;
        text-decoration: none;
    }

    .related-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(27,58,82,0.12);
        border-color: rgba(232,200,122,0.3);
    }

    .related-img {
        width: 80px;
        height: 70px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .related-placeholder {
        width: 80px;
        height: 70px;
        border-radius: 8px;
        background: var(--primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255,255,255,0.25);
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .related-info {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .related-meta {
        font-size: 0.72rem;
        color: #64748b;
        font-weight: 500;
    }

    .related-title {
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--primary);
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 0;
    }

    @media (max-width: 991px) {
        .article-hero-image { height: 300px; }
        .article-content-wrapper { padding: 1.75rem 1.5rem; }
    }

    @media (max-width: 575px) {
        .article-hero-image { height: 220px; }
    }
</style>
@endpush

{{-- Breadcrumb --}}
<div class="breadcrumb-wrapper">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom">
                <li class="breadcrumb-item"><a href="{{ route('landing.index') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('public.berita.index') }}">Berita</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($berita->title, 40) }}</li>
            </ol>
        </nav>
    </div>
</div>

{{-- Main Article --}}
<div class="container article-container">
    <div class="row g-4">
        {{-- Left: Article Detail --}}
        <div class="col-lg-8">
            <article class="article-card">
                {{-- Hero Image --}}
                <div class="article-hero-image">
                    @if($berita->is_featured)
                        <div class="article-badge-featured">
                            <i class="bi bi-star-fill me-1"></i> Unggulan
                        </div>
                    @endif

                    @if($berita->image)
                        <img src="{{ asset('storage/' . $berita->image) }}" alt="{{ $berita->title }}">
                    @else
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);">
                            <i class="bi bi-newspaper text-white opacity-25" style="font-size: 5rem;"></i>
                        </div>
                    @endif
                </div>

                {{-- Content --}}
                <div class="article-content-wrapper">
                    <div class="article-meta">
                        <span><i class="bi bi-calendar3"></i> {{ $berita->created_at->format('d F Y H:i') }}</span>
                        <span><i class="bi bi-eye"></i> {{ number_format($berita->views_count) }} Kali Dibaca</span>
                    </div>

                    <h1 class="article-title">{{ $berita->title }}</h1>

                    @if($berita->excerpt)
                        <div class="article-excerpt-callout">
                            {{ $berita->excerpt }}
                        </div>
                    @endif

                    <div class="article-body-content">
                        {!! $berita->content !!}
                    </div>

                    {{-- Share Section --}}
                    <div class="share-box">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-share-fill text-primary"></i>
                            <h6 class="share-title">Bagikan berita ini:</h6>
                        </div>
                        <button class="btn-share-copy" id="btnCopyLink" data-url="{{ request()->fullUrl() }}">
                            <i class="bi bi-link-45deg fs-5"></i> Salin Tautan
                        </button>
                    </div>
                </div>
            </article>
        </div>

        {{-- Right: Sidebar (Related News) --}}
        <div class="col-lg-4">
            <div class="ps-lg-3">
                <h4 class="sidebar-section-title">Berita Terbaru Lainnya</h4>
                
                @forelse($relatedBeritas as $related)
                    <a href="{{ route('public.berita.show', $related->slug) }}" class="related-card">
                        @if($related->image)
                            <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" class="related-img">
                        @else
                            <div class="related-placeholder">
                                <i class="bi bi-newspaper"></i>
                            </div>
                        @endif
                        
                        <div class="related-info">
                            <div class="related-meta">
                                <i class="bi bi-calendar3"></i> {{ $related->created_at->format('d M Y') }}
                            </div>
                            <h6 class="related-title">{{ $related->title }}</h6>
                        </div>
                    </a>
                @empty
                    <p class="text-muted small">Tidak ada berita terkait lainnya.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnCopy = document.getElementById('btnCopyLink');
    if (btnCopy) {
        btnCopy.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            
            navigator.clipboard.writeText(url).then(() => {
                const originalContent = this.innerHTML;
                this.innerHTML = '<i class="bi bi-check-lg fs-5"></i> Berhasil Disalin!';
                this.classList.remove('btn-share-copy');
                this.style.background = '#15803d';
                this.style.color = 'white';
                this.style.borderColor = '#15803d';
                
                if (window.showToast) {
                    window.showToast('Tautan berita berhasil disalin!', 'success');
                }
                
                setTimeout(() => {
                    this.innerHTML = originalContent;
                    this.style.background = '';
                    this.style.color = '';
                    this.style.borderColor = '';
                    this.classList.add('btn-share-copy');
                }, 2000);
            }).catch(err => {
                console.error('Gagal menyalin link:', err);
                if (window.showToast) {
                    window.showToast('Gagal menyalin tautan.', 'error');
                } else {
                    alert('Gagal menyalin tautan.');
                }
            });
        });
    }
});
</script>
@endpush
