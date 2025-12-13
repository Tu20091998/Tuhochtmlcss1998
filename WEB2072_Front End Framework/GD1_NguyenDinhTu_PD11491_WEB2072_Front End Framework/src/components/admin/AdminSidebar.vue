<script setup>
import { RouterLink } from 'vue-router';
</script>

<template>
    <aside class="sidebar bg-dark text-white p-3 d-flex flex-column" style="width: 25%; height: 100vh;">
        
        <h5 class="py-2 mb-4 border-bottom text-secondary">
            <i class="bi bi-stack me-2"></i> QUẢN LÝ DỮ LIỆU
        </h5>
        
        <nav class="nav nav-pills flex-column mb-auto">
            <RouterLink
                :to= "{name: 'Dashboard'}"
                class="nav-link text-white mb-2" 
                active-class="bg-primary"
            >
                🏠 <span class="fs-6">Dashboard</span> 
            </RouterLink>

            <RouterLink
                :to="{name: 'PersonalEdit'}"
                class="nav-link text-white mb-2" 
                active-class="bg-primary"
            >
                🧑 <span class="fs-6">Thông tin cá nhân</span>
            </RouterLink>

            <RouterLink
                :to="{name: 'ArticlesManagement'}"
                class="nav-link text-white mb-2" 
                active-class="bg-primary"
            >
                📝 <span class="fs-6">Bài Viết</span>
            </RouterLink>

            <RouterLink
                :to="{name: 'ProjectsManagement'}"
                class="nav-link text-white mb-2" 
                active-class="bg-primary"
            >
                🏗️ <span class="fs-6">Dự Án</span> 
            </RouterLink>

            <RouterLink
                :to= "{name: 'StudyEdit'}"
                class="nav-link text-white mb-2" 
                active-class="bg-primary"
            >
                🎓 <span class="fs-6">Học Vấn</span> 
            </RouterLink>

            <RouterLink
                :to= "{name: 'ExperienceManagement'}"
                class="nav-link text-white mb-2" 
                active-class="bg-primary"
            >
                💼 <span class="fs-6">Kinh Nghiệm</span> 
            </RouterLink>
        </nav>

        <div class="mt-auto pt-3 border-top">
            <small class="text-secondary">&copy; 2025 Nguyễn Đình Tú</small>
        </div>
    </aside>
</template>

<style scoped>
.sidebar {
    /* Đảm bảo sidebar chiếm hết chiều cao màn hình */
    position: sticky;
    top: 0;
}
.nav-link {
    transition: background-color 0.2s ease;
}
</style>