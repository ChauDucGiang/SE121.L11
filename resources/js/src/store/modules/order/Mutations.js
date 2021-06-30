export default {
    SET_ORDERS(state, data) {
        state.orders = data.data.data;
        state.total = data.data.last_page;
        state.total_record = data.data.total;
    },
    SET_ORDER(state, data) {
        state.order = data;
    },
    SET_ERROR(state, errors) {
        state.errors = errors;
    },
    REMOVE_ORDER(state, data) {
        state.orders = data.data.data;
        state.total = data.data.last_page;
        state.total_record = data.data.total;
    }
}
