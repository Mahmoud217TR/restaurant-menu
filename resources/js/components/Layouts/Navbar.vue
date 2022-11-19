<template>
    <ul class="flex-row">
        <li class="inline-block mx-2">
            <router-link to='/menu' class="text-white px-2" exact-active-class="font-bold"> 
                <i class="fa-solid fa-book-open mx-2"></i>
                <span>Menus</span>
            </router-link>
            <router-link to='/dashboard' class="text-white px-2" exact-active-class="font-bold"> 
                <i class="fa-solid fa-gauge-high mx-2"></i>
                <span>Dashboard</span>
            </router-link>
        </li>
    </ul>
</template>

<script>
    export default {
        
    }
</script>
