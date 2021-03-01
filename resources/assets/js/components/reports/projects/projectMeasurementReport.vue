<template>
    <div class="m-2">
        <contentheader :trail="this.trail" model_name="project_measurements" :reset_menu="true" @eventReset="reset"
                       :collapse_menu="true" @eventCollapse="onExpand(false)" @eventExpand="onExpand(true)"
                       :generate_menu="true"   :disable_generate="this.disable_generate" @eventGenerate="generate">
        </contentheader>
        <br>
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
                </v-row>
                <v-row>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.sb_select" :items="items_bones"  :disabled="disable_sb_id" item-text ="name" @change="toggleDisable('bone')"
                                        item-value="id"  label="Bones"  placeholder="Select Bone" dusk="se-bone" clearable></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.side_select" :items="side" :disabled="disable_sb_id" label="Side" placeholder="Select Side" dusk="se-side" clearable></v-autocomplete>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.individual_number_select" :items="items_inumber" :disabled="disable_inum"  item-text ="name"
                                        @change="toggleDisable('inumber')" label="Individual Number"  placeholder="Select Individual Number" dusk="se-individual-number" clearable></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.side_select_INumber" :items="side" :disabled="disable_inum" label="Side" placeholder="Select Side" dusk="inumber-side" clearable></v-autocomplete>
                    </v-col>
                </v-row>
            </v-container>
            <div v-show="showTable">
                <v-row>
                    <v-col cols="9">
                        <v-btn-toggle v-model="toggle_multiple" dense multiple>
                            <v-btn dusk="excel">Excel</v-btn>
                            <v-menu right offset-x :close-on-content-click="false" max-height="500px">
                                <template v-slot:activator="{ on }">
                                    <v-btn v-on="on" dusk="column-visibility">Column Visibility<v-icon right>$dropdown</v-icon></v-btn>
                                </template>
                                <v-list>
                                    <v-list-item v-for="(header, index) in boneHeaders" :key="index">
                                        <v-checkbox v-bind:label="header.text" v-model="header.visibility" :value="header.visibility" :dusk="header.text"></v-checkbox>
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </v-btn-toggle>
                    </v-col>
                    <v-spacer></v-spacer>
                    <v-col cols="3">
                        <v-text-field v-model="search" label="Search" clearable append-icon="mdi-magnify" dusk="search-datatable"></v-text-field>
                    </v-col>
                </v-row>
                <v-data-table :headers="columnVisibility" :items="measure" :items-per-page="perPage" :options.sync="options" :server-items-length="totalSearchCount"
                              calculate-widths="" class="elevation-1" :sort-by="['key']" multi-sort :search="search"
                              :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }">
                    <template v-slot:item.key="{ item }"><a :href="`/skeletalelements/${item.se_id}`" target="_blank">{{ item.key }}</a></template>
                </v-data-table>
            </div>
        </v-card>
    </div>
</template>
<script>
    import { mapGetters, mapState } from 'vuex';
    import { eventBus } from '../../../eventBus';
    import axios from "axios";
    export default {
        name: "projectMeasurementReport",
        data() {
            return {
                trail: [{text: 'Home', disabled: false, href: '/'},
                    {text: 'Reports Dashboard', disabled: false, href: '/reports/dashboard'},
                    {text: 'Measurements Report', disabled: true, href: '/measurements'},
                ],
                showReportCriteria: true,
                form: {},
                disable_sb_id: false,
                disable_inum: false,
                disable_generate: true,
                snackbar: {
                    show: false,
                    message: null,
                    color: null
                },
                skeletalElements: [],
                side: ["Left", "Right", "Middle", "Unsided"],
                showTable: false,
                totalSearchCount: 0,
                items_bones: [],
                perPage: 100,
                options: {},
                loading: false,
                boneHeaders: [
                    {text: 'Key', value: 'key', visibility: true},
                    {text: 'Bone', value: 'bone', visibility: true},
                    {text: 'Side', value: 'side', visibility: true},
                ],
                iNUMheaders: [
                    {text: 'Measurement', value: 'measurementname', visibility: true},
                ],
                search: "",
                toggle_multiple: [],
                measurementcolumns: [],
                measurements: [],
                showINResults: false,
                showresults: false,
            }
        },
        created() {
            let bone = this.$store.getters.getBones;
            this.items_bones = bone.filter(el => {
                return el.measurements === true
            })
        },
        watch: {
            options: {
                handler() {
                    this.generate()
                },
                deep: true,
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
                if (!this.disable_generate) {
                    eventBus.$emit('generate-loading', true);
                    this.showTable = false;
                    this.showINResults = false;
                    this.showresults = false;
                    axios
                        .request({
                            url: '/api/reports/projects/' + this.project_id + '/measurements',
                            method: "GET",
                            headers: {'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken},
                            params: {
                                an: this.form.an ? [this.form.an] : null,
                                p1: this.form.p1 ? [this.form.p1] : null,
                                p2: this.form.p2 ? [this.form.p2] : null,
                                individual_number_select: this.form.individual_number_select ? [this.form.individual_number_select] : null,
                                sb_select: this.form.sb_select ? [this.form.sb_select] : null,
                                side_select: this.form.side_select ? [this.form.side_select] : null,
                                side_select_INumber: this.form.side_select_INumber ? [this.form.side_select_INumber] : null,
                                page: this.options.page,
                                per_page: this.perPage
                            }
                        }).then(response => {
                        eventBus.$emit('generate-loading', false);
                        this.showTable = true;
                        this.skeletalElements = response.data.data;
                        this.measurements = response.data.measurements;
                        this.totalSearchCount = response.data.meta.total;
                        if (this.form.individual_number_select){
                            this.showINResults = true;
                        }
                        else{
                            this.showresults = true;
                        }
                        this.getHeaders();
                    })
                        .catch(error => {
                            console.log(error);
                            this.showTable = false;
                            eventBus.$emit('generate-loading', false);
                        })
                }
            },
            toggleDisable(name) {
                if (name === "inumber") {
                    if (this.form.individual_number_select) {
                        this.disable_sb_id = true;
                        this.disable_generate = false;
                        eventBus.$emit('disable_generate', this.disable_generate);
                    }
                    else {
                        this.disable_sb_id = false;
                        this.disable_generate = true;
                        eventBus.$emit('disable_generate', this.disable_generate);
                    }
                } else {
                    if (this.form.sb_select) {
                        this.disable_inum = true;
                        this.disable_generate = false;
                        eventBus.$emit('disable_generate', this.disable_generate);
                    }
                    else {
                        this.disable_inum = false;
                        this.disable_generate = true;
                        eventBus.$emit('disable_generate', this.disable_generate);
                    }
                }
            },
            getMeasure(measure) {
                var finalcolumns={};
                for(var col=0; col<this.measurementcolumns.length; col++) {
                    if (measure.id === this.measurementcolumns[col].measurement_id) {
                        finalcolumns[this.measurementcolumns[col].se_id] = this.measurementcolumns[col].measure;
                    }
                }
                return finalcolumns;
            },
            getSEMeasure(item){
                var finalcolumns={};
                var measure_id = null;
                for(var col=0; col<this.measurementcolumns.length; col++){
                    if (item.id === this.measurementcolumns[col].se_id){
                        measure_id=this.measurementcolumns[col].measurement_id;
                        finalcolumns[measure_id]=this.measurementcolumns[col].measure;
                        this.boneHeaders.forEach(title => title.value === measure_id ? title.visibility = true:false);
                    }
                }
                return finalcolumns;
            },
            getKey(item) {
                var key = `${item.accession_number ? item.accession_number : ''}:${item.provenance1 ? item.provenance1 : ''}:${item.provenance2 ? item.provenance2 : ''}:${item.designator ? item.designator : ''}`;
                var bone = item.skeletalbone.name;
                var side = item.side;
                return `${key}-${bone}-${side}`;
            },
            getHeaders() {
                this.boneHeaders.splice(3, 1000);
                this.iNUMheaders.splice(1, 1000);
                if(this.form.sb_select) {
                    this.measurements.forEach(measure =>
                        this.boneHeaders.push({
                            text: measure.name,
                            value: measure.id.toString(),
                            visibility: true
                        })
                    );
                }
                else{
                    this.skeletalElements.forEach(item =>
                        this.iNUMheaders.push({
                            text:this.getKey(item),
                            value:item.id.toString(),
                            visibility: true
                        })
                    );
                }
            },
        },
        computed: {
            ...mapState({rowsPerPageItems: state => state.search.rowsPerPageItems,}),
            ...mapGetters({
                items_accessions: 'getProjectAccessions',
                items_provenance1: 'getProjectProvenance1',
                items_provenance2: 'getProjectProvenance2',
                project_id: 'theProjectId',
                items_inumber: 'getProjectIndividualNumbers',
            }),
            measure() {
                const rows = [];
                this.measurementcolumns = [];
                for (var i = 0; i < this.skeletalElements.length; i++) {
                    for (var j = 0; j < this.skeletalElements[i].measurements.length; j++) {
                        this.measurementcolumns.push({
                            se_id: this.skeletalElements[i].measurements[j].pivot.se_id,
                            measurement_id: this.skeletalElements[i].measurements[j].pivot.measurement_id,
                            measure: this.skeletalElements[i].measurements[j].pivot.measure
                        })
                    }
                }
                if(this.showINResults){
                    this.measurements.forEach(measure =>
                        rows.push({
                            measurementname: measure.name,
                            ...this.getMeasure(measure)
                        })
                    );
                }else{
                    this.skeletalElements.forEach(item => //look at measurements report line 116 - 120 there is key, bone, side do we need that?
                        rows.push({
                            se_id: item.id,
                            key: this.getKey(item),
                            bone: item.skeletalbone ? item.skeletalbone.name : null,
                            side: item.side,
                            ...this.getSEMeasure(item)
                        })
                    );
                }
                return rows;
            },
            columnVisibility() {
                if(this.showINResults){
                    return this.iNUMheaders.filter(item => item.visibility === true);
                }else{
                    return this.boneHeaders.filter(item => item.visibility === true);
                }
            },
        }
    }
</script>