<template>
    <div class="m-2">
        <contentheader :trail="this.trail" model_name="project_anomaly" :reset_menu="true" @eventReset="reset"
                       :collapse_menu="true" @eventCollapse="onExpand(false)" @eventExpand="onExpand(true)"
                       :generate_menu="true" :disable_generate="this.disable_generate" @eventGenerate="generate">
            :info_tooltip="true" :info_tooltip_text="text.report_help">
        </contentheader>
        <br>
        <v-card>
            <v-container fluid v-show="showReportCriteria">
                <v-row>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.an" :items="items_accessions" label="Accession Number" clearable placeholder="Select Accession Number" dusk="accessions"></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.p1" :items="items_provenance1" label="Provenance 1" clearable placeholder="Select Provenance 1" dusk="provenance1"></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.p2" :items="items_provenance2" label="Provenance 2" clearable placeholder="Select Provenance 2" dusk="provenance2"></v-autocomplete>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.sb_select" :items="items_bones" item-value="id" :loading="loading" :@change="getAnomaliesByBone1" item-text="name" label="Bone" clearable placeholder="Select Bone" dusk="bone"></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.side" :items="items_side"  @change="toggleDisable('side')" label="Side" clearable placeholder="Select Side" dusk="side"></v-autocomplete>
                    </v-col>
                </v-row>
                <v-row>
                </v-row>
                <v-row>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.anomaly_select" :items="anomalies"  @change="toggleDisable('anomaly')" item-value="id" item-text="individuating_trait" label="Anomaly" multiple chips deletable-chips placeholder="Select Anomaly" dusk="anomaly"></v-autocomplete>
                    </v-col>
                </v-row>
            </v-container>
            <div v-show="showTable">
                <v-row>
                    <v-col cols="9">
                        <v-btn-toggle v-model="toggleMultiple" dense multiple>
                            <v-btn dusk="excel">Excel</v-btn>
                            <v-menu right offset-x :close-on-content-click="false" max-height="500px">
                                <template v-slot:activator="{ on }">
                                    <v-btn v-on="on" dusk="column-visibility">Column Visibility <v-icon right>$dropdown</v-icon></v-btn>
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
                <v-data-table :headers="columnVisibility" :items="specimenItems" :items-per-page="perPage" :options.sync="options" :server-items-length="totalSearchCount"
                              calculate-widths="" class="elevation-1" :sort-by="['key']" multi-sort :search="search" :loading="loading"
                              :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }">
                    <template v-slot:item.key="{ item }">
                        <a :href="`/skeletalelements/${item.se_id}`" target="_blank" >{{ item.key }}</a>
                    </template>
                </v-data-table>
                <br>
            </div>
        </v-card>
    </div>
</template>

<script>
    import {mapState, mapGetters} from 'vuex';
    import { eventBus } from '../../../eventBus';
    import axios from "axios";

    export default {
        name: "projectAnomalyReport",
        props: {
            text: { type: Object, default: () => {} }
        },
        data() {
            return {
                trail: [{ text: 'Home', disabled: false, href: '/'},
                    { text: 'Reports Dashboard', disabled: false, href: '/reports/dashboard' },
                    { text:  'Anomaly Report', disabled: true, href: '/anomaly', },
                ],
                showReportCriteria: true,
                form: {},
                anomalylist: [],
                skeletalAnomalies: {},
                skeletalElements: {},
                showTable: false,
                totalSearchCount: 0,
                anomalies: [],
                headers:[
                    {text: 'Key', value: 'key', visibility: true},
                    {text: 'Bone', value: 'bone', visibility: true},
                    {text: 'Side', value: 'side', visibility: true},
                ],
                anomaly_select:[],
                disable_generate: true,
                items_side: ["Left", "Right", "Middle", "Unsided"],
                search: "",
                toggleMultiple: [],
                perPage:100,
                options:{},
                loading: false,
                anomalyColumns:[]
            }
        },
        watch: {
            options: {
                handler() {
                    this.generate()
                },
                deep: true,
            },
        },
        mounted() {
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
                if (!this.disable_generate) {
                    eventBus.$emit('generate-loading', true);
                    this.showTable = false;
                    axios
                        .request({
                            url: '/api/reports/projects/' + this.project_id + '/anomaly',
                            method: "GET",
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': this.$store.getters.bearerToken
                            },
                            params: {
                                an: this.form.an ? [this.form.an] : null,
                                p1: this.form.p1 ? [this.form.p1] : null,
                                p2: this.form.p2 ? [this.form.p2] : null,
                                anomaly_select: this.form.anomaly_select ? this.form.anomaly_select : null,
                                sb_select: this.form.sb_select ? this.form.sb_select : null,
                                side_select: this.form.side ? [this.form.side] : null,
                                page: this.options.page,
                                per_page: this.perPage
                            }
                        }).then(response => {
                        eventBus.$emit('generate-loading', false);
                        this.skeletalElements = response.data.data;
                        this.totalSearchCount = response.data.meta.total;
                        this.skeletalAnomalies = response.data.skeletal_anomaly;
                        this.getHeaders();
                        this.showTable = true;
                    }).catch(error => {
                        // console.log(error);
                        // this.showTable = false;
                        eventBus.$emit('generate-loading', false);
                    })
                } else {
                    this.disable_generate = false;
                    eventBus.$emit('disable_generate', this.disable_generate);
                }
            },
            getKey(item) {
                return `${item.accession_number ? item.accession_number : ""}:${
                    item.provenance1 ? item.provenance1 : ""
                    }:${item.provenance2 ? item.provenance2 : ""}:${
                    item.designator ? item.designator : ""
                    }`;
            },
            getKeyByValue(object, value) {
                return Object.keys(object).find(key => object[key] === value);
            },
            getHeaders() {
                this.headers.splice(3, 1000);
                this.anomalys = [];
                //if bone/side selected
                if (this.skeletalAnomalies != null) {
                    Object.values(this.skeletalAnomalies).forEach(skeletalAnomaly =>
                        this.headers.push({
                            text: skeletalAnomaly,
                            value: skeletalAnomaly,
                            visibility: true
                        }));
                } else {
                    //anomaly selected
                    let anomalys = [];
                    this.form.anomaly_select.forEach(item =>
                        Object.values(this.anomalies).forEach(se => {
                            if(item === se.id){
                                if(anomalys.indexOf(se.individuating_trait) === -1){
                                    anomalys.push(se.individuating_trait);
                                    this.headers.push({
                                        text: se.individuating_trait,
                                        value: se.individuating_trait,
                                        visibility: true
                                    })
                                }
                            }
                        })
                    );
                    this.anomalylist = anomalys;

                }
            }
    },
    computed: {
    ...mapState({
            rowsPerPageItems: state => state.search.rowsPerPageItems,
        }),
    ...mapGetters({
            items_accessions: 'getProjectAccessions',
            items_provenance1: 'getProjectProvenance1',
            items_provenance2: 'getProjectProvenance2',
            items_bones: 'getBones',
            project_id: 'theProjectId',
            items_anomaly: 'getAnomaliesByBone',
            anomaly1: 'getAnomalies',
            getBone: 'getBone',
        }),
            getBooleanIcon(item) {
            return item === true ? "✔" : "";
        },

        getIconColor(item) {
            return item === true ? "success" : "";
        },
        getAnomaliesByBone1() {
            if (typeof(this.form.sb_select) !== 'undefined' || this.form.sb_select !== null) {
                this.anomalies = this.items_anomaly(this.form.sb_select);
            }
            if(typeof(this.form.sb_select) == 'undefined' || this.form.sb_select == null) {
                this.anomalies = this.anomaly1
            }
        },
        specimenItems() {
            const rows = [];
            Object.values(this.skeletalElements).forEach(item => {
                let anomalyColumns = {};
                if (this.skeletalAnomalies != null) {
                    Object.values(this.skeletalAnomalies).forEach(
                        skeletalAnomaly => {
                            let keyValue = Number(this.getKeyByValue(this.skeletalAnomalies, skeletalAnomaly));
                            if (keyValue === item.anomaly_id){
                                (anomalyColumns[skeletalAnomaly] =   '✔' )
                            }}

                    )}else{
                    item.anomalys.forEach(se =>
                        this.anomalylist.forEach(skeletalAnomaly => {
                            if (skeletalAnomaly === se.individuating_trait) {
                                anomalyColumns[skeletalAnomaly] = '✔'
                            }
                        }))
                }

                rows.push({
                    se_id: item.id,
                    key: this.getKey(item),
                    bone: this.getBone(item.sb_id).name,
                    side: item.side,
                    ...anomalyColumns,
                });
            });
            return rows;
        },
        columnVisibility() {
            return this.headers.filter(item => item.visibility === true);
        }
    },
    }
</script>