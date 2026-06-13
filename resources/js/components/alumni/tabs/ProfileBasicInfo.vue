<template>
  <div>
    <div class="alert bg-light border-0 rounded-4 p-4 mb-4">
      <div class="row g-4 align-items-center">
        <div class="col-sm-4">
          <label class="label-muted text-uppercase mb-1">NISN</label>
          <div class="fw-bold fs-5">{{ alumni.nisn }}</div>
        </div>
        <div class="col-sm-4">
          <label class="label-muted text-uppercase mb-1">Angkatan</label>
          <div class="fw-bold fs-5 text-primary">{{ alumni.angkatan?.nama_angkatan || '-' }}</div>
        </div>
        <div class="col-sm-4">
          <label class="form-label fw-bold small text-muted text-uppercase mb-1">Status Saat Ini</label>
          <select v-model="form.jenjang_pendidikan_saat_ini" class="form-select border-0 bg-white rounded-3 shadow-sm">
            <option value="SD">Baru Lulus SD</option>
            <option value="SMP">Sedang/Lulus SMP</option>
            <option value="SMA">Sedang/Lulus SMA</option>
            <option value="KULIAH">Kuliah</option>
            <option value="KERJA">Bekerja</option>
          </select>
        </div>
      </div>
    </div>

    <div class="mb-4">
      <label class="form-label fw-bold small text-muted text-uppercase">Foto Profil</label>
      <div class="drop-zone p-4 rounded-4 text-center border-dashed position-relative">
        <input type="file" class="position-absolute inset-0 opacity-0 cursor-pointer" @change="$emit('update-preview', $event)" accept="image/*">
        <div v-if="!photoPreview" class="py-2">
          <i class="bi bi-cloud-arrow-up fs-1 text-primary opacity-50 mb-2 d-block"></i>
          <span class="text-muted small">Klik atau seret foto ke sini (Maks 2MB)</span>
        </div>
        <div v-else class="preview-wrap position-relative d-inline-block">
          <img :src="photoPreview" class="rounded-circle object-fit-cover shadow" style="width: 100px; height: 100px;">
          <div class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-1" style="cursor: pointer">
            <i class="bi bi-camera-fill small"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="mb-4">
      <label class="form-label fw-bold small text-muted text-uppercase">Alamat Lengkap <span class="text-danger">*</span></label>
      <textarea v-model="form.alamat" class="form-control rounded-4 bg-light border-0" rows="3" required placeholder="Jl. Raya No. 123, Kota..."></textarea>
    </div>

    <div class="row g-4 mb-5">
      <div class="col-md-6">
        <label class="form-label fw-bold small text-muted text-uppercase">Nomor WA <span class="text-danger">*</span></label>
        <div class="input-group">
          <span class="input-group-text bg-light border-0 rounded-start-4"><i class="bi bi-whatsapp text-success"></i></span>
          <input v-model="form.no_hp" type="text" class="form-control bg-light border-0 rounded-end-4" required placeholder="0812...">
        </div>
        <div class="form-check mt-2 ms-1">
          <input v-model="form.show_no_hp" class="form-check-input" type="checkbox" id="show_hp">
          <label class="form-check-label small text-muted" for="show_hp">Tampilkan di direktori publik</label>
        </div>
      </div>
      <div class="col-md-6">
        <label class="form-label fw-bold small text-muted text-uppercase">Email</label>
        <div class="input-group">
          <span class="input-group-text bg-light border-0 rounded-start-4"><i class="bi bi-envelope"></i></span>
          <input v-model="form.email" type="email" class="form-control bg-light border-0 rounded-end-4" placeholder="email@contoh.com">
        </div>
      </div>
    </div>

    <!-- KREDENSIAL LOGIN HILANGKAN -->
  </div>
</template>

<script setup>
defineProps({
  form: { type: Object, required: true },
  alumni: { type: Object, required: true },
  photoPreview: { type: String, default: null }
});

defineEmits(['update-preview']);
</script>

<style scoped>
.inset-0 { top: 0; left: 0; right: 0; bottom: 0; }
.cursor-pointer { cursor: pointer; }
.label-muted { font-size: 0.65rem; font-weight: 800; letter-spacing: 1px; color: #94a3b8; }
.border-dashed { border: 2px dashed #e2e8f0; }
</style>
