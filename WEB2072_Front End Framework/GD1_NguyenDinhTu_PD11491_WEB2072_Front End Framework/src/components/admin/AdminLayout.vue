<script setup>
import { inject, watchEffect, provide } from 'vue';
import { useRouter } from 'vue-router';
// Import Header/Sidebar riêng cho Admin
import AdminHeader from './AdminHeader.vue';
import AdminSidebar from './AdminSidebar.vue';
import AdminFooter from './AdminFooter.vue'; // Thêm Footer

const router = useRouter();


// 1. INJECT DỮ LIỆU TỪ APP.VUE
const portfolioData = inject('portfolioData'); 
const apiBaseUrl = inject('apiBaseUrl');
const fetchData = inject('fetchData');
const securityState = inject('securityState');

// Lấy trạng thái đăng nhập
const isLoggedIn = securityState.isLoggedIn || null;

// Guard: Kiểm tra và chuyển hướng nếu chưa đăng nhập
watchEffect(() => {
    if (!isLoggedIn.value) {
        // Chuyển hướng về trang Đăng nhập Admin hoặc trang chủ nếu chưa đăng nhập
        router.push({ name: 'LoginAdmin' }); 
    }
});

// Cung cấp lại dữ liệu/hàm xuống các trang con của Admin
provide('adminData', { 
    portfolioData, 
    apiBaseUrl, 
    fetchData,
    logout: securityState.logout // Truyền hàm logout xuống header/sidebar
});

</script>

<template>
    <div class="admin-wrapper d-flex">
        <AdminSidebar />
        <div class="admin-content" style="width: 100%;">
            <AdminHeader/>
            <main class="admin-main p-4">
                <router-view></router-view> 
            </main>
            <AdminFooter/>
        </div>
    </div>
</template>

<style>
    .admin-wrapper{
        width: 100%;
    }
</style>