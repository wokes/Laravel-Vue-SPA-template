<template>
    <div>
        <h1>Register</h1>

        <form class="login" @submit.prevent="submitRegister">
            <label>Key</label>
            <input v-model="form.id" type="text" required/>

            <br>

            <label>Name</label>
            <input v-model="form.name" type="text" required/>

            <br>

            <label>Email</label>
            <input v-model="form.email" type="email" required/>

            <br>

            <label>Password</label>
            <input v-model="form.password" type="password" required/>

            <br>

            <button type="submit">Register</button>
        </form>
    </div>
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        data() {
            return {
                form: {
                    id:         '',
                    name :      '',
                    email:      '',
                    password :  '',
                }
            }
        },
        methods: {
            ...mapActions(['register']),

            async submitRegister() {
                await this.register(this.form);

                this.$router.push('/');
            }
        }
    }
</script>