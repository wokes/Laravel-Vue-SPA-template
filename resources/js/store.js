import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        authStatus: '',
        token: localStorage.getItem('token') || '',
        user: {}
    },
    mutations: {
        authInProgress(state) {
            state.authStatus    = 'loading';
        },
        loggedIn(state) {
            state.authStatus    = 'success';
        },
        authError(state) {
            state.authStatus    = 'error';
        },
        loggedOut(state) {
            state.authStatus    = '';
            state.token         = '';
            state.user          = {};
        },
        storedUser(state, user) {
            state.user          = user;
        },
        storedToken(state, token) {
            state.token         = token;
        },
    },
    actions: {
        /**
         * Store token
         */
        storeToken({ commit }, token) {
            localStorage.setItem('token', token);
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

            commit('storedToken', token);
        },
        /**
         * Store user model
         */
        storeUser({ commit }, user) {
            commit('storedUser', user);
        },
        /**
         * Remove token from local storage and remove Authorization header
         */
        forgetToken() {
            localStorage.removeItem('token');
            delete axios.defaults.headers.common['Authorization'];
        },
        async login({ commit, dispatch }, credentials) {
            commit('authInProgress');
            let r;

            /**
             * Send a request to log in user with given credentials
             */
            try {
                r = await axios({
                    method: 'POST',
                    url: '/api/auth/login',
                    data: credentials
                });
            } catch (error) {
                commit('authError', error);
                dispatch('forgetToken');
                return;
            }

            /**
             * Store the token and user model
             */
            dispatch('storeToken', r.data.token);
            dispatch('storeUser', r.data.user);
            commit('loggedIn');
        },
        async register({ commit, dispatch }, credentials) {
            commit('authInProgress');
            let r;

            /**
             * Send a request to register user with given credentials
             */
            try {
                r = await axios({
                    method: 'POST',
                    url: '/api/auth/register',
                    data: credentials
                })
            } catch (error) {
                commit('authError', error);
                dispatch('forgetToken');
                return;
            }

            /**
             * Store the token and user model
             */
            dispatch('storeToken', r.data.token);
            dispatch('storeUser', r.data.user);
            commit('loggedIn');
        },
        async getUser({ commit, dispatch }) {
            /**
             * Restore token from localStorage and set the header
             */
            dispatch('storeToken', localStorage.getItem('token'));

            let r;

            /**
             * Send a request to get currently logged in user
             */
            try {
                r = await axios({
                    method: 'GET',
                    url: '/api/user',
                })
            } catch (error) {
                commit('authError', error);
                dispatch('forgetToken');
                return;
            }

            /**
             * Store the user model
             */
            commit('storedUser', r.data);
        },
        logout({ commit, dispatch }) {
            dispatch('forgetToken');
            commit('loggedOut');
        }
    },
    getters: {
        isLoggedIn: state => !!state.token,
        authStatus: state => state.authStatus,
    }
})