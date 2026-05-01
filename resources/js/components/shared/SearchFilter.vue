<template>
  <div class="search-filter d-flex flex-wrap gap-2 mb-3">
    <div class="input-group" style="max-width: 300px;">
      <span class="input-group-text bg-white border-end-0 text-muted">
        <i class="bi bi-search"></i>
      </span>
      <input 
        type="text" 
        class="form-control border-start-0 ps-0" 
        :placeholder="placeholder" 
        v-model="searchQuery" 
        @input="onSearch"
      >
    </div>
    <slot name="filters"></slot>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
  placeholder: { type: String, default: 'Cari...' }
});

const emit = defineEmits(['search']);

const searchQuery = ref('');

const onSearch = () => {
  emit('search', searchQuery.value);
};
</script>

<style scoped>
.search-filter .form-control:focus {
  box-shadow: none;
  border-color: #dee2e6;
}
</style>
