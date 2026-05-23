@extends('layouts.landing')

@section('title', 'Buat Thread Baru - Forum Alumni')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('forum.index') }}" class="text-decoration-none" style="color: var(--color-primary);">Forum</a></li>
            <li class="breadcrumb-item active" aria-current="page">Buat Thread Baru</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0" style="border-radius: var(--radius-md);">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h3 class="fw-bold mb-0" style="color: var(--color-primary-dark);">Buat Thread Baru</h3>
                    <p class="text-muted small mt-1">Mulai diskusi dengan menuliskan topik yang menarik.</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('forum.thread.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="forum_id" class="form-label fw-bold">Kategori Forum <span class="text-danger">*</span></label>
                            <select name="forum_id" id="forum_id" class="form-select @error('forum_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($forums as $forum)
                                    <option value="{{ $forum->id }}" {{ request('forum_id') == $forum->id || old('forum_id') == $forum->id ? 'selected' : '' }}>
                                        {{ $forum->icon }} {{ $forum->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('forum_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">Judul Topik <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Contoh: Tips mencari kerja di bidang IT" required maxlength="255">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="body" class="form-label fw-bold">Isi Topik <span class="text-danger">*</span></label>
                            <textarea name="body" id="body" rows="8" class="form-control @error('body') is-invalid @enderror" placeholder="Tuliskan detail topik diskusi di sini..." required minlength="10">{{ old('body') }}</textarea>
                            @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text mt-2 text-muted">Gunakan bahasa yang sopan dan saling menghargai.</div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                            <a href="{{ route('forum.index') }}" class="btn btn-light fw-medium">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold" style="background: var(--color-primary); border-color: var(--color-primary);">
                                <i class="bi bi-send-fill me-1"></i> Posting Thread
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
