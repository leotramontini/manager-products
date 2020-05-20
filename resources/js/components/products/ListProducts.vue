<template>
    <table class="table">
        <thead>
        <tr>
            <th scope="col"></th>
            <th scope="col">Nome do produto</th>
            <th scope="col">Status do produto</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="product in this.products">
            <td><img v-bind:src="product['image_path']"></td>
            <th>{{product['name']}}</th>
            <td>{{product['status']['name']}}</td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';

    export default {
        name: "ListProducts",
        methods: {
            ...mapActions([
                'changeProducts'
            ]),

            getProducts() {
                Vue.http.get('/api/product', {
                    headers: {
                        'Authorization': 'Bearer ' + this.userToken
                    }
                }).then(
                    (response) => {
                        this.changeProducts(response.data.data);
                    },

                    (response) => {
                        console.log(response);
                    }
                )
            }

        },

        computed: {
            ...mapGetters([
                'userToken',
                'products'
            ])
        },

        mounted() {
            this.getProducts(this.productName);
        }
    }
</script>
