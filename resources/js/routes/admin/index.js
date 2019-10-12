import AdminPrimaryLayout from '@/js/layouts/default'

import AdminJobPost from '@/js/pages/admin/jobs/list'
import AdminJobPostCreate from '@/js/pages/admin/jobs/create'

export const AdminRoutes = {
    path: '/admin',
    component: AdminPrimaryLayout,
    redirect: '/admin/jobs',
    children: [
        { name: 'admin-list-jobs', path: 'jobs', component: AdminJobPost },
        { name: 'admin-create-job', path: 'jobs/create', component: AdminJobPostCreate },
        // { name: 'admin-edit-job', path: 'jobs/edit', component: AdminJobPost },
    ],
    meta: {
        requireAdmin: true
    }

}


