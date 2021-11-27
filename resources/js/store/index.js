import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from "vuex-persistedstate";
Vue.use(Vuex);

import product_cart from './modules/product_cart';
import checkout from './modules/checkout';
import auth_information from './modules/auth_information';
import product from './modules/product';

const store = new Vuex.Store({
    modules: {
        product_cart,
        checkout,
        auth_information,
        product,
    },
    state: {},
    getters: {},
    mutations: {},
    actions: {},
    plugins: [createPersistedState()],
});

export default store;
