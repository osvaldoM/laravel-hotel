/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'

Vue.use(VueRouter);

import App from './views/App'
import Hotel from './views/Hotel'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/home',
            name: 'home',
            component: Hotel
        },
    ],
});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});

// Menu Toggle
$(".menu-toggle").on('click', function(e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    $('.wrapper').toggleClass("toggled");
    $('.expand-toggler').toggleClass('hidden');
});
