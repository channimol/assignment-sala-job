import AdminPrimaryLayout from '@/js/layouts/default'

import AdminJobPost from '@/js/pages/admin/jobs/list'
import AdminJobPostCreate from '@/js/pages/admin/jobs/create'
import AdminJobPostEdit from '@/js/pages/admin/jobs/edit'
import AdminJobPostView from '@/js/pages/admin/jobs/show'

import AdminUserList from '@/js/pages/admin/users/list'
import AdminUserCreate from '@/js/pages/admin/users/create'
import AdminUserEdit from '@/js/pages/admin/users/edit'
import AdminUserView from '@/js/pages/admin/users/show'

import AdminAccount from '@/js/pages/admin/account/index'

export const AdminRoutes = {
    path: '/admin',
    component: AdminPrimaryLayout,
    redirect: '/admin/jobs',
    children: [
        { name: 'admin-list-jobs', path: 'jobs', component: AdminJobPost },
        { name: 'admin-create-job', path: 'jobs/create', component: AdminJobPostCreate },
        { name: 'admin-edit-job', path: 'jobs/:id/edit', component: AdminJobPostEdit },
        { name: 'admin-view-job', path: 'jobs/:id', component: AdminJobPostView },
        // { name: 'admin-list-students', path: 'jobs', component: AdminJobPost },
        { name: 'admin-list-users', path: 'users', component: AdminUserList },
        { name: 'admin-create-user', path: 'users/create', component: AdminUserCreate },
        { name: 'admin-edit-user', path: 'users/:id/edit', component: AdminUserEdit },
        { name: 'admin-view-user', path: 'users/:id', component: AdminUserView },

        { name: 'admin-account', path: 'account', component: AdminAccount },
    ],
    meta: {
        requireAdmin: true
    }

}


