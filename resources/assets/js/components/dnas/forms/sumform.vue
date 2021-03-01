<template>
    <div class="m-2">
        <contentheader v-if="show_contentHeader" :title="heading"  model_name="dnas" :crud_action="action"
                       :specimen="(action.view) ? specimen : null" @eventNew="create" @eventEdit="edit" @eventSave="save">
        </contentheader>
        <specimen-highlights v-if="show_contentHeader" :specimen="specimen"></specimen-highlights>
        <v-container fluid>
            <v-card flat v-if="show_general_form">
                <generalform :samplenumber="dnas.sample_number"
                             :lab="dnas.lab_id"
                             :btbrequestdate="dnas.btb_request_date"
                             :btbreceivedate="dnas.btb_results_date"
                             :selecteddisposition="dnas.disposition"
                             :selectedcondition="dnas.sample_condition"
                             :weight="dnas.weight_sample_remaining"
                             :recommended="dnas.resample_indicator"
                             :remainingweightsuffix="dnas.weightsuffix"
                             :dispositionoptions="dispositionoptions"
                             :conditionoptions="conditionoptions"
                             :externalcasenumber="dnas.external_case_id"
                             :isDisabled="action.view">
                </generalform>
            </v-card>
            <v-stepper
                v-model="completed"
                :non-linear="nonlinear"
                dense>
                <v-card-title v-if="!show_contentHeader" class="justify-center">Consensus DNA</v-card-title>
                <v-stepper-header>
                    <v-stepper-step
                            :complete="completed > 1"
                            step="1"
                            editable>
                        Mito
                        <small>{{getMitoMissing}}/{{getMitoFields}} fields are filled</small>
                    </v-stepper-step>

                    <v-stepper-step
                            :complete="completed > 2"
                            step="2"
                            editable>
                        au-STR
                        <small>{{getAustrMissing}}/{{getAustrFields}} fields are filled</small>
                    </v-stepper-step>

                    <v-stepper-step
                            :complete="completed > 3"
                            step="3"
                            editable>
                        Y-STR
                        <small>{{getYstrMissing}}/{{getYstrFields}} fields are filled</small>
                    </v-stepper-step>
                </v-stepper-header>

                <v-stepper-items>
                    <v-stepper-content step="1">
                        <v-form ref="mitoform">
                            <mitoform :selectedmethod="mito.mito_method"
                                      :requestdate="mito.mito_request_date"
                                      :receivedate="mito.mito_receive_date"
                                      :selectedstatus="mito.mito_results_confidence"
                                      :sequencenum="mito.mito_sequence_number"
                                      :subgroup="mito.mito_sequence_subgroup"
                                      :seqsimilar="mito.mito_sequence_similar"
                                      :basepairs="mito.mito_base_pairs"
                                      :region="mito.mito_confirmed_regions"
                                      :poly="mito.mito_polymorphisms"
                                      :haplogroup="mito.mito_haplosubgroup"
                                      :mccdate="mito.mito_mcc_date"
                                      :count="mito.mito_match_count"
                                      :popfrequency="mito.mito_total_count"
                                      :haplooptions="mitohaplos"
                                      :methodoptions="mitomethods"
                                      :statusoptions="mitostatuses"
                                      :disabled="action.view">
                            </mitoform>
                        </v-form>
                    </v-stepper-content>
                </v-stepper-items>

                <v-stepper-items>
                    <v-stepper-content step="2" flat>
                        <v-form ref="austrform">
                            <austrform :austrmethod="austr.austr_method"
                                       :requestdate="austr.austr_request_date"
                                       :receivedate="austr.austr_receive_date"
                                       :selectedstatus="austr.austr_results_confidence"
                                       :sequencenum="austr.austr_sequence_number"
                                       :subgroup="austr.austr_sequence_subgroup"
                                       :seqsimilar="austr.austr_sequence_similar"
                                       :locinum="austr.austr_num_loci"
                                       :mccdate="austr.austr_mcc_date"
                                       :loci="austr.austr_loci"
                                       :methodoptions="austrmethods"
                                       :statusoptions="austrstatuses"
                                       :disabled="action.view">
                            </austrform>
                        </v-form>
                    </v-stepper-content>
                </v-stepper-items>


                <v-stepper-items>
                    <v-stepper-content step="3">
                        <v-form ref="ystrform">
                            <ystrform :selectedmethod="ystr.ystr_method"
                                      :requestdate="ystr.ystr_request_date"
                                      :receivedate="ystr.ystr_receive_date"
                                      :selectedstatus="ystr.ystr_results_confidence"
                                      :sequencenum="ystr.ystr_sequence_number"
                                      :seqsimilar="ystr.ystr_sequence_similar"
                                      :subgroup="ystr.ystr_sequence_subgroup"
                                      :locinum="ystr.ystr_num_loci"
                                      :count="ystr.ystr_match_count"
                                      :popfrequency="ystr.ystr_total_count"
                                      :selectedhaplogroup="ystr.ystr_haplogroup"
                                      :mccdate="ystr.ystr_mcc_date"
                                      :loci="ystr.ystr_loci"
                                      :haplooptions="ystrhaplos"
                                      :methodoptions="ystrmethods"
                                      :statusoptions="ystrstatuses"
                                      :disabled="action.view">
                            </ystrform>
                        </v-form>
                    </v-stepper-content>
                </v-stepper-items>
            </v-stepper>
            <v-card-actions v-if="action.edit">
                <v-row class="justify-center">
                    <v-btn title="Save" color="primary" class="mr-2" @click="save()"><v-icon class="mr-2">mdi-content-save</v-icon>Save</v-btn>
                </v-row>
            </v-card-actions>
            <br>
            <tags v-if="show_tags" :disabled="action.view" :tag_model="dna" type="Dna" :crud_action="crud_action"/>
        </v-container>
    </div>
</template>

<script>
    import {changeObjectToArray} from '../../../coraBaseModules';
    import {mapGetters, mapState} from "vuex";
    import axios from "axios";
    import {eventBus} from "../../../eventBus";

    export default {
        name: "sumform",
        props: {
            dna : {type: Object, default: null},
            specimen: { type: Object, default: null },
            crud_action: { type: String, default: "View" },
            show_contentHeader:{type: Boolean, default: true},
            show_general_form:{type: Boolean, default: true},
            austrmethodoptions: { type: Object, default: null },
            mitohaplooptions: { type: Object, default: null },
            mitomethodoptions: { type: Object, default: null },
            statusoptions: { type: Object, default: null },
            ystrhaplooptions: { type: Array, default: null },
            ystrmethodoptions: { type: Object, default: null },
            remainingweightsuffix: { type: String, default: null },
            dispositionoptions:{ type: Object, default: null },
            conditionoptions:{ type: Object, default: null },

            //dna tags
            show_tags: { type: Boolean, default: true }

        },
        data() {
            return{
            completed: 1,
            nonlinear: true,
            isDisabled: true,
            submissionMsg: '',
            snackcolor: '#0277BD',

           //General Form
            dnas:{},
           //austr Form
            austr:{},
           //Mito Form
            mito:{},
           //ystr Form
            ystr:{},
            }},
        beforeMount() {
            //General Form
            this.dispositions = this.dispositionoptions;
            this.conditions = this.conditionoptions;
            this.weightsuffix = this.remainingweightsuffix;

            //Mito Form
            this.mitomethods = this.mitomethodoptions;
            this.mitohaplos = this.mitohaplooptions;
            this.mitostatuses = this.statusoptions;

            //austr Form
            this.austrmethods = this.austrmethodoptions;
            this.austrstatuses = this.statusoptions;

            //ystr Form
            this.ystrmethods = this.ystrmethodoptions;
            this.ystrstatuses = this.statusoptions;
            this.ystrhaplos = this.ystrhaplooptions;

            //dna data
            //general form
            this.dnas.sample_number = this.dna.sample_number;
            this.dnas.lab_id = this.dna.lab_id;
            this.dnas.btb_request_date = this.dna.btb_request_date;
            this.dnas.btb_results_date = this.dna.btb_results_date;
            this.dnas.disposition = this.dna.disposition;
            this.dnas.sample_condition = this.dna.sample_condition;
            this.dnas.weight_sample_remaining = this.dna.weight_sample_remaining;
            this.dnas.resample_indicator = this.dna.resample_indicator;
            this.dispositions = this.dna.dispositions;
            this.dnas.external_case_id = this.dna.external_case_id;
            this.weightsuffix = this.remainingweightsuffix;

            //Mito Form
            this.mito.mito_sequence_subgroup = this.dna.mito_sequence_subgroup;
            this.mito.mito_sequence_number = this.dna.mito_sequence_number;
            this.mito.mito_sequence_similar = this.dna.mito_sequence_similar;
            this.mito.mito_match_count = this.dna.mito_match_count;
            this.mito.mito_total_count = this.dna.mito_total_count;
            this.mito.mito_receive_date = this.dna.mito_receive_date;
            this.mito.mito_results_confidence = this.dna.mito_results_confidence;
            this.mito.mito_method = this.dna.mito_method;
            this.mito.mito_confirmed_regions = this.dna.mito_confirmed_regions;
            this.mito.mito_base_pairs = this.dna.mito_base_pairs;
            this.mito.mito_mcc_date = this.dna.mito_mcc_date;
            this.mito.mito_request_date = this.dna.mito_request_date;
            this.mito.mito_polymorphisms = this.dna.mito_polymorphisms;
            this.mito.mito_haplosubgroup = this.dna.mito_haplosubgroup;

            //austr Form
            this.austr.austr_method = this.dna.austr_method;
            this.austr.austr_request_date = this.dna.austr_request_date;
            this.austr.austr_receive_date = this.dna.austr_receive_date;
            this.austr.austr_results_confidence = this.dna.austr_results_confidence;
            this.austr.austr_sequence_number = this.dna.austr_sequence_number;
            this.austr.austr_sequence_subgroup =this.dna.austr_sequence_subgroup;
            this.austr.austr_sequence_similar =this.dna.austr_sequence_similar;
            this.austr.austr_num_loci = this.dna.austr_num_loci;
            this.austr.austr_loci = this.dna.austr_loci;
            this.austr.austr_mcc_date = this.dna.austr_mcc_date;

            //ystr Form
            this.ystr.ystr_method = this.dna.ystr_method;
            this.ystr.ystr_request_date = this.dna.ystr_request_date;
            this.ystr.ystr_receive_date = this.dna.ystr_receive_date;
            this.ystr.ystr_results_confidence = this.dna.ystr_results_confidence;
            this.ystr.ystr_sequence_number = this.dna.ystr_sequence_number;
            this.ystr.ystr_sequence_similar = this.dna.ystr_sequence_similar;
            this.ystr.ystr_sequence_subgroup = this.dna.ystr_sequence_subgroup;
            this.ystr.ystr_match_count = this.dna.ystr_match_count;
            this.ystr.ystr_total_count = this.dna.ystr_total_count;
            this.ystr.ystr_num_loci = this.dna.ystr_num_loci;
            this.ystr.ystr_loci = this.dna.ystr_loci;
            this.ystr.ystr_haplogroup = this.dna.ystr_haplogroup;
            this.ystr.ystr_mcc_date = this.dna.ystr_mcc_date;
        },


        created() {
            console.log(this.dna);
            eventBus.$on('updateSampleNum', (data) => {
                this.dnas.sample_number = data
            });
            eventBus.$on('updatebtbrequestdate', (data) => {
                this.dnas.btb_request_date = data
            });
            eventBus.$on('updatebtbreceivedate', (data) => {
                this.dnas.btb_results_date = data
            });

            eventBus.$on('UpdateWeight', (data) => {
                this.dnas.weight_sample_remaining = data
            });
            eventBus.$on('UpdateCondition', (data) => {
                this.dnas.sample_condition = data
            });
            eventBus.$on('UpdateWeight', (data) => {
                this.dnas.weight_sample_remaining = data
            });
            eventBus.$on('UpdateResamplingIndicator', (data) => {
                this.dnas.resample_indicator = data
            });
            eventBus.$on('UpdateCaseNum', (data) => {
                this.dnas.external_case_id = data
            });
            eventBus.$on('UpdateDisposition', (data) => {
                this.dnas.disposition = data
            });

            //mito form
            eventBus.$on('UpdateMitoSubgroup', (data) => {
                this.mito.mito_sequence_subgroup = data
            });
            eventBus.$on('updateMitoRequestDate',(data)=>{
                this.mito.mito_request_date=data
            });
            eventBus.$on('UpdateMitoSequenceNum', (data) => {
                this.mito.mito_sequence_number = data
            });
            eventBus.$on('UpdateMitoSeqSimilar', (data) => {
                this.mito.mito_sequence_similar = data
            });
            eventBus.$on('UpdateMitoCount', (data) => {
                this.mito.mito_match_count = data
            });
            eventBus.$on('UpdateMitoPop', (data) => {
                this.mito.mito_total_count = data
            });
            eventBus.$on('updateMitoReceiveDate', (data) => {
                this.mito.mito_receive_date = data
            });
            eventBus.$on('UpdateMitoStatus', (data) => {
                this.mito.mito_results_confidence = data
            });

            eventBus.$on('UpdateMitoStatus', (data) => {
                this.mito.mito_results_confidence = data
            });
            eventBus.$on('UpdateMitoMethod', data => {
                this.mito.mito_method = data
            });
            eventBus.$on('UpdateRegion', (data) => {
                this.mito.mito_confirmed_regions = data
            });
            eventBus.$on('UpdateBasepairs', (data) => {
                this.mito.mito_base_pairs = data
            });
            eventBus.$on('updatedMitoMccDate', (data) => {
                this.mito.mito_mcc_date = data
            });
            eventBus.$on('UpdatePoly', (data) => {
                this.mito.mito_polymorphisms = data
            });
            eventBus.$on('UpdateMitoHaplo', (data) => {
                this.mito.mito_haplosubgroup = data
            });

            //austr Form
            eventBus.$on('UpdateAustrMethod', (data) => {
                this.austr.austr_method = data
            });
            eventBus.$on('updateAustrRequestDate', (data) => {
                this.austr.austr_request_date = data
            });
            eventBus.$on('updateAustrReceiveDate', (data) => {
                this.austr.austr_receive_date = data
            });
            eventBus.$on('UpdateAustrStatus', (data) => {
                this.austr.austr_results_confidence = data
            });
            eventBus.$on('UpdateAustrSequenceNum', (data) => {
                this.austr.austr_sequence_number = data
            });
            eventBus.$on('UpdateAustrSubgroup', (data) => {
                this.austr.austr_sequence_subgroup = data
            });
            eventBus.$on('UpdateAustrSeqSimilar', (data) => {
                this.austr.austr_sequence_similar = data
            });
            eventBus.$on('UpdateAustrLociNum', (data) => {
                this.austr.austr_num_loci = data
            });
            eventBus.$on('UpdateAustrLoci', (data) => {
                this.austr.austr_loci = data
            });
            eventBus.$on('updateAustrMccDate', (data) => {
                this.austr.austr_mcc_date = data
            });

            //ystr Form
            eventBus.$on('UpdateYstrMethod', (data) => {
                this.ystr.ystr_method = data
            });
            eventBus.$on('updateYstrRequestDate', (data) => {
                this.ystr.ystr_request_date = data
            });
            eventBus.$on('updateYstrReceiveDate', (data) => {
                this.ystr.ystr_receive_date = data
            });
            eventBus.$on('UpdateYstrStatus', (data) => {
                this.ystr.ystr_results_confidence = data
            });
            eventBus.$on('UpdateYstrSequenceNum', (data) => {
                this.ystr.ystr_sequence_number = data
            });
            eventBus.$on('UpdateYstrSeqSimilar', (data) => {
                this.ystr.ystr_sequence_similar = data
            });
            eventBus.$on('UpdateYstrSubgroup', (data) => {
                this.ystr.ystr_sequence_subgroup = data
            });
            eventBus.$on('UpdateYstrCount', (data) => {
                this.ystr.ystr_match_count = data
            });
            eventBus.$on('UpdateYstrPop', (data) => {
                this.ystr.ystr_total_count = data
            });
            eventBus.$on('UpdateYstrLociNum', (data) => {
                this.ystr.ystr_num_loci = data
            });
            eventBus.$on('UpdateYstrLoci', (data) => {
                this.ystr.ystr_loci = data
            });
            eventBus.$on('UpdateYstrHaplo', (data) => {
                this.ystr.ystr_haplogroup = data
            });
            eventBus.$on('updateYstrMccDate', (data) => {
                this.ystr.ystr_mcc_date = data
            });
            this.setHeading();


        },

        methods: {
            resetMito() {
                this.$refs.mitoform.reset();
            },

            resetAustr() {
                this.$refs.austrform.reset();
            },

            resetYstr() {
                this.$refs.ystrform.reset();
            },
            save() {
                var errored = false;
                var succeed = false;
                let data = JSON.stringify({...this.dnas,...this.mito,...this.austr,...this.ystr});
                console.log(data);
                axios.request({
                    url: '/api/dnas/' + this.dna.id,
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': this.$store.getters.bearerToken,
                    },
                    data: data,
                })
                .then(response => {
                    succeed = true;
                    let payload = { 'text': 'Update successful', 'color': 'success', };
                    eventBus.$emit('show_edit');
                    eventBus.$emit('show-snackbar', payload);
                    console.log(response.data.data.message, response.data.data.status);
                    window.location.assign('/skeletalelements/'+ this.specimen.id +'/dnas/'+ this.dna.id);
                })
                .catch(error => {
                    console.log(error);
                    errored = true;
                    let payload = { 'text': 'Update failed', 'color': 'error', };
                    eventBus.$emit('show-snackbar', payload);
                })
            },
            create() {
                window.location.assign('/skeletalelements/'+this.specimen.id+'/dnas/create');
            },
            edit() {
                window.location.assign('/skeletalelements/' + this.specimen.id+ '/dnas/'+ this.dna.id+'/edit');
            },
            setHeading(){
                this.heading = this.crud_action + " DNA - " + this.dna.sample_number;
            },
        },

        computed:{
            getMitoFields:function(){
                this.mitoFields=0;
                let data =changeObjectToArray(this.mito);
                this.mitoFields=data.length;
                return this.mitoFields;
            },

            getMitoMissing(){
                this.mitoFilled=0;
                let data=changeObjectToArray(this.mito);
                for(let value in data){
                    if(data[value]["text"]){
                        this.mitoFilled +=1;
                    }
                }
                return this.mitoFilled;
            },

            getAustrFields(){
                this.austrFields=0;
                let data =changeObjectToArray(this.austr);
                this.austrFields=data.length;
                return this.austrFields;
            },

            getAustrMissing:function(){
                this.austrFilled=0;
                let data=changeObjectToArray(this.austr);
                for(let value in data){
                    if(data[value]["text"]){
                        this.austrFilled +=1;
                    }
                }
                return this.austrFilled;
            },

            getYstrFields(){
                this.ystrFields=0;
                let data =changeObjectToArray(this.ystr);
                this.ystrFields=data.length;
                return this.ystrFields;
            },

            getYstrMissing(){
                this.ystrFilled=0;
                let data=changeObjectToArray(this.ystr);
                for(let value in data){
                    if(data[value]["text"]){
                        this.ystrFilled +=1;
                    }
                }
                return this.ystrFilled;
            },
            ...mapState({
                //
            }),
            ...mapGetters({
                bearerToken: 'bearerToken',
                csrfToken: 'csrfToken',
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
            }),
            action() {
                const act = this.crud_action;
                return { create: act === "Create", view: act === "View", edit: (act === "Update" || act === "Edit"), list: act === "List", };
            },
            // edited() {
            //     return JSON.stringify(this.form) !== JSON.stringify(this.initialFormData);
            // },
            toolbarProps() {
                if (this.action.create || this.action.edit) {
                    return { rese: true, save: {disabled: !this.edited} };
                } else if (this.action.view) {
                    return { edit: true };
                } else {
                    return {};
                }
            },
        },
    }
</script>
