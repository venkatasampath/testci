<template>
    <div class="m-2" id="IsotopeInformation">
      <contentheader :trail="this.trail" :title="this.heading" :help_menu="true"></contentheader>
      <snackbar v-if="snackbar === true" :snackbar_color="snackbar_color" :snackbar_text="snackbar_text" :snackbar="snackbar" @close="snackbar = false"></snackbar>
      <br>
      <v-card>
      <v-row justify="center">
        <v-col cols ="12" md="4" sm="12">
          <v-autocomplete  v-model="form.project" :items="project_items" dusk="select-project" label="Projects" placeholder="Select Project" item-value="projectsValue" item-text="projectsText"
                           clearable @change="getProjectIsotopeList()"></v-autocomplete>
        </v-col>
        <v-col cols ="12" md="4" sm="12">
          <v-autocomplete v-model="form.isotopelist" dusk="select-isotopes" label="Isotopes" placeholder="Select Isotopes" :items="isotopeList" item-text="value" item-value="text" :rules="[rules.required]" :loading="Isoloading" multiple chips deletable-chips clearable></v-autocomplete>
        </v-col>
      </v-row>
        <v-row justify="center">
        <v-col cols ="12" md="8" sm="12">
          <v-autocomplete v-model="form.isotopesassociatedlist" dusk="associated-isotopes" label="Associated Isotopes" placeholder="Select Associated Isotopes" :items="associatedIsotopeList" item-text="value" item-value="text"
                          @change="removeAssociateIsotopes()" :loading="loading" multiple chips deletable-chips clearable></v-autocomplete>
        </v-col>
      </v-row>
    <v-row>
        <v-col align="center"
               justify="center">
            <v-btn title="Save" color="primary" class="mr-2" dusk="save" @click="associateIsotopes()"><v-icon class="mr-2">mdi-content-save</v-icon>Save</v-btn>
            <v-btn :disabled="disable" title="Next" color="primary" dusk="se-next" @click="startProcessing()"><v-icon>mdi-step-forward</v-icon>Start Processing</v-btn>
        </v-col>
    </v-row>
      </v-card>
    </div>
</template>

<script>
  import {mapGetters} from "vuex";
  import axios from 'axios';
  import {changeObjectToArray} from "../../../../coraBaseModules";

  export default {
  name: "associateIsotopes",
  props: {
    heading: { type: String, default: " Associate Isotopes" },
    crud_action: {type: String, default: "Edit"},
    isotopeBatch: {type: Object,},
  },

  data() {
    return {
      show_contentheader: this.contentheader,
      trail: [{ text: 'Home', disabled: false, href: '/', },
              { text: 'Associate Isotopes', disabled: true, href: "/" },],
      rules:{
        required: value => !!value || 'Required.'
      },
      snackbar: false,
      snackbar_text:'',
      snackbar_color:'',
      isotopes: {},
      isotope_list:[],
      associatedIsotopes:{},
      Isoloading: false,
      loading: false,
      disable:true,
      form:{},
    }
  },
  created(){
    this.getAssociatedIsotopes();
  },
  methods:{
    startProcessing() {
      this.associateIsotopes();
      axios.request({
        url: "/api/isotope/batch/" + this.isotopeBatch.id + '/startprocessing',
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': this.$store.getters.bearerToken,
        },
      }).then(response => {
        let status = response.data.data;
        console.log(status);
        window.location.assign('/isotopebatch/'+ this.isotopeBatch.id);
      }).catch(error => {
        console.log(error);
        this.snackbar=true;
        this.snackbar_text = 'Failed to Associate Isotopes. Please recheck your inputs.';
        this.snackbar_color = 'info';
      })
    },
    getProjectIsotopeList(){
      this.Isoloading = true;
        axios.request({
            url: '/api/isotope/projectisotopes',
            method: 'GET',
            headers: {
              'Content-Type': 'application/json',
              'Authorization': this.$store.getters.bearerToken,
            },
            params:{
              project_id: this.form.project ? this.form.project : this.project_id,
            },
          }).then(response => {
            this.isotopes = response.data.data;
            this.Isoloading = false;
          }).catch(error => {
            console.log(error);
            this.Isoloading = false;
        })
    },
    getAssociatedIsotopes(){
      this.loading = true;
      axios.request({
        url: "/api/isotope/associatedisotopes",
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': this.$store.getters.bearerToken,
        },
        params:{
          isotopebatch_id:this.isotopeBatch.id,
        },
      }).then(response => {
        this.loading = false;
        this.associatedIsotopes = response.data.data;
      }).catch(error => {
        console.log(error);
        this.loading = false;
      })
    },
    associateIsotopes() {
        if (typeof (this.form.isotopelist) !== 'undefined' || this.form.isotopelist !== null) {
            axios.request({
                url: '/api/isotope/batch/' + this.isotopeBatch.id + '/associateisotopes',
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': this.$store.getters.bearerToken,
                },
                params: {
                    isotopelist: this.form.isotopelist ? this.form.isotopelist : null,
                },
            }).then(response => {
                this.form.isotopesassociatedlist = [];
                this.associatedIsotopes = response.data.isotopes;
                this.form.isotopelist = [];
                this.disable = false;
                this.getProjectIsotopeList();
            }).catch(error => {
                console.log(error);
                this.disable = true;
                this.snackbar = true;
                this.snackbar_text = 'Failed to Associate Isotopes. Please recheck your inputs.';
                this.snackbar_color = 'info';
            })
        }   else{
                this.disable = true;
            }
      },
      removeAssociateIsotopes() {
              axios.request({
                  url: '/api/isotope/batch/'+ this.isotopeBatch.id +'/associateisotopes',
                  method: 'PUT',
                  headers: {
                      'Content-Type': 'application/json',
                      'Authorization': this.$store.getters.bearerToken,
                  },
                  data: {
                      isotopesassociatedlist: this.form.isotopesassociatedlist
                  },
              }).then(response => {
                  this.form.isotopesassociatedlist =[];
                  this.associatedIsotopes = response.data.isotopes;
                  this.form.isotopelist= [];
                  this.disable = false;
                  this.getProjectIsotopeList();
              }).catch(error => {
                  console.log(error);
                  this.disable = true;
                  this.snackbar = true;
                  this.snackbar_text = 'Failed to Associate Isotopes. Please recheck your inputs.';
                  this.snackbar_color = 'info';
              })
      }
  },
  computed:{
    ...mapGetters({
      project_items: 'getProjectsIdNameArray',
      theOrg: 'theOrg',
      project_id: 'theProjectId'

    }),
    isotopeList() {
      return changeObjectToArray(this.isotopes)
    },
    associatedIsotopeList() {
        this.form.isotopesassociatedlist = changeObjectToArray(this.associatedIsotopes);
      return changeObjectToArray(this.associatedIsotopes)
    },
    action() {
      const act = this.crud_action;
      return { create: act === "Create", view: act === "View", edit: (act === "Update" || act === "Edit"), list: act === "List", };
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

<style scoped>

</style>