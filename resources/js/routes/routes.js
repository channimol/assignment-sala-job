import Vue from 'vue'
import VueRouter from 'vue-router'

import {AdminRoutes} from './../routes/admin/index'
import {StudentRoutes} from './student/index'

Vue.use(VueRouter) 

const router = new VueRouter({
    mode: 'history',
    routes: [
        AdminRoutes,
        StudentRoutes
    ]
})

export default router