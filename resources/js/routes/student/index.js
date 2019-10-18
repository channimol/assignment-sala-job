import FrontEndLayout from '@/js/layouts/primary'
import FrontEndIndex from '@/js/pages/frontend/index.vue'
import FrontEndSettings from '@/js/pages/frontend/settings.vue'
import FrontEndProfile from '@/js/pages/frontend/profile.vue'
import FrontEndApplyJob from '@/js/pages/frontend/apply.vue'
import FrontEndBookmarkJob from '@/js/pages/frontend/bookmark.vue'

export const StudentRoutes = {
    path: '/',
    component: FrontEndLayout,
    children: [
        { name: 'home', path: '', component: FrontEndIndex },
        { name: 'profile', path: '/profile', component: FrontEndProfile },
        { name: 'settings', path: '/settings', component: FrontEndSettings },

        { name: 'bookmark', path: '/bookmark', component: FrontEndBookmarkJob },
        { name: 'apply', path: '/apply', component: FrontEndApplyJob },
    ]
}