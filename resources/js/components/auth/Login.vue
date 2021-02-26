<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div v-if="message" class="alert alert-danger">
                    {{ message }}
                </div>
                <div class="card">
                    <div class="card-header">Login</div>

                    <div class="card-body">
                        <form @submit.prevent="login()">
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" v-model="email" class="form-control" name="email" value="" required autocomplete="email" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" v-model="password" class="form-control" name="password" required autocomplete="current-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <span v-if="loader === true" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Login
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                email: '',
                password: '',
                message: '',
                loader: false,
            };
        },
        mounted() {
            if (this.$globalHelper.authToken() !== null) {
                this.$router.push("/products");
            }
        },

        methods: {
            login() {
                this.loader = true;
                let data = {
                    email: this.email,
                    password: this.password,
                };

                axios.post(this.Api.auth.login, data).then((response) => response.data)
                    .then((response) => {
                        if (response.status === true) {
                            let authData = {
                                userId: response.user.id,
                                name: response.user.name,
                                email: response.user.email,
                                accessToken: response.token,
                                token_type: response.token_type,
                            };
                            localStorage.setItem("user", JSON.stringify(authData));
                            this.$router.push("/products");
                            this.loader = false;
                        } else {
                            this.loader = false;
                            this.message = "Invalid email or password";
                        }
                    })
                    .catch((error) => {
                        this.loading = false;
                        console.log(error);
                        this.message = "Invalid email or password";
                    });
            },

        },
    }
</script>


