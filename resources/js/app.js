require('./bootstrap');

import Vue from 'vue';
window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Vuex from 'vuex';
Vue.use(Vuex);

import auth from './auth'
import store from './vuex/store';
import App from './components/App.vue';
import Login from './components/LoginForm';
import Dashboard from "./components/Dashboard";
import ListProducts from "./components/products/ListProducts";
import CreateProduct from "./components/products/CreateProduct";
import UpdateProduct from "./components/products/UpdateProduct";

function requireAuth (to, from, next) {
    if (!auth.loggedIn()) {
        next({
            path: '/login',
            query: { redirect: to.fullPath }
        })
    } else {
        next()
    }
}

const router = new VueRouter({
    mode: 'history',
    base: __dirname,
    routes: [
        {
            path: '/dashboard',
            component: Dashboard,
            beforeEnter: requireAuth,
            children: [
                {
                    path: '/list-products',
                    component: ListProducts
                },
                {
                    path: '/create-product',
                    component: CreateProduct
                },
                {
                    path: '/update-product',
                    component: UpdateProduct
                },
            ]
        },
        { path: '/login', component: Login },
        { path: '/logout',
            beforeEnter (to, from, next) {
                auth.logout()
                next('/')
            }
        }
    ]
})

/* eslint-disable no-new */
new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
})
