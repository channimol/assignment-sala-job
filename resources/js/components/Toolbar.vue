<template>
    <v-toolbar-items>
        <div v-for="(item, key) in  toolbars" :key="key">
            <v-menu offset-y v-if="item.children">
                <template v-slot:activator="{ on }">
                    <v-btn v-on="on" color="primary" depressed>
                        <v-icon>{{item.icon}}</v-icon>
                        <v-avatar size="28" v-if="profile">
                            <img src="https://cdn.vuetifyjs.com/images/john.jpg" alt="John" />
                        </v-avatar>
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item-group>
                        <v-list-item v-for="(child, index) in item.children" :key="index">
                            <v-list-item-title
                                @click="redirectRouteName(child.nameUrl)"
                            >{{ child.text }}</v-list-item-title>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>
            </v-menu>
            <v-btn v-else text @click="$router.push({name: item.nameUrl})">{{item.text}}</v-btn>
        </div>
    </v-toolbar-items>
</template>

<script>
import auth from "./../mixins/auth";
export default {
    props: {
        toolbars: Array,
        profile: String
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