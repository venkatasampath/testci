<template>
  <div class="m-2">
    <contentheader :trail="this.trail" :title="this.heading" :help_menu="true"></contentheader>
    <snackbar v-if="snackbar === true" :snackbar_color="snackbar_color" :snackbar_text="snackbar_text" :snackbar="snackbar" @close="snackbar = false"></snackbar>
    <v-row>
      <v-col cols="9">
        <v-btn-toggle v-model="toggle_multiple" dense multiple>
          <v-btn dusk="excel-btn">Excel</v-btn>
          <v-btn dusk="pdf-btn">PDF</v-btn>
          <v-menu right offset-x :close-on-content-click="false" max-height="500px">
            <template v-slot:activator="{ on }">
              <v-btn v-on="on" dusk="column-visibility-btn">Column Visibility
                <v-icon right dusk="column-visibility-dropdown">$dropdown</v-icon>
              </v-btn>
            </template>
            <v-list>
              <v-list-item v-for="(header, index) in headers" :key="index">
                <v-checkbox v-bind:label="header.text" v-model="header.visibility" :value="header.visibility"
                            dusk="checkbox"/>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-btn-toggle>
      </v-col>

      <v-col cols="3">
        <v-text-field v-model="search" label="Search" clearable append-icon="mdi-magnify" dusk="search-datatable"/>
      </v-col>
    </v-row>
    <v-data-table :headers="columnVisibility" :items="exportRows" :options.sync="options"
                  :server-items-length="totalSearchCount"
                  calculate-widths="" class="elevation-1" :sort-by="['name','group']" multi-sort :search="search"
                  :loading="loading"
                  :footer-props="{ showFirstLastPage: true }">

      <template v-slot:item.actions="{ item }">
        <v-btn color="success" @click="submitJob(item.id)" dusk="export-btn">Export</v-btn>
        <v-btn v-if="isOrgAdmin || isAdmin" color="success" @click="exportAdvancePage(item.id)"
               :disabled="isDisabled(item)" dusk="advance-btn">Advanced
        </v-btn>
      </template>


    </v-data-table>
  </div>
</template>

<script>
import {mapGetters} from 'vuex';
import axios from "axios";

export default {
  name: "file-exports",
  props: {
    heading: {type: String, default: "Export Files"},
    //Export: { type: [ Array, Object ], default: null},
  },
  data() {
    return {
      searchResults: null,
      items: [],
      Export: {},
      options: {},
      search: '',
      toggle_multiple: [],
      loading: false,
      totalSearchCount: 0,
      tableNames: [],
      tableArray: {},
      snackbar: false,
      snackbar_text: '',
      snackbar_color: '',
      headers: [
        {text: 'Export Type', value: 'name', width: '10rem', visibility: true, filterable: true},
        {text: 'Group', value: 'group', width: '6rem', visibility: true},
        {text: 'Description', value: 'description', width: '6rem', visibility: true},
        {text: 'Actions', value: 'actions', width: '6rem', visibility: true},

      ],
      trail: [{text: 'Home', disabled: false, href: '/',},
        {text: 'Export Files', disabled: true, href: '/',},
      ],

      pagination: {
        descending: true,
        page: 1,
        rowsPerPage: 10,
        sortBy: "Export Type",
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
        url: '/api/files/export-types',
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': this.$store.getters.bearerToken,
        }
      }).then(response => {
        this.Export = response.data.data.exportTypes;
        this.totalSearchCount = response.data.data.count;
        //console.log(this.Export);
        //console.log(this.totalSearchCount);
        // For debugging purposes
        /*                console.log("meta: " + JSON.stringify(response.data.meta));
        console.log("links: " + JSON.stringify(response.data.links));*/
        this.loading = false;
      })
          .catch((error) => {
            this.snackbar = true;
            this.snackbar_text = 'Failed to get the export types. Please try again.';
            this.snackbar_color = 'info';
            console.log(error);
          });
    },

    exportAdvancePage(id) {
      window.location.href = '/exportOptions/advanced/' + id;
    },

    isDisabled(item) {
      return item.group === 'Project-Join';

    },

    submitJob(id) {
      this.loading = true;
      axios({
        url: '/api/files/export-all-tables',
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': this.$store.getters.bearerToken,
        },
        params: {
          id: id,
        },
      }).then(response => {
        let data = response.data;
        this.loading = false;
      }).catch(error => {
        this.snackbar = true;
        this.snackbar_text = 'Failed to Create File. Please try again.';
        this.snackbar_color = 'info';
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
                name: item.name,
                group: item.group,
                description: item.description,
                id: item.id,
                table_names: item.table_names,
              })
      );
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