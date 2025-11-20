<script setup lang="ts">

const props = defineProps({
    currentView: String, 
    personalData: {
        type: Object,
        // Đặt required: true, vì nó luôn được truyền từ App.vue (dù là mock hay API)
        required: true 
    }
});

const emit = defineEmits(['changeView']);

const navItems = [
    { label: "Trang chủ", view: "Home" },
    { label: "Thông tin", view: "Detail" },
    { label: "Kĩ năng/Dự án", view: "Skills" },
    { label: "Bài viết", view: "Articles" },
    { label: "Liên hệ", view: "Contact" }
];

</script>

<template>
    <!-- Navbar Bootstrap-->
    <header class="fixed-top bg-white shadow-sm z-index-10">
        <nav class="navbar navbar-expand-md navbar-light py-0">
            <!-- Container Responsive -->
            <div class="container-fluid container-md px-3 px-sm-3 px-lg-4 max-width-center"> 
                <!-- Logo/Tên: -->
                <a @click="emit('changeView', 'Home')" class="navbar-brand fs-4 fw-bold cursor-pointer py-3">
                    {{ (personalData as any)?.name || 'Portfolio' }}
                </a>
                
                <!-- Toggle Button cho Mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menu Desktop & Mobile-->
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li v-for="item in navItems" :key="item.view" class="nav-item mx-2">
                            <a @click="emit('changeView', item.view)"
                                data-bs-toggle="collapse" 
                                data-bs-target="#navbarNav" 
                                :class="{
                                    // Hiệu ứng border dưới cho trang hiện tại (Desktop)
                                    'border-bottom border-3 border-primary text-primary fw-semibold': currentView === item.view,
                                    // Màu chữ và hiệu ứng hover
                                    'text-dark hover-text-secondary': currentView !== item.view
                                }"
                                class="nav-link fs-6 cursor-pointer transition p-1 pt-3 pb-3">
                                {{ item.label }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</template>

<style scoped>
/* Custom CSS thuần */
.z-index-10 {
    z-index: 10;
}

.max-width-center {
    max-width: 1280px;
    margin-left: auto;
    margin-right: auto;
}

.cursor-pointer {
    cursor: pointer;
}

.transition {
    transition: all 0.2s ease-in-out;
}

/* Custom style cho hiệu ứng màu gradient */
.text-gradient {
    background-image: linear-gradient(45deg, #0575E6, #021B79);
    -webkit-text-fill-color: transparent;

}

/* Hiệu ứng hover cho menu item */
.hover-text-secondary:hover {
    color: var(--bs-secondary) !important;
}
</style>