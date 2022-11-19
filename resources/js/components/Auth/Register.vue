<template>
    <div class="container mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 justify-center gap-4">
            <div class="lg:col-start-2 m-4 shadow-lg">
                <div class="p-4 bg-slate-900 rounded-t-md">
                    <h1 class="text-center text-xl text-white">
                        <i class="fa-solid fa-user-plus mx-2"></i>
                        <span class="font-bold">Register</span>
                    </h1>
                </div>
                <div class="p-4 bg-gray-300 rounded-b-md">
                    <form action="#" @submit.prevent="submit()" ref="register-form">
                        <div class="block mb-4">
                            <label class="block text-slate-900 font-bold text-lg" for="email">Email</label>
                            <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['email']}" type="email" required ref="email">
                            <span class="text-red-600 font-bold my-2"> {{ messages['email'] }} </span>
                        </div>
                        <div class="block mb-4">
                            <label class="block text-slate-900 font-bold text-lg" for="name">Name</label>
                            <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['name']}" type="text" required ref="name">
                            <span class="text-red-600 font-bold my-2"> {{ messages['name'] }} </span>
                        </div>
                        <div class="block mb-4">
                            <label class="block text-slate-900 font-bold text-lg" for="email">Password</label>
                            <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['password']}" type="password" required ref="password">
                            <span class="text-red-600 font-bold my-2"> {{ messages['password'] }} </span>
                        </div>
                        <div class="block mb-4">
                            <label class="block text-slate-900 font-bold text-lg" for="email">Password Confirm</label>
                            <input class="block w-full mt-2 rounded-sm h-8 p-2 text-slate-900 focus:outline-none" :class="{'border-2 border-red-600':errors['password_confirmation']}" type="password" required ref="password_confirmation">
                            <span class="text-red-600 font-bold my-2"> {{ messages['password_confirmation'] }} </span>
                        </div>
                        <div class="flex mb-4 w-full">
                            <button class="text-white bg-slate-900 py-2 px-4 rounded-sm mx-auto max-w-max hover:bg-slate-800">
                                <i class="fa-solid fa-check mx-2"></i>
                                <span class="font-bold">Register</span>
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
        },
        methods: {
            submit(){
                axios.get('/sanctum/csrf-cookie').then(csrf_response =>{
                    this.restErrors();
                    axios.post('/api/register',{
                        name: this.$refs.name.value,
                        email: this.$refs.email.value,
                        password: this.$refs.password.value,
                        password_confirmation: this.$refs.password_confirmation.value,
                        device_name: "web",
                    }).then(response => {
                        localStorage.setItem('token',response.data.token);
                        this.$refs['register-form'].reset();
                        this.redirectHome();
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
            redirectHome(){
                this.$router.push('/')
            }
        },
    }
</script>
