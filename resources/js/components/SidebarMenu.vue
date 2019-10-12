<template>
    <v-list dense>
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
    </v-list>
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
        return {};
    },
    methods: {}
};
</script>

<style lang="scss" scoped>
</style>