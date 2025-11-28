<template>
    <div class="list-group-item bg-white px-0 py-4 align-items-start flex-wrap">
        <div class="flex-shrink-0 pt-1 me-3">
            <div class="d-flex align-items-start">
                <!-- Checkbox -->
                <input type="checkbox" class="cart-checkbox form-check-input me-3" checked />
                <div class="d-flex flex-column text-start">
                    <p class="mb-0 fw-semibold text-dark">{{ item.name }}</p>
                    <p class="text-secondary mb-2" style="font-size: 0.85em;">{{ item.category }} Category</p>
                </div>
            </div>
        </div>

        <!-- Chi tiết sản phẩm -->
        <div class="d-flex flex-grow-1 flex-md-row mt-3" style="margin-left: 2rem;">
            <img
                :src="item.imageUrl"
                :alt="item.name"
                class="img-fluid shadow-sm me-md-4 mb-3 mb-md-0"
                style="width: 10rem; height: 10rem; object-fit: contain;"
            />
            <div class="flex-grow-1 text-start">
                
                <p class="text-muted mb-2" style="font-size: 0.85em;">{{ item.description }}</p>
                <span class="badge bg-light text-secondary fw-normal">
                    Size: {{ item.size }}
                </span>

                <!-- Giá và Số lượng -->
                <div class="d-flex align-items-center ms-auto pt-2 pt-md-0 justify-content-between">
                    <!-- Tổng giá theo số lượng -->

                    <!-- Hiển thị Giá đơn vị -->
                    <p class="fs-4 fw-bold text-dark mb-2 mt-3">${{ item.price.toFixed(2) }}</p>

                    <div class="d-flex gap-2 align-items-center mb-3">
                        <!-- Giảm số lượng -->
                        <button
                            @click="emit('update-quantity', item.id, Math.max(1, item.quantity - 1))"
                            :disabled="item.quantity <= 1"
                            class="btn btn-sm btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px; border-width: 1px;"
                        >
                        -
                        </button>
                        <span class="text-center fw-medium text-dark" style="width: 32px;">{{ item.quantity }}</span>
                        <!-- Tăng số lượng -->
                        <button
                            @click="emit('update-quantity', item.id, item.quantity + 1)"
                            class="btn btn-sm btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px; border-width: 1px;"
                        >
                        +
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
// Định nghĩa Props và Emits
const props = defineProps({
    item: {
        type: Object,
        required: true
    }
});

const emit = defineEmits(['update-quantity']);
</script>

<style scoped>
/* Định nghĩa màu custom cho checkbox Bootstrap */
.cart-checkbox {
    accent-color: #f97316; 
}
</style>