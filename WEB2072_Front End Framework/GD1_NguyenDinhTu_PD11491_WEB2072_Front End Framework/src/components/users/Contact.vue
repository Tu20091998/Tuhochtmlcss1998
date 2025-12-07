<script setup>
import { ref } from 'vue';

const form = ref({
    name: '',
    email: '',
    subject: '',
    message: ''
});

//node server.cjs

const statusMessage = ref();
const isError = ref(false);
const isSubmitting = ref(false); // Trạng thái gửi form

//gọi cổng nodemailer
const CONTACT_API_URL = 'http://localhost:3001/messages'; 

// ➡️ Cổng Backend mới
const CONTACT_API_DB = 'http://localhost:3002/messages';

const submitForm = async () => {
    statusMessage.value = null;
    isError.value = false;
    isSubmitting.value = true;

    if (!form.value.name || !form.value.email || !form.value.subject || !form.value.message) {
        isError.value = true;
        statusMessage.value = 'Vui lòng điền đầy đủ tất cả các trường bắt buộc.';
        isSubmitting.value = false;
        return;
    }

    try {
        // Gửi request POST JSON đến Backend Server
        const response = await fetch(CONTACT_API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            // Dữ liệu form được gửi dưới dạng JSON
            body: JSON.stringify({
                ...form.value,
                timestamp: new Date().toISOString()
            }),
        });

         // 🚀 CHỈ MỘT LỜI GỌI API DUY NHẤT ĐẾN BACKEND (cổng 3002)
        const response_db = await fetch(CONTACT_API_DB, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                ...form.value,
                timestamp: new Date().toISOString()
            }),
        });

        if (!response.ok) {
            // Xử lý lỗi HTTP (4xx hoặc 5xx)
            throw new Error(`Gửi dữ liệu lỗi, Status: ${response.status}`);
        }

        // Backend thành công, có thể là đã lưu vào DB và gửi email
        statusMessage.value = `Thông tin của bạn đã được gửi thành công và đã được lưu vào database! Backend sẽ xử lý việc gửi email phản hồi.`;
        isError.value = false;
        
        // Reset form
        form.value = { name: '', email: '', subject: '', message: '' };

    } catch (e) {
        isError.value = true;
        // Hiển thị lỗi từ server hoặc lỗi mạng
        statusMessage.value = `Gửi thất bại: ${e.message}. Vui lòng kiểm tra server Backend.`;
        console.error("Gửi form lỗi (API):", e);
    } finally {
        isSubmitting.value = false;
    }
};
</script>

<template>
    <section class="container-fluid max-width-center pt-3">
        <h1 class="fs-2 fw-bold text-dark text-center mb-5">Liên Hệ & Hợp Tác</h1>

        <div class="card bg-white p-4 p-md-5 rounded-3 shadow-lg">
            <p class="text-center text-secondary mb-4">Hãy để lại thông tin của bạn. Tôi sẽ phản hồi sớm nhất có thể để thảo luận về cơ hội hợp tác.</p>
            
            <!-- Alert cho trạng thái form -->
            <div v-if="statusMessage" :class="{'bg-success-subtle border-success-subtle text-success-emphasis': !isError, 'bg-danger-subtle border-danger-subtle text-danger-emphasis': isError}" class="alert border px-4 py-3 rounded mb-4" role="alert">
                <p class="fw-bold mb-0">{{ isError ? 'Lỗi!' : 'Thành công!' }}</p>
                <p class="small mb-0">{{ statusMessage }}</p>
            </div>

            <!-- Form: d-flex flex-column gap-3 -->
            <form @submit.prevent="submitForm" class="d-flex flex-column gap-3">
                <div class="mb-3">
                    <label for="name" class="form-label d-block small fw-medium text-dark">Họ và Tên (*)</label>
                    <input type="text" id="name" v-model="form.name" required class="form-control rounded-2 shadow-sm transition" :disabled="isSubmitting">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label d-block small fw-medium text-dark">Email (*)</label>
                    <input type="email" id="email" v-model="form.email" required class="form-control rounded-2 shadow-sm transition" :disabled="isSubmitting">
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label d-block small fw-medium text-dark">Chủ đề (*)</label>
                    <input type="text" id="subject" v-model="form.subject" required class="form-control rounded-2 shadow-sm transition" :disabled="isSubmitting">
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label d-block small fw-medium text-dark">Tin nhắn/Nội dung hợp tác (*)</label>
                    <textarea id="message" rows="4" v-model="form.message" required class="form-control rounded-2 shadow-sm transition" :disabled="isSubmitting"></textarea>
                </div>
                
                <!-- Button: Thêm Loading Spinner Bootstrap -->
                <button type="submit" class="w-100 btn btn-primary py-3 px-4 shadow-sm fw-medium transition hover-scale-101" :disabled="isSubmitting">
                    <span v-if="isSubmitting" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    {{ isSubmitting ? 'Đang Gửi...' : 'Gửi Tin Nhắn & Hợp Tác' }}
                </button>
            </form>
            
            <p class="mt-4 text-center small text-muted">
                Lưu ý: Dữ liệu đã được cấu hình gửi dưới dạng JSON tới API Backend tại: {{ CONTACT_API_URL }}
            </p>
        </div>
    </section>
</template>

<style scoped>
/* Tái sử dụng CSS thuần */
.max-width-center {
    max-width: 1280px;
    margin-left: auto;
    margin-right: auto;
}
.transition {
    transition: all 0.2s ease-in-out;
}
.hover-scale-101:hover {
    transform: scale(1.01);
}
</style>