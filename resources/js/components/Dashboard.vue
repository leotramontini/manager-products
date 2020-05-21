<template>
    <div class="container">
        <router-link to="/list-products">Listagem de produtos</router-link>
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
