<script setup>
    import { inject } from 'vue';
    
    // Inject dữ liệu
    const portfolioData = inject('portfolioData');

    /**
     * Hàm định dạng ngày tháng từ chuỗi ISO/YYYY-MM-DD sang DD/MM/YYYY
     * @param {string} dateString
     * @returns {string} 
     */
    const formatProjectDate = (dateString) => {
        if (!dateString) return 'N/A';
        
        // Tạo đối tượng Date từ chuỗi
        const date = new Date(dateString);

        // Kiểm tra xem ngày có hợp lệ không
        if (isNaN(date)) {
            return dateString; // Trả về nguyên bản nếu không phải ngày hợp lệ
        }

        // Tùy chọn: { year: 'numeric', month: 'numeric', day: 'numeric' }
        return new Intl.DateTimeFormat('vi-VN').format(date);
    };
</script>

<template>
    <div class="card bg-white p-4 p-md-5 rounded-3 shadow-lg mb-5">
        <h2 class="fs-3 fw-bold text-dark mb-4 border-bottom pb-2">🏗️ Danh sách Dự án Cá nhân/Nhóm</h2>
        <div class="d-flex flex-column gap-5">
            <div v-for="project in portfolioData.projects" :key="project.id" class="row bg-light p-4 rounded-3 shadow-sm hover-shadow-lg transition">
                
                <div class="col-12 col-md-4 mb-3 mb-md-0">
                    <img :src="project.image" :alt="'Hình ảnh minh họa dự án ' + project.name" class="img-fluid object-fit-cover rounded-3 shadow-md project-image-size">
                </div>
                
                <div class="col-12 col-md-8">
                    <h3 class="fs-4 fw-bold text-primary mb-2">{{ project.name }}</h3>
                    <p class="text-secondary small mb-3">{{ project.description }}</p>
                    
                    <div class="row small g-2">
                        <div class="col-6"><p class="fw-medium text-dark mb-0">Công nghệ:</p> <span class="text-info">{{ project.tech?.join(", ") }}</span></div>
                        <div class="col-6"><p class="fw-medium text-dark mb-0">Thành viên:</p> <span class="text-info">{{ project.members }} người</span></div>
                        <div class="col-6"><p class="fw-medium text-dark mb-0">Thời gian:</p> <span class="text-info">{{ project.duration }}</span></div>
                        <div class="col-6"><p class="fw-medium text-dark mb-0">Trạng thái:</p> <span class="badge bg-success text-success-emphasis">Đã hoàn thành</span></div>
                        
                        <div class="col-6"><p class="fw-medium text-dark mb-0">Bắt đầu:</p> <span class="text-info">{{ formatProjectDate(project.startDate) }}</span></div>
                        <div class="col-6"><p class="fw-medium text-dark mb-0">Kết thúc:</p> <span class="text-info">{{ formatProjectDate(project.endDate) }}</span></div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* CSS đặc thù cho phần dự án */
/* (Giữ nguyên phần này) */
.transition {
    transition: all 0.3s ease-in-out;
}
.hover-shadow-lg:hover {
    box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
}
.project-image-size {
    height: 12rem;
    width: 100%;
}
.object-fit-cover {
    object-fit: cover;
}
</style>