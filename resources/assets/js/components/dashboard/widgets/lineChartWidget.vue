<template>
    <v-card class="m-2 p-0" v-if="show_widget">
        <v-card-title class="m-0 p-0">
            <v-toolbar dense>
                <v-toolbar-title>{{ titles[type]}}</v-toolbar-title>
                <v-spacer></v-spacer>
                <!--                    <v-btn title="Refresh" icon color="primary" @click=""><v-icon>mdi-refresh-circle</v-icon></v-btn>-->
                <v-autocomplete title="Line Step" v-model="step" :items="items_step" prepend-inner-icon="mdi-chart-bar"
                                menu-props="auto" hide-details width="64" single-line @change="changeLineStep()">
                </v-autocomplete>
                <v-autocomplete title="Days" v-model="days" :items="items_days" prepend-inner-icon="mdi-calendar"
                                menu-props="auto" hide-details width="64" single-line @change="changeDays()">
                </v-autocomplete>
                <v-autocomplete title="Point Style" v-model="point_style" :items="items_point_styles" prepend-inner-icon="mdi-shape"
                                menu-props="auto" hide-details width="64" single-line @change="changePointStyle()">
                </v-autocomplete>
<!--                <v-autocomplete title="Fill" v-model="fill" :items="items_fill" prepend-inner-icon="mdi-format-color-fill"-->
<!--                                menu-props="auto" hide-details width="64" single-line @change="changeFill()">-->
<!--                </v-autocomplete>-->
                <v-btn :title="!isCollapse ? 'Collapse' : 'Expand'" icon color="primary" @click="collapse">
                    <v-icon v-text="isCollapse ? 'mdi-arrow-collapse-down' : 'mdi-arrow-collapse-up'"></v-icon>
                </v-btn>
                <v-btn title="Close" icon color="primary" @click="close" :loading="loading"><v-icon>mdi-close</v-icon></v-btn>
            </v-toolbar>
        </v-card-title>
        <v-card-text v-if="!isCollapse" class="m-0 p-2">
            <line-chart v-if="loaded" :chartdata="chartdata" :options="options" style="max-height:200px;"></line-chart>
        </v-card-text>
        <v-card-actions v-if="!isCollapse" class="m-0 p-0">
            <v-toolbar dense>
                <v-toolbar-title dense><v-icon title="Last updated at" icon color="primary" class="mr-2">mdi-calendar</v-icon>{{last_updated_at}}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn title="Details" icon color="primary" @click=""><v-icon>mdi-clipboard-text</v-icon></v-btn>
                <v-btn title="Help - CoRA Docs" icon color="primary" :href="helpUrl" target="_blank"><v-icon>mdi-help-circle-outline</v-icon></v-btn>
            </v-toolbar>
        </v-card-actions>
    </v-card>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import axios from 'axios';
    import linechart from "./chartjs/linechart";
    import {eventBus} from "../../../eventBus";

    export default {
        name: "line-chart-widget",
        components: {
            'line-chart': linechart,
        },
        props: {
            // valid values "specimens", "dnas", "isotopes"
            type: { type: String, default: "specimens" },
            index: { type: Number },
            default_items: { type: Object|Array, default: () => ({}) },
            project_id: { type: Number, required: true },
        },
        data() {
            return {
                loading: false,
                loaded: false,
                show_widget: true,
                isCollapse: false,
                items: [],
                last_updated_at: new Date().toISOString().slice(0,19).replace("T", " "),
                backgroundColor: ['#F19A40', '#05909D', '#42C088','#f94050', '#F3F064',"#17B9CE", "#45C7D8", "#73D5E2", "#A2E3EB", "#D0F1F5"],
                options: { responsive: true, legend: { display: true }, maintainAspectRatio: false,
                    scales: {
                        yAxes: [{ ticks: { beginAtZero: true }, gridLines: { display: true }, }],
                        xAxes: [{ gridLines: { display: true }, }]
                    },
                    tooltips: { mode: 'index', intersect: false, },
                    hover: { mode: 'nearest', intersect: true },
                    elements: { point: { pointStyle: "circle" }, },
                },
                chartdata: { type: 'line', labels: [], datasets: [ { label: "Line 1", data: [1, 2], backgroundColor: [ "#0074D9", "#FF4136" ] }], },
                urls: {
                    specimens: "/api/dashboard/projects/specimens/complete",
                    dnas: "/api/dashboard/projects/specimens/complete",
                    isotopes: "/api/dashboard/projects/specimens/complete",
                },
                titles: {
                    specimens: "Specimens",
                    dnas: "DNAs",
                    isotopes: "Isotopes",
                },
                items_data_fields: {
                    complete: ["complete", "incomplete"],
                    individual_assigned: ['individual_assigned','individual_unassigned'],
                    dna_sampled: ['dna_sampled','not_dna_sampled'],
                },
                days: 30,
                items_days: [ { value: 30, text: "30 days", }, { value: 90, text: "90 days", }, { value: 180, text: "180 days", }, { value: 365, text: "1 year", },],
                step: false,
                items_step: [ { value: false, text: "No steps", }, { value: "before", text: "Before", }, { value: "after", text: "After", }, { value: "middle", text: "Middle", },],
                fill: false,
                items_fill: [ { value: false, text: "No Fill", }, { value: "origin", text: "Origin", }, { value: "start", text: "Start", }, { value: "end", text: "End", },],
                point_style: "circle",
                items_point_styles: [ { value: "circle", text: "Circle", }, { value: "triangle", text: "Triangle", }, { value: "rect", text: "Rectangle", }, { value: "rectRounded", text: "Rectangle Rounded", },
                    { value: "rectRot", text: "Rectangle Rotate", }, { value: "cross", text: "Cross", }, { value: "crossRot", text: "Cross Rotate", }, { value: "star", text: "Star", },
                ],
                show_filled: false,
            }
        },
        created() {
            // Listen for the visible and expand events.
            eventBus.$on('dashboard-event', payload => {
                // console.log("lineChartWidget received: dashboard-event: with payload: "+payload.expanded);
                this.isCollapse = payload.expanded;
            });

            // If data is not passed by parent dashboard container, go fetch it
            // If we stringify the object and the result is simply an
            // opening and closing bracket, we know the object is empty.
            if (JSON.stringify(this.items) === '{}') {
                this.getChartData();
            } else {
                console.log("calling set data correctly");
                this.setItems(this.default_items);
                this.loaded = true;
                console.log("fully loaded");
            }
        },
        mounted() {
            // this.getChartData();
        },
        methods: {
            getChartData: function () {
                this.loading = true;
                axios
                    .request({ url: '/api/dashboard/projects/'+this.project_id+'/summary?top='+this.days, method: 'GET',
                        headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken, },
                    })
                    .then(response => {
                        let records = response.data.data.records;
                        this.setItems(records);
                        this.loading = false;
                    })
            },
            setItems(data) {
                this.items = data;
                if (this.type === "specimens") {
                    this.buildSpecimens();
                } else if (this.type === "dnas") {
                    this.buildDna();
                }
            },
            buildSpecimens() {
                let labels = [];
                let dataset = { created: [], inventory_complete: [], reviewed: [], measured: [], unique_individuals: []}
                for(let i=0; i < this.items.length; i++) {
                    let record = this.items[i];
                    let specimen_stats = JSON.parse(record.specimen_stats);
                    labels[i] = record.created_at.slice(0, 10);
                    dataset.created[i] = specimen_stats.se_total;
                    dataset.inventory_complete[i] = specimen_stats.num_inventoried;
                    dataset.reviewed[i] = specimen_stats.num_reviewed;
                    dataset.measured[i] = specimen_stats.num_measured;
                    dataset.unique_individuals[i] = specimen_stats.num_unique_individuals;
                }
                this.chartdata.labels = labels;
                // fill: valid values are false, 'origin', 'start', 'end'
                // steppedLine: valid values are false, 'before', 'after', 'middle'
                this.chartdata.datasets = [
                    { data: dataset.created, label: "Created", borderColor: "#3e95cd", fill: this.fill,
                        steppedLine: this.step, pointRadius: 5, pointHoverRadius: 10, },
                    { data: dataset.inventory_complete, label: "Inventroy Complete", borderColor: "#8e5ea2", fill: this.fill,
                        steppedLine: this.step, pointRadius: 5, pointHoverRadius: 10, },
                    { data: dataset.reviewed, label: "Reviewed", borderColor: "#3cba9f", fill: this.fill,
                        steppedLine: this.step, pointRadius: 5, pointHoverRadius: 10, },
                    { data: dataset.measured, label: "Measured", borderColor: "#e8c3b9", fill: this.fill,
                        steppedLine: this.step, pointRadius: 5, pointHoverRadius: 10, },
                    { data: dataset.unique_individuals, label: "Unique Individuals", borderColor: "#c45850", fill: this.fill,
                        steppedLine: this.step, pointRadius: 5, pointHoverRadius: 10, },
                ];
                console.log("setData processing completed");
            },
            buildDna() {
                console.log
                let labels = [];
                let dataset = { specimens_sampled: [], total_dna_samples: [], mito_sequences: [], mito_method_sanger: [], mito_method_ngs: [], mito_request_date: [],
                    mito_received: [], mito_pending: [], mito_reportable: [], mito_inconclusive: [], mito_unable_to_assign: [], mito_cancelled: [], }
                for(let i=0; i < this.items.length; i++) {
                    let record = this.items[i];
                    let specimen_stats = JSON.parse(record.specimen_stats);
                    let dna_stats = JSON.parse(record.dna_stats);
                    labels[i] = record.created_at.slice(0, 10);
                    dataset.specimens_sampled[i] = specimen_stats.num_dna_sampled;
                    dataset.total_dna_samples[i] = dna_stats.num_dna_samples;
                    dataset.mito_sequences[i] = dna_stats.num_mito_sequences;
                    dataset.mito_method_sanger[i] = dna_stats.num_mito_method_sanger;
                    dataset.mito_method_ngs[i] = dna_stats.num_mito_method_ngs;
                    dataset.mito_request_date[i] = dna_stats.num_mito_request_date;
                    // dataset.mito_received[i] = dna_stats.num_mito_received;
                    // dataset.mito_pending[i] = dna_stats.num_mito_pending;
                    // dataset.mito_reportable[i] = dna_stats.num_mito_reportable;
                    // dataset.mito_inconclusive[i] = dna_stats.num_mito_inconclusive;
                    // dataset.mito_unable_to_assign[i] = dna_stats.num_mito_unable_to_assign;
                    // dataset.mito_cancelled[i] = dna_stats.num_mito_cancelled;
                }
                this.chartdata.labels = labels;
                // fill: valid values are false, 'origin', 'start', 'end'
                // steppedLine: valid values are false, 'before', 'after', 'middle'
                this.chartdata.datasets = [
                    { data: dataset.specimens_sampled, label: "Specimens Sampled", borderColor: "#3e95cd", fill: this.fill,
                        steppedLine: this.step, pointRadius: 5, pointHoverRadius: 10, },
                    { data: dataset.total_dna_samples, label: "DNA (Re)Samples", borderColor: "#8e5ea2", fill: this.fill,
                        steppedLine: this.step, pointRadius: 5, pointHoverRadius: 10, },
                    { data: dataset.mito_sequences, label: "Mito Sequences", borderColor: "#3cba9f", fill: this.fill,
                        steppedLine: this.step, pointRadius: 5, pointHoverRadius: 10, },
                    { data: dataset.mito_method_sanger, label: "Sanger", borderColor: "#e8c3b9", fill: this.fill,
                        steppedLine: this.step, pointRadius: 5, pointHoverRadius: 10, },
                    { data: dataset.mito_method_ngs, label: "NGS", borderColor: "#c45850", fill: this.fill,
                        steppedLine: this.step, pointRadius: 5, pointHoverRadius: 10, },
                    { data: dataset.mito_request_date, label: "Requests (with dates)", borderColor: "#45C7D8", fill: this.fill,
                        steppedLine: this.step, pointRadius: 5, pointHoverRadius: 10, },
                ];
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
            changeDays() {
                console.log("changeDays: "+ this.days);
                this.getChartData();
            },
            changeLineStep() {
                console.log("changeLineStep: "+ this.days);
                this.getChartData();
            },
            changeFill() {
                console.log("changeLineStep: "+ this.days);
                this.getChartData();
            },
            changePointStyle() {
                console.log("changePointStyle: "+ this.point_style);
                this.options.elements.point.pointStyle = this.point_style;
                // make a copy and assign otherwise watcher will not trigger.
                this.options = JSON.parse(JSON.stringify(this.options));
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
        },
    }
</script>
