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
            <label for="inputFile" class="col-sm-2 col-form-label">Imagem do produto</label>
            <div class="col-sm-10">
                <input type="file" id="inputFile" @change="getImageFile" required class="form-control-file">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary" :disabled="disableButton" v-on:click="addProduct">Cadastrar</button>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    export default {
        name: "CreateProduct",

        data() {
            return {
                productName: '',
                productImage: null,
                disableButton: false
            }
        },

        methods: {
            getImageFile(event) {
                this.productImage = event.target.files[0];
            },

            addProduct() {
                this.disableButton = true;

                let formData = new FormData();
                formData.append('image', this.productImage);
                formData.append('name', this.productName);

                Vue.http.post('/api/product', formData, {
                    headers: {
                        'Authorization': 'Bearer ' + this.userToken
                    }
                }).then(
                    (response) => {
                        this.products.push(response.data.data);
                        this.disableButton = false;
                        this.$router.go(-1);
                    }
                )
            },
        },

        computed: {
            ...mapGetters([
                'userToken',
                'products'
            ])
        }
    }
</script>
