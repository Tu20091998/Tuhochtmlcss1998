import { createApp } from 'vue'
import './style.css'
import App from './App.vue';
import router from './router'; // <-- Import router vừa tạo

const app = createApp(App);

app.use(router); // <-- Sử dụng router

app.mount('#app');


