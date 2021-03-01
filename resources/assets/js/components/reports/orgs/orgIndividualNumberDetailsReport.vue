<template>
    <div class="m-2">
        <contentheader :trail="this.trail" model_name="org_individual_number_details" :reset_menu="true" @eventReset="reset"
                       :collapse_menu="true" @eventCollapse="onExpand(false)" @eventExpand="onExpand(true)"
                       :generate_menu="true" :disable_generate="this.disable_generate" @eventGenerate="generate"
                       :info_toolip="true" :info_toolip_text="text.report_help">
        </contentheader>
        <v-alert v-if="alert" class="my-1" border="left" colored-border type="info" elevation="2" dismissible>{{alertText}}</v-alert>
        <br>
        <v-card>
            <v-container fluid v-show="showReportCriteria">
                <v-row>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete  v-model="form.projects" :items="project_items" label="Projects" placeholder="Select Project" item-value="projectsValue" item-text="projectsText"
                                     multiple clearable chips deletable-chips></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.individual_number" :items="items_inumber" :rules="rules.inum" :disabled="disable_inum" multiple chips deletable-chips label="Individual Number" placeholder="Select Individual Number" clearable
                                        :hint="hint.inumber" persistent-hint>
                        </v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.sb_id" :items="items_bones" :rules="rules.sb_id" :disabled="disable_boneSide"
                                        multiple chips deletable-chips item-text="name" item-value="id" label="Bone" placeholder="Select Bone" dusk="se-bone" clearable></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.side" :items="items_side" :disabled="disable_boneSide" label="Side" placeholder="Select Side" clearable></v-autocomplete>
                    </v-col>
                </v-row>
            </v-container>
            <div v-show="showTable">
                <v-row>
                    <v-col cols="9">
                        <v-btn-toggle v-model="toggleMultiple" dense dark multiple>
                            <v-btn dusk="excel">Excel</v-btn>
                            <v-menu right offset-x :close-on-content-click="false" max-height="500px">
                                <template v-slot:activator="{ on }">
                                    <v-btn v-on="on" dusk="column-visibility">
                                        Column Visibility
                                        <v-icon right>$dropdown</v-icon>
                                    </v-btn>
                                </template>

                                <v-list>
                                    <v-list-item v-for="(header, index) in headers" :key="index">
                                        <v-checkbox
                                                v-bind:label="header.text"
                                                v-model="header.visibility"
                                                :value="header.visibility"
                                                :dusk="header.text"
                                        />
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </v-btn-toggle>
                    </v-col>

                    <v-spacer />

                    <v-col cols="3">
                        <v-text-field v-model="search" label="Search" single-line hide-details />
                    </v-col>
                </v-row>

                <v-data-table :headers="columnVisibility" :items="specimenItems" :items-per-page="perPage" :options.sync="options" :server-items-length="totalSearchCount"
                              calculate-widths="" class="elevation-1" :sort-by="['key']" multi-sort :search="search"
                              :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }">
                    <template v-slot:item.key="{ item }">
                        <a :href="`/skeletalelements/${item.id}`" target="_blank">{{ item.key }}</a>
                    </template>

                    <template v-slot:item.dna_sampled="{ item }">
                        <template v-if="item.dna_sampled">
                            <a
                                    class="mx-1"
                                    v-for="(dna, index) in item.dnas"
                                    :key="index"
                                    :href="`/skeletalelements/${item.id}/dnas/${dna.id}`"
                                    target="_blank"
                            >{{ dna.sample_number }}</a>
                        </template>
                    </template>
                </v-data-table>
            </div>
            <v-snackbar v-model="snackbar.show" top  centered :color="snackbar.color" @close="snackbar = false">{{snackbar.message}}</v-snackbar>
        </v-card>
    </div>
</template>

<script>
    import {mapState, mapGetters} from 'vuex';
    import { eventBus } from '../../../eventBus';
    import axios from "axios";
    export default {
        name: "orgIndividualNumberDetailsReport",
        props:{
            text: {
                type: Object,
                default: () => {
                }
            }
        },
        data() {
            return {
                trail: [{ text: 'Home', disabled: false, href: '/'},
                    { text: 'Org Reports Dashboard', disabled: false, href: '/reports/org/dashboard' },
                    { text:  'Org Specimen by Individual Number Details Report', disabled: true, href: 'reports/org/IndividualNumberDetails'},
                ],
                showReportCriteria: true,
                form: {},
                disable_inum: false,
                disable_boneSide: false,
                disable_generate: true,
                showTable: false,
                items_side: ["Left", "Right", "Middle", "Unsided"],
                rules: {
                    inum: [ v => !!v || 'Individual number is required' ],
                    sb_id: [ v => !!v || 'Bone is required' ],
                },
                hint: {
                inumber: "Individual number or bone is required",
                },
                snackbar: {
                    show: false,
                    message: null,
                    color: null
                },
                specimens:{},
                totalSearchCount:0,
                perPage:100,
                options:{},
                loading: false,
                // loadingProjects: false,
                // projects:{},
                project_id: {},
                headers: [
                    {text: 'Project', value: 'project_id', visibility: true},
                    { text: "Key", value: "key", visibility: true, width: "12rem" },
                    {
                        text: "Individual Number",
                        value: "individual_number",
                        visibility: true
                    },
                    { text: "Bone", value: "bone", visibility: true, width: "12rem" },
                    { text: "Side", value: "side", visibility: true },
                    { text: "DNA Sample Number", value: "dna_sampled", visibility: true },
                    {
                        text: "DNA Sequence Number",
                        value: "dna_sequence_number",
                        visibility: true
                    },
                    { text: "Traumas", value: "traumas", visibility: true },
                    { text: "Pathologies", value: "pathologies", visibility: true },
                    { text: "Anomalies", value: "anomalies", visibility: true }
                ],
                search: "",
                toggleMultiple: [],
                alert: true,
                alertText: "For results returned for multiple projects, reset the Current Project to match the project of specific keys or DNA Sample Numbers to enable links in the results table.",
            }
        },
        watch: {
            options: {
                handler () {
                    this.generate()
                },
                deep: true,
            },
            'form.individual_number'() {
                let name = 'inumber';
                this.toggleDisable(name)
            },
            'form.sb_id'() {
                let name = 'bone';
                this.toggleDisable(name)
            },
        },
        methods: {
            reset() {
                this.form = {};
                this.showTable = false;
            },
            onExpand(val) {
                this.showReportCriteria = val;
            },
            generate(){
                if (!this.disable_generate) {
                    eventBus.$emit('generate-loading', true);
                    this.showTable = false;
                    axios
                        .request({
                            url: '/api/reports/orgs/' + this.theOrg.id + '/individualnumberdetails',
                            method: "GET",
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': this.$store.getters.bearerToken
                            },
                            params: {
                                project_id: this.form.projects ? this.form.projects : null,
                                an: this.form.an ? [this.form.an] : null,
                                p1: this.form.p1 ? [this.form.p1] : null,
                                p2: this.form.p2 ? [this.form.p2] : null,
                                individual_number: this.form.individual_number ? this.form.individual_number : null,
                                sb_select: this.form.sb_id ? this.form.sb_id : null,
                                side_select: this.form.side ? [this.form.side] : null,
                                page: this.options.page,
                                per_page: this.perPage
                            }
                        }).then(response => {
                        eventBus.$emit('generate-loading', false);
                        this.showTable = true;
                        this.specimens = response.data.data;
                        this.totalSearchCount = response.data.meta.total;
                    }).catch(error => {
                        console.log(error);
                        this.showTable = false;
                        eventBus.$emit('generate-loading', false);
                    })
                }
                else{
                    this.disable_generate =false;
                    eventBus.$emit('disable_generate', this.disable_generate);
                }
            },
            toggleDisable(name){
                if (name === "inumber"){
                    if (this.form.individual_number.length > 0){
                        this.disable_boneSide = true;
                        this.disable_generate = false;
                        eventBus.$emit('disable_generate', this.disable_generate);
                    }
                    else{
                        this.disable_boneSide = false;
                        this.disable_generate = true;
                        eventBus.$emit('disable_generate', this.disable_generate);
                    }
                }
                else{
                    if (this.form.sb_id.length > 0){
                        this.disable_inum = true;
                        this.disable_generate = false;
                        eventBus.$emit('disable_generate', this.disable_generate);
                    }
                    if (this.form.sb_id.length === 0) {
                        this.disable_inum = false;
                        this.disable_generate = true;
                        eventBus.$emit('disable_generate', this.disable_generate);
                    }
                }
            },
            getKey(item) {
                return `${item.accession_number ? item.accession_number : ""}:${
                    item.provenance1 ? item.provenance1 : ""
                    }:${item.provenance2 ? item.provenance2 : ""}:${
                    item.designator ? item.designator : ""
                    }`;
            },
            getBooleanIcon(item) {
                return item === true ? "✔" : "";
            },
            getIconColor(item) {
                return item === true ? "success" : "";
            }
        },
        computed: {
            ...mapState({
                rowsPerPageItems: state => state.search.rowsPerPageItems,
            }),
            ...mapGetters({
                project_items: 'getProjectsIdNameArray',
                getProjectNameById: 'getProjectNameById',
                items_accessions: 'getProjectAccessions',
                items_provenance1: 'getProjectProvenance1',
                items_provenance2: 'getProjectProvenance2',
                theOrg: 'theOrg',
                items_bones: 'getBones',
                getBone: 'getBone',
                items_inumber: 'getProjectIndividualNumbers',
             }),
            specimenItems() {
                const rows = [];
                Object.values(this.specimens).forEach(item =>
                    rows.push({
                        project_id: this.getProjectNameById(item.project_id),
                        id: item.id,
                        key: this.getKey(item),
                        individual_number: item.individual_number,
                        bone:item.sb.name,
                        side: item.side,
                        dna_sampled: item.dna_sampled ? item.dna_sampled : "",
                        dnas: item.dnas,
                        dna_sequence_number: item.mito_sequence_number,
                        traumas: item.uniquetraumaslist ? item.uniquetraumaslist : null,
                        pathologies: item.uniquepathologyslist ? item.uniquepathologyslist : null,
                        anomalies: item.uniqueanomalyslist ? item.uniqueanomalyslist : null
                    })
                );
                return rows;
            },
            columnVisibility() {
                return this.headers.filter(item => item.visibility === true);
            }
        },
    }
</script>