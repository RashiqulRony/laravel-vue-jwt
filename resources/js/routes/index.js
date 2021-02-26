import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

import Home      from '../components/Home'
import Product   from '../components/Product'
import Login     from '../components/auth/Login'
import Register  from '../components/auth/Register'
import Header    from '../components/Header';

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
        /*{
            path: "/:username",
            name: "Timeline",
            components: {
                'default': Timeline,
                'profile': Profile,
            },
        },*/


    ],
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
    }
});
