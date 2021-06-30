// Services
import ApiService from "@/services/api.service";
import JwtService from "@/services/jwt.service";

export default {
    STORE_PRODUCT(context, formdata) {
        return new Promise(resolve => {
            ApiService.post("admin/product", formdata)
                .then(({data}) => {
                    // context.commit("ADD_PRODUCT", data.data);
                    resolve(data);
                })
                .catch(({response}) => {
                    context.commit("SET_ERROR", response.data.errors);
                });
        });
    }
    ,
    FETCH_PRODUCTS(context, params) {
        return new Promise(resolve => {
            ApiService.query("admin/product", {params: params})
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
    CREATE_PRODUCT(context) {
        return new Promise(resolve => {
            ApiService.get("admin/product/create")
                .then(({data}) => {
                    context.commit("SET_CATEGORIES", data);
                    context.commit("SET_ERROR", []);
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
            ApiService.get(`admin/product/${id}/edit`)
                .then(({data}) => {
                    context.commit("SET_CATEGORIES", data);
                    context.commit("SET_PRODUCT", data);
                    context.commit("SET_ERROR", []);
                    resolve(data);
                })
                .catch(({response}) => {
                    console.log("FAIL")
                    // context.commit("SET_ERROR", response.data.message);
                });
        });
    }
    ,
    DELETE_PRODUCT(context, id) {
        return new Promise(resolve => {
            ApiService.delete(`admin/product/${id}`)
                .then(({data}) => {
                    context.commit("REMOVE_PRODUCT", id);
                    resolve(data);
                })
                .catch(({response}) => {
                    console.log("FAIL")
                    // context.commit("SET_ERROR", response.data.message);
                });
        });
    }
    ,
    UPDATE_PRODUCT(context, payload) {
        return new Promise(resolve => {
            ApiService.update('admin/product', payload.id, payload.params)
                .then(({data}) => {
                    // context.commit("ADD_USER", data.data);
                    context.commit("SET_ERROR", []);
                    resolve(data);
                })
                .catch(({response}) => {
                    context.commit("SET_ERROR", response.data.errors);
                });
        });
    }
}
