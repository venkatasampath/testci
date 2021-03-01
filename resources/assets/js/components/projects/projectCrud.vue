<template>
    <v-dialog v-model="dialog" max-width="50%">
        <v-card>
            <v-card-title class="m-0 p-0">
                <v-toolbar dense>
                    <v-btn icon><v-icon color="gray" class="p-2">mdi-skull</v-icon></v-btn>
                    <v-spacer></v-spacer>
                    <v-toolbar-title>{{title}}</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-progress-circular v-if="loading" :indeterminate="loading" color="primary"></v-progress-circular>
                    <v-btn v-if="this.action.create || this.action.edit" :title="(show_validation)?'Reset Validation':'Validate'" icon @click="toggleValidation">
                        <v-icon :color="(show_validation)?'error':''">mdi-shield-star</v-icon>
                    </v-btn>
<!--                    <v-btn v-if="this.action.create" title="Reset" icon @click="resetForm"><v-icon>mdi-undo-variant</v-icon></v-btn>-->
                    <v-btn title="Close" icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
                </v-toolbar>
            </v-card-title>
            <v-card-text>
                <v-form ref="form" v-model="isFormValid">
                    <v-row>
                        <v-col cols="6">
                            <v-text-field v-model="item.name" label="Name:" placeholder="e.g. CoRA Demo" counter="32" :rules="rules.name" :disabled="disabled"/>
                        </v-col>
                        <v-col cols="6">
                            <v-text-field v-model="item.description" label="Description:" placeholder="e.g. CoRA Demo Project"
                                          counter="128" :rules="rules.description" :disabled="disabled"/>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6">
                            <v-autocomplete v-model="item.status_id" label="Status:" :rules="rules.status" :disabled="disabled"
                                            :items="items_project_statuses" item-text="display_name" item-value="id">
                            </v-autocomplete>
                        </v-col>
                        <v-col cols="6">
                            <v-autocomplete v-model="item.manager_id" label="Manager:" :rules="rules.manager" :disabled="disabled"
                                            :items="users" item-text="display_name" item-value="id" filled chips>
                                <template v-slot:selection="data">
                                    <v-chip v-bind="data.attrs" :input-value="data.selected" @click="data.select">
                                        <v-avatar left><v-img :src="data.item.avatar"></v-img></v-avatar>{{ data.item.display_name }}
                                    </v-chip>
                                </template>
                                <template v-slot:item="data">
                                    <template v-if="typeof data.item !== 'object'"><v-list-item-content v-text="data.item"></v-list-item-content></template>
                                    <template v-else>
                                        <v-list-item-avatar><img :src="data.item.avatar"></v-list-item-avatar>
                                        <v-list-item-content><v-list-item-title v-html="data.item.display_name"></v-list-item-title></v-list-item-content>
                                    </template>
                                </template>
                            </v-autocomplete>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6"><v-text-field v-model="item.geo_lat" label="Geo Latitude:" placeholder="e.g. 41.2473820" :rules="rules.geo_location" :disabled="disabled"/></v-col>
                        <v-col cols="6"><v-text-field v-model="item.geo_long" label="Geo Longitude" placeholder="e.g. -96.0167990" :rules="rules.geo_location"  :disabled="disabled"/></v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6"><date :value="item['start_date']" label="Start Date: " type="projectStartDate" :rules="rules.start_date"></date></v-col>
                        <v-col cols="6"><v-switch v-model="item.public" label="Public" :disabled="disabled"/></v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6"><v-switch v-model="item.zones_autocomplete" label="Zones Auto Complete" :disabled="disabled"/></v-col>
                        <v-col cols="6"><v-switch v-model="item.allow_user_accession_create" label="Allow Users to Create Accessions" :disabled="disabled"/></v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6"><v-switch v-model="item.uses_auto_increment_designator" label="Uses Auto Incrementing Designator" :disabled="disabled"/></v-col>
                        <v-col cols="6"><v-switch v-model="item.uses_isotope_analysis" label="Uses Isotope Analysis" :disabled="disabled"/></v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6"><v-text-field v-model="item.slack_channel" label="Slack Channel:" placeholder="e.g. https://slack.com/projecturl" :disabled="disabled"/></v-col>
                    </v-row>
                    <v-row v-if="action.edit && item.id"><v-col cols="12"><project-users :project="item"></project-users></v-col></v-row>
                    <v-row v-if="action.edit && item.id"><v-col cols="12"><project-instruments :project="item"></project-instruments></v-col></v-row>
                </v-form>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions v-if="action.edit || action.create">
                <v-row align="center" justify="center" class="m-0 p-0">
                    <v-btn color="primary" text @click="save" :disabled="!isFormValid"><v-icon class="p-2">mdi-content-save</v-icon>Save</v-btn>
                    <v-btn color="primary" text @click="close"><v-icon class="p-2">mdi-cancel</v-icon>Cancel</v-btn>
                </v-row>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import {eventBus} from "../../eventBus";
    import axios from "axios";

    export default {
        name: "project-crud",
        props: {
            default_crud_action: "Edit",
            default_title: "Modal title",
        },
        data() {
            return {
                isFormValid: true,
                show_validation: false,
                loading: false,
                crud_action: "Edit",
                dialog: false,
                title: "Modal title",
                items: [],
                project_users: [],
                project_instruments: [],
                index: -1,
                item: { name: '', description: '', status_id: 1, public: false, start_date: '', latest_mcc_date: '', slack_channel: '',
                    zones_autocomplete: true, allow_user_accession_create: true, uses_auto_increment_designator: true, uses_isotope_analysis: false},
                defaultItem: { name: '', description: '', status_id: 1, public: false, start_date: '', latest_mcc_date: '', slack_channel: '',
                    zones_autocomplete: true, allow_user_accession_create: true, uses_auto_increment_designator: true, uses_isotope_analysis: false},
                cached_item: {},
                menu: false,
                current_date: new Date().toISOString().substr(0, 10),
                rules: {
                    name: [ v => !!v || 'Name is required', v => (v && v.length >= 3) || 'Name must be at least 3 characters',
                        v => v.length <= 32 || 'Max 32 characters'],
                    description: [ v => !!v || 'Description is required', v => (v && v.length >= 10) || 'Description must be at least 10 characters',
                        v => v.length <= 128 || 'Max 128 characters'],
                    status: [ v => !!v || 'Status is required',],
                    manager: [ v => !!v || 'Manager is required',],
                    geo_location: [ v => !!v || 'Geo location field is required',],
                    start_date: [ v => !!v || 'Start date is required',],
                    // latest_mcc_date: [ v => !!v || 'Start date is required',],
                },
            };
        },
        created() {
            this.defaultItem.project_id = this.item.project_id = this.theProject.id;
            this.item.start_date = this.defaultItem.start_date = this.current_date;
            eventBus.$on('show-crud-dialog', payload => {
                this.dialog = !this.dialog;
                this.title = (payload.title) ? payload.title : "No Modal Title";
                this.crud_action = (payload.action) ? payload.action : "Edit";
                this.item = (payload.item) ? payload.item : this.defaultItem;
                this.index = (payload.index) ? payload.index : this.index;
                this.cached_item = this.item;
                if (this.action.edit) {
                    // Get the users assigned to this project and their instruments
                    this.getProjectUsers();
                    this.getProjectInstruments();
                }
            });

            let payload = { 'type': 'users', 'list': true, 'force': true };
            this.$store.dispatch('fetchOrgList', payload).then(() => this.loading = false);
            payload = { 'type': 'instruments', 'list': true, 'force': true };
            this.$store.dispatch('fetchOrgList', payload).then(() => this.loading = false);
        },
        mounted() {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrfToken;
            this.show_validation = false;
        },
        watch: {
            dialog (val) {
                val || this.close()
            },
        },
        methods: {
            close() {
                this.title = "No Modal Title";
                this.crud_action = "Edit";
                this.item = this.cached_item;
                this.index = -1;
                this.item = this.defaultItem;
                this.project_users = [];
                this.project_instruments = [];
                this.dialog = false;
                this.show_validation = false;
                this.$refs.form.resetValidation();
            },
            save () {
                this.loading = true;
                let url = (this.action.create) ? '/api/projects' : '/api/projects/' + this.item.id;
                let method = (this.action.create) ? "POST" : "PUT";
                let data = { name: this.item.name, description: this.item.description, status_id: this.item.status_id, manager_id: this.item.manager_id,
                        start_date: this.item.start_date, public: this.item.public, geo_lat: this.item.geo_lat, geo_long: this.item.geo_long,
                        zones_autocomplete: this.item.zones_autocomplete, allow_user_accession_create: this.item.allow_user_accession_create,
                        uses_auto_increment_designator: this.item.uses_auto_increment_designator, uses_isotope_analysis: this.item.uses_isotope_analysis,
                        slack_channel: this.item.slack_channel, };

                console.log("Save Data: " + JSON.stringify(data));
                axios
                    .request({ url: url, method: method, data: data,
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        this.loading = false;
                        let payload = { 'text': 'Update successful', 'color': 'success', };
                        eventBus.$emit('show-snackbar', payload);
                        eventBus.$emit('refresh-list', { 'list': 'projects', } );
                        this.close();
                    }).catch(error => {
                    console.log(error.response);
                    this.loading = false;
                    let payload = { 'text': 'Update failed', 'color': 'error', };
                    eventBus.$emit('show-snackbar', payload);
                    this.close();
                })
            },
            getProjectUsers() {
                this.loading = true;
                let url = '/api/projects/' + this.item.id + '/users';
                axios
                    .request({ url: url, method: "GET",
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        this.loading = false;
                        this.project_users = response.data.data;
                        console.log("Project Users: " + JSON.stringify(this.project_users))
                    }).catch(error => {
                        this.loading = false;
                    })
            },
            getProjectInstruments() {
                this.loading = true;
                let url = '/api/projects/' + this.item.id + '/instruments';
                axios
                    .request({ url: url, method: "GET",
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        this.loading = false;
                        this.project_instruments = response.data.data;
                        console.log("Project Instruments: " + JSON.stringify(this.project_instruments))
                    }).catch(error => {
                    this.loading = false;
                })
            },
            toggleValidation () {
                this.show_validation = !this.show_validation;
                if (this.show_validation) {
                    this.validateForm();
                } else {
                    this.resetFormValidation();
                }
            },
            validateForm () {
                this.$refs.form.validate();
            },
            resetFormValidation () {
                this.$refs.form.resetValidation();
            },
            resetForm () {
                this.$refs.form.reset();
                this.item = (this.action.create) ? this.defaultItem : this.cached_item;
            },
            removeUser (index) {
                if (index >= 0) {
                    this.project_users.splice(index, 1);
                }
            },
        },
        computed: {
            ...mapState({
                //
            }),
            ...mapGetters({
                theOrg: 'theOrg',
                theProject: 'theProject',
                projectlist: 'theUserProjects',
                projectsData: 'getProjectsIdNameArray',
                users: 'getOrgUsers',
                instruments: 'getOrgInstruments',
                items_project_statuses: 'getProjectStatuses',
            }),
            action() {
                const action = this.crud_action;
                return { list: action === "List", create: action === "Create", view: action === "View", edit: action === "Update" || action === "Edit" };
            },
            disabled() {
                return this.action.delete;
            },
        },
    }
</script>

<style scoped>
    .v-text-field__slot { top: -5px; }
</style>