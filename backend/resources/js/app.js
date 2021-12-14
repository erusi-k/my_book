require('./bootstrap');

import Alpine from 'alpinejs';
import Vue from 'vue';
import VueRouter from 'vue-router';
import BookCreateComponent from "./components/BookCreateComponent";
import BookListComponent from "./components/BookListComponent";


window.Alpine = Alpine;

Alpine.start();

window.Vue = require('vue').default;


Vue.component('bookcreaet-component', require('./components/BookCreateComponent.vue').default);
Vue.component('header-component',require('./components/HeaderComponent.vue').default);


Vue.use(VueRouter);

const router = new VueRouter({
    mode:'history',
    routes:[
        {
            path: '/book/create',
            name: 'book.create',
            component: BookCreateComponent
        },
        {
            path: '/book',
            name: 'book.list',
            component: BookListComponent
        },
    ]
})

const app = new Vue({
    el: '#app',
    router
});