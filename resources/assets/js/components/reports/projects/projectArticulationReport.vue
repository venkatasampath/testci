<template>
    <div class="m-2">
        <contentheader :trail="this.trail" model_name="report-articulations" :reset_menu="true" @eventReset="reset"
                       :collapse_menu="true" @eventCollapse="onExpand(false)" @eventExpand="onExpand(true)"
                       :generate_menu="true" @eventGenerate="generate">
        </contentheader>
        <br>
        <v-card>
            <v-container fluid v-show="showReportCriteria">
                <v-row>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.an" :items="items_accessions" label="Accession Number" placeholder="Select Accession Number" dusk="accession-report" clearable></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.p1" :items="items_provenance1" label="Provenance 1" placeholder="Select Provenance 1" dusk="provenance1-report" clearable></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.p2" :items="items_provenance2" item-text="name" label="Provenance 2" placeholder="Select Provenance 2" dusk="provenance2-report" clearable></v-autocomplete>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.sb_select" :items="items_bones" item-value="id" item-text="name" label="Bone" placeholder="Select Bone" dusk="bone-report" clearable></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.side_select" :items="items_side" label="Side"
                                        placeholder="Select Side" dusk="bone-side-report" clearable></v-autocomplete>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.group_select" :items="items_group"  item-value="id" item-text="group_name" label="Group" placeholder="Select Group" dusk="group-report" clearable></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3" sm="12">
                        <v-autocomplete v-model="form.group_side_select" :items="items_groupside" item-value="value" tem-text="text" label="Group Side" placeholder="Select Side" dusk="group-side-report" clearable></v-autocomplete>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="3" sm="12">
                        <v-btn primary @click.prevent="getSpecimens()" dusk="search-se-btn">
                            <i class="fas fa-btn fa-list"></i>
                            {{ sending ? 'Loading...' : 'Search for Specimens' }}
                        </v-btn>
                    </v-col>
                </v-row>

                <v-row v-show="showNextStep">
                <v-col cols="12" md="4">
                <v-autocomplete v-model="form.skeletalelement_select" :items="specimensArray" item-text="text" item-value="value" label="Specimens" placeholder="Select Specimens" dusk="specimen-report" required/>
                </v-col>
                </v-row>
            </v-container>

            <div v-show="showTable" >
                <div class="m-2">
                    <v-row>
                        <v-col cols="9">
                            <v-btn-toggle v-model="toggleMultiple" dense multiple>
                                <v-btn dusk="excel">Excel</v-btn>
                                <v-menu right offset-x :close-on-content-click="false" max-height="500px">
                                    <template v-slot:activator="{ on }">
                                        <v-btn v-on="on" dusk="column-visibility">Column Visibility<v-icon right>$dropdown</v-icon></v-btn>
                                    </template>
                                    <v-list>
                                        <v-list-item v-for="(header, index) in headers" :key="index">
                                            <v-checkbox v-bind:label="header.text" v-model="header.visibility"
                                                        :value="header.visibility" :dusk="header.text"></v-checkbox>
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

                    <v-data-table :headers="columnVisibility" :items="specimenItems" :items-per-page="perPage" :options.sync="options" :server-items-length="totalSearchCount"
                                  calculate-widths="" class="elevation-1" :sort-by="['key']" multi-sort :search="search"
                                  :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage:true }">
                        <template v-slot:item.composite_key="{ item }">
                            <a :href="`/skeletalelements/${item.composite_key_id}`" target="_blank">{{item.composite_key }}</a>
                        </template>
                        <template v-slot:item.articulated_composite_key="{ item }">
                            <a :href="`/skeletalelements/${item.id}`"
                                    target="_blank">{{item.articulated_composite_key }}</a>
                        </template>
                    </v-data-table>

                    <br>

                </div>
            </div>

        </v-card>

    </div>


</template>

<script>
    import {mapState, mapGetters} from 'vuex';
    import { eventBus } from '../../../eventBus';
    import { changeObjectToArray } from "../../../coraBaseModules";
    import axios from "axios";
    export default {
        name: "projectArticulationReport",
        data() {
            return {
                form: {},
                sending: false,
                info: false,
                showReportCriteria: true,
                showNextStep: false,
                snackbar:false,
                loading: false,
                snackbar_text:'',
                snackbar_color:'',
                specimens: [],
                totalSearchCount: 0,
                perPage:100,
                showTable:false,
                options:{},
                skeletalelements: [],
                skeletalElement: {},
                trail: [{ text: 'Home', disabled: false, href: '/', },
                    {text: 'Reports Dashboard', diasbled: false, href: '/reports/dashboard'},
                    { text: 'Articulations Report', disabled: true, href: '/articulation', },
                ],
                items_groupside: ["Left", "Right", "Middle", "Unsided"],
                items_side: ["Left", "Right", "Middle", "Unsided"],
                headers: [
                    {
                        text: "Composite Key",
                        value: "composite_key",
                        visibility: true,
                        width: "12rem"
                    },
                    { text: "Bone", value: "bone", visibility: true },
                    {
                        text: "Articulated Composite Key",
                        value: "articulated_composite_key",
                        visibility: true,
                        width: "12rem"
                    },
                    {
                        text: "Articulated Bone",
                        value: "articulated_bone",
                        visibility: true,
                        width: "12rem"
                    },
                    { text: "Bone Group", value: "bone_group", visibility: true },
                    { text: "Created By", value: "created_by", visibility: false },
                    { text: "Created At", value: "created_at", visibility: false },
                    { text: "Updated By", value: "updated_by", visibility: false },
                    { text: "Updated At", value: "updated_at", visibility: false }
                ],
                search: "",
                toggleMultiple: []
            }
        },
        methods: {
            reset() {
                this.showNextStep = false;
                this.showTable = false;
                this.specimens = [];
                this.form = {};
            },
            onExpand(val) {
                this.showReportCriteria = val;
            },
            getKey(item) {
                return `${item.accession_number ? item.accession_number : ""}:${
                    item.provenance1 ? item.provenance1 : ""
                    }:${item.provenance2 ? item.provenance2 : ""}:${
                    item.designator ? item.designator : ""
                    }`;
            },
            getBooleanIcon(item) {
                return item === true ? "✔" : "";
            },

            getIconColor(item) {
                return item === true ? "success" : "";
            },
            generate() {
                this.form.finalsearch = true;
                this.showTable = false;
                eventBus.$emit('generate-loading', true);
                axios
                    .request({
                        url: '/api/reports/projects/' + this.project_id + '/articulations',
                        mmethod: "GET",
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken },
                        params: { sb_select: this.form.sb_select ? [this.form.sb_select] : null, side_select: this.form.side_select ? [this.form.side_select] : null,
                            group_select: this.form.group_select ? [this.form.group_select] : null, group_side_select: this.form.group_side_select? [this.form.group_side_select] : null,
                            skeletalelement_select: this.form.skeletalelement_select? [this.form.skeletalelement_select] : null, page: this.options.page,
                            per_page: this.perPage}
                    })
                    .then(response => {
                        const result = response.data.data;
                        eventBus.$emit('generate-loading', false);
                        this.skeletalElement = result.se;
                        this.skeletalelements = result.se.articulations2;
                        this.totalSearchCount = response.data.meta.total;
                        this.showTable = true;
                        if(this.skeletalelements.length === 0) {
                            this.snackbar=true;
                            this.snackbar_text = 'No Articulation Records Found. Refine your search';
                            this.snackbar_color = 'info';
                        }
                    })
                    .catch(() => {
                        this.showTable = false;
                        eventBus.$emit('generate-loading', false);
                    });
            },
            getSpecimens() {
                this.showNextStep = false;
                this.sending = true;
                this.specimens = [];
                delete this.form.finalsearch;
                this.form.skeletalelement_select = null;
                this.showTable = false;
                axios
                    .request({
                        url: '/api/reports/projects/' + this.project_id + '/specimenarticulations',
                        method: "GET",
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken },
                        params: { an: this.form.an ? [this.form.an] : null, p1: this.form.p1 ? [this.form.p1] : null, p2: this.form.p2 ? [this.form.p2] : null,
                            sb_select: this.form.sb_select ? [this.form.sb_select] : null, side_select: this.form.side_select ? [this.form.side_select] : null,
                            group_select: this.form.group_select ? [this.form.group_select] : null, group_side_select: this.form.group_side_select? [this.form.group_side_select] : null,
                        }
                    })
                    .then(response => {
                        const result = response.data;
                        this.showNextStep = true;
                        this.sending = false;
                        this.specimens = result
                        if(this.specimens.length == 0){
                            this.showNextStep = false;
                        }
                    })
                    .catch(() => {
                        this.sending = false;
                    });
            }
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
                getBone: 'getBone',
                items_group: 'getBoneGroupsList',

            }),
            specimenItems() {
                const rows = [];
                this.skeletalelements.forEach(item =>
                    rows.push({
                        id: item.id,
                        composite_key: this.getKey(this.skeletalElement),
                        composite_key_id: this.skeletalElement.id,
                        bone: this.skeletalElement.skeletalbone
                            ? this.skeletalElement.skeletalbone.name
                            : "",
                        articulated_composite_key: this.getKey(item),
                        articulated_bone: item.sb? item.sb.name : "",
                        bone_group: item.bone_group,
                        created_by: item.sb.created_by,
                        created_at: item.sb.created_at,
                        updated_by: item.sb.updated_by,
                        updated_at: item.sb.updated_at
                    })
                );

                return rows;
            },

            columnVisibility() {
                return this.headers.filter(item => item.visibility === true);
            },
            specimensArray() {
                return changeObjectToArray(this.specimens);
            },

        }
    };
</script>