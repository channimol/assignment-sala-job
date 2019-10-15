/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import router from './routes/routes'
import store from './stores'

// import 'vuetify/dist/vuetify.min.css'
import Vuetify from 'vuetify'
import '@mdi/font/css/materialdesignicons.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import VueCookies from 'vue-cookies'
import Vuelidate from 'vuelidate'
import CKEditor from '@ckeditor/ckeditor5-vue'
import vueDropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

Vue.use(Vuetify)
Vue.use(VueCookies)
Vue.use(Vuelidate)
Vue.use(CKEditor)
Vue.use(vueDropzone)
Vue.component('vueDropzone', vueDropzone)

const app = new Vue({
    el: '#app',
    store,
    router,
    vuetify: new Vuetify({
        iconfont: 'mdi'
    })
});
