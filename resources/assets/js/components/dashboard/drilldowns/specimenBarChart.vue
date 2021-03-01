<template>
    <div class="m-2">
        <contentheader :trail="this.trail" :help_menu="true"></contentheader>
        <bar-chart-widget :type="chart_type" :setClass="setClass" :setStyle="setStyle" :showOptions="showOptions" :top="top"/>
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
                                <v-checkbox v-bind:label="header.text" v-model="header.visibility" :value="header.visibility"></v-checkbox>
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
      <v-data-table :headers="columnVisibility" :items="items" :items-per-page="perPage" calculate-widths="" class="elevation-1" multi-sort :sort-by="['key']" :search="search" :loading="loading"
                    :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }">
            <template v-slot:item.mito_sequence_number="{ item }"><a :href="`/reports/mtdna/${item.mito_sequence_number}`" target="_blank">{{ item.mito_sequence_number }}</a></template>
        </v-data-table>
        <br>
    </div>
</template>

<script>
    import {mapState, mapGetters} from 'vuex';
    import axios from 'axios/index';

    export default {
        name: "specimenBarChart",
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
                top: 40,
                showOptions: false,
                headers:'',
                mito_headers: [
                    {text: 'Mito Sequence Number', value: 'mito_sequence_number', width: '10rem', visibility: true},
                    {text: 'Total', value: 'total', width: '6rem', visibility: true},
                ],
                mni_zone_headers:[
                    {text: 'Bone', value: 'name', width: '10rem', visibility: true},
                    {text: 'Zone', value: 'display_name', width: '10rem', visibility: true},
                    {text: 'Total', value: 'total', width: '6rem', visibility: true},
                ],
                mni_bone_headers:[
                    {text: 'Bone', value: 'name', width: '10rem', visibility: true},
                    {text: 'Total', value: 'total', width: '6rem', visibility: true},
                ],
                heading:'',
                trail: [{ text: 'Home', disabled: false, href: '/', },
                    {text:'Project Dashboard', disabled: true, href:'/'},
                ],

            }
        },
        created() {
            this.loadGeneral();
        },
        // watch: {
        //     options: {
        //         handler () {
        //             this.loadGeneral();
        //         },
        //         deep: true,
        //     },
        // },
        methods: {
            loadGeneral() {
                this.searchResults = {};
                this.loading  = true;
                if(this.chart_type === "mito_sequence_number"){
                    let url = "/api/dashboard/projects/dnas/mito?"
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
                            this.totalSearchCount = response.data.count;
                            this.initializeRows();
                        })
                        .catch((error) => {
                            console.log(error);
                            this.loading = false;
                        });
                }
                if(this.chart_type === "mni_bones"){
                    let url = "/api/dashboard/projects/mni?by=bones"
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
                            console.log(this.searchResults);
                            this.totalSearchCount = response.data.count;
                            this.initializeRows();
                        })
                        .catch((error) => {
                            console.log(error);
                            this.loading = false;
                        });
                }
                if(this.chart_type === "mni_zones"){
                    let url = "/api/dashboard/projects/mni?by=zones"
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
                            console.log(this.searchResults);
                            this.totalSearchCount = response.data.count;
                            this.initializeRows();
                        })
                        .catch((error) => {
                            console.log(error);
                            this.loading = false;
                        });
                } else{
                    this.loading = false;
                }

            },
            initializeRows() {
                this.items = [];
                if(this.chart_type === "mito_sequence_number"){
                    this.searchResults.map(item =>
                        this.items.push(
                            {
                                mito_sequence_number: item.mito_sequence_number,
                                total: item.total
                            })
                    );
                    this.loading = false;
                }
                if(this.chart_type === "mni_bones"){
                    this.searchResults.map(item =>
                        this.items.push(
                            {
                                name: item.name,
                                total: item.total
                            })
                    );
                    this.loading = false;
                }
                if(this.chart_type === "mni_zones"){
                    this.searchResults.map(item =>
                        this.items.push(
                            {
                                name: item.name,
                                display_name: item.display_name,
                                total: item.total
                            })
                    );
                    this.loading = false;
                }

            },
        },
        computed: {
            ...mapState({
                rowsPerPageItems: state => state.search.rowsPerPageItems,
            }),
            ...mapGetters({
                bearerToken: 'bearerToken',
                theProject: 'theProject',
            }),

            columnVisibility(){
                if(this.chart_type === "mito_sequence_number"){
                    this.headers = this.mito_headers;
                    return this.mito_headers.filter(item => item.visibility === true);
                }
                if(this.chart_type === "mni_bones"){
                    this.headers = this.mni_bone_headers;
                    return this.mni_bone_headers.filter(item => item.visibility === true);
                }
                if(this.chart_type === "mni_zones"){
                    this.headers = this.mni_zone_headers;
                    return this.mni_zone_headers.filter(item => item.visibility === true);
                }
            },
        },
    }
</script>

<style scoped>

</style>