require('./bootstrap');

import Alpine from 'alpinejs';
import Vue from 'vue';
import StarRating from 'vue-star-rating';
import VueRouter from 'vue-router';
import router from './router';


window.Alpine = Alpine;

Alpine.start();

window.Vue = require('vue').default;


Vue.component('bookcreaet-component', require('./components/BookCreateComponent.vue').default);
Vue.component('booklist-component',require('./components/BookListComponent.vue').default);
Vue.component('booklist-component',require('./components/BookListComponent.vue').default);
Vue.component('bookshow-component',require('./components/BookShowComponent.vue').default);
Vue.component('bookedit-component',require('./components/BookEditComponent.vue').default);
Vue.component('header-component',require('./components/HeaderComponent.vue').default);
Vue.component('star-rating',StarRating);

Vue.use(VueRouter);



const app = new Vue({
    el: '#app',
    router
});