require('./bootstrap');

import Vue from 'vue';
window.Vue = require('vue');


/**
 * Routes imports and assigning
 */
import VueRouter from 'vue-router';
Vue.use(VueRouter);
import routes from './routes';

const router = new VueRouter({
    mode: 'history',
    routes
});

import vuetify from './plugins/vuetify'

const app = new Vue({
    el: '#app',
    vuetify,
    router
});
