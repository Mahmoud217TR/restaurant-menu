<template>
    <div class="container mt-16 w-4/5 mx-auto pb-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 w-4/5 mx-auto pb-8">
            <div class="flex items-center justify-center md:justify-start" data-aos="fade-right" data-aos-offset="200"
            data-aos-delay="100" data-aos-duration="1000" data-aos-easing="ease-in-out">
                <h2 class="text-white">
                    <div class="text-center max-w-max">
                        <i class="fa-solid fa-user-large block text-4xl"></i>
                        <span class="font-bold">{{ author }}</span>
                    </div>
                </h2>
            </div>
            <div class="md:col-span-2 shadow-lg" data-aos="fade-left" data-aos-offset="200"
            data-aos-delay="100" data-aos-duration="1000" data-aos-easing="ease-in-out">
                <div class="border-2 border-solid border-slate-900 p-4 bg-gray-300">
                    <h1 class="text-center text-2xl font-bold text-slate-900">
                        <i class="fa-solid fa-utensils mx-2"></i>
                        <span>{{ title }}</span>
                    </h1>
                    <p class="text-center text-neutral-700 text-sm mt-2">{{ description }}</p>
                </div>
            </div>
        </div>
        <Categories :categories="categories" :main="true" data-aos="fade-up" data-aos-offset="200"
            data-aos-delay="100" data-aos-duration="1000" data-aos-easing="ease-in-out"></Categories>
    </div>
</template>

<script>
    import Categories from './Partials/Categories.vue';
    export default {
        components:{
            Categories
        },
        data() {
            return {
                id: null,
                title: null,
                description: null,
                discount: null,
                author: null,
                categories: [],
            }
        },
        methods: {
            redirectTo404(){
                this.$router.push('/404');
            },
            getMenuData(){
                axios.get('/sanctum/csrf-cookie').then(csrf_response =>{
                    axios.get('/api/menu/'+this.id).then(response => {
                        this.title = response.data.menu.title;
                        this.description = response.data.menu.description;
                        this.author = response.data.menu.author;
                        this.categories = response.data.menu.categories;
                    }).catch(error => {
                        if(error.response.status == 404){
                            this.redirectTo404();
                        }
                    });
                });
            }
        },
        created() {
            this.id = this.$route.params.id
            this.getMenuData();
        },
    }
</script>
