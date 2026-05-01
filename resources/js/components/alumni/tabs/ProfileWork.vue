<template>
  <div>
    <div v-if="form.jenjang_pendidikan_saat_ini === 'KERJA'">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h6 class="fw-bold text-muted text-uppercase mb-0">Data Pekerjaan Saat Ini</h6>
        <button v-if="form.pekerjaan.length < 1" type="button" @click="$emit('add-work')" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
          <i class="bi bi-plus-lg me-1"></i> Tambah
        </button>
      </div>

      <div v-if="form.pekerjaan.length === 0" class="empty-work p-5 text-center rounded-4 border-dashed mb-4">
        <i class="bi bi-briefcase fs-1 text-muted opacity-25 d-block mb-3"></i>
        <p class="text-muted small">Belum ada data pekerjaan. Tambahkan sekarang?</p>
      </div>

      <div v-for="(job, i) in form.pekerjaan" :key="i" class="job-card bg-light p-4 rounded-4 mb-3 border-start border-success border-4 position-relative">
        <button type="button" @click="$emit('remove-work', i)" class="btn-close position-absolute top-0 end-0 m-3 shadow-none"></button>
        
        <div class="row g-3 mt-1">
          <div class="col-md-12">
            <label class="form-label small fw-bold text-muted text-uppercase">Nama Perusahaan / Institusi</label>
            <input v-model="job.nama_perusahaan" class="form-control border-0 shadow-sm" placeholder="Contoh: PT. Teknologi Indonesia" required>
          </div>
          <div class="col-md-6">
            <label class="form-label small fw-bold text-muted text-uppercase">Jabatan / Posisi</label>
            <input v-model="job.jabatan" class="form-control border-0 shadow-sm" placeholder="Contoh: Manager Operasional" required>
          </div>
          <div class="col-md-6">
            <label class="form-label small fw-bold text-muted text-uppercase">Tahun Masuk</label>
            <input v-model="job.tahun_mulai" type="number" class="form-control border-0 shadow-sm" placeholder="Contoh: 2024" required>
          </div>
        </div>
      </div>
    </div>

    <div v-else class="text-center p-5 bg-light rounded-4">
      <i class="bi bi-briefcase fs-1 text-muted mb-3 d-block"></i>
      <p class="text-muted mb-0">Tab ini hanya aktif jika Anda memilih status <strong>Bekerja</strong> pada tab Data Dasar.</p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  form: { type: Object, required: true }
});

defineEmits(['add-work', 'remove-work']);
</script>

<style scoped>
.border-dashed { border: 2px dashed #e2e8f0; }
</style>
