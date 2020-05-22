<template>
    <div class="container">
        <br>
        <div class="d-flex justify-content-between">
            <router-link class="btn btn-primary" to="/list-products">Listagem de produtos</router-link>
            <router-link class="btn btn-secondary" to="/logout">Log out</router-link>
        </div>
        <router-view></router-view>
    </div>
</template>

<script>
    import auth from '../auth';
    import {mapActions, mapGetters} from 'vuex';
    export default {
        name: "Dashboard",

        methods: {
            ...mapActions([
                "changeUserToken"
            ]),

            setUserToken() {
                this.changeUserToken(auth.getToken());
            },
        },

        mounted() {
            this.setUserToken();
        }
    }
</script>
