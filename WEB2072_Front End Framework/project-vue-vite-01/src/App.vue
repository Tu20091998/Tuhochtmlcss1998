<script setup lang="ts">
import { ref } from 'vue'
import ProductCard from './components/ProductCard.vue'

const loading = ref(false)

// Dữ liệu sản phẩm mẫu
const product = ref({
  name: 'VinFast-VF8',
  description: 'Dòng xe mang phong cách Bác Vượng',
  price: 1200,
  oldPrice: 1500,
  rating: 4.5,
  reviews: '25',
  isBestseller: true,
  inStock: true,
  colors: [
    { name: 'White', code: '#f0f0f0', imgs: ['https://vinfast-vn.vn/wp-content/uploads/2023/10/vinfast-vf8-1.png'] },
    { name: 'Red', code: '#FF0000', imgs: ['https://vinfastotominhdao.vn/wp-content/uploads/VinFast-VF8-1.jpg'] },
    { name: 'Black', code: '#000000', imgs: ['https://otovinfastsaigon.vn/wp-content/uploads/2020/06/vinfast-vf8-gia-xe-18.jpg'] },
    { name: 'Green', code: '#008000', imgs: ['https://hips.hearstapps.com/hmg-prod/images/2023-vinfast-vf8-9283-64638ba8c149b.jpg?crop=0.641xw:0.543xh;0.114xw,0.346xh&resize=2048:*'] },
    { name: 'Blue', code: '#0000FF', imgs: ['https://vinfast-cars.vn/wp-content/uploads/2024/10/vinfast-vf8-xanh-duong.png'] },
  ],
  sizes: ["4 Ghế", "7 Ghế", "12 Ghế","16 Ghế"]
})
</script>

<template>
  <div class="container py-5">
    <div v-if="loading" class="text-center mt-5">
      <div class="spinner-border text-primary" role="status"></div>
      <p>Đang tải dữ liệu...</p>
    </div>

    <ProductCard v-else v-bind="product" />
  </div>


  <!-- <div>
    <a href="https://vite.dev" target="_blank">
      <img src="/vite.svg" class="logo" alt="Vite logo" />
    </a>
    <a href="https://vuejs.org/" target="_blank">
      <img src="./assets/vue.svg" class="logo vue" alt="Vue logo" />
    </a>
  </div>
  <HelloWorld msg="Vite + Vue" /> -->
</template>

<style scoped>
.logo {
  height: 6em;
  padding: 1.5em;
  will-change: filter;
  transition: filter 300ms;
}
.logo:hover {
  filter: drop-shadow(0 0 2em #646cffaa);
}
.logo.vue:hover {
  filter: drop-shadow(0 0 2em #42b883aa);
}
</style>
