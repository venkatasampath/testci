<template>
    <v-card :class="setClass" v-if="show_widget">
        <v-card-title class="m-0 p-0">
            <v-toolbar dense>
                <v-toolbar-title v-if="loaded">{{title}}</v-toolbar-title>
                <v-spacer></v-spacer>
                <!--                    <v-btn title="Refresh" icon color="primary" @click=""><v-icon>mdi-refresh-circle</v-icon></v-btn>-->
                <v-btn :title="show_pie_full?'Semi Circle':'Full Circle'" icon color="primary" @click="toggleCircleSize"><v-icon>{{ show_pie_full?'mdi-circle-half-full':'mdi-circle' }}</v-icon></v-btn>
                <v-btn :title="show_pie?'Show Donut':'Show Pie'" icon color="primary" @click="togglePieDoughnut"><v-icon>{{ show_pie?'mdi-chart-donut':'mdi-chart-pie' }}</v-icon></v-btn>
                <v-btn :title="!isCollapse ? 'Collapse' : 'Expand'" icon color="primary" @click="collapse">
                    <v-icon v-text="isCollapse ? 'mdi-arrow-collapse-down' : 'mdi-arrow-collapse-up'"></v-icon>
                </v-btn>
                <v-btn title="Close" icon color="primary" @click="close" :loading="loading"><v-icon>mdi-close</v-icon></v-btn>
            </v-toolbar>
        </v-card-title>
        <v-card-text v-if="!isCollapse" class="m-0 p-2">
            <pie-chart v-if="loaded" :chartdata="chartdata" :options="options" :style="setStyle"></pie-chart>
        </v-card-text>
        <v-card-actions v-if="!isCollapse" class="m-0 p-0">
            <v-toolbar dense>
                <v-toolbar-title dense>
                    <v-icon title="Last updated at" icon color="primary" class="mr-2">mdi-calendar</v-icon>{{last_updated_at}}
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn title="Details" icon color="primary" @click="fireGenerateDetails" v-if="showOptions"><v-icon>mdi-clipboard-text</v-icon></v-btn>
                <v-btn title="Help - CoRA Docs" icon color="primary" :href="helpUrl" target="_blank" v-if="showOptions"><v-icon>mdi-help-circle-outline</v-icon></v-btn>
            </v-toolbar>
        </v-card-actions>
    </v-card>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import axios from 'axios';
    import piechart from "./chartjs/piechart";
    import {eventBus} from "../../../eventBus";

    export default {
        name: "pie-chart-widget",
        components: {
            'pie-chart': piechart,
        },
        props: {
            // valid values "complete", "individual_assigned", "dna_sampled", "measured",
            // "ct_scanned", "xray_scanned", "clavicle_triage", "isotope_sampled".
            type: { type: String, default: "complete" },
            index: { type: Number },
            default_items: { type: Object|Array, default: () => ({}) },
            setClass: {type: String, default: "m-2 p-0"},
            setStyle: {type: String, default: "max-height:200px;" },
            showOptions:{type: Boolean, default:true}
        },
        data() {
            return {
                show_pie: true,
                show_pie_full: true,
                loading: false,
                loaded: false,
                show_widget: true,
                isCollapse: false,
                items: this.default_items,
                last_updated_at: new Date().toISOString().slice(0,19).replace("T", " "),
                backgroundColor: {
                    "for2": ['#05909D', '#F19A40', ],
                    "for3": ['#05909D', '#42C088', '#F19A40'],
                    "for4": ['#05909D', '#42C088', '#f94050','#F19A40'],
                    "for5": ['#05909D', '#42C088', '#f94050','#F3F064', '#F19A40', ],
                    "for6": ['#05909D', '#42C088', '#f94050','#F3F064', "#17B9CE", '#F19A40', ],
                    "original": ['#05909D', '#F19A40', '#42C088','#f94050', '#F3F064',"#17B9CE", "#45C7D8", "#73D5E2", "#A2E3EB", "#D0F1F5"],
                    "default": ['#00441b', '#006d2c', '#238b45','#41ab5d', '#74c476',"#a1d99b", "#c7e9c0", "#e5f5e0", "#f7fcf5", "#D0F1F5"],
                    "red": ['#67000d', '#a50f15', '#cb181d','#ef3b2c', '#fb6a4a',"#fc9272", "#fcbba1", "#fee0d2", "#fff5f0", "#D0F1F5"],    // Red single hue sequential
                    "blue": ['#08306b', '#08519c', '#2171b5','#4292c6', '#6baed6',"#9ecae1", "#c6dbef", "#deebf7", "#f7fbff", "#D0F1F5"],   // Blue single hue sequential
                    "green": ['#00441b', '#006d2c', '#238b45','#41ab5d', '#74c476',"#a1d99b", "#c7e9c0", "#e5f5e0", "#f7fcf5", "#D0F1F5"],  // Green single hue - sequential
                    "orange": ['#7f2704', '#a63603', '#d94801','#f16913', '#fd8d3c',"#fdae6b", "#fdd0a2", "#fee6ce", "#fff5eb", "#D0F1F5"], // Orange single hue sequential
                    "purple": ['#3f007d', '#54278f', '#6a51a3','#807dba', '#9e9ac8',"#bcbddc", "#dadaeb", "#efedf5", "#fcfbfd", "#D0F1F5"], // Purple single hue sequential
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutoutPercentage: 0,
                    legend: { display: true, position: 'top' },
                    title: { display: false, text: 'Chart.js Doughnut Chart' },
                    animation: { animateScale: true, animateRotate: true },
                },
                chartdata: {
                    type: 'pie',
                    labels: ['Seq 14', 'Seq 1', 'Seq 6'],
                    datasets: [ { label: "Views by Category", data: [1, 2, 3], backgroundColor: [ "#0074D9", "#FF4136", "#2ECC40", ] }],
                },
                urls: {
                    complete: "/api/dashboard/projects/specimens/complete",
                    individual_assigned: "/api/dashboard/projects/specimens/individual",
                    dna_sampled: "/api/dashboard/projects/specimens/dna-sampled",
                    measured: "/api/dashboard/projects/specimens/measured",
                    ct_scanned: "/api/dashboard/projects/specimens/ct-scanned",
                    xray_scanned: "/api/dashboard/projects/specimens/xray-scanned",
                    clavicle_triage: "/api/dashboard/projects/specimens/clavicle-triage",
                    isotope_sampled: "/api/dashboard/projects/specimens/isotope-sampled",
                    dna_mito_results: "/api/dashboard/projects/dnas/mito-results",
                    dna_ystr_results: "/api/dashboard/projects/dnas/ystr-results",
                    dna_austr_results: "/api/dashboard/projects/dnas/austr-results",
                },
                titles: {
                    complete: "Complete",
                    individual_assigned: "Individual # Assigned",
                    dna_sampled: "DNA Sampled",
                    measured: "Measured",
                    ct_scanned: "CT Scanned",
                    xray_scanned: "Xray Scanned",
                    clavicle_triage: "Clavicle Triage",
                    isotope_sampled: "Isotope Sampled",
                    dna_mito_results: "DNA Mito Results",
                    dna_ystr_results: "DNA YStr Results",
                    dna_austr_results: "DNA Austr Results",
                },
                chart_labels: {
                    complete: ["Complete", "Incomplete"],
                    individual_assigned: ['Associated','Unassociated'],
                    dna_sampled: ['Sampled','Not Sampled'],
                    measured: ['Measured','Not Measured'],
                    ct_scanned: ['Scanned','Not Scanned'],
                    xray_scanned: ['Xray-Scanned','Not Xray-Scanned'],
                    clavicle_triage: ['Triaged','Not Triaged'],
                    isotope_sampled: ['Sampled','Not Sampled'],
                    dna_mito_results: ['Reportable','Inconclusive','Unable to assign','Cancelled','No Results','Pending',],
                    dna_ystr_results: ['Reportable','Inconclusive','Unable to assign','Cancelled','No Results','Pending',],
                    dna_austr_results: ['Reportable','Inconclusive','Unable to assign','Cancelled','No Results','Pending',],
                },
                items_data_fields: {
                    complete: ["complete", "incomplete"],
                    individual_assigned: ['individual_assigned','individual_unassigned'],
                    dna_sampled: ['dna_sampled','not_dna_sampled'],
                    measured: ['measured','not_measured'],
                    ct_scanned: ['ct_scanned','not_ct_scanned'],
                    xray_scanned: ['xray_scanned','not_xray_scanned'],
                    clavicle_triage: ['clavicle_triage','not_clavicle_triage'],
                    isotope_sampled: ['isotope_sampled','not_isotope_sampled'],
                    dna_mito_results: [],
                    dna_ystr_results: [],
                    dna_austr_results: [],
                },
            }
        },
        created() {
            // Listen for the visible and expand events.
            eventBus.$on('dashboard-event', payload => {
                // console.log("pieChartWidget received: dashboard-event: with payload: "+payload.expanded);
                this.isCollapse = payload.expanded;
            });

            // If data is not passed by parent dashboard container, go fetch it
            // If we stringify the object and the result is simply an
            // opening and closing bracket, we know the object is empty.
            if (JSON.stringify(this.items) === '{}') {
                this.getChartData();
            } else {
                // this.setItems(this.default_items);
                this.setItemsNew(this.default_items);
                this.loaded = true;
            }
        },
        mounted() {
            // this.getChartData();
        },
        methods: {
            getChartData: function () {
                this.loading = true;
                axios
                    .request({ url: this.urls[this.type], method: 'GET',
                        headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken, }
                    })
                    .then(response => {
                        // Note that the items[type] matched what is returned from the API
                        this.setItems(response.data.data);
                        this.last_updated_at = response.data.last_updated_at;
                        this.last_updated_at = this.last_updated_at.slice(0,19).replace("T", " ");
                        this.loading = false;
                        this.loaded = true
                    })
            },
            setItems(data) {
                this.items = data;
                let items_data =  JSON.parse(JSON.stringify(this.items));
                let getType = this.type.substr(4).concat("_total");
                delete items_data.total;
                delete items_data[getType];


                this.chartdata.labels = this.chart_labels[this.type];
                this.chartdata.datasets = [{
                    label: this.titles[this.type],
                    data: Object.values(items_data),
                    backgroundColor: this.getBackgroundColor(),
                }];
                this.updatePieToolTips();
                this.updatePieOptions();
            },
            setItemsNew(data) {
                this.items = data;

                // let items_data = this.returnNewObjectOnlyValidKeys(this.items, this.items_data_fields[this.type]);
                // delete this.items.total; // If data comes from API call, it will comtain tolal which needs to be removed.

                let items_data = this.getPieDataFromStats();
                this.chartdata.labels = this.chart_labels[this.type];
                this.chartdata.datasets = [{
                    label: this.titles[this.type],
                    data: Object.values(items_data),
                    backgroundColor: this.getBackgroundColor(),
                }];
                this.updatePieToolTips();
                this.updatePieOptions();
            },
            getPieDataFromStats() {
                let data = [];

                console.log("items: " + JSON.stringify(this.items));
                if (this.type === "complete") {
                    data["complete"] = this.items["complete"] = this.items.specimen.num_complete;
                    data["incomplete"] = this.items.specimen.se_total - this.items.specimen.num_complete;
                } else if (this.type === "individual_assigned") {
                    data["individual_assigned"] = this.items["individual_assigned"] = this.items.specimen.num_individuals;
                    data["individual_unassigned"] = this.items.specimen.se_total - this.items.specimen.num_individuals;
                } else if (this.type === "dna_sampled") {
                    data["dna_sampled"] = this.items["dna_sampled"] = this.items.specimen.num_dna_sampled;
                    data["not_dna_sampled"] = this.items.specimen.se_total - this.items.specimen.num_dna_sampled;
                } else if (this.type === "measured") {
                    data["measured"] = this.items["measured"] = this.items.specimen.num_measured;
                    data["not_measured"] = this.items.specimen.se_total - this.items.specimen.num_measured;
                } else if (this.type === "ct_scanned") {
                    data["ct_scanned"] = this.items["ct_scanned"] = this.items.specimen.num_ct_scanned;
                    data["not_ct_scanned"] = this.items.specimen.se_total - this.items.specimen.num_ct_scanned;
                } else if (this.type === "xray_scanned") {
                    data["xray_scanned"] = this.items["xray_scanned"] = this.items.specimen.num_xray_scanned;
                    data["not_xray_scanned"] = this.items.specimen.se_total - this.items.specimen.num_xray_scanned;
                } else if (this.type === "clavicle_triage") {
                    data["clavicle_triage"] = this.items["clavicle_triage"] = this.items.specimen.num_clavicle_triage;
                    data["not_clavicle_triage"] = this.items.specimen.num_clavicle - this.items.specimen.num_clavicle_triage;
                } else if (this.type === "isotope_sampled") {
                    data["isotope_sampled"] = this.items["isotope_sampled"] = this.items.specimen.num_isotope_sampled;
                    data["not_isotope_sampled"] = this.items.specimen.se_total - this.items.specimen.num_isotope_sampled;
                } else if (this.type === "dna_mito_results") {
                    let total = 0;
                    total += data["mito_reportable"] = this.items.dna.num_mito_reportable;
                    total += data["mito_inconclusive"] = this.items.dna.num_mito_inconclusive;
                    total += data["mito_unable_to_assign"] = this.items.dna.num_mito_unable_to_assign;
                    total += data["mito_cancelled"] = this.items.dna.num_mito_cancelled;
                    total += data["mito_no_results"] = this.items.dna.num_mito_no_results;
                    total += data["mito_pending"] = this.items.dna.num_mito_pending;
                    this.items["dna_mito_results"] = total;
                } else if (this.type === "dna_ystr_results") {
                    let total = 0;
                    total += data["ystr_reportable"] = this.items.dna.num_ystr_reportable;
                    total += data["ystr_inconclusive"] = this.items.dna.num_ystr_inconclusive;
                    total += data["ystr_unable_to_assign"] = this.items.dna.num_ystr_unable_to_assign;
                    total += data["ystr_cancelled"] = this.items.dna.num_ystr_cancelled;
                    total += data["ystr_no_results"] = this.items.dna.num_ystr_no_results;
                    total += data["ystr_pending"] = this.items.dna.num_ystr_pending;
                    this.items["dna_ystr_results"] = total;
                } else if (this.type === "dna_austr_results") {
                    let total = 0;
                    total += data["austr_reportable"] = this.items.dna.num_austr_reportable;
                    total += data["austr_inconclusive"] = this.items.dna.num_austr_inconclusive;
                    total += data["austr_unable_to_assign"] = this.items.dna.num_austr_unable_to_assign;
                    total += data["austr_cancelled"] = this.items.dna.num_austr_cancelled;
                    total += data["austr_no_results"] = this.items.dna.num_austr_no_results;
                    total += data["austr_pending"] = this.items.dna.num_austr_pending;
                    this.items["dna_austr_results"] = total;
                }

                return data;
            },
            getBackgroundColor() {
                if (this.chart_labels[this.type].length === 2) {
                    return this.backgroundColor.for2;
                } else if (this.chart_labels[this.type].length === 3) {
                    return this.backgroundColor.for3;
                } else if (this.chart_labels[this.type].length === 4) {
                    return this.backgroundColor.for4;
                } else if (this.chart_labels[this.type].length === 5) {
                    return this.backgroundColor.for5;
                } else if (this.chart_labels[this.type].length === 6) {
                    return this.backgroundColor.for6;
                }
            },
            updatePieOptions() {
                if (this.type === "dna_mito_results" || this.type === "dna_ystr_results" || this.type === "dna_austr_results") {
                    this.options.legend.position = 'left';
                }
            },
            updatePieToolTips() {
                // We are implementing the tooltips callback to append the percentage of the pie slices
                this.options.tooltips = {
                    callbacks: {
                        label: function label(tooltipItem, data) {
                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            var total = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
                                return previousValue + currentValue;
                            });
                            var currentValue = dataset.data[tooltipItem.index];
                            var precentage = Math.floor(currentValue / total * 100 + 0.5);
                            var label = data.labels[tooltipItem.index];
                            return label + ": " + currentValue + ", (" + precentage + "%)";
                        }
                    }
                }
            },
            returnNewObjectOnlyValidKeys(obj, validKeys) {
                const newObject = {};
                Object.keys(obj).forEach(key => {
                    if (validKeys.includes(key)) newObject[key] = obj[key];
                });
                return newObject;
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
            toggleCircleSize() {
                console.log("changeCircleSize: "+ this.show_pie_full);
                this.show_pie_full = !this.show_pie_full;
                if (this.options.circumference === Math.PI) {
                    this.options.circumference = 2 * Math.PI;
                    this.options.rotation = -Math.PI / 2;
                } else {
                    this.options.circumference = Math.PI;
                    this.options.rotation = -Math.PI;
                }
                // make a copy and assign otherwise watcher will not trigger.
                this.options = JSON.parse(JSON.stringify(this.options));
            },
            togglePieDoughnut() {
                console.log("togglePieDoughnut: "+ this.show_pie);
                this.show_pie = !this.show_pie;
                if (this.options.cutoutPercentage) {
                    this.options.cutoutPercentage = 0;
                } else {
                    this.options.cutoutPercentage = 50;
                }
                // make a copy and assign otherwise watcher will not trigger.
                this.options = JSON.parse(JSON.stringify(this.options));
            },
            fireGenerateDetails() {
                this.$emit('eventGenerate', this.type);
                console.log("generateDetails: " + this.type);
            },
        },
        computed: {
            ...mapState({
                perPage: state => state.search.perPage,
                rowsPerPageItems: state => state.search.rowsPerPageItems,
            }),
            ...mapGetters({
                bearerToken: 'bearerToken',
                csrfToken: 'csrfToken',
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
                helpUrl: 'getHelpUrl',
            }),
            title() {
                if (this.type === "dna_sampled" || this.type === "dna_mito_results"
                    || this.type === "dna_ystr_results" || this.type === "dna_austr_results") {
                    if(this.items.dna === undefined){
                        let results_total = this.type === 'dna_sampled'? this.type: this.type.substr(4).concat("_total");
                        return this.titles[this.type] + ": " + this.items[results_total] + " / " + this.items.total;
                    }
                    return this.titles[this.type] + ": " + this.items[this.type] + " / " + this.items.dna.num_dna_samples;
                }
                return this.titles[this.type] + ": " + this.items[this.type];
            }
        },
    }
</script>
