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
                    <v-btn icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
                </v-toolbar>
            </v-card-title>
            <v-card-text>
                <v-form ref="form" v-model="isFormValid">
                    <v-row>
                        <v-col cols="6">
                            <v-autocomplete v-model="item.project_id" label="Project Name" placeholder="e.g. CoRA Demo" disabled
                                            :items="this.projectsData" item-value="projectsValue" item-text="projectsText">
                            </v-autocomplete>
                        </v-col>
                        <v-col cols="6">
                            <v-text-field v-model="item.number" label="Number:" placeholder="e.g. UNO 2016-212, BAK 2017-488" :rules="rules.number" required :disabled="disabled"/>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6"><v-text-field v-model="item.provenance1" label="Provenance 1" placeholder="e.g. G-01, G-22" :disabled="disabled"></v-text-field></v-col>
                        <v-col cols="6"><v-text-field v-model="item.provenance2" label="Provenance 2" placeholder="e.g. X-65, X-79" :disabled="disabled"></v-text-field></v-col>
                    </v-row>
                </v-form>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions v-if="(action.edit || action.create) && !specimens">
                <v-row align="center" justify="center" class="m-0 p-0">
                    <v-btn color="primary" text @click="save" :disabled="!isFormValid"><v-icon class="p-2">mdi-content-save</v-icon>Save</v-btn>
                    <v-btn color="primary" text @click="close"><v-icon class="p-2">mdi-cancel</v-icon>Cancel</v-btn>
                </v-row>
            </v-card-actions>
            <v-card-actions v-else-if="action.delete && !specimens">
                <v-row align="center" justify="center" class="m-0 p-0">
                    <span><v-icon color="warning" class="p-2">mdi-alert</v-icon>Are you sure you want to delete this item?</span>
                    <v-btn color="error" text @click="trash"><v-icon class="p-2">mdi-delete</v-icon>Delete</v-btn>
                    <v-btn color="primary" text @click="close"><v-icon class="p-2">mdi-cancel</v-icon>Cancel</v-btn>
                </v-row>
            </v-card-actions>
            <v-card-actions v-if="specimens">
                <v-row align="center" justify="center" class="m-0 p-0">
                    <v-badge :content="specimens.length" color="green" overlap>
                        <v-autocomplete label="Specimens" :items="specimens" item-text="key_bone_side" item-value="id"/>
                    </v-badge>
                </v-row>
                <v-row align="center" justify="center" class="m-0 p-0">
                    <span><v-icon color="warning" class="p-2">mdi-alert</v-icon>This accession is currently in use, you cannot edit/delete it.</span>
<!--                    <span><v-icon color="warning" class="p-2">mdi-information</v-icon>If you want edit or delete it, please delete all specimens associated with it.</span>-->
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
        name: "accession-crud",
        props: {
            default_crud_action: "Edit",
            default_title: "Modal title",
        },
        data() {
            return {
                isFormValid: true,
                loading: false,
                crud_action: "Edit",
                dialog: false,
                title: "Modal title",
                items: [],
                index: -1,
                show_validation: false,
                item: { number: '', provenance1: '', provenance2: ''},
                defaultItem: { name: '', number: '', provenance1: '', provenance2: ''},
                menu: false,
                rules: {
                    number: [ v => !!v || 'Accession number is required', v => (v && v.length >= 3) || 'Acceession number must be at least 3 characters',
                        v => v.length <= 32 || 'Max 32 characters'],
                },
                specimens: null,
            };
        },
        created() {
            this.defaultItem.project_id = this.item.project_id = this.theProject.id;
            eventBus.$on('show-crud-dialog', payload => {
                this.dialog = !this.dialog;
                this.title = (payload.title) ? payload.title : "No Modal Title";
                this.crud_action = (payload.action) ? payload.action : "Edit";
                this.item = (payload.item) ? payload.item : this.defaultItem;
                this.index = (payload.index) ? payload.index : this.index;
                if (this.crud_action !== "Create") {
                    this.getSpecimens();
                }
            });

            // Set org_id and project_id for new item
            this.defaultItem.org_id = this.theOrg.id;
            this.defaultItem.project_id = this.theProject.id;
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
                this.item = this.defaultItem;
                this.index = -1;
                this.dialog = false;
                this.show_validation = false;
                this.specimens = null;
            },
            save () {
                this.loading = true;
                let url = (this.action.create) ? '/api/accessions' : '/api/accessions/' + this.item.id;
                let method = (this.action.create) ? "POST" : "PUT";
                axios
                    .request({ url: url, method: method,
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                        data:{
                            org_id: this.item.org_id,
                            project_id: this.item.project_id,
                            number: this.item.number,
                            provenance1: this.item.provenance1,
                            provenance2: this.item.provenance2,
                        },
                    })
                    .then(response=>{
                        this.loading = false;
                        let payload = { 'text': 'Update successful', 'color': 'success', };
                        eventBus.$emit('show-snackbar', payload);
                        eventBus.$emit('refresh-list', { 'list': 'accessions', } );
                        this.close();
                    }).catch(error => {
                        console.log(error.response);
                        this.loading = false;
                        let payload = { 'text': 'Update failed', 'color': 'error', };
                        eventBus.$emit('show-snackbar', payload);
                        this.close();
                    })
            },
            trash() {
                this.loading = true;
                axios
                    .request({ url: '/api/accessions/' + this.item.id, method: 'DELETE',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        console.log("then response: " + JSON.stringify(response));
                        this.loading = false;
                        let payload = { 'text': 'Delete successful', 'color': 'success', };
                        eventBus.$emit('show-snackbar', payload);
                        eventBus.$emit('refresh-list', { 'list': 'accessions', } );
                        this.close();
                    }).catch(error => {
                        console.log(error.response);
                        this.loading = false;
                        let payload = { 'text': 'Delete failed', 'color': 'error', };
                        eventBus.$emit('show-snackbar', payload);
                        this.close();
                    })
            },
            getSpecimens() {
                this.loading = true;
                axios
                    .request({ url: '/api/accessions/' + this.item.id + "/specimens", method: 'GET',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        console.log("then response: " + JSON.stringify(response));
                        this.specimens=response.data.data;
                        this.loading = false;
                    }).catch(error => {
                        console.log(error.response);
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
                this.$refs.form.validate()
            },
            resetForm () {
                this.$refs.form.reset()
            },
            resetFormValidation () {
                this.$refs.form.resetValidation()
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
                getProjectById: 'getProjectById',
            }),
            action() {
                const action = this.crud_action;
                return { list: action === "List", create: action === "Create", view: action === "View", edit: action === "Update" || action === "Edit" , delete: action === "Delete",};
            },
            disabled() {
                return this.action.delete || (this.specimens !== null);
            },
        },
    }
</script>

<style scoped>
    .v-text-field__slot { top: -5px; }
</style>