
<script setup>
    import { computed, inject } from 'vue';

    // Inject dữ liệu
    const portfolioData = inject('portfolioData');
</script>

<template>
    <div class="bg-white p-4 p-md-5 rounded-3 shadow mb-5">
        <h2 class="fs-3 fw-bold text-dark mb-4 border-bottom pb-2">🌟 Kỹ năng nổi bật</h2>
        <div class="row g-4">
            <div class="col-md-6">
                <h3 class="fs-5 fw-semibold mb-3 text-primary">🔧 Kỹ năng cứng (Hard Skills)</h3>
                <div class="d-flex flex-wrap gap-2">
                    <span v-for="skill in portfolioData.personal?.hardSkills?.slice(0, 5)" :key="skill" class="badge bg-info-subtle text-info fs-7 px-3 py-2 rounded-pill shadow-sm">
                        {{ skill }}
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <h3 class="fs-5 fw-semibold mb-3 text-primary">✨ Kỹ năng mềm (Soft Skills)</h3>
                <div class="d-flex flex-wrap gap-2">
                    <span v-for="skill in portfolioData.personal?.softSkills?.slice(0, 5)" :key="skill" class="badge bg-success-subtle text-success-emphasis fs-7 px-3 py-2 rounded-pill shadow-sm">
                        {{ skill }}
                    </span>
                </div>
            </div>
        </div>

        <div class="mt-4 text-center">
            <router-link
                :to="{name: 'Skills'}"
                class="btn btn-link text-primary hover-text-dark fw-medium transition">
                Xem tất cả dự án và kỹ năng chi tiết &rarr;
            </router-link>
        </div>
    </div>
</template>

<style scoped>
.fs-7 {
    font-size: 0.875rem; /* text-sm */
}
.transition {
    transition: all 0.3s ease-in-out;
}
.hover-text-dark:hover {
    color: var(--bs-dark) !important;
}
</style>