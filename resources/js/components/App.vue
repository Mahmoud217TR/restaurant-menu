<template>
    <header class="bg-slate-900 sticky top-0 min-h-[10vh] shadow-lg z-50">
        <nav class="text-center p-4 mx-auto container flex items-center justify-between">
            <router-link to='/' class="text-white">
                <img src="/images/logo.svg" alt="Logo" class="logo" width="40">
            </router-link>
            <Navbar></Navbar>
            <div class="">
                <router-link to='/login' v-if="guest" exact-active-class="font-bold" class="text-white mx-2"> Login </router-link>
                <router-link to='/register' v-if="guest" exact-active-class="font-bold" class="text-white mx-2"> Register </router-link>
                <a href="#" v-if="auth" exact-active-class="font-bold" class="text-white mx-2" @click.prevent="logout()"> Logout </a>
            </div>
        </nav>
    </header>
    <main class="pt-8 min-h-[80vh]">
        <router-view @auth-change="updateAuth"></router-view>
    </main>
    <Footer></Footer>
</template>

<script>
import Footer from './Layouts/Footer.vue';
import Navbar from './Layouts/Navbar.vue';
    export default {
        components: { Navbar, Footer },
        data() {
            return {
                auth: false,
                guest: true,
            }
        },
        methods: {
            updateAuth(e){
                this.auth = localStorage.getItem('token');
                this.guest = !this.auth;
                axios.defaults.headers.common["Authorization"] = "Bearer " + localStorage.getItem('token');
            },
            redirectWelcome(){
                this.$router.push('/');
            },
            logout(){
                axios.get('/sanctum/csrf-cookie').then(csrf_response =>{
                    axios.post('/api/logout').then(response => {
                        localStorage.removeItem('token');
                        this.updateAuth();
                        this.redirectWelcome();
                    })
                }).catch(error => {
                    
                });
            },
        },
        created() {
            this.updateAuth();
        },
    }
</script>
