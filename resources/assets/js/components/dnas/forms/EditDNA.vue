<template>
    <v-container>
        <v-form lazy-validation>
            <generalform :samplenumber="dna.sample_number"
                         :btbrequestdate="dna.btb_request_date"
                         :btbreceivedate="dna.btb_receive_date"
                         :selecteddisposition="dna.disposition"
                         :selectedcondition="dna.sample_condition"
                         :weight="dna.weight_sample_remaining"
                         :recommended="dna.resample_indicator"
                         :dispositionoptions="dispositions"
                         :conditionoptions="conditions"
                         :remainingweightsuffix="weightsuffix"
                         :isDisabled="isDisabled">

            </generalform>

            <v-card>
                <v-tabs centered>

                    <v-toolbar flat dense shaped>
                        <v-tab>
                            <v-card-subtitle>Mito</v-card-subtitle>
                        </v-tab>
                        <v-tab>
                            <v-card-subtitle>au-STR</v-card-subtitle>
                        </v-tab>
                        <v-tab>
                            <v-card-subtitle>Y-STR</v-card-subtitle>
                        </v-tab>
                    </v-toolbar>

                    <!--                Mito Form-->
                    <v-tab-item>
                        <v-card flat>
                            <v-card-text>
                                <mitoform :selectedmethod="dna.mito_method"
                                          :requestdate="dna.mito_request_date"
                                          :receivedate="dna.mito_receive_date"
                                          :selectedstatus="dna.mito_results_confidence"
                                          :sequencenum="dna.mito_sequence_number"
                                          :subgroup="dna.mito_sequence_subgroup"
                                          :seqsimilar="dna.mito_sequence_similar"
                                          :basepairs="dna.mito_base_pairs"
                                          :region="dna.mito_confirmed_regions"
                                          :poly="dna.mito_polymorphisms"
                                          :haplogroup="dna.mito_haplosubgroup"
                                          :mccdate="dna.mito_mcc_date"
                                          :count="dna.mito_match_count"
                                          :popfrequency="dna.mito_total_count"
                                          :haplooptions="mitohaplos"
                                          :methodoptions="mitomethods"
                                          :statusoptions="mitostatuses">
                                </mitoform>
                            </v-card-text>
                        </v-card>
                    </v-tab-item>

<!--                    au-STR FORM-->
                    <v-tab-item>
                        <v-card flat>
                            <v-card-text>
                                <austrform :selectedmethod="dna.austr_method"
                                           :requestdate="dna.austr_request_date"
                                           :receivedate="dna.austr_receive_date"
                                           :selectedstatus="dna.austr_results_confidence"
                                           :sequencenum="dna.austr_sequence_number"
                                           :subgroup="dna.austr_sequence_subgroup"
                                           :seqsimilar="dna.austr_sequence_similar"
                                           :locinum="dna.austr_num_loci"
                                           :mccdate="dna.austr_mcc_date"
                                           :loci="dna.austr_loci"
                                           :methodoptions="austrmethods"
                                           :statusoptions="austrstatuses">
                                </austrform>
                            </v-card-text>
                        </v-card>
                    </v-tab-item>

<!--                    Y-STR FORM-->
                    <v-tab-item>
                        <v-card flat>
                            <v-card-text>

                                <ystrform :selectedmethod="dna.ystr_method"
                                          :requestdate="dna.ystr_request_date"
                                          :receivedate="dna.ystr_receive_date"
                                          :selectedstatus="dna.ystr_results_confidence"
                                          :sequencenum="dna.ystr_sequence_number"
                                          :seqsimilar="dna.ystr_sequence_similar"
                                          :locinum="dna.ystr_num_loci"
                                          :count="dna.ystr_match_count"
                                          :popfrequency="dna.ystr_total_count"
                                          :selectedhaplogroup="dna.ystr_haplogroup"
                                          :mccdate="dna.ystr_mcc_date"
                                          :loci="dna.ystr_loci"
                                          :haplooptions="ystrhaplos"
                                          :methodoptions="ystrmethods"
                                          :statusoptions="ystrstatuses">
                                </ystrform>
                            </v-card-text>
                        </v-card>

                    </v-tab-item>
                </v-tabs>

            </v-card>

        </v-form>

        <savebtn @click.native="editDNA">

        </savebtn>

    </v-container>
</template>

<script>
    import {bus} from '../../../coraBaseModules';
    import {mapGetters, mapState} from "vuex";
    import axios from "axios";

    export default {
        name: "EditDNA",

        data: () => ({
            completed: 1,
            nonlinear: true,
            isDisabled: true,

            dispositions: Object,
            conditions: Object,
            weightsuffix: Object,

            // Mito Form
            mitomethods: Object,
            mitohaplos: Object,
            mitostatuses: Object,

            //austr Form
            austrmethods: Object,
            austrstatuses: Object,

            //ystr Form
            ystrmethods: Object,
            ystrstatuses: Object,
            ystrhaplos: Object,


            dna: {
                //General Form
                sample_number: '',
                btb_request_date: '',
                btb_receive_date: '',
                disposition: '',
                sample_condition: '',
                weight_sample_remaining: '',
                resample_indicator: '',
                //Mito Form
                mito_sequence_subgroup: '',
                mito_sequence_number: '',
                mito_sequence_similar: '',
                mito_match_count: '',
                mito_total_count: '',
                mito_receive_date: '',
                mito_results_confidence: '',
                mito_method: '',
                mito_confirmed_regions: '',
                mito_base_pairs: '',
                mito_mcc_date: '',
                mito_request_date: '',
                mito_polymorphisms: '',
                mito_haplosubgroup: '',
                //austr Form
                austr_method: '',
                austr_request_date: '',
                austr_receive_date: '',
                austr_results_confidence: '',
                austr_sequence_number: '',
                austr_sequence_subgroup: '',
                austr_sequence_similar: '',
                austr_num_loci: '',
                austr_loci: '',
                austr_mcc_date: '',
                //ystr Form
                ystr_method: '',
                ystr_request_date: '',
                ystr_receive_date: '',
                ystr_results_confidence: '',
                ystr_sequence_number: '',
                ystr_sequence_similar: '',
                ystr_match_count: '',
                ystr_total_count: '',
                ystr_num_loci: '',
                ystr_loci: '',
                ystr_haplogroup: '',
                ystr_mcc_date: '',

            },
        }),

        props: {
            base_url: String,
            dnas_id: Number,

            //general form
            samplenumber: '',
            btbrequestdate: '',
            btbreceivedate: '',
            generaldisposition: '',
            generalcondition: '',
            weight: '',
            recommended: '',
            dispositionoptions: '',
            conditionoptions: '',
            remainingweightsuffix: '',


            //mito form
            mitomethodoptions: Object,
            mitorequestdate: '',
            mitoreceivedate: '',
            mitostatusoptions: Object,
            mitoselectedstatus: '',
            mitosequencenum: '',
            mitosubgroup: '',
            mitoseqsimilar: '',
            mitobasepairs: '',
            mitoregion: '',
            mitopoly: '',
            mitohaplooptions: Object,
            mitomccdate: '',
            mitocount: '',
            mitopopfrequency: '',
            mitoselectedmethod: '',
            mitohaplogroup: '',

            //auSTR form
            austrmethodoptions: Object,
            austrrequestdate: '',
            austrreceivedate: '',
            austrstatusoptions: Object,
            austrselectedstatus: '',
            austrsequencenum: '',
            austrsubgroup: '',
            austrseqsimilar: '',
            austrmccdate: '',
            austrloci: '',
            austrlocinum: '',
            austrselectedmethod: '',

            //ystr form
            ystrmethodoptions: Object,
            ystrrequestdate: '',
            ystrreceivedate: '',
            ystrstatusoptions: Object,
            ystrselectedstatus: '',
            ystrsequencenum: '',
            ystrseqsimilar: '',
            ystrmccdate: '',
            ystrloci: '',
            ystrhaplooptions: Object,
            ystrlocinum: '',
            ystrcount: '',
            ystrselectedmethod: '',
            ystrselectedhaplogroup: '',
            ystrpopfrequency: '',
        },

        beforeMount() {
            //General Form
            this.dispositions = this.dispositionoptions;
            this.conditions = this.conditionoptions;
            this.weightsuffix = this.remainingweightsuffix;

            //Mito Form
            this.mitomethods = this.mitomethodoptions;
            this.mitohaplos = this.mitohaplooptions;
            this.mitostatuses = this.mitostatusoptions;

            //austr Form
            this.austrmethods = this.austrmethodoptions;
            this.austrstatuses = this.austrstatusoptions;

            //ystr Form
            this.ystrmethods = this.ystrmethodoptions;
            this.ystrstatuses = this.ystrstatusoptions;
            this.ystrhaplos = this.ystrhaplooptions;

            //dna data
            //general form
            this.dna.sample_number = this.samplenumber;
            this.dna.btb_request_date = this.btbrequestdate;
            this.dna.btb_receive_date = this.btbreceivedate;
            this.dna.disposition = this.generaldisposition;
            this.dna.sample_condition = this.generalcondition;
            this.dna.weight_sample_remaining = this.weight;
            this.dna.resample_indicator = this.recommended;
            this.dispositions = this.dispositionoptions;
            this.conditions = this.conditionoptions;
            this.weightsuffix = this.remainingweightsuffix;

            //Mito Form
            this.dna.mito_sequence_subgroup = this.mitosubgroup;
            this.dna.mito_sequence_number = this.mitosequencenum;
            this.dna.mito_sequence_similar = this.mitoseqsimilar;
            this.dna.mito_match_count = this.mitocount;
            this.dna.mito_total_count = this.mitopopfrequency;
            this.dna.mito_receive_date = this.mitoreceivedate;
            this.dna.mito_results_confidence = this.mitoselectedstatus;
            this.dna.mito_method = this.mitoselectedmethod;
            this.dna.mito_confirmed_regions = this.mitoregion;
            this.dna.mito_base_pairs = this.mitobasepairs;
            this.dna.mito_mcc_date = this.mitomccdate;
            this.dna.mito_request_date = this.mitorequestdate;
            this.dna.mito_polymorphisms = this.mitopoly;
            this.dna.mito_haplosubgroup = this.mitohaplogroup;

            //austr Form
            this.dna.austr_method = this.austrselectedmethod;
            this.dna.austr_request_date = this.austrrequestdate;
            this.dna.austr_receive_date = this.austrreceivedate;
            this.dna.austr_results_confidence = this.austrselectedstatus;
            this.dna.austr_sequence_number = this.austrsequencenum;
            this.dna.austr_sequence_subgroup = this.austrsubgroup;
            this.dna.austr_sequence_similar = this.austrseqsimilar;
            this.dna.austr_num_loci = this.austrlocinum;
            this.dna.austr_loci = this.austrloci;
            this.dna.austr_mcc_date = this.austrmccdate;

            //ystr Form
            this.dna.ystr_method = this.ystrselectedmethod;
            this.dna.ystr_request_date = this.ystrrequestdate;
            this.dna.ystr_receive_date = this.ystrreceivedate;
            this.dna.ystr_results_confidence = this.ystrselectedstatus;
            this.dna.ystr_sequence_number = this.ystrsequencenum;
            this.dna.ystr_sequence_similar = this.ystrseqsimilar;
            this.dna.ystr_match_count = this.ystrcount;
            this.dna.ystr_total_count = this.ystrpopfrequency;
            this.dna.ystr_num_loci = this.ystrlocinum;
            this.dna.ystr_loci = this.ystrloci;
            this.dna.ystr_haplogroup = this.ystrselectedhaplogroup;
            this.dna.ystr_mcc_date = this.ystrmccdate;


        },


        created() {

            bus.$on('updateSampleNum', (data) => {
                this.dna.sample_number = data
            });
            bus.$on('updatebtbrequestdate', (data) => {
                console.log(data);
                this.dna.btb_request_date = data
            });
            bus.$on('updatebtbreceivedate', (data) => {
                this.dna.btb_receive_date = data
            });

            bus.$on('UpdateWeight', (data) => {
                this.dna.weight_sample_remaining = data
            });
            bus.$on('UpdateMitoSubgroup', (data) => {
                this.dna.mito_haplosubgroup = data
            });
            bus.$on('UpdateCondition', (data) => {
                this.dna.sample_condition = data
            });
            bus.$on('UpdateWeight', (data) => {
                this.dna.weight_sample_remaining = data
            });
            bus.$on('UpdateResamplingIndicator', (data) => {
                this.dna.resample_indicator = data
            });

            //mito form
            bus.$on('UpdateMitoSubgroup', (data) => {
                this.dna.mito_haplosubgroup = data
            });
            bus.$on('UpdateMitoSequenceNum', (data) => {
                this.dna.mito_sequence_number = data
            });
            bus.$on('UpdateMitoSeqSimilar', (data) => {
                this.mito_sequence_similar = data
            });
            bus.$on('UpdateMitoCount', (data) => {
                this.dna.mito_match_count = data
            });
            bus.$on('UpdateMitoPop', (data) => {
                this.dna.mito_total_count = data
            });
            bus.$on('updateMitoReceiveDate', (data) => {
                this.dna.mito_receive_date = data
            });
            bus.$on('UpdateMitoStatus', (data) => {
                this.dna.mito_results_confidence = data
            });

            bus.$on('UpdateMitoStatus', (data) => {
                this.dna.mito_results_confidence = data
            });
            bus.$on('UpdateMitoMethod', data => {
                this.dna.mito_method = data
            });
            bus.$on('UpdateRegion', (data) => {
                this.dna.mito_confirmed_regions = data
            });
            bus.$on('UpdateBasepairs', (data) => {
                this.dna.mito_base_pairs = data
            });
            bus.$on('updatedMitoMccDate', (data) => {
                this.dna.mito_mcc_date = data
            });
            bus.$on('UpdatePoly', (data) => {
                this.dna.mito_polymorphisms = data
            });
            bus.$on('UpdateMitoHaplo', (data) => {
                this.dna.mito_haplosubgroup = data
            });

            //austr Form
            bus.$on('UpdateAustrMethod', (data) => {
                this.dna.austr_method = data
            });
            bus.$on('updateAustrRequestDate', (data) => {
                this.dna.austr_request_date = data
            });
            bus.$on('updateAustrReceiveDate', (data) => {
                this.dna.austr_receive_date = data
            });
            bus.$on('UpdateAustrStatus', (data) => {
                this.dna.austr_results_confidence = data
            });
            bus.$on('UpdateAustrSequenceNum', (data) => {
                this.dna.austr_sequence_number = data
            });
            bus.$on('UpdateAustrSubgroup', (data) => {
                this.dna.austr_sequence_subgroup = data
            });
            bus.$on('UpdateAustrSeqSimilar', (data) => {
                this.dna.austr_sequence_similar = data
            });
            bus.$on('UpdateAustrLociNum', (data) => {
                this.dna.austr_num_loci = data
            });
            bus.$on('UpdateAustrLoci', (data) => {
                this.dna.austr_loci = data
            });
            bus.$on('updateAustrMccDate', (data) => {
                this.dna.austr_mcc_date = data
            });

            //ystr Form
            bus.$on('UpdateYstrMethod', (data) => {
                this.dna.ystr_method = data
            });
            bus.$on('updateYstrRequestDate', (data) => {
                this.dna.ystr_request_date = data
            });
            bus.$on('updateYstrReceiveDate', (data) => {
                this.dna.ystr_receive_date = data
            });
            bus.$on('UpdateYstrStatus', (data) => {
                this.dna.ystr_results_confidence = data
            });
            bus.$on('UpdateYstrSequenceNum', (data) => {
                this.dna.ystr_sequence_number = data
            });
            bus.$on('UpdateYstrSeqSimilar', (data) => {
                this.dna.ystr_sequence_similar = data
            });
            bus.$on('UpdateYstrCount', (data) => {
                this.dna.ystr_match_count = data
            });
            bus.$on('UpdateYstrPop', (data) => {
                this.dna.ystr_total_count = data
            });
            bus.$on('UpdateYstrLociNum', (data) => {
                this.dna.ystr_num_loci = data
            });

            bus.$on('UpdateYstrLoci', (data) => {
                this.dna.ystr_loci = data
            });
            bus.$on('UpdateYstrHaplo', (data) => {
                this.dna.ystr_haplogroup = data
            });
            bus.$on('updateYstrMccDate', (data) => {
                this.dna.ystr_mcc_date = data
            });
        },

        methods: {
            editDNA() {
                var errored = false;
                var succeed = false;

                let url = this.base_url + '/api/dnas/' + this.dnas_id;
                let data = JSON.stringify(this.dna);
                axios.request({
                    url: url,
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': this.$store.getters.bearerToken,
                    },
                    data: data,
                }).then(response => {
                        succeed = true;
                        alert('DNA Form is updated!')
                        // uncomment for debugging
                        // console.log(response);
                    })
                    .catch(error => {
                        // uncomment for debugging
                        // console.log(error.response);
                        errored = true
                    })
            }
        },
        computed: {
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
        }
    }
</script>