
import { createRouter, createWebHistory } from 'vue-router';

// Nhập các component bên User
import Home from './components/users/Home.vue';
import Skills from './components/users/Skills.vue';
import Contact from './components/users/Contact.vue';
import DetailInfo from './components/users/DetailInfo.vue';
import Articles from './components/users/Articles.vue';
import ArticleDetail from './components/users/ArticleDetail.vue';


// Nhập các component bên admin
import AdminLayout from './components/admin/AdminLayout.vue';
import LoginAdmin from './components/admin/LoginAdmin.vue';
import Dashboard from './components/admin/Dashboard.vue';
import StudyEdit from './components/admin/StudyEdit.vue';
import PersonalEdit from './components/admin/PersonalEdit.vue';
import ArticlesManagement from './components/admin/ArticlesManagement.vue';
import ProjectsManagement from './components/admin/ProjectsManagement.vue';
import ExperienceManagement from './components/admin/ExperienceManagement.vue';


//route quản lý chuyển hướng
const routes = [
    { path: '/', name: 'Home', component: Home },
    { path: '/detail', name: 'Detail', component: DetailInfo },
    { path: '/skills', name: 'Skills', component: Skills },
    { path: '/articles', name: 'Articles', component: Articles },
    { path: '/contact', name: 'Contact', component: Contact },

     // Route chi tiết bài viết với tham số động là 'id'
    {
        path: '/article/:article_id',
        name: 'ArticleDetail',
        component: ArticleDetail,
    },

    { 
        path: '/admin/login', 
        name: 'LoginAdmin', 
        component: LoginAdmin, 
    },

    // Route cho trang Admin
    { 
        path: '/admin',
        component: AdminLayout,
        children: [
            //  REDIRECT TỪ /admin SANG /admin/dashboard
            {
                path: '', 
                redirect: { name: 'Dashboard' }
            },

            //  TRANG DASHBOARD (Trang chủ Admin)
            {
                path: 'dashboard',
                name: 'Dashboard',
                component: Dashboard,
            },

            // ROUTE QUẢN LÝ THÔNG TIN HỌC VẤN
            {
                path: 'study',
                name: 'StudyEdit',
                component: StudyEdit,
            },

            // ROUTE QUẢN LÝ THÔNG TIN CÁ NHÂN
            {
                path: 'personal',
                name: 'PersonalEdit',
                component: PersonalEdit,
            },

            // ROUTE Quản lý Bài Viết
            {
                path: 'articles',
                name: 'ArticlesManagement',
                component: ArticlesManagement,
            },

            //ROUTE Quản lý dự án
            {
                path: 'projects',
                name: 'ProjectsManagement',
                component: ProjectsManagement, 
            },

            //ROUTE Quản lý kinh nghiệm
            {
                path: 'experience',
                name: 'ExperienceManagement',
                component: ExperienceManagement,
            },
        ]
    },
    // Route 404
    { path: '/:pathMatch(.*)*', name: 'NotFound', redirect: '/' }, // Chuyển hướng về trang chủ
];

const router = createRouter({
    history: createWebHistory(),//hiển thị url đẹp(không có #)
    routes,
    scrollBehavior() {
        return { top: 0 }; // ⭐ Tự scroll lên đầu mỗi khi đổi trang
    }
});


export default router; // nhờ route spa mà không bị load trang khi tải component