<template>
    <v-container>
        <h3>Applied List</h3>
        <v-row>
            <v-col v-if="list.length > 0">
                <v-row class="fill-height">
                    <template v-for="(item, i) in list">
                        <v-col :key="i" cols="12" md="4" sm="6">
                            <v-hover v-slot:default="{ hover }">
                                <job-card
                                    :hover="hover"
                                    :header="item.title"
                                    :chipText="item.schedule_type_id"
                                    :description="item.description"
                                    :author="item.published_by[0].email"
                                ></job-card>
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
            <v-banner single-line v-else width="100%" class="mt-10">No Result</v-banner>
        </v-row>
    </v-container>
</template>

<script>
import JobCard from "./../../components/JobCard";
export default {
    components: { JobCard },
    data: () => ({
        list: [],
        page: 1,
        totalPage: 1
    }),
    mounted() {
        this.requestingData();
    },
    methods: {
        requestingData() {
            axios.get("api/student/jobs/list-apply").then(res => {
                this.list = res.data.data;
            });
        },
        apply(job) {
            const data = {
                job_id: job.id
            };
            axios.post(`api/student/jobs/apply`, data);
        }
    }
};
</script>

<style lang="scss" scoped>
</style>