<script setup>
import { inject, watchEffect, provide } from 'vue';
import { useRouter } from 'vue-router';
// Import Header/Sidebar riêng cho Admin
import AdminHeader from './AdminHeader.vue';
import AdminSidebar from './AdminSidebar.vue';
import AdminFooter from './AdminFooter.vue'; // Thêm Footer

//chèn route
const router = useRouter();

//  INJECT DỮ LIỆU TỪ APP.VUE
const portfolioData = inject('portfolioData'); 
const apiBaseUrl = inject('apiBaseUrl');
const fetchData = inject('fetchData');
const securityState = inject('securityState');

// Lấy trạng thái đăng nhập
const isLoggedIn = securityState.isLoggedIn || null;

// Kiểm tra và chuyển hướng nếu chưa đăng nhập
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
    logout: securityState.logout,
    isLoggedIn: securityState.isLoggedIn,
});

</script>

<template>
    <div class="admin-wrapper d-flex">
        <AdminSidebar />
        <div class="admin-content" style="width: 100%;">
            <AdminHeader/>
            <main class="admin-main p-4">
                <transition name="fade" mode="out-in">
                    <router-view />
                </transition>
            </main>
            <AdminFooter/>
        </div>
    </div>
</template>

<style>
    .admin-wrapper{
        width: 100%;
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity 1s;
    }

    .fade-enter-from, .fade-leave-to {
        opacity: 0;
        transition: opacity 0.5s;
    }
</style>