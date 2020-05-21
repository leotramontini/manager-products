<template>
    <div id="app">
        <router-link v-if="!loggedIn" to="/login">Log in</router-link>
        <div class="d-flex justify-content-end">
            <router-link v-if="loggedIn" to="/logout">Log out</router-link>
        </div>
        <template v-if="$route.matched.length">
            <router-view></router-view>
        </template>
    </div>
</template>

<script>
    import auth from '../auth'
    export default {
        data () {
            return {
                loggedIn: auth.loggedIn()
            }
        },
        mounted() {
            if (auth.loggedIn()) {
                this.$router.replace('/dashboard');
            }
        },
        created () {
            auth.onChange = loggedIn => {
                this.loggedIn = loggedIn
            }
        },
    }
</script>
