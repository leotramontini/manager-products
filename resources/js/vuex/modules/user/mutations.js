export default {
    "CHANGE_USER_TOKEN" (state, payload) {
        state.token = payload
    },

    "CHANGE_USER" (state, payload) {
        state.user = payload;
    }
}
