<template>
  <div class="m-2">
    <contentheader :trail="this.trail" :title="this.heading" :help_menu="true"></contentheader>
    <v-row>
      <v-col cols="9">
        <v-btn-toggle v-model="toggle_multiple" dense multiple>
          <v-btn>Excel</v-btn>
          <v-btn>PDF</v-btn>
          <v-menu right offset-x :close-on-content-click="false" max-height="500px">
            <template v-slot:activator="{ on }">
              <v-btn v-on="on">Column Visibility<v-icon right>$dropdown</v-icon></v-btn>
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
    <v-data-table :headers="columnVisibility" :items="exportRows" :options.sync="options" :server-items-length="totalSearchCount"
                  calculate-widths="" class="elevation-1" :sort-by="['created_at']" multi-sort :search="search" :loading="loading"
                  :footer-props="{ showFirstLastPage: true }">
      <template v-slot:item.actions="{ item }">
        <v-btn color="success" v-on:click="downloadExportedFiles(item.id, item.name)" dusk="fm-download">Download</v-btn>
      </template>



    </v-data-table>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import axios from "axios";
export default {
  name: "file-manager",
  props: {
    heading: {type: String, default: "File Manager"},
  },
  data() {
    return {
      searchResults: null,
      items: [],
      Export: {},
      rows:[],
      options: {},
      search: "",
      toggle_multiple: [],
      loading: false,
      totalSearchCount: 0,
      headers: [
        {text: 'Export', value: 'export', width: '10rem', visibility: true},
        {text: 'Export Type', value: 'name', width: '10rem', visibility: true},
        {text: 'Created By', value: 'created_by', width: '6rem', visibility: true},
        {text: 'Created At', value: 'created_at', width: '6rem', visibility: true},
        {text: 'Actions', value: 'actions', width: '6rem', visibility: true},
      ],
      trail: [{text: 'Home', disabled: false, href: '/',},
        {text: 'File Manager', disabled: true, href: '/',},
      ],
      pagination: {
        descending: true,
        page: 1,
        rowsPerPage: 10,
        sortBy: "Export",
        totalItems: 0
      },
    }
  },
  created() {
  },
  mounted() {
    this.loadGeneral();
  },
  methods: {
    loadGeneral: function () {
      this.loading = true;
      axios({
        url: '/api/files/exportFileManager',
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': this.$store.getters.bearerToken,
        }
      })
          .then(response => {
            this.Export = response.data.data.userExports;
            this.totalSearchCount = response.data.data.count;
            this.loading = false;
          })
          .catch((error) => {
            console.log(error);
          });
    },
    downloadExportedFiles(id, name) {
      axios({
        url: '/api/files/exportFileManager/'+name+'/download/'+id,
        method: 'GET',
        headers: {
          'Content-Type' :'text/csv',
          'Content-Description' :'File Download',
          'Authorization': this.$store.getters.bearerToken,
        },
      })
          .then(response => {
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            console.log(this.rows);
            let fileName = this.rows.filter(row => row.id === id)[0].export;
            link.setAttribute('download', fileName);
            document.body.appendChild(link);
            link.click();
          })
          .catch((error) => {
            console.log(error);
          })
    }
  },
  computed: {
    exportRows() {
      const rows = [];
      Object.values(this.Export).forEach(item =>
          rows.push(
              {
                id: item.id,
                export: item.filename,
                name: item.export_type,
                created_by: item.created_by,
                created_at: item.created_at,
              })
      );
      this.rows=rows;
      return rows;
    },
    columnVisibility() {
      return this.headers.filter(item => item.visibility === true);
    },
    ...mapGetters({
      isAdmin: 'isAdmin',
      isOrgAdmin: 'isOrgAdmin',
    }),
  }
}
</script>

<style scoped>
</style>