<template>
  <div class="m-2">
    <contentheader :title="this.heading" :help_menu="true" :trail="(action.create) ? trail.create : trail.default" model_name="isotopebatch"
                   :crud_action="action" @eventNew="this.new">
    </contentheader>
    <br>
    <div>
      <v-row>
        <v-col cols="9">
          <v-btn-toggle v-model="toggle_multiple" dense multiple>
            <v-btn>Excel</v-btn>
            <v-btn>PDF</v-btn>
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

      <v-data-table :headers="columnVisibility" :items="isotopeItems" :items-per-page="perPage" :options.sync="options" calculate-widths="" :loading="loading"
                    class="elevation-1" multi-sort :search="search" :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }"
                    :server-items-length="totalSearchCount" :sort-by="['key']">
        <template v-slot:item.batch_number="{ item }">
          <a :href="encodedIsotopeBatchURI(item)" target="_blank">{{ item.batch_number }}</a>
        </template>
      </v-data-table>
      <br>
    </div>
  </div>
</template>

<script>
  import {mapGetters, mapState} from "vuex";
  import axios from 'axios';

  export default {
    name: "isotopeList",
    props: {
      heading: {type: String, default: "Isotope Batches"},
      crud_action: {type: String, default: "List"},
      specimen: { type: Object, default: null },
    },
    data() {
      return {
        trail: {
          'create': [{text: 'Home', disabled: false, href: '/',},
            {text: 'Isotope Batches ', disabled: false, href: "/isotopebatch"},
            {text: 'New', disabled: true, href: "/"},],
          'default': [{text: 'Home', disabled: false, href: '/',},
            {text: 'Isotope Batches ', disabled: true, href:  "/isotopebatch"},
            ],
        },
        headers: [
          {text: 'Batch Number', value: 'batch_number', visibility: true},
          {text: 'Isotope Count', value: 'isotope_count', visibility: true},
          {text: 'Status', value: 'result_status', visibility: true},
        ],
        perPage: 100,
        searchResults: null,
        totalSearchCount: 0,
        options:{},
        toggle_multiple: [],
        showReportCriteria: true,
        isotopes: {},
        loading: false,
        search:'',
      };
    },
    watch: {
      options: {
        handler () {
          this.fetchIsotopeBatches();
        },
        deep: true,
      },
    },
    methods: {
      fetchIsotopeBatches(){
        this.loading = true;
        axios
                .request({
                  url: '/api/isotope/batches' ,
                  method: "GET",
                  headers: {
                    'Content-Type': 'application/json',
                    'Authorization': this.$store.getters.bearerToken
                  },
                  params: {
                    page: this.options.page,
                    per_page: this.options.itemsPerPage
                  }
                }).then(response => {
          this.loading = false;
          this.isotopes = response.data.data;
          this.totalSearchCount = response.data.meta.total;
          this.showTable = true;
        }).catch(error => {
          this.loading = false;
        })
      },
      encodedIsotopeBatchURI(item) {
        let url;
        if (item.result_status === 'Open' || item.result_status === 'Associating Isotopes'){
          url = "/isotopebatch/associateisotopes/" +item.id;

        } else{
          url = '/isotopebatch/'+  item.id;
        }
        return url;
      },
      new() {
        location.assign(`/isotopebatch/create`);
      },
    },
    computed: {
      columnVisibility(){
        return this.headers.filter(item => item.visibility === true);
      },
      isotopeItems() {
        const rows = [];
        Object.values(this.isotopes).forEach(item =>
            rows.push({
              id: item.id,
              batch_number: item.batch_num,
              isotope_count:item.isotopes ? item.isotopes.length: 0,
              result_status: item.status,
            })
        );
        return rows;
      },
      ...mapState({
        rowsPerPageItems: state => state.search.rowsPerPageItems,
      }),
      ...mapGetters({
        project_id: 'theProjectId'

      }),
      action() {
        const act = this.crud_action;
        return { create: act === "Create", view: act === "View", edit: (act === "Update" || act === "Edit"), list: act === "List", };
      },
      toolbarProps() {
        if (this.action.create || this.action.edit) {
          return { rese: true, save: {disabled: !this.edited} };
        } else if (this.action.view) {
          return { edit: true };
        } else {
          return {};
        }
      },
    }
  }

</script>

<style scoped>

</style>