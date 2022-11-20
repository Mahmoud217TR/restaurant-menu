<template>
    <div class="grid gird-cols-1shadow-lg" :class="{'md:grid-cols-1':main}">
        <div class="" v-for="category in categories">
            <div class="p-4 grid grid-cols-2 bg-slate-900" v-if="main">
                <h2 class="text-white font-bold text-start">
                    <i class="fa-solid fa-copy mx-2"></i>
                    <span>{{ category.title }}</span>
                </h2>
                <div class="text-end">
                    <span class="text-white bg-red-600 max-w-max font-bold px-2 rounded-full" v-if="category.discount">{{category.discount}}% Discount</span>
                </div>
            </div>
            <div :class="' bg-gray-300 '+getLevelPadding(category.level)">
                <div class="w-full">
                    <div class="grid grid-cols-2 items-center">
                        <h2 v-if="!main" class="font-bold text-slate-900 py-4">
                            <i class="fa-solid fa-copy mx-2"></i>
                            <span>{{ category.title }}</span>
                        </h2>
                        <span class="text-white bg-red-600 max-w-max font-bold px-2 rounded-full justify-self-end mr-2" v-if="(category.discount&&(!main))">{{category.discount}}% Discount</span>
                    </div>
                    <div v-for="(item, index) in category.items" class="grid grid-cols-2 py-2" :class="{'pl-2':!main,'bg-gray-200':(index%2 != 1)}">
                        <div class="p-2">
                            <p class="text-start">
                                {{ item.title }}
                            </p>
                        </div>
                        <div class="p-2">
                            <p class="text-end" v-if="!item.discount_price">
                                <span class="font-bold"> {{ item.price.formatted }} </span>
                            </p>
                            <p class="text-end" v-if="item.discount_price">
                                <strike class="text-red-600 font-bold"> {{ item.price.formatted }} </strike>
                                <span class="font-bold ml-4">{{item.discount_price.formatted}}</span>
                            </p>
                        </div>
                    </div>
                </div>
                <Categories :categories="category.sub_categories" :main="false"></Categories>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['categories','main'],
        methods: {
            getLevelPadding(level){
                switch(level){
                    case 0 :{
                        return 'pl-0';
                    }
                    case 1 :{
                        return 'pl-8';
                    }
                    case 2 :{
                        return 'pl-12';
                    }
                    case 3 :{
                        return 'pl-16';
                    }
                }
            }
        },
    }
</script>
