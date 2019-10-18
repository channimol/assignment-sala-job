<template>
    <v-container>
        <v-row>
            <v-col class="col-6 offset-6">
                {{query}}
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
                                            <v-card-actions v-else>
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                    color="green darken-1"
                                                    text
                                                    @click="apply(item, 'cv')"
                                                >Upload</v-btn>
                                                <v-btn
                                                    color="green darken-1"
                                                    text
                                                    @click="apply(item, 'profile')"
                                                >Profile</v-btn>
                                            </v-card-actions>
                                            <v-card-actions v-else>
                                                <v-btn
                                                    color="green darken-1"
                                                    text
                                                    @click="upload()"
                                                ></v-btn>
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
        uploadModal: false
    }),
    mounted() {
        this.requestingData();
    },
    methods: {
        requestingData() {
            axios
                .all([
                    axios.get("/api/departments"),
                    axios.get("/api/student/jobs/list")
                ])
                .then(
                    axios.spread((departments, joblists) => {
                        this.departments = departments.data;
                        this.jobs = joblists.data.data;
                        this.totalPage = joblists.data.last_page;
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

        apply(job, choice) {
            const data = {
                job_id: job.id,
                apply_with: choice
            };
            if (choice == "cv") {
                this.uploadModal = true;
            }
            // axios.post(`api/student/jobs/apply`, data);
        },
        handleFile(event) {
            console.log("file uplaod", event);
            // axios.post(a)
        },
        upload() {}
    }
};
</script>

<style lang="scss" scoped>
</style>