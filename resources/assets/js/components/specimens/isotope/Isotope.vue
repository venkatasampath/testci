<template>
  <div class="m-2">
    <contentheader :title="heading" :help_menu="true"
                   :trail="(action.create) ? trail.create : trail.default" model_name="isotope"
                   :isotope= "(action.create) ? null : isotope" :crud_action="action" @eventEdit="edit"  @eventSave="save">
    </contentheader>
    <br>
    <v-card flat>
      <v-stepper v-model="step" vertical>
        <v-stepper-step editable :complete="step > 1" step="1" >Isotope Information</v-stepper-step>
        <v-stepper-content step="1" >
          <v-card flat>
            <v-row>
              <v-col cols="12" md="3" sm="12" >
                <v-autocomplete v-model="form.lab_id" :items="labOptions" :disabled="!this.editLab" :loading="loading" item-text="name" item-value="id" label="Lab" color="primary" ></v-autocomplete>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.external_case_id" :disabled="!this.editable" :loading="loading" label="External Case #" placeholder="e.g. 2004H0114, 2015G1022"  color="primary" ></v-text-field>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field disabled v-model="form.sample_number" :loading="loading" label="Isotope Sample Number" color="primary" ></v-text-field>
              </v-col>
            </v-row>
          </v-card>
        </v-stepper-content>
        <v-stepper-step editable :complete="step > 2" step="2">Basic Information</v-stepper-step>
        <v-stepper-content step="2" >
          <v-card flat>
            <v-row>
              <v-col cols="12" md="3" sm="12" >
                <v-autocomplete v-model="form.batch_id" :items="getIsotopeBatch" :disabled="!this.editable" placeholder="Isotope Batches"  item-text="text" item-value="value" :loading="loading" color="primary" ></v-autocomplete>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-autocomplete v-model="form.results_confidence" :items="resultConfidence" :disabled="!this.editable" :loading="loading" placeholder="Result Status" color="primary" ></v-autocomplete>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.weight_sample_cleaned" :disabled="!this.editable" :loading="loading" label="Weight Sample Cleaned" type="number" suffix="grams" placeholder="e.g. 11.3, 20.45" color="primary" ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.demineralizing_start_date" disabled :loading="loading" label="Demineralizing Start Date" color="primary" ></v-text-field>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.demineralizing_end_date" disabled :loading="loading" label="Demineralizing End Date" color="primary" ></v-text-field>
              </v-col>
            </v-row>
          </v-card>
        </v-stepper-content>
        <v-stepper-step editable :complete="step > 3" step="3">Weight Information</v-stepper-step>
        <v-stepper-content step="3" >
          <v-card flat>
            <v-row>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.weight_vial_lid" :disabled="!this.editable" :loading="loading" label="Weight Vial and Lid" type="number" suffix="grams" placeholder="e.g. 11.3, 20.45" color="primary" ></v-text-field>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.weight_collagen" :disabled="!this.editable" :loading="loading" label="Weight Collagen" type="number" suffix="grams" placeholder="e.g. 11.3, 20.45" color="primary" ></v-text-field>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.weight_sample_vial_lid" :disabled="!this.editable" :loading="loading" label="Weight Sample, Vial and Lid" type="number" suffix="grams" placeholder="e.g. 11.3, 20.45" color="primary" ></v-text-field>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.yield_collagen" :disabled="!this.editable" :loading="loading" label="Yield Collagen" type="number" suffix="%" placeholder="e.g. 11.3, 20.45" color="primary" ></v-text-field>
              </v-col>
            </v-row>
          </v-card>
        </v-stepper-content>
        <v-stepper-step editable :complete="step > 4" step="4">Analysis Information</v-stepper-step>
        <v-stepper-content step="4" >
          <v-card flat>
            <v-row>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.collagen_weight_used_for_analysis" :disabled="!this.editable" :loading="loading" label="Collagen Weight used for Analysis" type="number" suffix="mg" placeholder="e.g. 11.3, 20.45" color="primary" ></v-text-field>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.analysis_requested" :disabled="!this.editable" :loading="loading" label="Analysis Requested" placeholder="e.g. 2004H0114, 2015G1022" color="primary" ></v-text-field>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.well_location" :disabled="!this.editable" :loading="loading" label="Well Location" placeholder="e.g. 2004H0114, 2015G1022" color="primary" ></v-text-field>
              </v-col>
            </v-row>
          </v-card>
        </v-stepper-content>
        <v-stepper-step editable :complete="step > 5" step="5">Carbon Information</v-stepper-step>
        <v-stepper-content step="5" >
          <v-card flat>
            <v-row>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.c_delta" :disabled="!this.editable" :loading="loading" label="Carbon Delta" type="number" suffix="ug" placeholder="e.g. 11.3, 20.45" color="primary" ></v-text-field>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.c_weight" :disabled="!this.editable" :loading="loading" label="Carbon Weight" type="number" suffix="ug" placeholder="e.g. 11.3, 20.45" color="primary" ></v-text-field>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.c_percent" :disabled="!this.editable" :loading="loading" label="Carbon Percentage" type="number" suffix="%" placeholder="e.g. 11.3, 20.45" color="primary" ></v-text-field>
              </v-col>
            </v-row>
          </v-card>
        </v-stepper-content>
        <v-stepper-step editable :complete="step > 6" step="6">Nitrogen Information</v-stepper-step>
        <v-stepper-content step="6" >
          <v-card flat>
            <v-row>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.n_delta" :disabled="!this.editable" :loading="loading" label="Nitrogen Delta" type="number" suffix="ug" placeholder="e.g. 11.3, 20.45" color="primary" ></v-text-field>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.n_weight" :disabled="!this.editable" :loading="loading" label="Nitrogen Weight" type="number" suffix="ug" placeholder="e.g. 11.3, 20.45" color="primary" ></v-text-field>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.n_percent" :disabled="!this.editable" :loading="loading" label="Nitrogen Percentage" type="number" suffix="%" placeholder="e.g. 11.3, 20.45" color="primary" ></v-text-field>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.c_to_n_ratio" :disabled="!this.editable" :loading="loading" label="Carbon/Nitrogen Ratio" type="number" suffix="%" placeholder="e.g. 11.3, 20.45" color="primary" ></v-text-field>
              </v-col>
            </v-row>
          </v-card>
        </v-stepper-content>
        <v-stepper-step editable :complete="step > 7" step="7">Oxygen Information</v-stepper-step>
        <v-stepper-content step="7" >
          <v-card flat>
            <v-row>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.o_delta" :disabled="!this.editable" :loading="loading" label="Oxygen Delta" type="number" suffix="ug" placeholder="e.g. 11.3, 20.45" color="primary" ></v-text-field>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.o_weight" :disabled="!this.editable" :loading="loading" label="Oxygen Weight" type="number" suffix="ug" placeholder="e.g. 11.3, 20.45" color="primary" ></v-text-field>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.o_percent" :disabled="!this.editable" :loading="loading" label="Oxygen Percentage" type="number" suffix="%" placeholder="e.g. 11.3, 20.45" color="primary" ></v-text-field>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.c_to_o_ratio" :disabled="!this.editable" :loading="loading" label="Carbon/Oxygen Ratio" type="number" suffix="%" placeholder="e.g. 11.3, 20.45" color="primary" ></v-text-field>
              </v-col>
            </v-row>
          </v-card>
        </v-stepper-content>
        <v-stepper-step editable :complete="step > 8" step="8">Sulphur Information</v-stepper-step>
        <v-stepper-content step="8" >
          <v-card flat>
            <v-row>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.s_delta" :disabled="!this.editable" :loading="loading" label="Sulphur Delta" type="number" suffix="ug" placeholder="e.g. 11.3, 20.45" color="primary" ></v-text-field>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.s_weight" :disabled="!this.editable" :loading="loading" label="Sulphur Weight" type="number" suffix="ug" placeholder="e.g. 11.3, 20.45" color="primary" ></v-text-field>
              </v-col>
              <v-col cols="12" md="3" sm="12" >
                <v-text-field v-model="form.s_percent" :disabled="!this.editable" :loading="loading" label="Sulphur Percentage" type="number" suffix="%" placeholder="e.g. 11.3, 20.45" color="primary" ></v-text-field>
              </v-col>
            </v-row>
          </v-card>
        </v-stepper-content>
      </v-stepper>
    </v-card>
    <v-card-actions>
      <v-row class="justify-center">
        <v-btn title="Save" color="primary" :disabled="!this.editable" class="mr-2" @click="save()"><v-icon class="mr-2">mdi-content-save</v-icon>Save</v-btn>
      </v-row>
    </v-card-actions>
  </div>
</template>

<script>
import {mapGetters} from "vuex";
import axios from 'axios';
import { changeObjectToArray } from "../../../coraBaseModules";
import {eventBus} from "../../../eventBus";
export default {
  name: "isotope",
  props: {
    crud_action: {type: String, default: "View"},
    isotope: {type: Object},
    list_isotope_batches: {type: Object},
  },
  data() {
    return {
      trail: {
        'create': [{text: 'Home', disabled: false, href: '/',},
          {text: 'Isotope', disabled: true, href: '/isotopes'},],
        'default': [{text: 'Home', disabled: false, href: '/',},
          {text: 'Isotope ', disabled: true, href: '/isotopes'},]
      },
      form: {},
      step: 1,
      showForm: true,
      heading: '',
      isotopes: {},
      resultConfidence: [ 'Pending', 'Reportable', 'Inconclusive', 'Unable to Assign', 'Cancelled' ],
      loading: false,
      editable: false,
      editLab: false,
      batchNumber: '',
      isotope_batches: [],
      read_only: true,
    };
  },
  created(){
    this.getIsotope();
  },
  watch: {

  },
  methods: {
    expand(val) {
      this.showForm = val;
    },
    save() {
      this.loading = true;
      axios
          .request({
            url: "/api/isotopes/" + this.isotope.id,
            method: "PUT",
            headers: {
              'Content-Type': 'application/json',
              'Authorization': this.$store.getters.bearerToken
            },
            data: this.form
          }).then(response => {
        this.isotopes = response.data.data;
        this.batchNumber = response.data.data.batch;
        this.loading = false;
        this.editable = false;
        this.editLab = false;
        this.setHeading();
        this.setFields();
        eventBus.$emit('show_edit');
      }).catch(error => {
        console.log(error);
        this.loading = false;
        this.snackbar=true;
        this.snackbar_text = 'Isotope Update unsuccessful. Please recheck your inputs.';
        this.snackbar_color = 'info';
      })
    },
    edit() {
      this.editable = true;
      if(this.batchNumber){
        this.editLab = false;
      }else{
        this.editLab = true;
      }
    },
    getIsotope() {
      this.loading = true;
      axios
          .request({
            url: '/api/isotopes/' + this.isotope.id,
            method: "GET",
            headers: {
              'Content-Type': 'application/json',
              'Authorization': this.$store.getters.bearerToken
            },
          }).then(response => {
        this.isotopes = response.data.data;
        this.batchNumber = response.data.data.batch;
        console.log(this.isotopes);
        this.setHeading();
        this.setFields();
        this.loading = false;
      }).catch(error => {
        console.log(error);
        this.loading = false;
      })
    },
    setHeading(){
      this.heading = "View Isotope - " + this.isotopes.sample_number;
    },
    setFields() {
      this.form = this.isotopes;
      this.form.batch_id = this.isotopes.batch_id.toString()

    },
  },
  computed: {
    ...mapGetters({
      getLabs: 'getLabs',
      project_id: 'theProjectId',
      getProject: 'getProjectById',
      getBone: 'getBone',
    }),
    labOptions () {
      let type = 'Isotope';
      return this.getLabs(type);
    },
    action() {
      const act = this.crud_action;
      return { create: act === "Create", view: act === "View", edit: (act === "Update" || act === "Edit"), list: act === "List", };
    },
    toolbarProps() {
      if (this.action.create || this.action.edit) {
        return { reset: true, save: {disabled: !this.edited} };
      } else if (this.action.view) {
        return { edit: true };
      } else {
        return {};
      }
    },
    getIsotopeBatch(){
      this.isotope_batches = changeObjectToArray(this.list_isotope_batches);
      return this.isotope_batches;
    }
  }
}
</script>
<style scoped>
</style>