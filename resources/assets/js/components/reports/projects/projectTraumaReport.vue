<template>
  <div class="m-2">
    <contentheader :trail="this.trail" model_name="project_traumas" :reset_menu="true" @eventReset="reset"
                   :collapse_menu="true" @eventCollapse="onExpand(false)" @eventExpand="onExpand(true)"
                   :generate_menu="true" dusk="se-trauma-contentheader" :disable_generate="this.disable_generate" @eventGenerate="generate">
    </contentheader>
    <br>
    <v-card>
      <v-container fluid v-show="showReportCriteria">
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.an" :items="items_accessions" label="Accession Number" dusk="se-trauma-accession" placeholder="Select Accession Number" clearable></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.p1" :items="items_provenance1" label="Provenance 1" placeholder="Select Provenance 1" dusk="se-trauma-provenance1" clearable></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.p2" :items="items_provenance2" label="Provenance 2" placeholder="Select Provenance 2" dusk="se-trauma-provenance2" clearable></v-autocomplete>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.trauma_select" :rules="rules.trauma" dusk="se-trauma-select" :disabled="disable_trauma" :items="items_traumas" item-text="name" item-value="id"
                            label="Trauma" multiple chips deletable-chips placeholder="Select Traumas" clearable/>
            <input type="hidden" name="trauma_select" :value="form.trauma_select" />
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.sb_id" :items="items_bones" dusk="se-trauma-bone" item-text="name" item-value="id" label="Bones" placeholder="Select Bone" clearable></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.side" :items="side" label="Side" placeholder="Select Side" dusk="se-trauma-side" clearable></v-autocomplete>
          </v-col>
        </v-row>
      </v-container>

      <div v-show="showTable">
        <div class="m2">
          <v-row>
            <v-col cols="9">
              <v-btn-toggle v-model="toggle_multiple" dense dark multiple>
                <v-btn dusk="excel">Excel</v-btn>
                <v-menu right offset-x :close-on-content-click="false" max-height="500px">
                  <template v-slot:activator="{ on }">
                    <v-btn v-on="on" dusk="column-visibility">Column Visibility<v-icon right>$dropdown</v-icon></v-btn>
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
              <v-text-field v-model="search" label="Search" clearable append-icon="mdi-magnify" dusk="se-trauma-search-datatable"></v-text-field>
            </v-col>
          </v-row>

          <v-data-table :headers="columnVisibility" :items="specimenItems" :items-per-page="perPage" :options.sync="options" :server-items-length="totalSearchCount"
                        calculate-widths="" class="elevation-1" :sort-by="['key']" multi-sort :search="search"
                        :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }">
            <template v-slot:item.key="{ item }"><a :href="`/skeletalelements/${item.id}`" target="_blank">{{ item.key }}</a></template>
          </v-data-table>
          <br>
        </div>
      </div>
    </v-card>
  </div>
</template>


<script>
import {mapGetters, mapState} from 'vuex';
import { eventBus } from '../../../eventBus';
import axios from "axios";

export default {
  name: "projectTraumaReport",
  data() {
    return {
      trail: [{text: 'Home', disabled: false, href: '/'},
        {text: 'Reports Dashboard', disabled: false, href: '/reports/dashboard'},
        {text: 'Trauma Report', disabled: true, href: 'reports/trauma',},
      ],
      showReportCriteria: true,
      toggle_multiple: [],
      options: {},
      search: "",
      disable_trauma: false,
      disable_generate: true,
      loading: false,
      form: {},
      columns: [],
      side: ["Left", "Right", "Middle", "Unsided"],
      specimens: {},
      traumas:[],
      totalSearchCount: 0,
      showTable: false,
      snackbar: false,
      traumasByZonesList:{},
      snackbar_color: '',
      snackbar_text: '',
      perPage: 100,
      headers: [
        {text: 'Key', value: 'key', visibility: true},
        {text: 'Bone', value: 'bone', visibility: true},
        {text: 'Side', value: 'side', visibility: true},
      ],
      rules: {
        trauma: [v => !!v || 'Trauma is required'],
      },
    }
  },
  watch: {
    options: {
      handler() {
        this.generate()
      },
      deep: true,
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
      this.traumas.forEach(trauma => {
        this.headers.push({
          text: trauma.name,
          value:trauma.name,
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
              url: '/api/reports/projects/' + this.project_id + '/trauma',
              method: "GET",
              headers: {'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken},
              params: {
                an: this.form.an ? [this.form.an] : null,
                p1: this.form.p1 ? [this.form.p1] : null,
                p2: this.form.p2 ? [this.form.p2] : null,
                side_select: this.form.side ? [this.form.side] : null,
                trauma_select: this.form.trauma_select ? this.form.trauma_select: null,
                sb_select: this.form.sb_select ? this.form.sb_select : null,
                page: this.options.page,
                per_page: this.perPage
              }
            }).then(response => {
          eventBus.$emit('generate-loading', false);
          this.specimens = response.data.data;
          this.traumas = response.data.traumas;
          this.traumasByZonesList = response.data.traumas_by_zones_list;
          this.totalSearchCount = response.data.meta.total;
          this.getHeaders();
          this.showTable = true;
        }).catch(error => {
          console.log(error);
          this.showTable = false;
          eventBus.$emit('generate-loading', false);
        })
      }
      else{
        this.disable_generate=false;
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
      project_id: 'theProjectId',
      items_bones: 'getBones',
      getBone: 'getBone',
      items_traumas: 'getTraumas',
    }),
    specimenItems(){
      const rows = [];
      Object.values(this.specimens).forEach(item => {
        let traumaColumns = {};
        Object.values(this.traumas).forEach(
            trauma =>
                (traumaColumns[trauma.name] = this.traumasByZonesList[item.id][trauma.name]==='N/A'? '✔-Present in all Zones':'')
        );
        rows.push({
          id: item.id,
          key: this.getKey(item),
          bone: item.sb.name,
          side: item.side,
          ...traumaColumns
        });
      });

      return rows;
    },
    columnVisibility(){
      return this.headers.filter(item => item.visibility === true);
    },

  }
}
</script>