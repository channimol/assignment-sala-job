<template>
    <v-container class="fill-height" fluid>
        <v-col align="center" justify="center">
            <v-card class="py-8 mt-5" max-width="800">
                <h2 class="mb-5">SALA JOB</h2>
                <v-row>
                    <v-col cols="6" class="px-5">
                        <v-img :src="'/images/people-job.png'"></v-img>
                    </v-col>
                    <v-col cols="6">
                        <form class="px-8 mb-8">
                            <v-text-field
                                class="mb-5"
                                v-model="email"
                                :error-messages="emailErrors"
                                label="E-mail"
                                placeholder="Enter Your Email Address"
                                required
                                @input="$v.email.$touch()"
                                @blur="$v.email.$touch()"
                            ></v-text-field>
                            <v-text-field
                                class="mb-5"
                                v-model="password"
                                :error-messages="passwordErrors"
                                placeholder="Enter Your Password"
                                label="Password"
                                type="password"
                                required
                                @input="$v.password.$touch()"
                                @blur="$v.password.$touch()"
                            ></v-text-field>

                            <v-btn class="primary float-right" @click="submit">Login</v-btn>
                        </form>
                    </v-col>
                </v-row>
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
                client_secret: "7jepCjaVfo8XHabXdgnVQHzg5n3zTL0mwIkZ7FoB",
                client_id: 1,
                username: this.email,
                password: this.password
            };
            axios
                .post("oauth/token", data)
                .then(async res => {
                    this.$cookies.set("token", res.data.access_token);
                    axios.defaults.headers.common["Authorization"] =
                        "Bearer " + res.data.access_token;
                    this.getUserInfo();
                })
                .catch(error => {
                    this.snackbar = true;
                });
        },
        async getUserInfo() {
            await axios.get("api/user").then(res => {
                const roles = res.data.role_list;
                const user = {
                    email: res.data.email,
                    roles: roles,
                    firstName: res.data.first_name,
                    lastName: res.data.last_name
                };
                this.$cookies.set("user", user);
                if (roles.includes("admin")) {
                    this.$router.push("/admin");
                } else {
                    this.$router.push({ name: "home" });
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