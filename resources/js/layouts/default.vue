<template>
    <v-app>
        <v-navigation-drawer
            v-model="drawer"
            app
            clipped>
            <admin-sidebar></admin-sidebar>
        </v-navigation-drawer>

        <v-app-bar
            app
            clipped-left
            >
            <!-- <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon> -->
            <v-toolbar-title>SALA JOB</v-toolbar-title>
        </v-app-bar>

        <v-content>
            <!-- <v-container
                class="fill-height"
                fluid
            > -->
                <router-view/>
            <!-- </v-container> -->
        </v-content>

        <v-footer app>
        <span>&copy; 2019</span>
        </v-footer>
    </v-app>
</template>

<script>
import AdminSidebar from './../backend/_components/_Sidebar'
export default {
    props: {
      source: String,
    },
    components: {
        AdminSidebar
    },
    data: () => ({
      drawer: null,
    }),
    created () {
    //   this.$vuetify.theme.dark = true
    },
}
</script>