<template>
  <div class="angkatan-table-container">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
      <div class="card-header bg-white border-0 py-4 px-4 border-bottom">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4">
          
          <div class="d-flex align-items-center">
            <div class="bg-warning bg-opacity-10 text-warning rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
               <i class="bi bi-mortarboard-fill fs-5"></i>
            </div>
            <div>
              <h5 class="mb-1 fw-bold text-dark letter-spacing-1">Data Angkatan</h5>
              <p class="mb-0 text-muted small">Total <span class="fw-bold text-dark">{{ paginationInfo?.total || 0 }}</span> angkatan terdaftar</p>
            </div>
          </div>
          
          <div class="d-flex flex-wrap align-items-center gap-3">
            <!-- Search Box -->
            <div class="search-box position-relative" style="min-width: 250px;">
              <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
              <input 
                v-model="search" 
                type="text" 
                class="form-control ps-5 py-2 rounded-pill border-0 bg-light focus-ring-warning shadow-none" 
                placeholder="Cari angkatan..."
                @keyup.enter="handleSearch"
              >
            </div>
            
            <a :href="createUrl" class="btn btn-warning-premium rounded-pill px-4 py-2 fw-bold d-flex align-items-center shadow-sm">
              <i class="bi bi-plus-lg me-2"></i> Tambah Angkatan
            </a>
          </div>
          
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 custom-table">
          <thead class="bg-light-subtle">
            <tr>
              <th class="ps-4 py-3 text-muted small text-uppercase fw-bold letter-spacing-1">Nama Angkatan</th>
              <th class="py-3 text-muted small text-uppercase fw-bold letter-spacing-1">Tahun Ajaran</th>
              <th class="py-3 text-muted small text-uppercase fw-bold letter-spacing-1 text-center">Jumlah Alumni</th>
              <th class="py-3 text-muted small text-uppercase fw-bold letter-spacing-1 text-center">Status</th>
              <th class="pe-4 py-3 text-muted small text-uppercase fw-bold letter-spacing-1 text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="dataProp.length === 0">
              <td colspan="5" class="text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted opacity-25"></i>
                <p class="text-muted mt-2">Data angkatan tidak ditemukan</p>
              </td>
            </tr>
            <tr v-for="row in dataProp" :key="row.id">
              <td class="ps-4 py-3">
                <div class="d-flex align-items-center gap-3">
                  <div class="avatar-sm-premium rounded-circle bg-warning-subtle text-warning fw-bold">
                    {{ row.nama_angkatan.match(/\d+/) ? row.nama_angkatan.match(/\d+/)[0] : 'A' }}
                  </div>
                  <div class="fw-bold text-dark">{{ row.nama_angkatan }}</div>
                </div>
              </td>
              <td class="py-3">
                <span class="badge bg-light text-dark border px-3 py-1 rounded-pill small">
                   <i class="bi bi-calendar3 me-1 text-muted"></i> {{ row.tahun_ajaran }}
                </span>
              </td>
              <td class="py-3 text-center">
                <div class="fw-bold text-primary">{{ row.alumni_count || 0 }}</div>
                <div class="small text-muted">Alumni</div>
              </td>
              <td class="py-3 text-center">
                <span :class="['badge rounded-pill px-3 py-1 small fw-bold', row.status === 'LULUS' ? 'bg-success-subtle text-success' : 'bg-primary-subtle text-primary']">
                  <i :class="['bi me-1', row.status === 'LULUS' ? 'bi-check-circle-fill' : 'bi-clock-fill']"></i>
                  {{ row.status }}
                </span>
              </td>
              <td class="pe-4 py-3 text-end">
                <div class="d-flex gap-2 justify-content-end">
                  <a :href="`/admin/angkatan/${row.id}/edit`" class="btn btn-outline-warning btn-sm rounded-pill px-3 shadow-sm">
                    <i class="bi bi-pencil-square me-1"></i> Edit
                  </a>
                  <button @click="confirmDelete(row)" class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm">
                    <i class="bi bi-trash-fill me-1"></i> Hapus
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="card-footer bg-white border-top py-4 px-4 d-flex justify-content-between align-items-center flex-wrap">
        <div v-if="paginationInfo" class="small text-muted mb-2 mb-md-0">
          Menampilkan <strong>{{ paginationInfo.from || 0 }}</strong> - <strong>{{ paginationInfo.to || 0 }}</strong> dari <strong>{{ paginationInfo.total }}</strong> data
        </div>
        <slot name="pagination"></slot>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
  dataProp: { type: Array, required: true },
  paginationInfo: { type: Object, default: null },
  createUrl: { type: String, default: '/admin/angkatan/create' },
  searchProp: { type: String, default: '' }
});

const search = ref(props.searchProp);

const handleSearch = () => {
  const url = new URL(window.location.href);
  if (search.value) url.searchParams.set('search', search.value);
  else url.searchParams.delete('search');
  url.searchParams.delete('page');
  window.location.href = url.toString();
};

const confirmDelete = (row) => {
  if (row.alumni_count > 0) {
    alert(`Tidak dapat menghapus "${row.nama_angkatan}" karena masih memiliki ${row.alumni_count} alumni yang terdaftar.`);
    return;
  }

  if (confirm(`Apakah Anda yakin ingin menghapus data ${row.nama_angkatan}? Tindakan ini tidak dapat dikembalikan.`)) {
    executeDelete(row.id);
  }
};

const executeDelete = (id) => {
  const form = document.createElement('form');
  form.method = 'POST';
  form.action = `/admin/angkatan/${id}`;
  
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
};
</script>

<style scoped>
.letter-spacing-1 { letter-spacing: 1px; }

.custom-table thead th {
  border-top: none;
  background-color: #f8fafc;
}

.custom-table tbody tr {
  transition: all 0.2s ease;
}
.custom-table tbody tr:hover {
  background-color: rgba(248, 250, 252, 0.8);
}

.avatar-sm-premium {
  width: 40px; height: 40px;
  display: flex; align-items: center; justify-content: center;
  font-size: 0.9rem;
}

.bg-warning-subtle { background: rgba(255, 193, 7, 0.1); }
.bg-success-subtle { background: rgba(25, 135, 84, 0.1); }
.bg-primary-subtle { background: rgba(27, 58, 82, 0.1); }

.btn-warning-premium {
  background: #ffc107;
  color: #000;
  border: none;
  transition: all 0.3s ease;
}
.btn-warning-premium:hover {
  background: #e0a800;
  transform: translateY(-2px);
  box-shadow: 0 8px 15px rgba(255, 193, 7, 0.2);
}

.focus-ring-warning:focus {
  border-color: #ffc107 !important;
  box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.1) !important;
  outline: none;
}

.text-primary { color: #1B3A52 !important; }
</style>
