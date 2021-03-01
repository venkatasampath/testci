<template>
    <v-card>
        <v-card-title class="m-0 p-0">
            <v-app-bar>
                <v-toolbar-title>{{title}}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-progress-circular v-if="loading" :indeterminate="loading" color="primary"></v-progress-circular>
            </v-app-bar>
        </v-card-title>
        <v-card-text>
            <v-list two-line subheader>
                <v-subheader class="p-0">General</v-subheader>
                <v-list-item>
                    <v-list-item-content>
                        <v-autocomplete v-model="user_settings.lines_per_page" :hint="profile_lines_per_page.help" persistent-hint
                                        :items="rowsPerPageItems" :readonly="!isEditingLinesPerPage" label="Lines per page">
                            <template v-slot:append-outer>
                                <v-icon :title="isEditingLinesPerPage?'Save':'Edit'" v-text="isEditingLinesPerPage?'mdi-content-save':'mdi-circle-edit-outline'"
                                        @click="updateProfile('lines_per_page')" color="primary">
                                </v-icon>
                                <v-icon title="Reset/Undo" v-if="isEditingLinesPerPage" class="pl-2" color="primary" @click="reset('lines_per_page')">mdi-undo-variant</v-icon>
                            </template>
                        </v-autocomplete>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item>
                    <template v-slot:default="{ active, toggle }">
                        <v-list-item-action>
                            <v-switch v-model="user_settings.ui_right_sidebar_slideout_help" primary label="" @change="updateProfile('ui_right_sidebar_slideout_help')"/>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>Help Slideout</v-list-item-title>
                            <v-list-item-subtitle style="white-space: normal;">{{ profile_ui_right_sidebar_slideout_help.help }}</v-list-item-subtitle>
                        </v-list-item-content>
                    </template>
                </v-list-item>
            </v-list>

            <v-list two-line subheader>
                <v-subheader class="p-0">Specimen</v-subheader>
                <v-list-item>
                    <v-list-item-content>
                        <v-text-field v-model="user_settings.accession" label="Accession" placeholder="Set accession number"
                                      :hint="profile_accession.help" persistent-hint :readonly="!isEditingAN">
                            <template v-slot:append-outer>
                                <v-icon :title="isEditingAN?'Save':'Edit'" v-text="isEditingAN?'mdi-content-save':'mdi-circle-edit-outline'"
                                        @click="updateProfile('accession')" color="primary">
                                </v-icon>
                                <v-icon title="Reset/Undo" v-if="isEditingAN" class="pl-2" color="primary" @click="reset('accession')">mdi-undo-variant</v-icon>
                            </template>
                        </v-text-field>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item>
                    <v-list-item-content>
                        <v-text-field v-model="user_settings.provenance1" label="Provenance1" placeholder="Set provenance1"
                                      :hint="profile_provenance1.help" persistent-hint :readonly="!isEditingP1">
                            <template v-slot:append-outer>
                                <v-icon :title="isEditingP1?'Save':'Edit'" v-text="isEditingP1?'mdi-content-save':'mdi-circle-edit-outline'"
                                        @click="updateProfile('provenance1')" color="primary">
                                </v-icon>
                                <v-icon title="Reset/Undo" v-if="isEditingP1" class="pl-2" color="primary" @click="reset('provenance1')">mdi-undo-variant</v-icon>
                            </template>
                        </v-text-field>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item>
                    <v-list-item-content>
                        <v-text-field v-model="user_settings.provenance2" label="Provenance2" placeholder="Set provenance2"
                                      :hint="profile_provenance2.help" persistent-hint :readonly="!isEditingP2">
                            <template v-slot:append-outer>
                                <v-icon :title="isEditingP2?'Save':'Edit'" v-text="isEditingP2?'mdi-content-save':'mdi-circle-edit-outline'"
                                        @click="updateProfile('provenance2')" color="primary">
                                </v-icon>
                                <v-icon title="Reset/Undo" v-if="isEditingP2" class="pl-2" color="primary" @click="reset('provenance2')">mdi-undo-variant</v-icon>
                            </template>
                        </v-text-field>
                    </v-list-item-content>
                </v-list-item>
            </v-list>

            <v-list two-line subheader>
                <v-subheader class="p-0">DNA</v-subheader>
                <v-list-item>
                    <v-list-item-content>
                        <v-autocomplete v-model="user_settings.default_lab" label="Default lab" :hint="profile_default_lab.help" persistent-hint
                                        :items="labs" item-text="name" item-value="id" :readonly="!isEditingDefaultLab">
                            <template v-slot:append-outer>
                                <v-icon :title="isEditingDefaultLab?'Save':'Edit'" v-text="isEditingDefaultLab?'mdi-content-save':'mdi-circle-edit-outline'"
                                        @click="updateProfile('default_lab')" color="primary">
                                </v-icon>
                                <v-icon title="Reset/Undo" v-if="isEditingDefaultLab" class="pl-2" color="primary" @click="reset('default_lab')">mdi-undo-variant</v-icon>
                            </template>
                        </v-autocomplete>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item>
                    <v-list-item-content>
                        <v-autocomplete v-model="user_settings.default_dna_method" label="Default Method - Mito Sequence" :hint="profile_default_dna_method.help" persistent-hint
                                        :items="dna_mito_types" item-text="display_name" item-value="id" :readonly="!isEditingDefaultDnaMethod">
                            <template v-slot:append-outer>
                                <v-icon :title="isEditingDefaultDnaMethod?'Save':'Edit'" v-text="isEditingDefaultDnaMethod?'mdi-content-save':'mdi-circle-edit-outline'"
                                        @click="updateProfile('default_dna_method')" color="primary">
                                </v-icon>
                                <v-icon title="Reset/Undo" v-if="isEditingDefaultDnaMethod" class="pl-2" color="primary" @click="reset('default_dna_method')">mdi-undo-variant</v-icon>
                            </template>
                        </v-autocomplete>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-card-text>
    </v-card>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import axios from "axios";

    export default {
        name: "rhsPanelUserSettings",
        props:{
            title: {type:String, default: "User Settings"},
            show: {type:Boolean, default: false},
        },
        data() {
            return {
                loading: false,
                isEditingLinesPerPage: false,
                isEditingAN: false,
                isEditingP1: false,
                isEditingP2: false,
                isEditingDefaultLab: false,
                isEditingDefaultDnaMethod: false,

                profile_lines_per_page: null,
                profile_accession: null,
                profile_provenance1: null,
                profile_provenance2: null,
                profile_default_lab: null,
                profile_default_dna_method: null,
                profile_ui_right_sidebar_slideout_help: null,
                user_settings: {
                    lines_per_page: 0, accession: "", provenance1: "", provenance2: "", default_lab: -1, default_dna_method: -1, ui_right_sidebar_slideout_help: true,
                },
                cached_user_settings: null,

                rules: {
                    required: value => !!value || 'Required.',
                    min: v => v.length >= 8 || 'Min 8 characters',
                    emailMatch: () => ('The email and password you entered don\'t match'),
                },

                lab_id: 0,
                labs: null,
                dna_mito_types: null,
            }
        },
        created() {
            console.log('rhsPanelUserSettings Component created.');

            if (this.theUser) {
                this.loading = true;
                let payload = { 'type': 'profiles' };
                this.$store.dispatch('fetchUserList', payload).then(() => this.loading = false);
            }

            this.labs = this.$store.getters.getLabs('Genomics');
            this.dna_mito_types = this.$store.getters.getDnaAnalysisTypes('mito');

            this.profile_lines_per_page = this.$store.getters.getUserProfileByName('lines_per_page');
            this.profile_accession = this.$store.getters.getUserProfileByName('accession');
            this.profile_provenance1 = this.$store.getters.getUserProfileByName('provenance1');
            this.profile_provenance2 = this.$store.getters.getUserProfileByName('provenance2');
            this.profile_default_lab = this.$store.getters.getUserProfileByName('default_lab');
            this.profile_default_dna_method = this.$store.getters.getUserProfileByName('default_dna_method');
            this.profile_ui_right_sidebar_slideout_help = this.$store.getters.getUserProfileByName('ui_right_sidebar_slideout_help');

            this.user_settings.lines_per_page = (this.profile_lines_per_page.pivot)?parseInt(this.profile_lines_per_page.pivot.value):parseInt(this.profile_lines_per_page.default_value);
            this.user_settings.accession = (this.profile_accession.pivot)?this.profile_accession.pivot.value:this.profile_accession.default_value;
            this.user_settings.provenance1 = (this.profile_provenance1.pivot)?this.profile_provenance1.pivot.value:this.profile_provenance1.default_value;
            this.user_settings.provenance2 = (this.profile_provenance2.pivot)?this.profile_provenance2.pivot.value:this.profile_provenance2.default_value;
            // this.user_settings.default_dna_method = (this.profile_default_dna_method.pivot)?this.profile_default_dna_method.pivot.value:this.profile_default_dna_method.default_value;
            this.user_settings.default_lab = (this.profile_default_lab.pivot)?parseInt(this.profile_default_lab.pivot.value):parseInt(this.profile_default_lab.default_value);
            this.user_settings.default_dna_method = (this.profile_default_dna_method.pivot)?parseInt(this.profile_default_dna_method.pivot.value):parseInt(this.profile_default_dna_method.default_value);

            // let lab_id = (this.profile_default_lab.pivot)?parseInt(this.profile_default_lab.pivot.value):parseInt(this.profile_default_lab.default_value);
            // let lab = this.labs.find( lab => { return lab.id === lab_id });
            // this.user_settings.default_lab = lab.name;

            let slideout = (this.profile_ui_right_sidebar_slideout_help.pivot)?this.profile_ui_right_sidebar_slideout_help.pivot.value:this.profile_ui_right_sidebar_slideout_help.default_value;
            this.user_settings.ui_right_sidebar_slideout_help = (slideout === "true");

            this.cached_user_settings = Object.assign({}, this.user_settings);
            this.loading = false;
        },
        mounted() {
            console.log('rhsPanelUserSettings Component mounted.');
        },
        methods: {
            updateProfile(name) {
                console.log("updateProfile: "+ name);
                if (name === "lines_per_page") {
                    if (this.isEditingLinesPerPage && (this.user_settings.lines_per_page !== this.cached_user_settings.lines_per_page)) {
                        this.loading = true;
                        this.$store.dispatch('updateUserProfile', {'name': name, 'value': this.user_settings.lines_per_page} )
                            .then(response=>{
                                this.profile_lines_per_page.value = this.user_settings.lines_per_page;
                                this.cached_user_settings.lines_per_page = this.user_settings.lines_per_page;
                                this.loading = false;
                            });
                    }
                    this.isEditingLinesPerPage = !this.isEditingLinesPerPage;
                } else  if (name === "ui_right_sidebar_slideout_help") {
                    console.log("ui_right_sidebar_slideout_help: " + this.user_settings.ui_right_sidebar_slideout_help);
                    this.loading = true;
                    this.$store.dispatch('updateUserProfile', {'name': name, 'value': this.user_settings.ui_right_sidebar_slideout_help} )
                        .then(response=>{
                            this.profile_ui_right_sidebar_slideout_help.value = this.user_settings.ui_right_sidebar_slideout_help;
                            this.cached_user_settings.ui_right_sidebar_slideout_help = this.user_settings.ui_right_sidebar_slideout_help;
                            this.loading = false;
                        });
                } else  if (name === "accession") {
                    if (this.isEditingAN && (this.user_settings.accession !== this.cached_user_settings.accession)) {
                        this.loading = true;
                        this.$store.dispatch('updateUserProfile', {'name': name, 'value': this.user_settings.accession} )
                        .then(response=>{
                            this.profile_accession.value = this.user_settings.accession;
                            this.cached_user_settings.accession = this.user_settings.accession;
                            this.loading = false;
                        });
                    }
                    this.isEditingAN = !this.isEditingAN;
                } else  if (name === "provenance1") {
                    if (this.isEditingP1 && (this.user_settings.provenance1 !== this.cached_user_settings.provenance1)) {
                        this.loading = true;
                        this.$store.dispatch('updateUserProfile', {'name': name, 'value': this.user_settings.provenance1} )
                        .then(response=>{
                            this.profile_provenance1.value = this.user_settings.provenance1;
                            this.cached_user_settings.provenance1 = this.user_settings.provenance1;
                            this.loading = false;
                        });
                    }
                    this.isEditingP1 = !this.isEditingP1;
                } else  if (name === "provenance2") {
                    if (this.isEditingP2 && (this.user_settings.provenance2 !== this.cached_user_settings.provenance2)) {
                        this.loading = true;
                        this.$store.dispatch('updateUserProfile', {'name': name, 'value': this.user_settings.provenance2} )
                        .then(response=>{
                            this.profile_provenance2.value = this.user_settings.provenance2;
                            this.cached_user_settings.provenance2 = this.user_settings.provenance2;
                            this.loading = false;
                        });
                    }
                    this.isEditingP2 = !this.isEditingP2;
                } else  if (name === "default_lab") {
                    if (this.isEditingDefaultLab && (this.user_settings.default_lab !== this.cached_user_settings.default_lab)) {
                        this.loading = true;
                        this.$store.dispatch('updateUserProfile', {'name': name, 'value': this.user_settings.default_lab} )
                        .then(response=>{
                            this.profile_default_lab.value = this.user_settings.default_lab;
                            this.cached_user_settings.default_lab = this.user_settings.default_lab;
                            this.loading = false;
                        });
                    }
                    this.isEditingDefaultLab = !this.isEditingDefaultLab;
                } else  if (name === "default_dna_method") {
                    if (this.isEditingDefaultDnaMethod && (this.user_settings.default_dna_method !== this.cached_user_settings.default_dna_method)) {
                        this.loading = true;
                        this.$store.dispatch('updateUserProfile', {'name': name, 'value': this.user_settings.default_dna_method} )
                        .then(response=>{
                            this.profile_default_dna_method.value = this.user_settings.default_dna_method;
                            this.cached_user_settings.default_dna_method = this.user_settings.default_dna_method;
                            this.loading = false;
                        });
                    }
                    this.isEditingDefaultDnaMethod = !this.isEditingDefaultDnaMethod;
                }
            },
            reset(name) {
                if (name === "lines_per_page") {
                    this.user_settings.lines_per_page = this.cached_user_settings.lines_per_page;
                    this.isEditingLinesPerPage = !this.isEditingLinesPerPage;
                } else  if (name === "accession") {
                    this.user_settings.accession = this.cached_user_settings.accession;
                    this.isEditingAN = !this.isEditingAN;
                } else  if (name === "provenance1") {
                    this.user_settings.provenance1 = this.cached_user_settings.provenance1;
                    this.isEditingP1 = !this.isEditingP1;
                } else  if (name === "provenance2") {
                    this.user_settings.provenance2 = this.cached_user_settings.provenance2;
                    this.isEditingP2 = !this.isEditingP2;
                } else  if (name === "default_lab") {
                    this.user_settings.default_lab = this.cached_user_settings.default_lab;
                    this.isEditingDefaultLab = !this.isEditingDefaultLab;
                } else  if (name === "default_dna_method") {
                    this.user_settings.default_dna_method = this.cached_user_settings.default_dna_method;
                    this.isEditingDefaultDnaMethod = !this.isEditingDefaultDnaMethod;
                }
            },
        },
        computed: {
            ...mapState({
                perPage: state => state.search.perPage,
                rowsPerPageItems: state => state.search.rowsPerPageItems,
                profiles: state => state.profiles,
            }),
            ...mapGetters({
                bearerToken: 'bearerToken',
                csrfToken: 'csrfToken',
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
            }),
        },
    }
</script>

<style scoped>
    .wrap-text {
        -webkit-line-clamp: unset !important;
    }
    .v-list-item__title {
        white-space: normal;
    }
</style>