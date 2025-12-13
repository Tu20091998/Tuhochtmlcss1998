<script setup>
    import { computed } from 'vue';
    import { inject } from 'vue';
    import PersonalDetailsCard from './DetailInforComponent/PersonalDetailsCard.vue';
    import GallerySection from './DetailInforComponent/GallerySection.vue';

    // Inject dữ liệu
    const portfolioData = inject('portfolioData');

    
    // COMPUTED: Personal data được bảo vệ và sẵn sàng sử dụng
    const personalData = computed(() => {
        return portfolioData.value?.personal || { name: 'Portfolio', avatar: '', bio: '', title: '', hardSkills: [], softSkills: [] };
    });
</script>

<template>
    <section class="container-fluid max-width-center pt-3 mt-3">
        <h1 class="fs-2 fw-bold text-dark text-center mb-5" style="margin-top: 5rem;"><i class="bi bi-person-lines-fill me-2"></i> Thông Tin Cá Nhân Chi Tiết</h1>
        <PersonalDetailsCard />
        <GallerySection />
    </section>
</template>

<style scoped>
/* Tái sử dụng CSS thuần từ Home.vue và Header.vue */
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
    /* Dùng border-4 border-primary shadow-lg của Bootstrap */
}
.hover-text-dark:hover {
    color: var(--bs-dark) !important;
}
.transition {
    transition: all 0.3s ease-in-out;
}
.transform-hover-scale {
    transition: transform 0.3s ease-in-out;
}
.transform-hover-scale:hover {
    transform: scale(1.03);
}

.list-group{
    text-align: left;
}
</style>