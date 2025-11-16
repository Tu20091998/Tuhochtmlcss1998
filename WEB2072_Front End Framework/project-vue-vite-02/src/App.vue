<script setup lang="ts">
import { ref } from 'vue'
import ProductCard from './components/ProductCard.vue'

const loading = ref(false)

// Dữ liệu sản phẩm mẫu
const product = ref({
  name: 'VinFast-VF8',
  description: 'Dòng xe mang phong cách, sử dụng pin tốt nhất hiện nay !',
  price: 1200,
  oldPrice: 1500,
  rating: 4.5,
  reviews: '25',
  isBestseller: true,
  inStock: true,
  colors: [
    { name: 'White', code: '#f0f0f0', 
      imgs: [
      'https://vinfast-vn.vn/wp-content/uploads/2023/10/vinfast-vf8-1.png',
      'https://vinfast-timescity.com.vn/wp-content/uploads/2022/12/vinfast-vf8-2023-plus-trang-brahminy-white-2_optimized-1024x768.jpg',
      'https://vinfast-timescity.com.vn/wp-content/uploads/2022/12/vinfast-vf8-2023-plus-trang-brahminy-white-3_optimized-scaled.jpg',
      'https://vinfast-timescity.com.vn/wp-content/uploads/2022/12/vinfast-vf8-eco-2023-trang-brahminy-white-1_optimized.jpg',
      'https://vfxanh.vn/wp-content/uploads/2024/08/33.2.png'
    ] 
    },
    { name: 'Red', code: '#FF0000', 
      imgs: [
        'https://vinfastotominhdao.vn/wp-content/uploads/VinFast-VF8-1.jpg',
        'https://vinfast-tiengiang.vn/wp-content/uploads/2023/12/vinfast-231207_0042_vf-8s-765x430.jpg',
        'https://xehay.vn/uploads/images/2023/3/01/xehay-VF-8-060422-1.jpg',
        'https://vinfastotominhdao.vn/wp-content/uploads/VinFast-VF8-7.jpg',
        'https://cdn.gianhangvn.com/image/vinfast-vf8-lux-anh14-9r27ws8.jpg'
      ] 
    },
    { name: 'Black', code: '#000000', 
      imgs: [
        'https://otovinfastsaigon.vn/wp-content/uploads/2020/06/vinfast-vf8-gia-xe-18.jpg',
        'https://giaxeoto247.com/wp-content/uploads/2022/08/o-to-dien-VinFast-VF-8-mau-Den-Jet-Black.jpg',
        'https://media.ed.edmunds-media.com/vinfast/lt/vinfast_f34_lt_411221_1600.jpg',
        'https://giaxeoto247.com/wp-content/uploads/2022/08/o-to-dien-VinFast-VF-8-mau-Den-Jet-Black.jpg',
        'https://i.ytimg.com/vi/yE5Zujp_BHM/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLAjrXSKIf9zdUE4LtYyXb3v-PUkTA'
      ] 
    },
    { name: 'Green', code: '#008000', 
        imgs: [
        'https://hips.hearstapps.com/hmg-prod/images/2023-vinfast-vf8-9283-64638ba8c149b.jpg?crop=0.641xw:0.543xh;0.114xw,0.346xh&resize=2048:*',
        'https://cdn2.tuoitre.vn/thumb_w/480/471584752817336320/2024/1/30/vinfast-vf-8-my-1706585047078553530582.jpg',
        'https://kingwrap.vn/wp-content/uploads/2025/02/dan-decal-doi-mau-vinfast-vf8-1.jpg.webp',
        'https://images-stag.jazelc.com/uploads/theautopian-m2en/vf8_rear.jpg',
        'https://hips.hearstapps.com/hmg-prod/images/2023-vinfast-vf8-8311-64638b6f4efeb.jpg?crop=0.651xw:0.550xh;0.182xw,0.347xh&resize=2048:*'
      ] 
    },
    { name: 'Blue', code: '#0000FF', 
      imgs: [
        'https://vinfast-cars.vn/wp-content/uploads/2024/10/vinfast-vf8-xanh-duong.png',
        'https://vinfast-timescity.com.vn/wp-content/uploads/2023/01/bang-mau-xe-vinfast-vf8-2023-3_optimized.jpeg',
        'https://vinfastquangnam.com.vn/wp-content/uploads/2024/08/vinfast-vf8-city-edition-3-6f80-5570.jpg',
        'https://drive.gianhangvn.com/image/2sf5swa-2608366j33309.jpg',
        'https://oto-vinfastsaigon.com/wp-content/uploads/2024/06/dang-truoc-xe-vf8-lux-hoa-long-013_oto-vinfastsaigon.com_.webp'
      ] 
    },
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
</template>
