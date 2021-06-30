// Services
import ApiService from "@/services/api.service";
import JwtService from "@/services/jwt.service";

export default {
    STORE_ORDER(context, formdata) {
        return new Promise(resolve => {
            ApiService.post("order", formdata)
                .then(({data}) => {
                    context.commit("ADD_ORDER", data);
                    resolve(data);
                })
                .catch(({response}) => {
                    // context.commit("SET_ERROR", response.data.errors);
                });
        });
    },
    FETCH_PRODUCTS(context) {
        return new Promise(resolve => {
            ApiService.get('home')
                .then(({data}) => {
                    context.commit("SET_PRODUCTS", data);
                    resolve(data);
                })
                .catch(({response}) => {
                    console.log("FAIL")
                    // context.commit("SET_ERROR", response.data.message);
                });
        });
    },
    FETCH_CATEGORY_PRODUCTS(context, payload) {
        return new Promise(resolve => {
            ApiService.query('home', {params: payload})
                .then(({data}) => {
                    context.commit("SET_PRODUCTS", data);
                    context.commit("SET_SUBCATEGORIES", data);
                    context.commit("SET_TOTALRECORD", data);
                    resolve(data);
                })
                .catch(({response}) => {
                    console.log("FAIL")
                    // context.commit("SET_ERROR", response.data.message);
                });
        });
    },
    FETCH_PRODUCT(context, id) {
        return new Promise(resolve => {
            ApiService.get(`product/${id}`)
                .then(({data}) => {
                    // context.commit("SET_USERS", data.data);
                    resolve(data);
                })
                .catch(({response}) => {
                    console.log("FAIL")
                    // context.commit("SET_ERROR", response.data.message);
                });
        });
    },
    FETCH_CATEGORIES(context) {
        return new Promise(resolve => {
            ApiService.get("categories")
                .then(({data}) => {
                    context.commit("SET_CATEGORIES", data);
                    resolve(data);
                })
                .catch(({response}) => {
                    console.log("FAIL")
                    // context.commit("SET_ERROR", response.data.message);
                });
        });
    },
    RESET_PASSWORD(context, payload) {
        return new Promise(resolve => {
            ApiService.update('reset-password', payload.id, payload.params)
                .then(({data}) => {
                    // context.commit("ADD_USER", data.data);
                    resolve(data);
                })
                .catch(({response}) => {
                    context.commit("SET_ERROR", response.data.errors);
                });
        });
    },
    FETCH_CUSTOMERS(context) {
        return new Promise(resolve => {
            ApiService.get("customers")
                .then(({data}) => {
                    context.commit("SET_CUSTOMERS", data);
                    resolve(data);
                })
                .catch(({response}) => {
                    console.log("FAIL")
                    // context.commit("SET_ERROR", response.data.message);
                });
        });
    },
    toggleItemInWishList({commit}, item) {
        commit('TOGGLE_ITEM_IN_WISH_LIST', item)
    },
    toggleItemInCart({getters, commit, dispatch}, item) {
        getters.isInCart(item.id) ? commit('REMOVE_ITEM_FROM_CART', item) : dispatch('additemInCart', item)
    },
    additemInCart({commit}, item) {
        // Below properties should be added as per requirement from back-end
        // This is added just for demo purpose
        item['new_price'] = item.price
        item['images_export'] = ['', '', '']

        commit('ADD_ITEM_IN_CART', item)
    },
    updateItemNewPrice({commit}, payload) {
        commit('UPDATE_ITEM_PRICE', payload)
    },
    updateItemImages({commit}, payload) {
        commit('UPDATE_IMAGES', payload)
    },
    removeCartItem({commit}) {
        commit('REMOVE_CART')
    }
}
