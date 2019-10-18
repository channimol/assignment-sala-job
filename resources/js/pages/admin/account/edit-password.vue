<template>
    <v-list>
        <v-row>
            <v-subheader>Change Password</v-subheader>
            <v-btn icon @click="openEditPassword = !openEditPassword">
                <v-icon size="small" color="primary">edit</v-icon>
            </v-btn>
        </v-row>
        <template v-if="openEditPassword">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-content>
                        <v-text-field
                            label="Email*"
                            v-model="user.currentPassword"
                            :error-messages="currentPasswordErrors"
                            placeholder="Enter Current Password"
                            required
                            outlined
                        ></v-text-field>
                    </v-list-item-content>
                </v-list-item-content>
            </v-list-item>
            <v-list-item>
                <v-list-item-content>
                    <v-text-field
                        label="New Password*"
                        v-model="user.newPassword"
                        :error-messages="newPasswordErrors"
                        placeholder="Enter New Password"
                        required
                        outlined
                    ></v-text-field>
                </v-list-item-content>
            </v-list-item>
            <v-list-item>
                <v-list-item-content>
                    <v-text-field
                        label="Confirm Password*"
                        v-model="user.confirmPassword"
                        :error-messages="confirmPasswordErrors"
                        placeholder="Enter Confirm Password"
                        required
                        outlined
                    ></v-text-field>
                </v-list-item-content>
            </v-list-item>
            <v-list-item>
                <v-row justify="end">
                    <v-btn class="mr-5" color="primary" @click="updatePassword">Update</v-btn>
                    <v-btn color="error" @click="openEditPassword = false">Cancel</v-btn>
                </v-row>
            </v-list-item>
        </template>
    </v-list>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required, email } from "vuelidate/lib/validators";
export default {
    props: ["user"],
    components: {},
    mixins: [validationMixin],
    data() {
        return {
            user: null,
            show: 0,
            openEditPassword: false
        };
    },
    validations: {
        user: {
            password: { required },
            newPassword: { required },
            confirmPassword: { required }
        }
    },
    computed: {
        confirmPasswordErrors() {
            const errors = [];
            if (!this.$v.user.confirmPassword.$dirty) return errors;
            !this.$v.user.confirmPassword.required && errors.push("required.");
            return errors;
        },
        newPasswordErrors() {
            const errors = [];
            if (!this.$v.user.email.$dirty) return errors;
            !this.$v.user.newPassword.required && errors.push("required.");
            return errors;
        },
        PasswordErrors() {
            const errors = [];
            if (!this.$v.password.email.$dirty) return errors;
            !this.$v.user.password.required && errors.push("required.");
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