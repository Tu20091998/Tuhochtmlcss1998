<script setup>
import { ref, inject } from 'vue'; // Cần import 'inject'

// --- LOẠI BỎ PROPS VÀ SỬ DỤNG INJECT ---
// Lấy giá trị apiBaseUrl đã được cung cấp từ component tổ tiên (App.vue)
const apiBaseUrl = inject('apiBaseUrl'); 
// Lưu ý: Giá trị này là một chuỗi (string), không phải là ref, nên không cần dùng .value

// Sự kiện phát ra vai trò (role: string) sau khi đăng nhập thành công
const emit = defineEmits(['loginSuccess', 'goHome']);

const username = ref('admin_tu'); 
const password = ref('admin123');
const error = ref('');

const handleSubmit = async () => {
    error.value = '';

    // 1. GỌI API GET USER: Tìm kiếm người dùng theo username
    try {
        // Sử dụng biến apiBaseUrl đã được inject trực tiếp
        const url = `${apiBaseUrl}/users?username=${username.value}`;
        const response = await fetch(url);
        
        if (!response.ok) {
            throw new Error(`Lỗi HTTP: ${response.status}`);
        }
        
        const users = await response.json();

        if (users.length === 0) {
            error.value = 'Tên đăng nhập không tồn tại.';
            return;
        }

        const user = users[0];
        
        // 2. GIẢ LẬP XÁC THỰC MẬT KHẨU (Client-side check - KHÔNG AN TOÀN)
        const MOCK_CORRECT_PASSWORD = 'admin123';
        const isPasswordCorrect = (password.value === MOCK_CORRECT_PASSWORD); 

        if (isPasswordCorrect && user.role === 'admin') {
            // Xác thực thành công -> Báo cho component cha biết và truyền vai trò (role)
            emit('loginSuccess', user.role); 
        } else {
            error.value = 'Mật khẩu không đúng hoặc bạn không có quyền Admin.';
        }

    } catch (err) {
        error.value = 'Lỗi kết nối API hoặc xử lý đăng nhập.';
        console.error("Lỗi Đăng nhập:", err);
    }
};
</script>

<template>
    <div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
        <form @submit.prevent="handleSubmit" class="card p-5 shadow-lg" style="max-width: 450px; width: 100%;">
            <h2 class="text-center text-primary mb-4">🔐 Đăng nhập Admin</h2>
            <div class="mb-3">
                <label class="form-label small">Tên đăng nhập:</label>
                <input type="text" v-model="username" class="form-control" placeholder="admin_tu" required>
            </div>
            <div class="mb-3">
                <label class="form-label small">Mật khẩu:</label>
                <input type="password" v-model="password" class="form-control" placeholder="admin123" required>
            </div>
            <div v-if="error" class="alert alert-danger p-2 small">{{ error }}</div>
            <button type="submit" class="btn btn-primary w-100 mb-2">Đăng nhập</button>
            <button type="button" @click="$emit('goHome')" class="btn btn-secondary w-100">← Về Trang Chủ</button>
        </form>
    </div>
</template>
