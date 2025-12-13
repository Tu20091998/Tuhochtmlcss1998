<script setup>
import { computed, inject } from 'vue';
import { useRoute } from 'vue-router'; 

// Lấy đối tượng route hiện tại
const route = useRoute(); 

// INJECT DỮ LIỆU
const portfolioData = inject('portfolioData');

// LẤY ID TỪ ROUTE.PARAMS
const articleId = computed(() => route.params.article_id); 

// Lấy danh sách bài viết từ dữ liệu đã inject
const allArticles = computed(() => portfolioData.value?.articles || []);

// Dùng computed property để tìm bài viết tương ứng
const article = computed(() => {
    // lấy id bài viết ở đường dẫn route
    const idToFind = articleId.value; 
    
    // nếu id bài viết (inject) trùng với id bài viết (route)
    return allArticles.value.find(a => a.id === idToFind);
});

</script>

<style scoped>
.max-width-center {
    max-width: 960px;
    margin-left: auto;
    margin-right: auto;
}
.article-content :deep(p), .article-content :deep(h2) {
    line-height: 1.8;
    font-size: 1.15rem;
    margin-bottom: 1.5rem;
}
</style>

<template>
    <div class="container-fluid max-width-center pt-5 pb-5" style="margin-top: 5rem;">
        <button @click="$router.go(-1)" class="btn btn-lg btn-outline-secondary mb-5">
            <i class="bi bi-arrow-left me-2"></i> Quay lại Danh sách Bài viết
        </button>

        <div v-if="article">
            <h3 class="display-5 fw-bold text-dark mb-3">{{ article.title }}</h3>
            <p class="text-muted small mb-5">
                Ngày đăng: <strong>{{ article.date }}</strong> | Trạng thái: <strong>{{ article.status }}</strong>
            </p>
            <hr>
            <div class="mb-5 article-image-container">
                <img 
                    :src="article.image" 
                    :alt="article.title" 
                    class="img-fluid rounded shadow-sm"
                >
            </div>
            <div class="article-content mt-5">
                <div v-html="article.content"></div>
            </div>
            
        </div>
        <div v-else class="alert alert-danger text-center py-5">
            <h2 class="fw-bold">Lỗi: Không tìm thấy Bài viết</h2>
            <p>Bài viết có ID: **{{ id }}** không tồn tại trong hệ thống hoặc dữ liệu chưa được tải.</p>
        </div>
    </div>
</template>

