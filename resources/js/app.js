import './bootstrap';
import { createApp, defineAsyncComponent } from 'vue';

const app = createApp({});

// Register Shared Components (Lazy Loaded)
app.component('search-filter', defineAsyncComponent(() => import('./components/shared/SearchFilter.vue')));
app.component('data-table', defineAsyncComponent(() => import('./components/shared/DataTable.vue')));
app.component('status-badge', defineAsyncComponent(() => import('./components/shared/StatusBadge.vue')));
app.component('confirm-modal', defineAsyncComponent(() => import('./components/shared/ConfirmModal.vue')));
app.component('pagination', defineAsyncComponent(() => import('./components/shared/Pagination.vue')));

// Register Alumni Components (Lazy Loaded)
app.component('dashboard-stats', defineAsyncComponent(() => import('./components/alumni/DashboardStats.vue')));
app.component('alumni-profile', defineAsyncComponent(() => import('./components/alumni/AlumniProfile.vue')));
app.component('profile-form', defineAsyncComponent(() => import('./components/alumni/ProfileForm.vue')));

// Register Admin Components (Lazy Loaded)
app.component('admin-stats', defineAsyncComponent(() => import('./components/admin/AdminStats.vue')));
app.component('alumni-table', defineAsyncComponent(() => import('./components/admin/AlumniTable.vue')));
app.component('angkatan-table', defineAsyncComponent(() => import('./components/admin/AngkatanTable.vue')));
app.component('admin-alumni-detail', defineAsyncComponent(() => import('./components/admin/AlumniDetail.vue')));
app.component('admin-alumni-form', defineAsyncComponent(() => import('./components/admin/AlumniForm.vue')));
app.component('laporan-dashboard', defineAsyncComponent(() => import('./components/admin/LaporanDashboard.vue')));
app.component('admin-activity-logs', defineAsyncComponent(() => import('./components/admin/ActivityLogs.vue')));
app.component('admin-charts', defineAsyncComponent(() => import('./components/admin/AdminCharts.vue')));

// Register Landing & Auth Components (Lazy Loaded)
app.component('landing-page', defineAsyncComponent(() => import('./components/landing/LandingPage.vue')));
app.component('login-form', defineAsyncComponent(() => import('./components/auth/LoginForm.vue')));

// Mount Vue application if #app exists
if (document.getElementById('app')) {
    app.mount('#app');
}
