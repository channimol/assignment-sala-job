<template>
    <v-container>
        <v-row>
            <v-col cols="3">
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
            </v-col>
            <v-col cols="9">
                <v-row class="fill-height">
                    <template v-for="(item, i) in jobs">
                        <v-col :key="i" cols="12" md="6">
                            <v-hover v-slot:default="{ hover }">
                                <job-card
                                    :hover="hover"
                                    :header="item.title"
                                    :chipText="item.schedule_type_id"
                                    :description="item.description"
                                    :author="item.published_by"
                                >
                                    <div slot="action" class>
                                        <v-btn color="primary" text>bookmark</v-btn>
                                        <v-btn color="primary" text>apply</v-btn>
                                    </div>
                                </job-card>
                            </v-hover>
                        </v-col>
                    </template>
                </v-row>
            </v-col>
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
        jobs: []
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
                        this.jobs = joblists.data;
                    })
                );
        }
        // async getDepartments() {
        //     const departments = await axios.get("/api/departments");
        //     this.departments = departments.data.data;
        // },
        // async getJobsList() {
        //     const list = await axios.get("/api/students/jobs/list");
        //     this.jobs = list.data.data;
        // }
    }
};
</script>

<style lang="scss" scoped>
</style>