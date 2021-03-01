<template>
    <div class="m-2">
        <contentheader :trail="this.trail" :title="this.heading" :help_menu="true"></contentheader>
        <v-alert class="my-1" border="left" colored-border type="info" elevation="2" dismissible>{{defaultSearchDisplay}}</v-alert>
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
                                <v-checkbox v-bind:label="header.text" v-model="header.visibility" :value="header.visibility" :dusk="header.text"/>
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
                      calculate-widths="" class="elevation-1" :sort-by="['key']" :search="search" :loading="loading"
                      :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }">
            <template v-slot:item.key="{ item }"><a :href="`/skeletalelements/${item.se_id}`" target="_blank">{{ item.key }}</a></template>
            <template v-slot:item.individual_number="{ item }"><a :href="`/reports/individualnumberdetails/${item.individual_number}`" target="_blank">{{ item.individual_number }}</a></template>
            <template v-slot:item.sample_number="{ item }">
                <a      class="mx-1"
                        v-for="(dna, index) in item.dnas"
                        :key="index"
                        :href="`/skeletalelements/${dna.se_id}/dnas/${dna.id}`"
                        target="_blank"
                >{{ dna.sample_number }}</a></template>
            <template v-slot:item.mito_sequence_number="{ item }"><a :href="`/reports/mtdna/${item.mito_sequence_number}`" target="_blank">{{ item.mito_sequence_number }}</a></template>
        </v-data-table>
    </div>
</template>

<script>
    import {mapState, mapGetters, mapActions} from 'vuex';
    import axios from 'axios';

    export default {
        name: "DNASearchResults",
        props: {
            heading: { type: String, default: "" },
        },
        data: function () {
            return {
                searchResults: null,
                items: [],
                options: {},
                search: '',
                toggle_multiple: [],
                loading: false,
                totalSearchCount: 0,
                headers: [
                    {text: 'Key', value: 'key', width: '10rem', visibility: true},
                    {text: 'Bone', value: 'skeletalelement', width: '6rem', visibility: true},
                    {text: 'Side', value: 'side', width: '6rem', visibility: true},
                    {text: 'Bone Group', value: 'bone_group', width: '6rem', visibility: true},
                    {text: 'Individual Number', value: 'individual_number', width: '10rem', visibility: true},
                    {text: 'Sample Number', value: 'sample_number', width: '6rem', visibility: true},
                    {text: 'External Case ID', value: 'external_case_id', width: '6rem', visibility: true},
                    {text: 'Results Status', value: 'mito_results_confidence', width: '6rem', visibility: true},
                    {text: 'Mito Sequence Number', value: 'mito_sequence_number', width: '6rem', visibility: true},
                    {text: 'Mito Sequence Subgroup', value: 'mito_sequence_subgroup', width: '6rem', visibility: true},
                    {text: 'Mito Sequence Similar', value: 'mito_sequence_similar', width: '6rem', visibility: true},
                    {text: 'Receive Date', value: 'mito_receive_date', width: '6rem', visibility: true},
                    {text: 'Created By', value: 'created_by', width: '6rem', visibility: false},
                    {text: 'Created At', value: 'created_at', width: '6rem', visibility: false},
                    {text: 'Updated By', value: 'updated_by', width: '6rem', visibility: false},
                    {text: 'Updated At', value: 'updated_at', width: '6rem', visibility: false},
                ],
                trail: [{ text: 'Home', disabled: false, href: '/', },
                    { text: 'Search', disabled: true, href: '/dnas/search', },
                ],
            }
        },
        watch: {
            options: {
                handler () {
                    this.loadGeneral();
                },
                deep: true,
            },
        },
        created() {
            // this.loadGeneral();
        },
        methods: {
            loadGeneral: function() {
                this.loading = true;
                console.log("options: "+JSON.stringify(this.options));
                let url = '/api/projects/' + this.theProject.id + '/dnas/search?searchby=' + this.defaultSearchBy + '&searchstring=' + this.defaultSearchString
                    + '&page=' + this.options.page
                    + '&per_page=' + this.options.itemsPerPage;
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
                    // For debugging purposes
                    console.log("meta: " + JSON.stringify(response.data.meta));
                    console.log("links: " + JSON.stringify(response.data.links));
                    this.loading = false;
                    this.initializeRows();
                })
                .catch(error => {
                    console.log(error);
                });
            },
            initializeRows() {
                this.items = [];
                if(this.defaultSearchBy === 'SN' || this.defaultSearchBy === 'MS' || this.defaultSearchBy === 'EN') {
                    this.searchResults.map(item =>
                        this.items.push(
                        {
                            se_id: item.se_id,
                            dna_id: item.skeletalelement.dnas[0].id,
                            key: item.skeletalelement.key,
                            skeletalelement: item.skeletalelement.sb.name,
                            side: item.skeletalelement.side,
                            bone_group: item.bone_group,
                            individual_number: item.skeletalelement.individual_number,
                            dnas: (item.skeletalelement.dnas) ,
                            external_case_id: item.external_case_id,
                            mito_results_confidence: item.mito_results_confidence,
                            mito_sequence_number: item.mito_sequence_number,
                            mito_sequence_subgroup: item.mito_sequence_subgroup,
                            mito_sequence_similar: item.mito_sequence_similar,
                            mito_receive_date: item.mito_receive_date,
                            created_by: item.created_by,
                            created_at: item.created_at,
                            updated_by: item.updated_by,
                            updated_at: item.updated_at,
                        })
                    );
                } else {
                    this.searchResults.map(item =>
                        this.items.push(
                        {
                            se_id: item.id,
                            key: item.key,
                            skeletalelement: item.sb.name,
                            side: item.side,
                            bone_group: item.bone_group,
                            individual_number: item.individual_number,
                            dna_id: (item.dnas[0]) ? (item.dnas[0]).id : null,
                            dnas: (item.dnas) ,
                            external_case_id: (item.dnas[0]) ? (item.dnas[0]).external_case_id : null,
                            mito_results_confidence: (item.dnas[0]) ? (item.dnas[0]).mito_results_confidence : null,
                            mito_sequence_number: item.mito_sequence_number,
                            mito_sequence_subgroup: item.mito_sequence_subgroup,
                            mito_sequence_similar: item.mito_sequence_similar,
                            mito_receive_date: item.mito_receive_date,
                            created_by: item.created_by,
                            created_at: item.created_at,
                            updated_by: item.updated_by,
                            updated_at: item.updated_at,
                        })
                    );
                }
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
                defaultSearchOption: 'defaultSearchOption',
                defaultSearchFor: 'defaultSearchFor',
                defaultSearchBy: 'defaultSearchBy',
                defaultSearchString: 'defaultSearchString',
                defaultSearchName: 'defaultSearchName',
                defaultSearchDisplay: 'defaultSearchDisplay',
            }),

            columnVisibility(){
                return this.headers.filter(item => item.visibility === true);
            },
        },
    }
</script>