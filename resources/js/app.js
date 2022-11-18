import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler.js';
import App from './components/App.vue'
import router from './router';
import axios from 'axios';


const app = createApp(App);
app.use(router);
app.config.globalProperties.$axios = axios;
app.config.globalProperties.$router = router;
app.mount("#app");