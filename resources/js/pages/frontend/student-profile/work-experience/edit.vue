<template>
    <v-row justify="center">
        <v-dialog v-model="active" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">Edit Basic Information</span>
                </v-card-title>
                <v-card-title>
                    <v-container v-if="user">
                        <v-row>
                            <v-col cols="12">
                                <v-date-picker v-model="picker"></v-date-picker>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    label="Phone"
                                    v-model="user.phone"
                                    placeholder="Enter Phone"
                                    outlined
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-textarea
                                    label="Address"
                                    v-model="user.address"
                                    placeholder="Enter Address"
                                    outlined
                                ></v-textarea>
                            </v-col>
                            <v-col cols="12">
                                <v-textarea
                                    label="Description"
                                    v-model="user.cv.description"
                                    placeholder="Enter Address"
                                    outlined
                                ></v-textarea>
                            </v-col>
                        </v-row>
                    </v-container>
                    <small class="red--text">Note: * indicates required field</small>
                </v-card-title>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="close">Close</v-btn>
                    <v-btn color="blue darken-1" text @click="update">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<script>
import { validationMixin } from "vuelidate";
import { required, email } from "vuelidate/lib/validators";
export default {
    props: ["active", "user"],
    mixins: [validationMixin],
    validations: {
        user: {
            email: { required, email }
        }
    },
    data() {
        return {
            picker: new Date().toISOString().substr(0, 10)
        };
    },
    computed: {
        emailErrors() {
            const errors = [];
            if (!this.$v.user.email.$dirty) return errors;
            !this.$v.user.email.required && errors.push("required.");
            return errors;
        }
    },
    methods: {
        close() {
            this.$emit("close");
        },
        async update() {
            const data = {
                email: this.user.email,
                phone: this.user.phone,
                address: this.user.address,
                description: this.user.cv.description
            };
            const update = await axios.post(
                "api/student/user/update-basic-info",
                data
            );
            if (update.data.success) {
                this.close();
            }
        }
    }
};
</script>