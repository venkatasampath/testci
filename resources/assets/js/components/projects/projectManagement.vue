<template>
    <div class="m-2">
        <!-- Add the Content Header Crud component for Bread crumb trail, heading and Create New (crud buttons)-->
        <contentheader :trail="this.trail" :title="this.heading" :crud_action="action" model_name="projects" @eventNew="eventNewGo"></contentheader>
        <!-- Add the standard alert component-->
        <v-alert v-if="alert" class="my-1" border="left" colored-border type="info" elevation="2" dismissible>{{alertText}}</v-alert>
        <!-- Add the Crud component for Create/Read-View/Update/Delete-->
        <project-crud></project-crud>
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
            <template v-slot:item.name="{ item }"><a href="#" @click="editItem(item)"> {{ item.name }}</a></template>
            <template v-slot:item.status="{ item }">{{ item.status.display_name }}</template>
            <template v-slot:item.manager="{ item }">
                <v-list-item class="m-0 p-0">
                    <v-list-item-avatar class="m-0 p-0"><v-img :src="item.manager.avatar" class="m-0 p-0" style="max-height: 32px; max-width: 32px;"/></v-list-item-avatar>
                    <v-list-item-content class="m-0 p-0">{{ item.manager.display_name }}</v-list-item-content>
                </v-list-item>
            </template>
            <template v-slot:item.public="{ item }" ><v-icon right :color="getIconColor(item.public)"> {{ getBooleanIcon(item.public) }}</v-icon></template>
            <template v-slot:item.zones_autocomplete="{ item }" ><v-icon right :color="getIconColor(item.zones_autocomplete)"> {{ getBooleanIcon(item.zones_autocomplete) }}</v-icon></template>
            <template v-slot:item.allow_users_accession_create="{ item }" ><v-icon right :color="getIconColor(item.allow_users_accession_create)"> {{ getBooleanIcon(item.allow_users_accession_create) }}</v-icon></template>
            <template v-slot:item.uses_auto_increment_designator="{ item }" ><v-icon right :color="getIconColor(item.uses_auto_increment_designator)"> {{ getBooleanIcon(item.uses_auto_increment_designator) }}</v-icon></template>
            <template v-slot:item.uses_isotope_analysis="{ item }" ><v-icon right :color="getIconColor(item.uses_isotope_analysis)"> {{ getBooleanIcon(item.uses_isotope_analysis) }}</v-icon></template>
            <template v-slot:item.action="{ item }">
                <v-icon v-if="(item.org_id && item.org_id === theOrg.id)" color="primary" class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
            </template>
        </v-data-table>
    </div>
</template>

<script>
    import {mapState, mapGetters, mapActions} from 'vuex';
    import {eventBus} from "../../eventBus";
    import axios from "axios";

    export default {
        name: "projectManagement.vue",
        props: {
            heading: { type: String, default: "Project Management" },
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
                    { text: 'Projects', disabled: true, href: '/projects', },
                ],
                headers: [
                    {text: 'Name', align: 'left', sortable: false, value: 'name',  width: '6rem', visibility: true},
                    {text: 'Description', value: 'description',  width: '8rem', visibility: true},
                    {text: 'Manager', value: 'manager',  width: '8rem', visibility: true},
                    {text: 'Status', value: 'status',  width: '4rem', visibility: true},
                    {text: 'Start Date', value: 'start_date',  width: '4rem', visibility: true},
                    {text: 'Latest MCC Date', value: 'latest_mcc_date',  width: '4rem', visibility: true},
                    {text: 'Public', value: 'public',  width: '3rem', visibility: true},
                    {text: 'Auto Complete Zones', value: 'zones_autocomplete',  width: '3rem', visibility: true},
                    {text: 'Accession Create', value: 'allow_users_accession_create',  width: '3rem', visibility: true},
                    {text: 'Auto Increment Designator', value: 'uses_auto_increment_designator',  width: '3rem', visibility: true},
                    {text: 'Isotope Analysis', value: 'uses_isotope_analysis',  width: '3rem', visibility: true},
                    {text: 'Created By', value: 'created_by',  width: '5rem', visibility: false},
                    {text: 'Created At', value: 'created_at',  width: '5rem', visibility: false},
                    {text: 'Updated By', value: 'updated_by',  width: '5rem', visibility: false},
                    {text: 'Updated At', value: 'updated_at',  width: '5rem', visibility: false},
                    {text: 'Actions', value: 'action',  width: '3rem', visibility: true}
                ],
            };
        },
        created(){
            eventBus.$on('refresh-list', payload => {
                if ((payload.list) && (payload.list === "Projects" || payload.list === "projects")) {
                    this.fetchProjects();
                }
            });
            this.fetchProjects();
        },
        watch: {
            //
        },
        methods: {
            fetchProjects() {
                this.loading = true;
                axios
                    .request({ url: '/api/projects', method: 'GET',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        this.items=response.data.data;
                        this.loading = false;
                    })
            },
            eventNewGo(val) {
                if (val === "projects" || val === "project") {
                    let payload = { 'title': 'Create New Project', 'action': 'Create', };
                    eventBus.$emit('show-crud-dialog', payload);
                }
            },
            editItem(item) {
                let payload = { 'title': 'Edit Project', 'action': 'Edit', 'item': item };
                eventBus.$emit('show-crud-dialog', payload);
            },
            getBooleanIcon(item) {
                return item === true ? "✔" : "";
            },
            getIconColor(item) {
                return item === true ? "success" : "";
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