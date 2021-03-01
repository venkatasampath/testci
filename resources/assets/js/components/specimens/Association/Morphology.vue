<template>
   <div class="m-2">
      <contentheader v-if="show_contentheader" :trail="this.trail" :se_action_menu="(!action.create)"
                     model_name="morphologys"
                     :specimen="(action.create) ? null : specimen" :crud_action="action"
                     @eventEdit="edit" @eventReset="reset" @eventSave="save">
      </contentheader>
      <v-alert v-if="alert" class="my-1" border="left" colored-border type="info" elevation="2" dismissible>
         {{alertText}}
      </v-alert>
      <v-card flat>
         <v-row align="center" justify="center">
            <v-col cols="12" :md="cols">
               <v-toolbar v-if="show_toolbar">
                  <v-badge color="primary" :content="(this.morphologys) ? this.morphologys.length : 0">
                     Morphologys
                  </v-badge>
                  <v-spacer></v-spacer>
                  <v-tooltip v-if="show_toolbar_crud && !isEditing" v-model="showEdit" top>
                     <template v-slot:activator="{ on }">
                        <v-btn icon v-on="on" @click="edit" color="primary" :loading="loading">
                           <v-icon>mdi-pencil</v-icon>
                        </v-btn>
                     </template>
                     <span>Edit</span>
                  </v-tooltip>
                  <v-tooltip v-if="show_toolbar_crud && isEditing" v-model="showReset" top>
                     <template v-slot:activator="{ on }">
                        <v-btn icon v-on="on" @click="reset" color="primary" :loading="loading">
                           <v-icon>mdi-undo-variant</v-icon>
                        </v-btn>
                     </template>
                     <span>Reset</span>
                  </v-tooltip>
                  <v-tooltip v-if="show_toolbar_crud && isEditing" v-model="showSave" top>
                     <template v-slot:activator="{ on }">
                        <v-btn icon v-on="on" @click="save" color="primary" :loading="loading">
                           <v-icon>mdi-content-save</v-icon>
                        </v-btn>
                     </template>
                     <span>Save</span>
                  </v-tooltip>
                  <v-tooltip top>
                     <template v-slot:activator="{ on }">
                        <v-btn icon v-on="on" @click="showModal = !showModal" color="primary">
                           <v-icon small v-if="showModal">mdi-view-headline</v-icon>
                           <v-icon small v-if="!showModal">mdi-view-sequential</v-icon>
                        </v-btn>
                     </template>
                     <span v-if="showModal">Hide Details</span>
                     <span v-if="!showModal">Show Details</span>
                  </v-tooltip>
                  <v-tooltip top>
                     <template v-slot:activator="{ on }">
                        <v-btn icon v-on="on" @click="showCollapse = !showCollapse" color="primary">
                           <v-icon small v-if="showCollapse">mdi-arrow-collapse-up</v-icon>
                           <v-icon small v-if="!showCollapse">mdi-arrow-expand-down</v-icon>
                           <v-dialog v-model="showModal" scrollable lazy>
                              <v-card>
                                 <v-col cols="9">
                                    <v-menu right offset-x :close-on-content-click="false"
                                            max-height="500px">
                                       <template v-slot:activator="{ on }">
                                          <v-btn v-on="on">Column Visibility
                                             <v-icon right>$dropdown</v-icon>
                                          </v-btn>
                                       </template>

                                       <v-list>
                                          <v-list-item v-for="(header, index) in headers" :key="index">
                                             <v-checkbox v-bind:label="header.text"
                                                         v-model="header.visibility"
                                                         :value="header.visibility"/>
                                          </v-list-item>
                                       </v-list>
                                    </v-menu>
                                 </v-col>
                                 <v-data-table :headers="columnVisibility" :items="morphologysItems"
                                               class="elevation-1">
                                    <template v-slot:item.key_bone_side="{ item }">
                                       <a :href="/skeletalelements/ + specimen.id " target="_blank">
                                          {{ item.key_bone_side }}</a>
                                    </template>
                                    <template v-slot:item.measured="{ item }">
                                       <v-icon right :color="getIconColor(item.measured)">{{
                                          getBooleanIcon(item.measured) }}
                                       </v-icon>
                                    </template>
                                 </v-data-table>
                              </v-card>
                           </v-dialog>
                        </v-btn>
                     </template>
                     <span v-if="showCollapse">Collapse</span>
                     <span v-if="!showCollapse">Expand</span>
                  </v-tooltip>
               </v-toolbar>
               <v-card outlined v-show="(show_toolbar || show_contentheader) && showCollapse">
                  <v-autocomplete id="refits_id" v-model="morphologys" dusk="se-morphology-menu"
                                  :placeholder="isEditing ? '' : 'There are no Morphologys associated with this Specimen'"
                                  :items="morphologysList" item-value="value" item-text="text" dense chips
                                  multiple @change="search = ''"
                                  :readonly="!isEditing" :append-icon="isEditing ? '$dropdown': ''">
                  </v-autocomplete>
               </v-card>
            </v-col>
         </v-row>
      </v-card>
   </div>
</template>

<script>
    import axios from 'axios';
    import {mapGetters, mapState} from "vuex";
    import {changeObjectToArray, apiGetCall, apiPostCall} from '../../../coraBaseModules';

    export default {
        name: "Morphology",
        props: {
           list: {type: Object},
           specimen: {type: Object,},
           readonly: {type: Boolean, default: false},
           crud_action: {type: String, default: "View"},
           heading: {type: String, default: "Morpology"},
           toolbar: {type: Boolean, default: true},
           toolbar_crud: {type: Boolean, default: true},
           contentheader: {type: Boolean, default: true},
           cols: {type: Number, default: 12},
           morphologyDetails: {type: Object}
        },
       data() {
          return {
             alert: false,
             alertText: "",
             show_contentheader: this.contentheader,
             trail: [{text: 'Home', disabled: false, href: '/',},
                {
                   text: 'Specimen',
                   disabled: false,
                   href: (this.specimen) ? '/skeletalelements/' + this.specimen.id : "/"
                },
                {text: 'Morphology', disabled: true, href: "/"},
             ],
             show_toolbar: this.toolbar,
             show_toolbar_crud: this.toolbar_crud,
             loading: false,
             morphologys: null,
             type: 'morphologys',
             errored: null,
             isEditing: false,
             snackbar: false,
             showCollapse: true,
             showModal: false,
             morphologysItems: null,
             eleminationReason: [],
             eleminationOption: [
                {text: 'mtDNA', value: 'mtDNA'},
                {text: 'Fragmentary', value: 'Fragmentary'},
                {text: 'Morphology', value: 'Morphology'},
                {text: 'Age', value: 'Age'},
                {text: 'mtDNA and Morphology', value: 'mtDNA and Morphology'}
             ],
             headers: [
                {text: 'Key', value: 'key_bone_side', width: '8rem', visibility: true},
                {text: 'Bone', value: 'sb.name', width: '8rem', visibility: true},
                {text: 'Side', value: 'side', width: '8rem', visibility: true},
                {text: 'Bone Group', value: 'bone_group', width: '8rem', visibility: true},
                {text: 'Individual Number', value: 'individual_number', width: '8rem', visibility: true},
                {text: 'DNA Sampled', value: 'dnas[0].sample_number', width: '8rem', visibility: true},
                {text: 'Mito Sequence Number', value: 'mito_sequence_number', width: '8rem', visibility: true},
                {text: 'Measured', value: 'measured', width: '8rem', visibility: true},
                {text: 'Isotope Sampled', value: 'isotope_sampled', visibility: true},
                {text: 'Clavicle Triage', value: 'clavicle_triage', visibility: true},
                {text: 'CT Scanned', value: 'ct_scanned', visibility: true},
                {text: 'Xray Scanned', value: 'xray_scanned', visibility: true},
                {text: 'Inventoried', value: 'inventoried', visibility: false},
                {text: 'Reviewed', value: 'reviewed', visibility: false},
                {text: 'Inventoried By', value: 'inventoried_by', visibility: false},
                {text: 'Reviewed By', value: 'updated_by', visibility: false},
                {text: 'Inventoried At', value: 'inventoried_at', visibility: false},
                {text: 'Created By', value: 'created_by', visibility: false},
                {text: 'Created At', value: 'created_at', visibility: false},
                {text: 'Updated By', value: 'updated_by', visibility: false},
                {text: 'Updated At', value: 'updated_at', visibility: false},

             ]
          }
       },
       created() {
          this.getMorphologyTabledata();
       },
        mounted() {
            // on mounted load data asynchronous
            this.getMorphology();
        },
        computed: {
           morphologysList() {
              return changeObjectToArray(this.list)
            },
            ...mapState({
                perPage: state => state.search.perPage,
                rowsPerPageItems: state => state.search.rowsPerPageItems,
                bones: state => state.bones,
            }),
            ...mapGetters({
                bearerToken: 'bearerToken',
                csrfToken: 'csrfToken',
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
            }),
           action() {
              return {
                 create: this.crud_action === "Create", view: this.crud_action === "View",
                 edit: (this.crud_action === "Update" || this.crud_action === "Edit")
              };
           },
           columnVisibility() {
              return this.headers.filter(item => item.visibility === true);
           }
        },
        methods:{
            // ToDO this function will get replaced
            getMorphology: function(){
                this.loading=true;
                axios
                    .request({
                       url: '/api/specimens/' + this.specimen.id + '/associations?type=' + this.type,
                        method: 'GET',
                        headers:{
                            'Content-Type' : 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        }
                    })
                    .then(response=>{
                       this.morphologys = response.data.data.map(morphology => morphology.id.toString());
                        this.loading=false;
                        this.cachedMorphology = Object.assign([], this.morphology);
                    })
                    .catch(error => {
                        this.errored = true
                    });
            },
           getMorphologyTabledata() {
              axios
                      .request({
                         url: '/api/specimens/' + this.specimen.id + '/associations/' + this.type,
                         method: 'GET',
                         headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                         }
                      })
                      .then((response) => {
                                 console.log(Object.keys(response.data.data[0].morphologys[0]));
                                 this.morphologysItems = response.data.data[0].morphologys;
                              }
                      )
                      .catch(error => {
                         this.errored = true
                      });
           },
            //Post an array of Morphology ids
            postMorphology: function(){
               if (this.morphologys !== null) {
                    this.loading=true;
                  apiPostCall(this.base_url + '/api/specimens/' + this.specimen.id + '/associations', this.type, this.morphology.map(morphology => morphology.toString()));
                    this.loading=false;
                    this.snackbar=true;
                }
                else{
                    console.log('Morphology has no data!')
                }
            },
           edit() {
              this.isEditing = !this.isEditing;
           },
           reset() {
              this.isEditing = !this.isEditing;
           },
           save() {
              this.postArticulation();
              this.isEditing = !this.isEditing;
           },
           remove(item) {
              const index = this.morphologys.indexOf(item.id);
              if (index >= 0) this.morphologys.splice(index, 1)
           },
           getBooleanIcon(item) {
              return item === true ? '✔' : 'x'
           },
           getIconColor(item) {
              return item === true ? 'success' : 'error'
           },
        },
    }
</script>