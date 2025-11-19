<template>
<div>
    <div class="card border-0 shadow-sm p-4 rounded-4" style="max-width: 600px; margin: auto; background: #f5f7ff; box-shadow: 10px 10px 10px rgba(0, 0, 0, 0.3);">
        <div id="carouselExample" class="carousel slide" ref="carouselRef">
            <div class="carousel-inner">
                <div class="carousel-item active" 
                v-for="(img, index) in allImages" style="aspect-ratio: 16 / 9; overflow: hidden;"
                :key="index">
                    <img :src="img" class="d-block" alt="ProductImage" style="object-fit: contain; width: 100%; height: auto;">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- Giá -->
        <div class="d-flex align-items-center gap-2 mb-1 mt-3">
            <h4 class="text-danger mb-0">${{ price.toLocaleString() }}</h4>
            <span class="text-muted text-decoration-line-through">₱{{ oldPrice.toLocaleString() }}</span>

            <!-- Label Best Seller -->
            <div
                v-if="isBestseller"
                class="badge bg-warning text-dark m-2">
                Best Seller
            </div>
        </div>

        <!-- Tên + rating -->
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-bold mb-1">{{ name }}</h5>
            <div class="text-warning small">
                ⭐ {{ rating }} <span class="text-dark">({{ reviews }})</span>
            </div>
        </div>

        <!-- Mô tả -->
        <p class="text-muted small" style="text-align: left;">{{ description }}</p>

        <!-- Màu -->
        <div class="mb-3">
            <h5 style="text-align: left;">Color</h5>
            <div class="d-flex gap-2 mt-2">
                <div
                    v-for="(color, index) in colors"
                    :key="index"
                    :style="{ 
                        backgroundColor: color.code, 
                        // Thay đổi border
                        border: selectedColor?.name === color.name ? '2px solid white' : '1px solid #ccc',
                        // Thêm box-shadow khi được chọn
                        boxShadow: selectedColor?.name === color.name ? `0 0 10px 3px ${color.code}` : 'none' 
                    }"
                    class="rounded-circle"
                    style="width: 32px; height: 32px; cursor: pointer;"
                    @click="selectColor(color)">
                </div>
            </div>
        </div>

        <!-- Size -->
        <div class="mb-3">
            <h5 style="text-align: left;">Size</h5>
            <div class="d-flex flex-wrap gap-2 mt-2">
                <button
                    v-for="size in props.sizes"
                    :key="size"
                    @click="selectSize(size)"
                    class="btn rounded-pill px-3 "
                    :class="props.sizes === size ? 'btn-dark' : 'btn-outline-dark'">
                    {{ size }}
                </button>
            </div>
        </div>

        <!-- Số lượng -->
        <div class="mb-3">
            <div class="d-flex align-items-center gap-3 mt-2">
                <h5 style="text-align: left;">Quantity</h5>
                <span :class="inStock ? 'badge bg-success' : 'badge bg-danger'">
                    {{ inStock ? 'In Stock' : 'Out of Stock' }}
                </span>
            </div>
            <div class="input-group" style="width: 120px;">
                <button class="btn btn-outline-secondary" @click="decreaseQty">-</button>
                <input type="text" class="form-control text-center" :value="props.quantity" readonly />
                <button class="btn btn-outline-secondary" @click="increaseQty">+</button>
            </div>
        </div>

        <!-- Nút hành động -->
        <div class="d-flex gap-2 p-3 border rounded-3 align-items-center">
            <button class="btn btn-lg btn-outline-light border-0 text-dark position-relative p-0" style="width: 44px; height: 44px;">
                <i class="bi bi-heart fs-4"></i>
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                    <span class="visually-hidden">New items</span>
                </span>
            </button>

            <button class="btn btn-lg btn-outline-light border-0 text-dark position-relative p-0" style="width: 44px; height: 44px;">
                <i class="bi bi-bag fs-4"></i>
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                    <span class="visually-hidden">New items</span>
                </span>
            </button>
        
            <button
                class="btn flex-fill fw-bold py-3"
                :disabled="!canBuy"
                @click="buyNow" style="background-color: #000080; color: #f5f7ff;">
                Buy Now
            </button>
        </div>
    </div>
</div>
</template>

<script setup>
import { ref, computed, onUnmounted, onMounted, reactive, watch } from 'vue'

//khai báo prop để nhận thông tin từ trang app.vue
const props = defineProps({
    name: String,
    description: String,
    price: Number,
    oldPrice: Number,
    rating: Number,
    reviews: String,
    isBestseller: Boolean,
    inStock: Boolean,
    colors: Array,
    sizes: Array,
    quantity: Number
})

//khi chọn thay đổi số lượng thì log ra số lượng vừa thay đổi
watch(()=> props.quantity, (newValue, oldValue)=>{
    if(newValue != oldValue){
        console.log("Giá trị của số lượng là: " + newValue);
    }
});


//khi thông tin được điền đầy đủ và điều kiện thoả mãn thì cho đặt mua
const selectedColor = ref(props.colors[0]);

//lấy toàn bộ mảng hình ảnh
const allImages = computed(() => selectedColor.value.imgs);

const canBuy = computed(() =>
    selectedColor.value && selectedSize.value && props.quantity > 0 && props.inStock
)

//gọi hàm để điều khiển carousel
let carouselInstance = null
const carouselRef = ref(null)
onMounted(() => {
    // Khởi tạo Bootstrap Carousel
    carouselInstance = new bootstrap.Carousel(carouselRef.value)
})

function selectColor(color) {
    selectedColor.value = color

    //khi chọn màu thì in ra màu đang được chọn
    console.log("Màu đang được chọn là: "+ selectedColor.value.name);
    console.log("Mảng hình ảnh đang được chọn là: ", selectedColor.value.imgs);

    const colorStartIndex = props.colors.indexOf(color);

    // Chuyển carousel đến ảnh đầu của màu
    carouselInstance.to(colorStartIndex)
}


//chọn size
const selectedSize = ref(props.sizes);
function selectSize(size) {
    selectedSize.value = size
    console.log("Size đang được chọn là: "+ selectedSize.value);
}

//khi thay đổi số lượng
const emit = defineEmits(['update:quantity']);

function increaseQty() {
    emit('update:quantity',props.quantity + 1);
}

function decreaseQty() {
    if (props.quantity > 1) {
        emit('update:quantity',props.quantity - 1);
    }
}

//hiển thị nếu đặt được hàng
function buyNow() {
    alert(`Đã đặt hàng: ${props.name} (${selectedSize.value})`)
}
</script>