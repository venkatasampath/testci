<template>
    <div class="m-2">
        <contentheader :trail="this.trail" model_name="project_dna" :reset_menu="true" @eventReset="reset" :collapse_menu="true"
                       @eventCollapse="onExpand(false)" :disable_generate="this.disable_generate" @eventExpand="onExpand(true)"
                       :generate_menu="true" :info_toolip="true" :info_toolip_text="text.report_help" @eventGenerate="generate">
        </contentheader>
        <br>
        <v-card>
            <v-container fluid v-show="showReportCriteria">
                <v-row>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.an" :items="items_accessions" label="Accession Number" placeholder="Select Accession Number" clearable dusk="accession"></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.p1" :items="items_provenance1" label="Provenance 1" placeholder="Select Provenance 1" clearable dusk="provenance1"></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.p2" :items="items_provenance2" label="Provenance 2" placeholder="Select Provenance 2" clearable dusk="provenance2"></v-autocomplete>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.results_confidence" :items="resultConfidence" label="Results Status" placeholder="Select Results Status" clearable dusk="results-status"></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.seqNum" :items="dnaSeqNumArray" :label="this.capitalizeDnaType(this.dna_type) + ' Sequence Number'" placeholder="Select Sequence Number"
                                        item-text="text" item-value="text" :loading="loadingSeqNum" multiple clearable chips deletable-chips clearable dusk="sequence-number"></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.sequence_subgroup" :items="dnaSubGroupArray" :label="this.capitalizeDnaType(this.dna_type) + ' Sequence Subgroup'" placeholder="Select Subgroup"
                                        item-text="text" item-value="text" multiple chips deletable-chips :loading="this.loadingSubGrp" clearable dusk="sequence-subgroup"></v-autocomplete>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="3" sm="12">
                        <date v-model="form.request_date_start" label="Request Dates From" name="request_date_start" dusk="request-dates-from"></date>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <date v-model="form.request_date_end" label="Request Dates To" :minvalue="form.request_date_start" name="request_date_end" dusk="request-date-end"></date>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="3" sm="12">
                        <date v-model="form.receive_date_start" label="Receive Dates From"  name="receive_date_start" dusk="receive-date-start"></date>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <date v-model="form.receive_date_end" label="Receive Dates To" :minvalue="form.receive_date_start" name="receive_date_end" dusk="receive-date-end"></date>
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
                    <template v-slot:item.individual_number="{ item }"><a :href="`/reports/individualnumberdetails/${item.individual_number}`" target="_blank">{{ item.individual_number }}</a></template>
                    <template v-slot:item.sample_number="{ item }"><a :href="`/skeletalelements/${item.se_id}/dnas/${item.dna_id}`" target="_blank">{{ item.sample_number }}</a></template>
                    <template v-slot:item.mito_sequence_number="{ item }"><a :href="`/reports/mtdna/${item.mito_sequence_number}`" target="_blank">{{ item.mito_sequence_number }}</a></template>
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
        name: "project-dna-report",
        props: {
            dna_type: { type: String, required: true },
            text: {type: Object, default: () => {}},
        },
        data() {
            return {
                trail: [{ text: 'Home', disabled: false, href: '/'},
                    { text: 'Reports Dashboard', disabled: false, href: '/reports/dashboard' },
                    { text:  this.capitalizeDnaType(this.dna_type) + ' DNA Report', disabled: true, href: '/' + this.dna_type,  },
                ],
                showReportCriteria: true,
                form: {},
                dnas: {},
                options: {},
                totalSearchCount:0,
                perPage:100,
                showTable: false,
                disable_generate: true,
                resultConfidence: [ 'Pending', 'Reportable', 'Inconclusive', 'Unable to Assign', 'Cancelled', 'No Results'],
                loadingSeqNum: false,
                loadingSubGrp: false,
                seqSubGrpData: {},
                seqNumData: {},
                toggle_multiple: [],
                headers: [
                    {text: 'Key', value: 'key', visibility: true},
                    {text: 'Bone', value: 'bone', visibility: true},
                    {text: 'Side', value: 'side', visibility: true},
                    {text: 'Bone Group', value: 'bone_group', visibility: true},
                    {text: 'Individual Number', value: 'individual_number', visibility: true},
                    {text: 'Sample Number', value: 'sample_number', visibility: true},
                    {text: this.capitalizeDnaType(this.dna_type) + ' Sequence Number', value: 'sequence_number', visibility: true},
                    {text: this.capitalizeDnaType(this.dna_type) + ' Sequence Subgroup', value: 'sequence_subgroup', visibility: true},
                    {text: this.capitalizeDnaType(this.dna_type) + ' Sequence Similar', value: 'sequence_similar', visibility: true},
                    {text: this.capitalizeDnaType(this.dna_type) + ' Result Status', value: 'result_status', visibility: true},
                    {text: this.capitalizeDnaType(this.dna_type) + ' Request Date', value: 'request_date', visibility: true},
                    {text: this.capitalizeDnaType(this.dna_type) + ' Receive Date', value: 'receive_date', visibility: true}
                ],
                items: [],
                loading: false,
                search: '',
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
            console.log("MitoSeq prop: ",this.text.mitoSeqList);
            if(this.text.mitoSeqList) {
                this.form.seqNum = [this.text.mitoSeqList];
                console.log("MitoSeq form", this.form.seqNum);
                this.generate()
            }
            if(this.text.austrSeqList) {
            this.form.seqNum = [this.text.austrSeqList];
            console.log("AustrSeq form", this.form.seqNum);
            this.generate()
            }
            if(this.text.ystrSeqList) {
              this.form.seqNum = [this.text.ystrSeqList];
              console.log("YstrSeq form", this.form.seqNum);
              this.generate()
            }
        },
        methods: {
            reset() {
                this.form = {};
                this.showTable = false;
            },
            onExpand(val) {
                this.showReportCriteria = val;
            },
            generate() {
                if(!this.disable_generate) {
                    eventBus.$emit('generate-loading', true);
                    console.log("options: " + JSON.stringify(this.options));
                    this.showTable = false;
                    axios
                        .request({
                            url: '/api/reports/projects/' + this.project_id + '/dna',
                            method: "GET",
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': this.$store.getters.bearerToken
                            },
                            params: {
                                type: this.dna_type,
                                [this.dna_type + "_sequence_number_list"]: this.form.seqNum ? this.form.seqNum : null,
                                [this.dna_type + "_sequence_subgroup_list"]: this.form.sequence_subgroup ? this.form.sequence_subgroup : null,
                                [this.dna_type + "_results_confidence_list"]: this.form.results_confidence ? [this.form.results_confidence] : null,
                                an: this.form.an ? [this.form.an] : null,
                                p1: this.form.p1 ? [this.form.p1] : null,
                                p2: this.form.p2 ? [this.form.p2] : null,
                                [this.dna_type + "_request_date_start"]: this.form.request_date_start ? [this.form.request_date_start] : null,
                                [this.dna_type + "_request_date_end"]: this.form.request_date_end ? [this.form.request_date_end] : null,
                                [this.dna_type + "_receive_date_start"]: this.form.receive_date_start ? [this.form.receive_date_start] : null,
                                [this.dna_type + "_receive_date_end"]: this.form.receive_date_end ? [this.form.receive_date_end] : null,
                                page: this.options.page,
                                per_page: this.options.itemsPerPage
                            }
                        }).then(response => {
                        eventBus.$emit('generate-loading', false);
                        this.dnas = response.data.data;
                        this.totalSearchCount = response.data.meta.total;
                        this.showTable = true;
                    }).catch(error => {
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
                        url: '/api/projects/' + this.project_id + '/dnas/' + this.dna_type + '-sequence-numbers?list=true' ,
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
                        url: '/api/projects/' + this.project_id + '/dnas/' + this.dna_type + '-sequence-subgroups?list=true',
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
                items_accessions: 'getProjectAccessions',
                items_provenance1: 'getProjectProvenance1',
                items_provenance2: 'getProjectProvenance2',
                project_id: 'theProjectId',
                getBone: 'getBone',
            }),
            dnaSeqNumArray() {
                return changeObjectToArray(this.seqNumData);
            },
            dnaSubGroupArray() {
                return changeObjectToArray(this.seqSubGrpData);
            },
        },
    }
</script>