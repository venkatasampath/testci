<template>
  <div class="m-2">
    <contentheader :trail="this.trail" :title="this.heading" :help_menu="true"></contentheader>
    <snackbar v-if="snackbar === true" :snackbar_color="snackbar_color" :snackbar_text="snackbar_text"
              :snackbar="snackbar" @close="snackbar = false"></snackbar>
    <v-row>
      <v-col cols="9">
        <v-btn-toggle v-model="toggle_multiple" dense multiple>
          <v-btn>Excel</v-btn>
          <v-btn>PDF</v-btn>
          <v-menu right offset-x :close-on-content-click="false" max-height="500px">
            <template v-slot:activator="{ on }">
              <v-btn v-on="on">Column Visibility
                <v-icon right>$dropdown</v-icon>
              </v-btn>
            </template>
            <v-list>
              <v-list-item v-for="(header, index) in headers" :key="index">
                <v-checkbox v-bind:label="header.text" v-model="header.visibility" :value="header.visibility"/>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-btn-toggle>
      </v-col>
      <v-col cols="3">
        <v-text-field v-model="search" label="Search" clearable append-icon="mdi-magnify" dusk="search-datatable"/>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="3">
        <v-btn color="success" @click="submitFile()" :disabled=isDisabled dusk="export-table-advanced">Export Tables</v-btn>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="3">
        <v-checkbox v-model="timestamp" label='Include Timestamp' dusk="include-timestamp" hide-details/>
      </v-col>
    </v-row>
    <v-progress-linear v-if="loading" :indeterminate="loading"/>
    <div class="row">
      <div class="col-md-3" v-for="(item, index) in results" :key="index">
        <v-data-table v-model="selected" :headers="item.tableName" :items="item.tableColumns" show-select
                      :loading="loading" disable-pagination height="400px"  fixed-header
                      class="elevation-1" hide-default-footer dusk="select-entire-table">
          <template v-slot:body="{ items }">
            <tbody>
            <tr v-for="(item1, index) in item.tableColumns" :key="index">
              <td>
                <v-checkbox v-model="selected" :value="item1" style="margin:0;padding:0" hide-details dusk="export-table-column"/>
              </td>
              <td>{{ item1.text }}</td>
            </tr>
            </tbody>
          </template>
        </v-data-table>
      </div>
    </div>
  </div>
</template>

<script>
import {mapGetters} from 'vuex';
import axios from "axios";

export default {
  name: "file-export-advanced",
  props: {
    heading: {type: String, default: "Advanced Export Files"},
  },
  data() {
    return {
      search: '',
      tables:{},
      selectedTables :[],
      selectedColumns:[],
      toggle_multiple: [],
      loading: false,
      path: '',
      segments: [],
      itemId: null,
      headers: [],
      results: [],
      selected: [],
      timestamp: false,
      snackbar: false,
      snackbar_text: '',
      snackbar_color: '',
      trail: [{text: 'Home', disabled: false, href: '/',},
        {text: 'Advanced Export Files', disabled: true, href: '/',},
      ],
    }
  },

  created() {

  },
  mounted() {
    this.getIdFromUrl();
    this.getExportDetails();
  },

  methods: {
    getIdFromUrl() {
      this.path = window.location.pathname;
      this.segments = this.path.split("/");
      this.itemId = this.segments[3];
    },

    getExportDetails() {
      this.loading = true;
      axios({
        url: '/api/files/export-details/' + this.itemId,
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': this.$store.getters.bearerToken,
        }
      }).then(response => {
        let data = response.data.data;
        let tableArray = data.tableArray ? data.tableArray : null;
        this.getTableAndColumns(tableArray);
        this.loading = false;
      }).catch(error => {
        this.snackbar = true;
        this.snackbar_text = 'Failed to get the export type details. Please try again.';
        this.snackbar_color = 'info';
        console.log(error);
      })
    },

    getTableAndColumns(tableArray) {
      this.results = [];
      let columns = [];
      let tableNameArray = [];
      Object.entries(tableArray).forEach(([key, value]) => {
        columns = [];
        tableNameArray = [];
        tableNameArray.push({text: key, value: key, selected: false});
        for (let v in value) {
          if (value.hasOwnProperty(v)) {
            columns.push(({id: key + ':' + value[v], text: value[v], value: value[v]}))
          }
        }
        this.results.push({
          tableName: tableNameArray,
          tableColumns: columns,
        });
      });
    },
    submitFile() {
      let tableObject = {};
      for(let i=0; i<this.selected.length;i++) {
        let a = this.selected[i].id.split(':');
        if (this.selectedTables.indexOf(a[0]) === -1) {
          this.selectedTables.push(a[0]);
        }
      }
      this.selectedTables.forEach(tablename => {
        let rows = [];
        let tableAndCols = {};
        Object.values(this.selected).forEach(item => {
          let cols = (item.id).split(':');
          if (cols[0] === tablename) {
            rows.push(cols[1]);
          }
        });
        tableAndCols[tablename] = rows;
        this.selectedColumns.push(tableAndCols);
      });
      this.selectedColumns.forEach(column =>{
        tableObject = Object.assign(tableObject,column);
      })
      this.tables = Object.assign({tables:this.selectedTables, 'include-timestamps':this.timestamp}, tableObject);
      axios
          .request({
            url: '/api/files/export-file/'+this.itemId,
            method: 'POST',
            headers:{
              'Content-Type' : 'application/json',
              'Authorization' : this.$store.getters.bearerToken,
            },
            data: this.tables,
          }).then(response=>{
        console.log("success");

      }).catch(error => {
        console.log(error);
      });
    }
  },
  computed: {
    columnVisibility() {
      return this.headers.filter(item => item.visibility === true);
    },
    isDisabled() {
      return  this.selected.length === 0;
    },
    ...mapGetters({
      isAdmin: 'isAdmin',
      isOrgAdmin: 'isOrgAdmin',

    }),
  },
}
</script>

<style scoped>

</style>
