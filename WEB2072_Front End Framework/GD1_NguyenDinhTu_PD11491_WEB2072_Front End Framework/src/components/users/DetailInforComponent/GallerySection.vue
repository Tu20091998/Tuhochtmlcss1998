<script setup>
    import { computed } from 'vue';
    import { inject } from 'vue';

    // Inject dữ liệu
    const portfolioData = inject('portfolioData');

    // COMPUTED: Lấy danh sách hình ảnh
    const imageVarriant = computed(() => {
        return portfolioData.value?.personal?.imageVarriant || [];
    });
</script>

<template>
    <div class="card bg-white p-4 p-md-5 rounded-3 shadow-lg">
        <h2 class="fs-3 fw-bold text-dark mb-4 border-bottom pb-2">🖼️ Hình Ảnh Liên Quan</h2>
        <div class="row g-3">
            <div v-for="n in imageVarriant" :key="n" class="col-6 col-md-3" >
                <img 
                    :src="n" 
                    :alt="'Gallery Image ' + n" 
                    class="img-fluid rounded-3 shadow-sm transition transform-hover-scale" 
                    style="width: 20rem; height: 15rem; object-fit: cover;"
                >
            </div>
        </div>
    </div>
</template>

<style scoped>
/* CSS đặc thù cho component này */
.transition {
    transition: all 0.3s ease-in-out;
}
.transform-hover-scale {
    transition: transform 0.3s ease-in-out;
}
.transform-hover-scale:hover {
    transform: scale(1.03);
}
</style>