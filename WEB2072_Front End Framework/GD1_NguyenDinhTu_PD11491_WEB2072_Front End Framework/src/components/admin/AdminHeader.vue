<script setup>
import { inject } from 'vue';

// Inject dữ liệu cá nhân để hiển thị tên và avatar
const adminData = inject('adminData');
const personalData = adminData.portfolioData.value.personal;
const logout = adminData.logout;

// Hàm xử lý Đăng xuất
const handleLogout = () => {
    //Thực hiện logic thay đổi trạng thái đăng nhập
    logout();
};

</script>

<template>
    <header class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm p-3">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            
            <a class="navbar-brand text-uppercase fw-bold" href="/admin/dashboard">
                <i class="bi bi-speedometer2 me-2"></i> Admin Panel
            </a>

            <div class="d-flex align-items-center">
                <span class="me-3 text-white d-none d-sm-inline">
                    Xin chào, <strong>{{ personalData.name }}</strong>
                </span>

                <img 
                    :src="personalData.avatar" 
                    alt="Avatar" 
                    class="rounded-circle me-3" 
                    style="width: 40px; height: 40px; object-fit: cover;"
                >

                <!-- Nút Đăng xuất -->
                <li v-if="isLoggedIn" class="nav-item ms-md-3 mt-2 mt-md-0">
                    <button @click="handleLogout" class="btn btn-sm btn-outline-danger fw-medium rounded-pill">
                        Đăng xuất
                    </button>
                </li>
            </div>
        </div>
    </header>
</template>
