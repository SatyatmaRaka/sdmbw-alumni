<template>
  <span :class="['badge rounded-pill fw-medium px-3 py-2', badgeClass]">
    <i v-if="icon" :class="['bi me-1', icon]"></i>
    {{ statusLabel }}
  </span>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  status: { type: String, required: true }
});

const badgeClass = computed(() => {
  const map = {
    'verified': 'bg-success-subtle text-success border border-success-subtle',
    'pending': 'bg-warning-subtle text-warning border border-warning-subtle',
    'rejected': 'bg-danger-subtle text-danger border border-danger-subtle'
  };
  return map[props.status.toLowerCase()] || 'bg-secondary-subtle text-secondary';
});

const statusLabel = computed(() => {
  const map = {
    'verified': 'Verified',
    'pending': 'Pending',
    'rejected': 'Rejected'
  };
  return map[props.status.toLowerCase()] || props.status;
});

const icon = computed(() => {
  const map = {
    'verified': 'bi-check-circle',
    'pending': 'bi-clock',
    'rejected': 'bi-x-circle'
  };
  return map[props.status.toLowerCase()] || 'bi-info-circle';
});
</script>
