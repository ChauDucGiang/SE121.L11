const packageRouter = {
    path: 'package',
    component: () => import("@/views/pages/package/Package"),
    redirect: 'noRedirect',
    name: 'Package',
    meta: {
        title: 'Package',
        icon: 'chart'
    },
    children: [
        {
            path: '',
            component: () => import('@/views/pages/package/List'),
            name: 'PackageList',
            meta: {
                breadcrumb: [
                    {title: 'Home', url: '/'},
                    {title: 'Packages'},
                    {title: 'List', active: true}
                ],
                pageTitle: 'List Packages',
            }
        },
    ]
}

export default packageRouter

