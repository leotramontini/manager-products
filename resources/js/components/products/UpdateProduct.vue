<template>
    <div>
        <br>
        <div class="form-group row">
            <label for="productName" class="col-sm-2 col-form-label">Nome do produto</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" required v-model="productName" id="productName">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputActualFile" class="col-sm-2 col-form-label">Imagem atual produto</label>
            <div class="col-sm-10">
                <img style="max-width: 100px" id="inputActualFile" class="img-thumbnail" v-bind:src="selectedProduct['image_path']">
            </div>
        </div>

        <div class="form-group row">
            <label for="productStatus" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
                <select id="productStatus" class="custom-select">
                    <option v-for="productStatus in productStatuses" v-bind:selected="isSelected(productStatus['alias'])" v-bind:value="productStatus['id']">{{productStatus['name']}}</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputFile" class="col-sm-2 col-form-label">Imagem do produto</label>
            <div class="col-sm-10">
                <input type="file" id="inputFile" @change="getImageFile" required class="form-control-file">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary" :disabled="disableButton" v-on:click="updateProduct">Atualizar</button>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        name: "UpdateProduct",

        data() {
            return {
                productName: '',
                productImage: null,
                productStatuses: {},
                disableButton: false
            }
        },

        methods: {
            ...mapActions([
                'changeProducts'
            ]),

            setProductName() {
                this.productName = this.selectedProduct['name']
            },

            updateProduct() {
                let formData = new FormData();

                if (this.productName == '' && this.productImage == null) {
                    return;
                }

                formData.append('status_id', $('#productStatus').val());

                if (this.productName !== '') {
                    formData.append('name', this.productName);
                }

                if (this.productImage !== null) {
                    formData.append('image', this.productImage);
                }

                Vue.http.post('/api/product/{productId}', formData, {
                    headers: {
                        'Authorization': 'Bearer ' + this.userToken
                    },
                    params: {
                        'productId': this.selectedProduct['id']
                    }
                }).then(
                    (response) => {
                        this.$router.go(-1);
                    }
                )
            },

            isSelected(productAlias) {
                console.log(this.selectedProduct['status']);
                return this.selectedProduct['status']['alias'] === productAlias;
            },

            getStatuses() {
                Vue.http.get('/api/status/all', {
                    headers: {
                        'Authorization': 'Bearer ' + this.userToken
                    }
                }).then(
                    (response) => {
                        this.productStatuses = response.data.data;
                    }
                )
            },

            getImageFile(event) {
                this.productImage = event.target.files[0];
            }
        },


        computed: {
            ...mapGetters([
                'products',
                'userToken',
                'selectedProduct'
            ])
        },

        mounted() {
            this.setProductName();
            this.getStatuses();
        }

    }
</script>

<style scoped>

</style>
