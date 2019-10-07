import FrontEndLayout from '@/js/layouts/primary'
import FrontEndIndex from '@/js/frontend/pages/index.vue'

export const StudentRoutes = {
    path: '/home',
    component: FrontEndLayout,
    children: [
        { path: '/', component:  FrontEndIndex},
    ]
}