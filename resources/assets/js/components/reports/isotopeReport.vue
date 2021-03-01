<template>
    <div class="col-12">
        <contentheader :trail="this.trail" model_name="report-austrdna" :reset_menu="true" @eventReset="reset"
                       :collapse_menu="true" @eventCollapse="onExpand(false)" @eventExpand="onExpand(true)"
                       :generate_menu="true"  @eventGenerate="generate">
        </contentheader>
        <v-card>

        <v-container fluid v-show="showReportCriteria">
            <anp1p2dn v-model="form" :an="options.accession" :p1="options.provenance1" :p2="options.provenance2"
                    :model-keys="{ an: 'an_select', p1: 'p1_select', p2: 'p2_select',}"/>

            <v-row>
                <v-col cols="12" md="3" sm="12">
                    <v-autocomplete name="resultsconfidencelist[]" v-model="form.resultsconfidencelist" :items="resultsstatus" :key="form.resultsconfidencelist"
                            item-text="text" item-value="value" label="Results Status" placeholder="Select Results Confidence">
                    </v-autocomplete>
                </v-col>
            </v-row>
        </v-container>

        </v-card>

        <isotope-report-result v-if="showresults == true" :isotopes="this.isotopes"></isotope-report-result>
        <snackbar v-if="snackbar == true" :snackbar_color="snackbar_color" :snackbar_text="snackbar_text" :snackbar="snackbar" @close="snackbar = false"></snackbar>
    </div>
</template>

<script>
    import anp1p2dn from "../specimens/anp1p2dn"
    import axios from "axios";
    import snackbar from "../common/snackbar";
    import isotopeReportResult from "./isotopeReportResult";
    import ResultStatus from "../dnas/ResultStatus";
    import {changeObjectToArray} from "../../coraBaseModules";
    import {eventBus} from "../../eventBus";

    export default {
        components: {
            'anp1p2dn':anp1p2dn,
            'snackbar':snackbar,
            'resultstatus':ResultStatus,
            'isotope-report-result':isotopeReportResult,
        },
        name: "isotopeReport",
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
                isotopes:{},
                showresults: false,
                snackbar:false,
                snackbar_text:'',
                snackbar_color:'',
                trail: [{ text: 'Home', disabled: false, href: '/', },
                    {text: 'Reports Dashboard', diasbled: false, href: '/reports/dashboard'},
                    { text: 'Isotope Report', disabled: true, href: '/isotopes', },
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
                eventBus.$emit('generate-loading', true);
                this.showresults = false;
                var succeed = null;
                var errored = null;
                axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrf;
                axios
                    .request({
                        url: this.base_url + '/reports/isotopes',
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        data: this.form,
                    }).then(response => {
                    this.isotopes = response.data.isotopes;
                    if (this.isotopes.length == 0){
                        this.snackbar=true;
                        this.snackbar_text = 'No Isotope Records Found. Refine your search';
                        this.snackbar_color = 'info';
                    }
                    this.showresults = true;
                    succeed = true;
                    eventBus.$emit('generate-loading', false);
                }).catch(error => {
                    errored = true;
                    console.log(error);
                    eventBus.$emit('generate-loading', false);                })
            }
        },
        computed: {
            resultsstatus: function () {
                return changeObjectToArray(this.options.resultstatus)
            }
        }
    }
</script>