<script setup>
import { computed, inject, ref } from 'vue';

// 1. INJECT DỮ LIỆU CẦN THIẾT
const adminData = inject('adminData');
// Đảm bảo projectsList luôn là một mảng
const projectsList = computed(() => adminData.portfolioData.value.projects || []);
const apiBaseUrl = adminData.apiBaseUrl;
const fetchData = adminData.fetchData;

// 2. TRẠNG THÁI MODAL VÀ FORM
const isModalOpen = ref(false);
const isEditMode = ref(false);
const isLoading = ref(false);
const message = ref({ type: '', text: '' }); 

const projectForm = ref({
    name: '',
    techText: '',
    members: 1,
    duration: '',
    image: '',
    description: '',
    startDate: '', 
    endDate: '', 
    id: null,
});

// Hàm chuyển đổi chuỗi ngày tháng (YYYY-MM-DD)
const convertDate = (dateString) => {
    if (!dateString) return '';
    // Lấy chuỗi YYYY-MM-DD từ ISO string hoặc chuỗi ngày tháng tương tự
    return dateString.substring(0, 10);
};

// Reset Form và Mở Modal
const openModal = (project = null) => {
    message.value = { type: '', text: '' };
    isEditMode.value = !!project;
    
    if (project) {
        let techString = Array.isArray(project.tech) ? project.tech.join(', ') : '';
        
        projectForm.value = { 
            ...project,

            techText: techString, 
            startDate: convertDate(project.startDate), 
            endDate: convertDate(project.endDate),
        };
    } else {
        // Nếu thêm mới, reset toàn bộ form
        projectForm.value = { 
            name: '', 
            techText: '', 
            members: 1, 
            duration: '', 
            image: '', 
            description: '', 
            startDate: '', 
            endDate: ''
        };
    }
    isModalOpen.value = true;
};

// Hàm chuyển đổi chuỗi tech thành mảng, loại bỏ khoảng trắng và mục rỗng
const parseTech = (text) => text.split(',').map(s => s.trim()).filter(s => s.length > 0);


// --- HÀM XỬ LÝ CRUD ĐƠN GIẢN ---

const handleSubmit = async () => {
    if (!projectForm.value.name || !projectForm.value.description) {
        message.value = { type: 'danger', text: 'Vui lòng điền Tên và Mô tả Dự án.' };
        return;
    }
    
    isLoading.value = true;
    message.value = { type: '', text: '' };

    const method = isEditMode.value ? 'PUT' : 'POST';
    const url = isEditMode.value 
        ? `${apiBaseUrl}/projects/${projectForm.value.id}`
        : `${apiBaseUrl}/projects`;
        
    
    //Chuẩn bị Payload
    // Tách form thành payload và loại bỏ techText
    const { techText, ...restOfForm } = projectForm.value;
    
    const payload = { 
        ...restOfForm,
        // Chuyển chuỗi techText (từ input) thành mảng tech (cho API)
        tech: parseTech(techText), 
    };

    try {
        const response = await fetch(url, {
            method: method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload),
        });

        if (!response.ok) {
            throw new Error(`Lỗi ${method}: ${response.status} - ${response.statusText}`);
        }

        isModalOpen.value = false;
        await fetchData(); // Tải lại dữ liệu
        message.value = { type: 'success', text: `Dự án đã được ${isEditMode.value ? 'cập nhật' : 'thêm mới'} thành công!` };

    } catch (error) {
        console.error('Lỗi khi lưu:', error);
        message.value = { type: 'danger', text: `Lỗi khi lưu: ${error.message}` };
    } finally {
        isLoading.value = false;
    }
};

const handleDelete = async (id) => {
    if (!confirm('Bạn có chắc chắn muốn xóa dự án này không?')) return;
    
    message.value = { type: '', text: '' };
    try {
        const response = await fetch(`${apiBaseUrl}/projects/${id}`, { method: 'DELETE' });

        if (!response.ok) {
            const errorText = await response.text();
            throw new Error(`Xóa thất bại. Status: ${response.status}. Chi tiết: ${errorText}`);
        }
        
        await fetchData();
        message.value = { type: 'success', text: 'Đã xóa dự án thành công!' };

    } catch (error) {
        console.error('Lỗi khi xóa:', error);
        message.value = { type: 'danger', text: `Lỗi khi xóa: ${error.message}` };
    }
};
</script>

<template>
    <div class="projects-management">
        <h2 class="mb-4 text-primary fw-bold">🏗️ Quản Lý Dự Án</h2>
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div style="min-height: 38px;">
                <div v-if="message.text" :class="`alert alert-${message.type} p-2 m-0`" role="alert">
                    {{ message.text }}
                </div>
            </div>

            <button @click="openModal()" class="btn btn-primary fw-bold ms-auto">
                <i class="bi bi-plus-lg me-2"></i> Thêm Dự Án
            </button>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div v-if="projectsList.length === 0" class="alert alert-info">
                    Chưa có dự án nào được thêm.
                </div>
                <div v-else class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Tên Dự Án</th>
                                <th>Công Nghệ</th>
                                <th>Thành viên</th>
                                <th>Thời hạn</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="proj in projectsList" :key="proj.id">
                                <td>{{ proj.name }}</td>
                                <td>
                                    {{ Array.isArray(proj.tech) ? proj.tech.join(', ') : (proj.tech || 'N/A')}}
                                </td>
                                <td>{{ proj.members }}</td>
                                <td>{{ proj.duration }}</td>
                                <td class="text-nowrap">
                                    <button @click="openModal(proj)" class="btn btn-sm btn-warning me-2">Sửa</button>
                                    <button @click="handleDelete(proj.id)" class="btn btn-sm btn-danger">Xóa</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div v-if="isModalOpen" class="custom-backdrop show" @click="isModalOpen = false">
            <div class="modal d-block" tabindex="-1">
                <div class="modal-dialog modal-lg" @click.stop>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ isEditMode ? 'Chỉnh Sửa Dự Án' : 'Thêm Dự Án Mới' }}</h5>
                            <button type="button" class="btn-close" @click="isModalOpen = false"></button>
                        </div>
                        <form @submit.prevent="handleSubmit">
                            <div class="modal-body">
                                <div v-if="message.type === 'danger'" :class="`alert alert-${message.type}`">{{ message.text }}</div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Tên Dự Án:</label>
                                    <input type="text" v-model="projectForm.name" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Công nghệ (Ngăn cách bằng dấu phẩy):</label>
                                    <input type="text" v-model="projectForm.techText" class="form-control" placeholder="Vue 3, Bootstrap 5, PHP, API Resful">
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Số thành viên:</label>
                                        <input type="number" v-model="projectForm.members" class="form-control" min="1">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Thời hạn (ví dụ: 4 tháng):</label>
                                        <input type="text" v-model="projectForm.duration" class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">URL Hình ảnh đại diện:</label>
                                        <input type="url" v-model="projectForm.image" class="form-control">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Ngày bắt đầu:</label>
                                        <input type="date" v-model="projectForm.startDate" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Ngày kết thúc:</label>
                                        <input type="date" v-model="projectForm.endDate" class="form-control">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Mô tả Dự án:</label>
                                    <textarea v-model="projectForm.description" class="form-control" rows="3" required></textarea>
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
/* CSS cho Modal (Dùng lại) */
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
    top: 50%; /* Đặt modal ở giữa */
    left: 50%;
    transform: translate(-50%, -50%); /* Dịch chuyển để căn giữa hoàn toàn */
    z-index: 1060; 
    max-height: 90vh; /* Giới hạn chiều cao */
    overflow-y: auto; /* Thêm scroll nếu cần */
}
.modal-content {
    background-color: #fff; 
    border-radius: 0.5rem;
}
/* Thêm style cho phần hiển thị alert để giữ bố cục */
.d-flex > div:first-child {
    flex-grow: 1; 
}
</style>