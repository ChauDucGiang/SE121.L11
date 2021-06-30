export default {
    SET_PRODUCTS(state, data) {
        state.products = data.data.data;
        state.total_record = data.data.last_page;
        state.categories = data.categories;
        state.subcategories = data.subcategories;
        state.colors = data.colors;
        state.packages = data.packages;
    },
    SET_CATEGORIES(state, data) {
        state.categories = data.categories;
        state.packages = data.packages;
    },
    SET_PRODUCT(state, data) {
        state.product = data.item_data;
    },
    ADD_PRODUCT(state, user) {
        state.users.unshift(user);
    },
    SET_ERROR(state, errors) {
        state.errors = errors;
    },
    REMOVE_PRODUCT(state, id) {
        const productIndex = state.products.findIndex((u) => u.id === id)
        state.products.splice(productIndex, 1);
        // state.total_record--;
    }
}
