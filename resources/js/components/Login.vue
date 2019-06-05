<template>
    <div>
        <h1>Sign in</h1>

        <form class="login" @submit.prevent="submitLogin">
            <label>Name</label>
            <input required v-model="form.name" type="text"/>

            <br>

            <label>Password</label>
            <input required v-model="form.password" type="password"/>

            <br>

            <button type="submit">Login</button>
        </form>
    </div>
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        data(){
            return {
                form: {
                    name :      '',
                    password :  '',
                }
            }
        },
        methods: {
            ...mapActions(['login']),

            async submitLogin() {
                await this.login(this.form);

                this.$router.push('/');
            }
        }
    }
</script>