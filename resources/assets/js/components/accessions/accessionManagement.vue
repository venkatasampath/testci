<template>
    <div class="m-2">
        <!-- Add the Content Header Crud component for Bread crumb trail, heading and Create New (crud buttons)-->
        <contentheader :trail="this.trail" :title="this.heading" :crud_action="action" model_name="accessions" @eventNew="eventNewGo"></contentheader>
        <!-- Add the standard alert component-->
        <v-alert v-if="alert" class="my-1" border="left" colored-border type="info" elevation="2" dismissible>{{alertText}}</v-alert>
        <!-- Add the Crud component for Create/Read-View/Update/Delete-->
        <accession-crud></accession-crud>
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
                      calculate-widths="" class="elevation-1" multi-sort :search="search" :loading="loading"
                      :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }">
            <template v-slot:item.project_id="{ item }">{{ getProjectNameById(item.project_id) }}</template>
            <template v-slot:item.key="{ item }">{{ getKey(item) }}</template>
            <template v-slot:item.action="{ item }">
                <v-icon v-if="(item.org_id && item.org_id === theOrg.id)" color="primary" class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
                <v-icon v-if="(item.org_id && item.org_id === theOrg.id)" color="error" @click="deleteItem(item)">mdi-delete</v-icon>
            </template>
        </v-data-table>
    </div>
</template>

<script>
    import {mapState, mapGetters, mapActions} from 'vuex';
    import {eventBus} from "../../eventBus";
    import axios from "axios";


    export default {
        name: "accessionManagement",
        props: {
            heading: { type: String, default: "Accession Management" },
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
                    { text: 'Accessions', disabled: true, href: '/accessions', },
                ],
                headers: [
                    {text: 'Projects', align: 'left', sortable: false, value: 'project_id', width: '6rem', visibility: true},
                    {text: 'Key', value: 'key', width: '6rem', visibility: true},
                    {text: 'Number', value: 'number', width: '6rem', visibility: true},
                    {text: 'Provenance 1', value: 'provenance1', width: '6rem', visibility: true},
                    {text: 'Provenance 2', value: 'provenance2', width: '6rem', visibility: true},
                    {text: 'Created By', value: 'created_by', width: '6rem', visibility: false},
                    {text: 'Created At', value: 'created_at', width: '6rem', visibility: false},
                    {text: 'Updated By', value: 'updated_by', width: '6rem', visibility: false},
                    {text: 'Updated At', value: 'updated_at', width: '6rem', visibility: false},
                    {text: 'Action', value: 'action', sortable: false, width: '3rem', visibility: true},
                ],
            };
        },
        created(){
            eventBus.$on('refresh-list', payload => {
                if ((payload.list) && (payload.list === "Accessions" || payload.list === "accessions")) {
                    this.fetchAccessions();
                }
            });
            this.fetchAccessions();
        },
        watch: {
            //
        },
        methods: {
            fetchAccessions() {
                this.loading = true;
                axios
                    .request({ url: '/api/accessions', method: 'GET',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        this.items=response.data.data;
                        this.loading = false;
                    })
            },
            eventNewGo(val) {
                if (val === "accessions" || val === "accession") {
                    let payload = { 'title': 'Create New Accession', 'action': 'Create', };
                    eventBus.$emit('show-crud-dialog', payload);
                }
            },
            editItem(item) {
                let payload = { 'title': 'Edit Accession', 'action': 'Edit', 'item': item };
                eventBus.$emit('show-crud-dialog', payload);
            },
            deleteItem(item) {
                let payload = { 'title': 'Delete Accession', 'action': 'Delete', 'item': item };
                eventBus.$emit('show-crud-dialog', payload);
            },
            getKey(item) {
                return item.number + ":" + item.provenance1 + ":" + item.provenance2;
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