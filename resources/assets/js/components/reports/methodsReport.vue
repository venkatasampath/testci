<template>
    <div class="m-2">
        <contentheader :trail="this.trail" model_name="report-method" :reset_menu="true" @eventReset="reset"
                       :collapse_menu="true" @eventCollapse="onExpand(false)" @eventExpand="onExpand(true)"
                       :generate_menu="true"  @eventGenerate="generate">
        </contentheader>
        <v-card>

        <v-container fluid v-show="showReportCriteria">
            <v-row>
                <v-col cols="12" md="3" sm="12">
                    <accession name="an_select" v-model="form.an_select" :options="options.accession" :required="false" />
                </v-col>
                <v-col cols="12" md="3" sm="12">
                    <provenance1 name="p1_select" v-model="form.p1_select" :options="options.provenance1" />
                </v-col>
                <v-col cols="12" md="3" sm="12">
                    <provenance2 name="p2_select" v-model="form.p2_select" :options="options.provenance2" />
                </v-col>
                <v-col cols="12" md="3" sm="12">
                    <Bone name="sb_select" v-model="form.sb_select" :options="options.bone" label="Bone" class_value=""/>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="3" sm="12">
                    <v-autocomplete name="method_type_select" v-model="form.method_type_select" :key="form.method_type_select" :items="methodTypeData"
                            item-text="text" item-value="value" dusk="se-methodtype" label="Method Type" placeholder="Select Method Type">
                    </v-autocomplete>
                </v-col>
                <v-col cols="12" md="3" sm="12">
                    <v-autocomplete v-model="form.method_select" :key="form.method_select" :items="methodData" item-text="text" item-value="value"
                            dusk="se-method" label="Method" placeholder="Select Method" :loading="loadingMethod" required :rules="[v => !!v || 'Method is required']">
                    </v-autocomplete>
                    <input type="hidden" name="method_select" :value="form.method_select" />
                </v-col>
                <v-col cols="12" md="3" sm="12">
                    <v-autocomplete v-model="form.method_feature_select" :key="form.method_feature_select" :items="methodFeatureData" item-text="text"
                            item-value="value" dusk="se-methodfeature" label="Method Feature" placeholder="Select Method Feature" :loading="loadingFeature">
                    </v-autocomplete>
                    <input type="hidden" name="method_feature_select" :value="form.method_feature_select" />
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="3" sm="12">
                    <v-autocomplete name="score_select" v-model="form.score_select" :key="form.score_select" :items="methodScoreData" item-text="text"
                            item-value="value" dusk="se-score" label="Score" placeholder="Select Score" :loading="loadingScore">
                    </v-autocomplete>
                </v-col>
                <v-col cols="12" md="3" sm="12">
                    <v-autocomplete name="range_select" v-model="form.range_select" :key="form.range_select" :items="methodRangeData" item-text="text"
                            item-value="value" dusk="se-range" label="Range" placeholder="Select Range" :loading="loadingRange">
                    </v-autocomplete>
                </v-col>
            </v-row>
        </v-container>

        <methods-report-result v-if="showresults == true" :skeletal-elements="this.skeletalElements"/>
        <snackbar v-if="snackbar == true" :snackbar_color="snackbar_color" :snackbar_text="snackbar_text" :snackbar="snackbar" @close="snackbar = false"></snackbar>
        </v-card>
    </div>
</template>

<script>
    import anp1p2dn from "../specimens/anp1p2dn"
    import Bone from "../specimens/Bone"
    import {changeObjectToArray} from "../../coraBaseModules";
    import axios from "axios";
    import snackbar from "../common/snackbar";
    import MethodsReportResult from "./methodsReportResult";
    import {eventBus} from "../../eventBus";

    export default {
        components: {
            'anp1p2dn':anp1p2dn,
            'Bone':Bone,
            'snackbar':snackbar,
            'methods-report-result':MethodsReportResult
        },
        name: "methodsreport",
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
                methodOptions:{},
                methodFeatureOptions:{},
                methodScoreOptions:{},
                methodRangeOptions:{},
                loadingMethod:false,
                loadingFeature:false,
                loadingScore:false,
                loadingRange:false,
                showresults: false,
                snackbar:false,
                snackbar_text:'',
                snackbar_color:'',
                trail: [{ text: 'Home', disabled: false, href: '/', },
                    {text: 'Reports Dashboard', diasbled: false, href: '/reports/dashboard'},
                    { text: 'Methods Report', disabled: true, href: '/methods', },
                ],
            };
        },
        methods:{
            reset() {
                this.form = {};
                this.showresults = false;
            },
            onExpand(val) {
                this.showReportCriteria = val;
            },
            disable(){
                return this.form.sb_select && this.form.method_select ? false : true;
            },
            generate() {
                if (this.disable()){
                    this.snackbar=true;
                    this.snackbar_text = 'Fill the mandatory fields: Bone, and Methods';
                    this.snackbar_color = 'red accent-4';
                    return 0;
                }
                eventBus.$emit('generate-loading', true);
                var succeed = null;
                var errored = null;
                this.showresults = false;
                axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrf;
                axios
                    .request({
                        url: this.base_url + '/reports/methods',
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        data: this.form,
                    }).then(response => {
                    this.skeletalElements = response.data.skeletalelements;
                    if (this.skeletalElements.length == 0){
                        this.snackbar=true;
                        this.snackbar_text = 'No Specimen Records Found. Refine your search';
                        this.snackbar_color = 'info';
                    }
                    else
                        this.showresults = true;
                    succeed = true;
                    eventBus.$emit('generate-loading', false);
                }).catch(error => {
                    errored = true;
                    // console.log(error)
                    eventBus.$emit('generate-loading', false);
                })
            },
            getmethodlist() {
                this.loadingMethod = true;
                if (this.form.method_select)
                    this.form.method_select = null;
                var succeed = null;
                var errored = null;
                axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrf;
                if (this.form.sb_select != null){
                    axios
                        .request({
                            url: this.base_url + '/reports/jsonmethodsarray',
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            data: {sb_select: this.form.sb_select, method_type_select:this.form.method_type_select},
                        }).then(response => {
                        // console.log(response.data);
                        this.methodOptions = response.data;
                        if (this.methodOptions.length == 0){
                            this.loadingMethod = false;
                        }
                        succeed = true;
                        this.loadingMethod = false;
                    }).catch(error => {
                        errored = true;
                        // console.log(error)
                        this.methodOptions = {};
                        this.loadingMethod = false;
                    })
                }
                else{
                    this.loadingMethod = false;
                    this.methodOptions = {};
                    console.log("Please Select the Bone");
                }
            },
            getmethodFeaturelist() {
                this.loadingFeature = true;
                if (this.form.method_feature_select)
                    this.form.method_feature_select = null;
                var succeed = null;
                var errored = null;
                axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrf;
                if (this.form.method_select != null){
                    axios
                        .request({
                            url: this.base_url + '/reports/jsonmethodfeaturesarray',
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            data: {method_select: this.form.method_select},
                        }).then(response => {
                        // console.log(response.data);
                        this.methodFeatureOptions = response.data;
                        if (this.methodFeatureOptions.length == 0){
                            this.loadingFeature = false;
                        }
                        // this.form.methodfeature=this.methodFeatureData;
                        succeed = true;
                        this.loadingFeature = false;
                    }).catch(error => {
                        errored = true
                        // console.log(error)
                        this.methodFeatureOptions = {};
                        this.loadingFeature = false;
                    })
                }
                else
                {
                    this.loadingFeature = false;
                    this.methodFeatureOptions = {};
                    console.log("No Methods are available")
                }
            },
            getMethodScorelist() {
                this.loadingScore = true;
                this.loadingRange = true;
                if (this.form.score_select){
                    this.form.score_select = null;
                }
                if (this.form.range_select){
                    this.form.range_select = null;
                }
                var succeed = null;
                var errored = null;
                axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrf;
                if (this.form.method_feature_select != null){
                    axios
                        .request({
                            url: this.base_url +'/reports/jsonscoresarray',
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            data: {method_feature_select: this.form.method_feature_select},
                        }).then(response => {
                        // console.log(response.data);
                        this.methodScoreOptions = response.data;
                        if (this.methodScoreOptions.length == 0){
                            this.loadingScore = false;
                        }
                        succeed = true;
                        this.loadingScore = false;
                    }).catch(error => {
                        errored = true
                        // console.log(error)
                        this.methodScoreOptions = {};
                        this.loadingScore = false;
                    })

                    axios
                        .request({
                            url: this.base_url + '/reports/jsonrangesarray',
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            data: {method_feature_select: this.form.method_feature_select},
                        }).then(response => {
                        // console.log(response.data);
                        this.methodRangeOptions = response.data;
                        if (this.methodRangeOptions.length == 0){
                            this.loadingRange = false;
                        }
                        succeed = true;
                        this.loadingRange = false
                    }).catch(error => {
                        errored = true
                        // console.log(error)
                        this.methodRangeOptions = {}
                        this.loadingRange = false;
                    })
                }
                else{
                    console.log("No Method Feature are available")
                    this.methodRangeOptions = {};
                    this.methodScoreOptions = {};
                    this.loadingScore = false;
                    this.loadingRange = false;
                }
            },
        },
        computed: {
            methodTypeData() {
                return changeObjectToArray(this.options.methodtype)
            },
            methodData(){
                return changeObjectToArray(this.methodOptions)
            },
            methodFeatureData(){
                return changeObjectToArray(this.methodFeatureOptions)
            },
            methodScoreData(){
                return changeObjectToArray(this.methodScoreOptions)
            },
            methodRangeData(){
                return changeObjectToArray(this.methodRangeOptions)
            }
        },
        watch: {
            'form.sb_select'(newVal) {
                this.getmethodlist();
            },
            'form.method_type_select'(newVal) {
                this.getmethodlist();
            },
            'form.method_select'(newVal) {
                this.getmethodFeaturelist();
            },
            'form.method_feature_select'(newVal) {
                this.getMethodScorelist();
            },
        },
    }
</script>

<style scoped>

</style>