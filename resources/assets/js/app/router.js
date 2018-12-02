// Load Vue based dependencies
import Vue from 'vue';
import VueRouter from 'vue-router';

import HomeView from './../views/Home';
import GuestsView from './../views/Guests';

// Register router with Vue
Vue.use(VueRouter);

export default new VueRouter({
	routes: [
		{
			path: '/',
			name: 'Dashboard',
			component: HomeView
		},
		{
			path: '/guests',
			name: 'Guests',
			component: GuestsView
		}
	]
});
