{{-- ═══════════════════════════════════════════════
     PARTIAL: admin/alumni/partials/modals.blade.php
     Variables: $item (Alumni model)
════════════════════════════════════════════════ --}}

{{-- ── 1. MODAL DETAIL PROFIL ── --}}
<div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content alumni-modal">
            <div class="alumni-modal-header">
                <div class="alumni-modal-title">
                    <i class="bi bi-person-vcard-fill"></i> Detail Profil Alumni
                </div>
                <button type="button" class="alumni-modal-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="alumni-modal-body">
                <div class="row g-3">
                    <div class="col-6">
                        <span class="modal-field-label">Nama Lengkap</span>
                        <span class="modal-field-value">{{ $item->nama_lengkap }}</span>
                    </div>
                    <div class="col-6">
                        <span class="modal-field-label">NISN</span>
                        <span class="modal-field-value">
                            <span class="nisn-mono-sm">{{ $item->nisn }}</span>
                        </span>
                    </div>
                    <div class="col-6">
                        <span class="modal-field-label">Angkatan</span>
                        <span class="modal-field-value">
                            <span class="angkatan-tag-sm">{{ $item->angkatan->nama_angkatan ?? '-' }}</span>
                        </span>
                    </div>
                    <div class="col-6">
                        <span class="modal-field-label">Tahun Lulus</span>
                        <span class="modal-field-value">{{ $item->tahun_lulus ?? '-' }}</span>
                    </div>
                    <div class="col-6">
                        <span class="modal-field-label">Status Verifikasi</span>
                        <span class="modal-field-value">
                            @if($item->status_verifikasi === 'verified')
                                <span class="v-pill-sm v-verified-sm"><i class="bi bi-patch-check-fill"></i> Terverifikasi</span>
                            @elseif($item->status_verifikasi === 'pending')
                                <span class="v-pill-sm v-pending-sm"><i class="bi bi-hourglass-split"></i> Menunggu</span>
                            @else
                                <span class="v-pill-sm v-rejected-sm"><i class="bi bi-x-circle-fill"></i> Ditolak</span>
                            @endif
                        </span>
                    </div>
                    <div class="col-6">
                        <span class="modal-field-label">Kelengkapan Profil</span>
                        <span class="modal-field-value">
                            @if($item->is_profile_complete)
                                <span class="v-pill-sm v-complete-sm"><i class="bi bi-check-all"></i> Lengkap</span>
                            @else
                                <span class="v-pill-sm v-incomplete-sm"><i class="bi bi-exclamation-circle-fill"></i> Belum Lengkap</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            <div class="alumni-modal-footer">
                <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">Tutup</button>
                @if($item->status_verifikasi === 'pending')
                    <a href="{{ route('admin.alumni.show', $item) }}" class="btn-modal-primary">
                        <i class="bi bi-eye-fill"></i> Lihat Detail &amp; Verifikasi
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ── 2. MODAL RESET PASSWORD ── --}}
<div class="modal fade" id="modalReset{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content alumni-modal">
            <div class="alumni-modal-header alumni-modal-header-warning">
                <div class="alumni-modal-title">
                    <i class="bi bi-key-fill"></i> Reset Password
                </div>
                <button type="button" class="alumni-modal-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="alumni-modal-body" style="text-align:center;">
                <div class="modal-icon-circle modal-icon-warning">
                    <i class="bi bi-key-fill"></i>
                </div>
                <p class="modal-confirm-title">Reset password alumni ini?</p>
                <p class="modal-confirm-sub">{{ $item->nama_lengkap }}</p>

                <div class="modal-info-box">
                    <i class="bi bi-info-circle-fill"></i>
                    Password baru akan menjadi:
                    <span class="nisn-mono-sm" style="display:inline-block; margin-top:4px;">{{ $item->nisn }}</span>
                </div>

                <form action="{{ route('admin.alumni.resetPassword', $item) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="reset">
                    <div class="modal-btn-group">
                        <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-modal-warning"
                                onclick="return confirm('Yakin reset password ke NISN?')">
                            <i class="bi bi-check-circle-fill"></i> Ya, Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ── 3. MODAL HAPUS PERMANEN ── --}}
<div class="modal fade" id="modalDelete{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content alumni-modal">
            <div class="alumni-modal-header alumni-modal-header-danger">
                <div class="alumni-modal-title">
                    <i class="bi bi-exclamation-triangle-fill"></i> Hapus Data Alumni
                </div>
                <button type="button" class="alumni-modal-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="alumni-modal-body" style="text-align:center;">
                <div class="modal-icon-circle modal-icon-danger">
                    <i class="bi bi-trash3-fill"></i>
                </div>
                <p class="modal-confirm-title">Hapus data ini secara permanen?</p>
                <p class="modal-confirm-sub">{{ $item->nama_lengkap }}</p>

                <div class="modal-danger-box">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    Tindakan ini <strong>TIDAK DAPAT DIBATALKAN</strong>. Semua data terkait (pendidikan, pekerjaan, foto) akan dihapus.
                </div>

                <form action="{{ route('admin.alumni.destroy', $item) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-btn-group">
                        <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-modal-danger">
                            <i class="bi bi-trash3-fill"></i> Ya, Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ── SHARED MODAL STYLES (injected once per page via deduplication trick) ── --}}
@once
<style>
    :root {
        --primary:       #1B3A52;
        --primary-light: #2a5378;
        --accent:        #EAE0CF;
        --accent-soft:   rgba(232,200,122,0.12);
        --success:       #16a34a;
        --warning:       #d97706;
        --danger:        #e53e3e;
        --radius:        14px;
        --transition:    all 0.24s cubic-bezier(0.4,0,0.2,1);
    }

    /* ─── MODAL SHELL ─── */
    .alumni-modal {
        border: none;
        border-radius: var(--radius);
        box-shadow: 0 24px 60px rgba(0,0,0,0.18);
        overflow: hidden;
    }

    /* ─── MODAL HEADER ─── */
    .alumni-modal-header {
        background: var(--primary);
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
    }

    .alumni-modal-header::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: var(--accent);
    }

    .alumni-modal-header-warning { background: #92400e; }
    .alumni-modal-header-danger  { background: var(--danger); }

    .alumni-modal-title {
        display: flex;
        align-items: center;
        gap: 8px;
        color: white;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .alumni-modal-title i { opacity: 0.85; }

    .alumni-modal-close {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.18);
        color: rgba(255,255,255,0.75);
        width: 28px; height: 28px;
        border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.75rem;
        cursor: pointer;
        transition: var(--transition);
        line-height: 1;
    }

    .alumni-modal-close:hover { background: rgba(255,255,255,0.22); color: white; }

    /* ─── MODAL BODY ─── */
    .alumni-modal-body { padding: 1.4rem 1.5rem; }

    /* ─── FIELD ROWS (detail modal) ─── */
    .modal-field-label {
        display: block;
        font-size: 0.63rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.1px;
        color: #94a3b8;
        margin-bottom: 4px;
    }

    .modal-field-value {
        display: block;
        font-weight: 700;
        font-size: 0.875rem;
        color: var(--primary);
    }

    /* ─── CHIPS ─── */
    .nisn-mono-sm {
        font-family: 'Courier New', monospace;
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--primary);
        background: #f1f5f9;
        padding: 2px 8px;
        border-radius: 5px;
        display: inline-block;
    }

    .angkatan-tag-sm {
        display: inline-flex;
        align-items: center;
        padding: 0.18rem 0.6rem;
        background: var(--accent-soft);
        border: 1px solid rgba(232,200,122,0.28);
        border-radius: 5px;
        font-size: 0.75rem;
        font-weight: 700;
        color: #7a5c1e;
    }

    .v-pill-sm {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0.2rem 0.6rem;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 700;
    }

    .v-verified-sm  { background: rgba(22,163,74,0.1);  border: 1px solid rgba(22,163,74,0.22);  color: var(--success); }
    .v-pending-sm   { background: rgba(217,119,6,0.1);  border: 1px solid rgba(217,119,6,0.22);  color: var(--warning); }
    .v-rejected-sm  { background: rgba(229,62,62,0.1);  border: 1px solid rgba(229,62,62,0.22);  color: var(--danger); }
    .v-complete-sm  { background: var(--accent-soft);   border: 1px solid rgba(232,200,122,0.3);  color: #7a5c1e; }
    .v-incomplete-sm{ background: #f1f5f9;              border: 1px solid #e2e8f0;                color: #64748b; }

    /* ─── CONFIRM MODALS ─── */
    .modal-icon-circle {
        width: 64px; height: 64px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.6rem;
    }

    .modal-icon-warning { background: rgba(217,119,6,0.1);  color: var(--warning); }
    .modal-icon-danger  { background: rgba(229,62,62,0.1);  color: var(--danger); }

    .modal-confirm-title {
        font-weight: 800;
        color: var(--primary);
        font-size: 0.92rem;
        margin-bottom: 4px;
    }

    .modal-confirm-sub {
        color: #64748b;
        font-size: 0.85rem;
        margin-bottom: 1rem;
    }

    .modal-info-box {
        background: rgba(217,119,6,0.06);
        border: 1px solid rgba(217,119,6,0.18);
        border-radius: 9px;
        padding: 0.75rem 1rem;
        font-size: 0.81rem;
        color: #78350f;
        text-align: left;
        margin-bottom: 1.1rem;
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .modal-info-box i { color: var(--warning); }

    .modal-danger-box {
        background: #fef2f2;
        border: 1px solid rgba(229,62,62,0.18);
        border-radius: 9px;
        padding: 0.75rem 1rem;
        font-size: 0.81rem;
        color: #7f1d1d;
        text-align: left;
        margin-bottom: 1.1rem;
        display: flex;
        align-items: flex-start;
        gap: 7px;
        line-height: 1.5;
    }

    .modal-danger-box i { color: var(--danger); flex-shrink: 0; margin-top: 2px; }

    /* ─── MODAL BUTTONS ─── */
    .modal-btn-group {
        display: flex;
        gap: 0.6rem;
    }

    .btn-modal-secondary {
        flex: 1;
        padding: 0.6rem;
        background: #f1f5f9;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.85rem;
        color: #64748b;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-modal-secondary:hover { background: #e2e8f0; }

    .btn-modal-primary {
        flex: 1;
        padding: 0.6rem;
        background: var(--primary);
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.85rem;
        color: white;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        box-shadow: 0 4px 12px rgba(27,58,82,0.18);
    }

    .btn-modal-primary:hover { background: var(--primary-light); color: white; transform: translateY(-1px); }

    .btn-modal-warning {
        flex: 1;
        padding: 0.6rem;
        background: var(--warning);
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.85rem;
        color: white;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        box-shadow: 0 4px 12px rgba(217,119,6,0.25);
    }

    .btn-modal-warning:hover { background: #b45309; transform: translateY(-1px); }

    .btn-modal-danger {
        flex: 1;
        padding: 0.6rem;
        background: var(--danger);
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.85rem;
        color: white;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        box-shadow: 0 4px 12px rgba(229,62,62,0.28);
    }

    .btn-modal-danger:hover { background: #c53030; transform: translateY(-1px); }

    /* ─── MODAL FOOTER (detail modal) ─── */
    .alumni-modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid #f1f5f9;
        background: #fafbfc;
        display: flex;
        justify-content: flex-end;
        gap: 0.6rem;
    }
</style>
@endonce
