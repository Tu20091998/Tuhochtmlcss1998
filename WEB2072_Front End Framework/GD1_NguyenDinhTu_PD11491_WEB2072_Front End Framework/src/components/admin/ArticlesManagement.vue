<script setup>
import { computed, inject, ref } from 'vue';

// INJECT DỮ LIỆU CẦN THIẾT
const adminData = inject('adminData');
const articlesList = computed(() => adminData.portfolioData.value.articles);
const apiBaseUrl = adminData.apiBaseUrl;
const fetchData = adminData.fetchData;

// TRẠNG THÁI MODAL VÀ FORM
const isModalOpen = ref(false);
const isEditMode = ref(false);
const isLoading = ref(false);
const message = ref({ type: '', text: '' });

const articleForm = ref({
    _id: null,
    title: '',
    summary: '',
    content: '',
    date: new Date().toISOString().substring(0, 10), // Đặt ngày mặc định
    image: '',
    status: 'Draft', // Mặc định là Bản nháp
});


// Reset Form và Mở Modal
const openModal = (article = null) => {
    message.value = { type: '', text: '' };
    
    if (article) {
        // Nếu chỉnh sửa, điền dữ liệu vào form
        articleForm.value = { ...article };

        // Đảm bảo trường date là chuỗi YYYY-MM-DD nếu cần hiển thị trong input type="date"
        if (article.date) {
            const [day, month, year] = article.date.split('/');
            articleForm.value.date = `${year}-${month}-${day}`;
        }

        //chuyển sang true vì là cập nhật
        isEditMode.value = true;
    } else {
        // Nếu thêm mới
        articleForm.value = { 
            title: '', 
            summary: '', 
            content: '', 
            image: '', 
            status: 'Draft', 
            date: new Date().toISOString().substring(0, 10) 
        };

        //không phải cập nhật
        isEditMode.value = false;
    }
    isModalOpen.value = true;
};


//hàm khi nhấn thì cập nhật hoặc thêm mới
const handleSubmit = async () => {
    if (!articleForm.value.title || !articleForm.value.content) {
        message.value = { type: 'danger', text: 'Vui lòng điền Tiêu đề và Nội dung bài viết.' };
        return;
    }

    isLoading.value = true;
    message.value = { type: '', text: '' };

    const method = isEditMode.value ? 'PUT' : 'POST';
    const url = isEditMode.value 
        ? `${apiBaseUrl}/articles/${articleForm.value.id}`
        : `${apiBaseUrl}/articles`;

    // Chuẩn bị Payload
    const payload = { ...articleForm.value };
    
    // Định dạng lại ngày tháng trước khi gửi (từ YYYY-MM-DD sang DD/MM/YYYY)
    if (payload.date) {
        const [year, month, day] = payload.date.split('-');
        payload.date = `${day}/${month}/${year}`;
    }

    try {
        const response = await fetch(url, {
            method: method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload),
        });

        if (!response.ok) {
            throw new Error(`Lỗi ${method}: ${response.status}`);
        }

        isModalOpen.value = false;
        await fetchData(); // Tải lại dữ liệu
        message.value = { type: 'success', text: `Bài viết đã được ${isEditMode.value ? 'cập nhật' : 'thêm mới'} thành công!` };

    } catch (error) {
        console.error('Lỗi khi lưu:', error);
        message.value = { type: 'danger', text: `Lỗi: ${error.message}` };
    } finally {
        isLoading.value = false;
    }
};

//hàm xoá bài viết
const handleDelete = async (id) => {
    if (!confirm('Bạn có chắc chắn muốn xóa bài viết này không?')) return;
    
    console.log(id);
    message.value = { type: '', text: '' };
    try {
        const response = await fetch(`${apiBaseUrl}/articles/${id}`, { method: 'DELETE' });

        if (!response.ok) {
            const errorText = await response.text();
            throw new Error(`Xóa thất bại. Status: ${response.status}. Chi tiết: ${errorText}`);
        }
        
        await fetchData();
        message.value = { type: 'success', text: 'Đã xóa bài viết thành công!' };

    } catch (error) {
        console.error('Lỗi khi xóa:', error);
        message.value = { type: 'danger', text: `Lỗi khi xóa: ${error.message}` };
    }
};
</script>

<template>
    <div class="articles-management">
        <h2 class="mb-4 text-dark fw-bold">📝 Quản Lý Bài Viết</h2>
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div v-if="message.text" :class="`alert alert-${message.type} p-2 m-0`">
                {{ message.text }}
            </div>
            <div v-else></div>

            <button @click="openModal()" class="btn btn-primary fw-bold">
                <i class="bi bi-plus-lg me-2"></i> Thêm Bài Viết
            </button>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div v-if="articlesList.length === 0" class="alert alert-info">
                    Chưa có bài viết nào được thêm.
                </div>
                <table v-else class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Tiêu đề</th>
                            <th>Trạng thái</th>
                            <th>Ngày đăng</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="article in articlesList" :key="article._id">
                            <td>{{ article.title }}</td>
                            <td>
                                <span :class="{'badge bg-success': article.status === 'Published', 'badge bg-secondary': article.status === 'Draft'}">
                                    {{ article.status }}
                                </span>
                            </td>
                            <td>{{ article.date }}</td>
                            <td>
                                <button @click="openModal(article)" class="btn btn-sm btn-warning me-2">Sửa</button>
                                <button @click="handleDelete(article.id)" class="btn btn-sm btn-danger">Xóa</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div v-if="isModalOpen" class="custom-backdrop show" @click="isModalOpen = false">
            <div class="modal d-block" tabindex="-1">
                <div class="modal-dialog modal-lg" @click.stop>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ isEditMode ? 'Chỉnh Sửa Bài Viết' : 'Thêm Bài Viết Mới' }}</h5>
                            <button type="button" class="btn-close" @click="isModalOpen = false"></button>
                        </div>
                        <form @submit.prevent="handleSubmit">
                            <div class="modal-body">
                                <div v-if="message.type === 'danger'" :class="`alert alert-${message.type}`">{{ message.text }}</div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Tiêu đề:</label>
                                    <input type="text" v-model="articleForm.title" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tóm tắt:</label>
                                    <textarea v-model="articleForm.summary" class="form-control" rows="2"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nội dung chi tiết:</label>
                                    <textarea v-model="articleForm.content" class="form-control" rows="5" required></textarea>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">URL Hình ảnh đại diện:</label>
                                        <input type="url" v-model="articleForm.image" class="form-control">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Ngày đăng:</label>
                                        <input type="date" v-model="articleForm.date" class="form-control">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Trạng thái:</label>
                                        <select v-model="articleForm.status" class="form-select">
                                            <option value="Published">Published</option>
                                            <option value="Draft">Draft</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="isModalOpen = false">Hủy</button>
                                <button type="submit" class="btn btn-primary" :disabled="isLoading">
                                    <span v-if="isLoading" class="spinner-border spinner-border-sm me-2"></span>
                                    {{ isEditMode ? 'Lưu Thay Đổi' : 'Thêm Mới' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* CSS cho Modal (Đảm bảo z-index và background color) */
.custom-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1050;
}
.modal {
    position: fixed;
    top: 10%;
    left: 50%;
    transform: translate(-50%, -10%);
    z-index: 1060;
}
.modal-content {
    background-color: #fff;
    border-radius: 0.5rem;
}
.text-dark {
    color: #212529 !important;
}
</style>