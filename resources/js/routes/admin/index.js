import AdminPrimaryLayout from '@/js/layouts/default'
import AdminIndex from '@/js/backend/pages/index.vue'

import AdminJobPost from '@/js/backend/pages/jobs/list'
// import AdminJobPostEdit from '@/js/backend/pages/jobs/edit'

export const AdminRoutes = {
    path: '/admin',
    component: AdminPrimaryLayout,
    children: [
        { path: '/', component:  AdminIndex},
        { name: 'admin-list-jobs', path: '/list-jobs', component:  AdminJobPost},
    ]
}


