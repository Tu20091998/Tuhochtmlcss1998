
import { createRouter, createWebHistory } from 'vue-router';

// Nhập các component bên User
import Home from './components/users/Home.vue';
import Skills from './components/users/Skills.vue';
import Contact from './components/users/Contact.vue';
import DetailInfo from './components/users/DetailInfo.vue';
import Articles from './components/users/Articles.vue';
import AdminLayout from './components/admin/AdminLayout.vue';

// Nhập các component bên User
import Dashboard from './components/admin/Dashboard.vue';

// Không cần dùng defineAsyncComponent ở đây nữa, router sẽ tự quản lý.

const routes = [
    { path: '/', name: 'Home', component: Home },
    { path: '/detail', name: 'Detail', component: DetailInfo },
    { path: '/skills', name: 'Skills', component: Skills },
    { path: '/articles', name: 'Articles', component: Articles },
    { path: '/contact', name: 'Contact', component: Contact },

    // Route cho trang Admin
    { 
        path: '/admin', 
        name: 'Admin', 
        component: AdminLayout,
        children: [
            // Mặc định, hiển thị Dashboard khi truy cập /admin
            { 
                path: '', // path trống: /admin
                name: 'AdminDashboard', 
                component: Dashboard // Component trang tổng quan
            },
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