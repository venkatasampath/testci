<template>
    <div class="m-2 align-center">
        <v-card flat>
            <v-container fluid class="m-0 p-0">
                <v-toolbar>
                    <v-breadcrumbs :items="trail" large class="p-0"></v-breadcrumbs>
                    <v-spacer></v-spacer>
                    <v-toolbar-title class="pt-5">
                        <v-row class="mx-4">
                            <v-col cols="12" md="3">
                                <v-badge class="specimen-canvas" :content="listAccession.length" :value="listAccession.length" color="green" overlap>
                                    <v-autocomplete v-model="accession_number" name="accession_number" :items="listAccession" clearable
                                                    label="Accession Number" placeholder="Select Accession Number" @change="getSpecimens">
                                    </v-autocomplete>
                                </v-badge>
                            </v-col>
                            <v-col cols="12" md="3">
                                <v-badge class="specimen-canvas" :content="listProvenance1.length" :value="listProvenance1.length" color="green" overlap>
                                    <v-autocomplete v-model="provenance1" name="provenance1" :items="listProvenance1" clearable
                                                    label="Provenance1" placeholder="Select Provenance1" @change="getSpecimens">
                                    </v-autocomplete>
                                </v-badge>
                            </v-col>
                            <v-col cols="12" md="3">
                                <v-badge class="specimen-canvas" :content="listProvenance2.length" :value="listProvenance2.length" color="green" overlap>
                                    <v-autocomplete v-model="provenance2" name="provenance2" :items="listProvenance2" clearable
                                                    label="Provenance2" placeholder="Select Provenance2" @change="getSpecimens">
                                    </v-autocomplete>
                                </v-badge>
                            </v-col>
<!--                            <v-col cols="12" md="2">-->
<!--                                <v-badge class="specimen-canvas" :content="listIndividualNumbers.length" :value="listIndividualNumbers.length" color="green" overlap>-->
<!--                                    <v-autocomplete v-model="individual_number" name="individual_number" :items="listIndividualNumbers" clearable-->
<!--                                                    label="Individual Number" placeholder="Select Individual Number">-->
<!--                                    </v-autocomplete>-->
<!--                                </v-badge>-->
<!--                            </v-col>-->
                            <v-col cols="12" md="3">
                                <v-badge class="specimen-canvas-specimens" :content="listSpecimens.length" :value="listSpecimens.length" color="green" overlap>
                                    <v-autocomplete v-model="selected_specimen_id" name="selected_specimen" label="Specimen" placeholder="Select Specimen" clearable
                                                    :items="listSpecimens" item-text="key_bone_side" item-value="id" :loading="loading" @change="getSpecimen">
                                        <template v-slot:append-outer>
                                            <v-icon title="View" color="primary" @click="search" :disabled="!selected_specimen_id" :loading="loading">mdi-magnify</v-icon>
                                        </template>
                                    </v-autocomplete>
                                </v-badge>
                            </v-col>
<!--                            <v-col cols="12" md="2"><Provenance1 :options="listProvenance1" v-model="provenance1"/></v-col>-->
<!--                            <v-col cols="12" md="2"><Provenance2 :options="listProvenance2" v-model="provenance2"/></v-col>-->
                        </v-row>
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <!--  Start - Place dynamic buttons here-->
                    <v-btn title="Reset/Undo" icon color="primary" @click="resetWidgets"><v-icon>mdi-undo-variant</v-icon></v-btn>
                    <v-btn :title="!isCollapseAll?'Collapse All':'Expand All'" icon color="primary" @click="toggleCollapseAll">
                        <v-icon v-text="isCollapseAll ? 'mdi-chevron-triple-down' : 'mdi-chevron-triple-up'"></v-icon>
                    </v-btn>
                </v-toolbar>
            </v-container>
        </v-card>
        <v-card v-if="specimen" :key="specimen.id">
            <v-alert v-if="alert" class="my-1" border="left" colored-border type="info" elevation="2" dismissible>{{alertText}}</v-alert>
            <specimen-highlights v-if="show_specimen" :specimen="specimen"></specimen-highlights>
            <draggable v-if="specimen" class="row px-2" v-model="widgets" group="widgets" @start="drag=true" @end="drag=false">
                <div v-if="widget.visible" :class="widgetWidth(widget)" v-for="(widget, key) in widgets" :key="key" class="m-0 p-0">
                    <specimen v-if="widget.name === 'Specimen'" :specimen="specimen" :show_tags="false" :show_comments="false"
                              :contentheader="false" :toolbar="true" :toolbar_crud="true"/>
                    <measurements v-if="widget.name === 'Measurements'" :specimen="specimen" :help_slideout="false" :contentheader="false" :toolbar="true" :toolbar_crud="true"/>
                    <zones v-if="widget.name === 'Zones'" :specimen="specimen" :help_slideout="false" :contentheader="false" :toolbar="true" :toolbar_crud="true"/>
                    <biological-profile-methods v-if="widget.name === 'Methods'" :specimen="specimen" :contentheader="false" :toolbar="true" :toolbar_crud="true"/>
                    <pat v-if="widget.name === 'Pathology'" :specimen="specimen" :contentheader="false" :toolbar="true" :toolbar_crud="true"/>
                    <taphonomy v-if="widget.name === 'Taphonomy'" :specimen="specimen" :contentheader="false" :toolbar="true" :toolbar_crud="true"/>
                    <tags v-if="widget.name === 'Tags'" :tag_model="specimen" type="Specimen" crud_action="Edit"/>
                </div>
            </draggable>
        </v-card>
    </div>
</template>
<style scoped>
    .v-autocomplete-content .v-select-list .v-subheader {
        color: blue;
    }
    .specimen-canvas .v-badge__wrapper {
        margin-left: -10px;
        margin-top: -5px;
    }
    .specimen-canvas-specimens .v-badge__wrapper {
        margin-left: -42px;
        margin-top: -5px;
    }
</style>
<script>
    import {mapGetters, mapState} from "vuex";
    import IndividualNumber from "../specimens/IndividualNumber";
    import axios from "axios";
    import {eventBus} from "../../eventBus";

    export default {
        name: 'specimen-canvas',
        components: {IndividualNumber},
        props: {
            default_specimen: { type: Object, default: null },
            heading: { type: String, default: "Specimen Canvas" },
            widgetsList: { type: [Object, Array], default: () => ([
                    { name: 'Specimen', width: 6, visible: true, expanded: true },
                    { name: 'DNA', width: 6, visible: false, expanded: true },
                    { name: 'Isotopes', width: 6, visible: false, expanded: true },
                    { name: 'Pathology', width: 6, visible: true, expanded: true },
                    { name: 'Measurements', width: 3, visible: true, expanded: true },
                    { name: 'Zones', width: 3, visible: true, expanded: true },
                    { name: 'Methods', width: 6, visible: true, expanded: true },
                    { name: 'Taphonomy', width: 3, visible: true, expanded: true },
                    { name: 'Tags', width: 3, visible: true, expanded: true }]
                )},
        },
        data() {
            return {
                loading: false,
                listSpecimens: [],
                accession_number: "",
                provenance1: "",
                provenance2: "",
                individual_number: "",
                selected_specimen_id: null,
                specimen: null,
                show_specimen: false,
                isCollapseAll: false,

                trail: [ { text: 'Home', disabled: false, href: '/', }, { text: 'Specimen Canvas', disabled: true,  href: "/" }, ],
                alert: false,
                alertText: "",

                // Show specimen components
                show_bio_profile: false,
                show_dna: false,
                show_isotope: false,
                show_measurement: false,
                show_zone: false,
                show_taphonomy: false,
                show_articulation: false,
                show_pair_match: false,
                show_refit: false,
                show_morphology: false,
                show_pathology: false,
                show_tag: false,
                show_comment: false,

                // Widgets and Draggable
                widgets:    localStorage.getItem("specimen-canvas-widgets") ?
                            JSON.parse(localStorage.getItem("specimen-canvas-widgets")) :
                            this.widgetsList,
            };
        },
        created() {
            console.log('Specimen Component created.');
            this.$store.dispatch('fetchProjectList', { 'type': 'accessions' }).then(() => this.loading = false);
            this.$store.dispatch('fetchProjectList', { 'type': 'provenance1' }).then(() => this.loading = false);
            this.$store.dispatch('fetchProjectList', { 'type': 'provenance2' }).then(() => this.loading = false);
            this.$store.dispatch('fetchProjectList', { 'type': 'anp1p2' }).then(() => this.loading = false);
            this.$store.dispatch('fetchProjectList', { 'type': 'individual-numbers' }).then(() => this.loading = false);
            // this.$store.dispatch('fetchProjectList', { 'type': 'specimens' }).then(() => this.loading = false);
        },
        mounted(){
            this.$store.commit('setListCount', 0);
            // Get unique values for an array of objects
            // this.listAccession = [...new Set(this.listAnP1P2.map(item => item.number))];
            // this.accession_number = (this.listAccession && this.listAccession.length) ? this.listAccession[0] : "";
            // this.listProvenance1 = [...new Set(this.listAnP1P2.map(item => item.provenance1))];
            // this.listProvenance1 = [...new Set(this.listAnP1P2.map(item => item.provenance2))];

            this.accession_number = (this.listAccession && this.listAccession.length) ? this.listAccession[0] : "";
            this.provenance1 = (this.listProvenance1 && this.listProvenance1.length) ? this.listProvenance1[0] : "";
            this.provenance2 = (this.listProvenance2 && this.listProvenance2.length) ? this.listProvenance2[0] : "";
            this.individual_number = (this.listIndividualNumbers && this.listIndividualNumbers.length) ? this.listIndividualNumbers[0] : "";
        },
        watch: {
            widgets: {
                deep: true,
                handler(list) {
                    localStorage.setItem("specimen-canvas-widgets", JSON.stringify(list));
                }
            },
        },
        methods: {
            getSpecimens() {
                this.loading = true;
                // Use this below for testing
                let url = '/api/projects/' + this.theProject.id + '/specimens/advanced-search?list=true';
                let params = {};
                (this.accession_number) ? params.an = [this.accession_number] : null;
                (this.provenance1) ? params.p1 = [this.provenance1] : null;
                (this.provenance2) ? params.p2 = [this.provenance2] : null;

                axios({ url: url, method: 'GET',
                    headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    params: params,
                })
                .then(response=>{
                    // For debugging purposes
                    console.log("data: " + JSON.stringify(response.data.data));
                    this.listSpecimens = response.data.data;
                    this.loading = false;
                })
                .catch((error) => {
                    console.log(error);
                    let payload = { 'text': 'Too many specimen, Please refine your search', 'color': 'error', };
                    eventBus.$emit('show-snackbar', payload);
                });
            },
            getSpecimen() {
                this.loading = true;
                let url = '/api/specimens/' + this.selected_specimen_id;
                console.log("getSpecimen url: "+url);
                axios({ url: url, method: 'GET',
                    headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, }
                })
                .then(response=>{
                    // For debugging purposes
                    console.log("data: " + JSON.stringify(response.data.data));
                    this.setSpecimen(response.data.data);
                    this.loading = false;
                })
                .catch((error) => {
                    console.log(error);
                });
            },
            expand(val) {
                // this.showForm = val;
            },
            search(val) {
                // this.showForm = val;
            },
            setSpecimen(item) {
                this.specimen = item;
                this.show_specimen = true;
                this.show_bio_profile = true;
                this.show_dna = true;
                this.show_isotope = true;
                this.show_measurement = true;
                this.show_zone = true;
                this.show_taphonomy = true;
                this.show_articulation = true;
                this.show_pair_match = true;
                this.show_refit = true;
                this.show_morphology = true;
                this.show_pathology = true;
                this.show_tag = true;
                this.show_comment = true;
            },
            widgetWidth(item) {
                return (item.width===12) ? 'col-12': (item.width===6) ? 'col-6': (item.width===4) ? 'col-4': (item.width===3) ? 'col-3': 'col-2';
            },
            resetWidgets() {
                this.$delete(this.widgets, {});
                this.widgetsList.forEach((widget, key) => {
                    this.$set(this.widgets, key, widget);
                });
                localStorage.setItem("specimen-canvas-widgets", JSON.stringify(this.widgets));
            },
            toggleCollapseAll() {
                this.isCollapseAll = !this.isCollapseAll;
                this.widgets.map(widget => {
                    widget.expanded = !widget.expanded;
                    return widget;
                });
            },
        },
        computed: {
            ...mapState({
                //
            }),
            ...mapGetters({
                theUser: 'theUser',
                theProject: 'theProject',
                listAccession: 'getProjectAccessions',
                listProvenance1: 'getProjectProvenance1',
                listProvenance2: 'getProjectProvenance2',
                listAnP1P2: 'getProjectAnP1P2',
                listIndividualNumbers: 'getProjectIndividualNumbers',
                // listSpecimens: 'getProjectSpecimens',
            }),
            edited() {
                // return JSON.stringify(this.form) !== JSON.stringify(this.initialFormData);
            },
            action() {
                const action = "View"; // ToDo: temporary hard-coded
                return { create: action === "Create", view: action === "View", edit: action === "Update" };
            },
        },
    };
</script>
