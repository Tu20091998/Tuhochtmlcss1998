<script setup>
import { computed, inject } from 'vue';

// Inject dữ liệu
const portfolioData = inject('portfolioData');

// Lấy danh sách bài viết từ dữ liệu đã inject
const articles = computed(() => portfolioData.value?.articles || []);

</script>

<template>
    <section class="container-fluid max-width-center pt-3 mt-3">
        <h1 class="fs-2 fw-bold text-dark text-center mb-5" style="margin-top: 5rem;"><i class="bi bi-newspaper me-2"></i> Danh Sách Bài Viết Công Nghệ</h1>
    
        <div class="row g-4">
            <div class="col-12 col-md-6 col-lg-4" v-for="article in articles" :key="article.id">
                <router-link
                    :to="{ name: 'ArticleDetail', params: { article_id: article.id } }" 
                    class="card h-100 shadow-sm text-decoration-none text-dark article-card"
                >
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ article.title }}</h5>
                        <p class="card-text text-muted">{{ article.summary }}</p>
                    </div>
                    <div class="mb-5 article-image-container">
                        <img 
                            :src="article.image" 
                            :alt="article.title" 
                            class="img-fluid rounded shadow-sm"
                        >
                    </div>
                    <div class="card-footer small text-end">
                        <span class="text-primary fw-medium">Xem chi tiết <i class="bi bi-arrow-right"></i></span>
                    </div>
                </router-link>
            </div>
            <div v-if="articles.length === 0" class="col-12 text-center py-5">
                <p class="text-muted">Không tìm thấy bài viết nào.</p>
            </div>
        </div>
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
    .article-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1px solid #dee2e6;
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
        border-radius: 0.5rem;
        overflow: hidden;
        text-decoration: none;
        cursor: pointer;
    }
    .article-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>