<template>
    <div class="d-block mx-12 mt-5">
        <v-btn class="primary" @click="$router.push({name: 'admin-create-user'})">
            <v-icon>add</v-icon>Create New User
        </v-btn>
        <v-card class="d-block mt-3" outlined>
            <!-- <DataTable title="List Jobs" :header="headers" :list="jobs" v-if="jobs"></DataTable> -->
            <v-card>
                <v-card-title>
                    {{title}}
                    <div class="flex-grow-1"></div>
                    <v-text-field
                        v-model="search"
                        append-icon="search"
                        label="Search"
                        single-line
                        hide-details
                    ></v-text-field>
                </v-card-title>
                <v-data-table :headers="headers" :items="list" :search="search">
                    <template v-slot:item.role="{ item }">
                        <template v-for="(role, key) in item.role_list">
                            <span :key="key">
                                {{role}}
                                <br />
                            </span>
                        </template>
                    </template>
                    <template
                        v-slot:item.department="{ item }"
                    >{{item.department? item.department.name:''}}</template>
                    <template v-slot:item.actions="{ item }">
                        <v-btn
                            class="info"
                            @click="$router.push({name: 'admin-view-user', params: {id: item.id}})"
                        >
                            <v-icon>visibility</v-icon>
                        </v-btn>
                        <v-btn
                            class="primary"
                            @click="$router.push({name: 'admin-edit-user', params: {id: item.id}})"
                        >
                            <v-icon>edit</v-icon>
                        </v-btn>
                        <v-btn class="error" @click="remove(item)">
                            <v-icon>delete</v-icon>
                        </v-btn>
                    </template>
                </v-data-table>
            </v-card>
        </v-card>
    </div>
</template>

<script>
import DataTable from "./../../../components/DataTable";

export default {
    components: {
        DataTable
    },
    data() {
        return {
            search: "",
            title: "List Users",
            headers: [
                {
                    text: "First Name",
                    align: "left",
                    value: "first_name"
                },
                {
                    text: "Last Name",
                    align: "left",
                    value: "last_name"
                },
                { text: "Email Address", value: "email" },
                { text: "Role", value: "role" },
                { text: "Department", value: "department" },
                { text: "Created at", value: "created_at" },
                { text: "Actions", value: "actions" }
            ],
            list: []
        };
    },
    mounted() {
        this.getListUsers();
    },
    methods: {
        remove(item) {
            const removeIndex = this.list.indexOf(item);
            axios.post(`api/admin/users/delete/${item.id}`).then(res => {
                this.list.splice(removeIndex, 1);
            });
        },
        getListUsers() {
            axios.get("api/admin/users/list").then(res => {
                console.log("getJobList", res);
                this.list = res.data;
            });
        }
    }
};
</script>

<style lang="scss" scoped>
</style>