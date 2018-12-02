require('./app/bootstrap');

// Load Vue based dependencies
import Vue from 'vue';
import Vuetify from 'vuetify';

// Register Vue based dependencies
Vue.use(Vuetify);

// Set up Router
import Router from './app/router';

// Register Vue components
Vue.component('dashboard', require('./Dashboard.vue'));
Vue.component('rsvp', require('./Rsvp.vue'));

const app = new Vue({
    el: '#app',
    router: Router
});
