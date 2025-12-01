<template>
    <!-- 1. Tóm tắt Đơn hàng -->
    <div class="card shadow-lg border-0 rounded-4 p-4 mb-4">
        <h2 class="fs-5 fw-bold text-dark mb-4 border-bottom pb-3">Tóm tắt đơn hàng</h2>
        
        <!-- Chi tiết tính tiền từng sản phẩm -->
        <div class="small text-secondary mb-3 border-bottom pb-3">
            <div v-for="item in cart" :key="item.id" class="d-flex justify-content-between mb-1">
                <span class="text-muted">x{{ item.quantity }} {{ item.name }}</span>
                <span class="fw-medium text-dark">${{ (item.price * item.quantity).toFixed(2) }}</span>
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

        <!-- Tổng đơn hàng -->
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
            @click="notifyPayment"
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
    taxRate: { type: Number, default: 0.08 },
});

const emit = defineEmits(['apply-voucher']);

const voucherInput = ref('');
const message = ref(null);

// --- LOGIC TÍNH TOÁN ĐƠN HÀNG ---
const orderSummary = computed(() => {

    //bản chất là so sánh mã voucher nhập vào với mã voucher đã áp dụng
    const appliedVoucher = props.vouchers.find(v => v.code === props.appliedVoucherCode) || null;

    // 1. Tính Subtotal 
    const subtotal = props.cart.reduce((acc, item) => {
        //các mặt hàng khác không được chọn sẽ không tính vào tổng subtotal
        return acc + (item.isChecked ? item.price * item.quantity : 0);
    }, 0);

    // 2. Tính Discount
    let discount = 0;
    if (appliedVoucher) {
        discount = props.cart.reduce((acc, item) => {

            // Chỉ áp dụng giảm giá cho các mặt hàng thuộc danh mục áp dụng của voucher
            if (item.category === appliedVoucher.applicableCategory) {
                // Tính tổng giảm giá
                return acc + item.price * item.quantity * appliedVoucher.discount;
            }

            return acc;
        }, 0);
    }

    // 3. Tính thuế (Tax)
    const amountAfterDiscount = subtotal - discount;

    //dòng này để tính thuế không âm
    const tax = amountAfterDiscount > 0 ? amountAfterDiscount * props.taxRate : 0;
    
    // 4. Tính Order Total (Tổng đơn hàng)
    const orderTotal = amountAfterDiscount + tax;

    // Trả về các giá trị đã tính toán
    return { subtotal, discount, tax, orderTotal, appliedVoucher };
});

// --- LOGIC VOUCHER (Phát sự kiện lên App.vue) ---
const handleVoucherSubmit = () => {
    // Phát sự kiện lên App.vue
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

// Hàm thông báo thanh toán
const notifyPayment = () => {
    //kiểm tra logic giỏ hàng trống
    if (props.cart.length === 0) {
        alert('Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm trước khi thanh toán.');
        return;
    }

    //kiểm tra logic tổng đơn hàng âm hoặc bằng 0
    if (orderSummary.value.orderTotal <= 0) {
        alert('Tổng đơn hàng không hợp lệ. Vui lòng kiểm tra giỏ hàng của bạn.');
        return;
    }

    // Hiển thị thông báo đặt hàng thành công
    alert(`Cảm ơn bạn đã thanh toán đơn hàng trị giá $${orderSummary.value.orderTotal.toFixed(2)}!`);
};
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