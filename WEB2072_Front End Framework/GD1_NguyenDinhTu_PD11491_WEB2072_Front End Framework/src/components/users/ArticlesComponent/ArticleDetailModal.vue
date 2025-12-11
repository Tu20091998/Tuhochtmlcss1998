<script setup>
import { defineProps } from 'vue';

// Định nghĩa props để nhận dữ liệu bài viết được chọn
const props = defineProps({
    article: {
        type: Object,
        default: null,
    }
});
</script>

<template>
    <div class="modal fade" id="articleDetailModal" aria-labelledby="articleDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content" v-if="article">
                
                <div class="modal-header">
                    <h5 class="modal-title fs-5 fw-bold text-primary" id="articleDetailModalLabel">{{ article.title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <p class="small text-muted mb-3">Ngày đăng: {{ article.date }}</p>
                    <p class="fs-6 fw-medium text-secondary mb-4">{{ article.summary }}</p>
                    <img :src="article.image" :alt="'Ảnh minh họa bài viết'" class="img-fluid mb-4 rounded-2 shadow-sm" v-if="article.image" style="max-height: 200px; object-fit: cover;">
                    
                    <div class="article-content text-dark">
                        <p>Đây là phần nội dung chi tiết của bài viết <strong>"{{ article.title }}"</strong>.</p>
                        <p>{{ article.content }}</p>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</template>