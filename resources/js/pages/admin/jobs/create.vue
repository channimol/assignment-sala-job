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
                        <label class="text-capitalize font-weight-bold">Title</label>
                        <v-text-field
                            v-model="title"
                            :error-messages="titleErrors"
                            placeholder="Enter Job Title"
                            required
                            outlined
                        ></v-text-field>
                        <label class="text-capitalize font-weight-bold">Description</label>
                        <v-textarea outlined name="input-7-4" v-model="description"></v-textarea>
                        <label class="text-capitalize font-weight-bold">Requirement</label>
                        <ckeditor
                            :editor="editor"
                            :config="editorConfig"
                            v-model="requirement"
                            @input="onEditorInput"
                        ></ckeditor>
                        <v-row>
                            <v-col>
                                <label class="text-capitalize font-weight-bold">Contact Email</label>
                                <v-text-field
                                    v-model="email"
                                    placeholder="Enter Contact Email"
                                    type="email"
                                    required
                                    outlined
                                ></v-text-field>
                            </v-col>
                            <v-col>
                                <label class="text-capitalize font-weight-bold">Contact Number</label>
                                <v-text-field
                                    v-model="phone"
                                    placeholder="Enter Contact Phone"
                                    required
                                    outlined
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="3">
                                <label class="text-capitalize font-weight-bold">Source</label>
                                <v-select
                                    v-model="source"
                                    :items="sourceTypes"
                                    item-text="name"
                                    item-value="id"
                                    required
                                    outlined
                                ></v-select>
                            </v-col>
                            <v-col cols="3">
                                <label class="text-capitalize font-weight-bold">Department</label>
                                <v-select
                                    v-model="department"
                                    :items="departments"
                                    item-text="name"
                                    item-value="id"
                                    required
                                    outlined
                                ></v-select>
                            </v-col>
                            <v-col cols="3">
                                <label class="text-capitalize font-weight-bold">Schedule Types</label>
                                <v-select
                                    v-model="schedule"
                                    :items="scheduleTypes"
                                    item-text="name"
                                    item-value="id"
                                    required
                                    outlined
                                ></v-select>
                            </v-col>
                            <v-col cols="3">
                                <label class="text-capitalize font-weight-bold">Salary</label>
                                <v-text-field outlined v-model="salary" type="number" prefix="$"></v-text-field>
                            </v-col>
                        </v-row>
                        <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions"></vue-dropzone>

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
    minLength,
    maxLength,
    email
} from "vuelidate/lib/validators";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

export default {
    mixins: [validationMixin],
    validations: {
        title: { required, minLength: minLength(5), maxLength: maxLength(150) },
        email: { required, email }
    },
    data: () => ({
        title: "",
        email: "",
        phone: "",
        description: "",
        source: null,
        sourceTypes: [{ id: 1, name: "Internal" }, { id: 2, name: "External" }],
        department: null,
        departments: [
            // { id: 1, name: "Full Time" },
            // { id: 2, name: "Part Time" },
            // { id: 3, name: "Internship" }
        ],
        schedule: null,
        scheduleTypes: [
            { id: 1, name: "Full Time" },
            { id: 2, name: "Part Time" },
            { id: 3, name: "Internship" }
        ],
        salary: null,
        editor: ClassicEditor,
        requirement: "",
        editorConfig: {
            readOnly: true,
            toolbar: [
                "heading",
                "|",
                "bold",
                "italic",
                "link",
                "bulletedList",
                "numberedList",
                "blockQuote"
            ]
        },
        dropzoneOptions: {
            url: "https://httpbin.org/post",
            thumbnailWidth: 150,
            maxFilesize: 2.1,
            addRemoveLinks: true,
            uploadMultiple: true,
            acceptedFiles: ".jpg,.jpeg,.png",
            dictDefaultMessage:
                "Drop image file here, or click to select a file to upload."
        }
    }),

    computed: {
        titleErrors() {
            const errors = [];
            if (!this.$v.title.$dirty) return errors;
            !this.$v.title.minLength &&
                errors.push("Title must be at least 5 characters long");
            !this.$v.title.required && errors.push("Title is required.");
            return errors;
        }
    },
    mounted() {
        this.getDepartments();
    },
    methods: {
        async getDepartments() {
            const departments = await axios.get("/api/departments");
            this.departments = departments.data;
        },
        async submit() {
            this.$v.$touch();
            let user = this.$cookies.get("user");
            this.convertValueType();
            let formData = new FormData();
            for (
                let i = 0;
                i < this.$refs.myVueDropzone.dropzone.files.length;
                i++
            ) {
                formData.append(
                    "photos[]",
                    this.$refs.myVueDropzone.dropzone.files[i],
                    this.$refs.myVueDropzone.dropzone.files[i].name
                );
            }
            formData.append("title", this.title);
            formData.append("description", this.description);
            formData.append("requirement", this.requirement);
            formData.append("salary", this.salary);
            formData.append("job_source_id", this.source);
            formData.append("schedule_type_id", this.schedule);
            formData.append("department_id", this.department);
            formData.append("published_by", user.id);
            formData.append("contact_email", this.email);
            formData.append("contact_number", this.phone);
            const store = await axios.post("/api/admin/jobs/create", formData);
            console.log("store result", store);
        },
        convertValueType() {
            this.salary = this.salary ? parseInt(this.salary) : null;
            this.job_source_id = this.job_source_id
                ? parseInt(this.job_source_id)
                : null;
            this.schedule_type_id = this.schedule_type_id
                ? parseInt(this.schedule_type_id)
                : null;
            this.department_id = this.department_id
                ? parseInt(this.department_id)
                : null;
            this.department_id = this.department_id
                ? parseInt(this.department_id)
                : null;
        },
        onEditorInput(event) {
            console.log("ONE EDITORRR INOTU ==", event);
        }
    }
};
</script>

<style lang="scss">
.ck-editor__editable {
    min-height: 300px;
}
</style>