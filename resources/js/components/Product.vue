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
                        <span class="btn btn-sm btn-info float-right" data-toggle="modal" data-target="#productModal">Add Product</span>
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
                                    <tr v-for="product in products">
                                        <td>1</td>
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
                                                    <button class="dropdown-item" type="button">Edit</button>
                                                    <button class="dropdown-item" type="button">View</button>
                                                    <button class="dropdown-item" type="button">Delete</button>
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

        <div class="modal fade bd-example-modal-lg" id="productModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="productStore()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="title" class="col-form-label">Product Title</label>
                                <input type="text" v-model="product.title" class="form-control" id="title">
                                <span v-if="errors.title" class="text-danger">
                                    <small>{{ errors.title[0] }}</small>
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="price" class="col-form-label">Product Price</label>
                                <input type="number" v-model="product.price" min="0" step="0.05" max="99999" class="form-control" id="price">
                                <span v-if="errors.price" class="text-danger">
                                    <small>{{ errors.price[0] }}</small>
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="description" class="col-form-label">Product Description</label>
                                <textarea class="form-control" v-model="product.description" id="description"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="image" class="col-form-label">Product Image</label>
                                <input type="file" accept="image/*" class="form-control" id="image">
                                <span v-if="errors.image" class="text-danger">
                                    <small>{{ errors.image[0] }}</small>
                                </span>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">
                                <span v-if="loader === true" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Send message
                            </button>
                        </div>
                    </form>
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
                product: {
                    title: '',
                    price: '',
                    description: '',
                },
                errors: [],
                products: []
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

            productStore () {
                this.loader = true;

                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                };

                let postData = new FormData ();

                let image = document.getElementById("image").files[0];
                if (image !== undefined){
                    if(image.type === 'image/jpeg' || image.type === 'image/png' || image.type === 'image/webp' || image.type === 'image/gif'){
                        this.product.image = image;
                        postData.append('image', image);
                    }else {
                        alert('This file is not an image')
                    }
                }
                postData.append('title', this.product.title);
                postData.append('price', this.product.price);
                postData.append('description', this.product.description);

                axios.post(this.Api.auth.product, postData, { headers: this.$globalHelper.authHeader(), config })
                    .then((response) => response.data)
                    .then((response) => {
                        if (response.status === true) {
                            this.loader = false;
                            this.message = response.message;
                            this.product.title = this.product.price = this.product.description = '';
                            $('#productModal').modal('hide');
                            this.getProduct();
                        } else {
                            this.loader = false;
                            this.errors = response.errors;
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }


    }
</script>

