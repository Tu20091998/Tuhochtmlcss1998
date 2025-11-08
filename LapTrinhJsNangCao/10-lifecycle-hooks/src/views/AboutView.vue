<script setup>
import { onBeforeMount, onMounted, onBeforeUpdate, onUpdated, onBeforeUnmount, onUnmounted, ref } from 'vue';

const count = ref(7);

// Hàm để kích hoạt cập nhật
const increment = () => {
  count.value++;
};

// --- 1. GẮN KẾT (MOUNTING) ---
onBeforeMount(() => {
  console.log('👶 1. onBeforeMount: Sắp chèn vào DOM. Count hiện tại:', count.value);
});

onMounted(() => {
  console.log('✅ 2. onMounted: Đã chèn vào DOM. Có thể thao tác DOM tại đây.', count.value);
});

// --- 2. CẬP NHẬT (UPDATING) ---
onBeforeUpdate(() => {
  // Lấy giá trị *trước* khi DOM được cập nhật
  console.log('🔄 3. onBeforeUpdate: DOM sắp được cập nhật. Giá trị Count mới:', count.value);
});

onUpdated(() => {
  // Lấy giá trị *sau* khi DOM đã được cập nhật
  console.log('✨ 4. onUpdated: DOM đã hoàn tất cập nhật.', count.value);
});

// --- 3. GỠ BỎ (UNMOUNTING) ---
onBeforeUnmount(() => {
  console.warn('🗑️ 5. onBeforeUnmount: Sắp gỡ khỏi DOM. Dọn dẹp tài nguyên (timers) tại đây.', count.value);
});

onUnmounted(() => {
  console.error('❌ 6. onUnmounted: Đã gỡ hoàn toàn khỏi DOM.',count.value);
});

</script>

<template>
  <div style="border: 2px solid #42b883; padding: 15px; margin-top: 20px;">
    <h3>Component Con đang hoạt động</h3>
    <p>Giá trị đếm: <strong>{{ count }}</strong></p>
    <button @click="increment">Tăng giá trị đếm</button>
  </div>
</template>