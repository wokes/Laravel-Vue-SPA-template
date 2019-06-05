<template>
    <div id="app">
        <div id="nav">
            <router-link to="/">Home</router-link>

            <router-link v-if="isLoggedIn" to="/secure">Secure</router-link>

            <a v-if="isLoggedIn" @click="submitLogout">Logout</a>

            <router-link
                v-if="!isLoggedIn"
                to="/login"
            >Login</router-link>

            <router-link
                v-if="!isLoggedIn"
                to="/register"
            >Register</router-link>
        </div>

        <router-view/>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';

    export default {
        computed : {
            ...mapGetters(['isLoggedIn']),
        },
        methods: {
            ...mapActions(['logout', 'getUser']),

            submitLogout() {
                this.logout();

                this.$router.push('/login');
            }
        },
        mounted() {
            if (this.isLoggedIn)
                this.getUser();
        }
    }
</script>