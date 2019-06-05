import Vue from 'vue';
import Axios from 'axios';

import App from './App.vue';

import router from './router';
import store from './store';

/**
 * Auth Header
 */
Vue.prototype.$http = Axios;

const token = localStorage.getItem('user-token');

if (token)
    Vue.prototype.$http.defaults.headers.common['Authorization'] = token;

/**
 * CSRF Token header
 */
let csrfToken = document.head.querySelector('meta[name="csrf-token"]');

if (csrfToken)
    Vue.prototype.$http.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.content;

else
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')