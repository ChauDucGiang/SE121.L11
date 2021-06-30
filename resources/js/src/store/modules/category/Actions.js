// Services
import ApiService from "@/services/api.service";
import JwtService from "@/services/jwt.service";

export default {
    STORE_CATEGORY(context, formdata) {
        return new Promise(resolve => {
            ApiService.post("admin/category", formdata)
                .then(({data}) => {
                    context.commit("ADD_CATEGORY", data);
                    resolve(data);
                })
                .catch(({response}) => {
                    context.commit("SET_ERROR", response.data.errors);
                });
        });
    }
    ,
    FETCH_CATEGORIES(context, params) {
        return new Promise(resolve => {
            ApiService.query("admin/category", {params: params})
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
    FETCH_SUBCATEGORIES(context, id) {
        return new Promise(resolve => {
            ApiService.get(`admin/category/${id}`)
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
    FETCH_CATEGORY(context, id) {
        return new Promise(resolve => {
            ApiService.get(`admin/category/${id}/edit`)
                .then(({data}) => {
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
    DELETE_CATEGORY(context, id) {
        return new Promise(resolve => {
            ApiService.delete(`admin/category/${id}`)
                .then(({data}) => {
                    context.commit("REMOVE_CATEGORY", id);
                    resolve(data);
                })
                .catch(({response}) => {
                    console.log("FAIL")
                    // context.commit("SET_ERROR", response.data.message);
                });
        });
    }
    ,
    UPDATE_CATEGORY(context, payload) {
        return new Promise(resolve => {
            ApiService.update('admin/category', payload.id, payload.params)
                .then(({data}) => {
                    context.commit("UPDATE_CATEGORY", data);
                    context.commit("SET_ERROR", []);
                    resolve(data);
                })
                .catch(({response}) => {
                    context.commit("SET_ERROR", response.data.errors);
                });
        });
    }
}
