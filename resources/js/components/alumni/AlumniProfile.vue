<template>
  <div class="row g-4">
    <!-- SIDEBAR -->
    <div class="col-lg-4">
      <div class="profile-sidebar-card shadow-sm border-0">
        <div class="profile-sidebar-bg">
          <div class="profile-sidebar-stripe"></div>
        </div>
        <div class="profile-sidebar-content">
          <div class="profile-avatar shadow">
            <img v-if="fotoUtama" :src="`/storage/${fotoUtama.path_file}`" :alt="alumni.nama_lengkap">
            <span v-else class="avatar-initial">{{ alumni.nama_lengkap?.charAt(0).toUpperCase() }}</span>
          </div>
          <h4 class="profile-name">{{ alumni.nama_lengkap }}</h4>
          <span class="pill-angkatan">
            <i class="bi bi-mortarboard-fill me-1"></i>
            {{ alumni.angkatan?.nama_angkatan || 'Alumni' }}
          </span>
        </div>
      </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="col-lg-8">
      <div class="card-section mb-4">
        <div class="card-section-header">
          <i class="bi bi-person-vcard-fill me-2"></i> Informasi Lengkap
        </div>
        <div class="card-section-body p-4">
          <div class="info-grid">
            <div class="info-item">
              <span class="info-label">Nama Lengkap</span>
              <p class="info-value">{{ alumni.nama_lengkap }}</p>
            </div>
            <div class="info-item">
              <span class="info-label">Angkatan</span>
              <p class="info-value">{{ alumni.angkatan?.nama_angkatan || '-' }}</p>
            </div>
            <div class="info-item">
              <span class="info-label">Tahun Ajaran</span>
              <p class="info-value">{{ alumni.angkatan?.tahun_ajaran || '-' }}</p>
            </div>
            <div class="info-item">
              <span class="info-label">Status Kelulusan</span>
              <p class="info-value">
                <span :class="['status-tag', alumni.angkatan?.status === 'LULUS' ? 'tag-success' : 'tag-warn']">
                  <i :class="['bi', alumni.angkatan?.status === 'LULUS' ? 'bi-check-circle-fill' : 'bi-hourglass-split', 'me-1']"></i>
                  {{ alumni.angkatan?.status || '-' }}
                </span>
              </p>
            </div>
          </div>

          <!-- KONTAK -->
          <div class="kontak-section mt-4 pt-3 border-top">
            <span class="kontak-sublabel text-muted fw-bold small text-uppercase mb-3 d-block">Kontak</span>
            <div class="d-flex flex-wrap gap-2">
              <a v-if="displayEmail" :href="`mailto:${displayEmail}`" class="kontak-link kontak-email">
                <i class="bi bi-envelope-at me-1"></i> {{ displayEmail }}
              </a>
              <a v-if="showWa" :href="`https://wa.me/${waNumber}`" target="_blank" class="kontak-link kontak-wa">
                <i class="bi bi-whatsapp me-1"></i> {{ formattedPhone }}
              </a>
              <span v-if="!displayEmail && !showWa" class="kontak-empty text-muted fst-italic">Informasi kontak tidak tersedia.</span>
            </div>
          </div>
        </div>
      </div>

      <!-- PENDIDIKAN -->
      <div v-if="alumni.pendidikan?.length" class="card-section mb-4">
        <div class="card-section-header">
          <i class="bi bi-mortarboard-fill me-2"></i> Pendidikan Lanjutan
        </div>
        <div class="card-section-body p-4">
          <div v-for="edu in alumni.pendidikan" :key="edu.id" class="timeline-item p-3 mb-2 rounded-3 border">
            <div class="d-flex gap-3">
              <div class="timeline-icon icon-edu bg-light p-2 rounded text-primary">
                <i class="bi bi-mortarboard-fill"></i>
              </div>
              <div class="timeline-content">
                <h6 class="fw-bold mb-1">{{ edu.nama_instansi }}</h6>
                <p class="text-muted small mb-2">{{ edu.jenjang }}</p>
                <span v-if="edu.is_ongoing" class="tag tag-ongoing bg-info bg-opacity-10 text-info px-2 py-1 rounded small">
                  <i class="bi bi-hourglass-split me-1"></i> Masih Belajar (Aktif)
                </span>
                <span v-else class="tag tag-done bg-success bg-opacity-10 text-success px-2 py-1 rounded small">
                  <i class="bi bi-check-circle me-1"></i> Lulus {{ edu.tahun_lulus || '-' }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- PEKERJAAN -->
      <div v-if="alumni.pekerjaan?.length" class="card-section mb-4">
        <div class="card-section-header">
          <i class="bi bi-briefcase-fill me-2"></i> Riwayat Pekerjaan
        </div>
        <div class="card-section-body p-4">
          <div v-for="job in alumni.pekerjaan" :key="job.id" class="timeline-item p-3 mb-2 rounded-3 border">
            <div class="d-flex gap-3">
              <div class="timeline-icon icon-work bg-light p-2 rounded text-success">
                <i class="bi bi-briefcase-fill"></i>
              </div>
              <div class="timeline-content">
                <h6 class="fw-bold mb-1">{{ job.nama_perusahaan }}</h6>
                <p class="text-muted small mb-2">{{ job.jabatan }}</p>
                <span class="tag tag-work bg-success bg-opacity-10 text-success px-2 py-1 rounded small">
                  <i class="bi bi-circle-fill me-1" style="font-size:0.4rem;"></i> Aktif
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- HARAPAN -->
      <div v-if="alumni.harapan" class="harapan-card bg-dark text-light p-4 rounded-4 shadow-sm position-relative overflow-hidden">
        <div class="harapan-card-header text-uppercase small fw-bold text-accent mb-2">
          <i class="bi bi-chat-left-quote-fill me-1"></i> Harapan & Pesan
        </div>
        <div class="harapan-card-body position-relative z-1">
          <span class="quote-mark text-accent opacity-25" style="font-size: 4rem; line-height: 0; position: absolute; left: -10px; top: 20px;">"</span>
          <p class="harapan-text fst-italic lh-lg mb-0 ps-4">{{ alumni.harapan }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  alumni: { type: Object, required: true }
});

const fotoUtama = computed(() => props.alumni.fotos?.find(f => f.is_main));

const displayEmail = computed(() => props.alumni.email || props.alumni.user?.username);
const showWa = computed(() => props.alumni.show_no_hp && props.alumni.no_hp);
const waNumber = computed(() => props.alumni.no_hp?.replace(/[^0-9]/g, ''));
const formattedPhone = computed(() => props.alumni.no_hp); // Could use a helper here if available

</script>

<style scoped>
.profile-sidebar-card { background: white; text-align: center; overflow: hidden; border-radius: 14px; }
.profile-sidebar-bg { height: 70px; background: #112534; position: relative; }
.profile-sidebar-stripe { position: absolute; bottom: 0; left: 0; right: 0; height: 2px; background: linear-gradient(to right, #EAE0CF, transparent); }
.profile-sidebar-content { padding: 0 1.5rem 1.75rem; }
.profile-avatar {
  width: 110px; height: 110px; border-radius: 28px; border: 4px solid white;
  margin: -55px auto 1.1rem; background: #1B3A52; display: flex; align-items: center; justify-content: center;
}
.profile-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 24px; }
.avatar-initial { font-size: 2.5rem; font-weight: 800; color: rgba(255,255,255,0.2); }
.profile-name { font-weight: 700; color: #1B3A52; margin-bottom: 0.65rem; }
.pill-angkatan { background: #1B3A52; color: white; padding: 0.3rem 0.9rem; border-radius: 50px; font-size: 0.8rem; font-weight: 700; }

.card-section { background: white; border-radius: 14px; border: 1px solid rgba(226,232,240,0.8); overflow: hidden; }
.card-section-header { background: #1B3A52; padding: 0.9rem 1.5rem; color: white; font-weight: 700; font-size: 0.85rem; border-left: 3px solid #EAE0CF; }

.info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.info-item { background: #fafbfc; padding: 1rem; border-radius: 10px; border: 1px solid #f1f5f9; }
.info-label { display: block; font-size: 0.65rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.4rem; }
.info-value { font-size: 0.9rem; font-weight: 700; color: #1B3A52; margin: 0; }

.status-tag { display: inline-flex; align-items: center; padding: 0.2rem 0.7rem; border-radius: 6px; font-size: 0.75rem; font-weight: 700; }
.tag-success { background: rgba(22,163,74,0.1); color: #16a34a; }
.tag-warn { background: rgba(217,119,6,0.1); color: #d97706; }

.kontak-link {
  display: inline-flex; align-items: center; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; text-decoration: none;
}
.kontak-email { background: #f8fafc; border: 1px solid #e2e8f0; color: #1B3A52; }
.kontak-wa { background: rgba(22,163,74,0.05); border: 1px solid rgba(22,163,74,0.2); color: #16a34a; }

.text-accent { color: #EAE0CF; }
.harapan-card::before {
  content: ''; position: absolute; inset: 0; background-image: radial-gradient(rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 20px 20px;
}
</style>
