<script setup>
import { ref, inject } from 'vue';
import { useRouter } from 'vue-router'; 

const router = useRouter();

// Inject các hàm và API Base URL từ App.vue
const apiBaseUrl = inject('apiBaseUrl');
const securityState = inject('securityState');
const { loginAsAdmin } = securityState; 

// Trạng thái Form
const username = ref('');
const password = ref('');
const errorMessage = ref('');
const isLoading = ref(false);

// Hàm xử lý Đăng nhập
const handleLogin = async () => {
    errorMessage.value = '';
    isLoading.value = true;

    if (!username.value || !password.value) {
        errorMessage.value = 'Vui lòng nhập đầy đủ Tên đăng nhập và Mật khẩu.';
        isLoading.value = false;
        return;
    }

    try {
        //gọi api lấy thông tin người dùng 
        const response = await fetch(`${apiBaseUrl}/users?username=${username.value}`);
        
        if (!response.ok) {
            throw new Error('Lỗi kết nối API.');
        }

        const users = await response.json();

        // BƯỚC 2: KIỂM TRA TỒN TẠI VÀ MẬT KHẨU
        if (users.length === 0) {
            errorMessage.value = 'Tên đăng nhập không tồn tại.';
            return;
        }

        const user = users[0];

        if (password.value !== user.password) {
            errorMessage.value = 'Mật khẩu không đúng.';
            return;
        }

        // BƯỚC 3: ĐĂNG NHẬP THÀNH CÔNG
        loginAsAdmin(user.role); 

        } catch (error) {
            console.error('Lỗi Đăng nhập:', error);
            errorMessage.value = 'Đã xảy ra lỗi trong quá trình đăng nhập. Vui lòng thử lại.';
        } finally {
            isLoading.value = false;
        }
};
</script>

<template>
    <div class="login-container d-flex align-items-center justify-content-center min-vh-100 bg-light">
        <div class="card p-4 shadow-lg" style="width: 100%; max-width: 400px;">
            <div class="card-body">
                <h3 class="card-title text-center mb-4 text-primary">Đăng Nhập Admin</h3>
                
                <form @submit.prevent="handleLogin">
                    
                    <div class="mb-3">
                        <label for="username" class="form-label">Tên đăng nhập:</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="username" 
                            v-model="username" 
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Mật khẩu:</label>
                        <input 
                            type="password" 
                            class="form-control" 
                            id="password" 
                            v-model="password" 
                            required
                        >
                    </div>

                    <div v-if="errorMessage" class="alert alert-danger p-2 small">
                        {{ errorMessage }}
                    </div>

                    <button 
                        type="submit" 
                        class="btn btn-primary w-100" 
                        :disabled="isLoading"
                    >
                        <span v-if="isLoading" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                        {{ isLoading ? 'Đang Đăng nhập...' : 'Đăng Nhập' }}
                    </button>
                </form>

                <p class="text-center mt-3 small text-muted">
                    <router-link :to="{ name: 'Home' }" class="text-decoration-none">Quay lại Trang chủ</router-link>
                </p>
            </div>
        </div>
    </div>
</template>

<style scoped>
.login-container {
    background: #e9ecef !important;
}
.card {
    border-radius: 1rem;
}
</style>