export default {
    SET_CATEGORIES(state, data) {
        state.categories = data.data;
        state.listCategory = data.listCategory;
    },
    ADD_CATEGORY(state, data) {
        state.categories = data.data;
        state.listCategory = data.listCategory;
        // state.categories.unshift(category);
    },
    REMOVE_CATEGORY(state, id) {
        // state.categories = data.data;
        const userIndex = state.categories.findIndex((u) => u.id === id)
        state.categories.splice(userIndex, 1)
    },
    UPDATE_CATEGORY(state, data) {
        state.categories = data.data;
    },
    SET_ERROR(state, errors) {
        state.errors = errors;
    },
}
