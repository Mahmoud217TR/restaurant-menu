import {createWebHistory, createRouter } from 'vue-router/dist/vue-router.esm-bundler';
import ExampleComponent from "./components/ExampleComponent.vue";

export default new createRouter({
    history: createWebHistory(),
    routes:[
        {
            path: '/',
            component: ExampleComponent,
        }
    ],
});