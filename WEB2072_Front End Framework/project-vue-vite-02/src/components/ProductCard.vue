<template>
    <div class="card border-0 shadow-sm p-4 rounded-4" style="max-width: 600px; margin: auto; background: #f5f7ff;">
        <!-- Hình sản phẩm với Carousel -->
        <div
            :key="selectedColor?.name"
            :id="`productCarousel-${name.replace(/\s+/g, '-')}-${selectedColor?.name || 'default'}`"
            class="carousel slide position-relative"
            data-bs-ride="carousel"
        >
            <div class="carousel-inner" style="height: 250px; width: 400px;">
                <div
                    v-for="(img, index) in selectedImages"
                    :key="index"
                    class="carousel-item"
                    :class="{ active: index === 0 }"
                    style="height: 100%; width: 100%; display: flex; align-items: center; justify-content: center;"
                >
                    <img
                        :src="img"
                        class="d-block w-100 rounded-3"
                        style="object-fit: contain;"
                        alt="product image"
                    />
                </div>
            </div>

            <button
                class="carousel-control-prev"
                type="button"
                :data-bs-target="`#productCarousel-${name.replace(/\s+/g, '-')}-${selectedColor?.name || 'default'}`"
                data-bs-slide="prev"
            >
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>

            <button
                class="carousel-control-next"
                type="button"
                :data-bs-target="`#productCarousel-${name.replace(/\s+/g, '-')}-${selectedColor?.name || 'default'}`"
                data-bs-slide="next"
            >
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
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
                    :style="{ backgroundColor: color.code, border: selectedColor?.name === color.name ? '3px solid #FF99FF' : '1px solid #ccc' }"
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
                    v-for="size in sizes"
                    :key="size"
                    @click="selectSize(size)"
                    class="btn rounded-pill px-3 "
                    :class="selectedSize === size ? 'btn-dark' : 'btn-outline-dark'">
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
                <input type="text" class="form-control text-center" v-model="quantity" readonly />
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
</template>

<script setup>
import { ref, computed } from 'vue'

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
    sizes: Array
})

const selectedColor = ref(props.colors[0])
const selectedSize = ref(null)
const quantity = ref(1)

const allImages = props.colors.map(color => color.imgs).flat();

console.log(allImages);

// Mỗi màu có thể chứa nhiều ảnh
const selectedImages = computed(() => selectedColor.value?.imgs || [selectedColor.value?.img])

const canBuy = computed(() =>
    selectedColor.value && selectedSize.value && quantity.value > 0 && props.inStock
)

function selectColor(color) {
    selectedColor.value = color
}


function selectSize(size) {
    selectedSize.value = size
}

function increaseQty() {
    quantity.value++
}

function decreaseQty() {
    if (quantity.value > 1) quantity.value--
}

function buyNow() {
    alert(`Đã đặt hàng: ${props.name} (${selectedSize.value})`)
}
</script>