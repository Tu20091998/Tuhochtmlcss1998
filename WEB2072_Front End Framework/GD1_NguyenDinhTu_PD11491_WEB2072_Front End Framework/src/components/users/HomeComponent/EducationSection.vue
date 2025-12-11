<script setup>
import { inject } from 'vue';

// Inject dữ liệu chính để lấy education
const portfolioData = inject('portfolioData'); 
</script>

<template>
    <div class="bg-white p-4 p-md-5 rounded-3 shadow mb-5">
        <h2 class="fs-3 fw-bold text-dark mb-4 border-bottom pb-2">🎓 Học vấn</h2>
        <ul class="list-unstyled d-flex gap-2">
            <li v-for="edu in portfolioData.education" :key="edu.id" class="education p-3 bg-light rounded-2 border-start border-4 border-info hover-shadow-md transition gap-2 mb-4">
                <p class="fw-bold fs-5 text-dark">{{ edu.institution }}</p>
                <p class="fw-bold fs-6 text-dark">{{ edu.degree }}</p>
                <p class="text-primary">{{ edu.institution }}</p> <p class="small text-secondary">{{ edu.period }}</p>
                <p class="small text-secondary">{{ edu.details }}</p>
                <p class="small text-secondary">{{ edu.address }}</p>
            </li>
        </ul>
    </div>
</template>

<style>
    .education{
        width: 50%;
    }
</style>