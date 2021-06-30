const customerRouter = {
    path: 'customer',
    component: () => import("@/views/pages/customer/Customer"),
    redirect: 'noRedirect',
    name: 'Customer',
    meta: {
        title: 'Customer',
        icon: 'chart'
    },
    children: [
        {
            path: '',
            component: () => import('@/views/pages/customer/List'),
            name: 'CustomerList',
            meta: {
                breadcrumb: [
                    {title: 'Home', url: '/'},
                    {title: 'Customers'},
                    {title: 'List', active: true}
                ],
                pageTitle: 'List Customers',
            }
        },
        {
            path: 'create',
            component: () => import('@/views/pages/customer/Create'),
            name: 'CustomerCreate',
            meta: {
                breadcrumb: [
                    {title: 'Home', url: '/'},
                    {title: 'Customers', url: '/admin/customer'},
                    {title: 'Create', active: true}
                ],
                pageTitle: 'Create Customer',
                rule: 'editor'
            }
        },
        // {
        //   path: ':id',
        //   component: () => import('@/views/pages/customer/Show'),
        //   name: 'ShowCustomer',
        //   meta: {
        //     breadcrumb: [
        //       {title: 'Home', url: '/'},
        //       {title: 'Customer'},
        //       {title: 'List', active: true}
        //     ],
        //     pageTitle: 'Show Customer',
        //     rule: 'editor'
        //   }
        // },
        {
            path: ':id/edit',
            component: () => import('@/views/pages/customer/Edit'),
            name: 'CustomerEdit',
            meta: {
                breadcrumb: [
                    {title: 'Home', url: '/'},
                    {title: 'Customers', url: '/admin/customer'},
                    {title: 'Edit', active: true}
                ],
                pageTitle: 'Edit Customer',
            }
        }
    ]
}

export default customerRouter

