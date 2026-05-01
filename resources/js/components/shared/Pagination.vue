<template>
  <nav v-if="totalPages > 1" class="mt-4">
    <ul class="pagination justify-content-center mb-0">
      <li class="page-item" :class="{ disabled: currentPage === 1 }">
        <button class="page-link shadow-sm" @click="changePage(currentPage - 1)">
          <i class="bi bi-chevron-left"></i>
        </button>
      </li>
      <li 
        v-for="page in pages" 
        :key="page" 
        class="page-item" 
        :class="{ active: page === currentPage }"
      >
        <button class="page-link shadow-sm" @click="changePage(page)">{{ page }}</button>
      </li>
      <li class="page-item" :class="{ disabled: currentPage === totalPages }">
        <button class="page-link shadow-sm" @click="changePage(currentPage + 1)">
          <i class="bi bi-chevron-right"></i>
        </button>
      </li>
    </ul>
  </nav>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  currentPage: { type: Number, required: true },
  totalPages: { type: Number, required: true }
});

const emit = defineEmits(['page-change']);

const pages = computed(() => {
  const p = [];
  for (let i = 1; i <= props.totalPages; i++) {
    p.push(i);
  }
  return p;
});

const changePage = (page) => {
  if (page >= 1 && page <= props.totalPages && page !== props.currentPage) {
    emit('page-change', page);
  }
};
</script>

<style scoped>
.page-link {
  color: var(--color-primary, #1B3A52);
  border: none;
  margin: 0 4px;
  border-radius: 8px !important;
  font-weight: 500;
  transition: all 0.2s ease;
}

.page-link:hover {
  background-color: var(--color-accent, #EAE0CF);
  color: var(--color-primary, #1B3A52);
}

.page-item.active .page-link {
  background-color: var(--color-primary, #1B3A52);
  color: #fff;
  box-shadow: 0 4px 12px rgba(27, 58, 82, 0.2) !important;
}

.page-item.disabled .page-link {
  background-color: #f8f9fa;
  color: #adb5bd;
  box-shadow: none !important;
}
</style>
