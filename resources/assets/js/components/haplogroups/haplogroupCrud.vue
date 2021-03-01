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
                        <v-col cols="6"><v-autocomplete v-model="item.type" label="Type" :items="dnaType" :disabled="disabled" :rules="rules.type"></v-autocomplete></v-col>
                        <v-col cols="6"><v-text-field v-model="item.letter" label="Letter" :disabled="disabled" :rules="rules.letter" /></v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6"><v-text-field v-model="item.subgroup" label="Subgroup" :disabled="disabled"/></v-col>
                        <v-col cols="6"><v-autocomplete v-model="item.ancestry" label="Ancestry" :disabled="disabled"></v-autocomplete></v-col>
                    </v-row>
                </v-form>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions v-if="action.edit || action.create">
                <v-row align="center" justify="center" class="m-0 p-0">
                    <v-btn color="primary" text @click="save" :disabled="!isFormValid"><v-icon class="p-2">mdi-content-save</v-icon>Save</v-btn>
                    <v-btn color="primary" text @click="close"><v-icon class="p-2">mdi-cancel</v-icon>Cancel</v-btn>
                </v-row>
            </v-card-actions>
            <v-card-actions v-else-if="action.delete">
                <v-row align="center" justify="center" class="m-0 p-0">
                    <span><v-icon color="warning" class="p-2">mdi-alert</v-icon>Are you sure you want to delete this item?</span>
                    <v-btn color="error" text @click="trash"><v-icon class="p-2">mdi-delete</v-icon>Delete</v-btn>
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
        name: "haplogroup-crud",
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
                item: { type: '', letter: '', subgroup: '', ancestry: ''},
                    defaultItem: { type: '', letter: '', subgroup: '', ancestry: ''},
                menu: false,
                show_validation: false,
                dnaType: [ 'Mito', 'Ystr'],
                rules: {
                    type: [ v => !!v || 'Type is required'],
                    letter: [ v => !!v || 'Letter is required'],
                }
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
            });
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
            },
            save() {
                this.loading = true;
                let url = (this.action.create) ? '/api/haplogroups' : '/api/haplogroups/' + this.item.id;
                let method = (this.action.create) ? "POST" : "PUT";
                axios
                    .request({
                        url: url,
                        method: method,
                        headers:{
                            'Content-Type' : 'application/json',
                            'Authorization' : this.$store.getters.bearerToken,
                        },
                        data:{
                            org_id: this.theOrg.id,
                            project_id: (this.item.org) ? null : this.item.project_id,
                            type: this.item.type,
                            letter: this.item.letter,
                            subgroup: this.item.subgroup,
                            ancestry: this.item.ancestry,
                        },
                    })
                    .then(response=>{
                        this.loading = false;
                        let payload = { 'text': 'Update successful', 'color': 'success', };
                        eventBus.$emit('show-snackbar', payload);
                        eventBus.$emit('refresh-list', { 'list': 'haplogroups', } );
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
                    .request({
                        url: '/api/haplogroups/' + this.item.id,
                        method: 'DELETE',
                        headers:{
                            'Content-Type' : 'application/json',
                            'Authorization' : this.$store.getters.bearerToken,
                        }
                    })
                    .then(response=>{
                        console.log("then response: " + JSON.stringify(response));
                        this.loading = false;
                        let payload = { 'text': 'Delete successful', 'color': 'success', };
                        eventBus.$emit('show-snackbar', payload);
                        eventBus.$emit('refresh-list', { 'list': 'haplogroups', } );
                        this.close();
                    }).catch(error => {
                    console.log(error.response);
                    this.loading = false;
                    let payload = { 'text': 'Delete failed', 'color': 'error', };
                    eventBus.$emit('show-snackbar', payload);
                    this.close();
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
            }),
            action() {
                const action = this.crud_action;
                return { list: action === "List", create: action === "Create", view: action === "View", edit: action === "Update" || action === "Edit" , delete: action === "Delete",};
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