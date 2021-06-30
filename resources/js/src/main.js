/*=========================================================================================
  File Name: main.js
  Description: main vue(js) file
  ----------------------------------------------------------------------------------------
  Item Name: VietNam HouseWares Admin Dashboard
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import Vue from 'vue'
import App from './App.vue'
import VueHtmlToPaper from 'vue-html-to-paper';


const options = {
    name: '_blank',
    specs: [
        'fullscreen=no',
        'titlebar=yes',
        'scrollbars=yes'
    ],
    styles: [
        'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
        // "https://unpkg.com/kidlat-css/css/kidlat.css",
        '/css/export-pdf.css'
    ]
}

Vue.use(VueHtmlToPaper, options);


// Vuesax Component Framework
import Vuesax from 'vuesax'

Vue.use(Vuesax)


// // axios
// import axios from './axios.js'
// Vue.prototype.$http = axios

// Filters
import './filters/filters.js'


// Theme Configurations
import '../themeConfig.js'


// Globally Registered Components
import './globalComponents.js'


// Vue Router
import router from './routes/router'

//Vue auth
import http from './http'

//VUe config
import config from './config'

// Vuex Store
import store from './store/store'


// Vuejs - Vue wrapper for hammerjs
import {VueHammer} from 'vue2-hammer'

Vue.use(VueHammer)


// PrismJS
import 'prismjs'
import 'prismjs/themes/prism-tomorrow.css'


// Vue select css
// Note: In latest version you have to add it separately
// import 'vue-select/dist/vue-select.css';


Vue.config.productionTip = false

new Vue({
    http,
    router,
    store,
    config,
    render: h => h(App)
}).$mount('#app')
