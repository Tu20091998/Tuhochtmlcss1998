<script setup>
import { ref, inject, watch } from 'vue';

// Inject dữ liệu và hàm cần thiết
const adminData = inject('adminData');
const portfolioData = adminData.portfolioData;
const apiBaseUrl = adminData.apiBaseUrl;
const fetchData = adminData.fetchData;

// --- TRẠNG THÁI FORM ---
const isLoading = ref(false);
const errorMessage = ref('');
const successMessage = ref('');

// Tạo bản sao dữ liệu (Form Model)
const formData = ref({
    name: '',
    title: '',
    email: '',
    phone: '',
    address: '',
    bio: '',
    avatar: '', 
    github: '', 
    facebook: '', 
    youtube: '', 
    gmail: '', 
    hardSkillsText: '', 
    softSkillsText: '',
});

// Watch portfolioData để đồng bộ dữ liệu vào form khi component load hoặc data fetch lại
watch(portfolioData, (newData) => {
    const personal = newData.personal;
    
    // Nếu personal.social tồn tại, lấy dữ liệu mạng xã hội
    const social = personal.social || {}; 

    formData.value = {
        name: personal.name || '',
        title: personal.title || '',
        email: personal.email || '',
        phone: personal.phone || '',
        address: personal.address || '',
        bio: personal.bio || '',
        avatar: personal.avatar || '',
        // Lấy Social Links
        github: social.github || '',
        facebook: social.facebook || '',
        youtube: social.youtube || '',
        gmail: social.gmail || '',
        // Xử lý chuyển đổi mảng Kỹ năng thành chuỗi
        hardSkillsText: personal.hardSkills?.join(', ') || '',
        softSkillsText: personal.softSkills?.join(', ') || '',
    };
}, { immediate: true });

// --- HÀM XỬ LÝ UPDATE (PUT) ---
const handleUpdatePersonal = async () => {
    errorMessage.value = '';
    successMessage.value = '';
    isLoading.value = true;
    
    // Hàm chuyển đổi chuỗi kỹ năng thành mảng, loại bỏ khoảng trắng và mục rỗng
    const parseSkills = (text) => text.split(',').map(s => s.trim()).filter(s => s.length > 0);

    // 1. Chuẩn bị dữ liệu gửi đi (Sử dụng ID cố định là 1)
    const updatedPersonal = {
        ...portfolioData.value.personal,
        id: 1, 
        name: formData.value.name,
        title: formData.value.title,
        email: formData.value.email,
        phone: formData.value.phone,
        address: formData.value.address,
        avatar: formData.value.avatar,
        bio: formData.value.bio,
        // Cập nhật Social Links
        social: {
            github: formData.value.github,
            facebook: formData.value.facebook,
            youtube: formData.value.youtube,
            gmail: formData.value.gmail,
        },
        // Cập nhật Skills
        hardSkills: parseSkills(formData.value.hardSkillsText),
        softSkills: parseSkills(formData.value.softSkillsText),
    };

    try {
        // 2. Gọi API PUT để cập nhật toàn bộ đối tượng personal
        const response = await fetch(`${apiBaseUrl}/personal`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(updatedPersonal),
        });

        if (!response.ok) {
            throw new Error(`Cập nhật thất bại, Status: ${response.status}`);
        }

        // 3. Cập nhật giao diện toàn cục
        await fetchData(); 
        successMessage.value = 'Thông tin cá nhân đã được cập nhật thành công!';

    } catch (error) {
        console.error('Lỗi cập nhật thông tin cá nhân:', error);
        errorMessage.value = `Lỗi: ${error.message}`;
    } finally {
        isLoading.value = false;
    }
};
</script>

<template>
    <div class="personal-edit">
        <h2 class="mb-4 text-dark fw-bold">Chỉnh Sửa Thông Tin Cá Nhân</h2>
        
        <form @submit.prevent="handleUpdatePersonal" class="p-4 bg-white shadow-sm rounded">
            
            <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>
            <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>

            <h5 class="fw-semibold mb-3">Thông Tin Liên Hệ & Cơ Bản</h5>
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Họ và Tên:</label>
                    <input type="text" id="name" v-model="formData.name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="title" class="form-label">Tiêu đề (Chức danh):</label>
                    <input type="text" id="title" v-model="formData.title" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" v-model="formData.email" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Điện thoại:</label>
                    <input type="text" id="phone" v-model="formData.phone" class="form-control">
                </div>
                <div class="col-12 mb-4">
                    <label for="address" class="form-label">Địa chỉ:</label>
                    <input type="text" id="address" v-model="formData.address" class="form-control">
                </div>
            </div>
            
            <h5 class="fw-semibold mb-3">Tiểu Sử & Hình Ảnh</h5>
            <div class="mb-3">
                <label for="avatar" class="form-label">URL Ảnh đại diện (Avatar):</label>
                <input type="url" id="avatar" v-model="formData.avatar" class="form-control">
                <small class="form-text text-muted mt-2">Ảnh đại diện trước</small><br></br>
                <img :src="formData.avatar" alt="Ảnh đại diện" style="width: 10rem; height: 10rem; margin-top: 1rem;">
            </div>
            <div class="mb-4">
                <label for="bio" class="form-label">Tiểu sử (Bio):</label>
                <textarea id="bio" v-model="formData.bio" class="form-control" rows="3"></textarea>
            </div>

            <h5 class="fw-semibold mb-3">Liên Kết Mạng Xã Hội (URL)</h5>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="github" class="form-label">GitHub:</label>
                    <input type="url" id="github" v-model="formData.github" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="facebook" class="form-label">Facebook:</label>
                    <input type="url" id="facebook" v-model="formData.facebook" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="youtube" class="form-label">YouTube:</label>
                    <input type="url" id="youtube" v-model="formData.youtube" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="gmailSocial" class="form-label">Gmail (Social Link):</label>
                    <input type="email" id="gmailSocial" v-model="formData.gmail" class="form-control">
                </div>
            </div>
            
            <h5 class="fw-semibold mb-3">Quản lý Kỹ năng</h5>
            <div class="mb-3">
                <label for="hardSkills" class="form-label">Kỹ năng Cứng:</label>
                <textarea 
                    id="hardSkills" 
                    v-model="formData.hardSkillsText" 
                    class="form-control" 
                    rows="2"
                ></textarea>
            </div>
            <div class="mb-4">
                <label for="softSkills" class="form-label">Kỹ năng Mềm:</label>
                <textarea 
                    id="softSkills" 
                    v-model="formData.softSkillsText" 
                    class="form-control" 
                    rows="2"
                ></textarea>
            </div>

            <button type="submit" class="btn btn-success fw-bold mt-3" :disabled="isLoading">
                <i class="bi bi-save me-2"></i> {{ isLoading ? 'Đang Lưu...' : 'Cập Nhật Thông Tin' }}
            </button>
        </form>
        
    </div>
</template>