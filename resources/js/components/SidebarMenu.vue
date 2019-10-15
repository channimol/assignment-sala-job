<template>
    <v-list>
        <template v-for="item in menu">
            <v-list-group
                :key="item.text"
                v-if="item.children"
                :prepend-icon="item.icon"
                :append-icon="item.model ? item['icon-append-up'] : item['icon-append-down']"
                no-action
            >
                <template v-slot:activator>
                    <v-list-item-content>
                        <v-list-item-title v-text="item.text"></v-list-item-title>
                    </v-list-item-content>
                </template>

                <v-list-item
                    v-for="subItem in item.children"
                    :key="subItem.text"
                    @click="redirectRouteName(subItem.nameUrl)"
                >
                    <v-list-item-title
                        v-text="subItem.text"
                        :class="{
                    'primary--text': $route.name == subItem.nameUrl
                }"
                    ></v-list-item-title>
                    <v-list-item-icon>
                        <v-icon
                            v-text="subItem.icon"
                            color="primary"
                            v-if="$route.name == subItem.nameUrl"
                        ></v-icon>
                        <v-icon v-else v-text="subItem.icon"></v-icon>
                    </v-list-item-icon>
                </v-list-item>
            </v-list-group>
        </template>
    </v-list>
    <!-- <v-list dense>
        <template v-for="item in menu">
            <v-list-group
                v-if="item.children"
                :key="item.text"
                v-model="item.model"
                :prepend-icon="item.icon"
                :append-icon="item.model ? item['icon-append-up'] : item['icon-append-down']"
            >
                <template v-slot:activator>
                    <v-list-item>
                        <v-list-item-content>
                            <v-list-item-title>{{ item.text }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </template>
                <v-list-item
                    v-ripple
                    style="cursor: pointer"
                    v-for="(child, i) in item.children"
                    :key="i"
                    @click.native="redirectRouteName(child.nameUrl)"
                >
                    <v-list-item-action v-if="child.icon">
                        <v-icon>{{ child.icon }}</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>{{ child.text }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list-group>
            <v-list-item
                v-else
                v-ripple
                style="cursor: pointer"
                :key="item.text"
                @click="redirectRouteName(item.nameUrl)"
            >
                <v-list-item-action>
                    <v-icon>{{ item.icon }}</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title>{{ item.text }}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </template>
    </v-list>-->
</template>

<script>
import auth from "./../mixins/auth";

export default {
    props: {
        menu: {
            type: Array,
            default: () => []
        }
    },
    mixins: [auth],
    data() {
        return {
            admins: [
                ["Management", "people_outline"],
                ["Settings", "settings"]
            ],
            cruds: [
                ["Create", "add"],
                ["Read", "insert_drive_file"],
                ["Update", "update"],
                ["Delete", "delete"]
            ]
        };
    },
    methods: {}
};
</script>

<style lang="scss" scoped>
</style>