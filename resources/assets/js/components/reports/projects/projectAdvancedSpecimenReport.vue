<template>
  <div class="m-2">
    <contentheader :trail="this.trail" model_name="report-austrdna" :reset_menu="true" @eventReset="reset"
                   :collapse_menu="true" @eventCollapse="onExpand(false)" @eventExpand="onExpand(true)"
                   :generate_menu="true" :disable_generate="this.disable_generate" @eventGenerate="generate">
    </contentheader>
    <br>
    <v-card>
      <v-container fluid v-show="showReportCriteria">
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.an" :items="items_accessions" label="Accession Number" placeholder="Select Accession Number" dusk="se-accession" clearable > </v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.p1" :items="items_provenance1" label="Provenance 1" placeholder="Select Provenance 1" dusk="se-provenance1" clearable></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.p2" :items="items_provenance2" item-text="name"  label="Provenance 2" placeholder="Select Provenance 2" dusk="se-provenance2"  clearable></v-autocomplete>
          </v-col>

          <!-- <v-col cols="12" md="3" sm="12">
             <v-text-field v-model="form.designator" label="Designator" placeholder="Designator: e.g., 403, 709" clearable></v-text-field>
           </v-col>-->
        </v-row>
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.sb_select"  :items="items_bones" item-value="id" item-text="name"  label="Bone" placeholder="Select Bone" dusk="se-bone" clearable></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.side_select" :items="items_side" label="Side" placeholder="Select Side" dusk="se-side" clearable></v-autocomplete>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.completeness" :items="items_completeness" label="Completeness" placeholder="Select Completeness" dusk="se-completeness"  clearable></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.created_by" :items="items_created_by" label="Created By" placeholder="Select Created By" dusk="se-created" clearable></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.reviewed_by" :items="items_reviewed_by" label="Reviewed By" placeholder="Select Reviewed By" dusk="se-reviewedBy"  clearable></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.inventoried_by"  :items="items_inventoried_by" label="Inventoried By" placeholder="Select Inventoried By" dusk="se-inventoried" clearable></v-autocomplete>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-switch v-model="form.measured" dusk="measured-button" label="Measured" />
          </v-col>

          <v-col cols="12" md="3" sm="12">
            <v-switch v-model="form.dna_sampled" dusk="se-dna_sampled" label="DNA Sampled" />
          </v-col>

          <v-col cols="12" md="3" sm="12">
            <v-switch v-model="form.ct_scanned" dusk="se-ct_scanned" label="CT Scanned" :show-date="false" />
          </v-col>

          <v-col cols="12" md="3" sm="12">
            <v-switch v-model="form.clavicle_triage" dusk="se-clavicle_triage" label="Clavicle Triage" />
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-switch v-model="form.xray_scanned" dusk="se-xray_scanned" label="Xray Scanned" :show-date="false" />
          </v-col>

          <v-col cols="12" md="3" sm="12">
            <v-switch v-model="form.inventory_completed" dusk="se-inventory_completed" label="Inventory Completed":show-date="false" />
          </v-col>

          <v-col cols="12" md="3" sm="12">
            <v-switch v-model="form.reviewed" dusk="se-reviewed" label="Reviewed" :show-date="false" />
          </v-col>
        </v-row>

      </v-container>
      <div v-show="showTable" >
        <v-row>
          <v-col cols="9">
            <v-btn-toggle v-model="toggle_multiple" dense multiple>
              <v-btn dusk="excel">Excel</v-btn>
              <v-menu right offset-x :close-on-content-click="false" max-height="500px">
                <template v-slot:activator="{ on }">
                  <v-btn v-on="on" dusk="column-visibility">Column Visibility<v-icon right dusk="collapse-button" >$dropdown</v-icon></v-btn>
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
        <v-data-table :headers="columnVisibility" :items="dnaItems" :items-per-page="perPage" :options.sync="options" :server-items-length="totalSearchCount"
                      calculate-widths="" class="elevation-1" :sort-by="['key']" multi-sort :search="search" :loading="loading"
                      :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }">
          <template v-slot:item.key="{ item }">
            <a :href="`/skeletalelements/${item.id}`" target="_blank">{{ item.key }}</a>
          </template>

          <template v-slot:item.dna_sampled="{ item }">
            <template v-if="item.dna_sampled">
              <a
                  class="mx-1"
                  v-for="(dna, index) in item.dnas"
                  :key="index"
                  :href="`/skeletalelements/${item.id}/dnas/${dna.id}`"
                  target="_blank"
              >{{ dna.sample_number }}</a>
            </template>
          </template>
          <template v-slot:item.mito_sequence_number="{ item }"><a :href="`/reports/mtdna/${item.mito_sequence_number}`" target="_blank">{{ item.mito_sequence_number }}</a></template>
          <template v-slot:item.measured="{ item }">
            <v-icon right :color="getIconColor(item.measured)" small>{{ getBooleanIcon(item.measured) }}</v-icon>
          </template>

          <template v-slot:item.isotope_sampled="{ item }">
            <v-icon
                right
                :color="getIconColor(item.isotope_sampled)"
                small
            >{{ getBooleanIcon(item.isotope_sampled) }}</v-icon>
          </template>

          <template v-slot:item.ct_scanned="{ item }">
            <v-icon
                right
                :color="getIconColor(item.ct_scanned)"
                small
            >{{ getBooleanIcon(item.ct_scanned) }}</v-icon>
          </template>

          <template v-slot:item.xray_scanned="{ item }">
            <v-icon
                right
                :color="getIconColor(item.xray_scanned)"
                small
            >{{ getBooleanIcon(item.xray_scanned) }}</v-icon>
          </template>

          <template v-slot:item.clavicle_triage="{ item }">
            <v-icon
                right
                :color="getIconColor(item.clavicle_triage)"
                small
            >{{ getBooleanIcon(item.clavicle_triage) }}</v-icon>
          </template>

          <template v-slot:item.inventoried="{ item }">
            <v-icon
                right
                :color="getIconColor(item.inventoried)"
                small
            >{{ getBooleanIcon(item.inventoried) }}</v-icon>
          </template>

          <template v-slot:item.reviewed="{ item }">
            <v-icon
                right
                :color="getIconColor(item.reviewed)"
                small
            >{{ getBooleanIcon(item.reviewed) }}</v-icon>
          </template>
          <template v-slot:item.mito_sequence_number="{ item }"><a :href="`/reports/mtdna/${item.mito_sequence_number}`" target="_blank">{{ item.mito_sequence_number }}</a></template>



        </v-data-table>
        <br>
      </div>
      <!-- <template v-if="resultsFetched">
         <project-advanced-specimen-report-result v-if="resultData.length" :skeletal-elements="resultData" :skeletal-element="skeletalElement"/>
       </template>-->
      <!--<project-advanced-specimen-report-result v-if="showTable" :specimen="specimen" :totalSearchCount="totalSearchCount"></project-advanced speciment-report-result>-->
      <!-- <snackbar v-if="snackbar == true" :snackbar_color="snackbar_color" :snackbar_text="snackbar_text" :snackbar="snackbar" @close="snackbar = false"></snackbar>-->

    </v-card>
  </div>
</template>
<script>
import {mapGetters, mapState} from 'vuex';
// import { changeObjectToArray } from "../../../coraBaseModules";
import { eventBus } from '../../../eventBus';
import axios from "axios";
// import snackbar from "../../common/snackbar";
export default {
  name: "project-advanced-specimen-report",
  /* components: {
     'snackbar':snackbar
   },
 */
  data() {
    return {
      // form: JSON.parse(JSON.stringify(this.formData)),
      trail: [{text: 'Home', disabled: false, href: '/',},
        {text: 'Reports Dashboard', disabled: false, href: '/reports/dashboard'},
        {text: 'Advanced Specimen Report', disabled: true, href: '/advanced',},
      ],
      form: {},
      sending: false,
      resultsFetched: false,
      info: false,
      showReportCriteria: true,
      showNextStep: false,
      totalSearchCount: 0,
      snackbar: false,
      snackbar_text: '',
      snackbar_color: '',
      resultData: [],
      showTable: false,
      disable_generate: true,
      specimens: {},
      resultConfidence:[],
      items_side: null,
      items_side_all: ["Left", "Right", "Middle", "Unsided"],
      items_completeness: ["Complete", "Incomplete"],
      items_created_by: [],
      items_reviewed_by: [],
      items_inventoried_by: [],
      headers: [
        { text: "Key", value: "key", visibility: true, width: "12rem" },
        { text: "Bone", value: "bone", visibility: true, width: "12rem" },
        { text: "Side", value: "side", visibility: true },
        { text: "Bone Group", value: "bone_group", visibility: true },
        { text: "Individual Number", value: "individual_number", visibility: true },
        { text: "DNA Sampled", value: "dna_sampled", visibility: true },
        { text: "Mito Sequence Number", value: "mito_sequence_number", visibility: true},
        { text: "Measured", value: "measured", visibility: true },
        { text: "Isotope Sampled", value: "isotope_sampled", visibility: true },
        { text: "Clavicle Triage", value: "clavicle_triage", visibility: true },
        { text: "CT Scanned", value: "ct_scanned", visibility: true },
        { text: "XRay Scanned", value: "xray_scanned", visibility: true },
        { text: "Inventoried", value: "inventoried" },
        { text: "Reviewed", value: "reviewed" },
        { text: "Inventoried By", value: "inventoried_by" },
        { text: "Inventoried At", value: "inventoried_at" },
        { text: "Reviewed By", value: "reviewed_by" },
        { text: "Reviewed At", value: "reviewed_at" },
        { text: "Created By", value: "created_by" },
        { text: "Created At", value: "created_at" },
        { text: "Updated By", value: "updated_by" },
        { text: "Updated At", value: "updated_at" }
      ],
      toggle_multiple: [],
      searchResults: null,
      items: [],
      options: {},
      search: "",
      loading: false,
      perPage:100,
      skeletalElements:[]
    };
  },
  watch: {
    options: {
      handler() {
        this.generate()
      },
      deep: true,
    }
  },
  created() {
    this.items_side = this.items_side_all
    this.items_completeness = this.items_completeness
    this.items_created_by = this.items_created_by
    this.items_reviewed_by = this.items_reviewed_by
    this.items_inventoried_by = this.items_inventoried_by
    this.items_groupSide = this.items_side_all
  },
  methods: {
    reset() {
      this.showNextStep = false;
      this.skeletalElement = {};
      this.resultData = [];
      this.specimens = [];
      this.form = {};
      this.showTable = false;
    },
    getKey(item) {
      return `${item.accession_number ? item.accession_number : ''}:
                          ${item.provenance1 ? item.provenance1 : ''}:
                          ${item.provenance2 ? item.provenance2 : ''}';
                          ${item.designator ? item.designator : ''}`;
    },
    getBooleanIcon(item) {
      return item === true ? "✔" : "";
    },
    getIconColor(item) {
      return item === true ? "success" : "";
    },
    onExpand(val) {
      this.showReportCriteria = val;
    },
    generate() {
      if (!this.disable_generate) {
        this.form.finalsearch = true;
        eventBus.$emit('generate-loading', true);
        this.showTable = false;
        axios
            .request({
              url: '/api/reports/projects/' + this.project_id + '/advanced',
              method: "GET",
              headers: {'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken},
              params: {
                an: this.form.an ? [this.form.an] : null,
                p1: this.form.p1 ? [this.form.p1] : null,
                p2: this.form.p2 ? [this.form.p2] : null,
                sb_id: this.form.sb_select ? this.form.sb_select : null,
                side: this.form.side_select? this.form.side_select : null,
                completeness: this.form.completeness ? this.form.completeness : null,
                created_by: this.form.created_by ? this.form.created_by : null,
                reviewed_by: this.form.reviewed_by ? this.form.reviewed_by : null,
                inventoried_by: this.form.inventoried ? this.form.inventoried : null,
                measured: this.form.measured ? this.form.measured : null,
                dna_sampled: this.form.dna_sampled ? this.form.dna_sampled : null,
                ct_scanned: this.form.ct_scanned ? this.form.ct_scanned : null,
                clavicle_triage: this.form.clavicle_triage ? this.form.clavicle_triage : null,
                xray_scanned: this.form.xray_scanned ? this.form.xray_scanned : null,
                inventory_completed: this.form.inventory_completed ? this.form.inventory_completed : null,
                reviewed: this.form.reviewed ? this.form.reviewed : null,
                page: this.options.page,
                per_page: this.perPage
              },
            }).then(response => {
          eventBus.$emit('generate-loading', false);
          this.showTable = true;
          this.skeletalElements = response.data.data;
          this.totalSearchCount = response.data.meta.total;
        }).catch(error => {
          console.log(error);
          eventBus.$emit('generate-loading', false);
        })
      } else {
        this.disable_generate = false;
        eventBus.$emit('disable_generate', this.disable_generate);
      }
    },
  },
  computed: {
    columnVisibility() {
      return this.headers.filter(item => item.visibility === true);
    },
    dnaItems() {
      const rows = [];
      Object.values(this.skeletalElements).forEach(item =>
          rows.push({
            id: item.id,
            key: item.key,
            bone: item.skeletalbone ? item.skeletalbone.name : null,
            side: item.side,
            bone_group: item.bone_group,
            individual_number: item.individual_number,
            dna_sampled: item.dna_sampled ? item.dna_sampled : "",
            dnas: item.dnas,
            mito_sequence_number: item.mito_sequence_number,
            measured: item.measured,
            isotope_sampled: item.isotope_sampled,
            clavicle_triage: item.clavicle_triage,
            ct_scanned: item.ct_scanned,
            xray_scanned: item.xray_scanned,
            inventoried: item.inventoried,
            inventoried_at: item.inventoried_at,
            inventoried_by: item.user ? item.user.name : null,
            reviewed: item.reviewed,
            reviewed_by: item.reviewer ? item.reviewer.name : null,
            reviewed_at: item.reviewed_at,
            created_by: item.created_by,
            created_at: item.created_at,
            updated_by: item.updated_by,
            updated_at: item.updated_at
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
      items_bones: 'getBones',
      project_id: 'theProjectId',
      getBone: 'getBone',
    }),
  },
}
</script>
<style scoped>
</style>