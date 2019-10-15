<template>
    <sidebar :menu="items" />
</template>

<script>
import Sidebar from "./../../components/SidebarMenu";

export default {
    components: {
        Sidebar
    },
    data() {
        return {
            items: [
                {
                    icon: "post_add",
                    text: "Jobs",
                    "icon-append-up": "keyboard_arrow_up",
                    "icon-append-down": "keyboard_arrow_down",
                    model: false,
                    children: [
                        {
                            icon: "post_add",
                            text: "Posts",
                            nameUrl: "admin-list-jobs",
                            icon: "work"
                        }
                    ]
                },
                {
                    icon: "mdi-account-multiple",
                    "icon-append-up": "keyboard_arrow_up",
                    "icon-append-down": "keyboard_arrow_down",
                    text: "Management",
                    model: false,
                    children: [
                        {
                            icon: "archive",
                            text: "Students",
                            nameUrl: "admin-list-students"
                        },
                        {
                            icon: "supervised_user_circle",
                            text: "Users",
                            nameUrl: "admin-list-users"
                        }
                    ]
                },
                {
                    icon: "settings",
                    "icon-append-up": "keyboard_arrow_up",
                    "icon-append-down": "keyboard_arrow_down",
                    text: "Settings",
                    model: false,
                    children: [
                        {
                            icon: "perm_identity",
                            text: "Account",
                            nameUrl: "admin-account"
                        },
                        {
                            icon: "exit_to_app",
                            text: "Logout",
                            nameUrl: "login"
                        }
                    ]
                }
            ]
        };
    }
};
</script>

<style lang="scss" scoped>
</style>