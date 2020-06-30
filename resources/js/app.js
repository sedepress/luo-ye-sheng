/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.axios = require('axios');
window.VueRouter = require('vue-router').default;

Vue.use(VueRouter)

import Shop from "./components/Shop";
import MyProp from "./components/MyProp";
import UserProfile from "./components/UserProfile";
import App from "./App.vue";

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('my-app', require('./App.vue').default);

const routes = [
    { path: '/shop', component: Shop },
    { path: '/user/prop', component: MyProp },
    { path: '/user', component: UserProfile }
];

const router = new VueRouter({
    routes
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    router,
    render: h => h(App),
    data: {
        token: ''
    },
    created() {
        this.token = this.getQueryString('token');
    },
    methods: {
        getQueryString(name) {
            var reg = new RegExp("(^|&)"+name+"=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            if(r != null){
                return decodeURI(r[2]);
            }
            return '';
        }
    }
}).$mount('#app');
