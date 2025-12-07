<script setup>
import { computed, inject } from 'vue'; // ✅ Thêm inject
import { useRoute } from 'vue-router'; 


//1. INJECT DỮ LIỆU TỪ APP.VUE
const portfolioData = inject('portfolioData');
const securityState = inject('securityState');
const isLoggedIn = securityState.isLoggedIn;
const logout = securityState.logout;

//2. TẠO COMPUTED PROPERTY ĐỂ TRUY CẬP DỮ LIỆU CÁ NHÂN AN TOÀN
const personalData = computed(() => {
    // Luôn trả về object có cấu trúc cơ bản
    return portfolioData.value?.personal || { name: 'Portfolio', avatar: '' };
});

// Hàm xử lý Đăng xuất
const handleLogout = () => {
    //Thực hiện logic thay đổi trạng thái đăng nhập
    logout();
};

const route = useRoute();

// Định nghĩa navItems (Không đổi)
const navItems = [
    { label: "Trang chủ", path: "/" },
    { label: "Thông tin", path: "/detail" },
    { label: "Kĩ năng/Dự án", path: "/skills" },
    { label: "Bài viết", path: "/articles" },
    { label: "Liên hệ", path: "/contact" },
];


const isActive = (path) => {
    return route.path === path;
};

// Thêm hàm để đóng menu thủ công (Dựa trên ID 'navbarNav')
const collapseNavbar = () => {
    // Chỉ đóng nếu menu đang mở (thường xảy ra trên mobile)
    const navbar = document.getElementById('navbarNav');
    if (navbar && navbar.classList.contains('show')) {
        // Đây là cách chuẩn để kích hoạt việc đóng collapse của Bootstrap bằng JS
        const collapseElement = new bootstrap.Collapse(navbar, { toggle: false });
        collapseElement.hide();
    }
};

// Hàm điều hướng và đóng menu
const navigateAndClose = (path) => {
    // Điều hướng trước
    route.push(path);
    // Đợi Vue cập nhật DOM, sau đó đóng menu
    nextTick(() => {
        collapseNavbar();
    });
};
</script>

<template>
    <!-- Navbar Bootstrap-->
    <header class="fixed-top bg-white shadow-sm z-index-10">
        <nav class="navbar navbar-expand-md navbar-light py-0">
            <!-- Container Responsive -->
            <div class="container-fluid container-md px-3 px-sm-3 px-lg-4 max-width-center"> 
                <!-- Logo/Tên (Sử dụng computed personalData.name) -->
                <router-link to="/" class="navbar-brand fs-4 fw-bold cursor-pointer py-3">
                    <!--  Truy cập trực tiếp personalData.name (Vì nó là Computed Object) -->
                    {{ personalData.name || 'Portfolio' }}
                </router-link>
                
                <!-- Toggle Button cho Mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menu Desktop & Mobile-->
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav mb-2 mb-lg-0 align-items-center">
                        <!-- Menu Items -->
                        <li v-for="item in navItems" :key="item.path" class="nav-item mx-2">
                            <router-link
                                :to="item.path"
                                @click="collapseNavbar" 
                                :class="{
                                    'border-bottom border-3 border-primary text-primary fw-semibold': isActive(item.path),
                                    'text-dark hover-text-secondary': !isActive(item.path)
                                }"
                                class="nav-link fs-6 cursor-pointer transition p-1 pt-3 pb-3">
                                {{ item.label }}
                            </router-link>
                        </li>
                        
                        <!-- Admin Link -->
                        <li class="nav-item mx-2">
                            <router-link
                                to="/admin/login"
                                @click="collapseNavbar" 
                                :class="{
                                    'border-bottom border-3 border-primary text-primary fw-semibold': isActive('/admin'),
                                    'text-dark hover-text-secondary': !isActive('/admin')
                                }"
                                class="nav-link fs-6 cursor-pointer transition p-1 pt-3 pb-3">
                                Trang quản trị
                            </router-link>
                        </li>

                        <!-- Nút Đăng xuất (Chỉ hiện khi đăng nhập) -->
                        <li v-if="isLoggedIn" class="nav-item ms-md-3 mt-2 mt-md-0">
                            <button @click="handleLogout" class="btn btn-sm btn-outline-danger fw-medium rounded-pill">
                                Đăng xuất
                            </button>
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
</style>