<template>
    <div class="m-2">
        <contentheader :trail="this.trail" model_name="report-austrdna" :reset_menu="true" @eventReset="reset"
                       :collapse_menu="true" @eventCollapse="onExpand(false)" @eventExpand="onExpand(true)"
                       :generate_menu="true"  @eventGenerate="generate">
        </contentheader>
        <v-card>

        <v-container fluid v-show="showReportCriteria">
            <anp1p2dn v-model="form" :an="options.accession" :p1="options.provenance1" :p2="options.provenance2"
                    :model-keys="{ an: 'an_select', p1: 'p1_select', p2: 'p2_select',}"/>
            <v-row>
                <v-col cols="12" sm="12"><boneside v-model="form" :bone="options.bone" :side="options.side" :model-keys="{ bone: 'sb_select', side: 'side_select',}"/></v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="3" sm="12">
                    <individualnumber v-model="form" individual-number-name="individual_number_select" individual-number-model-key="individual_number_select"
                        :options="options.individual_number" :required="false" :autocomplete="true" label="Individual Number"/>
                </v-col>
                <v-col cols="12" md="3" sm="12">
                    <Side v-model="form.side_select_INumber" name="side_select_INumber" :options="options.side" :required="false" class_value=""/>
                </v-col>
            </v-row>
        </v-container>

        <measurement-individual-number-report-result v-if="showINResults == true"
                                                     :skeletal-elements="this.skeletalElements"
                                                     :measurements="this.measurements"/>

        <measurement-report-result v-if="showresults == true"
                                   :skeletal-elements="this.skeletalElements"
                                   :measurements="this.measurements"/>

        <snackbar v-if="snackbar == true" :snackbar_color="snackbar_color"
                  :snackbar_text="snackbar_text"
                  :snackbar="snackbar"
                  @close="snackbar = false"></snackbar>
        </v-card>
    </div>
</template>

<script>
    import anp1p2dn from "../specimens/anp1p2dn"
    import boneside from "../specimens/boneside"
    import indside from "../specimens/indside"
    import axios from "axios";
    import snackbar from "../common/snackbar";
    import MeasurementReportResult from "./measurementReportResult";
    import MeasurementIndividualNumberReportResult from "./measurementIndividualNumberReportResult";
    import {eventBus} from "../../eventBus";

    export default {
        components: {
            'anp1p2dn':anp1p2dn,
            'boneside':boneside,
            'indside':indside,
            'snackbar':snackbar,
            'measurement-report-result':MeasurementReportResult,
            'measurement-individual-number-report-result':MeasurementIndividualNumberReportResult
        },
        name: "measurementreport",
        props:{
            title: String,
            options: {
                type: Object,
                default: () => {}
            },
            csrf_prop:String,
            base_url:String,
        },
        data() {
            return{
                form: {},
                showReportCriteria:true,
                csrf:this.csrf_prop,
                skeletalElements:{},
                measurements:{},
                showresults: false,
                showINResults: false,
                snackbar:false,
                snackbar_text:'',
                snackbar_color:'',
                trail: [{ text: 'Home', disabled: false, href: '/', },
                    {text: 'Reports Dashboard', diasbled: false, href: '/reports/dashboard'},
                    { text: 'Measurements Report', disabled: true, href: '/measurements', },
                ],
            };
        },
        methods:{
            reset() {
                this.form = {};
                this.showresults = false;
                this.showINResults = false;
            },
            onExpand(val) {
                this.showReportCriteria = val;
            },
            generate() {
                if (this.disable()){
                    this.snackbar=true;
                    this.snackbar_text = 'Fill either Bone, or Individual Number';
                    this.snackbar_color = 'red accent-4';
                    return 0;
                }
                eventBus.$emit('generate-loading', true);
                this.showINResults = false;
                this.showresults = false;
                var succeed = null;
                var errored = null;
                axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrf;
                axios
                    .request({
                        url: this.base_url + '/reports/measurements',
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        data: this.form,
                    }).then(response => {
                    this.skeletalElements = response.data.skeletalelements;
                    this.measurements = response.data.measurements;
                    if (this.skeletalElements.length == 0){
                        this.snackbar=true;
                        this.snackbar_text = 'No Specimen Records Found. Refine your search';
                        this.snackbar_color = 'info';
                    }
                    else if (this.form.individual_number_select != null)
                        this.showINResults = true;
                    else
                        this.showresults = true;
                    succeed = true;
                    eventBus.$emit('generate-loading', false);
                }).catch(error => {
                    errored = true
                    console.log(error)
                    eventBus.$emit('generate-loading', false);
                })
            },
            disable(){
                return this.form.sb_select || this.form.individual_number_select ? false : true;
            },
        },
    }
</script>

<style scoped>

</style>