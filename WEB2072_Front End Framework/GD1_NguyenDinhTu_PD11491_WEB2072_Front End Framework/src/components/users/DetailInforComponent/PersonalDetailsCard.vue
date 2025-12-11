<script setup>
    import { computed } from 'vue';
    import { inject } from 'vue';

    // Inject dữ liệu
    const portfolioData = inject('portfolioData');

    // COMPUTED: Personal data được bảo vệ và sẵn sàng sử dụng
    const personalData = computed(() => {
        // Cung cấp các trường cần thiết trong fallback để tránh lỗi
        return portfolioData.value?.personal || { 
            name: 'Portfolio', avatar: '', title: '', email: '', phone: '', address: '', bio: '' 
        };
    });
</script>

<template>
    <div class="card p-4 p-md-5 rounded-3 shadow-lg mb-5">
        <div class="row g-4 align-items-center">
            
            <div class="col-12 col-lg-4 d-flex justify-content-center">
                <img 
                    :src="personalData.avatar" 
                    :alt="'Ảnh đại diện của ' + personalData.name" 
                    class="profile-avatar rounded-circle border-4 border-primary shadow-lg"
                >
            </div>
            
            <div class="col-12 col-lg-8">
                <h2 class="fs-1 fw-bold mb-2">{{ personalData.name }}</h2>
                <p class="fs-5 text-secondary mb-4">👨‍💻 {{ personalData.title }}</p>
                
                <div class="list-group list-group-flush small">
                    <div class="list-group-item d-flex border-0 px-0">
                        <span class="fw-semibold w-25">Email:</span> 
                        <a :href="'mailto:' + personalData.email" class="text-primary hover-text-dark">{{ personalData.email }}</a>
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
</template>

<style scoped>
/* CSS đặc thù cho component này */
.profile-avatar {
    width: 20rem;
    height: 20rem;
    object-fit: cover;
}
.hover-text-dark:hover {
    color: var(--bs-dark) !important;
}
.list-group {
    text-align: left;
}
</style>