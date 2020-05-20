<template>
    <div>
        <br>
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
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDeleteProduct" v-on:click="selectedProduct(index)">Excluir</button>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="modal" id="modalDeleteProduct" tabindex="-1" role="dialog" aria-labelledby="Excluir produto" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Excluir produto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Deja realmente excluir o produto?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-danger" v-on:click="deleteProduct()">Salvar mudanças</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';

    export default {
        name: "ListProducts",
        data() {
            return {
                indexProductSelected: ''
            }
        },

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
                    }
                )
            },

            deleteProduct() {

                let product = this.products[this.indexProductSelected];

                Vue.http.delete('/api/product/{productId}', {
                    headers: {
                        'Authorization': 'Bearer ' + this.userToken
                    },
                    params: {
                        productId: product['id']
                    }
                }).then(
                    (response) => {
                        this.products.splice(this.indexProductSelected, 1);
                        $("#modalDeleteProduct").modal('hide')
                    },
                );
            },

            selectedProduct(indexProduct) {
                this.indexProductSelected = indexProduct;
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
