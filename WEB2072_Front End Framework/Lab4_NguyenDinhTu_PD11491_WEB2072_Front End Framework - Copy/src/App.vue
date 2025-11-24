<script setup lang="ts">
  import { ref, onMounted } from 'vue'
  import ProductCard from './components/ProductCard.vue'
  
  const loading = ref(true)
  const products = ref<any[]>([])      // mảng sản phẩm
  const quantities = ref<number[]>([]) // quantity cho từng sản phẩm
  
  onMounted(async () => {
    const res = await fetch("http://localhost:3000/products")
    const data = await res.json()
    products.value = data // lấy tất cả sản phẩm
    quantities.value = products.value.map(() => 0) // khởi tạo quantity mặc định
    loading.value = false
  })
</script>

<template>
  <div class="container py-5">
    
    <!-- Loading -->
    <div v-if="loading" class="text-center mt-5">
      <div class="spinner-border text-primary"></div>
      <p>Đang tải dữ liệu...</p>
    </div>

    <!-- Lặp qua tất cả sản phẩm -->
    <div class="row" v-else>
      <div class="col-12 col-md-6 col-lg-4 mb-4" v-for="(product, index) in products" :key="product.id">
        <ProductCard
          :id="product.id"
          :name="product.name"
          :description="product.description"
          :price="product.price"
          :oldPrice="product.oldPrice"
          :rating="product.rating"
          :reviews="product.reviews"
          :isBestseller="product.isBestseller"
          :inStock="product.inStock"
          :colors="product.colors"
          :sizes="product.sizes"
          v-model:quantity="quantities[index]"
        />
      </div>
    </div>

  </div>
</template>
