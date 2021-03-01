<template>
    <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition" width="600" style="align-content:center" persistent>
        <v-card :elevation="10">
            <v-toolbar dark color="primary">
                <v-toolbar-title>{{title}}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn icon dark @click="closeTab"><v-icon>mdi-close</v-icon></v-btn>
            </v-toolbar>
            <v-tabs centered>
                <v-tab><v-icon left>mdi-bone</v-icon>Specimens</v-tab>
                <v-tab><v-icon left>mdi-map-marker-radius</v-icon>Accessions</v-tab>
                <v-tab><v-icon left>mdi-calendar</v-icon>Dates</v-tab>
                <v-tab-item>
                    <v-card>
                        <v-row>
                            <v-col cols="9">
                                <v-btn-toggle v-model="toggle_multiple" dense multiple>
                                    <v-btn>Excel</v-btn>
                                    <v-menu right offset-x :close-on-content-click="false" max-height="500px">
                                        <template v-slot:activator="{ on }">
                                            <v-btn v-on="on">Column Visibility<v-icon right>$dropdown</v-icon></v-btn>
                                        </template>
                                        <v-list>
                                            <v-list-item v-for="(header, index) in headers" :key="index">
                                                <v-checkbox v-bind:label="header.text" v-model="header.visibility" :value="header.visibility"/>
                                            </v-list-item>
                                        </v-list>
                                    </v-menu>
                                </v-btn-toggle>
                            </v-col>
                            <v-col cols="3"><v-text-field v-model="search" label="Search" clearable append-icon="mdi-magnify" dusk="search-datatable"/></v-col>
                        </v-row>
                        <v-data-table :headers="columnVisibility" :items="items" :items-per-page="perPage" :options.sync="options" :server-items-length="totalSearchCount"
                                      calculate-widths="" class="elevation-1" :sort-by="['key']" :search="search" :loading="loading"
                                      :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }">
                            <template v-slot:item.key="{ item }"><a :href="`/skeletalelements/${item.se_id}`" target="_blank">{{ item.key }}</a></template>
                            <template v-slot:item.individual_number="{ item }"><a :href="`/reports/individualnumber/${item.individual_number}`" target="_blank">{{ item.individual_number }}</a></template>
                            <template v-slot:item.sample_number="{ item }"><a :href="`/skeletalelements/${item.se_id}/dnas/${item.dna_id}`" target="_blank">{{ item.sample_number }}</a></template>
                            <template v-slot:item.mito_sequence_number="{ item }"><a :href="`/reports/mtdna/`" target="_blank">{{ item.mito_sequence_number }}</a></template>
                            <template v-slot:item.measured="{ item }"><v-icon right :color="checkColor(item.measured)">{{ displayCheck(item.measured) }}</v-icon></template>
                            <template v-slot:item.isotope_sampled="{ item }"><v-icon right :color="checkColor(item.isotope_sampled)">{{ displayCheck(item.isotope_sampled) }}</v-icon></template>
                            <template v-slot:item.clavicle_triage="{ item }"><v-icon right :color="checkColor(item.clavicle_triage)">{{ displayCheck(item.clavicle_triage) }}</v-icon></template>
                            <template v-slot:item.ct_scanned="{ item }"><v-icon right :color="checkColor(item.ct_scanned)">{{ displayCheck(item.ct_scanned) }}</v-icon></template>
                            <template v-slot:item.xray_scanned="{ item }"><v-icon right :color="checkColor(item.xray_scanned)">{{ displayCheck(item.xray_scanned) }}</v-icon></template>
                            <template v-slot:item.inventoried="{ item }"><v-icon right :color="checkColor(item.inventoried)">{{ displayCheck(item.inventoried) }}</v-icon></template>
                            <template v-slot:item.reviewed="{ item }"><v-icon right :color="checkColor(item.reviewed)">{{ displayCheck(item.reviewed) }}</v-icon></template>
                        </v-data-table>
                    </v-card>
                </v-tab-item>
                <v-tab-item>
                    <v-card class="m-2 p-2">
                        <v-row class="align-center" v-if="accessions.length">
                            <v-chip v-for="item in accessions" v-bind:key="item" ref="item" class="m-2 p-2">{{item}}</v-chip>
                        </v-row>
                        <v-row v-else>No Data Available</v-row>
                    </v-card>
                </v-tab-item>
                <v-tab-item>
                    <v-card class="m-2 p-2">
                        <v-row class="align-center" v-if="dates.length">
                            <v-chip v-for="item in dates" v-bind:key="item" ref="item" class="m-2 p-2">{{item}}</v-chip>
                        </v-row>
                        <v-row v-else>No Data Available</v-row>
                    </v-card>
                </v-tab-item>
            </v-tabs>
        </v-card>
    </v-dialog>
</template>
<script>
import {mapState, mapGetters, mapActions} from 'vuex';
import {eventBus} from "../../../eventBus";
import axios from 'axios';

export default {
    name: "cabanatuanDetails",
    data() {
        return {
            loading: false,
            title: "Common Grave",
            payload: null,
            dialog: false,
            accessions: [],
            dates: [],
            items: [],
            options:{},
            headers: [
                {text: 'Key', value: 'key', width: '10rem', visibility: true},
                {text: 'Bone', value: 'skeletalbone', width: '6rem', visibility: true},
                {text: 'Side', value: 'side', width: '6rem', visibility: true},
                {text: 'Bone Group', value: 'bone_group', width: '6rem', visibility: true},
                {text: 'Individual Number', value: 'individual_number', width: '10rem', visibility: true},
                {text: 'DNA Sample Number', value: 'sample_number', width: '6rem', visibility: true},
                {text: 'Mito Sequence Number', value: 'mito_sequence_number', width: '6rem', visibility: true},
                {text: 'Measured', value: 'measured', width: '6rem', visibility: true},
                {text: 'Isotope Sampled', value: 'isotope_sampled', width: '6rem', visibility: true},
                {text: 'Clavicle Triage', value: 'clavicle_triage', width: '6rem', visibility: true},
                {text: 'CT Scanned', value: 'ct_scanned', width: '6rem', visibility: false},
                {text: 'Xray Scanned', value: 'xray_scanned', width: '6rem', visibility: false},
                {text: 'Inventoried', value: 'inventoried', width: '6rem', visibility: false},
                {text: 'Reviewed', value: 'reviewed', width: '6rem', visibility: false},
                {text: 'Inventoried By', value: 'inventoried_by', width: '6rem', visibility: false},
                {text: 'Inventoried At', value: 'inventoried_at', width: '6rem', visibility: false},
                {text: 'Reviewed By', value: 'reviewed_by', width: '6rem', visibility: false},
                {text: 'Reviewed At', value: 'reviewed_at', width: '6rem', visibility: false},
                {text: 'Created By', value: 'created_by', width: '6rem', visibility: false},
                {text: 'Created At', value: 'created_at', width: '6rem', visibility: false},
                {text: 'Updated By', value: 'updated_by', width: '6rem', visibility: false},
                {text: 'Updated At', value: 'updated_at', width: '6rem', visibility: false},
            ],
            search: '',
            toggle_multiple: [],

            // --- new
            pagination: {
                descending: true,
                page: 1,
                rowsPerPage: 10,
                sortBy: "id",
                totalItems: 0
            },
            totalSearchCount: 0,
        }
    },
    created() {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrfToken;
        eventBus.$on('cabanatuan-details-event', payload => {
            this.dialog = !this.dialog;
            this.payload = payload;
            this.accessions = payload.accessions;
            this.dates = payload.dates;
            this.title = (payload.searchBy === "P1") ? "Common Grave: " + payload.searchString:"Accession Number: " + payload.searchString;
            console.log("cabanatuan-details-event received: "+"payload: "+JSON.stringify(payload));
            this.getSpecimen(payload);
        });
    },
    methods: {
        getSpecimen(payload) {
            this.loading = true;
            let searchString = 'CG '+ payload.searchString;
            searchString = (payload.searchBy === "P1") ? 'CG '+ payload.searchString:'CIL'+ payload.searchString;

            let url = "/api/projects/11/specimens/search";
            console.log("getSpecimen: " + JSON.stringify(payload));
            axios.request({ url: url, method: "GET",
                params:{ 'searchby': payload.searchBy, 'searchstring': searchString, 'page': this.options.page, 'per_page':this.options.itemsPerPage, },
                headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
            }).then(response=>{
                console.log("response: "+JSON.stringify(response.data.data));
                console.log("response meta: "+JSON.stringify(response.data.meta));this.totalSearchCount = response.data.meta.total;
                this.initializeRows(response.data.data)
                this.loading = false;
            }).catch(error => {
                console.log(error.response);
                this.loading = false;
            })
        },
        initializeRows(data) {
            this.items = [];
            data.map(item =>
                this.items.push({
                    se_id: item.id,
                    key: item.key,
                    skeletalbone: item.skeletalbone.name,
                    side: item.side,
                    bone_group: item.bone_group,
                    individual_number: item.individual_number,
                    dna_id: (item.dnas[0]) ? (item.dnas[0]).id : null,
                    sample_number: (item.dnas[0]) ? (item.dnas[0]).sample_number : null,
                    mito_sequence_number: (item.dnas[0]) ? (item.dnas[0]).mito_sequence_number : null,
                    measured: item.measured,
                    isotope_sampled: item.isotope_sampled,
                    clavicle_triage: item.clavicle_triage,
                    ct_scanned: item.ct_scanned,
                    xray_scanned: item.xray_scanned,
                    inventoried: item.inventoried,
                    reviewed: item.reviewed,
                    inventoried_by: item.inventoried_by,
                    inventoried_at: item.inventoried_at,
                    reviewed_by: item.reviewed_by,
                    reviewed_at: item.reviewed_at,
                    created_by: item.created_by,
                    created_at: item.created_at,
                    updated_by: item.updated_by,
                    updated_at: item.updated_at,
                })
            );
        },
        addLink(item){
            window.open(this.helpUrl);
        },
        closeTab(){
            this.dialog = false;
            this.payload = null;
            this.title = "Common Grave";
        },
        displayCheck(item) {
            return item === true ? '✔' : ''
        },
        checkColor(item) {
            return item === true ? 'success' : ''
        },
    },
    computed: {
        ...mapState({
            perPage: state => state.search.perPage,
            rowsPerPageItems: state => state.search.rowsPerPageItems,
        }),
        ...mapGetters({
            bearerToken: 'bearerToken',
            csrfToken: 'csrfToken',
            theOrg: 'theOrg',
            theUser: 'theUser',
            theProject: 'theProject',
            helpUrl: 'getHelpUrl',
        }),
        columnVisibility(){
            return this.headers.filter(item => item.visibility === true);
        }
    },
};
</script>
<style scoped>
</style>