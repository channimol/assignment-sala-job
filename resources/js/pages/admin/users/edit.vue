<template>
    <div class="d-block mx-12 mt-5">
        <v-btn class="primary" @click="$router.go(-1)">
            <v-icon>keyboard_backspace</v-icon>Back
        </v-btn>
        <v-card class="d-block mt-3" outlined>
            <v-card>
                <v-card-title>
                    Edit User
                    <div class="flex-grow-1"></div>
                </v-card-title>
                <v-card-text>
                    <form>
                        <v-row>
                            <v-col cols="6">
                                <label class="text-capitalize font-weight-bold">First Name</label>
                                <v-text-field
                                    v-model="first_name"
                                    :error-messages="firstNameErrors"
                                    placeholder="First Name"
                                    required
                                    outlined
                                    @input="$v.first_name.$touch()"
                                    @blur="$v.first_name.$touch()"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <label class="text-capitalize font-weight-bold">Last Name</label>
                                <v-text-field
                                    v-model="last_name"
                                    :error-messages="lastNameErrors"
                                    placeholder="Last Name"
                                    required
                                    outlined
                                    @input="$v.last_name.$touch()"
                                    @blur="$v.last_name.$touch()"
                                ></v-text-field>
                            </v-col>
                        </v-row>

                        <v-row>
                            <v-col cols="4">
                                <label class="text-capitalize font-weight-bold">Gender</label>
                                <v-select
                                    v-model="gender"
                                    :items="genders"
                                    item-text="name"
                                    item-value="id"
                                    placeholder="gender"
                                    outlined
                                ></v-select>
                            </v-col>
                            <v-col cols="4">
                                <label class="text-capitalize font-weight-bold">Email Address</label>
                                <v-text-field
                                    v-model="email"
                                    :error-messages="emailErrors"
                                    placeholder="E-mail"
                                    required
                                    outlined
                                    @input="$v.email.$touch()"
                                    @blur="$v.email.$touch()"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="4">
                                <label class="text-capitalize font-weight-bold">Department</label>
                                <v-select
                                    v-model="department"
                                    :items="departments"
                                    item-text="name"
                                    item-value="id"
                                    placeholder="department"
                                    outlined
                                ></v-select>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <label class="text-capitalize font-weight-bold">Password</label>
                                <v-text-field
                                    v-model="password"
                                    placeholder="Password"
                                    outlined
                                    type="password"
                                    disabled
                                    style="cursor-pointer: not-allowed"
                                ></v-text-field>
                            </v-col>
                            <v-col>
                                <label class="text-capitalize font-weight-bold">Role</label>
                                <v-select
                                    v-model="role"
                                    :items="roles"
                                    item-text="name"
                                    item-value="id"
                                    placeholder="role"
                                    :error-messages="roleErrors"
                                    required
                                    outlined
                                    @change="$v.role.$touch()"
                                    @blur="$v.role.$touch()"
                                ></v-select>
                            </v-col>
                        </v-row>

                        <div class="d-flex mt-8 justify-end">
                            <v-btn class="mr-4 primary" @click="submit">submit</v-btn>
                            <v-btn class="error" @click="$router.go(-1)">cancel</v-btn>
                        </div>
                    </form>
                </v-card-text>
            </v-card>
        </v-card>
    </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import {
    required,
    maxLength,
    minLength,
    email
} from "vuelidate/lib/validators";

export default {
    mixins: [validationMixin],

    validations: {
        first_name: { required, minLength: minLength(2) },
        last_name: { required, minLength: minLength(2) },
        email: { required, email },
        role: { required }
    },

    data: () => ({
        first_name: null,
        last_name: null,
        email: null,
        password: null,
        role: null,
        roles: [
            { id: 1, name: "Admin" },
            { id: 2, name: "Publisher" },
            { id: 3, name: "Student" }
        ],
        department: null,
        departments: [],
        gender: null,
        genders: [{ id: 1, name: "Male" }, { id: 2, name: "Female" }]
    }),

    computed: {
        roleErrors() {
            const errors = [];
            if (!this.$v.role.$dirty) return errors;
            !this.$v.role.required && errors.push("Role is required");
            return errors;
        },
        firstNameErrors() {
            const errors = [];
            if (!this.$v.first_name.$dirty) return errors;
            !this.$v.first_name.minLength &&
                errors.push("First Name must be at least 2 characters");
            !this.$v.first_name.required &&
                errors.push("First Name is required.");
            return errors;
        },
        lastNameErrors() {
            const errors = [];
            if (!this.$v.last_name.$dirty) return errors;
            !this.$v.last_name.minLength &&
                errors.push("Last Name must be at least 2 characters");
            !this.$v.last_name.required &&
                errors.push("Last Name is required.");
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
    mounted() {
        this.getDepartments();
        this.getUserDetail();
    },
    methods: {
        async getDepartments() {
            const departments = await axios.get("/api/departments");
            this.departments = departments.data;
        },
        async getUserDetail() {
            const userId = this.$route.params.id;
            const user = await axios.get(`api/admin/users/${userId}`);
            console.log("user", user);
            this.first_name = user.data.first_name;
            this.last_name = user.data.last_name;
            this.email = user.data.email;
            this.password = user.data.password;
            if (user.data.role_list) {
                const role = this.roles.find(
                    item => item.name.toLowerCase() == user.data.role_list[0]
                );
                this.role = role.id;
            }
            if (user.data.gender_id) {
                const gender = this.departments.find(
                    item => item.id == user.data.gender_id
                );
                this.gender = gender.id;
            }
            if (user.data.department_id) {
                const department = this.departments.find(
                    item => item.id == user.data.department_id
                );
                this.department = department.id;
            }
        },
        async submit() {
            this.$v.$touch();
            let user = this.$cookies.get("user");
            const userId = this.$route.params.id;
            this.convertValueType();
            let data = {
                first_name: this.first_name,
                last_name: this.last_name,
                gender_id: this.gender,
                email: this.email,
                roles: this.role,
                department_id: this.department
            };
            const store = await axios.post(
                `/api/admin/users/update/${userId}`,
                data
            );
            console.log("store result", store);
        },
        convertValueType() {
            this.gender = this.gender ? parseInt(this.gender) : null;
            this.role = this.role ? parseInt(this.role) : null;
            this.department = this.department
                ? parseInt(this.department)
                : null;
        }
    }
};
</script>

<style lang="scss" scoped>
</style>