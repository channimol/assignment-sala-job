<template>
    <v-container>
        <v-card class="mx-auto">
            <v-row>
                <v-col cols="3">
                    <v-avatar>
                        <v-img v-if="user.photo" src="https://cdn.vuetifyjs.com/images/john.jpg"></v-img>
                        <!-- <v-img :src="'/images/placeholder-user.png'" width="300"></v-img> -->
                    </v-avatar>

                    <v-list>
                        <template v-for="(item, key) in sidebar">
                            <!-- <v-divider v-if="item.divider" :key="i"></v-divider> -->
                            <v-list-item :key="key" @click>
                                <!-- <v-list-item-action>
                                    <v-icon>{{ item.icon }}</v-icon>
                                </v-list-item-action>-->
                                <v-list-item-title>{{ item.name }}</v-list-item-title>
                            </v-list-item>
                        </template>
                    </v-list>
                </v-col>
                <v-col cols="8">
                    <BasicInformation v-if="show==1"></BasicInformation>
                    <WorkExperience></WorkExperience>
                    <Skill></Skill>
                    <Language></Language>
                </v-col>
            </v-row>
        </v-card>
    </v-container>
</template>

<script>
import BasicInformation from "./student-profile/basic-information";
import Skill from "./student-profile/skill";
import Language from "./student-profile/language";
import WorkExperience from "./student-profile/work-experience";

export default {
    components: {
        BasicInformation,
        Skill,
        Language,
        WorkExperience
    },
    data() {
        return {
            user: null,
            sidebar: [
                { id: 1, name: "Basic Information" },
                { id: 2, name: "Work Experience" },
                { id: 3, name: "Skill" },
                { id: 4, name: "Language" }
            ],
            show: 1
        };
    },
    mounted() {
        this.getUserInfo();
    },
    methods: {
        getUserInfo() {
            // const user = axios('')
        }
    }
};
</script>

<style lang="scss" scoped>
</style>