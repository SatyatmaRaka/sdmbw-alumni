<template>
  <div class="row g-4 mb-4">
    <div class="col-12 col-md-6 col-xl-3" v-for="(stat, index) in statsList" :key="index">
      <div class="card border-0 shadow-sm rounded-4 stat-card-modern h-100 position-relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="stat-bg-pattern position-absolute top-0 end-0 opacity-10">
          <i :class="['bi', stat.icon]" style="font-size: 8rem; margin-right: -2rem; margin-top: -1rem;"></i>
        </div>

        <div class="card-body p-4 position-relative z-1">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div :class="['icon-box rounded-3', stat.iconBg]">
              <i :class="['bi fs-4', stat.icon, stat.iconColor]"></i>
            </div>
            <div class="flex-grow-1">
              <h6 class="text-muted fw-bold mb-0 text-uppercase small letter-spacing-1">{{ stat.label }}</h6>
            </div>
          </div>
          
          <div class="d-flex align-items-end justify-content-between">
            <div>
              <h2 class="fw-800 mb-1 text-dark">{{ stat.value }}</h2>
              <div class="d-flex align-items-center gap-2">
                <span :class="['badge rounded-pill px-2 py-1', stat.trendColor]" style="font-size: 0.65rem;">
                  <i :class="['bi', stat.trendIcon, 'me-1']"></i>{{ stat.trendText }}
                </span>
                <span class="text-muted" style="font-size: 0.7rem;">vs bulan lalu</span>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Bottom Bar -->
        <div class="stat-progress-bar position-absolute bottom-0 start-0 w-100" style="height: 4px;" :class="stat.progressBg"></div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  dataProp: { type: Object, required: true }
});

const statsList = computed(() => {
  return [
    {
      label: 'Total Alumni',
      value: props.dataProp.total_alumni || 0,
      icon: 'bi-people-fill',
      iconColor: 'text-primary',
      iconBg: 'bg-primary-subtle',
      progressBg: 'bg-primary',
      trendIcon: 'bi-arrow-up-short',
      trendText: '+12%',
      trendColor: 'bg-success-subtle text-success'
    },
    {
      label: 'Total Angkatan',
      value: props.dataProp.total_angkatan || 0,
      icon: 'bi-mortarboard-fill',
      iconColor: 'text-warning',
      iconBg: 'bg-warning-subtle',
      progressBg: 'bg-warning',
      trendIcon: 'bi-check-circle',
      trendText: 'Aktif/Lulus',
      trendColor: 'bg-warning-subtle text-warning'
    },
    {
      label: 'Profil Lengkap',
      value: props.dataProp.profil_lengkap || 0,
      icon: 'bi-person-check-fill',
      iconColor: 'text-success',
      iconBg: 'bg-success-subtle',
      progressBg: 'bg-success',
      trendIcon: 'bi-check-all',
      trendText: 'Selesai',
      trendColor: 'bg-success-subtle text-success'
    },
    {
      label: 'Profil Belum Lengkap',
      value: props.dataProp.profil_belum_lengkap || 0,
      icon: 'bi-person-exclamation',
      iconColor: 'text-danger',
      iconBg: 'bg-danger-subtle',
      progressBg: 'bg-danger',
      trendIcon: 'bi-exclamation-triangle',
      trendText: 'Perlu Update',
      trendColor: 'bg-danger-subtle text-danger'
    }
  ];
});
</script>

<style scoped>
.fw-800 { font-weight: 800; }
.letter-spacing-1 { letter-spacing: 1px; }
.z-1 { z-index: 1; }

.stat-card-modern {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.stat-card-modern:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 40px rgba(17, 37, 52, 0.12) !important;
}

.icon-box {
  width: 48px; height: 48px;
  display: flex; align-items: center; justify-content: center;
}

.bg-primary-subtle { background: rgba(27, 58, 82, 0.1); }
.bg-success-subtle { background: rgba(25, 135, 84, 0.1); }
.bg-warning-subtle { background: rgba(255, 193, 7, 0.1); }
.bg-info-subtle { background: rgba(13, 202, 240, 0.1); }
.bg-danger-subtle { background: rgba(220, 53, 69, 0.1); }

.bg-primary { background: #1B3A52 !important; }
.text-primary { color: #1B3A52 !important; }

.stat-bg-pattern {
  pointer-events: none;
  transition: all 0.5s ease;
}
.stat-card-modern:hover .stat-bg-pattern {
  transform: scale(1.1) rotate(-5deg);
  opacity: 0.15 !important;
}
</style>
