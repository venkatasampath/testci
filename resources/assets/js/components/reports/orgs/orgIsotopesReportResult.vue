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

    <v-data-table :headers="columnVisibility" :items="dnaItems" :items-per-page="perPage" calculate-widths=""
                  class="elevation-1" multi-sort :search="search" :loading="loading" :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }"
                  :server-items-length="totalSearchCount" :sort-by="['key']">
<!--      <template v-slot:item.project_id="{ item }">{{ getProjectNameById(item.project_id) }}</template>-->
<!--      <template v-slot:item.individual_number="{ item }"><a :href="`/reports/individualnumber/${item.individual_number}`" target="_blank">{{ item.individual_number }}</a></template>-->
<!--      <template v-slot:item.sample_number="{ item }"><a :href="`/skeletalelements/${item.se_id}/dnas/${item.dna_id}`" target="_blank">{{ item.sample_number }}</a></template>-->
    </v-data-table>
    <br>
  </div>
</template>

<script>
import {mapGetters, mapState} from "vuex";

export default {
  name: "org-isotopes-report-results",
  props: {
    // dnas: { type: [ Array, Object ], default: null},
    // dna_type: { type: String, required: true },
    totalSearchCount: { type: Number, required: true },
  },
  data() {
    return {
      toggle_multiple: [],
      headers: [
        {text: 'Project', value: 'project_id', visibility: true},
        {text: 'Key', value: 'key', visibility: true},
        {text: 'Bone', value: 'bone', visibility: true},
        {text: 'Side', value: 'side', visibility: true},
        {text: 'Bone Group', value: 'bone_group', visibility: true},
        {text: 'Individual Number', value: 'individual_number', visibility: true},
        {text: 'Sample Number', value: 'sample_number', visibility: true}
        // {text: this.capitalizeDnaType(this.dna_type)+ ' Sequence Number', value: 'sequence_number', visibility: true},
        // {text: this.capitalizeDnaType(this.dna_type) + ' Sequence Subgroup', value: 'sequence_subgroup', visibility: true},
        // {text: this.capitalizeDnaType(this.dna_type) + ' Sequence Similar', value: 'sequence_similar', visibility: true},
        // {text: this.capitalizeDnaType(this.dna_type) + ' Result Status', value: 'result_status', visibility: true},
        // {text: this.capitalizeDnaType(this.dna_type) + ' Request Date', value: 'request_date', visibility: true},
        // {text: this.capitalizeDnaType(this.dna_type) + ' Receive Date', value: 'receive_date', visibility: true}
      ],
      items: [],
      loading: false,
      search: '',
    }
  },
  methods: {
    getKey(item) {
      return `${ item.accession_number ? item.accession_number : '' }:
                        ${ item.provenance1 ? item.provenance1 : '' }:
                        ${ item.provenance2 != "NONE" ? '' : item.provenance2 }:
                        ${ item.designator ? item.designator : '' }`;
    },
    capitalizeDnaType(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    }
  },
  computed: {
    columnVisibility(){
      return this.headers.filter(item => item.visibility === true);
    },
    // dnaItems() {
    //   const rows = [];
    //
    //   switch(this.dna_type) {
    //     case 'mito':
    //       Object.values(this.dnas).forEach(item =>
    //           rows.push({
    //             se_id: item.se_id,
    //             dna_id: item.id,
    //             project_id: item.project_id,
    //             key: this.getKey(item),
    //             bone: this.getBone(item.sb_id).name,
    //             side: item.side,
    //             bone_group: item.bone_group,
    //             individual_number: item.individual_number,
    //             sample_number: item.sample_number,
    //             sequence_number: item.mito_sequence_number,
    //             sequence_subgroup:item.mito_sequence_subgroup,
    //             sequence_similar: item.mito_sequence_similar,
    //             result_status: item.mito_results_confidence,
    //             request_date: item.mito_request_date,
    //             receive_date: item.mito_receive_date
    //           })
    //       );
    //       break;
    //     case 'austr':
    //       Object.values(this.dnas).forEach(item =>
    //           rows.push({
    //             se_id: item.se_id,
    //             dna_id: item.id,
    //             project_id: item.project_id,
    //             key: this.getKey(item),
    //             bone: this.getBone(item.sb_id).name,
    //             side: item.side,
    //             bone_group: item.bone_group,
    //             individual_number: item.individual_number,
    //             sample_number: item.sample_number,
    //             sequence_number: item.austr_sequence_number,
    //             sequence_subgroup: item.austr_sequence_subgroup,
    //             sequence_similar: item.austr_sequence_similar,
    //             result_status: item.austr_results_confidence,
    //             request_date: item.austr_request_date,
    //             receive_date: item.austr_receive_date
    //           })
    //       );
    //       break;
    //     case 'ystr':
    //       Object.values(this.dnas).forEach(item =>
    //           rows.push({
    //             se_id: item.se_id,
    //             dna_id: item.id,
    //             project_id: item.project_id,
    //             key: this.getKey(item),
    //             bone: this.getBone(item.sb_id).name,
    //             side: item.side,
    //             bone_group: item.bone_group,
    //             individual_number: item.individual_number,
    //             sample_number: item.sample_number,
    //             sequence_number: item.ystr_sequence_number,
    //             sequence_subgroup: item.ystr_sequence_subgroup,
    //             sequence_similar: item.ystr_sequence_similar,
    //             result_status: item.ystr_results_confidence,
    //             request_date: item.ystr_request_date,
    //             receive_date: item.ystr_receive_date
    //           })
    //       );
    //       break;
    //   }
    //   return rows;
    // },
    ...mapState({
      perPage: state => state.search.perPage,
      rowsPerPageItems: state => state.search.rowsPerPageItems,
    }),
    ...mapGetters({
      getBone: 'getBone',
      getProjectNameById: 'getProjectNameById',
    }),
  },
}
</script>

<style scoped>

</style>