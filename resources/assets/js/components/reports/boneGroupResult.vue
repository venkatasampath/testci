<template>
  <div class="m-2">
    <contentheader :trail="this.trail" :title="this.heading" :help_menu="true"></contentheader>
    <v-card>
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
      <v-data-table :headers="columnVisibility" :items="specimenItems" :items-per-page="perPage" :options.sync="options" :server-items-length="totalSearchCount"
                    calculate-widths="" class="elevation-1" :sort-by="['key']" multi-sort :search="search"  :loading="this.loading"
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
        <template v-slot:item.complete="{ item }"><v-icon right :color="checkColor(item.complete)">{{displayCheck(item.complete) }}</v-icon></template>
        <template v-slot:item.measured="{ item }"><v-icon right :color="checkColor(item.measured)">{{ displayCheck(item.measured) }}</v-icon></template>
        <template v-slot:item.isotope_sampled="{ item }"><v-icon right :color="checkColor(item.isotope_sampled)">{{ displayCheck(item.isotope_sampled) }}</v-icon></template>
        <template v-slot:item.clavicle_triage="{ item }"><v-icon right :color="checkColor(item.clavicle_triage)">{{ displayCheck(item.clavicle_triage) }}</v-icon></template>
        <template v-slot:item.ct_scanned="{ item }"><v-icon right :color="checkColor(item.ct_scanned)">{{ displayCheck(item.ct_scanned) }}</v-icon></template>
        <template v-slot:item.xray_scanned="{ item }"><v-icon right :color="checkColor(item.xray_scanned)">{{ displayCheck(item.xray_scanned) }}</v-icon></template>
      </v-data-table>
      <v-snackbar v-model="snackbar.show" top  centered :color="snackbar.color" @close="snackbar = false">{{snackbar.message}}</v-snackbar>
    </v-card>
  </div>
</template>

<script>
import {mapState, mapGetters} from 'vuex';
import axios from "axios";
export default {
  name: "boneGroupResult",
  props:{
    heading:{type:String},
    bonegroup:{type: String},
  },
  data() {
    return {
      trail: [{ text: 'Home', disabled: false, href: '/'},
        { text:  'Bone Group Report', disabled: true, href: '/bonegroup'},
      ],
      showReportCriteria: true,

      snackbar: {
        show: false,
        message: null,
        color: null
      },
      report_help:'',
      specimens:{},
      totalSearchCount:0,
      perPage:100,
      options:{},
      toggle_multiple: [],
      loading: false,
      headers: [
        { text: "Key", value: "key", visibility: true},
        { text: "Bone", value: "bone", visibility: true},
        { text: "Side", value: "side", visibility: true},
        { text: "Bone Group", value: "bone_group", visibility: true},
        { text: "Complete", value: "complete", visibility: true},
        { text: "Measured", value: "measured", visibility: true},
        { text: "DNA Sampled", value: "dna_sampled", visibility: true },
        { text: "Isotope Sampled", value: "isotope_sampled", visibility: true },
        { text: "Clavicle Triaged", value: "clavicle_triage", visibility: true},
        { text: "CT Scanned", value: "ct_scanned", visibility: true},
        { text: "Xray Scanned", value: "xray_scanned", visibility: true}
      ],
      search: "",
    }
  },
  watch: {
    options: {
      handler () {
        this.generate();
      },
      deep: true,
    },
  },
  methods: {
    generate() {
      this.loading = true;
      let url = '/api/reports/projects/' + this.project_id + '/bonegroup';
      axios({
        url: url,
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': this.$store.getters.bearerToken,},
        params:{ 'bone_group_id':this.bonegroup,
                 'page':this.options.page,
                 'per_page':this.options.itemsPerPage
        }
      })
              .then(response => {
                this.specimens = response.data.data;
                this.totalSearchCount = response.data.meta.total;
                // For debugging purposes
                console.log("meta: " + JSON.stringify(response.data.meta));
                console.log("links: " + JSON.stringify(response.data.links));
                this.loading = false;
              })
              .catch((error) => {
                console.log(error);
              });
    },
    getKey(item) {
      return `${item.accession_number ? item.accession_number : ""}:${
          item.provenance1 ? item.provenance1 : ""
      }:${item.provenance2 ? item.provenance2 : ""}:${
          item.designator ? item.designator : ""
      }`;
    },
    displayCheck(item) {
      return item === true ? "✔" : "";
    },
    checkColor(item) {
      return item === true ? "success" : "";
    }
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
      items_inumber: 'getProjectIndividualNumbers',
    }),
    specimenItems() {
      const rows = [];
      Object.values(this.specimens).forEach(item =>
          rows.push({
            id: item.id,
            key: this.getKey(item),
            bone:item.sb.name,
            side: item.side,
            bone_group: item.bone_group,
            dna_sampled: item.dna_sampled ? item.dna_sampled : "",
            dnas: item.dnas,
            complete: item.completeness === "Complete"? true : null,
            measured: item.measured,
            isotope_sampled:item.isotope_sampled,
            clavicle_triage:item.clavicle_triage,
            ct_scanned: item.ct_scanned,
            xray_scanned: item.xray_scanned,




          })
      );
      return rows;
    },
    columnVisibility() {
      return this.headers.filter(item => item.visibility === true);
    }
  },
}
</script>