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
      <template v-slot:item.measured="{ item }"><v-icon right :color="checkColor(item.measured)">{{ displayCheck(item.measured) }}</v-icon></template>
      <template v-slot:item.complete="{ item }"><v-icon right :color="checkColor(item.complete)">{{displayCheck(item.complete) }}</v-icon></template>
      <template v-slot:item.isotope_sampled="{ item }"><v-icon right :color="checkColor(item.isotope_sampled)">{{ displayCheck(item.isotope_sampled) }}</v-icon></template>
      <template v-slot:item.clavicle_triage="{ item }"><v-icon right :color="checkColor(item.clavicle_triage)">{{ displayCheck(item.clavicle_triage) }}</v-icon></template>
      <template v-slot:item.ct_scanned="{ item }"><v-icon right :color="checkColor(item.ct_scanned)">{{ displayCheck(item.ct_scanned) }}</v-icon></template>
      <template v-slot:item.xray_scanned="{ item }"><v-icon right :color="checkColor(item.xray_scanned)">{{ displayCheck(item.xray_scanned) }}</v-icon></template>
<!--add in code for bone name, bone side, and updated at -->
    </v-data-table>
  </div>
</template>

<script>
import {mapState, mapGetters} from 'vuex';
import axios from 'axios/index';

export default {
  name: "specimenUserActivity",
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
      // setClass: "m-12 p-2",
      // setStyle: "",
      showOptions: false,
      headers: [
        {text: 'Key', value: 'key', width: '10rem', visibility: true},
        {text: 'Name', value: 'skeletalbone', width: '6rem', visibility: true},
        {text: 'Side', value: 'side', width: '6rem', visibility: true},
        {text: 'Completeness', value: 'complete', width: '6rem', visibility: true},
        {text: 'Individual Number', value: 'individual_number', width: '10rem', visibility: true},
        {text: 'Measured', value: 'measured', width: '6rem', visibility: true},
        {text: 'Isotope Sampled', value: 'isotope_sampled', width: '6rem', visibility: true},
        {text: 'Clavicle Triage', value: 'clavicle_triage', width: '6rem', visibility: true},
        {text: 'CT Scanned', value: 'ct_scanned', width: '6rem', visibility: true},
        {text: 'Xray Scanned', value: 'xray_scanned', width: '6rem', visibility: true},
        {text: 'Inventoried', value: 'inventoried', width: '6rem', visibility: false},
        {text: 'Reviewed', value: 'reviewed', width: '6rem', visibility: false},
        {text: 'Inventoried At', value: 'inventoried_at', width: '6rem', visibility: false},
        {text: 'Reviewed At', value: 'reviewed_at', width: '6rem', visibility: false},
        {text: 'Created By', value: 'created_by', width: '6rem', visibility: false},
        {text: 'Created At', value: 'created_at', width: '6rem', visibility: false},
        {text: 'Updated By', value: 'updated_by', width: '6rem', visibility: false},
        {text: 'Updated At', value: 'updated_at', width: '6rem', visibility: false},

      ],
      heading:'User Activity: Specimen',
      chart_type: '',
      trail: [{ text: 'Home', disabled: false, href: '/', },
        {text:'User Dashboard', disabled: true, href:'/'},
        // {text:this.chartTitle, disabled: true, href:'/'},

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
      let url = '/api/dashboard/projects/activity?by=specimen'
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
            console.log("test123")
            console.log(this.searchResults);
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
                skeletalbone: item.name,
                side: item.side,
                bone_group: item.bone_group,
                bone_group_id: item.bone_group_id,
                individual_number: item.individual_number,
                measured: item.measured,
                isotope_sampled: item.isotope_sampled,
                clavicle_triage: item.clavicle_triage,
                ct_scanned: item.ct_scanned,
                xray_scanned: item.xray_scanned,
                inventoried: item.inventoried,
                reviewed: item.reviewed,
                inventoried_at: item.inventoried_at,
                reviewed_at: item.reviewed_at,
                created_by: item.created_by,
                created_at: item.created_at,
                updated_by: item.updated_by,
                updated_at: item.updated_at,
                complete: item.completeness === "Complete"? true : null,
              })
      );
    },
    getKey(item) {
      return `${item.accession_number ? item.accession_number : ''}:
                        ${item.provenance1 ? item.provenance1 : ''}:
                        ${item.provenance2 ? item.provenance2 : ''}:
                        ${item.designator ? item.designator : ''}`;
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