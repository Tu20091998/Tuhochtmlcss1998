<script setup>
import { computed, inject, ref } from 'vue';

//  INJECT DỮ LIỆU CẦN THIẾT
const adminData = inject('adminData');
const experienceList = computed(() => adminData.portfolioData.value.experience || []);
const apiBaseUrl = adminData.apiBaseUrl;
const fetchData = adminData.fetchData;

//  TRẠNG THÁI MODAL VÀ FORM
const isModalOpen = ref(false);
const isEditMode = ref(false);
const isLoading = ref(false);
const message = ref({ type: '', text: '' }); 

// Form Model sử dụng các trường KHỚP VỚI DỮ LIỆU JSON
const experienceForm = ref({
    company: '',
    title: '',   
    period: '',   
    description: '',
    startDate: '',
    endDate: '',   
    id: null,
});

// Hàm chuyển đổi chuỗi ngày tháng
const convertDate = (dateString) => {
    if (!dateString) return '';
    return dateString.substring(0, 10);
};

// Reset Form và Mở Modal
const openModal = (experience = null) => {
    message.value = { type: '', text: '' };
    isEditMode.value = !!experience;
    
    if (experience) {
        // Nếu chỉnh sửa, điền dữ liệu vào form
        experienceForm.value = { 
            ...experience,
            startDate: convertDate(experience.startDate), 
            endDate: convertDate(experience.endDate),
            id: experience.id,
        };
    } else {
        // Nếu thêm mới
        experienceForm.value = { 
            company: '', 
            title: '', 
            period: '', 
            description: '', 
            startDate: '', 
            endDate: ''
        };
    }
    isModalOpen.value = true;
};

// --- HÀM XỬ LÝ CRUD ĐƠN GIẢN ---
const handleSubmit = async () => {
    if (!experienceForm.value.company || !experienceForm.value.title) {
        message.value = { type: 'danger', text: 'Vui lòng điền Tên Công ty và Tiêu đề.' };
        return;
    }
    
    isLoading.value = true;
    message.value = { type: '', text: '' };

    const method = isEditMode.value ? 'PUT' : 'POST';
    const url = isEditMode.value 
        ? `${apiBaseUrl}/experience/${experienceForm.value.id}`
        : `${apiBaseUrl}/experience`;
        
    const payload = { ...experienceForm.value };
    // Loại bỏ ID nếu là thao tác POST (thêm mới)
    if (method === 'POST') {
        delete payload.id;
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
        message.value = { type: 'success', text: `Kinh nghiệm đã được ${isEditMode.value ? 'cập nhật' : 'thêm mới'} thành công!` };

    } catch (error) {
        console.error('Lỗi khi lưu:', error);
        message.value = { type: 'danger', text: `Lỗi: ${error.message}` };
    } finally {
        isLoading.value = false;
    }
};

//hàm xoá kinh nghiệm dựa vào id
const handleDelete = async (id) => {
    if (!confirm('Bạn có chắc chắn muốn xóa kinh nghiệm này không?')) return;
    
    message.value = { type: '', text: '' };
    try {
        const response = await fetch(`${apiBaseUrl}/experience/${id}`, { method: 'DELETE' });

        if (!response.ok) {
            const errorText = await response.text();
            throw new Error(`Xóa thất bại. Status: ${response.status}. Chi tiết: ${errorText}`);
        }
        
        await fetchData();
        message.value = { type: 'success', text: 'Đã xóa kinh nghiệm thành công!' };

    } catch (error) {
        console.error('Lỗi khi xóa:', error);
        message.value = { type: 'danger', text: `Lỗi khi xóa: ${error.message}` };
    }
};
</script>

<template>
    <div class="experience-management">
        <h2 class="mb-4 text-dark fw-bold">💼 Quản Lý Kinh Nghiệm</h2>
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div v-if="message.text" :class="`alert alert-${message.type} p-2 m-0`">
                {{ message.text }}
            </div>
            <div v-else></div>

            <button @click="openModal()" class="btn btn-primary fw-bold">
                <i class="bi bi-plus-lg me-2"></i> Thêm Kinh Nghiệm
            </button>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div v-if="experienceList.length === 0" class="alert alert-info">
                    Chưa có kinh nghiệm nào được thêm.
                </div>
                <table v-else class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Công Ty</th>
                            <th>Tiêu Đề</th>
                            <th>Thời Gian</th>
                            <th>Mô Tả (Tóm tắt)</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="exp in experienceList" :key="exp.id">
                            <td>{{ exp.company }}</td>
                            <td>{{ exp.title }}</td>
                            <td>{{ exp.period }}</td>
                            <td>{{ exp.description.substring(0, 50) + '...' }}</td>
                            <td>
                                <button @click="openModal(exp)" class="btn btn-sm btn-warning">Sửa</button>
                                <button @click="handleDelete(exp.id)" class="btn btn-sm btn-danger m-2">Xóa</button>
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
                            <h5 class="modal-title">{{ isEditMode ? 'Chỉnh Sửa Kinh Nghiệm' : 'Thêm Kinh Nghiệm Mới' }}</h5>
                            <button type="button" class="btn-close" @click="isModalOpen = false"></button>
                        </div>
                        <form @submit.prevent="handleSubmit">
                            <div class="modal-body">
                                <div v-if="message.type === 'danger'" :class="`alert alert-${message.type}`">{{ message.text }}</div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tên Công Ty:</label>
                                        <input type="text" v-model="experienceForm.company" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tiêu đề Công việc (Title):</label>
                                        <input type="text" v-model="experienceForm.title" class="form-control" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Khoảng thời gian (Period):</label>
                                    <input type="text" v-model="experienceForm.period" class="form-control" placeholder="06/2027 - 12/2027" required>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Ngày bắt đầu (Tùy chọn):</label>
                                        <input type="date" v-model="experienceForm.startDate" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Ngày kết thúc (Tùy chọn):</label>
                                        <input type="date" v-model="experienceForm.endDate" class="form-control">
                                        <small class="form-text text-muted">Sử dụng trường Period ở trên cho mô tả thời gian ngắn gọn.</small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Mô tả Công việc/Trách nhiệm:</label>
                                    <textarea v-model="experienceForm.description" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="isModalOpen = false">Hủy</button>
                                <button type="submit" class="btn btn-dark" :disabled="isLoading">
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
    top: 10%;
    left: 50%;
    transform: translate(-50%, -10%); 
    z-index: 1060; 
}
.modal-content {
    background-color: #fff; 
    border-radius: 0.5rem;
}
</style>