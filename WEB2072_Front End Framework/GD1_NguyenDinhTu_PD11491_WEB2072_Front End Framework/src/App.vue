<script setup>
import { ref, onMounted, provide} from 'vue';
import { useRouter } from 'vue-router'; 

// Import Components chung
import HeaderComponent from './components/users/Header.vue';
import FooterComponent from './components/users/Footer.vue';

// Khởi tạo router hook
const router = useRouter();

// --- TRẠNG THÁI VÀ DỮ LIỆU ---
const isLoading = ref(true);
const apiBaseUrl = 'http://localhost:3002';

// Dữ liệu dự phòng (Fallback data - dùng khi API lỗi hoặc chưa chạy)
const portfolioData = ref({
    personal: { 
        name: "Đang Tải...", 
        title: "...", 
        avatar: "https://placehold.co/100x100/94A3B8/FFFFFF?text=Loading",
        bio: "Đang tải dữ liệu từ API..."
    },
    education: [], 
    experience: [], 
    projects: [], 
    articles: [],
});

// Gọi api từ db.json
const apiFetch = async (url) => {
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`Lỗi HTTP! Status: ${response.status} cho URL: ${url}`);
        }
        return await response.json();
    } catch (error) {
        console.error(`Lỗi khi thực hiện fetch đến ${url}:`, error);
        throw error; // Ném lỗi để bên ngoài có thể xử lý tiếp
    }
};

//json-server --watch db.json --port 3002

//lấy dữ liệu từng trang
const fetchData = async () => {
    isLoading.value = true;
    try {
        const [personal, education, experience, projects, articles] = await Promise.all([
            apiFetch(`${apiBaseUrl}/personal`),
            apiFetch(`${apiBaseUrl}/education`),
            apiFetch(`${apiBaseUrl}/experience`),
            apiFetch(`${apiBaseUrl}/projects`),
            apiFetch(`${apiBaseUrl}/articles`),
        ]);

        // Cập nhật dữ liệu từ API
        portfolioData.value = { personal, education, experience, projects, articles };
        console.log("Dữ liệu đã được tải thành công từ API.");

    } catch (error) {
        console.error("Lỗi khi tải dữ liệu từ API. Sử dụng dữ liệu Mock Fallback.");
    } finally {
        isLoading.value = false;
    }
};


// --- TRẠNG THÁI BẢO MẬT ---
const isLoggedIn = ref(false);
const userRole = ref('guest'); 


//xác định vai trò người dùng
const loginAsAdmin = (role) => {
    isLoggedIn.value = true;
    userRole.value = role;
    router.push({ name: 'Dashboard' }); 
};

//hàm đăng xuất
const logout = () => {
    isLoggedIn.value = false;
    userRole.value = 'guest';
    router.push({ name: 'Home' }); 
};

// Cung cấp (Provide) để inject dữ liệu đến trang con
provide('portfolioData', portfolioData);
provide('apiBaseUrl', apiBaseUrl);
provide('fetchData', fetchData); 
provide('securityState', { isLoggedIn, userRole, loginAsAdmin, logout });

// --- Đảm bảo khi trang được load hết mới gọi api lấy dữ liệu ---
onMounted(fetchData);
</script>

<template>
    <div id="app-portfolio" class="d-flex flex-column"> 
        <!-- Header -->
        <HeaderComponent 
            v-if="!isLoggedIn" :personal-data="portfolioData.value?.personal || {}" 
        />
        
        <main class="flex-grow-1"> 
            <!-- Vùng hiển thị Component theo Route -->
            <router-view v-slot="{ Component }">
                <component :is="Component" />
            </router-view>
        </main>

        <!-- Footer -->
        <FooterComponent 
            v-if="!isLoggedIn" :personal-data="portfolioData.value?.personal || {}" 
        />
    </div>
</template>