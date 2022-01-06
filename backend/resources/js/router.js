import Router from 'vue-router';


export default new Router({
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
            },
            {
                path:'/book/edit/:bookId',
                name: 'book.edit',
                component: BookEditComponent,
                props:true
            }
    ]
})