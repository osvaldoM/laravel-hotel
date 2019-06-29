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

import moment from 'moment'

Vue.use(VueRouter);
Vue.use(Toasted, {
    router: VueRouter
});

Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('YYYY/MM/DD');
    }
});

import App from './views/App'
import Hotel from './views/hotels/Hotels';
import HotelDetails from './views/hotels/HotelDetails'
import RoomType from './views/room-types/RoomTypes';
import RoomTypeCreate from './views/room-types/RoomTypeCreate'
import RoomTypeDetails from './views/room-types/RoomTypeDetails'
import Room from './views/rooms/Rooms';
import RoomDetails from './views/rooms/RoomDetails';
import RoomCreate from './views/rooms/RoomCreate';

import Booking from './views/bookings/Bookings'
import BookingDetails from './views/bookings/BookingDetails';
import BookingCreate from './views/bookings/BookingCreate'

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
        },
        {
            path: '/bookings',
            name: 'bookings',
            component: Booking
        },
        {
            path: '/bookings/new',
            name: 'bookingCreate',
            component: BookingCreate
        },
        {
            path: '/bookings/:id',
            name: 'bookingDetails',
            component: BookingDetails,
            props: true
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
    components: { App,},
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
