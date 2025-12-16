<script setup>

//  IMPORTS
import { ref, onMounted, provide } from 'vue';
import { useRouter } from 'vue-router'; 

// Components chung (User Layout)
import HeaderComponent from './components/users/Header.vue';
import FooterComponent from './components/users/Footer.vue';


//  SETUP HOOKS & KHAI BÁO BIẾN CỐ ĐỊNH
const router = useRouter();
const apiBaseUrl = 'http://localhost:3005';

//link để mở mongodb : mongodb://localhost:27017/

// --- TRẠNG THÁI CHUNG ---
const isLoading = ref(true);


//  DỮ LIỆU & LOGIC LẤY API
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
        const [personal, education, experience, projects, articles, messages, users] = await Promise.all([
            apiFetch(`${apiBaseUrl}/personal`),
            apiFetch(`${apiBaseUrl}/education`),
            apiFetch(`${apiBaseUrl}/experience`),
            apiFetch(`${apiBaseUrl}/projects`),
            apiFetch(`${apiBaseUrl}/articles`),
            apiFetch(`${apiBaseUrl}/messages`),
            apiFetch(`${apiBaseUrl}/users`),
        ]);

        portfolioData.value = { personal, education, experience, projects, articles, messages, users};

        console.log("Dữ liệu đã được tải thành công từ API.");
    } catch (error) {
        console.error("Lỗi khi tải dữ liệu từ API. Sử dụng dữ liệu Mock Fallback.");
    } finally {
        isLoading.value = false;
    }
};


// LOGIC BẢO MẬT (ADMIN)
const isLoggedIn = ref(false);
const userRole = ref('guest'); 

// Hàm Đăng nhập Admin
const loginAsAdmin = (role) => {
    isLoggedIn.value = true;
    userRole.value = role;
    router.push({ name: 'Dashboard' }); 
};

// Hàm Đăng xuất
const logout = () => {
    isLoggedIn.value = false;
    userRole.value = 'guest';
    router.push({ name: 'LoginAdmin' }); 
};


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
        />
        
        <main class="flex-grow-1"> 
            <router-view v-slot="{ Component }">
                <transition name="fade" mode="out-in">
                    <component :is="Component" />
                </transition>
            </router-view>
        </main>

        <FooterComponent 
            v-if="!isLoggedIn" 
            :personal-data="portfolioData.value?.personal || {}" 
        />
    </div>
</template>

<style>
    #app-portfolio{
        background-color: #EEEEEE;
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity 0.6s;
    }

    .fade-enter-from, .fade-leave-to {
        opacity: 0;
        transition: opacity 0.5s;
    }
</style>