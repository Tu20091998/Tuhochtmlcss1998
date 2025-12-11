<script setup>
    import { inject } from 'vue';

    // Inject dữ liệu
    const portfolioData = inject('portfolioData');
</script>

<template>
    <div class="bg-white p-4 p-md-5 rounded-3 shadow mb-5">
        <h2 class="fs-3 fw-bold text-dark mb-4 border-bottom pb-2">💼 Kinh nghiệm làm việc</h2>
        <ol class="list-unstyled position-relative ms-3 ps-3 border-start border-secondary">
            <li v-for="exp in portfolioData.experience" :key="exp.id" class="mb-5 position-relative">
                <h3 class="d-flex align-items-center mb-1 fs-5 fw-semibold text-dark">
                    {{ exp.title }} 
                    <span class="badge bg-info-subtle text-info fw-medium ms-3">{{ exp.period }}</span>
                </h3>
                <p class="d-block mb-2 small mt-3 fw-normal text-secondary">{{ exp.company }}</p>
                <p class="fw-normal text-secondary">{{ exp.description }}</p>
            </li>
        </ol>
    </div>
</template>