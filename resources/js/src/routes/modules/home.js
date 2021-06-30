const homeRouter = {
    path: '/',
    component: () => import("@/views/pages/home/Home"),
    redirect: 'noRedirect',
    name: 'Home',
    meta: {
        title: 'Home',
        icon: 'chart'
    },
    children: [
        {
            path: '',
            component: () => import('@/views/pages/home/List'),
            name: 'List',
        },
        {
            path: 'category/:id',
            component: () => import('@/views/pages/home/CategoryProduct'),
            name: 'CategoryDetail',
        },
        {
            path: 'product/:id',
            component: () => import('@/views/pages/home/Product'),
            name: 'ProductDetail',
        },
        {
            path: 'cart',
            component: () => import('@/views/pages/home/Cart'),
            name: 'Cart',
        },
        {
            path: 'profile',
            component: () => import('@/views/pages/home/Profile'),
            name: 'Profile',
        },
        {
            path: 'offer',
            component: () => import('@/views/pages/home/Order'),
            name: 'OfferView',
        },
        {
            path: 'offer/:id',
            component: () => import('@/views/pages/home/OrderDetail'),
            name: 'OfferShow',
        },
    ]
}

export default homeRouter

