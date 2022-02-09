require('./bootstrap');

import Alpine from 'alpinejs';
import Vue from 'vue';
import {ValidationProvider,ValidationObserver, extend,localize} from 'vee-validate';
import * as originalRules from 'vee-validate/dist/rules';
import ja from 'vee-validate/dist/locale/ja.json';
import VueCarousel from 'vue-carousel';
import StarRating from 'vue-star-rating';
import VueRouter from 'vue-router';
import router from './router';
import 'vue-loaders/dist/vue-loaders.css';
import VueLoaders from 'vue-loaders';
import VueSwal from 'vue-swal';

let rule;
for(rule in originalRules) {
    extend(rule,{
        ...originalRules[rule],
    });
}


localize('ja',ja);


window.Alpine = Alpine;

Alpine.start();

window.Vue = require('vue').default;

Vue.component('login-component',require('./components/login.vue').default);
Vue.component('about',require('./components/about.vue').default);
Vue.component('bookCreaet-component', require('./components/BookCreateComponent.vue').default);
Vue.component('bookHome-component',require('./components/BookHomeComponent.vue').default);
Vue.component('bookShow-component',require('./components/BookShowComponent.vue').default);
Vue.component('bookEdit-component',require('./components/BookEditComponent.vue').default);
Vue.component('header-component',require('./components/HeaderComponent.vue').default);
Vue.component('bookOtherList-component',require('./components/BookOtherListComponent.vue').dafault);
Vue.component('bookMylist-component',require('./components/BookMyListComponent.vue').default);
Vue.component('star-rating',StarRating);
Vue.component('ValidationProvider',ValidationProvider);
Vue.component('ValidationObserver',ValidationObserver);
Vue.component('vue-loaders',VueLoaders);

Vue.use(VueRouter);
Vue.use(VueCarousel);
Vue.use(VueLoaders);
Vue.use(VueSwal);






const app = new Vue({
    el: '#app',
    router
});