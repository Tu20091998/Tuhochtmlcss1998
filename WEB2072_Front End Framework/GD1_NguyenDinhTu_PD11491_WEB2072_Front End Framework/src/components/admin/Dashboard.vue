<script setup>
import { computed, inject } from 'vue';

// INJECT DỮ LIỆU TỪ ADMIN LAYOUT
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

// Tổng số Tin nhắn
const totalMessages = computed(() => {
    return portfolioData.value.messages?.length || 0;
});

// Thống kê học vấn
const totalStudy = computed(() => {
    return portfolioData.value.education?.length || 0;
});

//thống kê kinh nghiệm
const totalExperience = computed(() => {
    return portfolioData.value.experience?.length || 0;
});

//thống kê số tài khoản
const totalAccount = computed(() => {
    return portfolioData.value.users?.length || 0;
});

//hàm lấy danh sách tin nhắn
const messages = computed(() => {
    return portfolioData.value.messages || null;
    
});

// THÊM HÀM ĐỊNH DẠNG NGÀY THÁNG
const formatDate = (timestamp) => {
    if (!timestamp) return 'N/A';
    try {
        const date = new Date(timestamp);
        // Định dạng: Ngày/Tháng/Năm Giờ:Phút
        return date.toLocaleDateString('vi-VN') + ' ' + date.toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });
    } catch {
        return 'Invalid Date';
    }
};

</script>

<template>
    <div class="container-fluid">
        <h2 class="mb-4 text-dark fw-bold">Dashboard Tổng Quan</h2>
        <p class="text-muted">Chào mừng trở lại, đây là cái nhìn tổng quan về nội dung của bạn.</p>
        
        <hr class="mb-5">

        <div class="row">
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm border-start border-4 border-info h-100">
                    <div class="card-body">
                        <div class="row align-items-center d-flex flex-column">
                            <div class="col me-2">

                                <div class="col-auto">
                                    <i class="bi bi-file-text fs-2 text-gray-300"></i>
                                </div>

                                <div class="text-xs fw-bold text-info text-uppercase mb-1">
                                    Tổng Số Bài Viết
                                </div>
                                <div class="h5 mb-0 fw-bold text-gray-800">
                                    {{ totalArticles }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm border-start border-4 border-primary h-100">
                    <div class="card-body">
                        <div class="row align-items-center d-flex flex-column">
                            <div class="col-auto">
                                <i class="bi bi-envelope-fill fs-2 text-gray-300"></i>
                            </div>

                            <div class="col me-2">
                                <div class="text-2 fw-bold text-primary text-uppercase mb-1">
                                    Tổng Số Tin Nhắn Khách Hàng
                                </div>
                                <div class="h5 mb-0 fw-bold text-gray-800">
                                    {{ totalMessages }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm border-start border-4 border-success h-100">
                    <div class="card-body">
                        <div class="row align-items-center d-flex flex-column">
                            <div class="col-auto">
                                <i class="bi bi-check-circle fs-2 text-gray-300"></i>
                            </div>

                            <div class="col me-2">
                                <div class="text-xs fw-bold text-success text-uppercase mb-1">
                                    Đã Xuất Bản
                                </div>
                                <div class="h5 mb-0 fw-bold text-gray-800">
                                    {{ publishedArticles }} / {{ totalArticles }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm border-start border-4 border-warning h-100">
                    <div class="card-body">
                        <div class="row align-items-center d-flex flex-column">

                            <div class="col-auto">
                                <i class="bi bi-briefcase fs-2 text-gray-300"></i>
                            </div>

                            <div class="col me-2">
                                <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                                    Tổng Số Dự Án
                                </div>
                                <div class="h5 mb-0 fw-bold text-gray-800">
                                    {{ totalProjects }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm border-start border-4 border-danger h-100">
                    <div class="card-body">
                        <div class="row align-items-center d-flex flex-column">
                            <div class="col-auto">
                                <i class="bi bi-tools fs-2 text-gray-300"></i>
                            </div>

                            <div class="col me-2">
                                <div class="text-xs fw-bold text-danger text-uppercase mb-1">
                                    Kỹ Năng Cứng Đã Liệt Kê
                                </div>
                                <div class="h5 mb-0 fw-bold text-gray-800">
                                    {{ hardSkillsCount }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm border-start border-4 border-secondary h-100">
                    <div class="card-body">
                        <div class="row align-items-center d-flex flex-column">

                            <div class="col-auto">
                                <i class="bi bi-mortarboard-fill fs-2 text-gray-300"></i>
                            </div>

                            <div class="col me-2">
                                <div class="text-xs fw-bold text-secondary text-uppercase mb-1">
                                    Học vấn
                                </div>
                                <div class="h5 mb-0 fw-bold text-gray-800">
                                    {{ totalStudy }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm border-start border-4 border-dark h-100">
                    <div class="card-body">
                        <div class="row align-items-center d-flex flex-column">
                            <div class="col-auto">
                                <i class="bi bi-gear-fill fs-2 text-gray-300"></i>
                            </div>

                            <div class="col me-2">
                                <div class="text-xs fw-bold text-dark text-uppercase mb-1">
                                    Kinh Nghiệm
                                </div>
                                <div class="h5 mb-0 fw-bold text-gray-800">
                                    {{ totalExperience }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm border-4 h-100" style="border-color: pink;">
                    <div class="card-body">
                        <div class="row align-items-center d-flex flex-column">
                            <div class="col-auto">
                                <i class="bi bi-person fs-2 text-gray-300"></i>
                            </div>

                            <div class="col me-2">
                                <div class="text-xs fw-bold text-uppercase mb-1" style="color: pink;">
                                    Số tài khoản
                                </div>
                                <div class="h5 mb-0 fw-bold text-gray-800">
                                    {{ totalAccount }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light fw-bold d-flex justify-content-between align-items-center">
                    <span>💌 Tin Nhắn Hợp Tác Gần Đây</span>
                </div>
                <div class="card-body p-0">
                    <div v-if="totalMessages === 0" class="alert alert-secondary m-3">
                        Không có tin nhắn nào trong hộp thư.
                    </div>
                    <table v-else class="table table-striped table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Thời gian</th>
                                <th>Người Gửi</th>
                                <th>Email</th>
                                <th>Tiêu đề</th>
                                <th>Tóm tắt</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="msg in messages.slice(-5).reverse()" :key="msg.id">
                                <td>{{ formatDate(msg.timestamp) }}</td>
                                <td>{{ msg.name }}</td>
                                <td>{{ msg.email }}</td>
                                <td>{{ msg.subject }}</td>
                                <td>{{ msg.message}}</td>
                            </tr>
                        </tbody>
                    </table>
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