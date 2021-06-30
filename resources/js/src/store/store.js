import Vue from 'vue'
import Vuex from 'vuex'

/*Modules*/
import moduleUser from './modules/user/moduleUser'
import moduleCategory from './modules/category/moduleCategory'
import moduleProduct from './modules/product/moduleProduct'
import moduleCustomer from './modules/customer/moduleCustomer'
import moduleOrder from './modules/order/moduleOrder'
import moduleHome from './modules/home/moduleHome'
import modulePackage from './modules/package/modulePackage'

/*Global Store*/
import state from "./state"
import getters from "./getters"
import mutations from "./mutations"
import actions from "./actions"

Vue.use(Vuex)

export default new Vuex.Store({
    getters,
    mutations,
    state,
    actions,
    modules: {
        user: moduleUser,
        category: moduleCategory,
        product: moduleProduct,
        customer: moduleCustomer,
        order: moduleOrder,
        home: moduleHome,
        package: modulePackage,
    },
    strict: process.env.NODE_ENV !== 'production'
})
