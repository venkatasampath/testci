<template>
  <div class="m-2">
    <v-row>
      <v-col cols="9">
        <v-btn-toggle v-model="toggle_multiple" dense multiple>
          <v-btn dusk="excel">Excel</v-btn>
          <v-menu right offset-x :close-on-content-click="false" max-height="500px">
            <template v-slot:activator="{ on }">
              <v-btn v-on="on" dusk="column-visibility">Column Visibility<v-icon right>$dropdown</v-icon></v-btn>
            </template>
            <v-list>
              <v-list-item v-for="(header, index) in headers" :key="index">
                <v-checkbox v-bind:label="header.text" v-model="header.visibility" :value="header.visibility" :dusk="header.text"></v-checkbox>
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

    <v-data-table :headers="headers" :items="specimenData" :items-per-page="perPage" calculate-widths=""
                  class="elevation-1" multi-sort :search="search" :loading="loading" :sort-by="['key']">
      <template v-slot:item.key="{ item }"><a :href="`/skeletalelements/${item.id}`" target="_blank">{{ item.key }}</a></template>
      <template v-slot:item.sb="{ item }" :item-class="getDifference(item)" >{{ item.sb }}</template>
      <template v-slot:item.sb.articulated="{ item }" ><v-icon right :color="getIconColor(item.sb.articulated)"> {{ getBooleanIcon(item.sb.articulated) }}</v-icon></template>
      <template v-slot:item.individual_number="{ item }"><a :href="`/reports/individualnumberdetails/${item.individual_number}`" target="_blank">{{ item.individual_number }}</a></template>
      <template v-slot:item.paired="{ item }" ><v-icon right :color="getIconColor(item.paired)"> {{ getBooleanIcon(item.paired) }}</v-icon></template>
      <template v-slot:item.refit="{ item }" ><v-icon right :color="getIconColor(item.refit)"> {{ getBooleanIcon(item.refit) }}</v-icon></template>
      <template v-slot:item.articulated="{ item }" ><v-icon right :color="getIconColor(item.articulated)"> {{ getBooleanIcon(item.articulated) }}</v-icon></template>
      <template v-slot:item.mito_sequence_number="{ item }"><a :href="`/reports/mtdna/${item.mito_sequence_number}`" target="_blank">{{ item.mito_sequence_number }}</a></template>


    </v-data-table>
    <br>
  </div>
</template>
<script>
import {mapState} from "vuex";

export default {
  name: "seComparisonReportResult",
  props: {
    selectedSpecimensData: { type: Array }
  },
  data() {
    return {
      toggle_multiple: [],
      headers: [
        {text: 'Key', value: 'key', visibility: true},
        {text: 'Bone', value: 'sb', visibility: true},
        {text: 'Side', value: 'side', visibility: true},
        {text: 'Bone Group', value: 'bone_group', visibility: true},
        {text: 'Individual Number', value: 'individual_number', visibility: true},
        {text: 'Remains Status', value: 'remains_status', visibility: true},
        {text: 'Mito Seq Number', value: 'mito_sequence_number', visibility: true},
        {text: 'Zones', value: 'zones', visibility: true},
        {text: 'Trauma', value: 'traumas', visibility: true},
        {text: 'Pathology', value: 'pathologys', visibility: true},
        {text: 'Taphonomy', value: 'taphonomys', visibility: true},
        {text: 'Paired', value: 'paired', visibility: true},
        {text: 'Refit', value: 'refit', visibility: true},
        {text: 'Articulated', value: 'articulated', visibility: true},
      ],
      items: [],
      loading: false,
      search: '',
    }
  },
  mounted() {
    this.getDifference();
  },
  methods: {
    getBooleanIcon(item) {
      return item === true ? '✔' : 'x'
    },
    getIconColor(item) {
      return item === true ? 'success' : 'error'
    },
    getDifference(item) {

      let dataTable = document.getElementsByTagName('tbody')[0]; // data table
      let tableRows = dataTable.getElementsByTagName('tr'); // all the rows in the table
      let columns = tableRows[0].getElementsByTagName('td').length;

      let baseCell, secondRow, thirdRow, fourthRow, i;

      for (i = 3; i < columns; i++) {
        baseCell = tableRows[0].getElementsByTagName('td'); // row 1
        baseCell = baseCell[i];                                         // each column is the same number

        secondRow = tableRows[1].getElementsByTagName('td'); // row 2
        secondRow = secondRow[i];


        if(baseCell.innerHTML != secondRow.innerHTML) {
          secondRow.setAttribute("class", "alert alert-warning");
        }

        if(tableRows.length === 3) {
          thirdRow = tableRows[2].getElementsByTagName('td'); // row 3
          thirdRow = thirdRow[i];

          if(baseCell.innerHTML != thirdRow.innerHTML) {
            thirdRow.setAttribute("class", "alert alert-warning");
          }
        }

        if(tableRows.length === 4) {
          thirdRow = tableRows[2].getElementsByTagName('td'); // row 3
          thirdRow = thirdRow[i];

          fourthRow = tableRows[3].getElementsByTagName('td'); // row 4
          fourthRow = fourthRow[i];


          if(baseCell.innerHTML != thirdRow.innerHTML) {
            thirdRow.setAttribute("class", "alert alert-warning");
          }

          if(baseCell.innerHTML != fourthRow.innerHTML) {
            fourthRow.setAttribute("class", "alert alert-warning");
          }
        }
      }
    },
    getZoneArray(item) {
      let zoneArray = [];
      for(let i = 0; i < item.zones.length; i++) {
        zoneArray.push(' ' + item.zones[i].display_name);
      }
      return zoneArray;
    },
    getTaphonomies(item) {
      let taphonomyArray = [];
      for(let i = 0; i < item.taphonomys.length; i++) {
        taphonomyArray.push(' ' + item.taphonomys[i].type);
      }
      return taphonomyArray;
    },
    getTraumas(item) {
      let traumaArray = [];
      for(let i = 0; i < item.traumas.length; i++) {
        traumaArray.push(' ' + item.traumas[i].name);
      }
      return traumaArray;
    },
    getPathologies(item) {
      let pathologyArray = [];
      for(let i = 0; i < item.pathologys.length; i++) {
        pathologyArray.push(' ' + item.pathologys[i].name);
      }
      return pathologyArray;
    },
  },
  computed: {
    ...mapState({
      perPage: state => state.search.perPage,
      rowsPerPageItems: state => state.search.rowsPerPageItems,
    }),
    specimenData() {
      let rows = [];

      Object.values(this.selectedSpecimensData).forEach(item =>
          rows.push({
            id :item.id,
            key: item.key,
            sb: item.sb.name,
            side: item.side,
            bone_group: item.bone_group,
            individual_number: item.individual_number,
            remains_status: item.remains_status,
            mito_sequence_number: item.mito_sequence_number,
            pathologys: this.getPathologies(item),
            taphonomys: this.getTaphonomies(item),
            paired: item.sb.paired,
            refit: item.sb.refit,
            articulated: item.sb.articulated,
            zones: this.getZoneArray(item),
            traumas: this.getTraumas(item)
          })
      );

      return rows;
    },
  },
}
</script>

<style scoped>

</style>