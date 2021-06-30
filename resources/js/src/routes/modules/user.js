const userRouter = {
    path: 'user',
    component: () => import("@/views/pages/user/User"),
    redirect: 'noRedirect',
    name: 'User',
    meta: {
        title: 'User',
        icon: 'chart'
    },
    children: [
        {
            path: '',
            component: () => import('@/views/pages/user/List'),
            name: 'UserList',
            meta: {
                breadcrumb: [
                    {title: 'Home', url: '/'},
                    {title: 'User'},
                    {title: 'List', active: true}
                ],
                pageTitle: 'List Users',
            }
        },
        {
            path: 'create',
            component: () => import('@/views/pages/user/Create'),
            name: 'UserCreate',
            meta: {
                breadcrumb: [
                    {title: 'Home', url: '/'},
                    {title: 'Users', url: '/admin/user'},
                    {title: 'Create', active: true}
                ],
                pageTitle: 'Create User',
                rule: 'editor'
            }
        },
        // {
        //   path: ':id',
        //   component: () => import('@/views/pages/user/Show'),
        //   name: 'ShowUser',
        //   meta: {
        //     breadcrumb: [
        //       {title: 'Home', url: '/'},
        //       {title: 'User'},
        //       {title: 'List', active: true}
        //     ],
        //     pageTitle: 'Show User',
        //     rule: 'editor'
        //   }
        // },
        {
            path: ':id/edit',
            component: () => import('@/views/pages/user/Edit'),
            name: 'UserEdit',
            meta: {
                breadcrumb: [
                    {title: 'Home', url: '/'},
                    {title: 'Users', url: '/admin/user'},
                    {title: 'Edit', active: true}
                ],
                pageTitle: 'Edit User',
            }
        }
    ]
}

export default userRouter

