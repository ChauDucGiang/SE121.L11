// Services
import ApiService from "@/services/api.service";
import JwtService from "@/services/jwt.service";

export default {
    STORE_CUSTOMER(context, formdata) {
        return new Promise(resolve => {
            ApiService.post("admin/customer", formdata)
                .then(({data}) => {
                    context.commit("ADD_CUSTOMER", data);
                    resolve(data);
                })
                .catch(({response}) => {
                    context.commit("SET_ERROR", response.data.errors);
                });
        });
    },
    FETCH_CUSTOMERS(context) {
        return new Promise(resolve => {
            ApiService.get("admin/customer")
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
    FETCH_COUNTRIES(context) {
        return new Promise(resolve => {
            ApiService.get("admin/customer/create")
                .then(({data}) => {
                    context.commit("SET_COUNTRIES", data);
                    context.commit("SET_ERROR", []);
                    resolve(data);
                })
                .catch(({response}) => {
                    console.log("FAIL")
                    // context.commit("SET_ERROR", response.data.message);
                });
        });
    },
    FETCH_CUSTOMER(context, id) {
        return new Promise(resolve => {
            ApiService.get(`admin/customer/${id}/edit`)
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
    DELETE_CUSTOMER(context, id) {
        return new Promise(resolve => {
            ApiService.delete(`admin/customer/${id}`)
                .then(({data}) => {
                    context.commit("REMOVE_CUSTOMER", data);
                    resolve(data);
                })
                .catch(({response}) => {
                    console.log("FAIL")
                    // context.commit("SET_ERROR", response.data.message);
                });
        });
    },

    UPDATE_CUSTOMER(context, payload) {
        return new Promise(resolve => {
            ApiService.update('admin/customer', payload.id, payload.params)
                .then(({data}) => {
                    // context.commit("ADD_USER", data.data);
                    context.commit("SET_ERROR", []);
                    resolve(data);
                })
                .catch(({response}) => {
                    context.commit("SET_ERROR", response.data.errors);
                });
        });
    },
    REMOVE_ERRORS({commit}) {
        commit('SET_ERROR', [])
    },
}
