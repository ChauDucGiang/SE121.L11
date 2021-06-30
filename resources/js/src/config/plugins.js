import Vue from 'vue'

import auth from '@websanova/vue-auth/src/index.js';
import authBearer from '@websanova/vue-auth/drivers/auth/bearer.js';
import httpAxios from '@websanova/vue-auth/drivers/http/axios.1.x.js';
import httpVueResource from '@websanova/vue-auth/drivers/http/vue-resource.1.x.js';
import routerVueRouter from '@websanova/vue-auth/drivers/router/vue-router.2.x.js';

Vue.use(auth, {
    auth: authBearer,
    http: httpAxios, // Axios
    // http: httpVueResource, // Vue Resource
    router: routerVueRouter,
    tokenDefaultName: 'token',
    tokenStore: ['localStorage'],
    rolesVar: 'role',
    notFoundRedirect: {name: '404'},
    registerData: {url: 'auth/register', method: 'POST', redirect: '/login'},
    loginData: {url: 'auth/login', method: 'POST', redirect: '', fetchUser: true},
    logoutData: {url: 'auth/logout', method: 'POST', redirect: '/login', makeRequest: true},
    fetchData: {url: 'auth/user', method: 'GET', enabled: true},
    refreshData: {url: 'auth/refresh', method: 'GET', enabled: true, interval: 30},
    _invalidToken: function (res) {
        if (res.status === 401 || res.status === 400 || res.status === 500) {
            this.options.logoutProcess.call(this, res, {redirect: '/auth/logout'})
        }
    },

    // parseUserData(data) {
    //     return data.original || {}
    // },
});
