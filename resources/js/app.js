/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


import router from './routes/routes'

// import 'vuetify/dist/vuetify.min.css'
import Vuetify from 'vuetify';
import '@mdi/font/css/materialdesignicons.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
Vue.use(Vuetify);

import VueCookies from 'vue-cookies'
Vue.use(VueCookies)

import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)

const app = new Vue({
    el: '#app',
    router,
    vuetify: new Vuetify({
        iconfont: 'mdi'
    })
});
