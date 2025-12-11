<script setup>
    import { computed, inject } from 'vue';

    // Inject dữ liệu
    const portfolioData = inject('portfolioData');

    const featuredArticles = computed(() => portfolioData.value?.articles || []);
</script>

<template>
    <div class="bg-white p-4 p-md-5 rounded-3 shadow mb-5">
        <h2 class="fs-3 fw-bold text-dark mb-4 border-bottom pb-2">📝 Bài viết nổi bật</h2>
        <div class="row g-4">
            <div v-for="article in featuredArticles" :key="article.id" class="col-md-6">
                <div class="card p-3 shadow-sm hover-shadow-lg cursor-pointer transition h-100">
                    <div class="card-body p-0">
                        <h3 class="fs-5 fw-bold text-primary mb-2 hover-text-dark">{{ article.title }}</h3>
                        <p class="text-secondary small">{{ article.summary }}</p>
                        <span class="small text-muted mt-2 d-block">Ngày đăng: {{ article.date }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-4 text-center">
            <router-link
                :to="{name: 'Articles'}"
                class="btn btn-link text-primary hover-text-dark fw-medium transition">
                Xem tất cả bài viết &rarr;
            </router-link>
        </div>
    </div>
</template>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}
.transition {
    transition: all 0.3s ease-in-out;
}
.hover-text-dark:hover {
    color: var(--bs-dark) !important;
}
.hover-shadow-lg:hover {
    box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important; /* shadow-xl */
}
</style>