<template>
  <div class="m-2">
    <contentheader :trail="this.trail" model_name="project_isotope" :reset_menu="true" @eventReset="reset"
                   :collapse_menu="true" @eventCollapse="onExpand(false)" @eventExpand="onExpand(true)"
                   :generate_menu="true" :disable_generate="this.disable_generate" @eventGenerate="generate">
    </contentheader>
    <br>
    <v-card>
      <v-container fluid v-show="showReportCriteria">
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.an" :items="items_accessions" label="Accession Number" placeholder="Select Accession Number" clearable dusk="accession-number"></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.p1" :items="items_provenance1" label="Provenance 1" placeholder="Select Provenance 1" clearable dusk="provenance1"></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.p2" :items="items_provenance2" item-text="name"  label="Provenance 2" placeholder="Select Provenance 2" clearable dusk="provenance2"></v-autocomplete>
          </v-col>

        </v-row>
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.batch_id" label="Batch ID" placeholder="Batch ID" clearable dusk="batch-id"></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.lab_id" :items="labOptions" label="Lab" placeholder="Select Lab" item-text="name" item-value="id"
                            multiple clearable chips deletable-chips dusk="lab"></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.results_confidence" :items="resultConfidence" label="Results Status" placeholder="Select Results Status"
                            clearable chips dusk="results-status"></v-autocomplete>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.yield_collagen_from" type="number" label="Collagen Yield From" placeholder="Collagen Yield From" clearable dusk="collagen-yield-from"></v-text-field>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.yield_collagen_to" type="number" label="Collagen Yield To" placeholder="Collagen Yield To" clearable dusk="collagen-yield-to"></v-text-field>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.weight_collagen_from" type="number" label="Collagen Weight From" placeholder="Collagen Weight From" clearable dusk="collagen-weight-from"></v-text-field>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.weight_collagen_to" type="number" label="Collagen Weight To" placeholder="Collagen Weight To" clearable dusk="collagen-weight-to"></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.c_weight_from" type="number" label="Carbon Weight From" placeholder="Carbon Weight From" clearable dusk="carbon-weight-from"></v-text-field>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.c_weight_to" type="number" label="Carbon Weight To" placeholder="Carbon Weight To" clearable dusk="carbon-weight-to"></v-text-field>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.n_weight_from" type="number" label="Nitrogen Weight From" placeholder="Nitrogen Weight From" clearable dusk="nitrogen-weight-from"></v-text-field>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.n_weight_to" type="number" label="Nitrogen Weight To" placeholder="Nitrogen Weight To" clearable dusk="nitrogen-weight-to"></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.o_weight_from" type="number" label="Oxygen Weight From" placeholder="Oxygen Weight From" clearable dusk="oxygen-weight-from"></v-text-field>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.o_weight_to" type="number" label="Oxygen Weight To" placeholder="Oxygen Weight To" clearable dusk="oxygen-weight-to"></v-text-field>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.s_weight_from" type="number" label="Sulfur Weight From" placeholder="Sulfur Weight From" clearable dusk="sulfur-weight-from"></v-text-field>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.s_weight_to" type="number" label="Sulfur Weight To" placeholder="Sulfur Weight To" clearable dusk="sulfur-weight-to"></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.c_percent_from" type="number" label="Carbon Percentage From" placeholder="Carbon Percentage From" clearable dusk="carbon-percentage-from"></v-text-field>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.c_percent_to" type="number" label="Carbon Percentage To" placeholder="Carbon Percentage To" clearable dusk="carbon-percentage-to"></v-text-field>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.n_percent_from" type="number" label="Nitrogen Percentage From" placeholder="Nitrogen Percentage From" clearable dusk="nitrogen-percentage-from"></v-text-field>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.n_percent_to" type="number" label="Nitrogen Percentage To" placeholder="Nitrogen Percentage To" clearable dusk="nitrogen-percentage-to"></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.o_percent_from" type="number" label="Oxygen Percentage From" placeholder="Oxygen Percentage From" clearable dusk="oxygen-percentage-from"></v-text-field>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.o_percent_to" type="number" label="Oxygen Percentage To" placeholder="Oxygen Percentage To" clearable dusk="oxygen-percentage-to"></v-text-field>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.s_percent_from" type="number" label="Sulfur Percentage From" placeholder="Sulfur Percentage From" clearable dusk="sulfur-percentage-from"></v-text-field>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.s_percent_to" type="number" label="Sulfur Percentage To" placeholder="Sulfur Percentage To" clearable dusk="sulfur-percentage-to"></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.c_to_n_ratio_from" type="number" label="Carbon to Nitrogen Ratio From" placeholder="Carbon to Nitrogen Ratio From" clearable dusk="carbon-to-nitrogen-ratio-from"></v-text-field>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.c_to_n_ratio_to" type="number" label="Carbon to Nitrogen Ratio To" placeholder="Carbon to Nitrogen Ratio To" clearable dusk="carbon-to-nitrogen-ratio-to"></v-text-field>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.c_to_o_ratio_from" type="number" label="Carbon to Oxygen Ratio From" placeholder="Carbon to Oxygen Ratio From" clearable dusk="carbon-to-oxygen-ratio-from"></v-text-field>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.c_to_o_ratio" type="number" label="Carbon to Oxygen Ratio To" placeholder="Carbon to Oxygen Ratio To" clearable dusk="carbon-to-oxygen-ratio-to"></v-text-field>
          </v-col>
        </v-row>

      </v-container>

      <div v-show="showTable">
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
                    <v-checkbox v-bind:label="header.text" v-model="header.visibility" :value="header.visibility" :dusk="header.text"></v-checkbox>
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

        <v-data-table :headers="columnVisibility" :items="dnaItems" :items-per-page="perPage" :options.sync="options" calculate-widths=""
                      class="elevation-1" multi-sort :search="search" :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }"
                      :server-items-length="totalSearchCount" :sort-by="['key']">
          <template v-slot:item.key="{ item }">
            <a :href="`/skeletalelements/${item.se_id}`" target="_blank">{{ item.key }}</a>
          </template>
          <template v-slot:item.individual_number="{ item }">
            <a :href="encodedSpecimenURI(item)" target="_blank">{{ item.individual_number }}</a>
          </template>
          <template v-slot:item.sample_number="{ item }"><a :href="`/skeletalelements/${item.se_id}/dnas/${item.dna_id}`" target="_blank">{{ item.sample_number }}</a></template>
        </v-data-table>
        <br>
      </div>
    </v-card>
  </div>
</template>
<script>
import { mapGetters } from 'vuex';
import { mapState } from 'vuex';
import { eventBus } from '../../../eventBus';
import axios from "axios";
export default {
  name: "projectIsotopeReport",
  data() {
    return {
      trail: [{text: 'Home', disabled: false, href: '/'},
        {text: 'Reports Dashboard', disabled: false, href: '/reports/dashboard'},
        {text: 'Isotopes Report', disabled: true, href: '/isotopes',},
      ],
      headers: [
        {text: 'Key', value: 'key', visibility: true},
        {text: 'Bone', value: 'bone', visibility: true},
        {text: 'Side', value: 'side', visibility: true},
        {text: 'Bone Group', value: 'bone_group', visibility: true},
        {text: 'Individual Number', value: 'individual_number', visibility: true},
        {text: 'Result Confidence', value: 'result_status', visibility: true},
        {text: 'Sample Number', value: 'sample_number', visibility: true},
        {text: 'Collagen Yield', value: 'collagen_yield', visibility: true},
        {text: 'Collagen Weight', value: 'collagen_weight', visibility: true},
        {text: 'Carbon Weight', value: 'c_weight', visibility: true},
        {text: 'Nitrogen Weight', value: 'n_weight', visibility: true},
        {text: 'Oxygen Weight', value: 'o_weight', visibility: true},
        {text: 'Sulfur Weight', value: 's_weight', visibility: true},
        {text: 'Carbon Percentage', value: 'c_percent', visibility: true},
        {text: 'Nitrogen Percentage', value: 'n_percent', visibility: true},
        {text: 'Oxygen Percentage', value: 'o_percent', visibility: true},
        {text: 'Sulfur Percentage', value: 's_percent', visibility: true},
        {text: 'Carbon to Nitrogen Ratio', value: 'c_to_n_ratio', visibility: true},
        {text: 'Carbon to Oxygen Ratio', value: 'c_to_o_ratio', visibility: true}
      ],
      perPage: 100,
      disable_generate: true,
      toggle_multiple: [],
      searchResults: null,
      items: [],
      options: {},
      search: "",
      loading: false,
      totalSearchCount: 0,
      showReportCriteria: true,
      form: {},
      isotopes: {},
      showTable: false,
      showNextStep: false,
      snackbar: false,
      snackbar_text: '',
      snackbar_color: '',
      specimens: [],
      dnas: [],
      items_side: null,
      items_groupSide: null,
      items_labs: [],
      items_side_all: ["Left", "Right", "Middle", "Unsided"],
      resultConfidence: ['Pending', 'Reportable', 'Inconclusive', 'Unable to Assign', 'Cancelled'],
      skeletalElement: {},
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
    reset() {
      this.form = {};
      this.showTable = false;
    },
    onExpand(val) {
      this.showReportCriteria = val;
    },
    generate() {
      if(!this.disable_generate) {
        eventBus.$emit('generate-loading', true);
        console.log("options: " + JSON.stringify(this.options));
        this.showTable = false;
        axios
            .request({
              url: '/api/reports/projects/' + this.project_id + '/isotopes',
              method: "GET",
              headers: {'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken},
              params: {
                an: this.form.an ? [this.form.an] : null,
                p1: this.form.p1 ? [this.form.p1] : null,
                p2: this.form.p2 ? [this.form.p2] : null,
                designator: this.form.designator ? [this.form.designator] : null,
                batch_id: this.form.batch_id ? [this.form.batch_id] : null,
                lab_id: this.form.lab_id ? this.form.lab_id : null,
                results_confidence: this.form.results_confidence ? [this.form.results_confidence] : null,
                yield_collagen_from: this.form.yield_collagen_from ? this.form.yield_collagen_from : null,
                yield_collagen_to: this.form.yield_collagen_to ? this.form.yield_collagen_to : null,
                weight_collagen_from: this.form.weight_collagen_from ? this.form.weight_collagen_from : null,
                weight_collagen_to: this.form.weight_collagen_to ? this.form.weight_collagen_to : null,
                c_weight_from: this.form.c_weight_from ? this.form.c_weight_from : null,
                c_weight_to: this.form.c_weight_to ? this.form.c_weight_to : null,
                n_weight_from: this.form.n_weight_from ? this.form.n_weight_from : null,
                n_weight_to: this.form.n_weight_to ? this.form.n_weight_to : null,
                o_weight_from: this.form.o_weight_from ? this.form.o_weight_from : null,
                o_weight_to: this.form.o_weight_to ? this.form.o_weight_to : null,
                s_weight_from: this.form.s_weight_from ? this.form.s_weight_from : null,
                s_weight_to: this.form.s_weight_to ? this.form.s_weight_to : null,
                c_percent_from: this.form.c_percent_from ? this.form.c_percent_from : null,
                c_percent_to: this.form.c_percent_to ? this.form.c_percent_to : null,
                n_percent_from: this.form.n_percent_from ? this.form.n_percent_from : null,
                n_percent_to: this.form.n_percent_to ? this.form.n_percent_to : null,
                o_percent_from: this.form.o_percent_from ? this.form.o_percent_from : null,
                o_percent_to: this.form.o_percent_to ? this.form.o_percent_to : null,
                s_percent_from: this.form.s_percent_from ? this.form.s_percent_from : null,
                s_percent_to: this.form.s_percent_to ? this.form.s_percent_to : null,
                c_to_n_ratio_from: this.form.c_to_n_ratio_from ? this.form.c_to_n_ratio_from : null,
                c_to_n_ratio_to: this.form.c_to_n_ratio_to ? this.form.c_to_n_ratio_to : null,
                c_to_o_ratio_from: this.form.c_to_o_ratio_from ? this.form.c_to_o_ratio_from : null,
                c_to_o_ratio_to: this.form.c_to_o_ratio_to ? this.form.c_to_o_ratio_to : null,
                page: this.options.page,
                per_page: this.perPage
              },
            }).then(response=>{
          eventBus.$emit('generate-loading', false);
          this.dnas = response.data.data;
          this.showTable = true;
          this.totalSearchCount = response.data.meta.total;
        }).catch(error=>{
          eventBus.$emit('generate-loading', false);
        })
      }
      else{
        this.disable_generate =false;
        eventBus.$emit('disable_generate', this.disable_generate);
      }
    },
    getKey(item) {
      return `${item.accession_number ? item.accession_number : ''}:
                        ${item.provenance1 ? item.provenance1 : ''}:
                        ${item.provenance2 ? item.provenance2 : ''}:
                        ${item.designator ? item.designator : ''}`;
    },
    encodedSpecimenURI(item) {
      return "/reports/individualnumberdetails/" + encodeURI(item.individual_number);
    },
  },
  computed: {
    columnVisibility(){
      return this.headers.filter(item => item.visibility === true);
    },
    dnaItems() {
      const rows = [];
      Object.values(this.dnas).forEach(item =>
          rows.push({
            se_id: item.se_id,
            key: this.getKey(item),
            bone: this.getBone(item.sb_id).name,
            side: item.side,
            bone_group: item.bone_group,
            individual_number: item.individual_number,
            sample_number: item.sample_number,
            result_status: item.results_confidence,
            collagen_yield: item.collagen_yield,
            collagen_weight: item.collagen_weight,
            c_weight: item.c_weight,
            n_weight: item.n_weight,
            o_weight: item.o_weight,
            s_weight: item.s_weight,
            c_percent: item.c_percent,
            n_percent: item.n_percent,
            o_percent: item.o_percent,
            s_percent: item.s_percent,
            c_to_n_ratio: item.c_to_n_ratio,
            c_to_o_ratio: item.c_to_o_ratio
          })
      );
      return rows;
    },
    ...mapState({
      rowsPerPageItems: state => state.search.rowsPerPageItems,
    }),
    ...mapGetters({
      items_accessions: 'getProjectAccessions',
      items_provenance1: 'getProjectProvenance1',
      items_provenance2: 'getProjectProvenance2',
      getLabs: 'getLabs',
      getBone: 'getBone',
      project_id: 'theProjectId',
    }),
    labOptions(){
      let type = 'Isotope';
      return this.getLabs(type);
    }
  }
}
</script>
<style scoped>
</style>