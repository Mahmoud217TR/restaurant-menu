<template>
    <div class="container mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 justify-center gap-4">
            <div class="lg:col-start-2 m-4 ">
                <div class="p-4 bg-lime-600 rounded-t-md">
                    <h1 class="text-center text-xl text-white">
                        <i class="fa-solid fa-user-check mx-2"></i>
                        <span class="font-bold">Login</span>
                    </h1>
                </div>
                <div class="p-4 bg-lime-300 rounded-b-md">
                    <form action="#" @submit.prevent="submit()" ref="login-form">
                        <div class="block mb-4">
                            <label class="block text-lime-800 font-bold text-lg" for="email">Email</label>
                            <input class="block w-full mt-2 rounded-sm h-8 p-2 text-lime-800 focus:outline-none" :class="{'border-2 border-red-600':(errors['email'] || errors['credentials'])}" type="email"  ref="email" required>
                            <span class="text-red-600 font-bold my-2"> {{ messages['email'] }} </span>
                        </div>
                        <div class="block mb-4">
                            <label class="block text-lime-800 font-bold text-lg" for="email">Password</label>
                            <input class="block w-full mt-2 rounded-sm h-8 p-2 text-lime-800 focus:outline-none" :class="{'border-2 border-red-600':(errors['password'] || errors['credentials'])}" type="password"  ref="password" required>
                            <span class="text-red-600 font-bold my-2"> {{ messages['password'] }} </span>
                        </div>
                        <div class="block mb-4">
                            <span class="text-red-600 font-bold my-2"> {{ messages['credentials'] }} </span>
                        </div>
                        <div class="flex mb-4 w-full">
                            <button class="text-white bg-lime-600 py-2 px-4 rounded-sm mx-auto max-w-max">
                                <i class="fa-solid fa-check mx-2"></i>
                                <span class="font-bold">Login</span>
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
                    axios.post('/api/login',{
                        email: this.$refs.email.value,
                        password: this.$refs.password.value,
                        device_name: "web",
                    }).then(response => {
                        localStorage.setItem('token',response.data.token);
                        this.$refs['login-form'].reset();
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
