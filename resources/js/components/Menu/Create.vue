<template>
    <div class="container w-4/5 mx-auto">
        <h1 class="text-white text-center font-bold text-xl">Create a new Menu</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 my-24 justify-items-center gap-4">
            <div class="w-full shadow-xl col-start-2">
                <div class="bg-slate-900 text-white text-2xl font-bold p-4">
                    <h2> Menu Info </h2>
                </div>
                <div class="bg-gray-300 p-4">
                    <form action="#" ref="menu-form" @submit.prevent="submit()">
                        <div class="block mb-4">
                            <label class="block text-slate-900 font-bold text-lg" for="title">Title</label>
                            <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['title']}" type="title" required ref="title">
                            <span class="text-red-600 font-bold my-2"> {{ messages['title'] }} </span>
                        </div>
                        <div class="block mb-4">
                            <label class="block text-slate-900 font-bold text-lg" for="description">Description</label>
                            <textarea class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['description']}" required ref="description" style="height:6rem"></textarea>
                            <span class="text-red-600 font-bold my-2"> {{ messages['description'] }} </span>
                        </div>
                        <div class="block mb-4">
                            <label class="block text-slate-900 font-bold text-lg" for="discount">Discount</label>
                            <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['discount']}" type="number" ref="discount" min="0" max='100'>
                            <span class="text-red-600 font-bold my-2"> {{ messages['discount'] }} </span>
                        </div>
                        <div class="flex mb-4 w-full">
                            <button class="text-white bg-slate-900 py-2 px-4 rounded-sm mx-auto max-w-max hover:bg-slate-800">
                                <i class="fa-solid fa-check mx-2"></i>
                                <span class="font-bold">Add</span>
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
                errors: [],
                messages: [],
            }
        },methods: {
            submit(){
                axios.get('/sanctum/csrf-cookie').then(csrf_response =>{
                    this.restErrors();
                    axios.post('/api/menu',{
                        title: this.$refs.title.value,
                        description: this.$refs.description.value,
                        discount: this.$refs.discount.value,
                    }).then(response => {
                        this.$refs['menu-form'].reset();
                        this.redirectToEdit();
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
            }
        },
    }
</script>
