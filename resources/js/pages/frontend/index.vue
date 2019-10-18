<template>
    <v-container>
        <v-row>
            <v-col class="col-6 offset-6">
                <v-text-field
                    solo
                    clearable
                    v-model="query"
                    label="Search"
                    append-icon="search"
                    placeholder="Search Job Title"
                    @change="search"
                ></v-text-field>
            </v-col>
        </v-row>
        <v-row>
            <!-- <v-col cols="3">
                <v-card class="mt-3 px-8 py-10">
                    <div class="filter-block">
                        <div class="filter-content">
                            <div>
                                <v-text-field
                                    outlined
                                    clearable
                                    label="Search"
                                    placeholder="Job title"
                                ></v-text-field>
                            </div>
                            <div>
                                <div>
                                    <v-select
                                        v-model="department"
                                        :items="departments"
                                        item-text="name"
                                        item-value="id"
                                        label="Department"
                                        outlined
                                    ></v-select>
                                </div>
                            </div>
                            <div>
                                Types
                                <div>
                                    <v-radio-group v-model="scheduleType" :mandatory="false">
                                        <v-radio
                                            v-for="(item, key) in scheduleTypes"
                                            :key="key"
                                            :label="item.name"
                                            :value="key"
                                            color="primary"
                                        ></v-radio>
                                    </v-radio-group>
                                </div>
                            </div>
                        </div>
                    </div>
                </v-card>
            </v-col>-->
            <v-col v-if="jobs.length > 0">
                <v-row class="fill-height">
                    <template v-for="(item, i) in jobs">
                        <v-col :key="i" cols="12" md="4" sm="6">
                            <v-hover v-slot:default="{ hover }">
                                <job-card
                                    :hover="hover"
                                    :header="item.title"
                                    :chipText="item.schedule_type_id"
                                    :description="item.description"
                                    :author="item.published_by"
                                >
                                    <div slot="action" class>
                                        <v-btn color="primary" text @click="bookmark(item)">bookmark</v-btn>
                                        <v-btn color="primary" text @click="openModal = true">apply</v-btn>
                                    </div>
                                    <v-dialog v-model="openModal" persistent max-width="290">
                                        <v-card>
                                            <v-card-title class="headline">Choose Option</v-card-title>
                                            <v-card-text>Are you going to apply using your Profile as cv or upload a cv file?</v-card-text>
                                            <div v-if="uploadModal" class="p-8">
                                                <div v-if="hasCv">
                                                    <div class="ml-10">
                                                        <a :href="hasCv" target="_blank">View CV</a>
                                                    </div>
                                                    <v-card-actions>
                                                        <v-spacer></v-spacer>
                                                        <v-btn
                                                            color="green darken-1"
                                                            text
                                                            @click="apply(item, 'cv')"
                                                        >Apply</v-btn>
                                                    </v-card-actions>
                                                </div>
                                                <div v-else>
                                                    <v-file-input
                                                        label="File input"
                                                        accept="application/pdf"
                                                        @change="handleFile"
                                                    ></v-file-input>
                                                    <v-card-actions>
                                                        <v-spacer></v-spacer>
                                                        <v-btn
                                                            color="green darken-1"
                                                            text
                                                            @click="upload()"
                                                        >Upload</v-btn>
                                                    </v-card-actions>
                                                </div>
                                            </div>
                                            <v-card-actions v-else>
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                    color="green darken-1"
                                                    text
                                                    @click="chooseOption(item, 'cv')"
                                                >CV</v-btn>
                                                <v-btn
                                                    color="green darken-1"
                                                    text
                                                    @click="chooseOption(item, 'profile')"
                                                >Profile</v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                </job-card>
                            </v-hover>
                        </v-col>
                    </template>
                </v-row>
                <v-pagination
                    v-model="page"
                    class="my-4"
                    :length="totalPage"
                    @input="search($event)"
                ></v-pagination>
            </v-col>
            <v-banner single-line v-else width="100%">No Matching Result</v-banner>
        </v-row>
    </v-container>
</template>

<script>
import JobCard from "./../../components/JobCard";
export default {
    components: { JobCard },
    data: () => ({
        department: 0,
        departments: [
            { id: 0, name: "All" },
            { id: 1, name: "GIC" },
            { id: 2, name: "GIM" },
            { id: 3, name: "GCA" },
            { id: 4, name: "GCI" }
        ],
        scheduleType: 0,
        scheduleTypes: [
            { id: 0, name: "All" },
            { id: 1, name: "Full Time" },
            { id: 2, name: "Part Time" },
            { id: 3, name: "Internship" }
        ],
        jobs: [],
        page: 1,
        totalPage: 1,
        query: "",
        openModal: false,
        uploadModal: false,
        file: null,
        hasCv: null,
        viewCv: false
    }),
    mounted() {
        this.requestingData();
    },
    methods: {
        requestingData() {
            axios
                .all([
                    axios.get("/api/departments"),
                    axios.get("/api/student/jobs/list"),
                    axios.get("/api/student/user/profile")
                ])
                .then(
                    axios.spread((departments, joblists, user) => {
                        this.departments = departments.data;
                        this.jobs = joblists.data.data;
                        this.totalPage = joblists.data.last_page;
                        this.hasCv = user.data.cv.media_url;
                    })
                );
        },
        search(page) {
            if (typeof page === "undefined") {
                page = 1;
            }

            axios
                .get(`/api/student/jobs/list?search=${this.query}&page=${page}`)
                .then(response => {
                    console.log("first then ", response);
                    this.jobs = response.data.data;
                });
        },
        bookmark(job) {
            const data = {
                job_id: job.id
            };
            const bookmark = axios.post(`api/student/jobs/bookmark`, data);
        },
        async apply(job, choice) {
            const data = {
                job_id: job.id,
                apply_with: choice
            };
            const apply = await axios.post(`api/student/jobs/apply`, data);
            if (apply.data.success) {
                this.openModal = false;
                alert("success");
            }
        },
        chooseOption(job, choice) {
            if (choice == "cv") {
                this.uploadModal = true;
                return;
            }
            this.apply(job, choice);
        },
        handleFile(event) {
            this.file = event;
        },
        async upload() {
            const formData = new FormData();
            formData.append("file", this.file);
            const upload = await axios.post(
                `api/student/user/upload-cv`,
                formData
            );
            if (upload.data.success) {
                this.hasCv = upload.data.data;
            }
        }
    }
};
</script>

<style lang="scss" scoped>
</style>