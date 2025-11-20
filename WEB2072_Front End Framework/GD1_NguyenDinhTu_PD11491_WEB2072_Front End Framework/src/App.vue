<script setup lang="ts">
import { ref, onMounted, defineAsyncComponent} from 'vue';

//json-server --watch db.json --port 3000

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
    personal: { name: "Đang Tải...", title: "...", avatar: "https://scontent.fdad3-1.fna.fbcdn.net/v/t39.30808-6/474443694_122215494704227192_8696271321617163636_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=86c6b0&_nc_ohc=TJAbx1RLIf8Q7kNvwEvMJGX&_nc_oc=AdkrmzGhjPkI79BrNjHq4OijWF3eRCieWtvgo9KzNpk2HVVn8CSOEIc4Bvwi0_ljO3A&_nc_zt=23&_nc_ht=scontent.fdad3-1.fna&_nc_gid=0P289ub5PZLifSKYAo7WdQ&oh=00_AfhZS6lMVVyMLj94nywJl3h0Zwh1SRxGeA_5NT_usAvRUg&oe=69239FD4" },
    education: [], experience: [], projects: [], articles: [],
});

// Gọi api từ db.json
const apiFetch = async (url: string): Promise<any> => {
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

// --- Đảm bảo khi trang được load hết mới gọi api lấy dữ liệu ---
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
                    <button @click="changeView('Home')" class="btn btn-primary mt-4">Về Trang Chủ</button>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <FooterComponent :personal-data="portfolioData.personal" />
    </div>
</template>