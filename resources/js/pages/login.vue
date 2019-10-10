<template>
    <v-container class="fill-height">
        <v-col align="center" justify="center">
            <h2 class="white--text">Welcome to SALA JOB</h2>
            <v-card class="py-8 mt-5" max-width="500">
                <form class="px-8 mb-8">
                    <v-text-field
                        v-model="email"
                        :error-messages="emailErrors"
                        label="E-mail"
                        required
                        @input="$v.email.$touch()"
                        @blur="$v.email.$touch()"
                    ></v-text-field>
                    <v-text-field
                        v-model="password"
                        :error-messages="passwordErrors"
                        label="Password"
                        type="password"
                        required
                        @input="$v.password.$touch()"
                        @blur="$v.password.$touch()"
                    ></v-text-field>

                    <v-btn class="primary float-right" @click="submit">submit</v-btn>
                </form>
            </v-card>
        </v-col>
        <v-snackbar v-model="snackbar">
            Invalid Email or Password
            <v-btn color="pink" text @click="snackbar = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required, email } from "vuelidate/lib/validators";

export default {
    mixins: [validationMixin],

    validations: {
        password: { required },
        email: { required, email }
    },

    data: () => ({
        password: "",
        email: "",
        snackbar: false
    }),

    computed: {
        passwordErrors() {
            const errors = [];
            if (!this.$v.password.$dirty) return errors;
            !this.$v.password.required && errors.push("Password is required.");
            return errors;
        },
        emailErrors() {
            const errors = [];
            if (!this.$v.email.$dirty) return errors;
            !this.$v.email.email && errors.push("Must be valid e-mail");
            !this.$v.email.required && errors.push("E-mail is required");
            return errors;
        }
    },
    methods: {
        submit() {
            this.$v.$touch();
            if (this.$v.$invalid) return;
            const data = {
                grant_type: "password",
                client_secret: "1HBtMckK19B8Fvkic9ANSWIUbwjICySXYixY0ArP",
                client_id: 2,
                username: this.email,
                password: this.password
            };
            axios
                .post("oauth/token", data)
                .then(res => {
                    this.$cookies.set("token", res.data.access_token);
                    this.getUserInfo();
                })
                .catch(error => {
                    this.snackbar = true;
                });
        },
        async getUserInfo() {
            await axios.get("api/user").then(res => {
                const roles = res.data.role_list;
                if (roles.includes("admin")) {
                    this.$router.push("/admin");
                }
            });
        },
        clear() {
            this.$v.$reset();
            this.name = "";
            this.email = "";
            this.select = null;
            this.checkbox = false;
        }
    }
};
</script>

<style lang="scss" scoped>
</style>