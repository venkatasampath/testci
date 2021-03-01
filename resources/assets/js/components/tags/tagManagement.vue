<template>
    <div class="m-2">
        <!-- Add the Content Header Crud component for Bread crumb trail, heading and Create New (crud buttons)-->
        <contentheader :trail="this.trail" :title="this.heading" :crud_action="action" model_name="tags" @eventNew="eventNewGo"></contentheader>
        <!-- Add the standard alert component-->
        <v-alert v-if="alert" class="my-1" border="left" colored-border type="info" elevation="2" dismissible>{{alertText}}</v-alert>
        <!-- Add the Crud component for Create/Read-View/Update/Delete-->
        <tag-crud></tag-crud>
        <!-- Add the Datatable top row for managing column visibility, search and download functionality-->
        <v-row>
            <v-col cols="9">
                <v-btn-toggle v-model="toggle_multiple" dense dark multiple>
                    <v-btn>Excel</v-btn>
                    <v-menu right offset-x :close-on-content-click="false" max-height="500px">
                        <template v-slot:activator="{ on }">
                            <v-btn v-on="on">Column Visibility<v-icon right>$dropdown</v-icon></v-btn>
                        </template>

                        <v-list>
                            <v-list-item v-for="header in headers" :key="header.id">
                                <v-checkbox v-bind:label="header.text" v-model="header.visibility" :value="header.visibility"></v-checkbox>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </v-btn-toggle>
            </v-col>
            <v-spacer></v-spacer>
            <v-col cols="3">
                <v-text-field v-model="search" label="Search" single-line hide-details></v-text-field>
            </v-col>
        </v-row>
        <!-- Add the Main listing Datatable here-->
        <v-data-table :headers="columnVisibility" :items="items" :items-per-page="perPage" :options.sync="options"
                      calculate-widths="" class="elevation-1" :sort-by="['name']" multi-sort :search="search" :loading="loading"
                      :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }">
            <template v-slot:item.name="{ item }"><v-chip :color="item.color" dark label><v-icon left>{{ item.icon }}</v-icon>{{ item.name }}</v-chip></template>
            <template v-slot:item.project_id="{ item }">{{ getProjectNameById(item.project_id) }}</template>
            <template v-slot:item.action="{ item }">
                <v-icon v-if="(item.org_id && item.org_id === theOrg.id)" color="primary" class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
                <v-icon v-if="(item.org_id && item.org_id === theOrg.id)" color="error" @click="deleteItem(item)">mdi-delete</v-icon>
            </template>
            <template v-slot:item.org_id="{ item }">{{ (item.org_id === theOrg.id) ? theOrg.acronym : (item.org_id === null) ? "System" : "Other Org" }}</template>
        </v-data-table>
    </div>
</template>

<script>
    import {mapState, mapGetters, mapActions} from 'vuex';
    import {eventBus} from "../../eventBus";
    import axios from "axios";
    import TagCrud from "./tagCrud";

    export default {
        name: "tag-management",
        components: {TagCrud},
        props: {
            heading: { type: String, default: "Tag Management" },
            crud_action: { type: String, default: "List" },
        },
        data() {
            return {
                loading: false,
                alert: false,
                alertText: "",
                search: '',
                toggle_multiple: [],
                items: [],
                options: {},
                trail: [{ text: 'Home', disabled: false, href: '/', },
                    { text: 'Tags', disabled: true, href: '/tags', },
                ],
                headers: [
                    { text: 'Tag Name', align: 'left', value: 'name', visibility: true },
                    { text: 'Description', value: 'description', visibility: true },
                    { text: 'Color', value: 'color', visibility: true },
                    { text: 'Org', value: 'org_id', visibility: true },
                    { text: 'Project', value: 'project_id', visibility: true },
                    { text: 'Category', value: 'category', visibility: true },
                    { text: 'Type', value: 'type', visibility: true },
                    { text: 'Icon', value: 'icon', visibility: true },
                    { text: 'Created At', value: 'created_at', visibility: false },
                    { text: 'Updated At', value: 'updated_at', visibility: false },
                    { text: 'Actions', value: 'action', visibility: true },
                ],
            };
        },
        created(){
            eventBus.$on('refresh-list', payload => {
                if ((payload.list) && (payload.list === "Tags" || payload.list === "tags")) {
                    this.fetchTags();
                }
            });
            this.fetchTags();
        },
        watch: {
            //
        },
        methods: {
            fetchTags() {
                this.loading = true;
                axios
                    .request({ url: '/api/tags', method: 'GET',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        this.items=response.data.data;
                        this.loading = false;
                    })
            },
            eventNewGo(val) {
                console.log('Tags eventNewGo - captured event: ' + val);
                if (val === "tags" || val === "tag") {
                    let payload = { 'title': 'Create New Tag', 'action': 'Create', };
                    eventBus.$emit('show-crud-dialog', payload);
                }
            },
            editItem(item) {
                let payload = { 'title': 'Edit Tag', 'action': 'Edit', 'item': item };
                eventBus.$emit('show-crud-dialog', payload);
            },
            deleteItem(item) {
                let payload = { 'title': 'Delete Tag', 'action': 'Delete', 'item': item };
                eventBus.$emit('show-crud-dialog', payload);
            },
        },
        computed: {
            ...mapState({
                perPage: state => state.search.perPage,
                rowsPerPageItems: state => state.search.rowsPerPageItems,
            }),
            ...mapGetters({
                bearerToken: 'bearerToken',
                csrfToken: 'csrfToken',
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
                getProjectById: 'getProjectById',
                getProjectNameById: 'getProjectNameById',
            }),
            columnVisibility(){
                return this.headers.filter(item => item.visibility === true);
            },
            action() {
                const action = this.crud_action;
                return { list: action === "List", create: action === "Create", view: action === "View", edit: (action === "Update" || action === "Edit") };
            },
        },
    }
</script>

<style scoped>

</style>