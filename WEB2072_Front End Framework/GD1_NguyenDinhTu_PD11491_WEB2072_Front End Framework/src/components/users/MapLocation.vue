<script setup>
import { computed } from 'vue';
import { inject } from 'vue';

// Lấy dữ liệu cá nhân (để lấy địa chỉ)
const portfolioData = inject('portfolioData');
const personalData = computed(() => portfolioData.value?.personal || {});


</script>

<template>
    <div class="card bg-white p-4 p-md-5 rounded-3 shadow-lg map-container">
        <h2 class="fs-3 fw-bold text-dark mb-4 border-bottom pb-2">🗺️ Vị trí của tôi</h2>
        
        <p class="mt-4 small text-secondary">
            Địa chỉ liên hệ chính: <p class="fw-semibold text-dark">{{ personalData.address || 'Đang cập nhật...' }}</p>
            Số điện thoại liên hệ chính: <p class="fw-semibold text-dark">{{ personalData.phone || 'Đang cập nhật...' }}</p>
            Email liên hệ chính: <p class="fw-semibold text-dark">{{ personalData.email || 'Đang cập nhật...' }}</p>
        </p>
        
        <div class="map-wrapper">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3834.2614286788726!2d108.16491284207486!3d16.051918045102948!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31421916812dec4b%3A0x5a2394d6c0835e14!2zMTE2IE5ndXnhu4VuIEh1eSBUxrDhu59uZywgSG_DoCBBbiwgTGnDqm4gQ2hp4buDdSwgxJDDoCBO4bq1bmcgNTUwMDAwLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1765451170332!5m2!1svi!2s" width="1200" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</template>

<style scoped>
.map-wrapper {
    /* Đảm bảo khung chứa bản đồ có tỷ lệ 16:9 */
    position: relative;
    width: 100%;
    height: auto;
    padding-top: 56.25%; /* 16:9 Aspect Ratio */
}

.map-wrapper iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
}

.map-container{
    width: 50%;
}
</style>