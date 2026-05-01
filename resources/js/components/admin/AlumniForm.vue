<template>
  <div class="row g-4">
    <div class="col-lg-8">
      <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-primary text-white py-3">
          <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-fill me-2"></i> Edit Data Alumni</h5>
          <p class="small opacity-75 mb-0">Update informasi dasar identitas dan kontak</p>
        </div>
        <div class="card-body p-4">
          <form @submit.prevent="submitForm">
            <!-- IDENTITAS -->
            <div class="section-label d-flex align-items-center gap-2 mb-4">
              <i class="bi bi-person-badge-fill text-accent"></i>
              <span class="text-uppercase small fw-bold text-muted letter-spacing-1">Data Identitas</span>
              <div class="flex-grow-1 border-top opacity-25"></div>
            </div>

            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">NISN <span class="text-danger">*</span></label>
                <input v-model="form.nisn" type="text" class="form-control" :class="{'is-invalid': errors.nisn}" required>
                <div v-if="errors.nisn" class="invalid-feedback">{{ errors.nisn[0] }}</div>
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">NIPD</label>
                <input v-model="form.nipd" type="text" class="form-control" :class="{'is-invalid': errors.nipd}">
                <div v-if="errors.nipd" class="invalid-feedback">{{ errors.nipd[0] }}</div>
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">NAMA LENGKAP <span class="text-danger">*</span></label>
                <input v-model="form.nama_lengkap" type="text" class="form-control" :class="{'is-invalid': errors.nama_lengkap}" required>
                <div v-if="errors.nama_lengkap" class="invalid-feedback">{{ errors.nama_lengkap[0] }}</div>
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">NAMA PANGGILAN</label>
                <input v-model="form.nama_panggilan" type="text" class="form-control" :class="{'is-invalid': errors.nama_panggilan}">
                <div v-if="errors.nama_panggilan" class="invalid-feedback">{{ errors.nama_panggilan[0] }}</div>
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold text-muted d-block">JENIS KELAMIN</label>
                <div class="d-flex gap-4 mt-2">
                  <div class="form-check">
                    <input v-model="form.jenis_kelamin" class="form-check-input" type="radio" value="L" id="jkL">
                    <label class="form-check-label" for="jkL">Laki-laki</label>
                  </div>
                  <div class="form-check">
                    <input v-model="form.jenis_kelamin" class="form-check-input" type="radio" value="P" id="jkP">
                    <label class="form-check-label" for="jkP">Perempuan</label>
                  </div>
                </div>
                <div v-if="errors.jenis_kelamin" class="text-danger small mt-1">{{ errors.jenis_kelamin[0] }}</div>
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">ANGKATAN <span class="text-danger">*</span></label>
                <select v-model="form.angkatan_id" class="form-select" :class="{'is-invalid': errors.angkatan_id}" required>
                  <option value="">-- Pilih Angkatan --</option>
                  <option v-for="a in angkatans" :key="a.id" :value="a.id">
                    {{ a.nama_angkatan }} ({{ a.tahun_ajaran }})
                  </option>
                </select>
                <div v-if="errors.angkatan_id" class="invalid-feedback">{{ errors.angkatan_id[0] }}</div>
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">TAHUN LULUS <span class="text-danger">*</span></label>
                <input v-model="form.tahun_lulus" type="number" class="form-control" :class="{'is-invalid': errors.tahun_lulus}" required>
                <div v-if="errors.tahun_lulus" class="invalid-feedback">{{ errors.tahun_lulus[0] }}</div>
              </div>
            </div>

            <!-- KONTAK -->
            <div class="section-label d-flex align-items-center gap-2 mb-4">
              <i class="bi bi-telephone-fill text-accent"></i>
              <span class="text-uppercase small fw-bold text-muted letter-spacing-1">Data Kontak</span>
              <div class="flex-grow-1 border-top opacity-25"></div>
            </div>

            <div class="mb-4">
              <label class="form-label small fw-bold text-muted">ALAMAT</label>
              <textarea v-model="form.alamat" class="form-control" rows="3" :class="{'is-invalid': errors.alamat}"></textarea>
              <div v-if="errors.alamat" class="invalid-feedback">{{ errors.alamat[0] }}</div>
            </div>

            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">NO. HP / WA</label>
                <input v-model="form.no_hp" type="text" class="form-control" :class="{'is-invalid': errors.no_hp}">
                <div v-if="errors.no_hp" class="invalid-feedback">{{ errors.no_hp[0] }}</div>
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">EMAIL</label>
                <input v-model="form.email" type="email" class="form-control" :class="{'is-invalid': errors.email}">
                <div v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</div>
              </div>
            </div>

            <!-- PESAN -->
            <div class="section-label d-flex align-items-center gap-2 mb-4">
              <i class="bi bi-chat-left-text-fill text-accent"></i>
              <span class="text-uppercase small fw-bold text-muted letter-spacing-1">Harapan & Pesan</span>
              <div class="flex-grow-1 border-top opacity-25"></div>
            </div>

            <div class="mb-4">
              <label class="form-label small fw-bold text-muted">HARAPAN UNTUK SEKOLAH</label>
              <textarea v-model="form.harapan" class="form-control" rows="3" :class="{'is-invalid': errors.harapan}"></textarea>
              <div v-if="errors.harapan" class="invalid-feedback">{{ errors.harapan[0] }}</div>
            </div>

            <div class="border-top pt-4 d-flex justify-content-between">
              <a :href="backUrl" class="btn btn-light fw-bold px-4 rounded-3 border">
                <i class="bi bi-arrow-left me-1"></i> Kembali
              </a>
              <button type="submit" class="btn btn-primary fw-bold px-4 rounded-3 shadow-sm" :disabled="loading">
                <template v-if="loading">
                  <span class="spinner-border spinner-border-sm me-1"></span>
                  Memproses...
                </template>
                <template v-else>
                  <i class="bi bi-floppy-fill me-1"></i>
                  Simpan Perubahan
                </template>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-primary text-white py-3 fw-bold small">
          <i class="bi bi-info-circle-fill me-1"></i> RINGKASAN DATA
        </div>
        <div class="card-body p-4">
          <div class="d-flex flex-column gap-3">
            <div>
              <label class="small text-muted text-uppercase fw-bold d-block mb-1">Status Verifikasi</label>
              <span :class="['badge rounded-pill px-3 py-2', vClass]">{{ alumni.status_verifikasi }}</span>
            </div>
            <div>
              <label class="small text-muted text-uppercase fw-bold d-block mb-1">Kelengkapan Profil</label>
              <span :class="['badge rounded-pill px-3 py-2', cClass]">
                {{ alumni.is_profile_complete ? 'Lengkap' : 'Belum Lengkap' }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="alert alert-info border-0 rounded-4 p-4 shadow-sm">
        <div class="d-flex gap-3">
          <i class="bi bi-info-circle-fill fs-4"></i>
          <div>
            <h6 class="fw-bold mb-1">Catatan Admin</h6>
            <p class="small mb-0 opacity-75">
              Form ini hanya mengubah data dasar. Data pendidikan dan pekerjaan diatur sendiri oleh alumni melalui panel profil mereka untuk menjaga akurasi data riwayat.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  alumni: { type: Object, required: true },
  angkatans: { type: Array, required: true },
  actionUrl: { type: String, required: true },
  backUrl: { type: String, required: true }
});

const form = ref({
  nisn: props.alumni.nisn,
  nipd: props.alumni.nipd,
  nama_lengkap: props.alumni.nama_lengkap,
  nama_panggilan: props.alumni.nama_panggilan,
  jenis_kelamin: props.alumni.jenis_kelamin,
  angkatan_id: props.alumni.angkatan_id,
  tahun_lulus: props.alumni.tahun_lulus,
  alamat: props.alumni.alamat,
  no_hp: props.alumni.no_hp,
  email: props.alumni.email || props.alumni.user?.email,
  harapan: props.alumni.harapan
});

const errors = ref({});
const loading = ref(false);

const vClass = computed(() => {
  if (props.alumni.status_verifikasi === 'verified') return 'bg-success bg-opacity-10 text-success';
  if (props.alumni.status_verifikasi === 'pending') return 'bg-warning bg-opacity-10 text-warning';
  return 'bg-danger bg-opacity-10 text-danger';
});

const cClass = computed(() => {
  return props.alumni.is_profile_complete 
    ? 'bg-primary bg-opacity-10 text-primary' 
    : 'bg-secondary bg-opacity-10 text-secondary';
});

const submitForm = async () => {
  loading.value = true;
  errors.value = {};

  try {
    const response = await fetch(props.actionUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        ...form.value,
        _method: 'PUT'
      })
    });

    const data = await response.json();

    if (response.ok) {
      window.location.href = props.backUrl;
    } else {
      errors.value = data.errors || { message: [data.message] };
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
  } catch (err) {
    console.error(err);
    alert('Terjadi kesalahan koneksi.');
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
.form-control, .form-select {
  padding: 0.65rem 1rem;
  border-radius: 10px;
  border: 1.5px solid #e2e8f0;
  background-color: #f8fafc;
}
.form-control:focus, .form-select:focus {
  border-color: #1B3A52;
  box-shadow: 0 0 0 3px rgba(27,58,82,0.1);
  background-color: #fff;
}
.text-accent { color: #EAE0CF; }
.letter-spacing-1 { letter-spacing: 1px; }
</style>
