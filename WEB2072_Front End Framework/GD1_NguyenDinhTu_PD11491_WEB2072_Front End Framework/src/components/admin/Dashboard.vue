<script setup>
import { computed, inject } from 'vue';

// ✅ INJECT DỮ LIỆU TỪ ADMIN LAYOUT
const adminData = inject('adminData');
const portfolioData = adminData.portfolioData; // Dữ liệu reactive từ App.vue

// --- CÁC CHỈ SỐ THỐNG KÊ (Computed Properties) ---

// Tổng số Dự án
const totalProjects = computed(() => {
    return portfolioData.value.projects.length;
});

// Tổng số Bài viết
const totalArticles = computed(() => {
    return portfolioData.value.articles.length;
});

// Bài viết đang ở trạng thái 'Published'
const publishedArticles = computed(() => {
    return portfolioData.value.articles.filter(a => a.status === 'Published').length;
});

// Kỹ năng cứng (Lấy từ Personal Data)
const hardSkillsCount = computed(() => {
    return portfolioData.value.personal.hardSkills?.length || 0;
});
</script>

<template>
    <div class="container-fluid">
        <h1 class="mb-4 text-dark fw-bold">Dashboard Tổng Quan</h1>
        <p class="text-muted">Chào mừng trở lại, đây là cái nhìn tổng quan về nội dung của bạn.</p>
        
        <hr class="mb-5">

        <div class="row">
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm border-start border-4 border-info h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col me-2">
                                <div class="text-xs fw-bold text-info text-uppercase mb-1">
                                    Tổng Số Bài Viết
                                </div>
                                <div class="h5 mb-0 fw-bold text-gray-800">
                                    {{ totalArticles }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-file-text fs-2 text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm border-start border-4 border-success h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col me-2">
                                <div class="text-xs fw-bold text-success text-uppercase mb-1">
                                    Đã Xuất Bản
                                </div>
                                <div class="h5 mb-0 fw-bold text-gray-800">
                                    {{ publishedArticles }} / {{ totalArticles }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-check-circle fs-2 text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm border-start border-4 border-warning h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col me-2">
                                <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                                    Tổng Số Dự Án
                                </div>
                                <div class="h5 mb-0 fw-bold text-gray-800">
                                    {{ totalProjects }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-briefcase fs-2 text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm border-start border-4 border-danger h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col me-2">
                                <div class="text-xs fw-bold text-danger text-uppercase mb-1">
                                    Kỹ Năng Cứng Đã Liệt Kê
                                </div>
                                <div class="h5 mb-0 fw-bold text-gray-800">
                                    {{ hardSkillsCount }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-tools fs-2 text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header fw-bold">Hoạt động Gần đây</div>
                    <div class="card-body">
                        <p class="text-muted">Tùy thuộc vào Back-end, đây có thể là nơi hiển thị các bài viết/dự án mới nhất hoặc log hoạt động của Admin.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Định nghĩa màu xám nhạt cho icon */
.text-gray-300 {
    color: #dee2e6 !important;
}
</style>