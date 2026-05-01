<template>
  <div class="table-responsive bg-white rounded-3 shadow-sm border-0">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light text-secondary">
        <tr>
          <th v-for="(header, index) in headers" :key="index" :class="header.class" class="fw-semibold py-3 border-bottom">
            {{ header.label }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="loading">
          <td :colspan="headers.length" class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
            <div class="mt-2 text-muted small">Memuat data...</div>
          </td>
        </tr>
        <tr v-else-if="rows.length === 0">
          <td :colspan="headers.length" class="text-center py-5 text-muted">
            <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
            Data tidak ditemukan
          </td>
        </tr>
        <tr v-else v-for="(row, rowIndex) in rows" :key="rowIndex">
          <td v-for="(header, colIndex) in headers" :key="colIndex" :class="header.class" class="py-3">
            <slot :name="`cell-${header.key}`" :row="row">
              {{ row[header.key] }}
            </slot>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
defineProps({
  headers: { type: Array, required: true },
  rows: { type: Array, required: true },
  loading: { type: Boolean, default: false }
});
</script>
