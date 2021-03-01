<template>
  <div class="col-12">
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
            <v-autocomplete v-model="form.trauma_select" :items="traumaData" item-text="text" item-value="value"
              dusk="se-trauma" label="Trauma" multiple chips deletable-chips placeholder="Select Traumas"/>
            <input type="hidden" name="trauma_select" :value="form.trauma_select" />
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" sm="12">
            <boneside v-model="form" :bone="options.bone" :side="options.side" :required="false" :model-keys="{ bone: 'sb_select', side: 'side_select',}"/>
          </v-col>
        </v-row>
      </v-container>
    </v-card>

    <v-row v-if="Object.keys(skeletalElements).length">
      <v-col>
        <trauma-report-result
          :skeletal-elements="skeletalElements"
          :traumas-by-zones-list="traumasByZonesList"
          :traumas="traumas"
        />
      </v-col>
    </v-row>
  </div>
</template>

<script>
import { changeObjectToArray } from "../../coraBaseModules";
import {eventBus} from "../../eventBus";

export default {
  name: "traumaReport",
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
      traumasByZonesList: this.reportResult.traumasByZonesList,
      traumas: this.reportResult.traumas,
      trail: [{ text: 'Home', disabled: false, href: '/', },
        {text: 'Reports Dashboard', diasbled: false, href: '/reports/dashboard'},
        { text: 'Trauma Report', disabled: true, href: '/traumas', },
      ],
    };
  },
  methods: {
    reset() {
      this.form = {};
      this.skeletalElements = [];
      this.traumasByZonesList = {};
      this.traumas = {};
    },
    onExpand(val) {
      this.showReportCriteria = val;
    },
    generate() {
      eventBus.$emit('generate-loading', true);
      document.getElementById("trauma-report").submit();
    }
  },
  computed: {
    traumaData() {
      return changeObjectToArray(this.options.trauma);
    }
  }
};
</script>
