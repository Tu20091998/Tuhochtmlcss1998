<script setup>
import { computed, inject, ref } from 'vue';

const adminData = inject('adminData');
const portfolioData = adminData.portfolioData;
const apiBaseUrl = adminData.apiBaseUrl;
const fetchData = adminData.fetchData;

// Lấy danh sách Học vấn (READ)
const educationList = computed(() => portfolioData.value.education);

// --- TRẠNG THÁI & FORM MODAL ---
const isModalOpen = ref(false);
const isEditMode = ref(false); // true: Edit, false: Create
const currentEducationId = ref(null);
const isLoading = ref(false);
const errorMessage = ref('');

const educationForm = ref({
    institution: '',
    address: '',
    degree: '',
    period: '',
    details: '',
});

// Reset Form
const resetForm = () => {
    educationForm.value = { institution: '', address: '', degree: '', period: '', details: '' };
    isEditMode.value = false;
    currentEducationId.value = null;
    errorMessage.value = '';
};

// Mở Modal cho việc Thêm mới
const openCreateModal = () => {
    resetForm();
    isModalOpen.value = true;
};

// Mở Modal cho việc Chỉnh sửa
const openEditModal = (education) => {
    resetForm();
    isEditMode.value = true;
    currentEducationId.value = education.id;

    // Điền dữ liệu hiện tại vào form
    educationForm.value = { ...education };
    isModalOpen.value = true;
};

// --- XỬ LÝ CRUD ---

// Xử lý Thêm mới và Cập nhật (POST / PUT)
const handleSubmit = async () => {
    if (!educationForm.value.institution || !educationForm.value.degree) {
        errorMessage.value = 'Vui lòng điền tên cơ sở và bằng cấp.';
        return;
    }
    
    isLoading.value = true;
    errorMessage.value = '';

    const method = isEditMode.value ? 'PUT' : 'POST';
    const url = isEditMode.value 
        ? `${apiBaseUrl}/education/${currentEducationId.value}`
        : `${apiBaseUrl}/education`;
        
    // Tạo bản sao form và thêm id nếu đang tạo mới (JSON Server sẽ tự thêm id)
    const payload = isEditMode.value
        ? { id: currentEducationId.value, ...educationForm.value } 
        : educationForm.value;

    try {
        const response = await fetch(url, {
            method: method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload),
        });

        if (!response.ok) {
            throw new Error('Lỗi khi lưu dữ liệu học vấn.');
        }

        isModalOpen.value = false;
        await fetchData(); // Tải lại dữ liệu toàn cục
        alert(`Đã ${isEditMode.value ? 'cập nhật' : 'thêm mới'} mục Học vấn thành công!`);

    } catch (error) {
        console.error('Lỗi khi lưu:', error);
        errorMessage.value = `Lỗi: ${error.message}`;
    } finally {
        isLoading.value = false;
    }
};

// Xử lý Xóa (DELETE)
const handleDelete = async (id) => {
    if (!confirm('Bạn có chắc chắn muốn xóa mục Học vấn này không?')) return;
    
    try {
        const response = await fetch(`${apiBaseUrl}/education/${id}`, { method: 'DELETE' });

        if (!response.ok) {
            throw new Error('Xóa thất bại.');
        }
        
        await fetchData(); // Tải lại dữ liệu toàn cục
        alert('Đã xóa mục Học vấn thành công!');

    } catch (error) {
        console.error('Lỗi khi xóa:', error);
        alert(`Lỗi khi xóa: ${error.message}`);
    }
};
</script>

<template>
    <div class="education-management">
        <h2 class="mb-4 text-dark fw-bold">Quản Lý Học Vấn</h2>
        
        <div class="d-flex justify-content-end mb-3">
            <button @click="openCreateModal" class="btn btn-primary fw-bold">
                <i class="bi bi-plus-lg me-2"></i> Thêm Học Vấn
            </button>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div v-if="educationList.length === 0" class="alert alert-info">
                    Chưa có mục Học vấn nào được thêm.
                </div>
                <table v-else class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cơ Sở</th>
                            <th>Bằng Cấp</th>
                            <th>Thời Gian</th>
                            <th>Chi Tiết</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="edu in educationList" :key="edu.id">
                            <td>{{ edu.id }}</td>
                            <td>{{ edu.institution }}</td>
                            <td>{{ edu.degree }}</td>
                            <td>{{ edu.period }}</td>
                            <td>{{ edu.details }}</td>
                            <td>
                                <button @click="openEditModal(edu)" class="btn btn-sm btn-warning">Sửa</button>
                                <button @click="handleDelete(edu.id)" class="btn btn-sm btn-danger m-2">Xóa</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div v-if="isModalOpen" class="custom-modal show" @click="isModalOpen = false">
            <div class="modal d-block" tabindex="-1" @click.stop>
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ isEditMode ? 'Chỉnh Sửa Mục Học Vấn' : 'Thêm Mục Học Vấn Mới' }}</h5>
                            <button type="button" class="btn-close" @click="isModalOpen = false"></button>
                        </div>
                        <form @submit.prevent="handleSubmit">
                            <div class="modal-body">
                                <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Cơ sở/Trường học:</label>
                                    <input type="text" v-model="educationForm.institution" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Bằng cấp:</label>
                                    <input type="text" v-model="educationForm.degree" class="form-control" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Thời gian:</label>
                                        <input type="text" v-model="educationForm.period" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Địa chỉ:</label>
                                        <input type="text" v-model="educationForm.address" class="form-control">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Chi tiết/Thành tích:</label>
                                    <textarea v-model="educationForm.details" class="form-control" rows="2"></textarea>
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
/* Custom style cho Modal backdrop */
.modal-backdrop {
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
    transform: translateX(-50%);
    z-index: 1051;
}
</style>