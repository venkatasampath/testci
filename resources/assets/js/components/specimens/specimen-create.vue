<template>
    <div class="m-2 align-center">
        <contentheader :trail="trail" :title="heading">
        </contentheader>
        <v-alert v-if="alert" class="my-1" border="left" colored-border type="info" elevation="2" dismissible>{{alertText}}</v-alert>
        <v-card>
            <v-card-text>
                <v-row>
                    <v-col cols="12" md="3"><an :value="form.accession_number" @input="(val) => {form.accession_number = val}"/></v-col>
                    <v-col cols="12" md="3"><p1 :value="form.provenance1" @input="(val) => {form.provenance1 = val}"/></v-col>
                    <v-col cols="12" md="3"><p2 :value="form.provenance2" @input="(val) => {form.provenance2 = val}"/></v-col>
                    <v-col cols="12" md="3" v-if="!theProject.use_auto_incrementing_designator"><dn @input="(val) => {form.designator = val}"/></v-col>
                </v-row>
                <v-row>
                    <v-col cols="6" class="m-0 py-0"><bone-side @input-sb="(val) => {form.sb_id = val}" @input-side="(val) => {form.side = val}"/></v-col>
                    <v-col cols="6" md="3"><completeness @input="(val) => {form.completeness = val}"/></v-col>
                </v-row>
        </v-card-text>
        <v-card-actions>
            <v-row class="justify-center">
                <v-btn title="Save and Edit" color="primary" class="mr-2" @click="save" :disabled="!isFormValid"><v-icon class="mr-2">mdi-content-save-edit</v-icon>Save and Edit</v-btn>
                <v-btn title="Save and Add" color="primary" class="mr-2" @click="save_n_add" :disabled="!isFormValid"><v-icon class="mr-2">mdi-content-save</v-icon>Save and Add</v-btn>
<!--                    <v-btn color="primary" class="mr-2" @click="save_n_add" :disabled="!isFormValid"><v-icon class="mr-2">mdi-content-save</v-icon>Save and Add<v-icon class="ml-2">mdi-plus-circle</v-icon></v-btn>-->
            </v-row>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import {eventBus} from "../../eventBus";
    import axios from 'axios';

    export default {
        props: {
            heading: { type: String, default: "Create Specimen" },
            crud_action: { type: String, default: "Create" },
        },
        data() {
            return {
                isFormValid: true,
                loading: false,
                formSubmitssionDisabled: false,
                form: {
                    org_id: null,
                    project_id: null,
                    accession_number: null,
                    provenance1: null,
                    provenance2: null,
                    designator: null,
                    sb_id: null,
                    side: 'Left',
                    completeness: 'Complete',
                },
                showForm: true,
                show_save: true,
                trail: [{ text: 'Home', disabled: false, href: '/', }, { text: 'Specimen ', disabled: true, href: "/" }, { text: 'New', disabled: true, href: "/" }, ],
                alert: false,
                alertText: "",
                save_and_add: false,
                se_id: null
            };
        },
        created() {
            this.form.org_id = this.theOrg.id;
            this.form.project_id = this.theProject.id;

            // Get the User profile defaults for Accession, Provenance1 and Provenance2 if available
            this.form.accession_number = this.getUserProfileValueByName("accession");
            this.form.provenance1 = this.getUserProfileValueByName("provenance1");
            this.form.provenance2 = this.getUserProfileValueByName("provenance2");
            console.log("form data: " + JSON.stringify(this.form));
        },
        watch: {
            //
        },
        methods: {
            reset() {
                this.form = this.getFormData();
            },
            save_n_add() {
                this.save_and_add = true;
                this.save();
            },
            save() {
                axios
                .request({
                    url: '/api/specimens/',
                    method: 'POST',
                    headers: {'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken,},
                    data: this.form,
                })
                .then(response => {
                    this.loading = false;
                    let status = response.data;
                    console.log(status);
                    console.log("Specimen Create Save: data: " + JSON.stringify(response.data));
                    let payload = {'text': 'Specimen create successful', 'color': 'success',};
                    eventBus.$emit('show-snackbar', payload);
                    if (this.save_and_add) {
                        // Stay on this screen, clear certain/some old data fields
                        this.save_and_add = false;
                    } else {
                        this.se_id = response.data.data.id;
                        window.location.href = '/skeletalelements/' + this.se_id;
                    }
                }).catch(error => {
                    console.log(error.response);
                    let msg = error.response.data.data.message;
                    this.loading = false;
                    this.save_and_add = false;
                    let payload = {'text': 'Specimen create failed' + "\n" + msg, 'color': 'error', 'multiline': true };
                    eventBus.$emit('show-snackbar', payload);
                })
            },
        },
        computed: {
            ...mapState({
                //
            }),
            ...mapGetters({
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
                bearerToken: 'bearerToken',
                isAdminOrOrgAdmin: 'isAdminOrOrgAdmin',
                getOrgProfileValueByName: 'getOrgProfileValueByName',
                getUserProfileValueByName: 'getUserProfileValueByName',
            }),
            action() {
                const act = this.crud_action;
                return { create: act === "Create", view: act === "View", edit: (act === "Update" || act === "Edit"), list: act === "List", };
            },
        },
    };
</script>
