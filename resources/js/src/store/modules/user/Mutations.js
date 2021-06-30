export default {
    SET_USERS(state, data) {
        state.users = data.data.data
        state.total = data.data.last_page
    },
    ADD_USER(state, user) {
        // state.users.unshift(user);
    },
    SET_ERROR(state, errors) {
        state.errors = errors;
    },
    REMOVE_USER(state, id) {
        const userIndex = state.users.findIndex((u) => u.id === id)
        state.users.splice(userIndex, 1)
    }
}
