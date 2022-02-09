import Router from 'vue-router';
import BookCreateComponent from "./components/BookCreateComponent";
import BookHomeComponent from "./components/BookHomeComponent";
import BookShowComponent from "./components/BookShowComponent";
import BookEditComponent from "./components/BookEditComponent";
import BookOtherListComponent from "./components/BookOtherListComponent";
import BookMyListComponent from "./components/BookMyListComponent";
import login from "./components/login.vue";
import about from "./components/about.vue";

export default new Router({
    mode:'history',
    routes:[
            {
                path: '/book/create',
                name: 'book.create',
                component: BookCreateComponent
            },
            {
                path: '/book/home',
                name: 'book.home',
                component: BookHomeComponent
            },                          
            {
                path:'/book/show/:bookId',
                name: 'book.show',
                component: BookShowComponent,
                props:true
            },
            {
                path:'/book/edit/:bookId',
                name: 'book.edit',
                component: BookEditComponent,
                props:true
            },

            {
                path:'/book/other',
                name: 'book.other',
                component: BookOtherListComponent,
                props:true
            },

            {
                path:'/book/mylist',
                name: 'book.mylist',
                component: BookMyListComponent,
                props:true
            },

            {
                path: "/book/login",
                name: "login",
                component: login,
                meta: {guestOnly: true}
            },

            {
                path: "/book/about",
                name: "about",
                component: about,
                meta: {authOnly: true}
            }
    ]
})