<template>
    <v-row justify="center">
        <v-dialog v-model="active" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">Edit Basic Information</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    label="Email*"
                                    v-model="email"
                                    :error-messages="emailErrors"
                                    placeholder="Enter Email"
                                    required
                                    outlined
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    label="Email*"
                                    v-model="email"
                                    :error-messages="emailErrors"
                                    placeholder="Enter Email"
                                    required
                                    outlined
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-container>
                    <small>*indicates required field</small>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
                    <v-btn color="blue darken-1" text @click="dialog = false">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<script>
export default {
    props: ["active"],
    computed: {
        emailErrors() {
            const errors = [];
            if (!this.$v.email.$dirty) return errors;
            !this.$v.email.required && errors.push("Title is required.");
            return errors;
        }
    },
    methods: {
        close() {
            this.$emit("close");
        }
    }
};
</script>