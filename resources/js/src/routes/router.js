import Vue from 'vue'
import Router from 'vue-router'

/*Modules*/
import authRouter from './modules/auth'
import userRouter from './modules/user'
import categoryRouter from './modules/category'
import packageRouter from './modules/package'
import productRouter from './modules/product'
import customerRouter from './modules/customer'
import orderRouter from './modules/order'
import homeRouter from './modules/home'


Vue.use(Router)

//Routes
const routes = [
    // =============================================================================
    // HOME PAGE LAYOUTS
    // =============================================================================
    {
        path: '/',
        component: () => import('@/layouts/home/Home.vue'),
        meta: {
            auth: true
        },
        children: [
            // =============================================================================
            // PAGES
            // =============================================================================
            homeRouter,
        ]
    },

    {
        // =============================================================================
        // MAIN LAYOUT ROUTES
        // =============================================================================
        path: '/admin',
        component: () => import('../layouts/main/Main.vue'),
        meta: {auth: 2, forbiddenRedirect: '/403'},
        children: [
            // =============================================================================
            // Theme Routes
            // =============================================================================
            userRouter,
            categoryRouter,
            productRouter,
            customerRouter,
            orderRouter,
            packageRouter,
        ],
    },
    // =============================================================================
    // FULL PAGE LAYOUTS
    // =============================================================================
    {
        path: '',
        component: () => import('@/layouts/full-page/FullPage.vue'),
        children: [
            // =============================================================================
            // PAGES
            // =============================================================================
            authRouter,
        ]
    },
    // Redirect to 404 page, if no match found
    {
        path: '*',
        redirect: '404'
    }
];

Vue.router = new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    scrollBehavior() {
        return {x: 0, y: 0}
    },
    routes: routes
})
//
// Vue.router.beforeEach((to, from, next) => {
//     // Remove initial loading
//     const appLoading = document.getElementById('loading-bg')
//     if (appLoading) {
//         appLoading.style.display = "block";
//     }
//     return next()
// })
Vue.router.afterEach(() => {
    // Remove initial loading
    const appLoading = document.getElementById('loading-bg')
    if (appLoading) {
        appLoading.style.display = "none";
    }
})

export default Vue.router
