<script setup lang="ts">
const props = defineProps({
    data: { type: Object as () => any, required: true },
});

// Tính toán số liệu thống kê đơn giản
const totalProjects = props.data.projects?.length || 0;
const totalArticles = props.data.articles?.length || 0;
const totalEducation = props.data.education?.length || 0;
</script>

<template>
    <div class="container-fluid">
        <h2 class="mb-4 text-primary">Tổng quan Dữ liệu</h2>
        <div class="row g-4">
            
            <div class="col-md-4">
                <div class="card p-3 shadow-sm border-start border-4 border-info">
                    <div class="card-body">
                        <h5 class="card-title text-info">Dự án đã hoàn thành</h5>
                        <p class="card-text fs-2 fw-bold">{{ totalProjects }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3 shadow-sm border-start border-4 border-success">
                    <div class="card-body">
                        <h5 class="card-title text-success">Bài viết/Blog</h5>
                        <p class="card-text fs-2 fw-bold">{{ totalArticles }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3 shadow-sm border-start border-4 border-warning">
                    <div class="card-body">
                        <h5 class="card-title text-warning">Mục Học vấn</h5>
                        <p class="card-text fs-2 fw-bold">{{ totalEducation }}</p>
                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="mt-5 p-4 bg-white rounded shadow-sm">
            <h3 class="fs-5 text-secondary">Thông tin cơ bản</h3>
            <p><strong>Xin chào, {{ data.personal.name }}!</strong></p>
            <p>Sử dụng menu bên trái để quản lý và cập nhật nội dung Portfolio của bạn.</p>
        </div>
    </div>
</template>