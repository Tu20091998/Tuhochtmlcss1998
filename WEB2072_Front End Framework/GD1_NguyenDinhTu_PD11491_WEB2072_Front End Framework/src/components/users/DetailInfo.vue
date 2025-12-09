<script setup>
    import { computed } from 'vue';
    import { inject } from 'vue';

    // Inject dữ liệu
    const portfolioData = inject('portfolioData');

    
    // COMPUTED: Personal data được bảo vệ và sẵn sàng sử dụng
    const personalData = computed(() => {
        return portfolioData.value?.personal || { name: 'Portfolio', avatar: '', bio: '', title: '', hardSkills: [], softSkills: [] };
    });
</script>

<template>
    <section class="container-fluid max-width-center pt-3">
        <h1 class="fs-2 fw-bold text-dark text-center mb-5">Thông Tin Cá Nhân Chi Tiết</h1>

        <!-- Phần Thông tin -->
        <div class="card p-4 p-md-5 rounded-3 shadow-lg mb-5">
            <div class="row g-4 align-items-center">
                
                <!-- Cột Avatar -->
                <div class="col-12 col-lg-4 d-flex justify-content-center">
                    <img :src="personalData.avatar" :alt="'Ảnh đại diện của ' + personalData.name" class="profile-avatar rounded-circle border-4 border-primary shadow-lg">
                </div>
                
                <!-- Cột Chi tiết -->
                <div class="col-12 col-lg-8">
                    <!-- Tên và chức danh -->
                    <h2 class="fs-1 fw-bold mb-2">{{ personalData.name }}</h2>
                    <p class="fs-5 text-secondary mb-4">{{ personalData.title }}</p>
                    
                    <!-- Thông tin liên hệ chi tiết -->
                    <div class="list-group list-group-flush small">
                        <div class="list-group-item d-flex border-0 px-0">
                            <span class="fw-semibold w-25">Email:</span> 
                            <a :href="'mailto:' + personalData.email" class="text-primary hover-text-dark">{{ portfolioData.personal.email }}</a>
                        </div>
                        <div class="list-group-item d-flex border-0 px-0">
                            <span class="fw-semibold w-25">Điện thoại:</span> 
                            <span>{{ personalData.phone }}</span>
                        </div>
                        <div class="list-group-item d-flex border-0 px-0">
                            <span class="fw-semibold w-25">Địa chỉ:</span> 
                            <span>{{ personalData.address }}</span>
                        </div>
                        <div class="list-group-item d-flex border-0 px-0">
                            <span class="fw-semibold w-25">Giới thiệu:</span> 
                            <span>{{ personalData.bio }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Phần Gallery Hình ảnh -->
        <div class="card bg-white p-4 p-md-5 rounded-3 shadow-lg">
            <h2 class="fs-3 fw-bold text-dark mb-4 border-bottom pb-2">Gallery Hình Ảnh Liên Quan</h2>
            <div class="row g-3">
                <div v-for="n in personalData.imageVarriant" :key="n" class="col-6 col-md-3" >
                    <img :src="'' + n" :alt="'Gallery Image ' + n" class="img-fluid rounded-3 shadow-sm transition transform-hover-scale" style="width: 20rem; height: 15rem;">
                </div>
            </div>
        </div>
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