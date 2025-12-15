<script setup>
import { computed, inject } from 'vue'; 



// Định nghĩa navItems (Không đổi)
const navItems = [
    { label: "🏠 Trang chủ", path: "/" },
    { label: "📄 Thông tin", path: "/detail" },
    { label: "🛠️ Kĩ năng/Dự án", path: "/skills" },
    { label: "✍️ Bài viết", path: "/articles" },
    { label: "📧 Liên hệ", path: "/contact" },
];

// Thêm hàm để đóng menu thủ công (Dựa trên ID 'navbarNav')
const collapseNavbar = () => {
    // Chỉ đóng nếu menu đang mở (thường xảy ra trên mobile)
    const navbar = document.getElementById('navbarNav');
    if (navbar && navbar.classList.contains('show')) {
        const collapseElement = new bootstrap.Collapse(navbar, { toggle: false });
        collapseElement.hide();
    }
};
</script>

<template>
    <!-- Navbar Bootstrap-->
    <header class="fixed-top bg-white shadow-sm z-index-10">
        <nav class="navbar navbar-expand-md navbar-light py-0 bg-dark">
            <!-- Container Responsive -->
            <div class="container-fluid container-md px-3 px-sm-3 px-lg-4 max-width-center"> 
                <!-- Logo/Tên (Sử dụng computed personalData.name) -->
                <router-link to="/" class="navbar-brand fs-4 fw-bold cursor-pointer py-3 text-white">
                    <i class="bi bi-briefcase fs-2"></i> PORTFOLIO
                </router-link>
                
                <!-- Toggle Button cho Mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menu Desktop & Mobile-->
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav mb-2 mb-lg-0 align-items-center">
                        <!-- Menu Items -->
                        <li v-for="item in navItems" :key="item.path" class="nav-item mx-2 text-white">
                            <router-link
                                :to="item.path"
                                @click="collapseNavbar" 
                                class="nav-link fs-6 cursor-pointer transition p-1 pt-3 pb-3 text-white">
                                {{ item.label }}
                            </router-link>
                        </li>
                        
                        <!-- Admin Link -->
                        <li class="nav-item mx-2">
                            <router-link
                                to="/admin/login"
                                @click="collapseNavbar" 
                                class="nav-link fs-6 cursor-pointer transition p-1 pt-3 pb-3 text-white">
                                ⚙️ Trang quản trị
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</template>

<style scoped>
/* Custom CSS thuần */
.z-index-10 {
    z-index: 10;
}

.max-width-center {
    max-width: 1280px;
    margin-left: auto;
    margin-right: auto;
}

.cursor-pointer {
    cursor: pointer;
}

.transition {
    transition: all 0.2s ease-in-out;
}

/* Custom style cho hiệu ứng màu gradient */
.text-gradient {
    background-image: linear-gradient(45deg, #0575E6, #021B79);
}

/* Hiệu ứng hover cho menu item */
.hover-text-secondary:hover {
    color: var(--bs-secondary) !important;
}

/* === BỔ SUNG: STYLE CHO MENU ACTIVE === */
.nav-link.router-link-active,
.nav-link.router-link-exact-active {
    /* Đặt màu sắc khi mục đang active (ví dụ: Màu Primary - Xanh dương) */
    color: var(--bs-primary) !important;
    
    /* Tùy chọn: Thêm gạch chân để nổi bật hơn */
    border-bottom: 2px solid var(--bs-primary); 
}

/* Đảm bảo hiệu ứng hover vẫn hoạt động khi không active */
.nav-link:hover:not(.router-link-exact-active) {
    color: var(--bs-secondary) !important; /* Màu hover thông thường (secondary) */
}

/* Đảm bảo link active vẫn giữ màu active khi hover */
.nav-link.router-link-exact-active:hover {
    color: var(--bs-primary) !important; 
}

/* Đảm bảo nút nổi bật trên mọi nền */
.navbar-toggler-icon {
    /* Thay đổi màu của icon (3 gạch) thành màu trắng */
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='white' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
}

/* Tùy chọn: Thay đổi màu viền của nút nếu cần */
.navbar-toggler {
    border-color: rgba(255, 255, 255, 0.5); /* Viền màu trắng nhạt */
}
</style>