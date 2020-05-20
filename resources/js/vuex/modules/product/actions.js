export default {
    changeProducts(context, payload) {
        context.commit("CHANGE_PRODUCTS", payload);
    },

    changeSelectedProduct(context, payload) {
        context.commit("CHANGE_SELECTED_PRODUCTS", payload);
    }
}
