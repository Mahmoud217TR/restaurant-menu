import {createWebHistory, createRouter } from 'vue-router/dist/vue-router.esm-bundler';
import Home from "./components/Home.vue";
import Login from "./components/Login.vue";
import Register from "./components/Register.vue";


export const routes = [
    {
        path: '/',
        component: Home,
    },
    {
        path: '/login',
        component: Login,
        meta:{
            guest: true,
        },
    },
    {
        path: '/register',
        component: Register,
        meta:{
            guest: true,
        },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

router.beforeEach((to, from, next) => {
    const auth = localStorage.getItem('token') != null;
  
    if (to.matched.some(record => record.meta.auth) && !auth) {
        next('/login');
        return;
    }

    if (to.matched.some(record => record.meta.guest) && auth) {
        next('/');
        return;
    }

    next();
});

export default router;
