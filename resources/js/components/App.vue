<template>
    <header class="bg-lime-600 sticky top-0 min-h-[10vh]">
        <nav class="text-center p-4 mx-auto container flex items-center justify-between">
            <router-link to='/' class="text-white">
                <img src="/images/logo.svg" alt="Logo" class="logo" width="40">
            </router-link>
            <ul class="flex-row">
                <li class="inline-block mx-2">
                    <router-link to='/' class="text-white" exact-active-class="font-bold"> Home </router-link>
                </li>
            </ul>
            <div class="">
                <router-link to='/login' v-if="guest" exact-active-class="font-bold" class="text-white mx-2"> Login </router-link>
                <router-link to='/register' v-if="guest" exact-active-class="font-bold" class="text-white mx-2"> Register </router-link>
                <a href="#" v-if="auth" exact-active-class="font-bold" class="text-white mx-2" @click.prevent="logout()"> Logout </a>
            </div>
        </nav>
    </header>
    <main class="pt-8 min-h-[80vh] bg-lime-200">
        <router-view></router-view>
    </main>
    <footer class="bg-orange-600 min-h-[10vh]">
        <p class="text-center text-white font-bold p-4">
            © All Rights Reserved
        </p>
    </footer>
</template>

<script>
    export default {
        computed: {
            auth(){
                return localStorage.getItem('token') != null;
            },
            guest(){
                return !this.auth;
            },
            logout(){
                axios.get('/sanctum/csrf-cookie').then(csrf_response =>{
                    axios.post('/api/logout').then(response => {
                        localStorage.removeItem('token');
                    })
                }).catch(error => {
                    
                });;
            },
        },
    }
</script>
