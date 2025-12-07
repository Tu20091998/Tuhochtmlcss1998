<script setup>
    import { computed } from 'vue';
    import { inject } from 'vue';

    // Inject dữ liệu
    const portfolioData = inject('portfolioData');

    const featuredArticles = computed(() => portfolioData.value?.articles || []);
</script>

<template>
    <section class="container-fluid max-width-center pt-3 g-5">
        <h1 class="fs-2 fw-bold text-dark text-center mb-5">Kĩ Năng & Kinh Nghiệm Phát Triển</h1>

        <!-- Học vấn chi tiết -->
        <div class="card bg-white p-4 p-md-5 rounded-3 shadow-lg mb-5">
            <h2 class="fs-3 fw-bold text-dark mb-4 border-bottom pb-2">Quá trình Học vấn</h2>
            <ul class="list-unstyled space-y-4 d-flex gap-4">
                <li v-for="edu in portfolioData.education" :key="edu.id" class="p-3 border border-light-subtle rounded-3 shadow-sm hover-shadow-md transition w-50">
                    <p class="fw-bold fs-5 text-primary">{{ edu.degree }}</p>
                    <p class="fs-6 text-dark">{{ edu.institution }}</p>
                    <p class="small text-secondary">{{ edu.period }}</p>
                    <p class="small text-muted mt-1">Địa chỉ: {{ edu.address }}</p>
                    <p class="small text-secondary mt-2">{{ edu.details }}</p>
                </li>
            </ul>
        </div>

        <!-- Kỹ năng cứng & mềm -->
        <div class="card bg-white p-4 p-md-5 rounded-3 shadow-lg mb-5">
            <h2 class="fs-3 fw-bold text-dark mb-4 border-bottom pb-2">Bộ Kỹ Năng</h2>
            <div class="row g-4">
                <div class="col-md-6">
                    <h3 class="fs-5 fw-semibold mb-3 text-primary">Kỹ năng cứng (Hard Skills)</h3>
                    <div class="d-flex flex-column gap-3">
                        <div v-for="skill in portfolioData.personal.hardSkills" :key="skill" class="bg-light p-3 rounded-2 d-flex justify-content-between align-items-left">
                            <span class="fw-medium text-dark">{{ skill }}</span>
                            <!-- Placeholder cho Progress Bar Bootstrap -->
                            <div class="progress w-50" role="progressbar" aria-label="Skill level" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-info" :style="{width: (Math.random() * 30 + 70) + '%'}"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h3 class="fs-5 fw-semibold mb-3 text-success">Kỹ năng mềm (Soft Skills)</h3>
                    <div class="d-flex flex-wrap gap-2">
                        <span v-for="skill in portfolioData.personal.softSkills" :key="skill" class="badge bg-success-subtle text-success-emphasis fs-6 px-3 py-2 rounded-pill shadow-sm transition transform-hover-scale">
                            {{ skill }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danh sách dự án cá nhân -->
        <div class="card bg-white p-4 p-md-5 rounded-3 shadow-lg mb-5">
            <h2 class="fs-3 fw-bold text-dark mb-4 border-bottom pb-2">Danh sách Dự án Cá nhân/Nhóm</h2>
            <div class="d-flex flex-column gap-5">
                <div v-for="project in portfolioData.projects" :key="project.id" class="row bg-light p-4 rounded-3 shadow-sm hover-shadow-lg transition">
                    
                    <!-- Hình ảnh -->
                    <div class="col-12 col-md-4 mb-3 mb-md-0">
                        <!-- Sử dụng img-fluid object-fit-cover để đảm bảo hình ảnh responsive và giữ tỷ lệ -->
                        <img :src="project.image" :alt="'Hình ảnh minh họa dự án ' + project.name" class="img-fluid object-fit-cover rounded-3 shadow-md project-image-size">
                    </div>
                    
                    <!-- Chi tiết Dự án -->
                    <div class="col-12 col-md-8">
                        <h3 class="fs-4 fw-bold text-primary mb-2">{{ project.name }}</h3>
                        <p class="text-secondary small mb-3">{{ project.description }}</p>
                        
                        <!-- Thông tin chi tiết dự án (Grid 2 cột) -->
                        <div class="row small g-2">
                            <div class="col-6"><p class="fw-medium text-dark mb-0">Công nghệ:</p> <span class="text-info">{{ project.tech }}</span></div>
                            <div class="col-6"><p class="fw-medium text-dark mb-0">Thành viên:</p> <span class="text-info">{{ project.members }} người</span></div>
                            <div class="col-6"><p class="fw-medium text-dark mb-0">Thời gian:</p> <span class="text-info">{{ project.duration }}</span></div>
                            <div class="col-6"><p class="fw-medium text-dark mb-0">Trạng thái:</p> <span class="badge bg-success text-success-emphasis">Đã hoàn thành</span></div>
                            <div class="col-6"><p class="fw-medium text-dark mb-0">Bắt đầu:</p> <span class="text-info">{{ project.startDate }}</span></div>
                            <div class="col-6"><p class="fw-medium text-dark mb-0">Kết thúc:</p> <span class="text-info">{{ project.endDate }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
/* Tái sử dụng CSS thuần */
.max-width-center {
    max-width: 1280px;
    margin-left: auto;
    margin-right: auto;
}
.transition {
    transition: all 0.3s ease-in-out;
}
/* Kích thước ảnh dự án */
.project-image-size {
    height: 12rem;
    width: 100%;
}
.transform-hover-scale {
    transition: transform 0.3s ease-in-out;
}
.transform-hover-scale:hover {
    transform: scale(1.03);
}
.hover-shadow-md:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
.hover-shadow-lg:hover {
    box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
}
/* Utility class to help maintain aspect ratio on image container */
.object-fit-cover {
    object-fit: cover;
}
</style>