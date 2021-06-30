const categoryRouter = {
    path: 'category',
    component: () => import("@/views/pages/category/Category"),
    redirect: 'noRedirect',
    name: 'Category',
    meta: {
        title: 'Category',
        icon: 'chart'
    },
    children: [
        {
            path: '',
            component: () => import('@/views/pages/category/List'),
            name: 'CategoryList',
            meta: {
                breadcrumb: [
                    {title: 'Home', url: '/'},
                    {title: 'Categories'},
                    {title: 'List', active: true}
                ],
                pageTitle: 'List Categories',
            }
        },
        {
            path: ':id',
            component: () => import('@/views/pages/category/ListSubCategory'),
            name: 'CategoryShow',
            meta: {
                breadcrumb: [
                    {title: 'Home', url: '/'},
                    {title: 'Categories', url: '/admin/category'},
                    {title: 'List', active: true}
                ],
                pageTitle: 'Category Show',
            }
        },
    ]
}

export default categoryRouter

