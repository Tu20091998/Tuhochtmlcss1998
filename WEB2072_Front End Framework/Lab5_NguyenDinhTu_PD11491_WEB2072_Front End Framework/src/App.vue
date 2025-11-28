<template>
  <div class="min-vh-100 bg-light font-sans">
    <!-- Cần thêm Bootstrap CDN link trong index.html hoặc main.js -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

    <!-- Header (Tái tạo theo ảnh mẫu bằng Navbar Bootstrap) -->
    <header class="navbar navbar-expand-lg navbar-light bg-white shadow-sm border-bottom">
      <div class="container-xxl">
        <a class="navbar-brand fs-4 fw-bold" href="#">Chăm sóc sắc đẹp</a>
        
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
          <ul class="navbar-nav gap-4">
            <li class="nav-item"><a class="nav-link text-secondary" href="#">Về chúng tôi</a></li>
            <li class="nav-item"><a class="nav-link text-secondary" href="#">Sản phẩm</a></li>
            <li class="nav-item"><a class="nav-link text-secondary" href="#">Câu hỏi thường gặp</a></li>
          </ul>
        </div>

        <div class="d-flex align-items-center gap-3 text-secondary">
          <!-- Icons (Search, Cart, User) -->
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
          <div class="position-relative">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6em;">{{ totalItems }}</span>
          </div>
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
        </div>
      </div>
    </header>

    <!-- Nội dung chính -->
    <main class="container-xxl py-5">
      <div class="row g-4">
        
        <!-- Cột trái: Danh sách sản phẩm -->
        <div class="col-lg-8">
          <div class="card shadow-sm border-0 rounded-4 p-4">
            <h1 class="fs-4 fw-bold text-dark mb-4 border-bottom pb-3 d-flex align-items-center">
              Giỏ hàng của tôi
              <span class="ms-2 px-3 py-1 fw-semibold rounded-pill bg-light-orange text-custom-orange" style="font-size: 0.8em;">{{ totalItems }}</span>
            </h1>

            <!-- Thao tác chung -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <label class="d-flex align-items-center form-check-label text-secondary">
                    <input type="checkbox" class="cart-checkbox form-check-input me-2" checked />
                    Chọn tất cả sản phẩm
                </label>
                <div class="text-sm text-secondary">
                  <span class="me-3">Tất cả giỏ hàng</span>
                  <span class="fw-bold">Bộ lọc</span>
                </div>
            </div>

            <!-- LOADING STATE (Lab 7) -->
            <div v-if="loading" class="d-flex justify-content-center align-items-center py-5 text-secondary">
              <div class="spinner-border text-primary me-3" role="status" style="width: 1.5rem; height: 1.5rem;"></div>
              <span>Đang tải dữ liệu giỏ hàng từ API...</span>
            </div>
            
            <!-- Danh sách CartItem -->
            <div v-else class="list-group list-group-flush">
              <CartItem
                v-for="item in cart"
                :key="item.id"
                :item="item"
                @update-quantity="handleQuantityChange"
              />
            </div>
          </div>
        </div>

        <!-- Cột phải: Tóm tắt đơn hàng  -->
        <div class="col-lg-4">
          <OrderSummary 
            :cart="cart"
            :vouchers="vouchers"
            :applied-voucher-code="appliedVoucherCode"
            :tax-rate="TAX_RATE"
            @apply-voucher="handleApplyVoucher"
          />
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import CartItem from './components/CartItem.vue'; // Giả lập import component con
import OrderSummary from './components/OrderSummary.vue'; // Giả lập import component con

// --- CẤU HÌNH API ---
const BASE_API_URL = 'http://localhost:3003'; 

// --- STATE QUẢN LÝ (ref) ---
const cart = ref([]);
const loading = ref(true);
const appliedVoucherCode = ref(null);
const vouchers = ref([]);

const TAX_RATE = 0.08; // Thuế 8%

// --- LOAD DỮ LIỆU THẬT TỪ API (Đã sửa lỗi URL) ---
onMounted(async () => {
  loading.value = true;
  
  // đường dẫn tài nguyên
  const CART_API_URL = `${BASE_API_URL}/cartItems`;
  const VOUCHERS_API_URL = `${BASE_API_URL}/vouchers`;

  try {
    console.log(`Đang cố gắng fetch dữ liệu từ: ${CART_API_URL} và ${VOUCHERS_API_URL}`);
    
    //Thực hiện hai cuộc gọi API song song
    const [cartResponse, vouchersResponse] = await Promise.all([
        fetch(CART_API_URL),
        fetch(VOUCHERS_API_URL)
    ]);
    
    // 3. Kiểm tra lỗi HTTP cho cả hai response
    if (!cartResponse.ok || !vouchersResponse.ok) {
        throw new Error(`HTTP error! status: Cart=${cartResponse.status}, Vouchers=${vouchersResponse.status}`);
    }
    
    // 4. Phân tích JSON từ cả hai response
    cart.value = await cartResponse.json();
    vouchers.value = await vouchersResponse.json();
    
    console.log('Dữ liệu Giỏ hàng và Voucher đã tải thành công.');

  } catch (error) {
    console.error("LỖI KHI TẢI DỮ LIỆU API:", error.message);
    // Thông báo cho người dùng trên UI (nếu cần)
    cart.value = [];
    vouchers.value = [];
  } finally {
    loading.value = false;
  }
});

// --- HÀM XỬ LÝ SỰ KIỆN TỪ COMPONENT CON ---

// Xử lý sự kiện thay đổi số lượng từ CartItem.vue
const handleQuantityChange = (id, newQuantity) => {
  const item = cart.value.find(item => item.id === id);
  if (item) {
    item.quantity = newQuantity; 
  }
};

// Xử lý sự kiện áp dụng voucher từ OrderSummary.vue
const handleApplyVoucher = (code) => {
  const foundVoucher = vouchers.value.find(v => v.code === code);

  if (!foundVoucher) {
    appliedVoucherCode.value = null; 
    return;
  }

  // Kiểm tra áp dụng voucher theo danh mục sản phẩm
  const isApplicable = cart.value.some(item => item.category === foundVoucher.applicableCategory);

  if (isApplicable) {
    appliedVoucherCode.value = foundVoucher.code;
  } else {
    appliedVoucherCode.value = null;
  }
};

// --- TÍNH TOÁN (computed properties) ---
const totalItems = computed(() => {
    return cart.value.reduce((acc, item) => acc + item.quantity, 0);
});
</script>

<style scoped>
/* Custom styles để đồng bộ giao diện Bootstrap */
.min-vh-100 { min-height: 100vh; }
.bg-light { background-color: #f8f9fa !important; }

/* Custom variables for color matching the image */
.text-custom-orange { color: #f97316 !important; }
.bg-light-orange { background-color: #fff7ed !important; }

/* Custom class for the checkout button color */
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
.cart-checkbox {
    accent-color: #f97316;
}
</style>