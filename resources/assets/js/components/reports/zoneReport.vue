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
                <v-col cols="12" sm="12"><boneside v-model="form" :bone="options.bone" :side="options.side" :model-keys="{bone: 'sb_select',side: 'side_select',}"/></v-col>
            </v-row>
            <v-row>
                <v-col cols="12" sm="12">
                    <v-row justify="left">
                        <v-col cols="6" md="3">
                            <v-autocomplete v-model="form.zone_select" name="zone_select" :items="zonedata" item-text="value"
                                            item-value="text" multiple chips deletable-chips label="Zones" placeholder="Select Zones"
                                            dusk="se-zone" :loading="loading" clearable>
                            </v-autocomplete>
                        </v-col>
                        <v-col cols="6" md="3">
                            <zonesearchtype v-model="form.search_type_select" :options="options.zone_search_type" label="Select Search Type" :required="false"></zonesearchtype>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-container>

        <zone-report-result v-if="showresults == true" :skeletal-elements="this.skeletalElements" :zones="this.zones"/>
        <snackbar v-if="snackbar == true" :snackbar_color="snackbar_color" :snackbar_text="snackbar_text" :snackbar="snackbar" @close="snackbar = false"></snackbar>
        </v-card>
    </div>
</template>

<script>
    import anp1p2dn from "../specimens/anp1p2dn"
    import boneside from "../specimens/boneside"
    import zonesearchtype from "../specimens/zonesearchtype";
    import {changeObjectToArray} from "../../coraBaseModules";
    import axios from "axios";
    import ZoneReportResult from "./zoneReportResult";
    import snackbar from "../common/snackbar";
    import {eventBus} from "../../eventBus";

    export default {
        components: {
            'anp1p2dn':anp1p2dn,
            'boneside':boneside,
            'zonesearchtype':zonesearchtype,
            'zone-report-result':ZoneReportResult,
            'snackbar':snackbar
        },
        name: "zonereport",
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
                searchtypehelp:this.options.zone_search_type_help.split("<")[0],
                info:false,
                showReportCriteria:true,
                csrf:this.csrf_prop,
                zoneOptions:{},
                loading:false,
                skeletalElements:{},
                zones:{},
                showresults: false,
                snackbar:false,
                snackbar_text:'',
                snackbar_color:'',
                trail: [{ text: 'Home', disabled: false, href: '/', },
                    {text: 'Reports Dashboard', diasbled: false, href: '/reports/dashboard'},
                    { text: 'Zones Report', disabled: true, href: '/zones', },
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
            generate() {
                if (this.disable()){
                    this.snackbar=true;
                    this.snackbar_text = 'Fill the mandatory fields: Bone, Zones and Select Search Type';
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
                        url: this.base_url + '/reports/zones',
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        data: this.form,
                    }).then(response => {
                    // console.log(response.data.skeletalelements);
                    this.skeletalElements = response.data.skeletalelements;
                    this.zones = response.data.zones;
                    if (this.skeletalElements.length == 0){
                        this.snackbar=true;
                        this.snackbar_text = 'No Specimen Records Found. Refine your search';
                        this.snackbar_color = 'info';
                    }
                    else
                        this.showresults = true;
                    eventBus.$emit('generate-loading', false);
                    succeed = true;
                }).catch(error => {
                    errored = true;
                    console.log(error);
                    eventBus.$emit('generate-loading', false);
                })
            },
            getZonelist() {
                this.form.zone_select = null;
                this.loading = true;
                var succeed = null;
                var errored = null;
                axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrf;

                if (this.form.sb_select != null){
                    axios
                        .request({
                            url: this.base_url + '/reports/jsonzonesarray',
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            data: {sb_select: this.form.sb_select},
                        }).then(response => {
                        // console.log(response.data);
                        this.zoneOptions = response.data;
                        if (this.zoneOptions.length == 0){
                            this.loading = false;
                        }
                        succeed = true;
                        this.loading = false;
                    }).catch(error => {
                        errored = true;
                        console.log(error);
                        this.zoneOptions = {};
                        this.loading = false;
                    })
                }
                else{
                    this.loading = false;
                    this.method = {};
                    console.log("Please Select the Bone");
                }
            },
            disable(){
                return this.form.sb_select && this.form.zone_select && this.form.search_type_select ? false : true;
            }
        },
        computed: {
            zonedata: function () {
                return changeObjectToArray(this.zoneOptions)
            },
        },
        watch: {
            'form.sb_select'(newVal) {
                this.getZonelist();
            },
        }
    }
</script>

<style scoped>

</style>