<template>
    <v-card class="m-2 p-0" v-if="show_widget">
        <v-card-title class="m-0 p-0">
            <v-toolbar dense>
                <v-toolbar-title>{{ titles[type] }}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn :title="'Last updated at: '+last_updated_at" icon color="primary"><v-icon>mdi-calendar</v-icon></v-btn>
<!--                    <v-btn title="Refresh" icon color="primary" @click=""><v-icon>mdi-refresh-circle</v-icon></v-btn>-->
                <v-btn title="Help - CoRA Docs" icon color="primary" :href="help_url" target="_blank"><v-icon>mdi-help-circle-outline</v-icon></v-btn>
                <v-btn :title="!isCollapse ? 'Collapse' : 'Expand'" icon color="primary" @click="collapse">
                    <v-icon v-text="isCollapse ? 'mdi-arrow-collapse-down' : 'mdi-arrow-collapse-up'"></v-icon>
                </v-btn>
                <v-btn title="Close" icon color="primary" @click="close" :loading="loading"><v-icon>mdi-close</v-icon></v-btn>
            </v-toolbar>
        </v-card-title>
        <v-card-text v-if="!isCollapse" class="m-0 p-0">
            <v-data-table class="table-widget" :headers="headers[type]" height="300" fixed-header hide-default-footer dense
                          :items="items" :sort-by="['projectName', 'key']" :items-per-page="-1">
                <template v-slot:item.projectName="{ item }"><a :href="`/projectDashboard/${item.project_id}`" target="_blank">{{ item.projectName }}</a></template>
                <template v-slot:item.key="{ item }"><a :href="`/skeletalelements/${item.id}`" target="_blank">{{ item.key }}</a></template>
            </v-data-table>
        </v-card-text>
        <v-card-actions v-if="!isCollapse" class="m-0 p-0">
            <v-toolbar dense>
                <v-toolbar-title dense><v-icon title="Last updated at" icon color="primary" class="mr-2">mdi-calendar</v-icon>{{last_updated_at}}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn title="Details" icon color="primary" @click="fireGenerateDetails"><v-icon>mdi-clipboard-text</v-icon></v-btn>
            </v-toolbar>
        </v-card-actions>
    </v-card>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import axios from "axios";
    import {eventBus} from "../../../eventBus";

    export default {
        name: "table-widget",
        props: {
            index: { type: Number },
            type: { type: String, default: "specimen_summary" }, // valid values "specimen_summary", "dna_summary", "ua_specimens", "ua_dnas"
            help_url: { type: String, default: "https://cora-docs.readthedocs.io" },
            default_items: { type: Array, default: () => ([]) },
        },
        data () {
            return {
                loading: false,
                show_widget: true,
                isCollapse: false,
                items: this.default_items,
                response: null,
                last_updated_at: null,
                todayDate: new Date().toISOString().slice(0,19).replace("T", " "),
                headers: {
                    specimen_summary:[
                        {text: 'Project', value: 'projectName', width: '12rem', visibility: true},
                        {text: 'Specimens', value: 'se_total', width: '6rem', visibility: true},
                        {text: 'Complete', value: 'num_complete', width: '6rem', visibility: true},
                        {text: 'Measured', value: 'num_measured', width: '6rem', visibility: true},
                        {text: 'Isotope', value: 'num_isotope_sampled', width: '6rem', visibility: true},
                        {text: 'CT', value: 'num_ct_scanned', width: '6rem', visibility: true},
                        {text: 'X-Ray', value: 'num_xray_scanned', width: '6rem', visibility: true},
                        {text: 'Clavicle', value: 'num_clavicle', width: '6rem', visibility: true},
                        {text: 'Inventoried', value: 'num_inventoried', width: '6rem', visibility: true},
                        {text: 'Reviewed', value: 'num_reviewed', width: '6rem', visibility: true},
                        {text: 'SE with Ind', value: 'num_individuals', width: '6rem', visibility: true},
                        {text: 'Unique Ind', value: 'num_unique_individuals', width: '6rem', visibility: true},
                    ],
                    dna_summary: [
                        {text: 'Project', value: 'projectName', width: '12rem', visibility: true},
                        {text: 'Specimens', value: 'se_total', width: '6rem', visibility: true},
                        {text: 'Sampled', value: 'num_sampled', width: '6rem', visibility: true},
                        {text: 'Results Rec', value: 'num_results_received', width: '6rem', visibility: true},
                        {text: 'Reportable', value: 'num_results_reportable', width: '6rem', visibility: true},
                        {text: 'Mito Seq', value: 'num_mito_sequences', width: '6rem', visibility: true},
                    ],
                    ua_specimens:[
                        {text: 'Key', value: 'key', width: '12rem', visibility: true},
                        {text: 'Name', value: 'name', width: '6rem', visibility: true},
                        {text: 'Side', value: 'side', width: '6rem', visibility: true},
                        {text: 'Completeness', value: 'completeness', width: '6rem', visibility: true},
                        {text: 'Updated At', value: 'updated_at', width: '6rem', visibility: true},
                    ],
                    ua_dnas: [
                        {text: 'Key', value: 'key', width: '12rem', visibility: true},
                        {text: 'Mito Sequence Number', value: 'mito_sequence_number', width: '6rem', visibility: true},
                        {text: 'Mito Sequence Subgroup', value: 'mito_sequence_subgroup', width: '6rem', visibility: true},
                        {text: 'Updated At', value: 'updated_at', width: '6rem', visibility: true},
                    ],
                },
                urls: {
                    specimen_summary: "/api/dashboard/users/allprojectsummary?by=specimen",
                    dna_summary: "/api/dashboard/users/allprojectsummary?by=dna",
                    ua_specimens: "/api/dashboard/projects/activity?by=specimen&top=10&forUser=true",
                    ua_dnas: "/api/dashboard/projects/activity?by=dna&top=10&forUser=true",
                },
                titles: {
                    specimen_summary: "Specimen Summary",
                    dna_summary: "DNA Summary",
                    ua_specimens: "User Activity: Specimens",
                    ua_dnas: "User Activity: DNA",
                },
            }
        },
        created() {
            // Listen for the visible and expand events.
            eventBus.$on('dashboard-event', payload => {
                this.isCollapse = payload.expanded;
            });

            // If data is not passed by parent dashboard container, go fetch it
            if (!this.items || !this.items.length) {
                this.getTableWidgetData();
            } else {
                this.last_updated_at = (this.items[0].updated_at) ? this.items[0].updated_at : this.todayDate;
                if (this.type === "ua_specimens" || this.type === "us_dnas") {
                    this.last_updated_at = this.todayDate;
                }
            }
        },
        mounted() {
            //
        },
        methods:{
            getTableWidgetData: function () {
                this.loading = true;
                axios
                    .request({ url: this.urls[this.type], method: 'GET',
                        headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken },
                    })
                    .then(response => {
                        this.response = response.data.data;
                        this.setItem(response.data.data);
                        this.loading = false;
                    })
            },
            setItem(data) {
                // console.log("setItem data for type: " + this.type);
                // console.log("setItem data with data: " + JSON.stringify(data));
                this.items = [];
                if (this.type==='specimen_summary') {
                    this.items = data.specimens;
                    this.last_updated_at = (this.items.length) ? this.items[0].updated_at : this.todayDate;
                } else if(this.type==='dna_summary') {
                    this.items = data.dnas;
                    this.last_updated_at = (this.items.length) ? this.items[0].updated_at : this.todayDate;
                } if (this.type==="ua_specimens" || this.type==="ua_dnas") {
                    this.items = data;
                    this.last_updated_at = this.todayDate;
                    for (let i=0;i<data.length;++i) {
                        this.items[i]['key'] = data[i].accession_number+':'+data[i].provenance1+':'+data[i].provenance2+':'+data[i].designator;
                    }
                }
            },
            collapse() {
                // emit event for dashboard before setting isCollapse
                let payload = { 'index': this.index, 'visible': this.show_widget, 'expanded': this.isCollapse };
                eventBus.$emit('dashboard-widget-event', payload);
                this.isCollapse = !this.isCollapse;
            },
            close() {
                this.show_widget = !this.show_widget;
                // emit event for dashboard after setting show_widget
                let payload = { 'index': this.index, 'visible': this.show_widget, 'expanded': this.isCollapse };
                eventBus.$emit('dashboard-widget-event', payload);
            },
          fireGenerateDetails() {
            this.$emit('eventGenerate', this.type);
            console.log("generateDetails: " + this.type);
          },
        },
        computed:{
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
        },
    }
</script>

<style scoped>
</style>