<template>
    <v-card :elevation="hover ? 12 : 2" class="mx-auto" max-width="400" outlined v-on="$listeners">
        <v-list-item three-line>
            <v-list-item-avatar tile size="80" color="grey"></v-list-item-avatar>
            <v-list-item-content>
                <v-list-item-title class="headline mb-1">{{header}}</v-list-item-title>
                <v-list-item-title class="mb-2">
                    <v-chip color="primary" small>{{chipText}}</v-chip>
                </v-list-item-title>
                <v-list-item-subtitle>{{description}}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>

        <v-card-actions class="justify-space-between">
            <div class="overline">by: {{author}}</div>
            <div>
                <slot name="action"></slot>
            </div>
        </v-card-actions>
    </v-card>
</template>

<script>
export default {
    props: {
        header: String,
        chipText: String,
        description: String,
        author: String,
        hover: Boolean
    }
};
</script>

<style lang="scss" scoped>
</style>