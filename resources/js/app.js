/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
// register the plugin on vue
import Toasted from 'vue-toasted';

Vue.use(VueRouter);
Vue.use(Toasted, {
    router: VueRouter
});

import App from './views/App'
import Hotel from './views/Hotel';
import HotelDetails from './views/HotelDetails'
import RoomType from './views/RoomTypes';
import RoomTypeCreate from './views/RoomTypeCreate'
import RoomTypeDetails from './views/RoomTypeDetails'
import Room from './views/Rooms';
import RoomDetails from './views/RoomDetails';
import RoomCreate from './views/RoomCreate';
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            alias: '/hotels',
            component: Hotel
        },
        {
            path: '/hotels/:id',
            name: 'hotelDetails',
            component: HotelDetails,
            props: true
        },
        {
            path: '/room-types',
            name: 'roomType',
            component: RoomType
        },
        {
            path: '/room-types/new',
            name: 'roomTypeCreate',
            component: RoomTypeCreate
        },
        {
            path: '/room-types/:id',
            name: 'roomTypeDetails',
            component: RoomTypeDetails,
            props: true
        },
        {
            path: '/rooms',
            name: 'room',
            component: Room
        },
        {
            path: '/rooms/new',
            name: 'roomCreate',
            component: RoomCreate
        },
        {
            path: '/rooms/:id',
            name: 'roomDetails',
            component: RoomDetails
        }
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

// ensure file input name is updated
$(document).on('change', '.custom-file-input', function(){
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').html(fileName);
});
// Menu Toggle
$(".menu-toggle").on('click', function(e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    $('.wrapper').toggleClass("toggled");
    $('.expand-toggler').toggleClass('hidden');
});
