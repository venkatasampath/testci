<template>
    <div class="m-2">
        <contentheader v-if="show_contentheader" :trail="trail" :title="heading" :se_action_menu="true" :specimen="specimen"></contentheader>
        <!--        <v-alert v-if="alert" class="my-1" border="left" colored-border type="info" elevation="2" dismissible>{{alertText}}</v-alert>-->
        <specimen-highlights v-if="show_contentheader" :specimen="specimen"></specimen-highlights>
        <v-card>
            <v-card-text>
                <v-stepper v-model="step" vertical non-linear>
                    <v-stepper-step editable :complete="step > 1" step="1">
                        <v-badge :color="state.general.color" :content="state.general.badge"
                                 :value="!state.general.action.create">
                            <span>General</span>
                        </v-badge>
                    </v-stepper-step>
                    <v-stepper-content step="1">
                        <keep-alive><review-general v-if="step==1" :specimen="specimen"/></keep-alive>
                    </v-stepper-content>
                    <v-stepper-step editable :complete="step > 2" step="2" dusk="biological-review">Biological Profile</v-stepper-step>
                    <v-stepper-content step="2">
                        <v-row>
                            <v-col cols="12">
                                <keep-alive>
                                    <review-methods v-if="step==2" :specimen="specimen"></review-methods>
                                </keep-alive>
                            </v-col>
                        </v-row>
                    </v-stepper-content>
                    <v-stepper-step editable :complete="step > 3" step="3" dusk="dna-review">DNA</v-stepper-step>
                    <v-stepper-content step="3">
                        <keep-alive>
                            <review-dna v-if="step==3" :specimen="specimen" :methodoptions="methodoptions"
                                        :haplooptions="haplooptions"
                                        :austrmethodoptions="austrmethodoptions"
                                        :ystrmethodoptions="ystrmethodoptions"
                                        :ystrhaplooptions="ystrhaplooptions"
                                        :austrstatusoptions="austrstatusoptions"
                                        :statusoptions="statusoptions"
                                        :dispositionoptions="dispositionoptions"
                                        :conditionoptions="conditionoptions"
                                        :mitohaplooptions="mitohaplooptions"
                                        :mitomethodoptions="mitomethodoptions"
                                        :list_confidence="list_confidence"
                            ></review-dna>
                        </keep-alive>
                    </v-stepper-content>
                    <v-stepper-step editable :complete="step > 4" step="4">
                        <v-badge :color="state.taphonomys.color" :content="state.taphonomys.badge"
                                 :value="!state.taphonomys.action.create">
                            <span>Taphonomy</span>
                        </v-badge>
                    </v-stepper-step>
                    <v-stepper-content step="4">
                        <keep-alive><review-taphonomy v-if="step==4" :specimen="specimen"/></keep-alive>
                    </v-stepper-content>
                    <v-stepper-step editable :complete="step > 5" step="5" dusk="zones-step">Zones</v-stepper-step>
                    <v-stepper-content step="5">

                        <keep-alive>
                            <review-zones v-if="step==5" type="zones" :list_zones="list_zones"
                                          :specimen="specimen"></review-zones>
                        </keep-alive>

                    </v-stepper-content>
                    <v-stepper-step editable :complete="step > 6" step="6" dusk="measurements-step">Measurements</v-stepper-step>
                    <v-stepper-content step="6">
                        <div v-if="step==6">
                            <keep-alive>
                                <review-measurements :specimen="specimen"/>
                            </keep-alive>
                        </div>
                    </v-stepper-content>
                    <!-- Beginning of Association -->
                    <v-stepper-step editable :complete="step > 7" step="7" dusk="associations-step" >Associations</v-stepper-step>
                    <v-stepper-content step="7">
                        <v-row>
                            <v-expansion-panels>
                                <v-expansion-panel dusk="articulations-panel">
                                    <v-expansion-panel-header>
                                        <!--                                        <v-badge class="ml-2" :color="state.articulations.color" :content="state.articulations.badge" :value="!state.articulations.action.create">-->
                                        <span class="mx-2" dusk="articulations-review">Articulations</span>
                                        <!--                                        </v-badge>-->
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <div class="col-md-12">
                                            <keep-alive>
                                                <review-association v-if="step==7" :specimen="specimen"
                                                                    type="articulations"></review-association>
                                            </keep-alive>
                                        </div>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                            </v-expansion-panels>
                        </v-row>
                        <v-row>
                            <v-expansion-panels dusk="pairmatching-panel">
                                <v-expansion-panel>
                                    <v-expansion-panel-header><span class="mx-2">Pair Matching</span>
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <div class="col-md-12">
                                            <keep-alive>
                                                <review-association v-if="step==7" :specimen="specimen"
                                                                    type="pairs"></review-association>
                                            </keep-alive>
                                        </div>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                            </v-expansion-panels>
                        </v-row>
                        <v-row>
                            <v-expansion-panels>
                                <v-expansion-panel dusk="refits-panel">
                                    <v-expansion-panel-header><span class="mx-2">Refits</span>
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <div class="col-md-12">
                                            <keep-alive>
                                                <review-association v-if="step==7" :specimen="specimen"
                                                                    type="refits"></review-association>
                                            </keep-alive>
                                        </div>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                            </v-expansion-panels>
                        </v-row>
                        <v-row>
                            <v-expansion-panels>
                                <v-expansion-panel dusk="morphology-panel">
                                    <v-expansion-panel-header><span class="mx-2">Morphology</span>
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <div class="col-md-12">
                                            <keep-alive>
                                                <review-association v-if="step==7" :specimen="specimen"
                                                                    type="morphology"></review-association>
                                            </keep-alive>
                                        </div>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                            </v-expansion-panels>
                        </v-row>
                        <!-- End of Association -->
                    </v-stepper-content>
                    <v-stepper-step editable :complete="step > 8" step="8" dusk="pathology-review">Pathologies</v-stepper-step>
                    <v-stepper-content step="8">
                        <v-row>
                            <v-expansion-panels dusk="pathology-panel">
                                <v-expansion-panel>
                                    <v-expansion-panel-header><span class="mx-2">Pathology</span>
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <keep-alive>
                                            <review-pathology :specimen="specimen" :list_zones="list_zones"
                                                              :list_pathology="list_pathology"
                                                              type="pathologys"></review-pathology>
                                        </keep-alive>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                            </v-expansion-panels>
                        </v-row>

                        <v-row>
                            <v-expansion-panels>
                                <v-expansion-panel dusk="trauma-panel">
                                    <v-expansion-panel-header><span class="mx-2">Trauma</span>
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <keep-alive>
                                            <review-trauma :specimen="specimen" :list_zones="list_zones"
                                                           :list_trauma="list_trauma" type="traumas"></review-trauma>
                                        </keep-alive>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                            </v-expansion-panels>
                        </v-row>

                        <v-row>
                            <v-expansion-panels>
                                <v-expansion-panel dusk="anomaly-panel">
                                    <v-expansion-panel-header><span class="mx-2">Anomaly</span>
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <keep-alive>
                                            <review-anomaly :specimen="specimen" :list_anomaly="list_anomaly"
                                                            type="anomalys"></review-anomaly>
                                        </keep-alive>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                            </v-expansion-panels>
                        </v-row>
                    </v-stepper-content>
                </v-stepper>
            </v-card-text>
            <v-card-actions>
                <v-row class="justify-center">
                    <v-btn v-if="show_notify_review_ready && (theUser.id !== specimen.user_id)" color="primary" class="mr-2" @click="notifyReviewReady"><v-icon class="mr-2">mdi-account-alert</v-icon>Notify Review Ready</v-btn>
                    <v-btn v-if="show_review_complete" color="primary" class="mr-2" @click="reviewComplete"><v-icon class="mr-2">mdi-eye-check</v-icon>Review Complete</v-btn>
                </v-row>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
import {mapGetters, mapState} from "vuex";
import {bus} from "../../../coraBaseModules";
import {eventBus} from "../../../eventBus";
import axios from "axios";
import {diff} from "../../../utilities/diff";
import ReviewDna from "./reviewDNA";

export default {
        name: 'review-main',
    components: {ReviewDna},
    props: {
            specimen: { type: Object, required: true },
            crud_action: { type: String, default: "Edit" },
            heading: { type: String, default: "Specimen Review" },
            contentheader: { type:Boolean, default: true },
            cols: { type:Number, default: 12 },
            readonly: { type: Boolean, default: false },

            specimen_id: [String, Number],
            base_url: String,
            sb_id: [String, Number],
            suffix: String,

            //dropdowns
            laboptions: Object,
            methodoptions: Object,
            haplooptions: Object,
            austrmethodoptions: Object,
            ystrmethodoptions: Object,
        ystrhaplooptions: [Object, Array],
            austrstatusoptions: '',
            statusoptions: Object,
        dispositionoptions: Object,
        conditionoptions: Object,
            list_zones: [Object, Array],
            list_pathology: [Object, Array],
            list_trauma: [Object, Array],
            list_anomaly: [Object, Array],
            list_sb: [Object, Array],
            zones_base_data: [Object, Array],
        mitohaplooptions: [Object, Array],
        mitomethodoptions: [Object, Array],
        list_confidence: [Object, Array],
        },
        data() {
            return {
                show_contentheader: this.contentheader,
                trail: [{text: 'Home', disabled: false, href: '/',},
                    {
                        text: 'Specimen',
                        disabled: false,
                        href: (this.specimen) ? '/skeletalelements/' + this.specimen.id : "/"
                    },
                    {text: 'Review', disabled: true, href: "/"},
                ],

                show_notify_review_ready: false,
                show_review_complete: false,
                state: {
                    general: {
                        type: "general",
                        diff: {},
                        pass: false,
                        color: "warning",
                        action: {create: true, edit: false},
                        accepted: false,
                        badge: "0",
                    },
                    taphonomys: { type: "taphonomys", diff: null, pass: false, color: "warning", action: {create: true, edit: false }, accepted: false, badge: "0" },
                    articulations: {
                        type: "articulations",
                        diff: null,
                        pass: false,
                        color: "warning",
                        action: {create: true, edit: false},
                        accepted: false,
                        badge: "0"
                    },
                    pairs: {
                        type: "pairs",
                        diff: null,
                        pass: false,
                        color: "warning",
                        action: {create: true, edit: false},
                        accepted: false,
                        badge: "0"
                    },
                    refits: {
                        type: "refits",
                        diff: null,
                        pass: false,
                        color: "warning",
                        action: {create: true, edit: false},
                        accepted: false,
                        badge: "0"
                    },
                    morphologys: {
                        type: "morphologys",
                        diff: null,
                        pass: false,
                        color: "warning",
                        action: {create: true, edit: false},
                        accepted: false,
                        badge: "0"
                    },
                    // bioProfile: { type: "bioProfile", diff: {}, pass: false, color: "warning", action: {create: true, edit: false }, accepted: false },
                    // dna: { type: "dna", diff: {}, pass: false, color: "warning", action: {create: true, edit: false }, accepted: false },
                    // zones: { type: "zones", diff: {}, pass: false, color: "warning", action: {create: true, edit: false }, accepted: false },
                    // measurements: { type: "measurements", diff: {}, pass: false, color: "warning", action: {create: true, edit: false }, accepted: false },
                    // associations: { type: "associations", diff: {}, pass: false, color: "warning", action: {create: true, edit: false }, accepted: false },
                    // pathologys: { type: "pathologys", diff: {}, pass: false, color: "warning", action: {create: true, edit: false }, accepted: false },
                },

                step: 1,
                disabled: true,
                nolabel: null,
                reviewArticulations: null,
                //dna
                reviewedlab: '',
                reviewedmethod: '',
                reviewedcase: '',
                reviewedsamplenum: '',
                revieweddate: '',
                reviewedstatus: '',
                reviewedseqnum: '',
                reviewedsubgroup: '',
                reviewedseqsimilar: '',
                reviewedlocinum: '',
                reviewedcount: '',
                reviewedtotalcount: '',
                reviewedmccdate: '',

                //measurements
                originalmeasurements: [],
                reviewedmeasurements: [],

                //options
                labs: Object,
                methods: Object,
                statuses: Object,
                haplos: Object,
                austrmethods: Object,
                ystrmethods: Object,
                ystrhaplos: Object,
                austrstatuses: Object,
            };
        },
        created() {
            eventBus.$on('review', payload => {
                console.log("reviewEvent received: with payload " + JSON.stringify(payload));
                if (payload.state.type === "general") {
                    this.state.general = payload.state;
                    let differences = this.state.general.diff = diff(this.state.general.original, this.state.general.review);
                    let diff_count = this.state.general.diffCount = Object.keys(this.state.general.diff).length;
                    let color = this.state.general.color = (this.state.general.diffCount) ? "warning" : "success";
                    let pass = this.state.general.pass = !(this.state.general.diffCount);
                    let badge = (!this.state.general.diffCount) ? '✔' : this.state.general.diffCount
                    // For reactivity to work in Objects we need to assign a new object, see https://vuejs.org/v2/guide/reactivity.html
                    this.state.general = Object.assign({}, this.state.general,
                        { diff: differences, diffCount: diff_count, color: color, pass: pass, badge:  badge, });
                } else if (payload.state.type === "taphonomys") {
                    this.state.taphonomys = payload.state;
                    // this.state.taphonomys.diff = diff(this.state.taphonomys.original, this.state.taphonomys.review);
                    // this.state.taphonomys.diffCount = Object.keys(this.state.taphonomys.diff).length;
                    let differences = this.state.taphonomys.diff = this.difference(this.state.taphonomys.original, this.state.taphonomys.review);
                    let diff_count = this.state.taphonomys.diffCount = this.state.taphonomys.diff.length;
                    let color = this.state.taphonomys.color = (this.state.taphonomys.diffCount) ? "warning" : "success";
                    let pass = this.state.taphonomys.pass = !(this.state.taphonomys.diffCount);
                    let badge = (!this.state.taphonomys.diffCount) ? '✔' : this.state.taphonomys.diffCount
                    this.state.taphonomys = Object.assign({}, this.state.taphonomys,
                        { diff: differences, diffCount: diff_count, color: color, pass: pass, badge:  badge, });
                } else if (payload.state.type === "articulations") {
                    let differences = this.state.articulations.diff = this.difference(this.state.articulations.original, this.state.articulations.review);
                    let diff_count = this.state.articulations.diffCount = this.state.articulations.diff.length;
                    let color = this.state.articulations.color = (this.state.articulations.diffCount) ? "warning" : "success";
                    let pass = this.state.articulations.pass = !(this.state.articulations.diffCount);
                    let badge = (!this.state.articulations.diffCount) ? '✔' : this.state.articulations.diffCount;
                    this.state.articulations = Object.assign({}, this.state.articulations,
                        {diff: differences, diffCount: diff_count, color: color, pass: pass, badge: badge,});
                }
            });
        },
        beforeMount() {
            this.labs = this.laboptions;
            this.methods = this.methodoptions;
            this.statuses = this.statusoptions;
            this.haplos = this.haplooptions;
            this.austrmethods = this.austrmethodoptions;
            this.ystrmethods = this.ystrmethodoptions;
            this.ystrhaplos = this.ystrhaplooptions;
        },
        mounted() {
            console.log(this.$children)
        },
        methods: {
            difference(arr1, arr2) {
                return arr1.filter(x => !arr2.includes(x)).concat(arr2.filter(x => !arr1.includes(x)));
            },
            generalReviewState() {
                bus.$emit('')
            },
            saveTaphonomy() {
                bus.$emit('saveTaphonomy', true);
            },
            saveAnomaly() {
                bus.$emit('saveAnomaly', true);
            },
            saveArticulations() {
                bus.$emit('saveArticulations', true);
            },
            saveAssociation() {
                console.log(this.reviewArticulations)
            },
            reviewComplete() {
                axios
                    .request({ url: "/api/review/" + this.specimen.id + "/complete", method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken,},
                    })
                    .then(response => {
                        this.loading = false;
                        let payload = {'text': 'Update successful', 'color': 'success',};
                        eventBus.$emit('show-snackbar', payload);
                        // Now that review is complete, send the user to the specimen screen
                        // This will allow them to see that the reviewed flag/date are set.
                        window.location.href = '/skeletalelements/'+this.specimen.id;
                    }).catch(error => {
                        console.log(error.response);
                        this.loading = false;
                })

            },
            notifyReviewReady() {
                axios
                    .request({ url: "/api/review/" + this.specimen.id + "/notify-review-ready", method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken,},
                    })
                    .then(response => {
                        this.loading = false;
                        let payload = {'text': 'Notifications send successful', 'color': 'success',};
                        eventBus.$emit('show-snackbar', payload);
                    }).catch(error => {
                        console.log(error.response);
                        this.loading = false;
                })
            },
        },
        watch: {
            state: {
                handler: function () {
                    let passAll = true;
                    // console.log("Watch state: $data: " + JSON.stringify(this.$data));
                    const entries = Object.entries(this.$data.state);
                    for (const [reviewName, review] of entries) {
                        console.log("Watch state: reviewName: " + reviewName);
                        if (!review.pass) {
                            passAll = false;
                        }
                    }
                    console.log("reviewMain: Watch state: passAll: " + passAll);
                    if (passAll) {
                        this.show_notify_review_ready = true;
                        this.show_review_complete = true;
                    } else {
                        this.show_notify_review_ready = false;
                        this.show_review_complete = false;
                    }
                },
                deep: true,
            },
        },
        computed: {
            ...mapState({
                //
            }),
            ...mapGetters({
                bearerToken: 'bearerToken',
                csrfToken: 'csrfToken',
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
                isAdminOrOrgAdmin: 'isAdminOrOrgAdmin',
                isProjectManager: 'isProjectManager',
            }),
        }
    }
</script>

<style>

</style>