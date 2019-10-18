<template>
    <v-container>
        <v-card class="mx-auto">
            <v-row v-if="user">
                <v-col cols="3" class="pl-5">
                    <!-- <v-avatar> -->
                    <v-img v-if="user.media_url" :src="user.media_url"></v-img>
                    <v-img v-else :src="'/images/placeholder-user.png'"></v-img>
                    <!-- </v-avatar> -->
                    <v-list>
                        <v-list-item-group v-model="show">
                            <v-list-item v-for="(item, key) in sidebar" :key="key">
                                <v-list-item-title>{{ item.name }}</v-list-item-title>
                            </v-list-item>
                        </v-list-item-group>
                    </v-list>
                </v-col>
                <v-col cols="9">
                    <BasicInformation v-if="show==0" :user="user"></BasicInformation>
                    <WorkExperience v-else-if="show==1" :user="user"></WorkExperience>
                    <Skill v-else-if="show==2" :user="user"></Skill>
                    <Language v-else :user="user"></Language>
                </v-col>
            </v-row>
        </v-card>
    </v-container>
</template>

<script>
import BasicInformation from "./student-profile/basic-Infomation/index";
import Skill from "./student-profile/skill/index";
import Language from "./student-profile/language/index";
import WorkExperience from "./student-profile/work-experience/index";

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
            show: 0
        };
    },
    mounted() {
        this.getUserInfo();
    },
    methods: {
        async getUserInfo() {
            const user = await axios("api/student/user/profile");
            this.user = user.data;
        }
    }
};
</script>

<style lang="scss" scoped>
</style>