const productRouter = {
    path: 'product',
    component: () => import("@/views/pages/product/Product"),
    redirect: 'noRedirect',
    name: 'Product',
    meta: {
        title: 'Product',
        icon: 'chart'
    },
    children: [
        {
            path: '',
            component: () => import('@/views/pages/product/List'),
            name: 'ProductList',
            meta: {
                breadcrumb: [
                    {title: 'Home', url: '/'},
                    {title: 'Products'},
                    {title: 'List', active: true}
                ],
                pageTitle: 'List Products',
            }
        },
        {
            path: 'create',
            component: () => import('@/views/pages/product/Create'),
            name: 'ProductCreate',
            meta: {
                breadcrumb: [
                    {title: 'Home', url: '/'},
                    {title: 'Products', url: '/admin/product'},
                    {title: 'Create', active: true}
                ],
                pageTitle: 'Create Product',
            }
        },
        {
            path: ':id',
            component: () => import('@/views/pages/product/Show'),
            name: 'ProductShow',
            meta: {
                breadcrumb: [
                    {title: 'Home', url: '/'},
                    {title: 'Products', url: '/admin/product'},
                    {title: 'List', active: true}
                ],
                pageTitle: 'Show Product',
            }
        },
        {
            path: ':id/edit',
            component: () => import('@/views/pages/product/Edit'),
            name: 'ProductEdit',
            meta: {
                breadcrumb: [
                    {title: 'Home', url: '/'},
                    {title: 'Products', url: '/admin/product'},
                    {title: 'Edit', active: true}
                ],
                pageTitle: 'Edit Product',
            }
        }
    ]
}

export default productRouter

