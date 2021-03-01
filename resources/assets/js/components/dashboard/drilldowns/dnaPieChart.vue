<template>
    <div class="m-2">
        <contentheader :trail="this.trail" :help_menu="true"></contentheader>
        <pie-chart-widget :type="chart_type" :setClass="setClass" :setStyle="setStyle" :showOptions="showOptions"/>
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

        <v-data-table :headers="columnVisibility" :items="dnaItems" :items-per-page="perPage" calculate-widths="" :options.sync="options"
                      class="elevation-1" multi-sort :search="search" :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }"
                      :server-items-length="totalSearchCount" :sort-by="['key']" :loading="loading">
            <template v-slot:item.key="{ item }"><a :href="`/skeletalelements/${item.se_id}`" target="_blank">{{ item.key }}</a></template>
            <template v-slot:item.individual_number="{ item }"><a :href="`/reports/individualnumberdetails/${item.individual_number}`" target="_blank">{{ item.individual_number }}</a></template>
            <template v-slot:item.sample_number="{ item }"><a :href="`/skeletalelements/${item.se_id}/dnas/${item.dna_id}`" target="_blank">{{ item.sample_number }}</a></template>
            <template v-slot:item.sequence_number="{ item }" >
              <a :href="encodednaURI(item)"
                 target="_blank">
                {{ item.sequence_number }}
                <br />
              </a>
            </template>
            <template v-slot:item.bone_group="{ item }"><a :href="`/reports/bonegroup/${item.bone_group_id}`" target="_blank">{{ item.bone_group }}</a></template>
        </v-data-table>
        <br>
    </div>
</template>

<script>
    import {mapState, mapGetters} from 'vuex';
    import axios from 'axios/index';

    export default {
        name: "dnaPieChart",
        props: {
            dna_type: { type: String, required: true }
        },
        data() {
            return {
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
                options: {},
                dnas:[],
                search: '',
                setClass: "m-12 p-2",
                setStyle: "",
                showOptions: false,
                loading:true,
                chart_type:'',
                totalSearchCount: 0,
                perPage: 100,
                heading:'',
                trail: [{ text: 'Home', disabled: false, href: '/', },
                    {text:'Project Dashboard', disabled: true, href:'/'},
                    {text: this.capitalizeDnaType(this.dna_type) + 'DNA', disabled: true, href:'/'},

                ],
            }
        },
        created() {
            this.setHeading();

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
            encodednaURI(item) {
              if(this.dna_type=='austr') {
                return "/reports/austrdna/" + item.sequence_number;
              }else if(this.dna_type=='ystr') {
                return "/reports/ystrdna/" + item.sequence_number;
              }else if(this.dna_type=='mito') {
                return "/reports/mtdna/" + item.sequence_number;
              }
            },
            loadGeneral() {
                this.dnas = {};
                this.loading =true;
                let url = '/api/dashboard/projects/' + this.theProject.id + '/drilldowns?type=dna&filter=' + this.chart_type
                    + '&page=' + this.options.page
                    + '&per_page=' + this.perPage;
                axios({
                    url: url,
                    method: 'GET',
                    headers:{
                        'Content-Type' : 'application/json',
                        'Authorization' : this.$store.getters.bearerToken,
                    }
                })
                    .then(response=>{
                        this.dnas = response.data.data;
                        this.totalSearchCount = response.data.meta.total;
                        this.loading = false;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            getKey(item) {
                return `${item.accession_number ? item.accession_number : ''}:
                        ${item.provenance1 ? item.provenance1 : ''}:
                        ${item.provenance2 ? item.provenance2 : ''}:
                        ${item.designator ? item.designator : ''}`;
            },
            capitalizeDnaType(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            },
            setHeading(){
                let url = window.location.href;
                let type = url.substring(url.lastIndexOf('/') + 1);
                this.chart_type = type;
            }
        },
        computed: {
            dnaItems() {
                const rows = [];
                switch(this.dna_type) {
                    case 'mito':
                        Object.values(this.dnas).forEach(item =>
                            rows.push({
                                se_id: item.se_id,
                                dna_id: item.id,
                                key: this.getKey(item.skeletalelement),
                                bone: this.getBone(item.sb_id).name,
                                side: item.skeletalelement.side,
                                bone_group: item.skeletalelement.bone_group,
                                bone_group_id: item.skeletalelement.bone_group_id,
                                individual_number: item.skeletalelement.individual_number,
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
                                key: this.getKey(item.skeletalelement),
                                bone: this.getBone(item.sb_id).name,
                                side: item.skeletalelement.side,
                                bone_group: item.skeletalelement.bone_group,
                                individual_number: item.skeletalelement.individual_number,
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
                                key: this.getKey(item.skeletalelement),
                                bone: this.getBone(item.sb_id).name,
                                side: item.skeletalelement.side,
                                bone_group: item.skeletalelement.bone_group,
                                individual_number: item.skeletalelement.individual_number,
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
                getBone: 'getBone',
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