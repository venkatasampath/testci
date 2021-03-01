<template>
  <div class="m-2">
    <contentheader :title="this.heading" :trail="this.trail" :help_menu="true"></contentheader>
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
    <v-data-table :headers="columnVisibility" :items="items" :items-per-page="perPage" calculate-widths="" class="elevation-1" multi-sort :search="search" :loading="loading"
                  :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }">
      <template v-slot:item.key="{ item }"><a :href="`/skeletalelements/${item.se_id}`" target="_blank">{{ item.key }}</a></template>
      <template v-slot:item.mito_sequence_number="{ item }"><a :href="`/reports/mtdna/${item.mito_sequence_number}`" target="_blank">{{ item.mito_sequence_number }}</a></template>
<!--add in code for mito sequence subgroup-->
    </v-data-table>
  </div>
</template>

<script>
import {mapState, mapGetters} from 'vuex';
import axios from 'axios/index';

export default {
  name: "dnaUserActivity",
  props: {

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
        {text: 'Side', value: 'side', width: '6rem', visibility: true},
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
      heading:'User Activity: DNA',
      chart_type: '',
      trail: [{ text: 'Home', disabled: false, href: '/', },
        {text:'User Dashboard', disabled: true, href:'/'},


      ],

    }
  },
  created() {
    this.loadGeneral();
  },
  // watch: {
  //   options: {
  //     handler () {
  //
  //     },
  //     deep: true,
  //   },
  // },
  methods: {
    loadGeneral() {
      this.searchResults = {};
      this.loading  = true;
      let url = '/api/dashboard/projects/activity?by=dna'
      axios({
        url: url,
        method: 'GET',
        headers:{
          'Content-Type' : 'application/json',
          'Authorization' : this.$store.getters.bearerToken,
        },
        params: {
          forUser: this.theUser.name ? [this.theUser.name] : null,
          page: this.options.page,
          per_page: this.perPage
        }
      })
          .then(response=>{
            this.searchResults = response.data.data;
            // this.totalSearchCount = response.data.meta.total;
            console.log("test1234")
            console.log(this.searchResults)
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
                key: this.getKey(item),
                mito_sequence_number: item.mito_sequence_number,
                mito_sequence_subgroup: item.mito_sequence_subgroup,
                dna_id: item.id,
                side: item.side,
                sample_number: item.sample_number,
                external_case_id: item.external_case_id,
                mito_results_confidence: item.mito_results_confidence,
                mito_sequence_similar: item.mito_sequence_similar,
                mito_receive_date: item.mito_receive_date,
                created_by: item.created_by,
                created_at: item.created_at,
                updated_by: item.updated_by,
                updated_at: item.updated_at,

              })
      );
    },
    getKey(item) {
      return `${item.accession_number ? item.accession_number : ''}:
                        ${item.provenance1 ? item.provenance1 : ''}:
                        ${item.provenance2 ? item.provenance2 : ''}:
                        ${item.designator ? item.designator : ''}`;
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
      theUser: 'theUser',
    }),

    columnVisibility(){
      return this.headers.filter(item => item.visibility === true);
    },
  },
}
</script>

<style scoped>

</style>