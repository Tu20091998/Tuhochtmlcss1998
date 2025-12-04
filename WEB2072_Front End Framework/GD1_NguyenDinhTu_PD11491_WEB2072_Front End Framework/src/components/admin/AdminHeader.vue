<script setup lang="ts">
const props = defineProps({
    userRole: { type: String, required: true },
});
const emit = defineEmits(['logout']);
</script>

<template>
    <header class="bg-white shadow-sm p-3 mb-4 d-flex justify-content-between align-items-center sticky-top">
        <h4 class="mb-0 text-dark">Quản lý Dữ liệu Portfolio</h4>
        <div class="d-flex align-items-center">
            <span class="badge bg-primary me-3 fs-6">{{ props.userRole.toUpperCase() }}</span>
            <button @click="emit('logout')" class="btn btn-sm btn-outline-danger">Đăng xuất</button>
        </div>
    </header>
</template>

<style scoped>
.sticky-top {
    position: sticky;
    top: 0;
    z-index: 1000; /* Đảm bảo nó luôn ở trên cùng */
}
</style>