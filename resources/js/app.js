require('./bootstrap');

import Vue from 'vue';
window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Vuex from 'vuex';
Vue.use(Vuex);
import store from './vuex/store';

import auth from './auth'

import App from './components/App.vue';
import Login from './components/LoginForm';

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
