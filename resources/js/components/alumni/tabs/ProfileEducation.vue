<template>
  <div>
    <div v-for="edu in filteredPendidikan" :key="edu.jenjang" class="edu-card bg-light p-4 rounded-4 mb-4 position-relative border-start border-primary border-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0 text-primary">{{ edu.jenjang }}</h6>
        <div class="form-check form-switch">
          <input v-model="edu.is_ongoing" class="form-check-input" type="checkbox" :id="'on-'+edu.jenjang">
          <label class="form-check-label small text-muted" :for="'on-'+edu.jenjang">Masih Belajar</label>
        </div>
      </div>
      <div class="row g-3">
        <div class="col-md-12">
          <label class="form-label small fw-bold text-muted text-uppercase">Nama Instansi</label>
          <input v-model="edu.nama_instansi" class="form-control border-0 shadow-sm" :placeholder="edu.jenjang === 'SD' ? 'Contoh: SD Muhammadiyah Birrul Walidain' : edu.jenjang === 'SMP' ? 'Contoh: SMP Negeri 1 Kudus' : edu.jenjang === 'SMA' ? 'Contoh: SMA Negeri 1 Kudus' : 'Contoh: Universitas Diponegoro'">
        </div>
        <div class="col-md-6">
          <label class="form-label small fw-bold text-muted text-uppercase">Tahun Masuk</label>
          <input v-model="edu.tahun_masuk" type="number" class="form-control border-0 shadow-sm" placeholder="Contoh: 2020">
        </div>
        <div class="col-md-6">
          <label class="form-label small fw-bold text-muted text-uppercase">{{ edu.is_ongoing ? 'Estimasi Lulus' : 'Tahun Lulus' }}</label>
          <input v-model="edu.tahun_lulus" type="number" class="form-control border-0 shadow-sm" placeholder="Contoh: 2023">
        </div>
        
        <template v-if="edu.jenjang === 'Perguruan Tinggi'">
          <div class="col-md-6">
            <label class="form-label small fw-bold text-muted text-uppercase">Fakultas</label>
            <input v-model="edu.fakultas" class="form-control border-0 shadow-sm" placeholder="Contoh: Teknik">
          </div>
          <div class="col-md-6">
            <label class="form-label small fw-bold text-muted text-uppercase">Program Studi</label>
            <input v-model="edu.program_studi" class="form-control border-0 shadow-sm" placeholder="Contoh: Sistem Informasi">
          </div>
        </template>
      </div>
    </div>

    <div v-if="filteredPendidikan.length === 0" class="text-center p-5 bg-light rounded-4">
      <i class="bi bi-mortarboard fs-1 text-muted mb-3 d-block"></i>
      <p class="text-muted mb-0">Silakan pilih status pendidikan Anda di tab Data Dasar.</p>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  form: { type: Object, required: true }
});

const filteredPendidikan = computed(() => {
  const current = props.form.jenjang_pendidikan_saat_ini;
  const list = props.form.pendidikan || [];
  
  // Logic:
  // SD: show SD
  // SMP: show SD, SMP
  // SMA: show SD, SMP, SMA
  // KULIAH: show SD, SMP, SMA, PT
  // KERJA: show SD, SMP, SMA
  
  return list.filter(edu => {
    if (edu.jenjang === 'SD') return true;
    if (edu.jenjang === 'SMP' && ['SMP', 'SMA', 'KULIAH', 'KERJA'].includes(current)) return true;
    if (edu.jenjang === 'SMA' && ['SMA', 'KULIAH', 'KERJA'].includes(current)) return true;
    if (edu.jenjang === 'Perguruan Tinggi' && current === 'KULIAH') return true;
    return false;
  });
});
</script>
