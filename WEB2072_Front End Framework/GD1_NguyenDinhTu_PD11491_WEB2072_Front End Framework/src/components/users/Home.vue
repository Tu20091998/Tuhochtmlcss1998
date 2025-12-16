<script setup>
    import { computed, ref, onMounted, onUnmounted } from 'vue';
    import { inject } from 'vue';
    import { useRoute } from 'vue-router';

    // Import các component con
    import ArticlesSection from './HomeComponent/ArticlesSection.vue';
    import EducationSection from './HomeComponent/EducationSection.vue';
    import ExperienceSection from './HomeComponent/ExperienceSection.vue';
    import PersonalSection from './HomeComponent/PersonalSection.vue';
    import ProjectsList from './SkillsComponent/ProjectsList.vue';

    //dùng lại component
    import SkillsDetails from './SkillsComponent/SkillsDetails.vue';

    // Inject dữ liệu
    const portfolioData = inject('portfolioData');

    // COMPUTED: Personal data được bảo vệ và sẵn sàng sử dụng
    const personalData = computed(() => {
        return portfolioData.value?.personal || { name: 'Portfolio', avatar: '', bio: '', title: '', hardSkills: [], softSkills: [] };
    });

    const featuredArticles = computed(() => portfolioData.value?.articles || []);

</script>

<template>
        <section class="container-fluid max-width-center g-5" style="margin-top: 10rem;">
            <PersonalSection />
            <EducationSection />
            <ExperienceSection />
            <ArticlesSection />
            <ProjectsList />
        </section>
</template>
<style scoped>
/* Định nghĩa các lớp CSS thuần (Nên chuyển sang file style.css để dùng chung) */
.max-width-center {
    max-width: 1280px;
    margin-left: auto;
    margin-right: auto;
}
</style>