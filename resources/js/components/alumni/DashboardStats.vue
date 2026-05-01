<template>
  <div class="card-section mb-4">
    <div class="card-section-header">
      <i class="bi bi-shield-check me-2"></i> Status Akun
    </div>
    <div class="card-section-body p-4">
      <!-- Status Pills -->
      <div class="d-flex flex-wrap gap-4 mb-4">
        <div>
          <span class="status-sublabel d-block mb-1 text-muted fw-bold small text-uppercase" style="letter-spacing: 1px;">Verifikasi</span>
          <span v-if="alumni.status_verifikasi === 'verified'" class="status-pill pill-verified">
            <i class="bi bi-patch-check-fill me-1"></i> Terverifikasi
          </span>
          <span v-else-if="alumni.status_verifikasi === 'pending'" class="status-pill pill-pending">
            <i class="bi bi-clock-fill me-1"></i> Menunggu Verifikasi
          </span>
          <span v-else class="status-pill pill-rejected">
            <i class="bi bi-x-circle-fill me-1"></i> Ditolak
          </span>
        </div>
        <div>
          <span class="status-sublabel d-block mb-1 text-muted fw-bold small text-uppercase" style="letter-spacing: 1px;">Kelengkapan</span>
          <span v-if="isProfileComplete" class="status-pill pill-complete">
            <i class="bi bi-check-all me-1"></i> Data Lengkap
          </span>
          <span v-else class="status-pill pill-incomplete">
            <i class="bi bi-exclamation-triangle-fill me-1"></i> Belum Lengkap
          </span>
        </div>
      </div>

      <!-- Alert Info -->
      <div v-if="alumni.status_verifikasi === 'pending'" class="alert alert-info border-0 bg-info bg-opacity-10 text-info-emphasis d-flex align-items-start rounded-3 mb-3">
        <i class="bi bi-info-circle-fill me-2 mt-1"></i>
        <div><strong>Info:</strong> Akun Anda sedang ditinjau Admin. Silakan lengkapi biodata.</div>
      </div>

      <div v-if="!isProfileComplete" class="alert alert-warning border-0 bg-warning bg-opacity-10 text-warning-emphasis d-flex align-items-start rounded-3 mb-3">
        <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
        <div>
          <strong>Perhatian:</strong> Profil Anda belum lengkap.
          <a href="/alumni/profile/edit" class="alert-link text-decoration-none fw-bold ms-1">
            Lengkapi Sekarang <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>

      <!-- Progress Kelengkapan -->
      <div class="progress-wrap mt-4 pt-4 border-top">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <small class="fw-bold text-secondary">Kelengkapan Profil</small>
          <small class="fw-bold" :class="scoreColorClass">{{ score }}%</small>
        </div>
        <div class="progress" style="height: 8px; border-radius: 10px;">
          <div class="progress-bar" :class="scoreBgClass" role="progressbar" :style="`width: ${score}%`" :aria-valuenow="score" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <p class="mt-2 mb-0 fw-medium small" :class="scoreColorClass">{{ scoreMessage }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  dataProp: { type: Object, required: true }
});

const alumni = computed(() => props.dataProp || {});

const isProfileComplete = computed(() => {
  return score.value >= 100;
});

const score = computed(() => {
  let s = 0;
  if (alumni.value.alamat) s += 10;
  if (alumni.value.no_hp) s += 10;
  if (alumni.value.email || (alumni.value.user && alumni.value.user.email)) s += 10;
  if (alumni.value.harapan) s += 10;
  
  // Foto
  if (alumni.value.fotos && alumni.value.fotos.some(f => f.is_main)) s += 15;
  
  // Pendidikan
  if (alumni.value.pendidikan && alumni.value.pendidikan.length > 0) s += 30;
  
  // Pekerjaan
  if (alumni.value.pekerjaan && alumni.value.pekerjaan.length > 0) s += 15;
  
  return Math.min(s, 100);
});

const scoreColorClass = computed(() => {
  if (score.value >= 80) return 'text-success';
  if (score.value >= 50) return 'text-warning';
  return 'text-danger';
});

const scoreBgClass = computed(() => {
  if (score.value >= 80) return 'bg-success';
  if (score.value >= 50) return 'bg-warning';
  return 'bg-danger';
});

const scoreMessage = computed(() => {
  if (score.value >= 80) return '🎉 Profil Anda sudah sangat lengkap!';
  if (score.value >= 50) return '💪 Hampir lengkap! Tambahkan beberapa data lagi.';
  return '📝 Profil belum lengkap. Segera lengkapi data Anda.';
});
</script>

<style scoped>
.card-section {
  background: white;
  border-radius: 14px;
  border: 1px solid rgba(226,232,240,0.8);
  box-shadow: 0 2px 0 rgba(255,255,255,0.8) inset, 0 6px 24px rgba(27,58,82,0.08);
  overflow: hidden;
}

.card-section-header {
  background: var(--color-primary, #1B3A52);
  padding: 0.95rem 1.5rem;
  display: flex;
  align-items: center;
  color: white;
  font-weight: 700;
  font-size: 0.83rem;
  letter-spacing: 0.3px;
  position: relative;
}

.card-section-header::before {
  content: '';
  position: absolute;
  left: 0; top: 0; bottom: 0;
  width: 3px;
  background: #EAE0CF;
}

.status-pill {
  display: inline-flex;
  align-items: center;
  padding: 0.35rem 1rem;
  border-radius: 50px;
  font-weight: 700;
  font-size: 0.78rem;
}

.pill-verified { background: rgba(22,163,74,0.1); border: 1px solid rgba(22,163,74,0.22); color: #16a34a; }
.pill-pending { background: rgba(217,119,6,0.1); border: 1px solid rgba(217,119,6,0.22); color: #d97706; }
.pill-rejected { background: rgba(229,62,62,0.1); border: 1px solid rgba(229,62,62,0.2); color: #e53e3e; }
.pill-complete { background: rgba(232,200,122,0.12); border: 1px solid rgba(232,200,122,0.3); color: #7a5c1e; }
.pill-incomplete { background: rgba(217,119,6,0.1); border: 1px solid rgba(217,119,6,0.2); color: #d97706; }
</style>
