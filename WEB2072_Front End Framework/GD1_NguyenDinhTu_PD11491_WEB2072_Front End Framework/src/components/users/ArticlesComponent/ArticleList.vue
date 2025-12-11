<script setup>
import { computed, inject, defineEmits } from 'vue';

// Inject dữ liệu (hoặc bạn có thể truyền qua props)
const portfolioData = inject('portfolioData');

// Định nghĩa sự kiện (emit) khi người dùng chọn một bài viết
const emit = defineEmits(['selectArticle']);

const articles = computed(() => portfolioData.value?.articles || []);

// Khi người dùng click vào bài viết, phát ra sự kiện
const selectAndShowDetail = (article) => {
    emit('selectArticle', article);
};
</script>

<template>
    <div class="card p-4 p-md-5 rounded-3 shadow-lg mb-5">
        <h2 class="fs-3 fw-bold text-dark mb-4 border-bottom pb-2">📝 Các Bài Viết</h2>
        <div class="list-group list-group-flush">
            <a v-for="article in articles" 
                :key="article.id" 
                @click.prevent="selectAndShowDetail(article)"
                data-bs-toggle="modal" 
                data-bs-target="#articleDetailModal"
                class="list-group-item list-group-item-action p-4 border rounded-3 hover-shadow-md transition cursor-pointer mb-2">
                
                <h3 class="fs-5 fw-bold text-primary mb-2 hover-text-dark">{{ article.title }}</h3>
                <p class="text-secondary mt-1">{{ article.summary }}</p>
                <img :src="article.image" :alt="'Ảnh minh họa bài viết'" class="img-fluid my-3 rounded-2 shadow-sm" v-if="article.image" style="max-height: 200px; object-fit: cover;">
                <span class="small text-muted mt-2 d-block">Ngày đăng: {{ article.date }}</span>
            </a>
        </div>
    </div>
</template>

<style scoped>
/* CSS đặc thù cho list item */
.cursor-pointer {
    cursor: pointer;
}
.transition {
    transition: all 0.3s ease-in-out;
}
.hover-shadow-md:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
.hover-text-dark:hover {
    color: var(--bs-dark) !important;
}
</style>