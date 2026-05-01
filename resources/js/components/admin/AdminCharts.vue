<template>
  <div class="row g-3 mt-1">
    <!-- Chart 1: Distribution of Current Education/Work -->
    <div class="col-lg-6">
      <div class="card-section p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <div class="d-flex align-items-center gap-2">
            <div class="icon-box-sm bg-primary-subtle text-primary rounded-2">
              <i class="bi bi-pie-chart-fill"></i>
            </div>
            <h6 class="fw-bold mb-0">Distribusi Status Alumni</h6>
          </div>
        </div>
        <div class="chart-container" style="position: relative; height:300px; width:100%">
          <Pie :data="pieData" :options="pieOptions" />
        </div>
      </div>
    </div>

    <!-- Chart 2: Alumni Growth by Angkatan -->
    <div class="col-lg-6">
      <div class="card-section p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <div class="d-flex align-items-center gap-2">
            <div class="icon-box-sm bg-success-subtle text-success rounded-2">
              <i class="bi bi-graph-up-arrow"></i>
            </div>
            <h6 class="fw-bold mb-0">Pertumbuhan Alumni per Angkatan</h6>
          </div>
        </div>
        <div class="chart-container" style="position: relative; height:300px; width:100%">
          <Bar :data="barData" :options="barOptions" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { 
  Chart as ChartJS, 
  ArcElement, 
  Tooltip, 
  Legend, 
  CategoryScale, 
  LinearScale, 
  BarElement, 
  Title 
} from 'chart.js';
import { Pie, Bar } from 'vue-chartjs';

ChartJS.register(ArcElement, Tooltip, Legend, CategoryScale, LinearScale, BarElement, Title);

const props = defineProps({
  stats: { type: Object, required: true },
  angkatanData: { type: Array, required: true }
});

// Pie Chart Data: Distribution of jenjang_pendidikan_saat_ini
const pieData = computed(() => {
  const dist = props.stats.status_distribution || {};
  const labels = Object.keys(dist);
  const data = Object.values(dist);

  return {
    labels: labels,
    datasets: [{
      backgroundColor: ['#1B3A52', '#0891b2', '#16a34a', '#d97706', '#e53e3e', '#64748b'],
      data: data,
      borderWidth: 0,
      hoverOffset: 15
    }]
  };
});

const pieOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      position: 'right',
      labels: {
        usePointStyle: true,
        padding: 20,
        font: { size: 12, weight: '600' }
      }
    }
  }
};

// Bar Chart Data: Alumni count per Angkatan
const barData = computed(() => {
  return {
    labels: props.angkatanData.map(a => a.nama_angkatan),
    datasets: [{
      label: 'Jumlah Alumni',
      backgroundColor: '#1B3A52',
      borderRadius: 6,
      data: props.angkatanData.map(a => a.alumni_count)
    }]
  };
});

const barOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: { display: false }
  },
  scales: {
    y: {
      beginAtZero: true,
      grid: { display: false }
    },
    x: {
      grid: { display: false }
    }
  }
};
</script>

<style scoped>
.card-section {
  background: white;
  border-radius: 14px;
  border: 1px solid rgba(226,232,240,0.8);
  box-shadow: 0 2px 0 rgba(255,255,255,0.8) inset, 0 6px 24px rgba(27,58,82,0.08);
}
.icon-box-sm {
  width: 32px; height: 32px;
  display: flex; align-items: center; justify-content: center;
}
.bg-primary-subtle { background: rgba(27, 58, 82, 0.1); }
.bg-success-subtle { background: rgba(22, 163, 74, 0.1); }
</style>
