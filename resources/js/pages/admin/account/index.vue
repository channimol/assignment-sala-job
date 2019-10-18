<template>
    <v-container>
        <v-card class="mx-auto" max-width="600">
            <v-row v-if="user">
                <v-col cols="3" class="pl-5">
                    <!-- <v-avatar> -->
                    <v-img v-if="user.media_url" :src="user.media_url"></v-img>
                    <v-img v-else :src="'/images/placeholder-user.png'"></v-img>
                    <!-- </v-avatar> -->
                </v-col>
                <v-col cols="9">
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
                                <v-list-item-title>{{user.phone || 'No Information'}}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>

                        <v-divider inset></v-divider>

                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon color="primary">mdi-email</v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title>{{user.email}}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-col>
            </v-row>
            <EditBasicComponent v-if="dialog" @close="dialog=false"></EditBasicComponent>
        </v-card>
    </v-container>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required, email } from "vuelidate/lib/validators";
import EditBasicComponent from "./edit-basic";
export default {
    components: { EditBasicComponent },
    mixins: [validationMixin],
    data() {
        return {
            user: null,
            show: 0,
            openEditPassword: false,
            dialog: false
        };
    },
    validations: {
        user: {
            email: { required, email }
        }
    },
    computed: {
        emailErrors() {
            const errors = [];
            if (!this.$v.user.email.$dirty) return errors;
            !this.$v.user.email.required && errors.push("required.");
            return errors;
        }
    },
    mounted() {
        this.getUserInfo();
    },
    methods: {
        async getUserInfo() {
            const user = await axios("api/student/user/profile");
            this.user = user.data;
        },
        updatePassword() {}
    }
};
</script>

<style lang="scss" scoped>
</style>