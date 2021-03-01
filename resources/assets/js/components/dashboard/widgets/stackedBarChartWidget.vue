<template>
    <v-card :class="setClass" v-if="show_widget">
        <v-card-title class="m-0 p-0">
            <v-toolbar dense>
                <v-toolbar-title>{{ titles[type] }}</v-toolbar-title>
                <v-spacer></v-spacer>
                <!--                    <v-btn title="Refresh" icon color="primary" @click=""><v-icon>mdi-refresh-circle</v-icon></v-btn>-->
                <v-btn :title="!isCollapse ? 'Collapse' : 'Expand'" icon color="primary" @click="collapse">
                    <v-icon v-text="isCollapse ? 'mdi-arrow-collapse-down' : 'mdi-arrow-collapse-up'"></v-icon>
                </v-btn>
                <v-btn title="Close" icon color="primary" @click="close" :loading="loading"><v-icon>mdi-close</v-icon></v-btn>
            </v-toolbar>
        </v-card-title>
        <v-card-text v-if="!isCollapse" class="m-0 p-2">
            <bar-chart v-if="fullyloaded" :chartdata="chartdata" :options="options" :style="setStyle"></bar-chart>
        </v-card-text>
        <v-card-actions v-if="!isCollapse" class="m-0 p-0">
            <v-toolbar dense>
                <v-toolbar-title dense><v-icon title="Last updated at" icon color="primary" class="mr-2">mdi-calendar</v-icon>{{last_updated_at}}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn title="Details" icon color="primary" @click="fireGenerateDetails" v-if="showOptions"><v-icon>mdi-clipboard-text</v-icon></v-btn>
                <v-btn title="Help - CoRA Docs" icon color="primary" :href="helpUrl" target="_blank" v-if="showOptions"><v-icon>mdi-help-circle-outline</v-icon></v-btn>
            </v-toolbar>
        </v-card-actions>
    </v-card>
</template>

<script>
    import axios from 'axios';
    import {mapGetters, mapState} from "vuex";
    import barchart from "./chartjs/barchart";
    import DashboardTable from "./../DashboardTable";
    import {eventBus} from "../../../eventBus";

    export default {
        name: "stacked-bar-chart-widget",
        components: {
            'bar-chart': barchart,
            'dashboardtable':DashboardTable,
        },
        props: {
            // valid values "mni_mito_bones_side", "mni_bones_side", "mni_zones_side"
            type: { type: String, default: "mni_mito_bones_side" },
            index: { type: Number },
            default_items: { type: Object|Array, default: () => ({}) },
            sorted_list: { type: Object|Array, default: () => ({}) },
            setClass: {type: String, default: "m-2 p-0"},
            setStyle: {type: String, default: "max-height:200px;" },
            showOptions:{type: Boolean, default:true},
            top: {type: Number, default: 5},

        },
        data() {
            return {
                loading: false,
                loaded: false,
                fullyloaded: false,
                show_widget: true,
                isCollapse: false,
                items: this.default_items,
                sorted_items: this.sorted_list,
                response: null,
                last_updated_at: new Date().toISOString().slice(0,19).replace("T", " "),
                backgroundColor: {
                    "default": ['#00441b', '#006d2c', '#238b45','#41ab5d', '#74c476',"#a1d99b", "#c7e9c0", "#e5f5e0", "#f7fcf5", "#D0F1F5"],
                    "red": ['#67000d', '#a50f15', '#cb181d','#ef3b2c', '#fb6a4a',"#fc9272", "#fcbba1", "#fee0d2", "#fff5f0", "#D0F1F5"],    // Red single hue sequential
                    "blue": ['#08306b', '#08519c', '#2171b5','#4292c6', '#6baed6',"#9ecae1", "#c6dbef", "#deebf7", "#f7fbff", "#D0F1F5"],   // Blue single hue sequential
                    "green": ['#00441b', '#006d2c', '#238b45','#41ab5d', '#74c476',"#a1d99b", "#c7e9c0", "#e5f5e0", "#f7fcf5", "#D0F1F5"],  // Green single hue - sequential
                    "orange": ['#7f2704', '#a63603', '#d94801','#f16913', '#fd8d3c',"#fdae6b", "#fdd0a2", "#fee6ce", "#fff5eb", "#D0F1F5"], // Orange single hue sequential
                    "purple": ['#3f007d', '#54278f', '#6a51a3','#807dba', '#9e9ac8',"#bcbddc", "#dadaeb", "#efedf5", "#fcfbfd", "#D0F1F5"], // Purple single hue sequential
                },

                stackList: [],
                stackDataset: [],
                filterloaded:false,
                chartdata: {
                    type: "bar",
                    labels: ['seq 14', 'seq 1', 'seq 6', 'seq 9', 'seq 25'],
                    datasets: [
                        { label: 'Data 1', backgroundColor: '#f87979', barThickness: 10, data: [40, 20, 10] },
                        { label: 'Data 2', backgroundColor: '#3D5B96', barThickness: 10, data: [10, 20, 10] },
                        { label: 'Data 3', backgroundColor: '#f87979', barThickness: 10, data: [40, 20] },
                        { label: 'Data 4', backgroundColor: '#3D5B96', barThickness: 10, data: [10, 20] },
                        { label: 'Data 5', backgroundColor: '#f87979', barThickness: 10, data: [40, 20] },
                    ]
                },
                options: {
                    stacked: true,
                    responsive: true,
                    legend: { display: false,  },
                    maintainAspectRatio: false,
                    scales: { xAxes: [{ stacked: true, display: true, }], yAxes: [{ stacked: true }] },
                },
                urls: {
                    mni_mito_bones_side: "/api/dashboard/projects/mni?by=mito_bones_and_side",
                    mni_bones_side: "/api/dashboard/projects/mni?by=bones_and_side",
                    mni_zones_side: "/api/dashboard/projects/mni?by=bones_side_zones",
                },
                filter_urls: {
                    mni_mito_bones_side: "/api/dashboard/projects/dnas/mito?top=" + this.top,
                    mni_bones_side: "/api/dashboard/projects/mni?by=bones&top=" + this.top,
                    mni_zones_side: "/api/dashboard/projects/mni?by=zones&top=" + this.top,
                },
                titles: {
                    mni_mito_bones_side: "MNI Mito Bones & Side",
                    mni_bones_side: "MNI Bones & Side",
                    mni_zones_side: "Frequency Zones & Side",
                },
            }
        },
        created() {
            // Listen for the visible and expand events.
            eventBus.$on('dashboard-event', payload => {
                this.isCollapse = payload.expanded;
            });

            // If data is not passed by parent dashboard container, go fetch it
            // If we stringify the object and the result is simply an
            // opening and closing bracket, we know the object is empty.
            if (JSON.stringify(this.items) === '{}') {
                this.getChartData();
                this.getFilterData();
            } else {
                this.getFilterData();
                this.setItems();
                this.fullyloaded = true;
            }
        },
        mounted() {
            // this.getChartData();
        },
        methods: {
            getChartData: function () {
                this.loading = true
                axios
                    .request({ url: this.urls[this.type], method: 'GET',
                        headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken, },
                    })
                    .then(response => {
                        // Note that the items[type] matched what is returned from the API
                        this.items = response.data.data;
                        this.setItems();
                        this.last_updated_at = response.data.project.updated_at;
                        this.loading = false;
                        this.loaded = true
                    })
            },
            getFilterData: function () {
                this.loading = true
                axios
                    .request({ url: this.filter_urls[this.type], method: 'GET',
                        headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken, },
                    })
                    .then(response => {
                        // Note that the items[type] matched what is returned from the API
                        this.sorted_items = response.data.data;
                        this.setItems();
                        this.loading = false;
                        this.filterloaded = true;
                    })
            },
            setItems(data) {
                // Are both the required items and sorted_items list available?
                if (!this.loaded  && !this.filterloaded) {
                    console.log("Not Processing setItems");
                    return;
                }
                console.log("Processing setItems");

                // Get the data labels setup for the x-axis.
                // let items_data = [];
                // let distinct = [], labels = [];
                // if (this.titles[this.type] === "MNI Mito Bones & Side") {
                //     distinct = [...new Set(this.items.map(x => x.mito_sequence_number))];
                //     labels = distinct.map(x => "Seq-"+ x);
                // } else if(this.titles[this.type] === "MNI Bones & Side") {
                //     distinct = [...new Set(this.items.map(x => x.name))];
                //     labels = distinct.map(x => x);
                // } else if(this.titles[this.type] === "MNI Zones & Side") {
                //     distinct = [...new Set(this.items.map(x => x.zone_display_name))];
                //     labels = distinct.map(x => x);
                // }

                this.chartdata.labels = this.buildLabels();

                this.stackList = this.buildStackList();
                console.log("stackList: " + JSON.stringify(this.stackList));
                this.stackDataset = this.buildStackDataset(this.stackList);
                this.chartdata.datasets = this.stackDataset;
                if ( this.type === "mni_zones_side" ) {
                    this.options.scales.xAxes.display = false;
                }

                // Finally, we are ready to display
                console.log("Processing fullyloaded = true");
                this.fullyloaded = true;

                // // this.chartdata.labels = distinct;
                // console.log("Distinct: " + JSON.stringify(distinct));
                // console.log("Labels: " + JSON.stringify(labels));
                // labels = labels.splice(0, 10);
                // console.log("Labels: " + JSON.stringify(labels));
                // this.chartdata.labels = labels;
                //
                // for (let i=0; i < distinct.length; i++) {
                //     if (i >= 10) { break; } // Only ten
                //
                //     // Compute the labels for each stack
                //     let stack_labels = [], stack = [];
                //     let label;
                //     if (this.titles[this.type] === "MNI Mito Bones & Side") {
                //         stack = data.filter(el => { return el.mito_sequence_number === distinct[i]});
                //         stack_labels = [...new Set(stack.map(x => x.name + " - " + x.side))];
                //         labels = "Seq - " + distinct[i];
                //     } else if (this.titles[this.type] === "MNI Bones & Side") {
                //         stack = data.filter(el => { return el.name === distinct[i]});
                //         stack_labels = [...new Set(stack.map(x => x.side))];
                //         labels = distinct[i];
                //     } else if (this.titles[this.type] === "MNI Zones & Side") {
                //         stack = data.filter(el => { return el.zone_display_name === distinct[i]});
                //         stack_labels = [...new Set(stack.map(x => x.zone_display_name + " - " + x.side))];
                //         labels = distinct[i];
                //     }
                //
                //     console.log("stack: size: " + stack.length + " Data: " + JSON.stringify(stack));
                //     console.log("labels: " + stack_labels.length + " Data: "  + JSON.stringify(stack_labels));
                //
                //     let stack_data = [];
                //     for (let j=0; j < stack.length; j++) {
                //         stack_data[j] = {
                //             label: stack_labels[j],
                //             data: stack[j].total,
                //             backgroundColor: (j < this.backgroundColorBlue.length) ? this.backgroundColorBlue[j] : this.backgroundColorBlue[9],
                //         };
                //     }
                //     this.chartdata.datasets[i] = {
                //         // distinct: distinct[i],
                //         // stack: stack,
                //         data: stack_data,
                //         // label: label,
                //         // barThickness: 25,
                //     };
                // }
            },
            buildLabels() {
                var labels = [];
                for (let i=0; i<this.sorted_items.length; i++) {
                    if ( this.type === "mni_mito_bones_side" ) {
                        labels.push("Seq " + this.sorted_items[i].mito_sequence_number);
                    } else if ( this.type === "mni_bones_side" ) {
                        labels.push(this.sorted_items[i].name);
                    } else if ( this.type === "mni_zones_side" ) {
                        labels.push(this.sorted_items[i].display_name);
                    }
                }
                console.log("buildLabels labels: " + JSON.stringify(labels));
                return labels;
            },
            buildStackList () {
                console.log("Processing buildStackList");
                var detailedArray = [];
                for (var x = 0; x < this.sorted_items.length; ++x)
                {
                    var Set = [];
                    var SetIndex = 0;
                    for (var i = 0; i < this.items.length; ++i) {
                        if ( this.type === "mni_mito_bones_side" ) {
                            if (this.items[i].mito_sequence_number === this.sorted_items[x].mito_sequence_number) {
                                Set[SetIndex++] = this.items[i];
                            }
                        } else if ( this.type === "mni_zones_side" ) {
                            if (this.items[i].zone_display_name === this.sorted_items[x].display_name) {
                                if (this.items[i].name === this.sorted_items[x].name) {
                                    Set[SetIndex++] = this.items[i];
                                }
                            }
                        } else {
                            if (this.items[i].name === this.sorted_items[x].name) {
                                Set[SetIndex++] = this.items[i];
                            }
                        }
                    }
                    detailedArray[x] = Set;
                }
                return detailedArray;
            },
            buildStackDataset (stackList) {
                console.log("Processing buildStackDataset");
                var colorArray = this.getBackgroundColorPallete();
                var initialArray = stackList;
                var returnArray = [];
                var returnArrayCounter = 0;
                for (var x = 0; x < initialArray.length; ++x) {
                    var currentElement = initialArray[x];
                    for (var i = 0; i < currentElement.length; ++i) {
                        var innerElement = currentElement[i];
                        var backgroundColor = (i<10)?colorArray[i]:colorArray[9];

                        var newArray = Array.from(Array(initialArray.length), () => 0);
                        newArray[x] = innerElement.total;
                        var computed_label;
                        if ( this.type === "mni_mito_bones_side" || this.type === "mni_zones_side" ) {
                            computed_label = innerElement.name + '-' + innerElement.side;
                        } else {
                            computed_label = innerElement.side;
                        }

                        returnArray[returnArrayCounter++] = {
                            data: newArray,
                            label: computed_label,
                            backgroundColor: backgroundColor,
                        };
                    }
                }
                return returnArray;
            },
            getBackgroundColorPallete() {
                if ( this.type === "mni_mito_bones_side" ) {
                    return this.backgroundColor.blue;
                } else if ( this.type === "mni_bones_side" ) {
                    return this.backgroundColor.green;
                } else if ( this.type === "mni_zones_side" ) {
                    return this.backgroundColor.orange;
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
                helpUrl: 'getHelpUrl',
            }),
        },
    }
</script>
