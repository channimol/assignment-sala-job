<template>
    <div class="d-block mx-12 mt-5">
        <v-btn class="primary" @click="$router.push({name: 'admin-create-job'})">
            <v-icon>add</v-icon>Create New Job Post
        </v-btn>
        <v-card class="d-block mt-3" outlined>
            <!-- <DataTable title="List Jobs" :header="headers" :list="jobs" v-if="jobs"></DataTable> -->
            <v-card>
                <v-card-title>
                    {{title}}
                    <div class="flex-grow-1"></div>
                    <v-text-field
                        v-model="search"
                        append-icon="search"
                        label="Search"
                        single-line
                        hide-details
                    ></v-text-field>
                </v-card-title>
                <v-data-table :headers="headers" :items="list" :search="search">
                    <template v-slot:item.actions="{ item }">
                        <v-btn class="info" @click="view(item)">
                            <v-icon>visibility</v-icon>
                        </v-btn>
                        <v-btn class="primary">
                            <v-icon>edit</v-icon>
                        </v-btn>
                        <v-btn class="error">
                            <v-icon>delete</v-icon>
                        </v-btn>
                    </template>
                </v-data-table>
            </v-card>
        </v-card>
    </div>
</template>

<script>
import DataTable from "./../../../components/DataTable";

export default {
    components: {
        DataTable
    },
    data() {
        return {
            search: "",
            title: "List Jobs",
            headers: [
                {
                    text: "Title",
                    align: "left",
                    value: "title"
                },
                { text: "Description", value: "description" },
                { text: "Job Source", value: "job_source_id" },
                { text: "Schedule type", value: "schedule_type_id" },
                { text: "Publish by", value: "published_by" },
                { text: "Actions", value: "actions" }
            ],
            list: []
        };
    },
    mounted() {
        this.getListJobs();
    },
    methods: {
        view(item) {
            console.log("item", item);
        },
        getListJobs() {
            axios.get("api/admin/jobs/list").then(res => {
                console.log("getJobList", res);
                this.list = res.data;
            });
        }
    }
};
</script>

<style lang="scss" scoped>
</style>