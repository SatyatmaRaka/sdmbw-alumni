<template>
  <div class="activity-logs-container">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
      <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
        <div>
          <h5 class="mb-0 fw-bold d-flex align-items-center">
            <i class="bi bi-shield-check text-primary me-2"></i>
            Log Aktivitas Sistem
          </h5>
          <p class="text-muted small mb-0 mt-1">Riwayat aksi yang dilakukan oleh seluruh pengguna</p>
        </div>
        <div class="d-flex gap-2">
          <button @click="clearLogs" class="btn btn-outline-danger rounded-pill px-4 btn-sm fw-bold">
            <i class="bi bi-trash3 me-1"></i> Bersihkan Log
          </button>
        </div>
      </div>

      <div class="card-body p-0">
        <!-- Filter Bar -->
        <div class="bg-light p-3 px-4 border-top border-bottom d-flex gap-3 align-items-center">
          <div class="search-wrap flex-grow-1">
            <div class="input-group input-group-sm">
              <span class="input-group-text bg-white border-0 rounded-start-pill"><i class="bi bi-search text-muted"></i></span>
              <input v-model="search" type="text" class="form-control border-0 rounded-end-pill" placeholder="Cari aktivitas, user, atau deskripsi...">
            </div>
          </div>
          <div class="filter-type">
            <select v-model="filterAction" class="form-select form-select-sm rounded-pill border-0 shadow-sm">
              <option value="">Semua Aktivitas</option>
              <option v-for="(label, action) in actions" :key="action" :value="action">
                {{ label }}
              </option>
            </select>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table align-middle mb-0 custom-table">
            <thead class="text-muted small text-uppercase fw-bold letter-spacing-1">
              <tr>
                <th class="ps-4 py-3">Waktu</th>
                <th class="py-3">Pengguna</th>
                <th class="py-3">Aktivitas</th>
                <th class="py-3">Target</th>
                <th class="pe-4 py-3 text-end">Detail</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="log in filteredLogs" :key="log.id" class="fade-in">
                <td class="ps-4 py-3">
                  <div class="fw-bold">{{ formatTime(log.created_at) }}</div>
                  <div class="small text-muted">{{ formatDate(log.created_at) }}</div>
                </td>
                <td class="py-3">
                  <div class="d-flex align-items-center gap-2">
                    <div class="avatar-xs rounded-circle bg-light d-flex align-items-center justify-content-center fw-bold small">
                      {{ log.admin?.username?.charAt(0).toUpperCase() || 'S' }}
                    </div>
                    <div>
                      <div class="fw-bold small">{{ log.admin?.username || 'System' }}</div>
                      <div class="text-muted" style="font-size: 0.65rem;">{{ log.admin?.role || 'Service' }}</div>
                    </div>
                  </div>
                </td>
                <td class="py-3">
                  <div class="d-flex align-items-center gap-2">
                    <span :class="['badge-type rounded-circle', getLogTypeClass(log.action)]"></span>
                    <span class="small fw-semibold" v-html="log.description"></span>
                  </div>
                </td>
                <td class="py-3">
                  <div class="small text-muted">{{ log.target_type || '-' }}</div>
                  <div class="fw-bold small">ID: {{ log.target_id || '-' }}</div>
                </td>
                <td class="pe-4 py-3 text-end">
                  <button @click="showDetail(log)" class="btn btn-light btn-sm rounded-pill px-3 fs-xs fw-bold">
                    Lihat
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      
      <!-- Pagination -->
      <div v-if="initialLogs.last_page > 1" class="card-footer bg-white border-top py-3">
        <div class="d-flex justify-content-between align-items-center">
          <div class="small text-muted">
            Menampilkan {{ initialLogs.from }} sampai {{ initialLogs.to }} dari {{ initialLogs.total }} aktivitas
          </div>
          <Pagination 
            :current-page="initialLogs.current_page" 
            :total-pages="initialLogs.last_page" 
            @page-change="handlePageChange"
          />
        </div>
      </div>
    </div>

    <!-- DETAIL MODAL -->
    <div v-if="selectedLog" class="custom-modal-overlay d-flex align-items-center justify-content-center p-3">
      <div class="custom-modal-content glass-card p-4 rounded-4 shadow-lg w-100" style="max-width: 500px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h5 class="fw-bold mb-0">Detail Aktivitas</h5>
          <button @click="selectedLog = null" class="btn-close"></button>
        </div>
        <div class="log-detail-body">
          <div class="mb-4">
            <label class="label-muted text-uppercase mb-1">Deskripsi Lengkap</label>
            <div class="p-3 bg-light rounded-3 border fw-semibold" v-html="selectedLog.description"></div>
          </div>
          <div class="row g-3">
            <div class="col-6">
              <label class="label-muted text-uppercase mb-1">Target Model</label>
              <div class="small fw-bold text-primary">{{ selectedLog.target_type || '-' }}</div>
            </div>
            <div class="col-6">
              <label class="label-muted text-uppercase mb-1">Target ID</label>
              <div class="small fw-bold">{{ selectedLog.target_id || '-' }}</div>
            </div>
            <div class="col-12">
              <label class="label-muted text-uppercase mb-1">Waktu Kejadian</label>
              <div class="small text-muted">
                <i class="bi bi-clock me-1"></i> {{ formatDate(selectedLog.created_at) }} - {{ formatTime(selectedLog.created_at) }}
              </div>
            </div>
          </div>
        </div>
        <div class="mt-4 text-end">
          <button @click="selectedLog = null" class="btn btn-primary rounded-pill px-4">Tutup</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import Pagination from '../shared/Pagination.vue';

const props = defineProps({
  initialLogs: { type: Object, required: true },
  actions: { type: Object, required: true },
  clearUrl: { type: String, required: true }
});

const search = ref('');
const filterAction = ref('');
const selectedLog = ref(null);

const filteredLogs = computed(() => {
  const logsArray = props.initialLogs?.data || [];
  return logsArray.filter(log => {
    const searchLower = (search.value || '').toLowerCase();
    const matchesSearch = (log.description || '').toLowerCase().includes(searchLower) || 
                          (log.admin?.username || '').toLowerCase().includes(searchLower);
    const matchesAction = !filterAction.value || log.action === filterAction.value;
    return matchesSearch && matchesAction;
  });
});

const getLogTypeClass = (action) => {
  if (!action) return 'bg-secondary';
  const a = action.toLowerCase();
  if (a.includes('delete')) return 'bg-danger';
  if (a.includes('update') || a.includes('edit')) return 'bg-warning';
  if (a.includes('verify') || a.includes('import')) return 'bg-success';
  if (a.includes('reset') || a.includes('password')) return 'bg-info';
  return 'bg-primary';
};

const formatDate = (dateStr) => new Date(dateStr).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
const formatTime = (dateStr) => new Date(dateStr).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

const showDetail = (log) => { selectedLog.value = log; };

const handlePageChange = (page) => {
  const url = new URL(window.location.href);
  url.searchParams.set('page', page);
  window.location.href = url.toString();
};

const clearLogs = () => {
  if(confirm('Hapus semua riwayat aktivitas?')) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = props.clearUrl;
    
    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    form.appendChild(csrf);

    const method = document.createElement('input');
    method.type = 'hidden';
    method.name = '_method';
    method.value = 'DELETE';
    form.appendChild(method);

    document.body.appendChild(form);
    form.submit();
  }
};

const emit = defineEmits(['clear']);
</script>

<style scoped>
.letter-spacing-1 { letter-spacing: 1px; }
.fs-xs { font-size: 0.7rem; }

.custom-table thead th { border-bottom: none; }
.custom-table tbody tr { transition: all 0.2s ease; cursor: default; }
.custom-table tbody tr:hover { background: #f8fafc; }

.badge-type { width: 8px; height: 8px; display: inline-block; }
.avatar-xs { width: 32px; height: 32px; }

.label-muted { font-size: 0.65rem; font-weight: 800; letter-spacing: 1px; color: #94a3b8; }

.custom-modal-overlay {
  position: fixed; top: 0; left: 0; width: 100%; height: 100%;
  background: rgba(17, 37, 52, 0.4); backdrop-filter: blur(4px); z-index: 2000;
}

.fade-in { animation: fadeIn 0.4s ease-out forwards; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
</style>
