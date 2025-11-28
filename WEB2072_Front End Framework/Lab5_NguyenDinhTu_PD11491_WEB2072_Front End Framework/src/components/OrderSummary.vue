<template>
    <!-- 1. Tóm tắt Đơn hàng -->
    <div class="card sticky-top shadow-lg border-0 rounded-4 p-4 mb-4" style="top: 1rem;">
        <h2 class="fs-5 fw-bold text-dark mb-4 border-bottom pb-3">Tóm tắt đơn hàng</h2>
        
        <!-- Chi tiết tính tiền từng sản phẩm (Lab 6) -->
        <div class="small text-secondary mb-3 border-bottom pb-3">
            <div v-for="item in cart" :key="item.id" class="d-flex justify-content-between mb-1">
                <span class="text-muted">x{{ item.quantity }} {{ item.name }}</span>
                <span class="fw-medium text-dark">${{ (item.price * item.quantity).toFixed(2) }}</span>
            </div>
        </div>

        <!-- Phí giao hàng (Giữ lại giao diện theo ảnh mẫu) -->
        <div class="small text-secondary mb-4 border-bottom pb-3">
            <div class="d-flex justify-content-between mb-2">
                <span>Giao ngay hôm nay chỉ với</span>
                <span class="fw-medium text-dark">$20.00</span>
            </div>
            <div class="d-flex justify-content-between align-items-center text-muted" style="font-size: 0.75rem;">
                <span>Giao đến:</span>
                <span class="fw-medium">Thành phố Hồ Chí Minh</span>
            </div>
        </div>

        <!-- Tổng kết tính toán -->
        <div class="small text-secondary mb-4">
            <div class="d-flex justify-content-between mb-2">
                <span>Tổng phụ</span>
                <span class="fw-medium text-dark">${{ orderSummary.subtotal.toFixed(2) }}</span>
            </div>

            <!-- Giảm giá  -->
            <div v-if="orderSummary.discount > 0" class="d-flex justify-content-between text-success mb-2">
                <span>Giảm giá ({{ orderSummary.appliedVoucher?.code }})</span>
                <span class="fw-semibold">-${{ orderSummary.discount.toFixed(2) }}</span>
            </div>

            <!-- Thuế  -->
            <div class="d-flex justify-content-between mb-2">
                <span>Thuế (8%)</span>
                <span class="fw-medium text-dark">${{ orderSummary.tax.toFixed(2) }}</span>
            </div>
        </div>

        <!-- Tổng đơn hàng (Lab 5, 6) -->
        <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-3 fs-5 fw-bold text-dark">
            <span>Tổng đơn hàng</span>
            <span class="text-custom-orange">${{ orderSummary.orderTotal.toFixed(2) }}</span>
        </div>
    </div>

    <!-- 2. Form áp dụng Voucher và Checkout -->
    <div class="card shadow-lg border-0 rounded-4 p-4 mt-4">
        <h3 class="fs-6 fw-bold text-dark mb-3">Thêm mã giảm giá ở đây</h3>
        
        <div class="input-group mb-3">
            <input
                type="text"
                placeholder="Thêm mã giảm giá ở đây..."
                v-model="voucherInput"
                @input="voucherInput = voucherInput.toUpperCase()"
                class="form-control rounded-start-pill"
            />
            <button
                @click="handleVoucherSubmit"
                class="btn btn-custom-orange rounded-end-pill"
            >
                Áp dụng
            </button>
        </div>

        <!-- Message Box -->
        <div v-if="message"
            :class="['alert', 'p-3', 'mb-3', message.type === 'success' ? 'alert-success' : 'alert-danger']">
            {{ message.text }}
        </div>

        <!-- Nút Thanh toán -->
        <button
            @click="() => alert('Thanh toán thành công! Cảm ơn bạn đã mua hàng.')"
            class="btn btn-custom-orange w-100 py-3 mt-2 rounded-3 fs-5"
        >
            Thanh toán Ngay
        </button>
    </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue';

const props = defineProps({
  // Dữ liệu từ App.vue
    cart: { type: Array, required: true },
    vouchers: { type: Array, required: true },
    appliedVoucherCode: { type: String, default: null },
    TAX_RATE: { type: Number, default: 0.08 },
});

const emit = defineEmits(['apply-voucher']);

const voucherInput = ref('');
const message = ref(null);
const SHIPPING_FEE = 20.00; // Phí ship cố định (chỉ để hiển thị)

// --- LOGIC TÍNH TOÁN ĐƠN HÀNG ---
const orderSummary = computed(() => {
    //bản chất là tìm voucher đã áp dụng từ props
    const appliedVoucher = props.vouchers.find(v => v.code === props.appliedVoucherCode) || null;

    // 1. Tính Subtotal (Tổng phụ)
    const subtotal = props.cart.reduce((acc, item) => acc + item.price * item.quantity, 0);

    // 2. Tính Discount
    let discount = 0;
    if (appliedVoucher) {
        discount = props.cart.reduce((acc, item) => {
            if (item.category === appliedVoucher.applicableCategory) {
                return acc + item.price * item.quantity * appliedVoucher.discount;
            }
            return acc;
        }, 0);
    }

    // 3. Tính thuế (Tax)
    const amountAfterDiscount = subtotal - discount;
    const tax = amountAfterDiscount > 0 ? amountAfterDiscount * props.TAX_RATE : 0;
    
    // 4. Tính Order Total (Tổng đơn hàng)
    const orderTotal = amountAfterDiscount + tax + SHIPPING_FEE;

    return { subtotal, discount, tax, orderTotal, appliedVoucher };
});

// --- LOGIC VOUCHER (Phát sự kiện lên App.vue) ---
const handleVoucherSubmit = () => {
    // Phát sự kiện lên App.vue để xử lý logic voucher phức tạp
    emit('apply-voucher', voucherInput.value.trim().toUpperCase());
};

// Theo dõi props.appliedVoucherCode để hiển thị thông báo thành công/thất bại
watch(() => props.appliedVoucherCode, (newCode) => {
    // Chỉ cập nhật thông báo khi đã có input voucher
    if (voucherInput.value.length > 0) {
        if (newCode) {
            message.value = { text: `Mã voucher đã áp dụng thành công.`, type: 'success' };
        } else {
            message.value = { text: 'Mã voucher không hợp lệ hoặc không áp dụng được cho giỏ hàng này.', type: 'error' };
        }
    }
});
</script>

<style scoped>
.text-custom-orange { color: #f97316 !important; }

.btn-custom-orange {
    background-color: #f97316;
    border-color: #f97316;
    color: white;
    font-weight: bold;
}
.btn-custom-orange:hover {
    background-color: #ea580c;
    border-color: #ea580c;
    color: white;
}
</style>