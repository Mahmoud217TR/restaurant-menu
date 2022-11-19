<template>
    <nav>
        <ul class="flex-row items-center">
            <li class="hidden mx-2 md:inline-block">
                <router-link to='/menu' class="text-white px-2 " exact-active-class="font-bold"> 
                    <i class="fa-solid fa-book-open mx-2"></i>
                    <span>Menus</span>
                </router-link>
            </li>
            <li class="hidden mx-2 md:inline-block">
                <router-link to='/dashboard' class="text-white px-2" exact-active-class="font-bold"> 
                    <i class="fa-solid fa-gauge-high mx-2"></i>
                    <span>Dashboard</span>
                </router-link>
            </li>
            <li class="inline-block mx-2 md:hidden">
                <a href="#" class="text-white px-2" exact-active-class="font-bold" @click.prevent="toggleMenu()"> 
                    <i class="fa-solid fa-bars mx-2 text-2xl"></i>
                </a>
            </li>
        </ul>
    </nav>
    <aside class="menu bg-slate-900 z-40 md:-left-full" :class="{'left-0':(!open),'-left-full':open}">
        <ul class="flex-col">
            <li class="text-xl my-8">
                <router-link to='/menu' class="text-white px-2 " exact-active-class="font-bold"> 
                    <i class="fa-solid fa-book-open mx-2"></i>
                    <span>Menus</span>
                </router-link>
            </li>
            <li class="text-xl my-8">
                <router-link to='/dashboard' class="text-white px-2" exact-active-class="font-bold"> 
                    <i class="fa-solid fa-gauge-high mx-2"></i>
                    <span>Dashboard</span>
                </router-link>
            </li>
        </ul>
    </aside>
</template>

<script>
    export default {
        data() {
            return {
                open: false,
            }
        },
        methods: {
            toggleMenu(){
                this.open = !this.open;
            }
        },
    }
</script>
