<template>
  <div >
    <contentheader :trail="this.trail" model_name="project_inumber" ></contentheader>
    <v-row>
      <v-col cols="9">
        <v-btn-toggle v-model="toggleMultiple" dense dark multiple>
          <v-btn dusk="excel">Excel</v-btn>
          <v-menu right offset-x :close-on-content-click="false" max-height="500px">
            <template v-slot:activator="{ on }">
              <v-btn v-on="on" dusk="column-visibility">
                Column Visibility
                <v-icon right>$dropdown</v-icon>
              </v-btn>
            </template>

            <v-list>
              <v-list-item v-for="(header, index) in headers" :key="index">
                <v-checkbox
                    v-bind:label="header.text"
                    v-model="header.visibility"
                    :value="header.visibility"
                    :dusk="header.text"
                />
              </v-list-item>
            </v-list>
          </v-menu>
        </v-btn-toggle>
      </v-col>

      <v-spacer />

      <v-col cols="3">
        <v-text-field v-model="search" label="Search" single-line hide-details />
      </v-col>
    </v-row>

    <v-data-table :headers="columnVisibility" :items="data" :items-per-page="perPage" :options.sync="options" :server-items-length="totalSearchCount"
                  calculate-widths="" class="elevation-1" :sort-by="['key']" multi-sort :search="search" :loading="loading"
                  :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }">

      <template v-slot:item.key="{ item }">
        <a :href="`/skeletalelements/${item.id}`" target="_blank">{{ item.key }}</a>
      </template>

      <template v-slot:item.sequence_numbers="{ item }">
        <a
            v-for="(sequence_number, index) in item.sequence_numbers"
            :key="index"
            :href="encodedmtdnaURI(sequence_number)" target="_blank">{{ sequence_number }}
          <br />
        </a>
      </template>

      <template v-slot:item.individual_number="{ item }">
        <a :href="encodedSpecimenURI(item)" target="_blank">{{ item.individual_number }}</a>
      </template>

      <template v-slot:item.specimens="{ item }">
        <a
            v-for="(specimen, index) in item.specimens"
            :key="index"
            :href="`/skeletalelements/${specimen.id}`"
            target="_blank">
          {{ specimen.key_bone_side }}
          <br />
        </a>
      </template>
    </v-data-table>
  </div>
</template>

<script>
import {eventBus} from "../../../eventBus";
import axios from "axios";
import {mapGetters, mapState} from "vuex";

export default {
  name: "projectIndividualNumberReport",

  data() {
    return {
      headers: [
        { text: "Individual Number", value: "individual_number", visibility: true },
        { text: "Specimen Count", value: "specimen_count", visibility: true },
        { text: "Specimens", value: "specimens", visibility: true },
        { text: "Mito Sequence Count", value: "mito_sequence_count", visibility: true },
        { text: "Sequence Numbers", value: "sequence_numbers", visibility: true }
      ],
      totalSearchCount:0,
      perPage:10,
      options:{},
      loading: false,
      specimen:[],
      inumbers:[],
      mitSeqNum_inum:{},
      se_by_inum:[],
      mitoSeq_countBy_inum:{},
      specimen_count:{},
      search: "",
      showTable: false,
      toggleMultiple: [],
      trail: [{ text: 'Home', disabled: false, href: '/', },
        {text: 'Reports Dashboard', diasbled: false, href: '/reports/dashboard'},
        { text: 'Individual Number Report', disabled: true, href: '/individualnumberdetails', },
      ],
    };
  },
  watch: {
    options: {
      handler() {
        this.generate()
      },
      deep: true,
    },
  },
  methods: {
        encodedSpecimenURI(item) {
          return "/reports/individualnumberdetails/" + encodeURI(item.individual_number);
        },
        encodedmtdnaURI(sequence_number) {
          return "/reports/mtdna/" + encodeURI(sequence_number);
        },
    generate(){
      this.loading = true;
      axios
          .request({
            url: '/api/reports/projects/' + this.project_id + '/individualnumber',
            method: "GET",
            headers: {
              'Content-Type': 'application/json',
              'Authorization': this.$store.getters.bearerToken
            },
            params: {
              page: this.options.page,
              per_page: this.perPage
            }
          }).then(response => {
        this.loading = false;
        this.specimen = response;
        this.inumbers = response.data.inumbers;
        this.mitSeqNum_inum = response.data.mitSeqNum_inum
        this.se_by_inum = response.data.se_by_inum
        this.mitoSeq_countBy_inum = response.data.mitoSeq_countBy_inum
        this.specimen_count = response.data.se_count
        this.totalSearchCount = response.data.meta.total;
        this.showTable = true;
      }).catch(error => {
        console.log(error);
        this.showTable = false;
        this.loading = false;
      })
    },
  },

  computed: {
    ...mapState({
      rowsPerPageItems: state => state.search.rowsPerPageItems,
    }),
    ...mapGetters({
      project_id: 'theProjectId'
    }),
    data() {
      const rows = [];
      Object.values(this.inumbers).forEach(individualNumber =>
          rows.push({
            individual_number: individualNumber,
            specimen_count: this.specimen_count[individualNumber],
            specimens: this.se_by_inum[individualNumber],
            mito_sequence_count: this.mitoSeq_countBy_inum[individualNumber],
            sequence_numbers: this.mitSeqNum_inum[individualNumber]
          })
      );
      return rows;
    },
    columnVisibility() {
      return this.headers.filter(item => item.visibility === true);
    }
  }
};
</script>
