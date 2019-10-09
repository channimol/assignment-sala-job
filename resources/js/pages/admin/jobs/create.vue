<template>
    <div class="d-block mx-12 mt-5">
        <v-btn class="primary" @click="$router.go(-1)">
            <v-icon>keyboard_backspace</v-icon>Back
        </v-btn>
        <v-card class="d-block mt-3" outlined>
            <v-card>
                <v-card-title>
                    Create New Job Post
                    <div class="flex-grow-1"></div>
                </v-card-title>
                <v-card-text>
                    <form>
                        <v-text-field
                            v-model="title"
                            :error-messages="firstNameErrors"
                            label="Title"
                            required
                            @input="$v.title.$touch()"
                            @blur="$v.title.$touch()"
                        ></v-text-field>
                        <v-text-field
                            v-model="last_name"
                            :error-messages="lastNameErrors"
                            label="Last Name"
                            required
                            @input="$v.last_name.$touch()"
                            @blur="$v.last_name.$touch()"
                        ></v-text-field>
                        <v-text-field
                            v-model="email"
                            :error-messages="emailErrors"
                            label="E-mail"
                            required
                            @input="$v.email.$touch()"
                            @blur="$v.email.$touch()"
                        ></v-text-field>
                        <v-select
                            v-model="gender_id"
                            :items="genders"
                            item-text="name"
                            item-value="id"
                            label="Item"
                            persistent-hint
                            return-object
                            single-line
                            :error-messages="selectErrors"
                            required
                            @change="$v.select.$touch()"
                            @blur="$v.select.$touch()"
                        ></v-select>
                        <v-checkbox
                            v-model="checkbox"
                            :error-messages="checkboxErrors"
                            label="Do you agree?"
                            required
                            @change="$v.checkbox.$touch()"
                            @blur="$v.checkbox.$touch()"
                        ></v-checkbox>

                        <v-btn class="mr-4 primary" @click="submit">submit</v-btn>
                        <v-btn class="error" @click="clear">clear</v-btn>
                    </form>
                </v-card-text>
            </v-card>
        </v-card>
    </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required, minLength, email } from "vuelidate/lib/validators";

export default {
    mixins: [validationMixin],

    validations: {
        first_name: { required, minLength: minLength(2) },
        last_name: { required, minLength: minLength(2) },
        email: { required, email },
        select: { required },
        checkbox: {
            checked(val) {
                return val;
            }
        }
    },

    data: () => ({
        first_name: "",
        last_name: "",
        email: "",
        select: null,
        genders: [{ id: 1, name: "Male" }, { id: 2, name: "Female" }],
        gender_id: "",
        checkbox: false
    }),

    computed: {
        titleErrors() {
            const errors = [];
            if (!this.$v.first_name.$dirty) return errors;
            !this.$v.first_name.maxLength &&
                errors.push("First must be at most 10 characters long");
            !this.$v.first_name.required &&
                errors.push("First Name is required.");
            return errors;
        }
    },

    methods: {
        submit() {
            this.$v.$touch();
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