<template>
    <div>
        <br>
        <p>
            <router-link class="btn btn-success" to="/create-product">Cadastrar produto</router-link>
        </p>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Imagem do Produto</th>
                <th scope="col">Nome do produto</th>
                <th scope="col">Status do produto</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(product, index) in this.products">
                <td><img style="max-width: 100px" class="img-thumbnail" v-bind:src="product['image_path']"></td>
                <th>{{product['name']}}</th>
                <td>{{product['status']['name']}}</td>
                <td>
                    <button class="btn btn-warning" v-on:click="updateProduct(index)">Atualizar cadastro</button>
                </td>
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
                'changeProducts',
                'changeSelectedProduct'
            ]),

            getProducts() {
                Vue.http.get('/api/product', {
                    headers: {
                        'Authorization': 'Bearer ' + this.userToken
                    }
                }).then(
                    (response) => {
                        this.changeProducts(response.data.data);
                    }
                )
            },

            updateProduct(index) {
                const product = this.products[index];
                this.changeSelectedProduct(product);
                this.$router.push("/update-product");
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
