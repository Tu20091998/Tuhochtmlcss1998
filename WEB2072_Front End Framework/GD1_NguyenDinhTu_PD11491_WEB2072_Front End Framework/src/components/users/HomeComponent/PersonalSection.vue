<script setup>
    import { computed, inject } from 'vue';

    // Inject dữ liệu
    const portfolioData = inject('portfolioData');

    // COMPUTED: Personal data
    const personalData = computed(() => {
        return portfolioData.value?.personal || { name: 'Portfolio', avatar: '', bio: '', title: '' };
    });
</script>

<template>
    <div class="row g-4 align-items-center justify-content-between bg-white p-4 p-md-5 rounded-3 shadow mb-5">
        <div class="col-md-7 order-2 mt-3">
            <h1 class="fs-2 fs-md-1 fw-bolder text-dark">
                👨‍💻 Chào, tôi là <span>{{ personalData.name }}</span>
            </h1>
            <p class="fs-5 text-primary fw-semibold">{{ personalData.title }}</p>
            <p class="text-secondary">{{ personalData.bio }}</p>
        </div>
        <div class="col-md-5 d-flex justify-content-center order-1 order-md-2">
            <img :src="personalData.avatar" :alt="'Ảnh đại diện của ' + personalData.name" class="profile-avatar rounded-circle border-4 border-primary shadow-lg">
        </div>
    </div>
</template>

<style scoped>
/* Thêm CSS đặc thù cho component này */
.profile-avatar {
    width: 12rem;
    height: 12rem;
    object-fit: cover;
    border-radius: 50%; /* rounded-circle */
}
</style>