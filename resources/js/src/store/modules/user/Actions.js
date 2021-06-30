// Services
import ApiService from "@/services/api.service";
import JwtService from "@/services/jwt.service";

export default {
    STORE_USER(context, params) {
        return new Promise(resolve => {
            ApiService.post("admin/user", params)
                .then(({data}) => {
                    context.commit("ADD_USER", data.data);
                    resolve(data);
                })
                .catch(({response}) => {
                    context.commit("SET_ERROR", response.data.errors);
                });
        });
    },
    FETCH_USERS(context, params = null) {
        return new Promise(resolve => {
            ApiService.query("admin/user", {params})
                .then(({data}) => {
                    context.commit("SET_USERS", data);
                    resolve(data);
                })
                .catch(({response}) => {
                    console.log("FAIL")
                    // context.commit("SET_ERROR", response.data.message);
                });
        });
    },
    FETCH_USER(context, id) {
        return new Promise(resolve => {
            ApiService.get(`admin/user/${id}/edit`)
                .then(({data}) => {
                    // context.commit("SET_USERS", data.data);
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
    DELETE_USERS(context, id) {
        return new Promise(resolve => {
            ApiService.delete(`admin/user/${id}`)
                .then(({data}) => {
                    context.commit("REMOVE_USER", data.data);
                    resolve(data);
                })
                .catch(({response}) => {
                    console.log("FAIL")
                    // context.commit("SET_ERROR", response.data.message);
                });
        });
    }
    ,
    UPDATE_USER(context, payload) {
        return new Promise(resolve => {
            ApiService.update('admin/user', payload.id, payload.params)
                .then(({data}) => {
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
