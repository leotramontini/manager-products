<template>
    <div id="app">
        <ul>
            <li>
                <router-link v-if="loggedIn" to="/logout">Log out</router-link>
                <router-link v-if="!loggedIn" to="/login">Log in</router-link>
            </li>
        </ul>
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
        created () {
            auth.onChange = loggedIn => {
                this.loggedIn = loggedIn
            }
        }
    }
</script>
