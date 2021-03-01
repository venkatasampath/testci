<template>
  <div class="col-12">
    <contentheader :trail="this.trail" model_name="report-austrdna" :reset_menu="true" @eventReset="reset"
                   :collapse_menu="true" @eventCollapse="onExpand(false)" @eventExpand="onExpand(true)"
                   :generate_menu="true"  @eventGenerate="generate">
    </contentheader>
    <v-card>

      <v-container fluid v-show="showReportCriteria">
        <anp1p2dn v-model="form" :an="options.accession" :p1="options.provenance1" :p2="options.provenance2"
          :model-keys="{ an: 'an_select', p1: 'p1_select', p2: 'p2_select',}"/>

        <boneside  v-model="form" :bone="options.bone" :side="options.side" :required="false" :model-keys="{ bone: 'sb_id', side: 'side',}"/>

        <v-row>
          <v-col cols="12" md="3" sm="12">
          <completeness v-model="form.completeness" :required="false" class_value />
          </v-col>

          <v-col cols="12" md="3" sm="12">
            <created-by v-model="form.inventoried_by_user" :options="options.list_user" />
          </v-col>

          <v-col cols="12" md="3" sm="12">
            <reviewed-by v-model="form.reviewed_by_user" :options="options.list_user" />
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="3" sm="12">
            <measured v-model="form.measured" />
          </v-col>

          <v-col cols="12" md="3" sm="12">
            <dnasampled v-model="form.dna_sampled" />
          </v-col>

          <v-col cols="12" md="3" sm="12">
            <ctscanned v-model="form" :show-date="false" />
          </v-col>

          <v-col cols="12" md="3" sm="12">
            <clavicletriage v-model="form.clavicle_triage" />
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="3" sm="12">
            <xrayscanned v-model="form" :show-date="false" />
          </v-col>

          <v-col cols="12" md="3" sm="12">
            <inventorycompleted v-model="form" :show-date="false" />
          </v-col>

          <v-col cols="12" md="3" sm="12">
            <reviewed v-model="form" :show-date="false" />
          </v-col>
        </v-row>
      </v-container>
    </v-card>

    <v-row v-if="Object.keys(skeletalElements).length">
      <v-col>
        <advanced-specimen-report-result :skeletal-elements="skeletalElements" />
      </v-col>
    </v-row>
  </div>
</template>

<script>
import {eventBus} from "../../eventBus";

export default {
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
      trail: [{ text: 'Home', disabled: false, href: '/', },
        {text: 'Reports Dashboard', diasbled: false, href: '/reports/dashboard'},
        { text: 'Advanced Specimen Report', disabled: true, href: '/advanced', },
      ],
    };
  },

  methods: {
    reset() {
      this.form = {};
      this.skeletalElements = [];
    },
    onExpand(val) {
      this.showReportCriteria = val;
    },
    generate() {
      eventBus.$emit('generate-loading', true);
      document.getElementById("advanced-specimen-report").submit();
    }
  }
};
</script>
