<template>
  <div class="m-2">
    <contentheader :trail="this.trail" model_name="org_user" :reset_menu="true" @eventReset="reset"
                   :collapse_menu="true" @eventCollapse="onExpand(false)" @eventExpand="onExpand(true)"
                   :generate_menu="true" :disable_generate="this.disable_generate"  @eventGenerate="generate">
    </contentheader>
    <br>
    <v-card>
      <v-container fluid v-show="showReportCriteria">
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete  v-model="form.projects" :items="project_items" label="Projects" placeholder="Select Project" item-value="projectsValue"
                             item-text="projectsText" clearable chips deletable-chips></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.user_id" :items="fetched_users" label="User" placeholder="Select User" item-text="name" item-value="id"
                            clearable chips deletable-chips :loading="loading"></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete  v-model="form.activity" :items="activity" label="Activity" placeholder="Select Specimen" item-value="activityValue" item-text="activityText"
                             clearable chips deletable-chips></v-autocomplete>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <date v-model="form.request_date_start" label="From"  name="request_date_start"></date>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <date v-model="form.request_date_end" label="To" :minvalue="form.request_date_start" name="request_date_end"></date>
          </v-col>
        </v-row>
      </v-container>
      <div v-show="showTable">
        <v-row>
          <v-col cols="9">
            <v-btn-toggle v-model="toggle_multiple" dense multiple>
              <v-btn>Excel</v-btn>
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
          <v-spacer></v-spacer>
          <v-col cols="3">
            <v-text-field v-model="search" label="Search" clearable append-icon="mdi-magnify" dusk="search-datatable"></v-text-field>
          </v-col>
        </v-row>
        <v-data-table :headers="columnVisibility" :items="activityItems" :items-per-page="perPage" :options.sync="options" :server-items-length="totalSearchCount"
                      calculate-widths="" class="elevation-1" :sort-by="['project_id']" multi-sort :search="search" :loading="loading"
                      :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }">
         <template v-slot:item.activity_status="{ item }">
            <v-icon
                right
                :color="getIconColor(item.activity_status)"
                small
            >{{ getBooleanIcon(item.activity_status) }}</v-icon>
          </template>
        </v-data-table>
        <br>
      </div>
    </v-card>
  </div>
</template>

<script>
import {mapGetters, mapState} from 'vuex';
import { eventBus } from '../../../eventBus';
import axios from "axios";

export default {
  name: "org-user-report",
  props: {
   //
  },
  data() {
    return {
      trail: [{ text: 'Home', disabled: false, href: '/'},
        { text: 'Org Reports Dashboard', disabled: false, href: '/reports/org/dashboard' },
        { text:  'User Report', disabled: true, href: '/' + this.user, },
      ],
      showReportCriteria: true,
      activity:[ 'Specimen', 'Isotope','User','Dna'],
      options: {},
      form: {},
      fetched_users:[],
      disable_generate: true,
      specimenstype: {},
      showTable: false,
      totalSearchCount: 0,
      perPage:100,
      loading: false,
      headers: [
        {text: 'Project Name', value: 'project_id', visibility: true},
        {text: 'Event Time', value: 'created_at', visibility: true},
        {text: 'Event', value: 'event', visibility: true},
        {text: 'Active Status', value: 'activity_status', visibility: true},
        {text: 'Specimen Key', value: 'specimen_key', visibility: true},
        {text: 'Old Values', value: 'old_values', visibility: true},
        {text: 'New Values', value: 'new_values', visibility: true},
      ],
      toggle_multiple: [],
      search: '',
    }
  },
  watch:{
    options: {
    handler () {
      this.generate()
      },
      deep: true,
    },
  },
  mounted() {
    this.fetchUsers();
  },
  created(){},
  methods: {
    fetchUsers() {
      this.loading = true;
      axios
          .request({ url: '/api/users', method: 'GET',
            headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
          })
          .then(response=>{
            this.fetched_users=response.data.data;
            this.disable_generate = false;
            this.loading = false;
          }).catch(error =>{
            this.loading = false;
          })
    },
    getBooleanIcon(item) {
      return item === true ? "✔" : "";
    },
    getIconColor(item) {
      return item === true ? "success" : "";
    },
    reset() {
      this.form = {};
      this.showTable = false;
    },
    onExpand(val) {
      this.showReportCriteria = val;
    },
    generate() {
        if (!this.disable_generate) {
          eventBus.$emit('generate-loading', true);
          this.showTable = false;
          axios
              .request({
                url: '/api/users/' +this.form.user_id+ '/audit',
                method: "GET",
                headers: {'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken},
                params: {type: this.form.activity,}
              }).then(response => {
                eventBus.$emit('generate-loading', false);
                this.specimenstype = response.data.data;
                this.showTable = true;
                this.totalSearchCount = response.data.meta.total;
              })
        } else {
          this.disable_generate =false;
          eventBus.$emit('disable_generate', this.disable_generate);
        }
    }
  },
  computed: {
    columnVisibility() {
      return this.headers.filter(item => item.visibility === true);
    },
    ...mapState({
      rowsPerPageItems: state => state.search.rowsPerPageItems,
    }),
    ...mapGetters({
      project_items: 'getProjectsIdNameArray',
      getProjectNameById: 'getProjectNameById',
      theOrg: 'theOrg',
      theUser: 'theUser'
    }),
    activityItems() {
      const rows = [];
        Object.values(this.specimenstype).forEach(item =>
                rows.push({
                  project_id: this.getProjectNameById(item.new_values.project_id ? item.new_values.project_id:"" ),
                  created_at: item.created_at ? item.created_at : "",
                  event: item.event ? item.event : "",
                  activity_status: item.user.active ? item.user.active : "",
                  specimen_key: item.new_values.accession_number ? item.new_values.accession_number:"" ,
                  old_values: JSON.stringify(item.old_values ? item.old_values : ""),
                  new_values: JSON.stringify(item.new_values ? item.new_values : ""),
                })
        );
      return rows;
    },
  }
}
</script>
