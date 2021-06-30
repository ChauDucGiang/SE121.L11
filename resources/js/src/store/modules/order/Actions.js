// Services
import ApiService from "@/services/api.service";
import JwtService from "@/services/jwt.service";

export default {
    FETCH_ORDERS(context, params) {
        return new Promise(resolve => {
            ApiService.query("admin/order", {params})
                .then(({data}) => {
                    context.commit("SET_ORDERS", data);
                    resolve(data);
                })
                .catch(({response}) => {
                    console.log("FAIL")
                    // context.commit("SET_ERROR", response.data.message);
                });
        });
    },
    FETCH_ORDER(context, id) {
        return new Promise(resolve => {
            ApiService.get(`admin/order/${id}/edit`)
                .then(({data}) => {
                    context.commit("SET_ORDER", data.data);
                    resolve(data);
                })
                .catch(({response}) => {
                    console.log("FAIL")
                    // context.commit("SET_ERROR", response.data.message);
                });
        });
    },
    DELETE_ORDER(context, id) {
        return new Promise(resolve => {
            ApiService.delete(`admin/order/${id}`)
                .then(({data}) => {
                    context.commit("REMOVE_ORDER", data);
                    resolve(data);
                })
                .catch(({response}) => {
                    console.log("FAIL")
                    // context.commit("SET_ERROR", response.data.message);
                });
        });
    }
    ,
    UPDATE_CUSTOMER(context, payload) {
        return ApiService.update(`admin/customer`, payload.id, payload.params).then(({data}) => {
            context.commit("UPDATE_CUSTOMER", data);
            resolve(data);
        })
            .catch(({response}) => {
                console.log("FAIL")
                // context.commit("SET_ERROR", response.data.message);
            });
    }
}
