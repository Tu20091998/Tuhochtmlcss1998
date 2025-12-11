<script setup>
import { computed, inject, defineEmits } from 'vue'; 
import { useRoute } from 'vue-router'; 

// INJECT DỮ LIỆU TỪ APP.VUE
const portfolioData = inject('portfolioData');

// TẠO COMPUTED PROPERTY ĐỂ TRUY CẬP DỮ LIỆU CÁ NHÂN AN TOÀN
const personalData = computed(() => {
    // Luôn trả về object có cấu trúc cơ bản, ngay cả khi portfolioData là undefined
    return portfolioData.value?.personal || { name: 'Portfolio', avatar: '' };
});
</script>

<template>
    <footer class="footer-premium text-white mt-5 p-4 p-md-5">
    <div class="container">

        <div class="row g-5">

            <!-- Liên hệ -->
            <div class="col-12 col-md-4">
                <h4 class="footer-title">📞 Liên Hệ</h4>
                
                <p class="mb-2">
                    Email:
                    <a :href="'mailto:' + personalData.email"
                       class="footer-link">
                       {{ personalData.email }}
                    </a>
                </p>

                <p class="mb-2">Điện thoại: {{ personalData.phone }}</p>
                <p>Địa chỉ: {{ personalData.address }}</p>
            </div>

            <!-- Triết lý -->
            <div class="col-12 col-md-4">
                <h4 class="footer-title">📜 Triết Lý Phát Triển</h4>

                <p class="footer-quote">
                    "Simple is powerful."
                </p>

                <p class="footer-desc">
                    Tôi theo đuổi sự tối giản trong thiết kế và mã nguồn —
                    rõ ràng, gọn nhẹ và dễ mở rộng lâu dài.
                </p>
            </div>

            <!-- Mạng xã hội -->
            <div class="col-12 col-md-4">
                <h4 class="footer-title">🌐 Kết Nối</h4>

                <div class="d-flex gap-3 justify-content-center">
                    <!-- GitHub -->
                    <a :href="personalData.github" target="_blank" class="icon-wrapper">
                        <i class="bi bi-github"></i>
                    </a>

                    <!-- Facebook -->
                    <a :href="personalData.facebook" target="_blank" class="icon-wrapper">
                        <i class="bi bi-facebook"></i>
                    </a>

                    <!-- YouTube -->
                    <a :href="personalData.youtube" target="_blank" class="icon-wrapper">
                        <i class="bi bi-youtube"></i>
                    </a>

                    <!-- Email -->
                    <a :href="'mailto:' + personalData.email" target="_blank" class="icon-wrapper">
                        <i class="bi bi-envelope"></i>
                    </a>
                </div>
            </div>

        </div>

        <!-- Bản quyền -->
        <div class="mt-4 pt-3 text-center footer-copy">
            © 2027 {{ personalData.name }} — All Rights Reserved.
        </div>

    </div>
</footer>

</template>

<style scoped>
footer {
    width: 100%;
}
.icon-size {
    width: 1.5rem; 
    height: 1.5rem;
}
/* Thay thế hover:text-blue-400 */
.hover-text-info:hover {
    color: var(--bs-info) !important;
}
.hover-text-lighter:hover {
    color: #ced4da !important; /* Màu xám sáng hơn cho text-white trên nền tối */
}
/* Hiệu ứng hover cho Icon (thay thế transform hover:scale-110) */
.transform-hover {
    transition: transform 0.3s ease-in-out;
}
.transform-hover:hover {
    transform: scale(1.1);
}

a{
    cursor: pointer;
}

.footer-premium {
    background: linear-gradient(135deg, #0c0c0c, #1a1a1a);
    border-top: 1px solid rgba(255,255,255,0.08);
}

.footer-title {
    font-size: 1.1rem;
    font-weight: 600;
    padding-bottom: .6rem;
    border-bottom: 1px solid rgba(255,255,255,0.15);
    margin-bottom: 1rem;
}

.footer-link {
    color: var(--bs-info);
    text-decoration: none;
}
.footer-link:hover {
    color: #71d2ff;
}

.footer-quote {
    font-size: 1.3rem;
    font-weight: 600;
    font-style: italic;
    opacity: 0.9;
}

.footer-desc {
    color: #bfbfbf;
    font-size: 0.9rem;
    line-height: 1.6;
}

.icon-wrapper {
    font-size: 1.6rem;
    color: #bbbbbb;
    transition: 0.25s;
}
.icon-wrapper:hover {
    color: white;
    transform: scale(1.15);
    filter: drop-shadow(0 0 6px rgba(0, 183, 255, .5));
}

.footer-copy {
    color: #7b7b7b;
    font-size: 0.85rem;
    border-top: 1px solid rgba(255,255,255,0.1);
}

</style>