<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div v-if="message" class="alert alert-danger">
                    {{ message }}
                </div>
                <div class="card">
                    <div class="card-header">
                        Products
                        <span class="btn btn-sm btn-info float-right" data-toggle="modal" data-target=".bd-example-modal-lg">Add Product</span>
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
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <img src="https://st2.depositphotos.com/1000847/7167/i/600/depositphotos_71671117-stock-photo-bluetooth-headphones.jpg" width="40">
                                    </td>
                                    <td>Test Product</td>
                                    <td>$500.00</td>
                                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus consequatur debitis, eius iste itaque iure quae quaerat ullam?</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu21" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenu21">
                                                <button class="dropdown-item" type="button">Action</button>
                                                <button class="dropdown-item" type="button">Another action</button>
                                                <button class="dropdown-item" type="button">Something else here</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>2</td>
                                    <td>
                                        <img src="https://st2.depositphotos.com/1000847/7167/i/600/depositphotos_71671117-stock-photo-bluetooth-headphones.jpg" width="40">
                                    </td>
                                    <td>Test Product</td>
                                    <td>$500.00</td>
                                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus consequatur debitis, eius iste itaque iure quae quaerat ullam?</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu22" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenu22">
                                                <button class="dropdown-item" type="button">Action</button>
                                                <button class="dropdown-item" type="button">Another action</button>
                                                <button class="dropdown-item" type="button">Something else here</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>3</td>
                                    <td>
                                        <img src="https://st2.depositphotos.com/1000847/7167/i/600/depositphotos_71671117-stock-photo-bluetooth-headphones.jpg" width="40">
                                    </td>
                                    <td>Test Product</td>
                                    <td>$500.00</td>
                                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus consequatur debitis, eius iste itaque iure quae quaerat ullam?</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu23" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenu23">
                                                <button class="dropdown-item" type="button">Action</button>
                                                <button class="dropdown-item" type="button">Another action</button>
                                                <button class="dropdown-item" type="button">Something else here</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="title" class="col-form-label">Product Title</label>
                                <input type="text" class="form-control" id="title">
                            </div>

                            <div class="form-group">
                                <label for="price" class="col-form-label">Product Price</label>
                                <input type="number" min="0" step="0.05" max="99999" class="form-control" id="price">
                            </div>

                            <div class="form-group">
                                <label for="description" class="col-form-label">Product Description</label>
                                <textarea class="form-control" id="description"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="image" class="col-form-label">Product Image</label>
                                <input type="file" accept="image/*" class="form-control" id="image">
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Send message</button>
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
            };
        },

        mounted() {
            if (this.$globalHelper.authToken() === null) {
                this.$router.push("/login");
            }
        },

        methods: {

        }


    }
</script>

