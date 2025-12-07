
import { createRouter, createWebHistory } from 'vue-router';

// Nhập các component bên User
import Home from './components/users/Home.vue';
import Skills from './components/users/Skills.vue';
import Contact from './components/users/Contact.vue';
import DetailInfo from './components/users/DetailInfo.vue';
import Articles from './components/users/Articles.vue';


// Nhập các component bên admin
import AdminLayout from './components/admin/AdminLayout.vue';
import LoginAdmin from './components/admin/LoginAdmin.vue';
import Dashboard from './components/admin/Dashboard.vue';


//route quản lý chuyển hướng
const routes = [
    { path: '/', name: 'Home', component: Home },
    { path: '/detail', name: 'Detail', component: DetailInfo },
    { path: '/skills', name: 'Skills', component: Skills },
    { path: '/articles', name: 'Articles', component: Articles },
    { path: '/contact', name: 'Contact', component: Contact },
    { 
        path: '/admin/login', 
        name: 'LoginAdmin', 
        component: LoginAdmin, 
        meta: { hideDefaultLayout: false }
    },

    // Route cho trang Admin
    { 
        path: '/admin',
        component: AdminLayout,
        children: [
            // 1. REDIRECT TỪ /admin SANG /admin/dashboard
            {
                path: '', 
                redirect: { name: 'Dashboard' } // <--- ĐIỂM QUAN TRỌNG
            },

            // 2. TRANG DASHBOARD (Trang chủ Admin)
            {
                path: 'dashboard', // URL: /admin/dashboard
                name: 'Dashboard',
                component: Dashboard,
            }
        ]

        
    },
    // Route 404
    { path: '/:pathMatch(.*)*', name: 'NotFound', redirect: '/' }, // Chuyển hướng về trang chủ
];

const router = createRouter({
    history: createWebHistory(), // Sử dụng chế độ History mode (dùng URL đẹp)
    routes,
});


export default router;