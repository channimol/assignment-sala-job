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
            ],
        }
        // {
        //     path: '*',
        //     name: '404',
        //     component: () =>
        //         import('./../pages/404')
        // }
    ]
})


router.beforeEach((to, from, next) => {
    const user = window.$cookies.get('user')
    const adminRoute = to.matched.some(record => record.meta.requireAdmin)

    if (user) {
        const isStudent = user.roles.includes("student")
        const isAdmin = user.roles.includes("admin")
        const isPublisher = user.roles.includes("publisher")
        if (isAdmin && (to.name == 'login' || !adminRoute)) {
            next('/admin')
        } else if ((isStudent || isPublisher) && (to.name == 'login' || adminRoute)) {
            next({ name: 'home' })
        } else {
            next()
        }
    } else {
        if (to.name !== 'login') {
            next({ name: 'login' })
        } else {
            next()
        }
    }
})


export default router