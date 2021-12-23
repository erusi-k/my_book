require('./bootstrap');

import Alpine from 'alpinejs';
import Vue from 'vue';
import VueRouter from 'vue-router';
import BookCreateComponent from "./components/BookCreateComponent";
import BookListComponent from "./components/BookListComponent";
import BookShowComponent from "./components/BookShowComponent"
import StarRating from 'vue-star-rating';


window.Alpine = Alpine;

Alpine.start();

window.Vue = require('vue').default;


Vue.component('bookcreaet-component', require('./components/BookCreateComponent.vue').default);
Vue.component('booklist-component',require('./components/BookListComponent.vue').default);
Vue.component('booklist-component',require('./components/BookListComponent.vue').default);
Vue.component('bookshow-component',require('./components/BookShowComponent.vue').default);
Vue.component('header-component',require('./components/HeaderComponent.vue').default);
Vue.component('star-rating',StarRating);

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
            path: '/book/list',
            name: 'book.list',
            component: BookListComponent
        },
        {
            path:'/book/show/:bookId',
            name: 'book.show',
            component: BookShowComponent,
            props:true
        }
    ]
})

const app = new Vue({
    el: '#app',
    router
});