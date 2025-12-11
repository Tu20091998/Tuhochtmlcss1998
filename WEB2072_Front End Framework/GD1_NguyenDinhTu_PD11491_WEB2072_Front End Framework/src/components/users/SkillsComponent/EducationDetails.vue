<script setup>
    import { inject } from 'vue';

    // Inject dữ liệu
    const portfolioData = inject('portfolioData');
</script>

<template>
    <div class="card bg-white p-4 p-md-5 rounded-3 shadow-lg mb-5">
        <h2 class="fs-3 fw-bold text-dark mb-4 border-bottom pb-2">🎓 Quá trình Học vấn</h2>
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
</template>

<style scoped>
/* CSS đặc thù cho phần Học vấn */
.transition {
    transition: all 0.3s ease-in-out;
}
.hover-shadow-md:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
.w-50 {
    width: 50%; /* Đảm bảo li chiếm nửa chiều rộng, cần responsive hơn nếu cần */
}
</style>