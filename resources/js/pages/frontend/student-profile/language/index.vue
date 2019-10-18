<template>
    <div>
        <v-list>
            <v-row>
                <v-subheader>Language</v-subheader>
                <v-btn icon @click="openAdd">
                    <v-icon size="small" color="primary">add</v-icon>
                </v-btn>
            </v-row>
            <template v-if="user">
                <v-list-item two-line v-for="language in user.cv.languages" :key="language.id">
                    <v-list-item-content>
                        <v-list-item-title class="headline">
                            {{language.name}}
                            <span
                                class="caption"
                                v-if="language.pivot.level"
                            >({{level[language.pivot.level]}})</span>
                        </v-list-item-title>
                    </v-list-item-content>
                    <v-btn icon @click="openEdit(skill)">
                        <v-icon size="small" color="primary">edit</v-icon>
                    </v-btn>
                </v-list-item>
            </template>
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
            item: null,
            level: {
                1: "Beginner",
                2: "Conversational",
                3: "Business",
                4: "Fluent"
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