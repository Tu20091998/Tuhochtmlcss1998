<script setup lang="ts">
import { ref, onMounted, defineAsyncComponent} from 'vue';

// Import Components
import HeaderComponent from './components/Header.vue';
import FooterComponent from './components/Footer.vue';
import Home from './components/Home.vue';
import Skills from './components/Skills.vue';
import Contact from './components/Contact.vue';
// Các trang còn lại
const DetailInfo = defineAsyncComponent(() => import('./components/DetailInfo.vue'));
const Articles = defineAsyncComponent(() => import('./components/Articles.vue'));

// --- TRẠNG THÁI VÀ DỮ LIỆU ---
const currentView = ref('Home');
const isLoading = ref(true);
const apiBaseUrl = 'http://localhost:3000';

// Dữ liệu dự phòng (Fallback data - dùng khi API lỗi hoặc chưa chạy)
const portfolioData = ref({
    personal: { name: "Đang Tải...", title: "...", avatar: "https://placehold.co/150x150/9CA3AF/ffffff?text=Loading" },
    education: [], experience: [], projects: [], articles: [],
});

// --- LOGIC GỌI API VỚI THỬ LẠI ---
const fetchWithRetry = async (url: string, retries: number = 3): Promise<any> => {
    for (let i = 0; i < retries; i++) {
        try {
            const response = await fetch(url);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return await response.json();
        } catch (error) {
            console.warn(`Thử lần ${i + 1} thất bại cho ${url}. Thử lại sau ${2 ** i}s...`);
            if (i === retries - 1) throw error;
            await new Promise(resolve => setTimeout(resolve, 1000 * (2 ** i)));
        }
    }
};

const fetchData = async () => {
    isLoading.value = true;
    try {
        const [personal, education, experience, projects, articles] = await Promise.all([
            fetchWithRetry(`${apiBaseUrl}/personal`),
            fetchWithRetry(`${apiBaseUrl}/education`),
            fetchWithRetry(`${apiBaseUrl}/experience`),
            fetchWithRetry(`${apiBaseUrl}/projects`),
            fetchWithRetry(`${apiBaseUrl}/articles`),
        ]);

        // Cập nhật dữ liệu từ API
        portfolioData.value = { personal, education, experience, projects, articles };
        console.log("Dữ liệu đã được tải thành công từ API.");

    } catch (error) {
        console.error("Lỗi khi tải dữ liệu từ API. Sử dụng dữ liệu Mock Fallback.");
        // Nếu lỗi, giữ nguyên dữ liệu dự phòng ban đầu
    } finally {
        isLoading.value = false;
    }
};

// --- LIFECYCLE HOOKS ---
onMounted(fetchData);

// --- HÀM CHUYỂN TRANG ---
const changeView = (view: string) => {
    currentView.value = view;
    window.scrollTo({ top: 0, behavior: 'smooth' });
};
</script>

<template>
    <div id="app-portfolio" class="d-flex flex-column min-vh-100"> 
        <!-- Header -->
        <HeaderComponent 
            :current-view="currentView" 
            :personal-data="portfolioData.personal" 
            @change-view="changeView" 
        />
        
        <!-- Main Content Area -->
        <main class="flex-grow-1 page-content p-4 p-md-5"> 
            <!-- Loading Spinner -->
            <div v-if="isLoading" class="d-flex flex-column align-items-center justify-content-center py-5 text-secondary min-vh-75">
                <div class="spinner-border text-primary mb-4" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="fs-5 fw-medium">Đang tải dữ liệu Portfolio từ {{ apiBaseUrl }}...</p>
            </div>

            <div v-else :key="currentView">
                <Home v-if="currentView === 'Home'" :portfolio-data="portfolioData" @change-view="changeView" />
                <DetailInfo v-else-if="currentView === 'Detail'" :portfolio-data="portfolioData" />
                <Skills v-else-if="currentView === 'Skills'" :portfolio-data="portfolioData" />
                <Articles v-else-if="currentView === 'Articles'" :portfolio-data="portfolioData" />
                <Contact v-else-if="currentView === 'Contact'" />
                
                <div v-else class="text-center py-5">
                    <h1 class="h3 fw-bold text-gray-800">404 - Trang không tìm thấy</h1>
                    <!-- Sử dụng Bootstrap button class -->
                    <button @click="changeView('Home')" class="btn btn-primary mt-4">Về Trang Chủ</button>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <FooterComponent :personal-data="portfolioData.personal" />
    </div>
</template>