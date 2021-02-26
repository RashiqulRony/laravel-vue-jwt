<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div v-if="message" class="alert alert-success">
                    {{ message }}
                </div>

                <div class="card">
                    <div class="card-header">Register</div>

                    <div class="card-body">
                        <form ref="form" @submit.prevent="register()">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" v-model="user.name" name="name" >
                                    <span v-if="errors.name" class="text-danger">
                                         <small>{{ errors.name[0] }}</small>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" v-model="user.email" name="email">
                                    <span v-if="errors.email" class="text-danger">
                                         <small>{{ errors.email[0] }}</small>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="user.password" name="password">
                                    <span v-if="errors.password" class="text-danger">
                                         <small>{{ errors.password[0] }}</small>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" v-model="user.password_confirmation" name="password_confirmation">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <span v-if="loader === true" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Register
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
                user: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                },
                loader: false,
                errors: [],
                message: '',
            };
        },
        mounted() {
            if (this.$globalHelper.authToken() !== null) {
                this.$router.push("/products");
            }
        },

        methods: {
            register() {
                this.loader = true;
                axios.post(this.Api.auth.register, this.user)
                    .then((response) => response.data)
                    .then((response) => {
                        if (response.status === true) {
                            this.loader = false;
                            this.message = response.message;
                            this.user.name = this.user.email = this.user.password = this.user.password_confirmation = '';
                        } else {
                            this.loader = false;
                            this.errors = response.errors;
                        }
                    })
                    .catch((error) => {
                        console.log(error);

                    });
            },
        },
    }
</script>


