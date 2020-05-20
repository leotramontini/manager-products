export default {
    "CHANGE_PRODUCTS" (state, payload) {
        state.products = payload;
    },

    "CHANGE_SELECTED_PRODUCT"(state, payload) {
        state.selectedProduct = payload;
    }
}
