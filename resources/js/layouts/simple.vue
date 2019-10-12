<template>
    <v-app>
        <v-content class="primary">
            <router-view></router-view>
        </v-content>
    </v-app>
</template>

<script>
export default {
    data: () => ({
        user: null
    }),
    methods: {
        redirectPage() {
            this.$cookies.get("");
        }
    }
};
</script>

<style lang="scss" scoped>
</style>