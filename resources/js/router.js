import {createWebHistory, createRouter } from 'vue-router/dist/vue-router.esm-bundler';
import Welcome from "./components/Welcome.vue";
import Home from "./components/Home.vue";
import MenuIndex from "./components/Menu/Index.vue";
import MenuShow from "./components/Menu/Show.vue";
import MenuCreate from "./components/Menu/Create.vue";
import MenuEdit from "./components/Menu/Edit.vue";
import MenuManage from "./components/Menu/Manage.vue";
import Login from "./components/Auth/Login.vue";
import Register from "./components/Auth/Register.vue";
import NotFound from "./components/Errors/NotFound.vue";
import Unauthorized from "./components/Errors/Unauthorized.vue";


export const routes = [
    {
        path: '/',
        component: Welcome,
    },
    {
        path: '/dashboard',
        component: Home,
        meta:{
            auth: true,
        },
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
        path: '/menu/manage',
        component: MenuManage,
        meta:{
            auth: true,
        },
    },
    {
        path: '/menu/create',
        component: MenuCreate,
        meta:{
            auth: true,
        },
    },
    {
        path: '/menu/:id/edit',
        component: MenuEdit,
        meta:{
            auth: true,
        },
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
        path: '/403',
        component: Unauthorized,
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
