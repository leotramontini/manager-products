<template>
    <div>
        <p>
            <router-link class="btn btn-secondary" to="/create-product">Cadastrar produto</router-link>
        </p>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Imagem do Produto</th>
                <th scope="col">Nome do produto</th>
                <th scope="col">Status do produto</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="product in this.products">
                <td><img style="max-width: 100px" class="img-thumbnail" v-bind:src="product['image_path']"></td>
                <th>{{product['name']}}</th>
                <td>{{product['status']['name']}}</td>
            </tr>
            </tbody>
        </table>
    </div>
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
