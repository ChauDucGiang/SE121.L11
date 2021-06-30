// Services
import ApiService from "@/services/api.service";
import JwtService from "@/services/jwt.service";

export default {
    STORE_PACKAGE(context, formdata) {
        return new Promise(resolve => {
            ApiService.post("admin/package", formdata)
                .then(({data}) => {
                    context.commit("ADD_PACKAGE", data);
                    resolve(data);
                })
                .catch(({response}) => {
                    context.commit("SET_ERROR", response.data.errors);
                });
        });
    }
    ,
    FETCH_PACKAGES(context, params) {
        return new Promise(resolve => {
            ApiService.query("admin/package", {params: params})
                .then(({data}) => {
                    context.commit("SET_PACKAGES", data);
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
            ApiService.get(`admin/package/${id}`)
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
    FETCH_PACKAGE(context, id) {
        return new Promise(resolve => {
            ApiService.get(`admin/package/${id}/edit`)
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
    DELETE_PACKAGE(context, id) {
        return new Promise(resolve => {
            ApiService.delete(`admin/package/${id}`)
                .then(({data}) => {
                    context.commit("REMOVE_PACKAGE", id);
                    resolve(data);
                })
                .catch(({response}) => {
                    console.log("FAIL")
                    // context.commit("SET_ERROR", response.data.message);
                });
        });
    },
    UPDATE_PACKAGE(context, payload) {
        return new Promise(resolve => {
            ApiService.update('admin/package', payload.id, payload.params)
                .then(({data}) => {
                    context.commit("UPDATE_PACKAGE", data);
                    context.commit("SET_ERROR", []);
                    resolve(data);
                })
                .catch(({response}) => {
                    context.commit("SET_ERROR", response.data.errors);
                });
        });
    }
}
