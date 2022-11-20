<template>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 w-4/5 mx-auto py-16">
        <div class="shadow-lg" v-for="menu in menus" data-aos="fade-up" data-aos-offset="200"
            data-aos-delay="100" data-aos-duration="1000" data-aos-easing="ease-in-out">
            <div class="bg-slate-900 p-4 h-24 max-h-24 min-h-24 overflow-clip" :class="{'menu-header-discount':menu.discount}">
                <span v-if="menu.discount" class="discount-amount">-{{menu.discount}}%</span>
                <h2 class="text-white text-lg font-bold" :class="{'mr-6':menu.discount}">
                    <i class="fa-solid fa-book-open mx-2"></i>
                    <span>{{ menu.title }}</span>
                </h2>
            </div>
            <div class="bg-gray-200 p-4">
                <div class="block p-2 h-24 max-h-24 min-h-24 overflow-clip mb-4">
                    <p class="text-sm">
                        {{ menu.description }}
                    </p>
                </div>
                <div class="flex">
                    <router-link :to='"/menu/"+menu.id' class="text-white p-2 bg-slate-900 mx-auto hover:bg-slate-800"> 
                        <i class="fa-solid fa-eye mx-2"></i>
                        <span>Open</span>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                menus: [],
            }
        },
        methods: {
            getMenuData(){
                axios.get('/sanctum/csrf-cookie').then(csrf_response =>{
                    axios.get('/api/menu/').then(response => {
                        this.menus = response.data.menus;
                    }).catch(error => {

                    });
                });
            }
        },
        created() {
            this.getMenuData();
        },
    }
</script>
