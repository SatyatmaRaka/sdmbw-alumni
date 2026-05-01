<template>
  <div class="row g-4">
    <!-- SISI KIRI: FORM UTAMA -->
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-4 border-0 px-4">
          <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
              <div class="icon-box-premium bg-primary text-white me-3">
                <i class="bi bi-pencil-square"></i>
              </div>
              <div>
                <h5 class="mb-0 fw-bold text-dark">Lengkapi Profil Anda</h5>
                <p class="text-muted small mb-0">Informasi ini membantu kami memvalidasi keaslian data Anda</p>
              </div>
            </div>
            <div class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
              <i class="bi bi-check-circle-fill me-1"></i> Data Terlindungi
            </div>
          </div>
        </div>

        <div class="card-body p-4 pt-0">
          <form @submit.prevent="submitProfile">
            <!-- TAB NAVIGATION -->
            <ul class="nav nav-tabs-premium mb-5" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#basic-info">Data Dasar</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#education">Pendidikan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#work">Pekerjaan</a>
              </li>
            </ul>

            <div class="tab-content">
              <!-- TAB 1: BASIC INFO -->
              <div class="tab-pane fade show active" id="basic-info">
                <ProfileBasicInfo 
                  :form="form" 
                  :alumni="alumni" 
                  :photoPreview="photoPreview" 
                  @update-preview="previewImage" 
                />
              </div>

              <!-- TAB 2: EDUCATION -->
              <div class="tab-pane fade" id="education">
                <ProfileEducation :form="form" />
              </div>

              <!-- TAB 3: WORK -->
              <div class="tab-pane fade" id="work">
                <ProfileWork 
                  :form="form" 
                  @add-work="addWork" 
                  @remove-work="removeWork" 
                />
              </div>
            </div>

            <div class="mb-5 mt-5">
              <label class="form-label fw-bold small text-muted text-uppercase">Pesan & Harapan Untuk Sekolah</label>
              <textarea v-model="form.harapan" class="form-control rounded-4 border-0 bg-light" rows="4" placeholder="Tuliskan kesan atau harapan Anda untuk almamater..."></textarea>
            </div>

            <div class="d-flex gap-3 mt-4 pt-4 border-top">
              <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill fw-bold shadow-sm" :disabled="isSubmitting">
                <template v-if="isSubmitting">
                  <span class="spinner-border spinner-border-sm me-2"></span>
                  Menyimpan...
                </template>
                <template v-else>
                  <i class="bi bi-cloud-check-fill me-2"></i> Simpan Perubahan Profil
                </template>
              </button>
              <a href="/alumni/dashboard" class="btn btn-light px-5 py-3 rounded-pill fw-bold">Batal</a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- SISI KANAN: KEAMANAN & INFO -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm rounded-4 text-center p-5 mb-4 position-relative overflow-hidden">
        <div class="cta-mesh position-absolute inset-0 opacity-10"></div>
        <div class="position-relative z-1">
          <div class="avatar-container mx-auto mb-4 border border-5 border-white shadow-lg">
            <img :src="photoPreview || defaultAvatar" class="w-100 h-100 object-fit-cover" @error="handleImageError">
          </div>
          <h5 class="fw-bold mb-1">{{ alumni.nama_lengkap }}</h5>
          <p class="text-muted small">Status: <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">{{ alumni.status_verifikasi }}</span></p>
        </div>
      </div>

      <div class="card border-0 shadow-sm rounded-4 p-4">
        <div class="d-flex align-items-center mb-4">
          <div class="icon-box-sm bg-warning text-white me-2"><i class="bi bi-shield-lock"></i></div>
          <h6 class="fw-bold mb-0">Keamanan Akun</h6>
        </div>
        <form @submit.prevent="submitPassword">
          <div class="mb-3">
            <input v-model="passwordForm.current_password" type="password" class="form-control" placeholder="Password Saat Ini" required>
          </div>
          <div class="mb-3">
            <input v-model="passwordForm.password" type="password" class="form-control" placeholder="Password Baru" required>
          </div>
          <div class="mb-4">
            <input v-model="passwordForm.password_confirmation" type="password" class="form-control" placeholder="Konfirmasi Password Baru" required>
          </div>
          <button type="submit" class="btn btn-warning w-100 fw-bold text-white py-3 rounded-4 shadow-sm" :disabled="isUpdatingPassword">
            <template v-if="isUpdatingPassword">
              <span class="spinner-border spinner-border-sm me-2"></span>
              Updating...
            </template>
            <template v-else>
              Ganti Password Sekarang
            </template>
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import ProfileBasicInfo from './tabs/ProfileBasicInfo.vue';
import ProfileEducation from './tabs/ProfileEducation.vue';
import ProfileWork from './tabs/ProfileWork.vue';

const props = defineProps({
  alumni: { type: Object, required: true },
  actionUrl: { type: String, required: true },
  passwordUrl: { type: String, required: true }
});

const defaultAvatar = `data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='140' height='140'%3E%3Crect width='140' height='140' fill='%23667eea'/%3E%3Ctext x='50%25' y='50%25' dominant-baseline='middle' text-anchor='middle' font-family='Arial' font-size='60' fill='white'%3E${props.alumni.nama_lengkap?.charAt(0).toUpperCase()}%3C/text%3E%3C/svg%3E`;

const photoPreview = ref(null);
const isSubmitting = ref(false);
const isUpdatingPassword = ref(false);

const form = reactive({
  foto: null,
  alamat: props.alumni.alamat || '',
  no_hp: props.alumni.no_hp || '',
  show_no_hp: !!props.alumni.show_no_hp,
  email: props.alumni.email || props.alumni.user?.email || '',
  harapan: props.alumni.harapan || '',
  pendidikan: [
    { jenjang: 'SD', nama_instansi: '', tahun_masuk: '', tahun_lulus: '', is_ongoing: false },
    { jenjang: 'SMP', nama_instansi: '', tahun_masuk: '', tahun_lulus: '', is_ongoing: false },
    { jenjang: 'SMA', nama_instansi: '', tahun_masuk: '', tahun_lulus: '', is_ongoing: false },
    { jenjang: 'Perguruan Tinggi', nama_instansi: '', tahun_masuk: '', tahun_lulus: '', is_ongoing: false, fakultas: '', program_studi: '' }
  ],
  pekerjaan: [],
  username: props.alumni.user?.username || '',
  password: '',
  password_confirmation: '',
  jenjang_pendidikan_saat_ini: props.alumni.jenjang_pendidikan_saat_ini || 'SD'
});

const passwordForm = reactive({
  current_password: '',
  password: '',
  password_confirmation: ''
});

onMounted(() => {
  if (props.alumni.pendidikan?.length > 0) {
    const jenjangs = ['SD', 'SMP', 'SMA', 'Perguruan Tinggi'];
    jenjangs.forEach((jenjang, idx) => {
      const edu = props.alumni.pendidikan.find(e => e.jenjang === jenjang);
      if (edu) {
        form.pendidikan[idx] = { 
          ...edu, 
          is_ongoing: !!edu.is_ongoing,
          fakultas: edu.fakultas || '',
          program_studi: edu.program_studi || ''
        };
      }
    });
  }

  if (props.alumni.pekerjaan?.length > 0) {
    form.pekerjaan = props.alumni.pekerjaan.map(p => ({ 
      ...p, 
      is_current: !!p.is_current,
      nama_perusahaan: p.nama_perusahaan || '',
      tahun_mulai: p.tahun_mulai || ''
    }));
  } else {
    form.pekerjaan = [{ nama_perusahaan: '', jabatan: '', tahun_mulai: '', is_current: false }];
  }

  const fotoUtama = props.alumni.fotos?.find(f => f.is_main);
  if (fotoUtama) photoPreview.value = `/storage/${fotoUtama.path_file}`;
});

const previewImage = (e) => {
  const file = e.target.files[0];
  if (!file) return;
  form.foto = file;
  const reader = new FileReader();
  reader.onload = (e) => photoPreview.value = e.target.result;
  reader.readAsDataURL(file);
};

const addWork = () => { form.pekerjaan.push({ nama_perusahaan: '', jabatan: '', tahun_mulai: '', is_current: false }); };

const removeWork = (index) => {
  form.pekerjaan.splice(index, 1);
};

const submitProfile = async () => {
  isSubmitting.value = true;
  const formData = new FormData();
  formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
  formData.append('_method', 'PUT');
  formData.append('alamat', form.alamat);
  formData.append('no_hp', form.no_hp);
  formData.append('show_no_hp', form.show_no_hp ? '1' : '0');
  formData.append('email', form.email);
  formData.append('harapan', form.harapan);
  if (form.foto) formData.append('foto', form.foto);
  if (form.username) formData.append('username', form.username);
  if (form.password) {
    formData.append('password', form.password);
    formData.append('password_confirmation', form.password_confirmation);
  }
  formData.append('jenjang_pendidikan_saat_ini', form.jenjang_pendidikan_saat_ini);

  form.pendidikan.forEach((edu, i) => {
    if (edu.nama_instansi) {
      formData.append(`pendidikan[${i}][jenjang]`, edu.jenjang);
      formData.append(`pendidikan[${i}][nama_instansi]`, edu.nama_instansi);
      formData.append(`pendidikan[${i}][tahun_masuk]`, edu.tahun_masuk);
      formData.append(`pendidikan[${i}][tahun_lulus]`, edu.tahun_lulus);
      formData.append(`pendidikan[${i}][is_ongoing]`, edu.is_ongoing ? '1' : '0');
      formData.append(`pendidikan[${i}][fakultas]`, edu.fakultas || '');
      formData.append(`pendidikan[${i}][program_studi]`, edu.program_studi || '');
    }
  });

  form.pekerjaan.forEach((job, i) => {
    if (job.nama_perusahaan) {
      formData.append(`pekerjaan[${i}][nama_perusahaan]`, job.nama_perusahaan);
      formData.append(`pekerjaan[${i}][jabatan]`, job.jabatan);
      formData.append(`pekerjaan[${i}][tahun_mulai]`, job.tahun_mulai);
      formData.append(`pekerjaan[${i}][is_current]`, job.is_current ? '1' : '0');
    }
  });

  try {
    const res = await fetch(props.actionUrl, { 
        method: 'POST', 
        body: formData, 
        headers: { 
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        } 
    });
    
    if (res.redirected) { window.location.href = res.url; return; }
    
    const data = await res.json();
    
    if (!res.ok) {
        isSubmitting.value = false;
        if (res.status === 422) {
            let errorMsg = 'Terdapat kesalahan pengisian data:\n\n';
            for (const key in data.errors) {
                errorMsg += `- ${data.errors[key][0]}\n`;
            }
            alert(errorMsg);
            return;
        } else {
            alert(data.message || 'Terjadi kesalahan pada server.');
            return;
        }
    }
    
    if (data.redirect) window.location.href = data.redirect;
    else window.location.reload();
  } catch (err) { 
    isSubmitting.value = false;
    alert('Gagal menghubungi server. Silakan periksa koneksi Anda.');
  }
};

const submitPassword = async () => {
  isUpdatingPassword.value = true;
  const formData = new FormData();
  formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
  formData.append('_method', 'PUT');
  formData.append('current_password', passwordForm.current_password);
  formData.append('password', passwordForm.password);
  formData.append('password_confirmation', passwordForm.password_confirmation);

  try {
    const res = await fetch(props.passwordUrl, { 
        method: 'POST', 
        body: formData, 
        headers: { 
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        } 
    });
    
    if (res.redirected) { window.location.href = res.url; return; }
    
    const data = await res.json();
    
    if (!res.ok) {
        isUpdatingPassword.value = false;
        if (res.status === 422) {
            let errorMsg = 'Terdapat kesalahan:\n\n';
            for (const key in data.errors) {
                errorMsg += `- ${data.errors[key][0]}\n`;
            }
            alert(errorMsg);
            return;
        } else {
            alert(data.message || 'Terjadi kesalahan pada server.');
            return;
        }
    }
    
    if (data.redirect) window.location.href = data.redirect;
    else window.location.reload();
  } catch (err) { 
    isUpdatingPassword.value = false;
    alert('Gagal menghubungi server.');
  }
};

const handleImageError = (e) => { e.target.src = defaultAvatar; };
</script>

<style scoped>
.inset-0 { top: 0; left: 0; right: 0; bottom: 0; }
.z-1 { z-index: 1; }
.cursor-pointer { cursor: pointer; }

.icon-box-premium { width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; }
.icon-box-sm { width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; }

.nav-tabs-premium { border-bottom: 2px solid #f1f5f9; gap: 2rem; }
.nav-tabs-premium .nav-link { border: none; padding: 0.75rem 0; color: #64748b; font-weight: 700; position: relative; }
.nav-tabs-premium .nav-link.active { color: #1B3A52; background: transparent; }
.nav-tabs-premium .nav-link.active::after { content: ''; position: absolute; bottom: -2px; left: 0; width: 100%; height: 3px; background: #1B3A52; border-radius: 3px; }

.label-muted { font-size: 0.65rem; font-weight: 800; letter-spacing: 1px; color: #94a3b8; }
.border-dashed { border: 2px dashed #e2e8f0; }

.avatar-container { width: 150px; height: 150px; border-radius: 50%; overflow: hidden; background: #f8fafc; }
.cta-mesh { background: radial-gradient(circle at 70% 30%, rgba(232, 200, 122, 0.4), transparent 70%); }
</style>
