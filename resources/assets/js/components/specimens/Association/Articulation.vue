<template>
    <div class="m-2">
        <contentheader v-if="show_contentheader" :trail="this.trail" :se_action_menu="(!action.create)"
                       model_name="articulation"
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
                        <v-badge color="primary" :content="(this.articulation) ? this.articulation.length : 0">
                            Articulations
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
                                            <v-data-table :headers="columnVisibility" :items="articulationItems"
                                                          class="elevation-1">
                                                <template v-slot:item.key_bone_side="{ item }">
                                                    <a :href="/skeletalelements/ + specimen.id " target="_blank">{{
                                                        item.key_bone_side }}</a>
                                                </template>
                                                <template v-slot:item.pivot.elimination_reason="{ item }">
                                                    <v-autocomplete v-model="eleminationReason[item.pivot.se_id]"
                                                                    :items="eleminationOption"
                                                                    item-value="value" item-text="text"
                                                    ></v-autocomplete>
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
                        <v-autocomplete id="articulation_id" v-model="articulation" dusk="se-articulation-menu"
                                        :placeholder="isEditing ? '' : 'There are no Articulations associated with this Specimen'"
                                        :items="articulationList" item-value="value" item-text="text" dense chips
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
    import {changeObjectToArray, apiPostCall} from '../../../coraBaseModules';

    export default {
        name: 'Articulation',
        props: {
            list: {type: Object},
            specimen: {type: Object,},
            readonly: {type: Boolean, default: false},
            crud_action: {type: String, default: "View"},
            heading: {type: String, default: "Articulation"},
            toolbar: {type: Boolean, default: true},
            toolbar_crud: {type: Boolean, default: true},
            contentheader: {type: Boolean, default: true},
            cols: {type: Number, default: 12},
            articulationDetails: {type: Object}
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
                    {text: 'Articulation', disabled: true, href: "/"},
                ],
                show_toolbar: this.toolbar,
                show_toolbar_crud: this.toolbar_crud,
                loading: false,
                articulation: null,
                type: 'articulations',
                errored: null,
                isEditing: false,
                snackbar: false,
                showCollapse: true,
                showModal: false,
                articulationItems: null,
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
                    {text: 'Compare Method', value: 'compare_method', width: '8rem', visibility: true},
                    {text: 'Measurements Used', value: 'pivot.measurements_used', width: '8rem', visibility: true},
                    {text: 'Number of Measurements Used', value: 'num_measurements', width: '8rem', visibility: true},
                    {text: 'Sample Size', value: 'pivot.sample_size', width: '8rem', visibility: true},
                    {text: 'P-value', value: 'pivot.pvalue', width: '8rem', visibility: true},
                    {text: 'Mean', value: 'pivot.mean', width: '8rem', visibility: true},
                    {text: 'Elimination Reason', value: 'pivot.elimination_reason', width: '8rem', visibility: true},
                    {text: 'Standard Deviation', value: 'pivot.sd', width: '8rem', visibility: false},
                    {text: 'Elimination Reason', value: 'pivot.elimination_reason', width: '8rem', visibility: false},
                    {text: 'Elimination Date', value: 'pivot.elimination_date', width: '8rem', visibility: false},
                    {text: 'Individual Number', value: 'individual_number', visibility: false},
                    {text: 'DNA Sampled', value: 'dna_sampled', visibility: false},
                    {text: 'Mito Sequence Number', value: 'mito_sequence_number', visibility: false},
                    {text: 'Measured', value: 'measured', visibility: false},
                    {text: 'Isotope Sampled', value: 'isotope_sampled', visibility: false},
                    {text: 'Clavicle Triage', value: 'clavicle_triage', visibility: false},
                    {text: 'CT Scanned', value: 'ct_scanned', visibility: false},
                    {text: 'Xray Scanned', value: 'xray_scanned', visibility: false},
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
        computed:{
            articulationList() {
                return changeObjectToArray(this.list);
            },
            // headers(){
            // return this.articulationDetails.map(item => item.id)
            // },
            ...mapState({
                base_url: state => state.baseURL,
                // articulationList: state => state.articulations,
            }),
            ...mapGetters({
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
                bearerToken: 'bearerToken',
                csrfToken: 'csrfToken',
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
            getArticulation() {
                this.loading=true;
                axios
                    .request({
                        url: this.base_url + '/api/specimens/' + this.specimen.id + '/associations?type=' + this.type,
                        method: 'GET',
                        headers:{
                            'Content-Type' : 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        }
                    })
                    .then(response=>{
                        this.articulation = response.data.data.map(articulation=>articulation.id.toString());
                        this.loading=false;
                        this.cachedArticulation = Object.assign([], this.articulation);
                    })
                    .catch(error => {
                        this.errored = true
                    });
            },
            //Post an array of Articulation ids
            postArticulation() {
                if(this.Articulation !== null){
                    this.loading=true;
                    apiPostCall(this.base_url + '/api/specimens/' + this.specimen.id + '/associations', this.type, this.articulation.map(articulation => articulation.toString()));
                    this.loading=false;
                    this.snackbar=true;
                }else{
                    console.log('Articulation has no data!')
                }
            },
            //Load data
            getArticulationTabledata() {
                axios
                    .request({
                        url: this.base_url + '/api/specimens/' + this.specimen.id + '/associations/' + this.type,
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        }
                    })
                    .then((response) => {
                            console.log(Object.keys(response.data.data[0].articulations[0]));
                            // this.headers = Object.keys(response.data.data[0].articulations[0]);
                            this.articulationItems = response.data.data[0].articulations;
                        }
                    )
                    .catch(error => {
                        this.errored = true
                    });
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
                const index = this.articulation.indexOf(item.id);
                if (index >= 0) this.articulation.splice(index, 1)
            },
            // columnVisibility() {
            //     return this.headers.filter(item => item.visibility === true);
            // },
        },
        mounted() {
            this.getArticulation();
            this.getArticulationTabledata();
        }
    }
</script>