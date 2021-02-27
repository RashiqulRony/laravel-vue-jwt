<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <router-link class="navbar-brand" :to="{name: 'Home'}">
                CRUD Application
            </router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto" v-if="authUser !== null">
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{name: 'Product'}">Products</router-link>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <template v-if="authUser === null">
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{name: 'Login'}">Login</router-link>
                        </li>

                        <li class="nav-item">
                            <router-link class="nav-link" :to="{name: 'Register'}">Register</router-link>
                        </li>
                    </template>
                    <template v-else>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ authUser.name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#" @click="logout()">
                                    Logout
                                </a>
                            </div>
                        </li>
                    </template>

                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        data () {
            return {
                authUser: null,
            }
        },

        mounted() {
            this.checkAuth();
        },

        methods : {
            checkAuth(){
                if (this.$globalHelper.authToken() !== null){
                    this.authUser = this.$globalHelper.authUser();
                } else {
                    this.authUser = null;
                }
            },

            logout () {
                axios.post(this.Api.auth.logout, null, { headers: this.$globalHelper.authHeader() }).then(response => response.data)
                    .then(response => {
                        if (response.status === true) {
                            localStorage.removeItem('user');
                            this.checkAuth();
                            this.$router.push('/');
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
        }

    }
</script>


