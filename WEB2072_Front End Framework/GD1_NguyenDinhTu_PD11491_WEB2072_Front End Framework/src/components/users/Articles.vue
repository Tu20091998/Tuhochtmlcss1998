<script setup>
import { ref } from 'vue';
// Import các component con
import ArticleList from './ArticlesComponent/ArticleList.vue'; 
import ArticleDetailModal from './ArticlesComponent/ArticleDetailModal.vue';

// Sử dụng ref để lưu trữ bài viết đang được chọn
const selectedArticle = ref(null);

// Hàm mở Modal và lưu trữ bài viết được chọn
const handleArticleSelection = (article) => {
    selectedArticle.value = article;
};
</script>

<template>
    <section class="container-fluid max-width-center pt-3">
        <h1 class="fs-2 fw-bold text-dark text-center mb-5" style="margin-top: 5rem;"><i class="bi bi-newspaper me-2"></i> Danh Sách Bài Viết Công Nghệ</h1>
        
        <ArticleList @select-article="handleArticleSelection" />

        <ArticleDetailModal :article="selectedArticle" />
        
        <div class="mt-5 text-center">
            <h2 class="fs-4 fw-bold text-dark mb-3">Tham Khảo Thêm Từ Các Nguồn Uy Tín</h2>
            <p class="text-muted">Đọc thêm tin tức và phân tích công nghệ chuyên sâu từ các trang báo hàng đầu.</p>
            <div class="d-flex justify-content-center flex-wrap gap-4 pt-3 pb-5">
                <a href="https://vnexpress.net/khoa-hoc" target="_blank" class="btn btn-outline-primary">VnExpress Khoa học</a>
                <a href="https://techcrunch.com/" target="_blank" class="btn btn-outline-primary">TechCrunch</a>
                <a href="https://theverge.com/" target="_blank" class="btn btn-outline-primary">The Verge</a>
                <a href="https://ictnews.vietnamnet.vn/" target="_blank" class="btn btn-outline-primary">VietnamNet ICT</a>
                <a href="https://genk.vn/" target="_blank" class="btn btn-outline-primary">GenK</a>
            </div>
        </div>
    </section>
</template>

<style scoped>
.max-width-center {
    max-width: 1280px;
    margin-left: auto;
    margin-right: auto;
}
</style>