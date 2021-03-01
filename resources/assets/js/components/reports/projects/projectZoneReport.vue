<template>
  <div class="m-2">
  <contentheader :trail="this.trail" model_name="project_zone" :reset_menu="true" @eventReset="reset"
                 :collapse_menu="true" @eventCollapse="onExpand(false)" @eventExpand="onExpand(true)"
                 :generate_menu="true" dusk="se-zone-contentheader"  @eventGenerate="generate" :info_toolip="true" >
  </contentheader>
    <br>
    <v-card>
      <v-container fluid v-show="showReportCriteria">
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.an" :items="items_accessions" label="Accession Number" dusk="se-zone-accession" placeholder="Select Accession Number" clearable></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.p1" :items="items_provenance1" label="Provenance 1" dusk="se-zone-provenance1" placeholder="Select Provenance 1" clearable></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.p2" :items="items_provenance2" label="Provenance 2" dusk="se-zone-provenance2" placeholder="Select Provenance 2" clearable></v-autocomplete>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.sb_select" :items="items_bones" :loading="loading" dusk="se-zone-bone" :@change="getZoneFromBone" :rules="rules.itemBone" item-text="name" item-value="id" label="Bones" placeholder="Select Bone" clearable></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.side_select" :items="side" label="Side" dusk="se-zone-side" placeholder="Select Side" clearable></v-autocomplete>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="3" sm="12">
                <v-autocomplete v-model="form.zone_select" name="zone_select" :items="zone_select" :rules="rules.itemZone" item-text="display_name"
                                item-value="id" multiple chips deletable-chips label="Zones" placeholder="Select Zones"
                                dusk="se-zone-zone" :loading="loading" clearable >
                </v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.search_type_select" :items="searchTypes" label="Search Type" dusk="se-zone-search" :rules="rules.itemSearch" placeholder="Select Search Type" clearable></v-autocomplete>
          </v-col>
        </v-row>
      </v-container>
    <div v-show="showTable" >
      <div class="m-2">
        <v-row>
          <v-col cols="9">
            <v-btn-toggle v-model="toggle_multiple" dense multiple>
              <v-btn dusk="excel">Excel  </v-btn>
              <v-menu right offset-x :close-on-content-click="false" max-height="500px">
                <template v-slot:activator="{ on }">
                  <v-btn v-on="on" dusk="column-visibility">Column Visibility  <v-icon right>$dropdown</v-icon></v-btn>
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
            <v-text-field v-model="search" label="Search" clearable append-icon="mdi-magnify" dusk="se-zone-search-datatable"></v-text-field>
          </v-col>
        </v-row>
        <v-data-table :headers="columnVisibility" :items="specimenItems" :items-per-page="perPage" :options.sync="options" :server-items-length="totalSearchCount"
                      calculate-widths="" class="elevation-1" :sort-by="['key']" multi-sort :search="search" :loading="loading"
                      :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }">
          <template v-slot:item.key="{ item }"><a :href="`/skeletalelements/${item.id}`" target="_blank">{{ item.key }}</a></template>
        </v-data-table>
        <br>
      </div>
    </div>

    </v-card>
  </div>
</template>

<script>
import {mapGetters, mapState} from 'vuex';
import { eventBus } from '../../../eventBus';
import axios from "axios";

export default {
  name: "project-zone-report",
  // props: {
  //   text: { type: Object, default: () => {} }
  // },
  // zones:{
  //   type: [Array,Object],
  //   default: () => []
  // },
  data() {
    return {
      trail: [{ text: 'Home', disabled: false, href: '/'},
        { text: 'Reports Dashboard', disabled: false, href: '/reports/dashboard' },
        { text: 'Zone Report',  disabled: true, href: '/reports/zones', }, //changed this line
      ],
      showReportCriteria: true,
      form: {},
      dnas: {},
      items_zonesByBone: {},
      disable_zoneSelect: false,
      specimens: {},
      showTable: false,
      side: ["Left", "Right", "Middle", "Unsided"],
      searchTypes: ["Inclusive", "Exclusive", "Inclusive Only", "Exclusive Only", "Exclusive Or", "Not Present"],
      loadingSeqNum: false,
      loadingSubGrp: false,
      seqSubGrpData: {},
      seData: {},
      sb_select: '',
      baseuqNumrl:'/',
      rules: {
        itemBone: [ v => !!v || 'Bone is required'],
        itemZone: [ v => !!v || 'Zone is required'],
        itemSearch: [ v => !!v || 'Search Type is required'],
      },
      zoneOptions:{},
      totalSearchCount:0,
      perPage:100,
      disable_generate: true,
      options:{},
      search: '',
      columns: [],
      toggle_multiple: [],
      loading: false,
      zones: [],
      items: [],
      zonescolumns: [],
      headers: [
        {text: 'Key', value: 'key', visibility: true},
        {text: 'Bone', value: 'bone', visibility: true},
        {text: 'Side', value: 'side', visibility: true},
      ],
    }
  },
  watch: {
   options: {
      handler () {
        this.generate()
      },
      deep: true,
    }
  },
  methods: {
    getBooleanIcon(item) {
      return item === true ? "✔" : "";
    },
    getIconColor(item) {
      return item === true ? "success" : "";
    },
    getZones(item){
      var finalcolumns={};
      var zone_id = null;
      for(var col=0; col<this.zonescolumns.length; col++){
        if (item.id == this.zonescolumns[col].se_id){
          zone_id=this.zonescolumns[col].zone_id;
          finalcolumns[zone_id]=this.zonescolumns[col].presence?'✔':'';
        }
      }
      return finalcolumns;
    },
    getKey(item) {
      return `${item.accession_number ? item.accession_number : ''}:
                        ${item.provenance1 ? item.provenance1 : ''}:
                        ${item.provenance2 ? item.provenance2 : ''}:
                        ${item.designator ? item.designator : ''}`;
    },

    getHeaders(){
      this.headers.splice(3,1000);
      this.zones.forEach(zone =>
          this.headers.push({
            text:zone.display_name,
            // value:zone.id.toString(),
            value:zone.description,
            visibility: true
          })
      );
    },
    created(){
      let bone = this.$store.getters.getBones;
      this.bone_items = bone.filter( el => {return el.zones === true}) //changed el.measurements here
    },
    reset() {
      this.form = {};
      this.showTable = false;
    },
    onExpand(val) {
      this.showReportCriteria = val;
    },
    generate(){
      if (!this.disable_generate) {
        eventBus.$emit('generate-loading', true);
        this.showTable = false;
        axios
            .request({
                url: '/api/reports/projects/' + this.project_id + '/zones',
                method: "GET",
                headers: {
                  'Content-Type': 'application/json',
                  'Authorization': this.$store.getters.bearerToken
                },
                params: {
                  an: this.form.an ? [this.form.an] : null,
                  p1: this.form.p1 ? [this.form.p1] : null,
                  p2: this.form.p2 ? [this.form.p2] : null,
                  sb_select: this.form.sb_select ? this.form.sb_select : null,
                  side_select: this.form.side_select ? this.form.side_select : null,
                  zone_select: this.form.zone_select ? this.form.zone_select : null,
                  search_type_select: this.form.search_type_select ? this.form.search_type_select : null,
                  page: this.options.page,
                  per_page: this.perPage
                }
              }).then(response => {
            eventBus.$emit('generate-loading', false);
            this.zones = response.data.zones;
            this.showTable = true;
            this.specimens = response.data.data;
            this.totalSearchCount = response.data.meta.total;
            this.getHeaders();
        }).catch(error => {
          console.log(error);
          this.showTable = false;
          eventBus.$emit('generate-loading', false);
        })
      } else{
        this.disable_generate =false;
        eventBus.$emit('disable_generate', this.disable_generate);
      }
    },
  },
  computed: {
    ...mapState({
      rowsPerPageItems: state => state.search.rowsPerPageItems,
    }),
    ...mapGetters({
      items_accessions: 'getProjectAccessions',
      items_provenance1: 'getProjectProvenance1',
      items_provenance2: 'getProjectProvenance2',
      project_id: 'theProjectId',
      items_bones: 'getBones', //need this??
      getBone: 'getBone',
      item_zones_new: 'getZonesByBone'
    }),
    columnVisibility(){
      return this.headers.filter(item => item.visibility === true);
    },
    getZoneFromBone(){
      this.zone_select = this.item_zones_new(this.form.sb_select)
    },
    specimenItems() {
      const rows = [];
      Object.values(this.specimens).forEach(item => {

        let fullObject = {
          id: item.id,
          key: this.getKey(item),
          // individual_number: item.individual_number,
          bone:item.sb.name,
          side: item.side,
        };
        item.zones.forEach(zone=> {
          let attribute =    zone.description;
          fullObject[attribute] = zone.pivot.presence ?   '✔': '' ;
        })
        rows.push(fullObject)
      });
      return rows;
    },
  },
}
</script>