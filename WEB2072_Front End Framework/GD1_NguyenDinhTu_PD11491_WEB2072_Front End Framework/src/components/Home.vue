<script setup lang="ts">
    import { computed } from 'vue';

    const props = defineProps({
        portfolioData:{
            type: Object,
            required: true
        }
    });

    const emit = defineEmits(['changeView']);
    
    const featuredArticles = computed(() => props.portfolioData.articles);
</script>

<template>
    <section class="container-fluid max-width-center pt-3 g-5 mt-3">
        <!-- Thông tin cá nhân cơ bản -->
        <div class="row g-4 align-items-center justify-content-between bg-white p-4 p-md-5 rounded-3 shadow mb-5">
            <div class="col-md-7 order-2 order-md-1 mt-3 mt-md-0">
                <h1 class="fs-2 fs-md-1 fw-bolder text-dark">
                    Chào, tôi là <span>{{ portfolioData.personal.name }}</span>
                </h1>
                <p class="fs-5 text-primary fw-semibold">{{ portfolioData.personal.title }}</p>
                <p class="text-secondary">{{ portfolioData.personal.bio }}</p>
                <!-- d-flex, gap-3, pt-3 -->
                <div class="d-flex gap-3 pt-3">
                    <button @click="emit('changeView', 'Contact')" class="btn btn-primary px-4 py-2 fw-medium rounded-pill shadow-sm hover-scale-105">
                        Liên hệ hợp tác
                    </button>
                    <button @click="emit('changeView', 'Skills')" class="btn border-primary text-primary px-4 py-2 fw-medium rounded-pill hover-bg-light">
                        Xem Kỹ năng
                    </button>
                </div>
            </div>
            <div class="col-md-5 d-flex justify-content-center order-1 order-md-2">
                <img :src="portfolioData.personal.avatar" :alt="'Ảnh đại diện của ' + portfolioData.personal.name" class="profile-avatar rounded-circle border-4 border-primary shadow-lg">
            </div>
        </div>

        <!-- Học vấn -->
        <div class="bg-white p-4 p-md-5 rounded-3 shadow mb-5">
            <h2 class="fs-3 fw-bold text-dark mb-4 border-bottom pb-2">Học vấn</h2>
            <ul class="list-unstyled space-y-4">
                <li v-for="edu in portfolioData.education" :key="edu.id" class="p-3 bg-light rounded-2 border-start border-4 border-info hover-shadow-md transition">
                    <p class="fw-bold fs-6 text-dark">{{ edu.degree }}</p>
                    <p class="text-primary">{{ edu.institution }}</p>
                    <p class="small text-secondary">{{ edu.period }}</p>
                </li>
            </ul>
        </div>

        <!-- Kinh nghiệm làm việc -->
        <div class="bg-white p-4 p-md-5 rounded-3 shadow mb-5">
            <h2 class="fs-3 fw-bold text-dark mb-4 border-bottom pb-2">Kinh nghiệm làm việc</h2>
            <ol class="list-unstyled position-relative ms-3 ps-3 border-start border-secondary">
                <li v-for="exp in portfolioData.experience" :key="exp.id" class="mb-5 position-relative">
                    <span class="position-absolute top-0 start-0 translate-middle badge rounded-circle bg-primary p-2 ring-white timeline-dot"></span>
                    <h3 class="d-flex align-items-center mb-1 fs-5 fw-semibold text-dark">{{ exp.title }} <span class="badge bg-info-subtle text-info fw-medium ms-3">{{ exp.period }}</span></h3>
                    <p class="d-block mb-2 small fw-normal text-secondary">{{ exp.company }}</p>
                    <p class="text-base fw-normal text-secondary">{{ exp.description }}</p>
                </li>
            </ol>
        </div>

        <!-- Kỹ năng (Cứng + Mềm) -->
        <div class="bg-white p-4 p-md-5 rounded-3 shadow mb-5">
            <h2 class="fs-3 fw-bold text-dark mb-4 border-bottom pb-2">Kỹ năng nổi bật</h2>
            <!-- row, g-4 -->
            <div class="row g-4">
                <div class="col-md-6">
                    <h3 class="fs-5 fw-semibold mb-3 text-primary">Kỹ năng cứng (Hard Skills)</h3>
                    <!-- d-flex flex-wrap gap-2 -->
                    <div class="d-flex flex-wrap gap-2">
                        <span v-for="skill in portfolioData.personal.hardSkills.slice(0, 5)" :key="skill" class="badge bg-info-subtle text-info fs-7 px-3 py-2 rounded-pill shadow-sm">
                            {{ skill }}
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <h3 class="fs-5 fw-semibold mb-3 text-primary">Kỹ năng mềm (Soft Skills)</h3>
                    <div class="d-flex flex-wrap gap-2">
                        <span v-for="skill in portfolioData.personal.softSkills.slice(0, 5)" :key="skill" class="badge bg-success-subtle text-success-emphasis fs-7 px-3 py-2 rounded-pill shadow-sm">
                            {{ skill }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="mt-4 text-center">
                <button @click="emit('changeView', 'Skills')" class="btn btn-link text-primary hover-text-dark fw-medium transition">
                    Xem tất cả dự án và kỹ năng chi tiết &rarr;
                </button>
            </div>
        </div>
        
        <!-- Bài viết nổi bật -->
        <div class="bg-white p-4 p-md-5 rounded-3 shadow mb-5">
            <h2 class="fs-3 fw-bold text-dark mb-4 border-bottom pb-2">Bài viết nổi bật</h2>
            <!-- row, g-4 -->
            <div class="row g-4">
                <div v-for="article in featuredArticles" :key="article.id" class="col-md-6">
                    <div class="card p-3 shadow-sm hover-shadow-lg cursor-pointer transition h-100" @click="emit('changeView', 'Articles')">
                        <div class="card-body p-0">
                            <h3 class="fs-5 fw-bold text-primary mb-2 hover-text-dark">{{ article.title }}</h3>
                            <p class="text-secondary small">{{ article.summary }}</p>
                            <span class="small text-muted mt-2 d-block">Ngày đăng: {{ article.date }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 text-center">
                <button @click="emit('changeView', 'Articles')" class="btn btn-link text-primary hover-text-dark fw-medium transition">
                    Xem tất cả bài viết &rarr;
                </button>
            </div>
        </div>

    </section>
</template>

<style scoped>
/* Định nghĩa các lớp CSS thuần (Nên chuyển sang file style.css để dùng chung) */
.max-width-center {
    max-width: 1280px;
    margin-left: auto;
    margin-right: auto;
}

.text-gradient {
    background-image: linear-gradient(45deg, #0575E6, #021B79);
    -webkit-text-fill-color: transparent;
}

.profile-avatar {
    width: 12rem;
    height: 12rem;
    object-fit: cover;
    border-radius: 50%; /* rounded-circle */
}

/* Kỹ năng */
.fs-7 {
    font-size: 0.875rem; /* text-sm */
}

/* Timeline dot */
.timeline-dot {
    position: absolute;
    top: 0;
    left: 0;
    transform: translate(-50%, -50%);
    border: 4px solid white; /* ring-white */
    z-index: 1;
}

/* Hiệu ứng chung */
.transition {
    transition: all 0.3s ease-in-out;
}
.cursor-pointer {
    cursor: pointer;
}

/* Hiệu ứng hover cho buttons và cards */
.hover-scale-105:hover {
    transform: scale(1.05);
}
.hover-bg-light:hover {
    background-color: var(--bs-light) !important;
}
.hover-text-dark:hover {
    color: var(--bs-dark) !important;
}
.hover-shadow-md:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important; /* shadow-md */
}
.hover-shadow-lg:hover {
    box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important; /* shadow-xl */
}
</style>