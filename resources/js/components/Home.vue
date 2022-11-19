<template>
    <div class="container w-4/5 mx-auto">
        <h1 class="text-white text-center font-bold text-xl">Dashboard</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 mt-24 justify-items-center">
            <router-link to='/menu/create' class="min-w-[50%] w-full md:max-w-[50%] min-h-[12rem] bg-gradient-to-tr from-slate-900 via-slate-800 to-slate-900 flex justify-center items-center shadow-lg text-white font-bold text-lg hover:from-slate-800 hover:via-slate-700 hover:to-slate-800 my-4">
                <div class="text-center max-w-max">
                        <i class="fa-solid fa-plus block mb-2 text-4xl"></i>
                        <span>Create a new Menu</span>
                </div>
            </router-link>
            <router-link to='/menu/manage' class="min-w-[50%] w-full md:max-w-[50%] min-h-[12rem] bg-gradient-to-tr from-slate-900 via-slate-800 to-slate-900 flex justify-center items-center shadow-lg text-white font-bold text-lg hover:from-slate-800 hover:via-slate-700 hover:to-slate-800 my-4">
                <div class="text-center max-w-max">
                        <i class="fa-solid fa-book-open block mb-2 text-4xl"></i>
                        <span>Manage Menus</span>
                </div>
            </router-link>
        </div>
    </div>
</template>

<script>
    export default {
        
    }
</script>
