import {createWebHistory, createRouter } from 'vue-router/dist/vue-router.esm-bundler';
import Welcome from "./components/Welcome.vue";
import Home from "./components/Home.vue";
import MenuIndex from "./components/Menu/Index.vue";
import MenuShow from "./components/Menu/Show.vue";
import Login from "./components/Auth/Login.vue";
import Register from "./components/Auth/Register.vue";
import NotFound from "./components/Errors/NotFound.vue";


export const routes = [
    {
        path: '/',
        component: Welcome,
    },
    {
        path: '/dashboard',
        component: Home,
    },
    {
        path: '/menu',
        component: MenuIndex,
    },
    {
        path: '/menu/:id',
        component: MenuShow,
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
    {
        path: '/:pathMatch(.*)*',
        component: NotFound,
    }
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
