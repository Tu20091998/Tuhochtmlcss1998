<script setup>
    import { computed, inject } from 'vue';

    // Import các component con
    import EducationDetails from './SkillsComponent/EducationDetails.vue';
    import SkillsDetails from './SkillsComponent/SkillsDetails.vue';
    import ProjectsList from './SkillsComponent/ProjectsList.vue';

    // Inject dữ liệu (vẫn giữ ở đây nếu muốn)
    const portfolioData = inject('portfolioData');

    // Mặc dù không sử dụng trong template này, bạn có thể giữ nếu cần logic ở đây
    const featuredArticles = computed(() => portfolioData.value?.articles || []); 
</script>

<template>
    <section class="container-fluid max-width-center pt-3 g-5">
        <h1 class="fs-2 fw-bold text-dark text-center mb-5" style="margin-top: 5rem;"><i class="bi bi-tools"></i> Kĩ Năng & Kinh Nghiệm Phát Triển</h1>
        <EducationDetails />
        <SkillsDetails />
        <ProjectsList />
    </section>
</template>

<style scoped>
/* Chỉ giữ lại style layout chính */
.max-width-center {
    max-width: 1280px;
    margin-left: auto;
    margin-right: auto;
}
</style>