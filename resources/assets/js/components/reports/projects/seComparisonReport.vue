<template>
  <div class="m-2">
    <contentheader :trail="this.trail" model_name="se_comparison" :reset_menu="true" @eventReset="reset" :collapse_menu="true"
                   @eventCollapse="onExpand(false)" @eventExpand="onExpand(true)" :generate_menu="true"   @eventGenerate="generate">
    </contentheader>
    <br>
    <v-card>
      <v-container fluid v-show="showReportCriteria">
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.an" :items="items_accessions" label="Accession Number" placeholder="Select Accession Number" clearable dusk="accession"></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.p1" :items="items_provenance1" label="Provenance 1" placeholder="Select Provenance 1" clearable dusk="provenance1"></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.p2" :items="items_provenance2" label="Provenance 2" placeholder="Select Provenance 2" clearable dusk="provenance2"></v-autocomplete>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="bone" :items="items_bones" item-text="name" item-value="id"  label="Bone" placeholder="Select Bone" clearable dusk="bone"></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="boneSide" :items="boneSideOptions" label="Bone Side" placeholder="Select Bone Side" dusk="bone-side"></v-autocomplete>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-btn primary @click.prevent="getSpecimenOptions()" :disabled="requireBone">
              <i class="fas fa-btn fa-list"></i>
              {{ loadingSpecimens ? 'Loading Specimens...' : 'Search for Specimens' }}
            </v-btn>
          </v-col>
        </v-row>

        <v-row v-show="selectSpecimens">
          <v-col cols="12" md="9">
            <v-autocomplete v-model="specimens" :items="specimenData" item-value="id" item-text="key_bone_side" label="Specimens" placeholder="Select Specimens"
                            multiple chips deletable-chips counter="4" required dusk="select-specimen"/>
          </v-col>
        </v-row>
      </v-container>

      <se-comparison-report-result v-if="showTable" :selectedSpecimensData="selectedSpecimensData"></se-comparison-report-result>
    </v-card>
  </div>
</template>
<script>
import axios from "axios";
import { mapGetters } from 'vuex';
import {eventBus} from "../../../eventBus";

export default {
  name: "se-comparison-report",
  props: {
    //
  },
  data() {
    return {
      form: [],
      showReportCriteria: true,
      loadingSpecimens: false,
      selectSpecimens: false,
      showTable: false,
      specimenData: [],
      selectedSpecimensData: [],
      specimens: [],
      bone: [0],
      boneSide: 'Left',
      boneSideOptions: [ "Left", "Right", "Middle", "Unsided" ],
      trail: [{ text: 'Home', disabled: false, href: '/', },
        { text: 'Reports Dashboard', disabled: false, href: '/reports/dashboard'},
        { text: 'Specimen Comparison Report', disabled: true, href: '/secomparisons', },
      ],
    };
  },
  mounted() {
    //
  },
  methods: {
    reset() {
      this.selectSpecimens = false;
      this.bone = [0];
      this.form = [];
    },
    onExpand(val) {
      this.showReportCriteria = val;
    },
    generate() {
      eventBus.$emit('generate-loading', true);
      axios
          .request({
            url: '/api/reports/projects/' + this.project_id + '/specimen-comparison',
            method: 'GET',
            headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken },
            params: { listIds: this.specimens }
          }).then(response => {
        this.selectedSpecimensData = response.data.data;
        eventBus.$emit('generate-loading', false);
        this.showTable = true;
      }).catch(error => {
        console.log(error);
        eventBus.$emit('generate-loading', false);
      })
    },
    getSpecimenOptions() {
      this.loadingSpecimens = true;
      axios
          .request({
            url: '/api/projects/' + this.project_id + '/specimens/advanced-search?list=true',
            method: 'GET',
            headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken },
            params: { bone: this.bone ? [this.bone] : null, side: this.boneSide ? [this.boneSide] : null,
              an: this.form.an ? [this.form.an] : null, p1: this.form.p1 ? [this.form.p1] : null, p2: this.form.p2 ? [this.form.p2] : null
            }
          }).then(response => {
        let tempSpecimenData = response.data.data;
        this.specimenData = [...tempSpecimenData];
        this.selectSpecimens = true;
        this.loadingSpecimens = false;
      }).catch(error => {
        this.loadingSpecimens = false;
        console.log(error);
      })
    },
  },
  computed: {
    ...mapGetters({
      items_accessions: 'getProjectAccessions',
      items_provenance1: 'getProjectProvenance1',
      items_provenance2: 'getProjectProvenance2',
      items_bones: 'getBones',
      project_id: 'theProjectId',
    }),
    requireBone(){
      return this.bone === undefined || this.bone[0] === 0;
    }
  }
}
</script>
