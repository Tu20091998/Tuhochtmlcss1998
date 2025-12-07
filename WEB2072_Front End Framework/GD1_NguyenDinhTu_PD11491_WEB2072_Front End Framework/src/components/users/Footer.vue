<script setup>
import { computed, inject, defineEmits } from 'vue'; 

// INJECT DỮ LIỆU TỪ APP.VUE
const portfolioData = inject('portfolioData');

// TẠO COMPUTED PROPERTY ĐỂ TRUY CẬP DỮ LIỆU CÁ NHÂN AN TOÀN
const personalData = computed(() => {
    // Luôn trả về object có cấu trúc cơ bản, ngay cả khi portfolioData là undefined
    return portfolioData.value?.personal || { name: 'Portfolio', avatar: '' };
});
</script>

<template>
    <!-- Footer: Nền tối, Margin Top lớn, Padding responsive -->
    <footer class="bg-dark text-white mt-5 p-4 p-md-5">
        <div class="container-fluid"> 
            <div class="row g-4 g-md-5">
                
                <!-- 1. Thông tin liên hệ -->
                <div class="col-12 col-md-4">
                    <h4 class="fs-5 fw-semibold mb-3 border-bottom border-secondary pb-2">Liên Hệ</h4>
                    <p class="mb-2">Email: <a :href="'mailto:' + personalData.email" class="text-info hover-text-lighter">{{ personalData?.email }}</a></p>
                    <p class="mb-2">Điện thoại: {{ personalData.phone }}</p>
                    <p>Địa chỉ: {{ personalData.address }}</p>
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
                    <div class="d-flex gap-3" style="justify-content: center;">
                        <!-- GitHub Icon -->
                        <a :href="personalData.github" target="_blank" class="text-secondary hover-text-info transform-hover">
                            <svg class="icon-size" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.803 8.207 11.387.599.111.793-.261.793-.577 0-.285-.011-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.73.084-.73 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.493.998.108-.776.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.305-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.046.138 3.003.404 2.292-1.552 3.3-1.23 3.3-1.23.653 1.652.242 2.871.118 3.176.766.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.923.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.8 1.581 4.771-1.581 8.2-6.089 8.2-11.387C24 5.373 18.627 0 12 0z"/></svg>
                        </a>
                        <!-- Youtube Icon -->
                        <a :href="personalData.youtube" target="_blank" class="text-secondary hover-text-info transform-hover">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="30" height="30" viewBox="0 0 256 256" xml:space="preserve">
                            <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 2;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                            	<path d="M 88.119 23.338 c -1.035 -3.872 -4.085 -6.922 -7.957 -7.957 C 73.144 13.5 45 13.5 45 13.5 s -28.144 0 -35.162 1.881 c -3.872 1.035 -6.922 4.085 -7.957 7.957 C 0 30.356 0 45 0 45 s 0 14.644 1.881 21.662 c 1.035 3.872 4.085 6.922 7.957 7.957 C 16.856 76.5 45 76.5 45 76.5 s 28.144 0 35.162 -1.881 c 3.872 -1.035 6.922 -4.085 7.957 -7.957 C 90 59.644 90 45 90 45 S 90 30.356 88.119 23.338 z M 36 58.5 v -27 L 59.382 45 L 36 58.5 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                            </g>
                            </svg>
                        </a>
                        <!-- Facebook Icon -->
                        <a :href="personalData.facebook" target="_blank" class="text-secondary hover-text-info transform-hover">
                            <svg class="icon-size" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.901c0-.528.455-.599 1.242-.599h2.479v-4h-2.947c-4.001 0-4.475 2.622-4.475 4.379v2.621z"/></svg>
                        </a>

                        <!--Gmail icon-->
                        <a :href="personalData.email" target="_blank" class="text-secondary hover-text-info transform-hover">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="30" height="30" viewBox="0 0 256 256" xml:space="preserve">
                                <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                	<path d="M 86.17 11.255 H 3.83 c -2.115 0 -3.83 1.715 -3.83 3.83 v 59.83 c 0 2.115 1.715 3.83 3.83 3.83 h 82.34 c 2.115 0 3.83 -1.715 3.83 -3.83 v -59.83 C 90 12.97 88.285 11.255 86.17 11.255 z M 84.55 69.598 c 0 1.739 -1.498 3.149 -3.346 3.149 h -3.792 V 26.717 L 45.016 54.692 L 12.843 26.91 v 45.836 H 9.051 c -1.848 0 -3.346 -1.41 -3.346 -3.149 V 20.403 c 0 -1.739 1.498 -3.149 3.346 -3.149 h 1.535 h 2.209 h 0.048 v 0.041 l 32.173 27.782 l 32.221 -27.823 h 2.209 l 0 0 h 1.757 c 1.848 0 3.346 1.41 3.346 3.149 V 69.598 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
                                </g>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Bản quyền: Border Top, Text Center, Small Text -->
            <div class="mt-4 pt-3 border-top border-secondary text-center small text-secondary">
                &copy; 2027 {{ personalData.name || 'Portfolio' }}. All Rights Reserved.
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
</style>