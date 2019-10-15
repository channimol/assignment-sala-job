<template>
    <div class="d-block mx-12 mt-5">
        <v-btn class="primary" @click="$router.go(-1)">
            <v-icon>keyboard_backspace</v-icon>Back
        </v-btn>
        <v-card class="d-block mt-3" outlined>
            <v-card v-if="job">
                <v-card-title>
                    <v-list-item three-line>
                        <!-- <v-list-item-avatar tile size="80" color="grey"></v-list-item-avatar> -->
                        <v-list-item-content>
                            <v-list-item-title class="headline mb-1">{{job.title}}</v-list-item-title>
                            <v-list-item-title class="mb-2" v-if="job.schedule_type_id">
                                <v-chip color="primary" small>{{job.schedule_type_id}}</v-chip>
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-card-title>
                <v-card-text class="px-8">
                    <label class="text-capitalize font-weight-bold">Salary</label>
                    <div>{{job.salary || 'Negotiable'}}</div>
                    <v-row>
                        <v-col>
                            <label class="text-capitalize font-weight-bold">Description</label>
                            <p>{{job.description || 'No Information'}}</p>
                        </v-col>
                        <v-col>
                            <label class="text-capitalize font-weight-bold">Requirement</label>
                            <p v-html="job.requirement || '<p>No information</p>'"></p>
                        </v-col>
                    </v-row>

                    <v-row>
                        <template v-for="item in job.medias">
                            <v-col :key="item.id" cols="3" md="4" sm="6">
                                <v-img
                                    :src="item.url"
                                    class="white--text align-end"
                                    height="200px"
                                    aspect-ratio="1.7"
                                    contain
                                    @click="viewFile(item.url)"
                                ></v-img>
                            </v-col>
                        </template>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-card>
    </div>
</template>

<script>
export default {
    data: () => ({
        job: null
    }),
    mounted() {
        this.getJobDetail();
    },
    methods: {
        async getJobDetail() {
            const jobId = this.$route.params.id;
            const job = await axios.get(`/api/admin/jobs/${jobId}`);
            this.job = job.data;
        },
        viewFile(url) {
            window.open(url, "_blank");
        }
    }
};
</script>

<style lang="scss">
</style>