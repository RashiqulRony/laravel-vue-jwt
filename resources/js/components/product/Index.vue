<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div v-if="message" class="alert alert-secondary">
                    {{ message }}
                </div>
                <div class="card">
                    <div class="card-header">
                        Products
                        <router-link class="btn btn-sm btn-info float-right" :to="{name: 'ProductCreate'}">New Product</router-link>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="5%">Image</th>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <template v-if="products.length > 0">
                                    <tr v-for="(product, index) in products">
                                        <td>{{ index + 1 }}</td>
                                        <td>
                                            <img :src="'image/'+product.image" width="40">
                                        </td>
                                        <td>{{ product.title }}</td>
                                        <td>${{ product.price }}</td>
                                        <td><div v-html="product.description"></div></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenu21" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenu21">
                                                    <router-link class="dropdown-item" :to="{name: 'ProductEdit', params: {id: product.id}}">Edit</router-link>
                                                    <button @click="showProduct(product.id)" class="dropdown-item" type="button">View</button>
                                                    <button @click="deleteProduct(product.id)" class="dropdown-item" type="button">Delete</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="productView" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Recipient:</label>
                                <input type="text" class="form-control" id="recipient-name">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Message:</label>
                                <textarea class="form-control" id="message-text"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Send message</button>
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
                loader: false,
                message: '',
                products: [],
                productData: '',
            };
        },

        mounted() {
            if (this.$globalHelper.authToken() === null) {
                this.$router.push("/login");
            }
            this.getProduct()
        },

        methods: {

            getProduct() {
                axios.get(this.Api.auth.product,{ headers: this.$globalHelper.authHeader() })
                    .then((response) => response.data)
                    .then((response) => {
                        if (response.status === true) {
                            this.products = response.data;
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },

            showProduct(product_id) {
                axios.get(this.Api.auth.product+"/"+product_id, { headers: this.$globalHelper.authHeader() })
                    .then((response) => response.data)
                    .then((response) => {
                        if (response.status === true) {
                            this.productData = response.data;
                            $('#productView').modal("show");
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },

            deleteProduct(product_id) {
                axios.delete(this.Api.auth.product+"/"+product_id, { headers: this.$globalHelper.authHeader() })
                    .then((response) => response.data)
                    .then((response) => {
                        if (response.status === true) {
                            this.message = response.message;
                            this.getProduct();
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
        }


    }
</script>

