<template>
    <v-app>
        <v-app-bar app fixed color="primary" dark>
            <v-row class="container mx-auto" align="center">
                <v-toolbar-title @click="$router.push({name: 'home'})">SALA JOB</v-toolbar-title>

                <div class="flex-grow-1"></div>

                <toolbar-item :toolbars="getToolbarType" :profile="profile"></toolbar-item>
            </v-row>
        </v-app-bar>
        <v-content class="mt-30">
            <v-container>
                <router-view />
            </v-container>
        </v-content>
        <v-footer app>
            <span>&copy; 2019</span>
        </v-footer>
    </v-app>
</template>

<script>
import ToolbarItem from "./../components/Toolbar";
import { mapGetters } from "vuex";
export default {
    components: { ToolbarItem },
    data: () => ({
        toolbarItem: {
            student: [
                {
                    text: "Applied",
                    nameUrl: "apply"
                },
                {
                    text: "Bookmark",
                    nameUrl: "bookmark"
                },
                {
                    icon: "person",
                    children: [
                        {
                            text: "Profile",
                            nameUrl: "profile"
                        },
                        // {
                        //     text: "Settings",
                        //     nameUrl: "settings"
                        // },
                        {
                            text: "Logout",
                            nameUrl: "login"
                        }
                    ]
                }
            ],
            publisher: [
                {
                    text: "Post Job",
                    nameUrl: "login"
                },
                {
                    text: "Bookmark",
                    nameUrl: "login"
                },
                {
                    text: "Profile",
                    nameUrl: "login"
                }
            ]
        },
        role: null,
        profile: null
    }),
    computed: {
        getToolbarType() {
            // const user = this.$cookies.get("user");
            // const role = user.role[0];
            // this.role = "student";
            return this.toolbarItem[this.role];
        }
    },
    mounted() {
        this.getProfile();
    },
    methods: {
        async getProfile() {
            const profile = await axios.get("/api/student/user/profile");
            this.$store.commit("UPDATE_USER_PROFILE", profile);
            this.role = profile.data.role_list[0];
            this.profile = profile.data.media_url;
        }
    }
};
</script>

<style lang="scss" scoped>
</style>