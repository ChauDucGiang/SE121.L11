const orderRouter = {
    path: 'order',
    component: () => import("@/views/pages/order/Order"),
    redirect: 'noRedirect',
    name: 'Order',
    meta: {
        title: 'Offers',
        icon: 'chart'
    },
    children: [
        {
            path: '',
            component: () => import('@/views/pages/order/List'),
            name: 'OrderList',
            meta: {
                breadcrumb: [
                    {title: 'Home', url: '/'},
                    {title: 'Offers'},
                    {title: 'List', active: true}
                ],
                pageTitle: 'List Offers',
            }
        },
        {
            path: ':id',
            component: () => import('@/views/pages/order/Show'),
            name: 'OrderShow',
            meta: {
                breadcrumb: [
                    {title: 'Home', url: '/'},
                    {title: 'Offers', url: '/admin/order'},
                    {title: 'Offer Detail', active: true}
                ],
                pageTitle: 'Offer Detail',
                rule: 'editor'
            }
        },
        // {
        //     path: ':id/edit',
        //     component: () => import('@/views/pages/order/Edit'),
        //     name: 'OrderEdit',
        //     meta: {
        //         breadcrumb: [
        //             {title: 'Home', url: '/'},
        //             {title: 'Orders', url: '/admin/customer'},
        //             {title: 'Edit', active: true}
        //         ],
        //         pageTitle: 'Edit Order',
        //     }
        // }
    ]
}

export default orderRouter

