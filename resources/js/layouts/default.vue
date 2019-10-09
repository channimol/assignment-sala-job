<template>
    <v-app>
        <v-navigation-drawer v-model="drawer" app clipped>
            <admin-sidebar></admin-sidebar>
        </v-navigation-drawer>

        <v-app-bar app clipped-left>
            <v-toolbar-title>SALA JOB</v-toolbar-title>
        </v-app-bar>

        <v-content>
            <router-view />
        </v-content>

        <v-footer app>
            <span>&copy; 2019</span>
        </v-footer>
    </v-app>
</template>

<script>
import AdminSidebar from "./../backend/_components/_Sidebar";
export default {
    props: {
        source: String
    },
    components: {
        AdminSidebar
    },
    data: () => ({
        drawer: null
    }),
    created() {
        //   this.$vuetify.theme.dark = true
    }
};
</script>