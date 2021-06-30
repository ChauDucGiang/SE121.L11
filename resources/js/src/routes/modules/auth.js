const authRouter = {
    path: '',
    component: () => import('@/layouts/full-page/FullPage.vue'),

    children: [
        {
            path: '/login',
            name: 'Login',
            component: () => import('@/views/auth/Login.vue'),
            meta: {
                auth: false
            },
        },
        {
            path: '/reset-password',
            name: 'ResetPassword',
            component: () => import('@/views/auth/ResetPassword.vue'),
            meta: {
                auth: true
            },
        },
        {
            path: '403',
            name: '403',
            component: () => import('@/views/error/403.vue'),
            meta: {
                auth: true
            },
        },
        {
            path: '404',
            name: '404',
            component: () => import('@/views/error/404.vue'),
            meta: {
                auth: true
            },
        },
    ]
}

export default authRouter
