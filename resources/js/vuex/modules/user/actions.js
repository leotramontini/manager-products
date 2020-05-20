export default {
    changeUserToken(context, payload) {
        context.commit("CHANGE_USER_TOKEN", payload);
    },

    changeUser(context, payload) {
        context.commit("CHANGE_USER", payload)
    }
}
