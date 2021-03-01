<template>
  <div class="m-2" id="IsotopeInformation">
    <contentheader :title="this.heading" :help_menu="true" model_name="isotopecreate"></contentheader>
    <snackbar v-if="snackbar === true" :snackbar_color="snackbar_color" :snackbar_text="snackbar_text" :snackbar="snackbar" @close="snackbar = false"></snackbar>
    <br>
    <v-card>
    <v-row justify="center">
      <v-col cols="12" md="4" sm="12">
        <v-select
            v-model="form.lab"
            label="Lab"
            :rules="[rules.required]"
            :items="labOptions"
            placeholder="Select Lab" item-text="name" item-value="id"
        ></v-select>
      </v-col>
      <v-col cols="12" md="4" sm="12">
        <v-text-field
            v-model="form.external_case_id"
            label="External Case #"
            hide-details="auto"
            placeholder="Example 2004H0114, 20015G1022"
        ></v-text-field>
      </v-col>
      <v-col cols ="12" md="4" sm="12">
        <v-text-field v-model="form.sample_number"
                      label="Isotope Sample Number"
                      :rules="[rules.required]"
                      placeholder="Example 212A, 1446B"
        ></v-text-field>
      </v-col>
    </v-row>
        <v-row>
          <v-col align="center"
                 justify="center">
          <v-btn title="Save" color="primary" class="mr-2" @click="save()"><v-icon class="mr-2">mdi-content-save</v-icon>Save</v-btn>
          </v-col>
    </v-row>
    </v-card>
  </div>
</template>

<script>
import {mapGetters} from "vuex";
import axios from 'axios';

export default {
  name: "isotopeCreate",
  props: {
    specimen: {type: Object,},
    heading: { type: String, default: " Create Isotope" },
    crud_action: {type: String, default: "Create"},
  },
  data() {
    return {
      show_contentheader: this.contentheader,
      trail: {
        'create': [{text: 'Home', disabled: false, href: '/',},
          {text: 'Isotope', disabled: false, href: "/isotopes"},
          {text: 'New', disabled: true, href: "/"},],
        'default': [{text: 'Home', disabled: false, href: '/',},
          {text: 'Isotope', disabled: false, href:  "/isotopes"},
          {text: 'New', disabled: true, href: "/isotopes/create"},],
      },
      form:{},
      rules:{
        required: value => !!value || 'Required.'
      },
      snackbar: false,
      snackbar_text:'',
      snackbar_color:'',
    }
  },
  created(){
    console.log("the specimen info",this.specimen);
  },
  mounted() {
  },
  methods: {
    save() {
      axios.request({
        url: "/api/isotopes",
        method: 'POST',
        headers: {
          'content-Type': 'application/json',
          'Authorization': this.$store.getters.bearerToken,
        },
        data:{
          org_id: this.theOrg.id,
          project_id: this.project_id,
          lab_id: this.form.lab,
          se_id: this.specimen.id,
          sb_id: this.specimen.sb_id,
          external_case_id: this.form.external_case_id ? this.form.external_case_id: null,
          sample_number: this.form.sample_number ? this.form.sample_number: null
        },
      }).then(response => {
        let id = response.data.data.id;
        window.location.assign('/isotopes/' + this.specimen.id +'/' + id)
      }).catch(error => {
        this.snackbar=true;
        this.snackbar_text = 'Failed to Create Isotope. Please recheck your inputs.';
        this.snackbar_color = 'info';
      })
    }
  },
  computed:{
    ...mapGetters({
      getLabs: 'getLabs',
      project_id: 'theProjectId',
      theOrg: 'theOrg',


    }),
    labOptions () {
      let type = 'Isotope';
      return this.getLabs(type);
    },

    toolbarProps() {
      if (this.action.create || this.action.edit) {
        return { rese: true, save: {disabled: !this.edited} };
      } else if (this.action.view) {
        return { edit: true };
      } else {
        return {};
      }
    },
  }
}
</script>

<style>

</style>