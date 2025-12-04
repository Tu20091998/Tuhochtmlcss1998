<script setup>
const props = defineProps({
    currentView: { type: String, required: true },
});

const emit = defineEmits(['changeView', 'logout', 'goHome']);

const menuItems = [
    { name: 'Tổng quan', view: 'dashboard', icon: '🏠' },
    { name: 'Thông tin cá nhân', view: 'personal', icon: '👤' },
    { name: 'Kỹ năng & Dự án', view: 'skills', icon: '🛠️' },
    { name: 'Bài viết/Blog', view: 'articles', icon: '📝' },
];
</script>

<template>
    <div class="sidebar p-3 d-flex flex-column bg-dark text-white min-vh-100" style="width: 250px;">
        <h3 class="text-warning mb-4 border-bottom pb-2">Admin Panel</h3>
        <ul class="nav nav-pills flex-column mb-auto">
            <li v-for="item in menuItems" :key="item.view" class="nav-item mb-2">
                <a 
                    href="#" 
                    class="nav-link text-white" 
                    :class="{ 'active bg-primary': currentView === item.view }" 
                    @click.prevent="emit('changeView', item.view)"
                >
                    {{ item.icon }} {{ item.name }}
                </a>
            </li>
        </ul>
        <hr class="text-secondary">
        <div class="mt-auto">
            <button @click="emit('goHome')" class="btn btn-outline-light w-100 mb-2">← Quay lại Client</button>
            <button @click="emit('logout')" class="btn btn-danger w-100">Đăng xuất</button>
        </div>
    </div>
</template>

<style scoped>
.sidebar {
    position: sticky;
    top: 0;
    flex-shrink: 0; /* Ngăn sidebar bị co lại */
}
.nav-link {
    transition: background-color 0.2s;
    cursor: pointer;
}
</style>