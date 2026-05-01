<template>
  <div v-if="show" class="modal fade show d-block" tabindex="-1" style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="modal-header border-bottom-0 bg-light py-3">
          <h5 class="modal-title fw-bold text-danger">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ title }}
          </h5>
          <button type="button" class="btn-close" @click="onCancel"></button>
        </div>
        <div class="modal-body py-4 px-4 text-center">
          <p class="mb-0 text-secondary fs-5">{{ message }}</p>
        </div>
        <div class="modal-footer border-top-0 d-flex justify-content-center bg-light">
          <button type="button" class="btn btn-secondary px-4 rounded-3" @click="onCancel">Batal</button>
          <button type="button" class="btn btn-danger px-4 rounded-3" @click="onConfirm">
            Ya, Lanjutkan
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  show: { type: Boolean, default: false },
  title: { type: String, default: 'Konfirmasi' },
  message: { type: String, default: 'Apakah Anda yakin ingin melanjutkan aksi ini?' }
});

const emit = defineEmits(['confirm', 'cancel']);

const onConfirm = () => emit('confirm');
const onCancel = () => emit('cancel');
</script>
