/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');

import Vue          from 'vue'
import router       from './routes/index';
// import Header       from './components/Header';
import globalHelper from './globalHelper';
import Api          from './routes/api';


Vue.prototype.Api = Api;
Vue.use({
    install() {
        Vue.globalHelper = globalHelper;
        Vue.prototype.$globalHelper = globalHelper;
    }
});

const app = new Vue({
    router,
   /* components :{
        'web-header':Header,
    }*/
}).$mount('#app');
