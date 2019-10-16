import FrontEndLayout from '@/js/layouts/primary'
import FrontEndIndex from '@/js/pages/frontend/index.vue'
import FrontEndSettings from '@/js/pages/frontend/settings.vue'
import FrontEndProfile from '@/js/pages/frontend/profile.vue'

export const StudentRoutes = {
    path: '/',
    component: FrontEndLayout,
    children: [
        { name: 'home', path: '', component: FrontEndIndex },
        { name: 'profile', path: '/profile', component: FrontEndProfile },
        { name: 'settings', path: '/settings', component: FrontEndSettings },
    ]
}