<template>
    <div class="m-2">
        <contentheader :trail="this.trail" model_name="method-report" :reset_menu="true" @eventReset="reset"
                       :collapse_menu="true" @eventCollapse="onExpand(false)" @eventExpand="onExpand(true)"
                       :disable_generate="this.disable_generate" :generate_menu="true" @eventGenerate="generate">
        </contentheader>
        <v-card>
            <v-container fluid v-show="showReportCriteria">
                <v-row>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.an" :items="items_accessions" label="Accession Number" placeholder="Select Accession Number" dusk="se-accession" clearable></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.p1" :items="items_provenance1" label="Provenance 1" placeholder="Select Provenance 1" dusk="se-provenance1" clearable></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.p2" :items="items_provenance2" label="Provenance 2" placeholder="Select Provenance 2" dusk="se-provenance2" clearable></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.sb_select" :items="items_bones" item-text="name" item-value="id" label="Bone" placeholder="Select Bone" dusk="se-bone"
                                        required :rules="[v => !!v || 'Bone is required']" clearable @change="toggleDisable()"></v-autocomplete>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete name="method_type_select" v-model="form.method_type_select" :items="methodtype"
                                        dusk="se-methodtype" label="Method Type" placeholder="Select Method Type" clearable>
                        </v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.method_select" :items="methodOptions" item-text="name" item-value="id" clearable
                                        dusk="se-method" label="Method" placeholder="Select Method" :loading="loadingMethod"
                                        @change="toggleDisable()" required :rules="[v => !!v || 'Method is required']">
                        </v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.method_feature_select"  :items="methodFeatureOptions" item-text="feature" clearable
                                        item-value="id" dusk="se-methodfeature" label="Method Feature" placeholder="Select Method Feature" :loading="loadingFeature">
                        </v-autocomplete>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete name="score_select" v-model="form.score_select" :items="methodScoreData" item-text="text" clearable
                                        item-value="value" dusk="se-score" label="Score" placeholder="Select Score" :loading="loadingScore">
                        </v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete name="range_select" v-model="form.range_select" :items="methodRangeData" item-text="text" clearable
                                        :disabled="disable_range" item-value="value" dusk="se-range" label="Range" placeholder="Select Range" :loading="loadingRange">
                        </v-autocomplete>
                    </v-col>
                </v-row>
            </v-container>
            <div v-show="showTable">
                <v-row>
                    <v-col cols="9">
                        <v-btn-toggle v-model="toggleMultiple" dense dark multiple>
                            <v-btn dusk="excel">Excel</v-btn>
                            <v-menu
                                    right
                                    offset-x
                                    :close-on-content-click="false"
                                    max-height="500px">
                                <template v-slot:activator="{ on }">
                                    <v-btn v-on="on" dusk="column-visibility">Column Visibility
                                        <v-icon right>$dropdown</v-icon>
                                    </v-btn>
                                </template>

                                <v-list>
                                    <v-list-item v-for="(header, index) in headers" :key="index">
                                        <v-checkbox
                                                v-bind:label="header.text"
                                                v-model="header.visibility"
                                                :value="header.visibility"
                                                :dusk="header.text"
                                        />
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </v-btn-toggle>
                    </v-col>

                    <v-spacer />

                    <v-col cols="3">
                        <v-text-field
                                v-model="search"
                                label="Search"
                                single-line
                                hide-details />
                    </v-col>
                </v-row>

                <v-data-table :headers="columnVisibility" :items="data" :items-per-page="perPage" :options.sync="options" :server-items-length="totalSearchCount"
                              calculate-widths="" class="elevation-1" :sort-by="['key']" multi-sort :search="search"
                              :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }">
                    <template v-slot:item.key="{ item }">
                        <a :href="`/skeletalelements/${item.se_id}`" target="_blank">{{ item.key }}</a>
                    </template>
                </v-data-table>
            </div>
            <v-snackbar v-if="snackbar" :snackbar_color="snackbar_color" :snackbar_text="snackbar_text" :snackbar="snackbar" @close="snackbar = false"></v-snackbar>
        </v-card>
    </div>
</template>

<script>
    import {changeObjectToArray} from "../../../coraBaseModules";
    import axios from "axios";
    import {eventBus} from "../../../eventBus";
    import { mapState, mapGetters} from 'vuex';
    export default {
        name: "projectMethodReport",
        data() {
            return {
                form: {},
                showReportCriteria: true,
                disable_generate: true,
                showTable: false,
                methodOptions: [],
                methodFeatureOptions: [],
                methodScoreOptions: {},
                methodRangeOptions: [],
                loadingMethod: false,
                loadingFeature: false,
                loadingScore: false,
                loadingRange: false,
                disable_range:false,
                snackbar:false,
                snackbar_text:'',
                snackbar_color:'',
                skeletalElements:{},
                options: {},
                totalSearchCount:0,
                perPage:100,
                methodtype: ['Age', 'Ancestry', 'Sex'],
                trail: [{text: 'Home', disabled: false, href: '/',},
                    {text: 'Reports Dashboard', diasbled: false, href: '/reports/dashboard'},
                    {text: 'Methods Report', disabled: true, href: '/methods',},
                ],
                headers: [
                    {text: 'Key', value: 'key', visibility: true},
                    {text: 'Bone', value: 'bone', visibility: true},
                    {text: 'Side', value: 'side', visibility: true},
                    {text: 'Method', value: 'method', visibility: true},
                    {text: 'Method Feature', value: 'method_feature', visibility: true},
                    {text: 'Score', value: 'score', visibility: true},
                ],
                search: '',
                toggleMultiple: [],
            }
        },
        watch: {
            options: {
                handler() {
                    this.generate()
                },
                deep: true,
            },
            'form.sb_select'() {
                this.getMethodlist();
            },
            'form.method_type_select'() {
                this.getMethodlist();
            },
            'form.method_select'() {
                this.getMethodFeatures();
            },
            'form.method_feature_select'() {
                this.getMethodScorelist();
            },
        },
        methods: {
            reset() {
                this.form = {};
                this.showTable = false;
            },
            onExpand(val) {
                this.showReportCriteria = val;
            },
            generate() {
                if(!this.disable_generate) {
                eventBus.$emit('generate-loading', true);
                var succeed = null;
                var errored = null;
                this.showTable = false;
                axios
                    .request({
                        url: '/api/reports/projects/' + this.project_id + '/methods',
                        method: 'GET',
                        headers: {'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken},
                        params: {
                            an: this.form.an ? [this.form.an] : null, p1: this.form.p1 ? [this.form.p1] : null, p2: this.form.p2 ? [this.form.p2] : null,
                            sb_select: this.form.sb_select ? [this.form.sb_select] : null, method_select: this.form.method_select? [this.form.method_select] : null,
                            method_feature_select: this.form.method_feature_select ? [this.form.method_feature_select] : null,
                            score_select: this.form.score_select ? this.form.score_select: null, range_select: this.form.range_select? this.form.range_select : null,
                            page: this.options.page,
                            per_page: this.options.itemsPerPage
                        }
                    }).then(response => {
                    this.skeletalElements = response.data.data;
                    this.totalSearchCount = response.data.meta.total;
                    eventBus.$emit('generate-loading', false);
                    this.showTable = true;
                }).catch(error => {
                    errored = true;
                    // console.log(error)
                    eventBus.$emit('generate-loading', false);
                })
                }
            },
            getMethodlist() {
                let bone = this.form.sb_select;
                let methodtype = this.form.method_type_select;
                this.loadingMethod = true;
                if (bone && methodtype) {
                    this.methodOptions = this.methodByBoneType(bone, methodtype);
                    this.loadingMethod = false;
                } else {
                    this.methodOptions = this.methodByBone(bone);
                    this.loadingMethod = false;
                }
            },
            getMethodFeatures() {
                let method = this.form.method_select;
                this.methodFeatureOptions = this.methodFeature(method);
            },
            getMethodScorelist() {
                this.loadingScore = true;
                this.loadingRange = true;
                if (this.form.score_select) {
                    this.form.score_select = null;
                }
                if (this.form.range_select) {
                    this.form.range_select = null;
                }
                var succeed = null;
                var errored = null;
                if (this.form.method_feature_select != null) {
                    axios
                        .request({
                            url: '/api/reports/jsonscoresarray',
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': this.$store.getters.bearerToken
                            },
                            params: {method_feature_select: this.form.method_feature_select ? [this.form.method_feature_select] : null},
                        }).then(response => {
                        // console.log(response.data);
                        this.methodScoreOptions = response.data;
                        if (this.methodScoreOptions.length == 0) {
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
                            url: '/api/reports/jsonrangesarray',
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': this.$store.getters.bearerToken
                            },
                            params: {method_feature_select: this.form.method_feature_select ? [this.form.method_feature_select] : null},
                        }).then(response => {
                        // console.log(response.data);
                        this.methodRangeOptions = response.data;
                        if (this.methodRangeOptions.length === 0) {
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
                } else {
                    console.log("No Method Feature are available")
                    this.methodRangeOptions = {};
                    this.methodScoreOptions = {};
                    this.loadingScore = false;
                    this.loadingRange = false;
                }
            },
            toggleDisable(){
                if (this.form.sb_select && this.form.method_select){
                    this.disable_generate = false;
                    eventBus.$emit('disable_generate', this.disable_generate);
                }
                else{
                    this.disable_generate = true;
                    eventBus.$emit('disable_generate', this.disable_generate);
                }
            },
            getKey(item) {
                return `${item.accession_number ? item.accession_number : ""}:${
                    item.provenance1 ? item.provenance1 : ""
                    }:${item.provenance2 ? item.provenance2 : ""}:${
                    item.designator ? item.designator : ""
                    }`;
            },
            getMethod(item) {
                for(var i=0;i<item.methods.length;i++){
                    if (item.method_id === item.methods[i].id)
                        return item.methods[i].name;
                }
            },
            getMethodFeature(item) {
                for(var i=0;i<item.methodfeatures.length;i++){
                    if (item.method_feature_id === item.methodfeatures[i].id)
                        return item.methodfeatures[i].display_name;
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
                items_bones: 'getBones',
                items_traumas: 'getTraumas',
                methodByBone: 'getMethodsByBone',
                methodByBoneType: 'getMethodsByBoneAndType',
                methodFeature: 'getMethodFeaturesByMethodId',
            }),
            data() {
                const rows = [];
                Object.values(this.skeletalElements).forEach(item =>
                    rows.push({
                        se_id:item.id,
                        key: this.getKey(item),
                        bone: item.skeletalbone ? item.skeletalbone.name : null,
                        side: item.side,
                        method: this.getMethod(item),
                        method_feature: this.getMethodFeature(item),
                        score: item.score,
                    })
                );

                return rows;
            },
        methodScoreData() {
            return changeObjectToArray(this.methodScoreOptions)
        },
        methodRangeData() {
            return changeObjectToArray(this.methodRangeOptions)
        },
        columnVisibility() {
            return this.headers.filter(item => item.visibility === true);
        }
      }
    }
</script>

<style scoped>

</style>
