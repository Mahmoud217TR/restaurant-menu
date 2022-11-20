<template>
    <div class="container w-4/5 mx-auto">
        <h1 class="text-white text-center font-bold text-xl">Edit Your Menu</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 my-24 justify-items-center gap-4">
            <div class="w-full shadow-xl" data-aos="fade-up" data-aos-offset="200"
                data-aos-delay="100" data-aos-duration="1000" data-aos-easing="ease-in-out">
                <div class="bg-slate-900 text-white text-2xl font-bold p-4">
                    <h2> Menu Info </h2>
                </div>
                <div class="bg-gray-300 p-4">
                    <form action="#" ref="menu-form" @submit.prevent="saveInfo()">
                        <div class="block mb-4">
                            <label class="block text-slate-900 font-bold text-lg" for="title">Title</label>
                            <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['title']}" type="title" required ref="title" :value="menu.title">
                            <span class="text-red-600 font-bold my-2"> {{ messages['title'] }} </span>
                        </div>
                        <div class="block mb-4">
                            <label class="block text-slate-900 font-bold text-lg" for="description">Description</label>
                            <textarea class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['description']}" required ref="description" style="height:6rem" :value="menu.description"></textarea>
                            <span class="text-red-600 font-bold my-2"> {{ messages['description'] }} </span>
                        </div>
                        <div class="block mb-4">
                            <label class="block text-slate-900 font-bold text-lg" for="discount">Discount</label>
                            <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['discount']}" type="number" ref="discount" min="0" max='100' :value="menu.discount">
                            <span class="text-red-600 font-bold my-2"> {{ messages['discount'] }} </span>
                        </div>
                        <div class="flex mb-4 w-full">
                            <button class="text-white bg-slate-900 py-2 px-4 rounded-sm mx-auto max-w-max hover:bg-slate-800">
                                <i class="fa-solid fa-check mx-2"></i>
                                <span class="font-bold">Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="w-full shadow-xl md:col-span-2" data-aos="fade-up" data-aos-offset="200"
                data-aos-delay="100" data-aos-duration="1000" data-aos-easing="ease-in-out">
                <div class="bg-slate-900 text-white text-2xl font-bold p-4">
                    <h2> Categories </h2>
                </div>
                <div class="bg-gray-300 p-4">
                    <form action="#" class="grid grid-cols-3 gap-2" ref="new-category-form" @submit.prevent="addCategory()">
                        <div class="block mb-4">
                            <label class="block text-slate-900 font-bold text-lg" for="category_title">Title</label>
                            <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['category_title']}" type="text" required ref="category_title">
                            <span class="text-red-600 font-bold my-2"> {{ messages['category_title'] }} </span>
                        </div>
                        <div class="block mb-4">
                            <label class="block text-slate-900 font-bold text-lg" for="discount">Discount</label>
                            <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['category_discount']}" type="number" ref="category_discount" min="0" max='100'>
                            <span class="text-red-600 font-bold my-2"> {{ messages['category_discount'] }} </span>
                        </div>
                        <div class="flex mb-4 w-full">
                            <button class="text-white bg-slate-900 py-2 px-4 rounded-sm mx-auto max-w-max hover:bg-slate-800 block">
                                <i class="fa-solid fa-check mx-2"></i>
                                <span class="font-bold">Add new Category</span>
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                id: null,
                errors: [],
                messages: [],
                menu: {
                    title: null,
                    description: null,
                    discount: null,
                },
            }
        },
        methods: {
            redirectTo404(){
                this.$router.push('/404');
            },
            redirectTo403(){
                this.$router.push('/403');
            },
            saveInfo(){
                axios.get('/sanctum/csrf-cookie').then(csrf_response =>{
                    this.restErrors();
                    axios.put('/api/menu/'+this.id,{
                        title: this.$refs.title.value,
                        description: this.$refs.description.value,
                        discount: this.$refs.discount.value,
                    }).then(response => {
                        this.menu = response.data.menu;
                    }).catch(error => {
                        var errors_list = error.response.data.errors;
                        for(var input_error in errors_list){
                            this.setError(input_error,errors_list[input_error][0])
                        }
                    });
                });
            },
            addCategory(){
                axios.get('/sanctum/csrf-cookie').then(csrf_response =>{
                    this.restErrors();
                    axios.post('/api/menu/'+this.id+'/category',{
                        title: this.$refs.category_title.value,
                        discount: this.$refs.category_discount.value,
                    }).then(response => {
                        this.menu = response.data.menu;
                        this.$refs['new-category-form'].reset();
                    }).catch(error => {
                        var errors_list = error.response.data.errors;
                        for(var input_error in errors_list){
                            this.setError(input_error,errors_list[input_error][0])
                        }
                    });
                });
            },
            setError(name, message = null){
                this.errors[name] = true;
                this.messages[name] = message;
            },
            restErrors(){
                this.errors = [];
                this.messages = [];
            },
            redirectToEdit(){
                this.$router.push('/dashboard')
            },
            getMenuData(){
                axios.get('/sanctum/csrf-cookie').then(csrf_response =>{
                    axios.get('/api/menu/'+this.id+'/edit').then(response => {
                        this.menu = response.data.menu;
                    }).catch(error => {
                        console.log(error);
                        if(error.response.status == 404){
                            this.redirectTo404();
                        }else if(error.response.status == 403){
                            this.redirectTo403();
                        }
                    });
                });
            },
        },
        created() {
            this.id = this.$route.params.id
            this.getMenuData();
        },
    }
</script>
