<template>
  <div class="min-vh-100 bg-light font-sans">
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
                    <input 
                    type="checkbox" 
                    class="cart-checkbox form-check-input me-2" 
                    :checked="selectAll" 
                    @change="handleSelectAllChange"/>
                    Chọn tất cả sản phẩm
                </label>
                <div class="text-sm text-secondary">
                  <span class="me-3">Tất cả giỏ hàng</span>
                  <span class="fw-bold">Bộ lọc</span>
                </div>
            </div>

            <!-- LOADING STATE -->
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
                @update-checked="handleCheckedChange"
              />
            </div>
          </div>
        </div>

        <!-- Cột phải: Tóm tắt đơn hàng  -->
        <div class="col-lg-4">
          <OrderSummary 
            :cart="cart"
            :vouchers="vouchers"
            :tax-rate="TAX_RATE"
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
const vouchers = ref([]);

const TAX_RATE = 0.08; // Thuế 8%

////json-server --watch db.json --port 3003

// --- LOAD DỮ LIỆU TỪ API ---
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

  // Tìm sản phẩm trong giỏ hàng theo id
  const item = cart.value.find(item => item.id === id);

  // Cập nhật số lượng nếu tìm thấy
  if (item) {
    item.quantity = newQuantity; 
  }
};


// Xử lý sự kiện thay đổi trạng thái checked từ CartItem.vue
const handleCheckedChange = (id, isChecked) => {
  // Tìm sản phẩm trong giỏ hàng theo id
  const item = cart.value.find(item => item.id === id);

  // Cập nhật trạng thái checked nếu tìm thấy
  if (item) {
    item.isChecked = isChecked;
  }
};


// Nếu như tất cả mặt hàng được check thì true
const selectAll = computed(() => {
    // Nếu giỏ hàng rỗng, trả về false
    if (cart.value.length === 0) return false; 
    
    // Sử dụng .every() để kiểm tra xem tất cả các item đều có isChecked = true không
    return cart.value.every(item => item.isChecked);
});


// Trong CartView.vue
const handleSelectAllChange = (event) => {
    // 1. Lấy trạng thái checked mới từ sự kiện (true nếu check, false nếu uncheck)
    const newSelectAllState = event.target.checked; 

    // 2. Duyệt qua toàn bộ mảng cart
    cart.value.forEach(item => {
        // 3. Cập nhật thuộc tính isChecked của TẤT CẢ sản phẩm
        item.isChecked = newSelectAllState; 
    });
};


//tính tổng số mặt hàng trong giỏ
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