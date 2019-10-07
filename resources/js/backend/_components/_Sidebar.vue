<template>
    <sidebar :menu="items"/>
</template>

<script>
import Sidebar from './../../components/SidebarMenu'

export default {
    components: {
        Sidebar
    },
    data () {
        return {
            items: [
                { icon: 'post_add', text: 'Job Post', name: 'admin-list-jobs' },
                {
                    icon: 'folder',
                    'icon-append-up': 'keyboard_arrow_up',
                    'icon-append-down': 'keyboard_arrow_down',
                    text: 'Management',
                    model: false,
                    children: [
                        { icon: 'archive', text: 'Students', name: 'admin-list-students' },
                        { icon: 'supervised_user_circle', text: 'Users', name: 'admin-list-users' },
                    ],
                },
                {
                    icon: 'settings',
                    'icon-append-up': 'keyboard_arrow_up',
                    'icon-append-down': 'keyboard_arrow_down',
                    text: 'Settings',
                    model: false,
                    children: [
                        { icon: 'perm_identity', text: 'Account', name: 'admin-account' },
                        { icon: 'exit_to_app', text: 'Logout', name: 'admin-logout' },
                    ],
                }
            ],
        }
    }
}
</script>

<style lang="scss" scoped>

</style>