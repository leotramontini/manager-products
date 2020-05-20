<template>
    <div>
        <div class="container">
            <div v-if="error" class="alert alert-danger" role="alert">
                Email ou senha inválidos.
            </div>
            <form @submit.prevent="login">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" v-model="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Senha</label>
                    <input type="password" v-model="password" class="form-control" id="exampleInputPassword1">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</template>

<script>
    import auth from '../auth'

    export default {
        data () {
            return {
                email: '',
                password: '',
                error: false
            }
        },
        methods: {
            login () {
                auth.login(this.email, this.password, loggedIn => {
                    if (!loggedIn) {
                        this.error = true;
                        setTimeout(() => {
                            this.error = false;
                        },3000);
                    } else {
                        this.$router.replace(this.$route.query.redirect || '/dashboard')
                    }
                })
            },
            checkLogin() {
                if (auth.loggedIn()) {
                    this.$router.replace('/dashboard');
                }
            }
        },
        mounted: function () {
            this.checkLogin();
        }
    }
</script>
