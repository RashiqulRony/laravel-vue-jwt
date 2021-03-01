<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div v-if="message" class="alert alert-secondary">
                    {{ message }}
                </div>
                <div class="card">
                    <div class="card-header">
                        Edit Product
                        <router-link class="btn btn-sm btn-info float-right" :to="{name: 'Product'}">Back</router-link>
                    </div>

                    <div class="card-body">
                        <form @submit.prevent="updateProduct()">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="title" class="col-form-label">Product Title</label>
                                    <input type="text" v-model="product.title"  class="form-control" id="title">
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
                                    <input type="file" accept="image/*" @change="previewImage($event)" class="form-control" id="image">
                                    <span v-if="errors.image" class="text-danger">
                                    <small>{{ errors.image[0] }}</small>
                                </span>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">
                                    <span v-if="loader === true" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Update Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Product Image</div>
                    <div class="card-body" v-if="product.image">
                        <img id="previewImage" :src="'/image/'+product.image" class="img-thumbnail img-fluid">
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
                productId: '',
                product: {
                    title: '',
                    price: '',
                    description: '',
                    image: '',
                },
                errors: [],
            };
        },

        mounted() {
            if (this.$globalHelper.authToken() === null) {
                this.$router.push("/login");
            }
            this.getProduct()
        },

        methods: {


            updateProduct () {
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
                postData.append('_method', 'PUT');

                axios.post(this.Api.auth.product+"/"+this.$route.params.id, postData, { headers: this.$globalHelper.authHeader(), config })
                    .then((response) => response.data)
                    .then((response) => {
                        if (response.status === true) {
                            this.loader = false;
                            this.message = response.message;
                            document.getElementById('image').value = ""
                            this.getProduct()
                        } else {
                            this.loader = false;
                            this.errors = response.errors;
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });


            },

            getProduct() {
                axios.get(this.Api.auth.product+"/"+this.$route.params.id, { headers: this.$globalHelper.authHeader() })
                    .then((response) => response.data)
                    .then((response) => {
                        if (response.status === true) {
                            this.product.title = response.data.title;
                            this.product.price = response.data.price;
                            this.product.description = response.data.description;
                            this.product.image = response.data.image;
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },

            previewImage(event) {
                let image = document.getElementById("image").files[0];
                if (image !== undefined) {
                    if (image.type === 'image/jpeg' || image.type === 'image/png' || image.type === 'image/webp' || image.type === 'image/gif') {
                        let reader = new FileReader();
                        reader.onload = function () {
                            let output = document.getElementById('previewImage');
                            output.src = reader.result;
                            output.style.display = "block";
                            output.style.width = "100%";
                        }
                        reader.readAsDataURL(event.target.files[0]);
                    } else {
                        alert('This file is not an image')
                    }
                }
            },


        }


    }
</script>

