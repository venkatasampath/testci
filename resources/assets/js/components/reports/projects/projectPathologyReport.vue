<template>
  <div class="m-2">
    <contentheader :trail="this.trail" model_name="project_pathology" :reset_menu="true" @eventReset="reset"
                   :collapse_menu="true" @eventCollapse="onExpand(false)" @eventExpand="onExpand(true)"
                   :generate_menu="true" :disable_generate="this.disable_generate" @eventGenerate="generate">
    </contentheader>
    <br>
    <v-card>
      <v-container fluid v-show="showReportCriteria">
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.an" :items="items_accessions" label="Accession Number" placeholder="Select Accession Number" clearable></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.p1" :items="items_provenance1" label="Provenance 1" placeholder="Select Provenance 1" clearable></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.p2" :items="items_provenance2" label="Provenance 2" placeholder="Select Provenance 2" clearable dusk="provenance2"></v-autocomplete>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.pathology_select" :items="items_pathologys"  multiple chips deletable-chips label="Pathology" item-text="name" item-value="id" clearable dusk="pathology"></v-autocomplete>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.sb_id" :items="items_sb_id" label="Bone" item-text="name" item-value="id" placeholder="Select Bone" required clearable ></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.side" :items="side" label="Side" placeholder="Select Side" clearable></v-autocomplete>
          </v-col>
        </v-row>
      </v-container>
      <div v-show="showTable">
        <v-row>
          <v-col cols="9">
            <v-btn-toggle v-model="toggleMultiple" dense dark multiple>
              <v-btn dusk="excel">Excel</v-btn>
              <v-menu right offset-x :close-on-content-click="false" max-height="500px">
                <template v-slot:activator="{ on }">
                  <v-btn v-on="on" dusk="column-visibility">
                    Column Visibility
                    <v-icon right>$dropdown</v-icon>
                  </v-btn>
                </template>

                <v-list>
                  <v-list-item v-for="(header, index) in headers" :key="index">
                    <v-checkbox
                        v-bind:label="header.text"
                        v-model="header.visibility"
                        :value="header.visibility"
                        :dusk="header.text"
                    />
                  </v-list-item>
                </v-list>
              </v-menu>
            </v-btn-toggle>
          </v-col>

          <v-spacer />

          <v-col cols="3">
            <v-text-field v-model="search" label="Search" single-line hide-details />
          </v-col>
        </v-row>

        <v-data-table :headers="columnVisibility" :items="specimenItems" :items-per-page="perPage" :options.sync="options" :server-items-length="totalSearchCount"
                      calculate-widths="" class="elevation-1" :sort-by="['key']" multi-sort :search="search"
                      :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }">
          <template v-slot:item.key="{ item }">
            <a :href="`/skeletalelements/${item.id}`" target="_blank">{{ item.key }}</a>
          </template>
        </v-data-table>
      </div>
      <v-snackbar v-model="snackbar.show" top  centered :color="snackbar.color" @close="snackbar = false">{{snackbar.message}}</v-snackbar>
    </v-card>
  </div>
</template>

<script>

import {mapGetters, mapState} from 'vuex';
import { eventBus } from '../../../eventBus';
import axios from "axios";
import side from "../../specimens/common/side";

export default {
  name: "projectPathologyReport",
  data() {
    return {
      trail: [{ text: 'Home', disabled: false, href: '/'},
        { text: 'Reports Dashboard', disabled: false, href: '/reports/dashboard' },
        { text: 'Individual Pathology Report', disabled: true, href: '/reports/pathologys', },
      ],
      showReportCriteria: true,
      form: {},
      side: ["Left", "Right", "Middle", "Unsided"],
      showTable: false,
      showNextStep: false,
      snackbar: {show: false, message: null, color: null},
      pathologies: [],
      specimens: {},
      totalSearchCount:0,
      disable_generate: true,
      perPage:100,
      options:{},
      pathologysByZonesList:{},
      loading: false,
      items_side:null,
      items_groupSide:null,
      items_side_all:["Left", "Right", "Middle", "Unsided"],
      resultData: [],
      skeletalElement: {},
      headers: [
        { text: "Key", value: "key", visibility: true, width: "12rem" },
        { text: "Bone", value: "bone", visibility: true, width: "12rem" },
        { text: "Side", value: "side", visibility: true },
      ],
      search: "",
      toggleMultiple: [],
    }
  },

  watch: {
    options: {
      handler () {
        this.generate()
      },
      deep: true,
    },
    'form.pathology_select'(){
      this.toggleDisable();
    }
  },
  methods: {
    getKey(item) {
      return `${item.accession_number ? item.accession_number : ''}:
                        ${item.provenance1 ? item.provenance1 : ''}:
                        ${item.provenance2 ? item.provenance2 : ''}:`;
    },
    getHeaders (){
      this.headers.splice(3,1000);
      this.pathologies.forEach(pathology => {
        this.headers.push({
          text: pathology.name,
          value:pathology.name,
          visibility: true
        });
      });
    },
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
              url: '/api/reports/projects/' + this.project_id + '/pathology',
              method: "GET",
              headers: {'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken},
              params: {
                an: this.form.an ? [this.form.an] : null,
                p1: this.form.p1 ? [this.form.p1] : null,
                p2: this.form.p2 ? [this.form.p2] : null,
                pathology_select: this.form.pathology_select ? this.form.pathology_select : null,
                sb_select: this.form.sb_id ? this.form.sb_id : null,
                side_select: this.form.side ? this.form.side : null,
                page: this.options.page,
                per_page: this.perPage
              }
            }).then(response => {
          eventBus.$emit('generate-loading', false);
          this.specimens = response.data.data;
          this.pathologies = response.data.pathologies;
          this.pathologysByZonesList = response.data.pathology_by_zones_list;
          this.totalSearchCount = response.data.meta.total;
          this.getHeaders();
          this.showTable = true;
        }).catch(error => {
          console.log(error);
          eventBus.$emit('generate-loading', false);
        })
      }
    },
    toggleDisable(){
      if (this.form.pathology_select){
        this.disable_generate = false;
        eventBus.$emit('disable_generate', this.disable_generate);
      }
      else{
        this.disable_generate = true;
        eventBus.$emit('disable_generate', this.disable_generate);
      }
    },
  },
  computed: {
    ...mapState({
      rowsPerPageItems: state => state.search.rowsPerPageItems,
    }),

    ...mapGetters({
      items_accessions: 'getProjectAccessions',
      items_provenance1: 'getProjectProvenance1',
      items_provenance2: 'getProjectProvenance2',
      items_sb_id: 'getBones',
      items_pathologys:  'getPathologies',
      project_id: 'theProjectId',
    }),
    specimenItems(){
      const rows = [];
      Object.values(this.specimens).forEach(item => {
        let pathologyColumns = {};
        Object.values(this.pathologies).forEach(
            pathology =>
                (pathologyColumns[pathology.name] = this.pathologysByZonesList[item.id][pathology.name]==='N/A'? '✔-Present in all Zones':'')
        );
        rows.push({
          id: item.id,
          key:  item.key,
          bone: item.sb.name,
          side: item.side,
          ...pathologyColumns
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
