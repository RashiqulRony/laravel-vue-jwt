import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

import Home            from '../components/Home'
import Login           from '../components/auth/Login'
import Register        from '../components/auth/Register'
import Header          from '../components/Header';

import Product         from '../components/product/Index'
import ProductCreate   from '../components/product/Create'
import ProductEdit     from '../components/product/Edit'

export default new Router({
    mode: 'history',
    routes: [
        {
            path: "/",
            name: "Home",
            components: {
                'default': Home,
                'header': Header,
            },
        },
        {
            path: "/login",
            name: "Login",
            components: {
                'default': Login,
                'header': Header,
            },
        },
        {
            path: "/register",
            name: "Register",
            components: {
                'default': Register,
                'header': Header,
            },
        },
        {
            path: "/products",
            name: "Product",
            components: {
                'default': Product,
                'header': Header,
            },
        },
        {
            path: "/product/create",
            name: "ProductCreate",
            components: {
                'default': ProductCreate,
                'header': Header,
            },
        },
        {
            path: "/product/edit/:id",
            name: "ProductEdit",
            components: {
                'default': ProductEdit,
                'header': Header,
            },
        },


    ],
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
    }
});
