<script setup>
import { ref, defineAsyncComponent } from 'vue';

// Import các component cần thiết cho Admin
import LoginAdmin from './LoginAdmin.vue';
import AdminSidebar from './AdminSidebar.vue';
import AdminHeader from './AdminHeader.vue';

// Import các trang quản lý chính
const Dashboard = defineAsyncComponent(() => import('./Dashboard.vue')); 

// --- PROPS & EMITS ---
// Trong JS thuần, định nghĩa props bằng object và không cần 'as () => any'
const props = defineProps({
    portfolioData: { type: Object, required: true },
    isLoggedIn: { type: Boolean, required: true },
    userRole: { type: String, required: true },
    apiBaseUrl: { type: String, required: true },
});

// Trong JS thuần, định nghĩa emits bằng mảng các tên sự kiện
const emit = defineEmits([
    'loginSuccess', // Sự kiện này nhận đối số là 'role'
    'logout',
    'changeView',
    'dataUpdated',
]);

// --- TRẠNG THÁI NỘI BỘ (Quản lý chuyển trang Admin) ---
const adminCurrentView = ref('dashboard');

// Hàm chuyển trang nội bộ Admin
const changeAdminView = (view) => {
    adminCurrentView.value = view;
};

// Hàm xử lý việc cập nhật dữ liệu thành công từ component con (sẽ gọi lại API ở App.vue)
</script>

<template>
    <div class="admin-layout-wrapper d-flex">
        
        <template v-if="!props.isLoggedIn || props.userRole !== 'admin'">
            <LoginAdmin 
                :api-base-url="props.apiBaseUrl"
                @login-success="role => emit('loginSuccess', role)"
                @go-home="() => emit('changeView', 'Home')"
            />
        </template>
        
        <template v-else>
            <AdminSidebar 
                :current-view="adminCurrentView"
                @change-view="changeAdminView"
                @logout="() => emit('logout')"
                @go-home="() => emit('changeView', 'Home')"
            />
            
            <div class="admin-main-content flex-grow-1">
                <AdminHeader @logout="() => emit('logout')" :user-role="props.userRole" />

                <main class="admin-page-content p-4">
                    <Dashboard v-if="adminCurrentView === 'dashboard'" :data="portfolioData" />
                    
                    <div v-else class="alert alert-warning">Trang quản lý không tồn tại.</div>
                </main>
            </div>
        </template>

    </div>
</template>

<style scoped>
.admin-layout-wrapper {
    /* Style cơ bản cho layout */
    background-color: #f4f6f9;
    min-height: 100vh;
}
.admin-main-content {
    /* Đảm bảo nội dung chiếm hết không gian còn lại */
    overflow-y: auto;
}
</style>