export default {
    SET_CUSTOMERS(state, data) {
        state.customers = data.data;
        state.errors = [];
    },
    ADD_CUSTOMER(state, data) {
        state.customers = data.data;
        state.errors = [];
    },
    SET_ERROR(state, errors) {
        state.errors = errors;
    },
    SET_COUNTRIES(state, data) {
        state.countries = data.data;
    },
    UPDATE_CUSTOMER(state, data) {
        // state.customers = data.data;
        state.errors = [];
    },
    REMOVE_CUSTOMER(state, data) {
        state.customers = data.data;
        state.errors = [];
    }
}
