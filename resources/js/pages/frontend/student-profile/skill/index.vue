<template>
    <div>
        <v-list>
            <v-row>
                <v-subheader>Skill</v-subheader>
                <v-btn icon @click="openAdd">
                    <v-icon size="small" color="primary">add</v-icon>
                </v-btn>
            </v-row>
            <template v-if="user">
                <v-list-item two-line v-for="skill in user.cv.skills" :key="skill.id">
                    <v-list-item-content>
                        <v-list-item-title class="headline">
                            {{skill.name}}
                            <span
                                class="caption"
                                v-if="skill.level"
                            >({{level[skill.level]}})</span>
                        </v-list-item-title>
                    </v-list-item-content>
                    <v-btn icon @click="openEdit(skill)">
                        <v-icon size="small" color="primary">edit</v-icon>
                    </v-btn>
                </v-list-item>
            </template>
        </v-list>
        <!-- <EditComponent :active="dialog" :user="user" @close="dialog=false"></EditComponent>  -->
    </div>
</template>

<script>
import dayjs from "dayjs";
// import EditComponent from "./edit";/
export default {
    props: ["user"],
    components: {
        // EditComponent
    },
    data() {
        return {
            dialog: false,
            item: null,
            level: {
                1: "Basic",
                2: "Novice",
                3: "Intermediate",
                4: "Advance",
                5: "Expert"
            }
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