import Vue from "vue";
import Vuex from "vuex"
Vue.use(Vuex);

import User from './modules/user/main';
import Product from './modules/product/main';

export default new Vuex.Store({
    modules: {
        User,
        Product
    }
})
