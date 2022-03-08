import Router from 'vue-router';
import BookCreateComponent from "./components/BookCreateComponent";
import BookHomeComponent from "./components/BookHomeComponent";
import BookShowComponent from "./components/BookShowComponent";
import BookEditComponent from "./components/BookEditComponent";
import BookOtherListComponent from "./components/BookOtherListComponent";
import BookMyListComponent from "./components/BookMyListComponent";

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
    ]
})