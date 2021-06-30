export default {
    SET_PACKAGES(state, data) {
        state.packages = data.data;
    },
    ADD_PACKAGE(state, data) {
        state.packages = data.data;
        // state.packages.unshift(category);
    },
    REMOVE_PACKAGE(state, id) {
        // state.packages = data.data;
        const userIndex = state.packages.findIndex((u) => u.id === id)
        state.packages.splice(userIndex, 1)
    },
    UPDATE_PACKAGE(state, data) {
        state.packages = data.data;
    },
    SET_ERROR(state, errors) {
        state.errors = errors;
    },
}
