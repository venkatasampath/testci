<template>
  <div class="m-2">
    <contentheader :trail="this.trail" model_name="report-austrdna" :reset_menu="true" @eventReset="reset"
                   :collapse_menu="true" @eventCollapse="onExpand(false)" @eventExpand="onExpand(true)"
                   :generate_menu="true"  @eventGenerate="generate" :info_toolip="true" :info_toolip_text="options.report_help">
    </contentheader>
    <v-card>

    <v-container fluid v-show="showReportCriteria">
      <anp1p2dn v-model="form" :an="options.accession" :p1="options.provenance1" :p2="options.provenance2"
        :model-keys="{ an: 'an_select', p1: 'p1_select', p2: 'p2_select',}"/>

      <v-row>
        <v-col cols="12" sm="12"><boneside v-model="form" :bone="options.bone" :side="options.side" :required="false" :model-keys="{ bone: 'sb_select', side: 'side_select',}"/></v-col>
      </v-row>
      <v-row>
        <v-col cols="12" sm="12"><groupside v-model="form" :group="options.group" :group-side="options.groupside" :required="false" :model-keys="{ group: 'group_select', groupSide: 'group_side_select',}"/></v-col>
      </v-row>

      <v-row>
        <v-col cols="12" md="3" sm="12">
          <v-btn primary :disabled="sending" @click.prevent="getSpecimans()">
            <i class="fas fa-btn fa-list"></i>
            {{ sending ? 'Loading...' : 'Search for Skeletal Elements' }}
          </v-btn>
        </v-col>
      </v-row>

      <v-row v-show="showNextStep">
        <v-col cols="12" md="4">
          <v-autocomplete v-model="form.skeletalelement_select" :items="specimens" item-text="text" item-value="value"
            label="Specimen" placeholder="Select Specimen"/>
          <input type="hidden" name="skeletalelement_select" :value="form.skeletalelement_select" />
        </v-col>
      </v-row>
    </v-container>


    <template v-if="resultsFetched">
      <articulation-report-result v-if="resultData.length" :skeletal-elements="resultData" :skeletal-element="skeletalElement"/>
    </template>

    <snackbar v-if="snackbar == true" :snackbar_color="snackbar_color" :snackbar_text="snackbar_text" :snackbar="snackbar" @close="snackbar = false"></snackbar>

    </v-card>
  </div>
</template>

<script>
import axios from "axios";
import { changeObjectToArray } from "../../coraBaseModules";
import snackbar from "../common/snackbar";
import {eventBus} from "../../eventBus";

export default {
  name: "articulationsReport",

  props: {
    title: String,
    formData: { type: Object, default: () => {} },
    options: { type: Object, default: () => {} }
  },

  components: {
    'snackbar':snackbar
  },

  data() {
    return {
      form: JSON.parse(JSON.stringify(this.formData)),
      sending: false,
      resultsFetched: false,
      info: false,
      showReportCriteria: true,
      showNextStep: false,
      snackbar:false,
      snackbar_text:'',
      snackbar_color:'',
      specimens: [],
      resultData: [],
      skeletalElement: {},
      trail: [{ text: 'Home', disabled: false, href: '/', },
        {text: 'Reports Dashboard', diasbled: false, href: '/reports/dashboard'},
        { text: 'Articulations Report', disabled: true, href: '/articulation', },
      ],
    };
  },

  methods: {
    reset() {
      this.showNextStep = false;
      this.resultsFetched = false;
      this.skeletalElement = {};
      this.resultData = [];
      this.specimens = [];
      this.form = JSON.parse(JSON.stringify(this.formData));
    },

    onExpand(val) {
      this.showReportCriteria = val;
    },

    generate() {
      this.form.finalsearch = true;
      this.resultsFetched = false;
      eventBus.$emit('generate-loading', true);

      axios
        .request({
          url: "articulation/finalresults",
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.head.querySelector(
              'meta[name="csrf-token"]'
            ).content
          },
          data: this.form
        })
        .then(response => {
          const result = response.data;

          this.resultsFetched = true;
          eventBus.$emit('generate-loading', false);
          this.skeletalElement = result.se ? result.se : {};
          this.resultData = result.skeletalelements
            ? result.skeletalelements
            : [];
          if(this.resultData.length === 0) {
            this.snackbar=true;
            this.snackbar_text = 'No Articulation Records Found. Refine your search';
            this.snackbar_color = 'info';
          }
        })
        .catch(() => {
          this.resultsFetched = true;
          eventBus.$emit('generate-loading', false);
        });
    },

    getSpecimans() {
      this.sending = true;
      this.specimens = [];
      delete this.form.finalsearch;
      this.form.skeletalelement_select = null;

      axios
        .request({
          url: "articulation/results",
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.head.querySelector(
              'meta[name="csrf-token"]'
            ).content
          },
          data: this.form
        })
        .then(response => {
          const result = response.data;
          this.showNextStep = result.show;
          this.sending = false;

          if (result.show) {
            this.specimens = result.list_skeletalelement
              ? changeObjectToArray(result.list_skeletalelement)
              : [];
          }
        })
        .catch(() => {
          this.sending = false;
        });
    }
  }
};
</script>
