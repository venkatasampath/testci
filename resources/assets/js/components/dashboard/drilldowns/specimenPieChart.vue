<template>
    <div class="m-2">
        <contentheader :trail="this.trail" :help_menu="true"></contentheader>
        <pie-chart-widget :type="chart_type" :setClass="setClass" :setStyle="setStyle" :showOptions="showOptions"/>
        <v-row >
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

            <v-col cols="3">
                <v-text-field v-model="search" label="Search" clearable append-icon="mdi-magnify" dusk="search-datatable"/>
            </v-col>
        </v-row>
        <v-data-table :headers="columnVisibility" :items="items" :items-per-page="perPage" :options.sync="options" :server-items-length="totalSearchCount"
                      calculate-widths="" class="elevation-1" :sort-by="['key']" multi-sort :search="search" :loading="loading"
                      :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }">
            <template v-slot:item.key="{ item }"><a :href="`/skeletalelements/${item.se_id}`" target="_blank">{{ item.key }}</a></template>
            <template v-slot:item.individual_number="{ item }"><a :href="`/reports/individualnumberdetails/${item.individual_number}`" target="_blank">{{ item.individual_number }}</a></template>
            <template v-slot:item.sample_number="{ item }"><a :href="`/skeletalelements/${item.se_id}/dnas/${item.dna_id}`" target="_blank">{{ item.sample_number }}</a></template>
            <template v-slot:item.mito_sequence_number="{ item }"><a :href="`/reports/mtdna/${item.mito_sequence_number}`" target="_blank">{{ item.mito_sequence_number }}</a></template>
            <template v-slot:item.measured="{ item }"><v-icon right :color="checkColor(item.measured)">{{ displayCheck(item.measured) }}</v-icon></template>
            <template v-slot:item.complete="{ item }"><v-icon right :color="checkColor(item.complete)">{{
                displayCheck(item.complete) }}</v-icon></template>
            <template v-slot:item.dna_sampled="{ item }"><v-icon right :color="checkColor(item.dna_sampled)">{{
                displayCheck(item.dna_sampled) }}</v-icon></template>
            <template v-slot:item.isotope_sampled="{ item }"><v-icon right :color="checkColor(item.isotope_sampled)">{{ displayCheck(item.isotope_sampled) }}</v-icon></template>
            <template v-slot:item.clavicle_triage="{ item }"><v-icon right :color="checkColor(item.clavicle_triage)">{{ displayCheck(item.clavicle_triage) }}</v-icon></template>
            <template v-slot:item.ct_scanned="{ item }"><v-icon right :color="checkColor(item.ct_scanned)">{{ displayCheck(item.ct_scanned) }}</v-icon></template>
            <template v-slot:item.xray_scanned="{ item }"><v-icon right :color="checkColor(item.xray_scanned)">{{ displayCheck(item.xray_scanned) }}</v-icon></template>
            <template v-slot:item.inventoried="{ item }"><v-icon right :color="checkColor(item.inventoried)">{{ displayCheck(item.inventoried) }}</v-icon></template>
            <template v-slot:item.reviewed="{ item }"><v-icon right :color="checkColor(item.reviewed)">{{ displayCheck(item.reviewed) }}</v-icon></template>
            <template v-slot:item.associations="{ item }">
                <a :href="`/skeletalelements/${item.se_id}/pairs`" target="_blank">{{ item.pairs_count }}P</a>
                <a :href="`/skeletalelements/${item.se_id}/articulations`" target="_blank">{{ item.articulations_count }}A</a>
                <a :href="`/skeletalelements/${item.se_id}/refits`" target="_blank">{{ item.refits_count }}R</a>
                <a :href="`/skeletalelements/${item.se_id}/morphologys`" target="_blank">{{ item.morphologys_count }}M</a>
            </template>
            <template v-slot:item.tags="{ item }">
                <v-chip v-for="(tag, index) in item.tags" :key="index" :color="tag.color">
                    <v-avatar left><v-icon>{{ tag.icon }}</v-icon></v-avatar>{{ tag.name }}
                </v-chip>
            </template>
        </v-data-table>
    </div>
</template>

<script>
    import {mapState, mapGetters} from 'vuex';
    import axios from 'axios/index';

    export default {
        name: "specimenPieChart",
        props: {
            chart_type: { type: String, required: true }
        },
        data(){
            return{
                searchResults: null,
                items: [],
                options: {},
                search: "",
                toggle_multiple: [],
                showTable: true,
                loading: true,
                totalSearchCount: 0,
                PerPage:100,
                setClass: "m-12 p-2",
                setStyle: "",
                showOptions: false,
                headers: [
                    {text: 'Key', value: 'key', width: '10rem', visibility: true},
                    {text: 'Bone', value: 'skeletalbone', width: '6rem', visibility: true},
                    {text: 'Side', value: 'side', width: '6rem', visibility: true},
                    {text: 'Bone Group', value: 'bone_group', width: '6rem', visibility: true},
                    {text: 'Individual Number', value: 'individual_number', width: '10rem', visibility: true},
                    {text: 'DNA Sample Number', value: 'sample_number', width: '6rem', visibility: true},
                    {text: 'Mito Sequence Number', value: 'mito_sequence_number', width: '6rem', visibility: true},
                    {text: 'Associations', value: 'associations', width: '6rem', visibility: true},
                    {text: 'Pathology', value: 'pathology', width: '6rem', visibility: true},
                    {text: 'Methods', value: 'methods', width: '6rem', visibility: true},
                    {text: 'Tags', value: 'tags', width: '6rem', visibility: false},
                    {text: 'Dna Sampled', value: 'dna_sampled', width: '6rem', visibility: false},
                    {text: 'Measured', value: 'measured', width: '6rem', visibility: true},
                    {text: 'Complete', value: 'complete', width: '6rem', visibility: true},
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
                heading:'',
                chart_type: '',
                trail: [{ text: 'Home', disabled: false, href: '/', },
                    {text:'Project Dashboard', disabled: true, href:'/'},
                    // {text:this.chartTitle, disabled: true, href:'/'},

                ],

            }
        },
        created() {
        },
        watch: {
            options: {
                handler () {
                    this.loadGeneral();
                },
                deep: true,
            },
        },
        methods: {
            loadGeneral() {
                this.searchResults = {};
                this.loading  = true;
                let url = '/api/dashboard/projects/' + this.theProject.id + '/drilldowns?type=specimen&filter=' + this.chart_type
                    + '&page=' + this.options.page
                    + '&per_page=' + this.PerPage;
                axios({
                    url: url,
                    method: 'GET',
                    headers:{
                        'Content-Type' : 'application/json',
                        'Authorization' : this.$store.getters.bearerToken,
                    }
                })
                    .then(response=>{
                        this.searchResults = response.data.data;
                        this.totalSearchCount = response.data.meta.total;
                        this.initializeRows();
                        this.loading = false;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            initializeRows() {
                this.items = [];
                this.searchResults.map(item =>
                    this.items.push(
                        {
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
                            complete: item.completeness === "Complete"? true : null,
                            dna_sampled: item.dna_sampled,
                            isotope_sampled: item.isotope_sampled,
                            clavicle_triage: item.clavicle_triage,
                            ct_scanned: item.ct_scanned,
                            xray_scanned: item.xray_scanned,
                            inventoried: item.inventoried,
                            reviewed: item.reviewed,
                            pairs_count: item.pairs_count,
                            articulations_count: item.articulations_count,
                            refits_count: item.refits_count,
                            morphologys_count: item.morphologys_count,
                            methods_count: item.methods_count,
                            pathologys_count: item.pathologys_count,
                            traumas_count: item.traumas_count,
                            anomalys_count: item.anomalys_count,
                            tags: item.tags,
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
                theProject: 'theProject',
            }),

            columnVisibility(){
                return this.headers.filter(item => item.visibility === true);
            },
        },
    }
</script>

<style scoped>

</style>