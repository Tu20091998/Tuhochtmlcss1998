<script setup>
    import { computed } from 'vue';
    import { inject } from 'vue';

    // Inject dữ liệu
    const portfolioData = inject('portfolioData');

    
    // COMPUTED: Personal data được bảo vệ và sẵn sàng sử dụng
    const personalData = computed(() => {
        return portfolioData.value?.personal || { name: 'Portfolio', avatar: '', bio: '', title: '', hardSkills: [], softSkills: [] };
    });

    const featuredArticles = computed(() => portfolioData.value?.articles || []);

</script>

<template>
        <section class="container-fluid max-width-center g-5" style="margin-top: 8rem;">
            <div class="row g-4 align-items-center justify-content-between bg-white p-4 p-md-5 rounded-3 shadow mb-5">
                <div class="col-md-7 order-2 mt-3">
                    <h1 class="fs-2 fs-md-1 fw-bolder text-dark">
                        Chào, tôi là <span>{{ personalData.name }}</span>
                    </h1>
                    <p class="fs-5 text-primary fw-semibold">{{ personalData.title }}</p>
                    <p class="text-secondary">{{ personalData.bio }}</p>
                    </div>
                <div class="col-md-5 d-flex justify-content-center order-1 order-md-2">
                    <img :src="personalData.avatar" :alt="'Ảnh đại diện của ' + personalData.name" class="profile-avatar rounded-circle border-4 border-primary shadow-lg">
                </div>
            </div>

            <div class="bg-white p-4 p-md-5 rounded-3 shadow mb-5">
                <h2 class="fs-3 fw-bold text-dark mb-4 border-bottom pb-2">Học vấn</h2>
                <ul class="list-unstyled">
                    <li v-for="edu in portfolioData.education" :key="edu.id" class="p-3 bg-light rounded-2 border-start border-4 border-info hover-shadow-md transition gap-2 mb-4">
                        <p class="fw-bold fs-5 text-dark">{{ edu.institution }}</p>
                        <p class="fw-bold fs-6 text-dark">{{ edu.degree }}</p>
                        <p class="text-primary">{{ edu.institution }}</p>
                        <p class="small text-secondary">{{ edu.period }}</p>
                        <p class="small text-secondary">{{ edu.details }}</p>
                        <p class="small text-secondary">{{ edu.address }}</p>
                    </li>
                </ul>
            </div>

            <div class="bg-white p-4 p-md-5 rounded-3 shadow mb-5">
                <h2 class="fs-3 fw-bold text-dark mb-4 border-bottom pb-2">Kinh nghiệm làm việc</h2>
                <ol class="list-unstyled position-relative ms-3 ps-3 border-start border-secondary">
                    <li v-for="exp in portfolioData.experience" :key="exp.id" class="mb-5 position-relative">
                        <h3 class="d-flex align-items-center mb-1 fs-5 fw-semibold text-dark">{{ exp.title }} <span class="badge bg-info-subtle text-info fw-medium ms-3">{{ exp.period }}</span></h3>
                        <p class="d-block mb-2 small mt-3 fw-normal text-secondary">{{ exp.company }}</p>
                        <p class="fw-normal text-secondary">{{ exp.description }}</p>
                    </li>
                </ol>
            </div>

            <div class="bg-white p-4 p-md-5 rounded-3 shadow mb-5">
                <h2 class="fs-3 fw-bold text-dark mb-4 border-bottom pb-2">Kỹ năng nổi bật</h2>
                <div class="row g-4">
                    <div class="col-md-6">
                        <h3 class="fs-5 fw-semibold mb-3 text-primary">Kỹ năng cứng (Hard Skills)</h3>
                        <div class="d-flex flex-wrap gap-2">
                            <span v-for="skill in portfolioData.personal?.hardSkills?.slice(0, 5)" :key="skill" class="badge bg-info-subtle text-info fs-7 px-3 py-2 rounded-pill shadow-sm">
                                {{ skill }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 class="fs-5 fw-semibold mb-3 text-primary">Kỹ năng mềm (Soft Skills)</h3>
                        <div class="d-flex flex-wrap gap-2">
                            <span v-for="skill in portfolioData.personal?.softSkills?.slice(0, 5)" :key="skill" class="badge bg-success-subtle text-success-emphasis fs-7 px-3 py-2 rounded-pill shadow-sm">
                                {{ skill }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Bổ sung: Nút xem tất cả -->
                <div class="mt-4 text-center">
                    <button class="btn btn-link text-primary hover-text-dark fw-medium transition">
                        Xem tất cả dự án và kỹ năng chi tiết &rarr;
                    </button>
                </div>
            </div>
            
            <div class="bg-white p-4 p-md-5 rounded-3 shadow mb-5">
                <h2 class="fs-3 fw-bold text-dark mb-4 border-bottom pb-2">Bài viết nổi bật</h2>
                <div class="row g-4">
                    <div v-for="article in featuredArticles" :key="article.id" class="col-md-6">
                        <div class="card p-3 shadow-sm hover-shadow-lg cursor-pointer transition h-100">
                            <div class="card-body p-0">
                                <h3 class="fs-5 fw-bold text-primary mb-2 hover-text-dark">{{ article.title }}</h3>
                                <p class="text-secondary small">{{ article.summary }}</p>
                                <span class="small text-muted mt-2 d-block">Ngày đăng: {{ article.date }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Bổ sung: Nút xem tất cả -->
                <div class="mt-4 text-center">
                    <button class="btn btn-link text-primary hover-text-dark fw-medium transition">
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