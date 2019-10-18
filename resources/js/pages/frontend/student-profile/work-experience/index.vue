<template>
    <div>
        <v-list>
            <v-row>
                <v-subheader>Work Experience</v-subheader>
                <v-btn icon @click="openAdd">
                    <v-icon size="small" color="primary">add</v-icon>
                </v-btn>
            </v-row>
            <template v-if="user">
                <v-list-item
                    two-line
                    v-for="experience in user.cv.work_experiences"
                    :key="experience.id"
                >
                    <v-list-item-content>
                        <v-list-item-title class="headline">{{experience.title}}</v-list-item-title>
                        <div class="title">
                            {{experience.company}}
                            <span
                                class="caption"
                                v-if="experience.start_date"
                            >({{changeDateFormat(new Date(experience.start_date), 'MMM YYYY')}}</span>
                            <span
                                class="caption"
                                v-if="experience.start_date"
                            >- {{changeDateFormat(new Date(experience.end_date), 'MMM YYYY')}})</span>
                            <span v-else>- Present)</span>
                        </div>
                        <div>{{experience.description}}</div>
                    </v-list-item-content>
                    <v-btn icon @click="openEdit(experience)">
                        <v-icon size="small" color="primary">edit</v-icon>
                    </v-btn>
                </v-list-item>
            </template>
            <v-divider></v-divider>
        </v-list>
        <EditComponent :active="dialog" :user="user" @close="dialog=false"></EditComponent>
    </div>
</template>

<script>
import dayjs from "dayjs";
import EditComponent from "./edit";
export default {
    props: ["user"],
    components: {
        EditComponent
    },
    data() {
        return {
            dialog: false,
            item: null
        };
    },
    methods: {
        changeDateFormat(data, format) {
            return dayjs(data).format(format);
        },
        openAdd() {
            this.dialog = true;
        },
        openEdit(item) {
            this.dialog = true;
            this.item = item;
        }
    }
};
</script>

<style lang="scss" scoped>
</style>