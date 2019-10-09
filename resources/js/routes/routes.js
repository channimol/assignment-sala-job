import Vue from 'vue'
import VueRouter from 'vue-router'

import { AdminRoutes } from './../routes/admin/index'
import { StudentRoutes } from './student/index'
import SimpleLayout from './../layouts/simple'
import LoginPage from './../pages/login'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: [
        AdminRoutes,
        StudentRoutes,
        {
            path: '/login',
            component: SimpleLayout,
            children: [
                {
                    path: '',
                    name: 'login',
                    component: LoginPage,
                },
            ]
        },
        // {
        //     path: '*',
        //     name: '404',
        //     component: () =>
        //         import('./../pages/404')
        // }
    ]
})



export default router