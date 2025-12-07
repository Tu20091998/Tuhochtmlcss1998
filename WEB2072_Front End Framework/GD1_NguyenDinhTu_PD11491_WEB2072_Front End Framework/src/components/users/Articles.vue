<script setup>
    import { computed ,ref} from 'vue';
    import { inject } from 'vue';

    // ✅ Inject dữ liệu
    const portfolioData = inject('portfolioData');
    
    // Sử dụng ref để lưu trữ bài viết đang được chọn
    const selectedArticle = ref(null);
    
    // Hàm mở Modal và lưu trữ bài viết được chọn
    const showArticleDetail = (article) => {
        selectedArticle.value = article;
    };
</script>

<template>
    <section class="container-fluid max-width-center pt-3">
        <h1 class="fs-2 fw-bold text-dark text-center mb-5">Danh Sách Bài Viết Công Nghệ</h1>
        
        <!-- Danh sách bài viết -->
        <div class="card p-4 p-md-5 rounded-3 shadow-lg mb-5">
            <h2 class="fs-3 fw-bold text-dark mb-4 border-bottom pb-2">Các Bài Viết</h2>
            <div class="list-group list-group-flush">
                <a v-for="article in portfolioData.articles" 
                    :key="article.id" 
                    href="#"
                    @click.prevent="showArticleDetail(article)"

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

        <!-- Modal Chi Tiết Bài Viết (Bootstrap Modal) -->
        <div class="modal fade" id="articleDetailModal" aria-labelledby="articleDetailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content" v-if="selectedArticle">
                    
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title fs-5 fw-bold text-primary" id="articleDetailModalLabel">{{ selectedArticle.title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <p class="small text-muted mb-3">Ngày đăng: {{ selectedArticle.date }}</p>
                        <p class="fs-6 fw-medium text-secondary mb-4">{{ selectedArticle .summary }}</p>
                        <img :src="selectedArticle.image" :alt="'Ảnh minh họa bài viết'" class="img-fluid mb-4 rounded-2 shadow-sm" v-if="selectedArticle.image" style="max-height: 200px; object-fit: cover;">
                        
                        <!-- Nội dung chi tiết -->
                        <div class="article-content text-dark">
                            <p>Đây là phần nội dung chi tiết của bài viết <strong>"{{ selectedArticle.title }}"</strong>.</p>
                            <p>{{ selectedArticle.content }}</p>
                        </div>
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
/* Tái sử dụng CSS thuần từ các component khác */
.max-width-center {
    max-width: 1280px;
    margin-left: auto;
    margin-right: auto;
}
.cursor-pointer {
    cursor: pointer;
}
.transition {
    transition: all 0.3s ease-in-out;
}
.hover-shadow-md:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important; /* shadow-md */
}
.hover-text-dark:hover {
    color: var(--bs-dark) !important;
}
</style>