<template>
    <div class="m-2">
        <contentheader :trail="this.trail" model_name="org_dna" :reset_menu="true" @eventReset="reset" :collapse_menu="true"
                       :disable_generate="this.disable_generate" @eventCollapse="onExpand(false)" @eventExpand="onExpand(true)"
                       :generate_menu="true" :info_toolip="true" :info_toolip_text="text.report_help" @eventGenerate="generate" dusk="additional-information">
        </contentheader>
        <v-alert v-if="alert" class="my-1" border="left" colored-border type="info" elevation="2" dismissible>{{alertText}}</v-alert>
        <br>
        <v-card>
            <v-container fluid v-show="showReportCriteria">
                <v-row>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete  v-model="form.projects" :items="project_items" label="Projects" placeholder="Select Project" item-value="projectsValue" item-text="projectsText" dusk="dna-projects"
                                         multiple clearable chips deletable-chips></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.lab_id" :items="labOptions" label="Lab" placeholder="Select Lab" item-text="name" item-value="id" dusk="dna-lab"
                                        multiple clearable chips deletable-chips></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete label="Priority" placeholder="Select Priority" multiple clearable chips deletable-chips dusk="priority"></v-autocomplete>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.results_confidence" :items="resultConfidence" label="Results Status" placeholder="Select Results Status" dusk="dna-result-status"
                                        clearable chips></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.seqNum" :items="dnaSeqNumArray" :label="this.capitalizeDnaType(this.dna_type) + ' Sequence Number'" placeholder="Select Sequence Number" dusk="dna-sequence-number"
                                        item-text="text" item-value="text" :loading="loadingSeqNum" multiple clearable chips deletable-chips clearable></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.sequence_subgroup" :items="dnaSubGroupArray" :label="this.capitalizeDnaType(this.dna_type) + ' Sequence Subgroup'" placeholder="Select Subgroup" dusk="dna-subgroup"
                                        item-text="text" item-value="text" :loading="this.loadingSubGrp" clearable></v-autocomplete>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="3" sm="12">
                        <date v-model="form.request_date_start" label="Request Dates From" type="dnaStartDate" name="request_date_start" dusk="dna-request-date-start"></date>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <date v-model="form.request_date_end" label="Request Dates To" classList="" :minvalue="form.request_date_start" name="request_date_end" dusk="dna-request-date-end"></date>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="3" sm="12">
                        <date v-model="form.receive_date_start" label="Receive Dates From" name="receive_date_start" dusk="dna-receive-date-start"></date>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <date v-model="form.receive_date_end" label="Receive Dates To" :minvalue="form.receive_date_start" name="receive_date_end" dusk="dna-receive-date-end"></date>
                    </v-col>
                </v-row>
            </v-container>

            <div v-show="showTable">
                <v-row>
                    <v-col cols="9">
                        <v-btn-toggle v-model="toggle_multiple" dense multiple>
                            <v-btn dusk="excel">Excel</v-btn>
                            <v-menu right offset-x :close-on-content-click="false" max-height="500px">
                                <template v-slot:activator="{ on }">
                                    <v-btn v-on="on" dusk="column-visibility">Column Visibility<v-icon right>$dropdown</v-icon></v-btn>
                                </template>
                                <v-list>
                                    <v-list-item v-for="(header, index) in headers" :key="index">
                                        <v-checkbox v-bind:label="header.text" v-model="header.visibility" :value="header.visibility" :dusk="header.text"></v-checkbox>
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </v-btn-toggle>
                    </v-col>
                    <v-spacer></v-spacer>
                    <v-col cols="3">
                        <v-text-field v-model="search" label="Search" clearable append-icon="mdi-magnify" dusk="search-datatable"></v-text-field>
                    </v-col>
                </v-row>

                <v-data-table :headers="columnVisibility" :items="dnaItems" :items-per-page="perPage" :options.sync="options" :server-items-length="totalSearchCount"
                              calculate-widths="" class="elevation-1" :sort-by="['key']" multi-sort :search="search" :loading="loading"
                              :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }">
                    <template v-slot:item.key="{ item }"><a :href="`/skeletalelements/${item.se_id}`" target="_blank">{{ item.key }}</a></template>
                    <template v-slot:item.individual_number="{ item }"><a :href="`/reports/individualnumber/${item.individual_number}`" target="_blank">{{ item.individual_number }}</a></template>
                    <template v-slot:item.sample_number="{ item }"><a :href="`/skeletalelements/${item.se_id}/dnas/${item.dna_id}`" target="_blank">{{ item.sample_number }}</a></template>
                </v-data-table>
                <br>
            </div>
        </v-card>
    </div>
</template>

<script>
    import { mapGetters,mapState } from 'vuex';
    import { changeObjectToArray } from "../../../coraBaseModules";
    import { eventBus } from '../../../eventBus';
    import axios from "axios";
    export default {
        name: "org-dna-report",
        props: {
            dna_type: { type: String, required: true },
            text: {type: Object, default: () => {}}
        },
        data() {
            return {
                trail: [{ text: 'Home', disabled: false, href: '/'},
                    { text: 'Org Reports Dashboard', disabled: false, href: '/reports/org/dashboard' },
                    { text: 'Org ' + this.capitalizeDnaType(this.dna_type) + ' DNA Report', disabled: true, href: '/' + this.dna_type, },
                ],
                showReportCriteria: true,
                options: {},
                form: {},
                dnas: {},
                totalSearchCount:0,
                perPage:100,
                showTable: false,
                disable_generate: true,
                resultConfidence: [ 'Pending', 'Reportable', 'Inconclusive', 'Unable to Assign', 'Cancelled', 'No Results'],
                loadingSeqNum: false,
                loadingSubGrp: false,
                loadingProjects: false,
                projects:{},
                seqSubGrpData: {},
                seqNumData: {},
                headers: [
                    {text: 'Project', value: 'project_id', visibility: true},
                    {text: 'Key', value: 'key', visibility: true},
                    {text: 'Bone', value: 'bone', visibility: true},
                    {text: 'Side', value: 'side', visibility: true},
                    {text: 'Bone Group', value: 'bone_group', visibility: true},
                    {text: 'Individual Number', value: 'individual_number', visibility: true},
                    {text: 'Sample Number', value: 'sample_number', visibility: true},
                    {text: this.capitalizeDnaType(this.dna_type)+ ' Sequence Number', value: 'sequence_number', visibility: true},
                    {text: this.capitalizeDnaType(this.dna_type) + ' Sequence Subgroup', value: 'sequence_subgroup', visibility: true},
                    {text: this.capitalizeDnaType(this.dna_type) + ' Sequence Similar', value: 'sequence_similar', visibility: true},
                    {text: this.capitalizeDnaType(this.dna_type) + ' Result Status', value: 'result_status', visibility: true},
                    {text: this.capitalizeDnaType(this.dna_type) + ' Request Date', value: 'request_date', visibility: true},
                    {text: this.capitalizeDnaType(this.dna_type) + ' Receive Date', value: 'receive_date', visibility: true}
                ],
                toggle_multiple: [],
                loading: false,
                search: '',
                alert: true,
                alertText: "For results returned for multiple projects, reset the Current Project to match the project of specific keys or sample numbers to enable links in the results table.",
            }
        },
        watch: {
            options: {
                handler () {
                    this.generate();
                },
                deep: true,
            },
        },
        mounted() {
            this.getSeqNum();
            this.getSeqSubGrp();
            // this.getOrgProjects();
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
                            url: '/api/reports/orgs/' + this.theOrg.id + '/dna',
                            method: "GET",
                            params: {
                                type: this.dna_type, project_id: this.form.projects ? this.form.projects : null, lab_id: this.form.lab_id ? this.form.lab_id : null,
                                [this.dna_type + "_sequence_number_list"]: this.form.seqNum ? this.form.seqNum : null,
                                [this.dna_type + "_sequence_subgroup_list"]: this.form.sequence_subgroup ? [this.form.sequence_subgroup] : null,
                                [this.dna_type + "_results_confidence_list"]: this.form.results_confidence ? [this.form.results_confidence] : null,
                                [this.dna_type + "_request_date_start"]: this.form.request_date_start ? [this.form.request_date_start] : null,
                                [this.dna_type + "_request_date_end"]: this.form.request_date_end ? [this.form.request_date_end] : null,
                                [this.dna_type + "_receive_date_start"]: this.form.receive_date_start ? [this.form.receive_date_start] : null,
                                [this.dna_type + "_receive_date_end"]: this.form.receive_date_end ? [this.form.receive_date_end] : null,
                                page: this.options.page,
                                per_page: this.perPage
                            },
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': this.$store.getters.bearerToken
                            },
                        }).then(response => {
                        eventBus.$emit('generate-loading', false);
                        this.dnas = response.data.data;
                        this.showTable = true;
                        this.totalSearchCount = response.data.meta.total;
                    }).catch(error => {
                        // console.log(error);
                        eventBus.$emit('generate-loading', false);
                    })
                }
                else{
                    this.disable_generate =false;
                    eventBus.$emit('disable_generate', this.disable_generate);
                }
            },
            getSeqNum() {
                this.loadingSeqNum = true;
                this.form.seqNum = null;
                axios
                    .request({
                        url: '/api/orgs/' + this.theOrg.id + '/dnas/' + this.dna_type + '-sequence-numbers?list=true' ,
                        method: 'GET',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken },
                    }).then(response => {
                    this.seqNumData = response.data.data;
                    this.loadingSeqNum = false;
                }).catch(error => {
                    console.log(error);
                    this.loadingSeqNum = false;
                })
            },
            getSeqSubGrp() {
                this.loadingSubGrp = true;
                this.form.sequence_subgroup = null;
                axios
                    .request({
                        url: '/api/orgs/' + this.theOrg.id + '/dnas/' + this.dna_type + '-sequence-subgroups?list=true',
                        method: 'GET',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken },
                    }).then(response => {
                    this.seqSubGrpData = response.data.data;
                    this.loadingSubGrp = false;
                }).catch(error => {
                    // console.log(error);
                    this.loadingSubGrp = false;
                })
            },
            capitalizeDnaType(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            },
            getKey(item) {
                return `${item.accession_number ? item.accession_number : ''}:
                        ${item.provenance1 ? item.provenance1 : ''}:
                        ${item.provenance2 ? item.provenance2 : ''}:
                        ${item.designator ? item.designator : ''}`;
            },
        },
        computed: {
            columnVisibility(){
                return this.headers.filter(item => item.visibility === true);
            },
            dnaItems() {
                const rows = [];
                switch(this.dna_type) {
                    case 'mito':
                        Object.values(this.dnas).forEach(item =>
                            rows.push({
                                se_id: item.se_id,
                                dna_id: item.id,
                                project_id: this.getProjectNameById(item.project_id),
                                key: this.getKey(item),
                                bone: this.getBone(item.sb_id).name,
                                side: item.side,
                                bone_group: item.bone_group,
                                individual_number: item.individual_number,
                                sample_number: item.sample_number,
                                sequence_number: item.mito_sequence_number,
                                sequence_subgroup:item.mito_sequence_subgroup,
                                sequence_similar: item.mito_sequence_similar,
                                result_status: item.mito_results_confidence,
                                request_date: item.mito_request_date,
                                receive_date: item.mito_receive_date
                            })
                        );
                        break;
                    case 'austr':
                        Object.values(this.dnas).forEach(item =>
                            rows.push({
                                se_id: item.se_id,
                                dna_id: item.id,
                                project_id: this.getProjectNameById(item.project_id),
                                key: this.getKey(item),
                                bone: this.getBone(item.sb_id).name,
                                side: item.side,
                                bone_group: item.bone_group,
                                individual_number: item.individual_number,
                                sample_number: item.sample_number,
                                sequence_number: item.austr_sequence_number,
                                sequence_subgroup: item.austr_sequence_subgroup,
                                sequence_similar: item.austr_sequence_similar,
                                result_status: item.austr_results_confidence,
                                request_date: item.austr_request_date,
                                receive_date: item.austr_receive_date
                            })
                        );
                        break;
                    case 'ystr':
                        Object.values(this.dnas).forEach(item =>
                            rows.push({
                                se_id: item.se_id,
                                dna_id: item.id,
                                project_id: this.getProjectNameById(item.project_id),
                                key: this.getKey(item),
                                bone: this.getBone(item.sb_id).name,
                                side: item.side,
                                bone_group: item.bone_group,
                                individual_number: item.individual_number,
                                sample_number: item.sample_number,
                                sequence_number: item.ystr_sequence_number,
                                sequence_subgroup: item.ystr_sequence_subgroup,
                                sequence_similar: item.ystr_sequence_similar,
                                result_status: item.ystr_results_confidence,
                                request_date: item.ystr_request_date,
                                receive_date: item.ystr_receive_date
                            })
                        );
                        break;
                }
                return rows;
            },
            ...mapState({
                rowsPerPageItems: state => state.search.rowsPerPageItems,
            }),
            ...mapGetters({
                project_items: 'getProjectsIdNameArray',
                getProjectNameById: 'getProjectNameById',
                theOrg: 'theOrg',
                getLabs: 'getLabs',
                getBone: 'getBone'
            }),
            labOptions() {
                let type = 'Genomics';
                return this.getLabs(type);
            },
            // orgProjects() {
            //     return changeObjectToArray(this.projects);
            // },
            dnaSeqNumArray() {
                return changeObjectToArray(this.seqNumData);
            },
            dnaSubGroupArray() {
                return changeObjectToArray(this.seqSubGrpData);
            },
        }
    }
</script>
