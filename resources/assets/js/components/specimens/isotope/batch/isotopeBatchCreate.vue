<template>
  <div class="m-2" id="IsotopeInformation">
    <contentheader :title="this.heading" :help_menu="true" model_name="isotopebatch"></contentheader>
    <snackbar v-if="snackbar === true" :snackbar_color="snackbar_color" :snackbar_text="snackbar_text" :snackbar="snackbar" @close="snackbar = false"></snackbar>
    <br>
    <v-card>
    <v-row justify="center">
      <v-col cols="12" md="4" sm="12" dusk="lab">
        <v-select
            v-model="form.lab"
            label="Lab"
            :rules="[rules.required]"
            :items="labOptions"
            placeholder="Select Lab" item-text="name" item-value="id"
        ></v-select>
      </v-col>
      <v-col cols="12" md="4" sm="12" dusk="externalcase">
        <v-text-field
             v-model="form.external_case_id"
             label="External Case #"
            hide-details="auto"
            placeholder="Example 2004H0114, 20015G1022"
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="4" sm="12" dusk="isotopebatchnumber">
        <v-text-field v-model="form.batch_num"
              label="Isotope Batch Number"
            :rules="[rules.required]"
            placeholder="Example 212A,1446B "
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row>
      <v-col align="center"
             justify="center" dusk="save-btn">
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
    name: "isotopeBatchCreate",
    props: {
      heading: { type: String, default: " Create Isotope Batch" },
      // crud_action: {type: String, default: "Create"},
    },
    data() {
      return {
        show_contentheader: this.contentheader,
        trail: {
          'create': [{text: 'Home', disabled: false, href: '/',},
            {text: 'Isotope Batches ', disabled: false, href: "/isotopebatch"},
            {text: 'New', disabled: true, href: "/"},],
          'default': [{text: 'Home', disabled: false, href: '/',},
            {text: 'Isotope Batches ', disabled: false, href:  "/isotopebatch"},
            {text: 'New', disabled: true, href: "/isotopebatch/create"},],
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
    },
    mounted() {
    },
    methods: {
      save() {
        axios.request({
          url: '/api/isotope',
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': this.$store.getters.bearerToken,
          },
          params:{
            org_id: this.theOrg.id,
            project_id: this.project_id,
            lab_id: this.form.lab,
            batch_num: this.form.batch_num,
            external_case_id: this.form.external_case_id ? this.form.external_case_id: null
          },
        }).then(response => {
          let id = response.data.data.id;
          window.location.assign('/isotopebatch/associateisotopes/' + id)
        }).catch(error => {
            this.snackbar=true;
            this.snackbar_text = 'Failed to Create Isotope Batch. Please recheck your inputs.';
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
      // action() {
      //   const act = this.crud_action;
      //   return { create: act === "Create", view: act === "View", edit: (act === "Update" || act === "Edit"), list: act === "List", };
      // },
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