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
                            <label class="block text-slate-900 font-bold text-lg" for="category_add_title">Title</label>
                            <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['category_add_title']}" type="text" required ref="category_add_title" id='category_add_title'>
                            <span class="text-red-600 font-bold my-2"> {{ messages['category_add_title'] }} </span>
                        </div>
                        <div class="block mb-4">
                            <label class="block text-slate-900 font-bold text-lg" for="category_add_discount">Discount</label>
                            <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['category_add__discount']}" type="number" ref="category_add_discount" id='category_add_discount' min="0" max='100'>
                            <span class="text-red-600 font-bold my-2"> {{ messages['category_add_discount'] }} </span>
                        </div>
                        <div class="flex mb-4 w-full items-end">
                            <button class="text-white bg-slate-900 py-2 px-4 rounded-sm mx-auto max-w-max hover:bg-slate-800 block">
                                <i class="fa-solid fa-plus mx-2"></i>
                            </button>
                        </div>
                    </form>
                    <form class="grid grid-cols-3 gap-2 bg-gray-400 p-4 items-end" v-for="category in menu.categories" :ref="'category-form-'+category.id" @submit.prevent="updateCategory(category.id)">
                        <div class="block">
                            <label class="block text-slate-900 font-bold text-lg" :for="'category_title_'+id">Title</label>
                            <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['category_title_'+category.id]}" type="text" required :ref="'category_title_'+id" :id="'category_title_'+id" :value="category.title">
                            <span class="text-red-600 font-bold my-2"> {{ messages['category_title_'+id] }} </span>
                        </div>
                        <div class="block">
                            <label class="block text-slate-900 font-bold text-lg" :for="'category_discount_'+id">Discount</label>
                            <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['category_discount_'+category.id]}" type="number" :ref="'category_discount_'+id" :id="'category_discount_'+id" min="0" max='100' :value="category.discount">
                            <span class="text-red-600 font-bold my-2"> {{ messages['category_discount_'+id] }} </span>
                        </div>
                        <div class="flex w-full items-end">
                            <button class="text-white bg-slate-900 py-2 px-4 rounded-sm mx-2 max-w-max hover:bg-slate-800 block">
                                <i class="fa-solid fa-check mx-2"></i>
                            </button>
                            <button class="text-white bg-red-700 py-2 px-4 rounded-sm mx-2 max-w-max hover:bg-red-600 block" @click.prevent="removeCategory(category.id)">
                                <i class="fa-solid fa-trash mx-2"></i>
                            </button>
                        </div>
                        <h2 class="text-slate-900 text-xl font-bold mt-4" v-if="category.contains != 'items'">Add a SubCategory to {{ category.title }}</h2>
                        <div class="col-span-3 p-4 pl-8  bg-gray-200" v-if="category.contains != 'items'">
                            <form action="#" class="grid grid-cols-3 gap-2" :ref="'new-sub-category-form-'+category.id" :id="'new-sub-category-form-'+category.id" @submit.prevent="addSubCategory(category.id)">
                                <div class="block mb-4">
                                    <label class="block text-slate-900 font-bold text-lg" :for="'sub_category_add_'+category.id+'_title'">Title</label>
                                    <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['sub_category_add_'+category.id+'_title']}" type="text" required :ref="'sub_category_add_'+category.id+'_title'" :id="'sub_category_add_'+category.id+'_title'">
                                    <span class="text-red-600 font-bold my-2"> {{ messages['sub_category_add_'+category.id+'_title'] }} </span>
                                </div>
                                <div class="block mb-4">
                                    <label class="block text-slate-900 font-bold text-lg" :for="'sub_category_add_'+category.id+'_discount'">Discount</label>
                                    <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['sub_category_add_'+category.id+'_discount']}" type="number" :ref="'sub_category_add_'+category.id+'_discount'" :id="'sub_category_add_'+category.id+'_discount'" min="0" max='100'>
                                    <span class="text-red-600 font-bold my-2"> {{ messages['sub_category_add_'+category.id+'_discount'] }} </span>
                                </div>
                                <div class="flex mb-4 w-full items-end">
                                    <button class="text-white bg-slate-900 py-2 px-4 rounded-sm mx-auto max-w-max hover:bg-slate-800 block">
                                        <i class="fa-solid fa-plus mx-2"></i>
                                    </button>
                                </div>
                            </form>
                             <form class="grid grid-cols-3 gap-2 bg-gray-400 p-4 items-end" v-for="category in menu.categories" :ref="'category-form-'+category.id" @submit.prevent="updateCategory(category.id)">
                                <div class="block">
                                    <label class="block text-slate-900 font-bold text-lg" :for="'category_title_'+id">Title</label>
                                    <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['category_title_'+category.id]}" type="text" required :ref="'category_title_'+id" :id="'category_title_'+id" :value="category.title">
                                    <span class="text-red-600 font-bold my-2"> {{ messages['category_title_'+id] }} </span>
                                </div>
                                <div class="block">
                                    <label class="block text-slate-900 font-bold text-lg" :for="'category_discount_'+id">Discount</label>
                                    <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['category_discount_'+category.id]}" type="number" :ref="'category_discount_'+id" :id="'category_discount_'+id" min="0" max='100' :value="category.discount">
                                    <span class="text-red-600 font-bold my-2"> {{ messages['category_discount_'+id] }} </span>
                                </div>
                                <div class="flex w-full items-end">
                                    <button class="text-white bg-slate-900 py-2 px-4 rounded-sm mx-2 max-w-max hover:bg-slate-800 block">
                                        <i class="fa-solid fa-check mx-2"></i>
                                    </button>
                                    <button class="text-white bg-red-700 py-2 px-4 rounded-sm mx-2 max-w-max hover:bg-red-600 block" @click.prevent="removeCategory(category.id)">
                                        <i class="fa-solid fa-trash mx-2"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <h2 class="text-slate-900 text-xl font-bold mt-4" v-if="category.contains != 'subCategories'">Add an item to {{ category.title }}</h2>
                        <div class="col-span-3 p-4 pl-8  bg-gray-200" v-if="category.contains != 'subCategories'">
                            <form action="#" class="grid grid-cols-3 gap-2" :ref="'new-item-form-'+category.id" :id="'new-item-form-'+category.id" @submit.prevent="addItem(category.id)">
                                <div class="block mb-4">
                                    <label class="block text-slate-900 font-bold text-lg" :for="'item_add_'+category.id+'_title'">Title</label>
                                    <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['item_add_'+category.id+'_title']}" type="text" required :ref="'item_add_'+category.id+'_title'" :id="'item_add_'+category.id+'_title'">
                                    <span class="text-red-600 font-bold my-2"> {{ messages['item_add_'+category.id+'_title'] }} </span>
                                </div>
                                <div class="block mb-4">
                                    <label class="block text-slate-900 font-bold text-lg" :for="'item_add_'+category.id+'_discount'">Discount</label>
                                    <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['item_add_'+category.id+'_discount']}" type="number" :ref="'item_add_'+category.id+'_discount'" :id="'item_add_'+category.id+'_discount'" min="0" max='100'>
                                    <span class="text-red-600 font-bold my-2"> {{ messages['item_add_'+category.id+'_discount'] }} </span>
                                </div>
                                <div class="flex mb-4 w-full items-end">
                                    <button class="text-white bg-slate-900 py-2 px-4 rounded-sm mx-auto max-w-max hover:bg-slate-800 block">
                                        <i class="fa-solid fa-plus mx-2"></i>
                                    </button>
                                </div>
                                <div class="block mb-4">
                                    <label class="block text-slate-900 font-bold text-lg" :for="'item_add_'+category.id+'_price'">Price</label>
                                    <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['item_add_'+category.id+'_price']}" type="number" :ref="'item_add_'+category.id+'_price'" :id="'item_add_'+category.id+'_price'" min="0">
                                    <span class="text-red-600 font-bold my-2"> {{ messages['item_add_'+category.id+'_price'] }} </span>
                                </div>
                                <div class="block mb-4">
                                    <label class="block text-slate-900 font-bold text-lg" :for="'item_add_'+category.id+'_description'">Description</label>
                                    <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['item_add_'+category.id+'_description']}" type="text" required :ref="'item_add_'+category.id+'_description'" :id="'item_add_'+category.id+'_description'">
                                    <span class="text-red-600 font-bold my-2"> {{ messages['item_add_'+category.id+'_description'] }} </span>
                                </div>
                            </form>
                             <form class="grid grid-cols-3 gap-2 bg-gray-400 p-4 items-end" v-for="item in category.items" :ref="'item-form-'+item.id" @submit.prevent="updateItem(item.id)">
                                <div class="block mb-4">
                                    <label class="block text-slate-900 font-bold text-lg" :for="'item_'+item.id+'_title'">Title</label>
                                    <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['item_'+item.id+'_title']}" type="text" required :ref="'item_'+item.id+'_title'" :id="'item_'+item.id+'_title'" :value="item.title">
                                    <span class="text-red-600 font-bold my-2"> {{ messages['item_'+item.id+'_title'] }} </span>
                                </div>
                                <div class="block mb-4">
                                    <label class="block text-slate-900 font-bold text-lg" :for="'item_'+item.id+'_discount'">Discount</label>
                                    <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['item_'+item.id+'_discount']}" type="number" :ref="'item_'+item.id+'_discount'" :id="'item_'+item.id+'_discount'" min="0" max='100' :value="item.discount">
                                    <span class="text-red-600 font-bold my-2"> {{ messages['item_'+item.id+'_discount'] }} </span>
                                </div>
                                <div class="flex mb-4 w-full items-end">
                                    <button class="text-white bg-slate-900 py-2 px-4 rounded-sm mx-2 max-w-max hover:bg-slate-800 block">
                                        <i class="fa-solid fa-check mx-2"></i>
                                    </button>
                                </div>
                                <div class="block mb-4">
                                    <label class="block text-slate-900 font-bold text-lg" :for="'item_'+item.id+'_price'">Price</label>
                                    <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['item_'+item.id+'_price']}" type="number" :ref="'item_'+item.id+'_price'" :id="'item_'+item.id+'_price'" min="0" :value="item.price.amount">
                                    <span class="text-red-600 font-bold my-2"> {{ messages['item_'+item.id+'_price'] }} </span>
                                </div>
                                <div class="block mb-4">
                                    <label class="block text-slate-900 font-bold text-lg" :for="'item_'+item.id+'_description'">Description</label>
                                    <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['item_'+item.id+'_description']}" type="text" required :ref="'item_'+item.id+'_description'" :id="'item_'+item.id+'_description'" :value="item.description">
                                    <span class="text-red-600 font-bold my-2"> {{ messages['item_'+item.id+'_description'] }} </span>
                                </div>
                                <div class="flex w-full items-end">
                                    <button class="text-white bg-red-700 py-2 px-4 rounded-sm mx-2 max-w-max hover:bg-red-600 block" @click.prevent="removeItem(item.id)">
                                        <i class="fa-solid fa-trash mx-2"></i>
                                    </button>
                                </div>
                            </form>
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
            },getInputOf(id){
                return document.getElementById(id).value;
            },
            resetFormOf(id){
                return document.getElementById(id).reset();
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
                        title: this.getInputOf('category_add_title'),
                        discount: this.getInputOf('category_add_discount'),
                        type: 'category_add_',
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
            addSubCategory(id){
                axios.get('/sanctum/csrf-cookie').then(csrf_response =>{
                    this.restErrors();
                    axios.post('/api/menu/'+this.id+'/category',{
                        title: this.getInputOf('sub_category_add_'+id+'_title'),
                        discount: this.getInputOf('sub_category_add_'+id+'_discount'),
                        category_id: id,
                        type: 'sub_category_add_'+id+'_',
                    }).then(response => {
                        this.menu = response.data.menu;
                        this.resetFormOf('new-sub-category-form-'+id);
                    }).catch(error => {
                        var errors_list = error.response.data.errors;
                        for(var input_error in errors_list){
                            this.setError(input_error,errors_list[input_error][0])
                        }
                    });
                });
            },
            removeCategory(id){
                axios.get('/sanctum/csrf-cookie').then(csrf_response =>{
                    axios.delete('/api/menu/category/'+id).then(response => {
                        this.menu = response.data.menu;
                    }).catch(error => {

                    });
                });
            },
            addItem(id){
                axios.get('/sanctum/csrf-cookie').then(csrf_response =>{
                    this.restErrors();
                    axios.post('/api/menu/'+this.id+'/item',{
                        title: this.getInputOf('item_add_'+id+'_title'),
                        discount: this.getInputOf('item_add_'+id+'_discount'),
                        description: this.getInputOf('item_add_'+id+'_description'),
                        price: this.getInputOf('item_add_'+id+'_price'),
                        category_id: id,
                        type: 'item_add_'+id+'_',
                    }).then(response => {
                        this.menu = response.data.menu;
                        this.resetFormOf('new-item-form-'+id);
                    }).catch(error => {
                        var errors_list = error.response.data.errors;
                        for(var input_error in errors_list){
                            this.setError(input_error,errors_list[input_error][0])
                        }
                    });
                });
            },
            removeItem(id){
                axios.get('/sanctum/csrf-cookie').then(csrf_response =>{
                    axios.delete('/api/menu/item/'+id).then(response => {
                        this.menu = response.data.menu;
                    }).catch(error => {

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
