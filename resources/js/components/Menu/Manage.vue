<template>
    <div class="container w-4/5 mx-auto">
        <h1 class="text-white text-center font-bold text-xl">Menus</h1>
        <div class="grid grid-cols-1 mt-24 justify-items-center overflow-auto">
            <table class="w-full p-4">
                <tr class="bg-slate-900 text-white">
                    <th class="p-4">ID</th>
                    <th class="p-4">Title</th>
                    <th class="p-4">Description</th>
                    <th class="p-4">Discount</th>
                    <th class="p-4">Actions</th>
                </tr>
                <tr class=" text-slate-900" v-for="(menu,index) in menus" :class="{'bg-gray-300':(index%2),'bg-gray-100':(index%2 != 1)}">
                    <td class="p-4 text-center">{{ menu.id }}</td>
                    <td class="p-4 text-center">{{ menu.title }}</td>
                    <td class="p-4 text-center">{{ menu.description }}</td>
                    <td class="p-4 text-center">{{ menu.discount??'null' }}</td>
                    <td class="p-4 text-center">
                        <router-link :to='"/menu/"+menu.id+"/edit"' class="text-white p-2 bg-slate-900 hover:bg-slate-800 mx-2"> 
                            <i class="fa-solid fa-pen mx-2"></i>
                            <span>Edit</span>
                        </router-link>
                        <a href="#" class="text-white p-2 bg-red-900 hover:bg-red-800 mx-2" @click="deleteMenu(menu.id)"> 
                            <i class="fa-solid fa-trash mx-2"></i>
                            <span>Delete</span>
                        </a>
                    </td>
                </tr>
            </table>
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
                    axios.get('/api/menu/manage').then(response => {
                        this.menus = response.data.menus;
                    }).catch(error => {

                    });
                });
            },
            deleteMenu(id){
                axios.get('/sanctum/csrf-cookie').then(csrf_response =>{
                    axios.delete('/api/menu/'+id).then(response => {
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
