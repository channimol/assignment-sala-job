<template>
    <div>
        <h3>{{user.first_name}} {{user.last_name}}</h3>
        <v-list>
            <v-row>
                <v-subheader>Contact information</v-subheader>
                <v-btn icon @click="dialog = true">
                    <v-icon size="small" color="primary">edit</v-icon>
                </v-btn>
            </v-row>

            <v-list-item>
                <v-list-item-icon>
                    <v-icon color="primary">mdi-phone</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>{{user.phone}}</v-list-item-title>
                    <!-- <v-list-item-subtitle>Mobile</v-list-item-subtitle> -->
                </v-list-item-content>
            </v-list-item>

            <v-divider inset></v-divider>

            <v-list-item>
                <v-list-item-icon>
                    <v-icon color="primary">mdi-email</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>{{user.email}}</v-list-item-title>
                    <!-- <v-list-item-subtitle>Personal</v-list-item-subtitle> -->
                </v-list-item-content>
            </v-list-item>

            <v-divider inset></v-divider>

            <v-list-item>
                <v-list-item-icon>
                    <v-icon color="primary">mdi-map-marker</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>Address</v-list-item-title>
                    <v-list-item-subtitle>{{user.address}}</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
        </v-list>
        <EditComponent :active="dialog" @close="dialog=false"></EditComponent>
    </div>
</template>

<script>
import EditComponent from "./edit";
export default {
    props: ["user"],
    components: {
        EditComponent
    },
    data() {
        return {
            dialog: false
        };
    }
};
</script>

<style lang="scss" scoped>
</style>