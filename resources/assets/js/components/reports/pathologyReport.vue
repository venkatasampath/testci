<template>
  <div class="col-12 m-2">
    <contentheader :trail="this.trail" model_name="report-austrdna" :reset_menu="true" @eventReset="reset"
                   :collapse_menu="true" @eventCollapse="onExpand(false)" @eventExpand="onExpand(true)"
                   :generate_menu="true"  @eventGenerate="generate">
    </contentheader>
    <v-card outlined>

      <v-container fluid v-show="showReportCriteria">
        <anp1p2dn v-model="form" :an="options.accession" :p1="options.provenance1" :p2="options.provenance2"
          :model-keys="{ an: 'an_select', p1: 'p1_select', p2: 'p2_select',}"/>

        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete required v-model="form.pathology_select" :items="pathologyData" item-text="text" item-value="value"
              dusk="se-method-select" label="Pathology" multiple chips deletable-chips placeholder="Select Pathology"/>
            <input type="hidden" name="pathology_select" :value="form.pathology_select" />
          </v-col>
        </v-row>

        <boneside v-model="form" :bone="options.bone" :side="options.side" :rulesreqBone="false" :model-keys="{ bone: 'sb_select', side: 'side_select',}"/>
      </v-container>
    </v-card>

    <v-row v-if="Object.keys(skeletalElements).length">
      <v-col>
        <pathology-report-result :skeletal-elements="skeletalElements" :pathology-by-zones-list="pathologyByZonesList" :pathologies="pathologies"/>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import { changeObjectToArray } from "../../coraBaseModules";
import {eventBus} from "../../eventBus";

export default {
  name: "pathologyreport",
  props: {
    title: String,
    formData: {
      type: Object,
      default: () => {}
    },
    options: {
      type: Object,
      default: () => {}
    },
    reportResult: {
      type: [Array, Object],
      default: () => []
    }
  },
  data() {
    return {
      form: this.formData,
      showReportCriteria: true,
      skeletalElements: this.reportResult.skeletalElements
        ? this.reportResult.skeletalElements
        : [],
      pathologyByZonesList: this.reportResult.pathologyByZonesList,
      pathologies: this.reportResult.pathologies,
      trail: [{ text: 'Home', disabled: false, href: '/', },
        {text: 'Reports Dashboard', diasbled: false, href: '/reports/dashboard'},
        { text: 'Pathology Report', disabled: true, href: '/pathologys', },
      ],
    };
  },
  methods: {
    reset() {
      this.form = {};
      this.skeletalElements = [];
      this.pathologyByZonesList = {};
      this.pathologies = {};
    },
    onExpand(val) {
      this.showReportCriteria = val;
    },
    generate() {
      eventBus.$emit('generate-loading', true);
      document.getElementById("pathology-report").submit();
    }
  },
  computed: {
    pathologyData() {
      return changeObjectToArray(this.options.pathology);
    }
  }
};
</script>
