<template>
    <div class="container">
        <ul class="nav">
            <li class="nav-item">
                <router-link class="nav-link active" to="/list-products">Listagem de produtos</router-link>
            </li>
        </ul>
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
