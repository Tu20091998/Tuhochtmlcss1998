<script setup lang="ts">
// Định nghĩa props để nhận dữ liệu cá nhân (personalData)
const props = defineProps({
    personalData: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <!-- Footer: Nền tối, Margin Top lớn, Padding responsive -->
    <footer class="bg-dark text-white mt-5 p-4 p-md-5">
        <div class="container-fluid max-width-center"> 
            <div class="row g-4 g-md-5">
                
                <!-- 1. Thông tin liên hệ -->
                <div class="col-12 col-md-4">
                    <h4 class="fs-5 fw-semibold mb-3 border-bottom border-secondary pb-2">Liên Hệ</h4>
                    <p class="mb-2">Email: <a :href="'mailto:' + (personalData as any)?.email" class="text-info hover-text-lighter">{{ (personalData as any)?.email }}</a></p>
                    <p class="mb-2">Điện thoại: {{ (personalData as any)?.phone }}</p>
                    <p>Địa chỉ: {{ (personalData as any)?.address }}</p>
                </div>
                
                <!-- 2. Menu Phụ -->
                <div class="col-12 col-md-4">
                    <h4 class="fs-5 fw-semibold mb-3 border-bottom border-secondary pb-2">Menu Phụ</h4>
                    <ul class="list-unstyled space-y-2">
                        <li><a href="#" class="text-info hover-text-lighter">Điều khoản</a></li>
                        <li><a href="#" class="text-info hover-text-lighter">Chính sách bảo mật</a></li>
                        <li><a href="#" class="text-info hover-text-lighter">Sơ đồ trang</a></li>
                    </ul>
                </div>
                
                <!-- 3. Mạng xã hội -->
                <div class="col-12 col-md-4">
                    <h4 class="fs-5 fw-semibold mb-3 border-bottom border-secondary pb-2">Kết Nối</h4>
                    <!-- d-flex, gap-3 -->
                    <div class="d-flex gap-3">
                        <!-- GitHub Icon -->
                        <a :href="(personalData as any)?.social?.github" target="_blank" class="text-secondary hover-text-info transform-hover">
                            <svg class="icon-size" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.803 8.207 11.387.599.111.793-.261.793-.577 0-.285-.011-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.73.084-.73 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.493.998.108-.776.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.305-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.046.138 3.003.404 2.292-1.552 3.3-1.23 3.3-1.23.653 1.652.242 2.871.118 3.176.766.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.923.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.8 1.581 4.771-1.581 8.2-6.089 8.2-11.387C24 5.373 18.627 0 12 0z"/></svg>
                        </a>
                        <!-- LinkedIn Icon -->
                        <a :href="(personalData as any)?.social?.linkedin" target="_blank" class="text-secondary hover-text-info transform-hover">
                            <svg class="icon-size" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.238-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        </a>
                        <!-- Facebook Icon -->
                        <a :href="(personalData as any)?.social?.facebook" target="_blank" class="text-secondary hover-text-info transform-hover">
                            <svg class="icon-size" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.901c0-.528.455-.599 1.242-.599h2.479v-4h-2.947c-4.001 0-4.475 2.622-4.475 4.379v2.621z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Bản quyền: Border Top, Text Center, Small Text -->
            <div class="mt-4 pt-3 border-top border-secondary text-center small text-secondary">
                &copy; 2027 {{ (personalData as any)?.name || 'Portfolio' }}. All Rights Reserved.
            </div>
        </div>
    </footer>
</template>

<style scoped>
.max-width-center {
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
</style>