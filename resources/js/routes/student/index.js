import FrontEndLayout from '@/js/layouts/primary'
import FrontEndIndex from '@/js/pages/frontend/index.vue'

export const StudentRoutes = {
    path: '/',
    component: FrontEndLayout,
    children: [
        { name: 'home', path: '', component: FrontEndIndex },
    ]
}