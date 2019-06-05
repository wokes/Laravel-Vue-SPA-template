import Vue from 'vue';
import Router from 'vue-router';

import store from './store';

import Home from './components/Home.vue';
import Login from './components/Login.vue';
import Secure from './components/Secure.vue';
import Register from './components/Register.vue';

Vue.use(Router);

let router = new Router({
    mode: 'history',
    base: '/app/',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        },
        {
            path: '/secure',
            name: 'secure',
            component: Secure,
            meta: {
                requiresAuth: true
            }
        }
    ]
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters.isLoggedIn) {
            next();

            return;
        }

        next('/login');
    }

    else
        next();
});

export default router;