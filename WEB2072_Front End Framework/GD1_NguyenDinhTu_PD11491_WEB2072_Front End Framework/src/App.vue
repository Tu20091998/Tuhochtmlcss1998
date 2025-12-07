<script setup>
// =======================================================
// 1. IMPORTS
// =======================================================
import { ref, onMounted, provide } from 'vue';
import { useRouter } from 'vue-router'; 

// Components chung (User Layout)
import HeaderComponent from './components/users/Header.vue';
import FooterComponent from './components/users/Footer.vue';


// =======================================================
// 2. SETUP HOOKS & KHAI BÁO BIẾN CỐ ĐỊNH
// =======================================================
const router = useRouter();
const apiBaseUrl = 'http://localhost:3002';

//json-server --watch db.json --port 3002

// --- TRẠNG THÁI CHUNG ---
const isLoading = ref(true);


// =======================================================
// 3. DỮ LIỆU & LOGIC LẤY API
// =======================================================

// Dữ liệu reactive (Chứa toàn bộ data từ API)
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

// Hàm Fetch API chung
const apiFetch = async (url) => {
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`Lỗi HTTP! Status: ${response.status} cho URL: ${url}`);
        }
        return await response.json();
    } catch (error) {
        console.error(`Lỗi khi thực hiện fetch đến ${url}:`, error);
        throw error;
    }
};

// Hàm tải dữ liệu chính
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

        portfolioData.value = { personal, education, experience, projects, articles };
        console.log("Dữ liệu đã được tải thành công từ API.");

    } catch (error) {
        console.error("Lỗi khi tải dữ liệu từ API. Sử dụng dữ liệu Mock Fallback.");
    } finally {
        isLoading.value = false;
    }
};

// =======================================================
// 4. LOGIC BẢO MẬT (ADMIN)
// =======================================================
const isLoggedIn = ref(false);
const userRole = ref('guest'); 

// Hàm Đăng nhập Admin
const loginAsAdmin = (role) => {
    isLoggedIn.value = true;
    userRole.value = role;
    // Lưu ý: Đã có lỗi trong route name 'Dashboard'. 
    // Nếu bạn đã sửa router thành 'AdminDashboard', hãy dùng nó.
    router.push({ name: 'Dashboard' }); 
};

// Hàm Đăng xuất
const logout = () => {
    isLoggedIn.value = false;
    userRole.value = 'guest';
    router.push({ name: 'Home' }); 
};


// =======================================================
// 5. PROVIDE & LIFECYCLE HOOKS
// =======================================================

// Cung cấp dữ liệu và hàm cho các component con
provide('portfolioData', portfolioData);
provide('apiBaseUrl', apiBaseUrl);
provide('fetchData', fetchData); 
provide('securityState', { isLoggedIn, userRole, loginAsAdmin, logout });

// Gọi API khi component được mount
onMounted(fetchData);
</script>

<template>
    <div id="app-portfolio" class="d-flex flex-column min-vh-100"> 
        
        <HeaderComponent 
            v-if="!isLoggedIn" 
            :personal-data="portfolioData.value?.personal || {}" 
        />
        
        <main class="flex-grow-1"> 
            <router-view v-slot="{ Component }">
                <component :is="Component" />
            </router-view>
        </main>

        <FooterComponent 
            v-if="!isLoggedIn" 
            :personal-data="portfolioData.value?.personal || {}" 
        />
    </div>
</template>