<template>
    <v-card :class="setClass" v-if="show_widget">
        <v-card-title class="m-0 p-0">
            <v-toolbar dense>
                <v-toolbar-title>{{ titles[type] }}</v-toolbar-title>
                <v-spacer></v-spacer>
                <!--                    <v-btn title="Refresh" icon color="primary" @click=""><v-icon>mdi-refresh-circle</v-icon></v-btn>-->
<!--                <v-btn :title="show_bar?'Show Horizontal':'Show Vertical'" icon color="primary" @click="toggleBar"><v-icon>{{ show_bar?'mdi-chart-bar':'mdi-chart-gantt' }}</v-icon></v-btn>-->
                <v-btn :title="!isCollapse ? 'Collapse' : 'Expand'" icon color="primary" @click="collapse">
                    <v-icon v-text="isCollapse ? 'mdi-arrow-collapse-down' : 'mdi-arrow-collapse-up'"></v-icon>
                </v-btn>
                <v-btn title="Close" icon color="primary" @click="close" :loading="loading"><v-icon>mdi-close</v-icon></v-btn>
            </v-toolbar>
        </v-card-title>
        <v-card-text v-if="!isCollapse" class="m-0 p-2">
            <bar-chart v-if="loaded" :chartdata="chartdata" :options="options" :style="setStyle"></bar-chart>
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
    import {mapGetters, mapState} from "vuex";
    import axios from 'axios';
    import barchart from "./chartjs/barchart";
    import DashboardTable from "./../DashboardTable";
    import {eventBus} from "../../../eventBus";

    export default {
        name: "bar-chart-widget",
        components: {
            'bar-chart': barchart,
            'dashboardtable':DashboardTable,
        },
        props: {
            // valid values "mito_sequence_number", "mni_bones", "mni_zones"
            type: { type: String, default: "mito_sequence_number" },
            index: { type: Number },
            top: {type: Number, default: 10},
            default_items: { type: Object|Array, default: () => ({}) },
            setClass: {type: String, default: "m-2 p-0"},
            setStyle: {type: String, default: "max-height:200px;" },
            showOptions:{type: Boolean, default:true}
        },
        data() {
            return {
                loading: false,
                loaded: false,
                show_widget: true,
                show_bar: true,
                isCollapse: false,
                items: this.default_items,
                last_updated_at: new Date().toISOString().slice(0,19).replace("T", " "),
                backgroundColor: {
                    "default": ['#00441b', '#006d2c', '#238b45','#41ab5d', '#74c476',"#a1d99b", "#c7e9c0", "#e5f5e0", "#f7fcf5", "#D0F1F5"],
                    "red": ['#67000d', '#a50f15', '#cb181d','#ef3b2c', '#fb6a4a',"#fc9272", "#fcbba1", "#fee0d2", "#fff5f0", "#D0F1F5"],    // Red single hue sequential
                    "blue": ['#08306b', '#08519c', '#2171b5','#4292c6', '#6baed6',"#9ecae1", "#c6dbef", "#deebf7", "#f7fbff", "#D0F1F5",
                            '#c5cbe9', '#9fa8da', '#7985cb', '#5c6bc0', '#3f51b5', '#394aae', '#3140a5', '#29379d', '#1b278d', '#c6cbff', '#939dff',
                            '#606eff', '#4757ff', '#08519c', '#2171b5','#4292c6', '#6baed6',"#9ecae1", "#c6dbef", "#deebf7", "#f7fbff", "#D0F1F5",
                            '#c5cbe9', '#9fa8da', '#7985cb', '#5c6bc0', '#3f51b5', '#394aae', '#3140a5', '#29379d', '#1b278d', '#c6cbff', '#939dff'],   // Blue single hue sequential
                    "green": ['#00441b', '#006d2c', '#238b45','#41ab5d', '#74c476',"#a1d99b", "#c7e9c0", "#e5f5e0", "#f7fcf5", "#D0F1F5",
                            "#D0F1F5","#f7fcf5","#e5f5e0","#c7e9c0",'#00441b', "#a1d99b",'#006d2c', '#74c476','#41ab5d',  '#238b45',
                            '#00441b', '#006d2c', '#238b45','#41ab5d', '#74c476',"#a1d99b", "#c7e9c0", "#e5f5e0", "#f7fcf5", "#D0F1F5",
                            "#D0F1F5","#f7fcf5","#e5f5e0","#c7e9c0",'#00441b', "#a1d99b",'#006d2c', '#74c476','#41ab5d',  '#238b45',],  // Green single hue - sequential
                    "orange": ['#7f2704', '#a63603', '#d94801','#f16913', '#fd8d3c',"#fdae6b", "#fdd0a2", "#fee6ce", "#fff5eb", "#D0F1F5",
                            "#D0F1F5","#fff5eb","#fee6ce","#fdd0a2", "#fdae6b",'#fd8d3c', '#f16913','#d94801','#a63603','#7f2704',
                            '#7f2704', '#a63603', '#d94801','#f16913', '#fd8d3c',"#fdae6b", "#fdd0a2", "#fee6ce", "#fff5eb", "#D0F1F5",
                            "#D0F1F5","#fff5eb","#fee6ce","#fdd0a2", "#fdae6b",'#fd8d3c', '#f16913','#d94801','#a63603','#7f2704',
                            '#7f2704', '#a63603', '#d94801','#f16913', '#fd8d3c',"#fdae6b", "#fdd0a2", "#fee6ce", "#fff5eb", "#D0F1F5",
                            ], // Orange single hue sequential
                    "purple": ['#3f007d', '#54278f', '#6a51a3','#807dba', '#9e9ac8',"#bcbddc", "#dadaeb", "#efedf5", "#fcfbfd", "#D0F1F5"], // Purple single hue sequential
                },

                chartdata: {
                    type: 'bar',
                    labels: ['Seq 14','Seq 1','Seq 6','Seq 9','Seq 25' ],
                    datasets: [ { label: 'Mito', backgroundColor: ['#F19A40', '#fd8d3c', '#74a9cf', ], data: [8,7,7,7,6] } ],
                },
                options: {
                    stacked: true,
                    responsive: true,
                    legend: { display: false },
                    maintainAspectRatio: false,
                    scales: { xAxes: [{ stacked: true, }], yAxes: [{ stacked: true, }] },
                },
                urls: {
                    mito_sequence_number: "/api/dashboard/projects/dnas/mito?top=" + this.top,
                    mni_bones: "/api/dashboard/projects/mni?by=bones&top=" + this.top,
                    mni_zones: "/api/dashboard/projects/mni?by=zones&top=" + this.top,
                },
                titles: {
                    mito_sequence_number: "Mito Sequences",
                    mni_bones: "Frequency Bones",
                    mni_zones: "Frequency Zones",
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
            } else {
                this.setItems(this.default_items);
                this.loaded = true;
            }
        },
        mounted() {
            //
        },
        methods: {
            getChartData: function () {
                this.loading = true;
                axios
                    .request({ url: this.urls[this.type], method: 'GET',
                        headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken },
                    })
                    .then(response => {
                        // Note that the items[type] matched what is returned from the API
                        this.setItems(response.data.data);
                        this.loading = false;
                        this.loaded = true
                    })
            },
            setItems(data) {
                this.items = data;
                this.chartdata.labels = this.buildLabels(this.items);
                console.log("Mito Item: "+ JSON.stringify(this.items));

                // Get the data (totals) for bar values
                let items_data = [];
                for (let i=0; i < this.items.length; i++){
                    items_data[i] = this.items[i]["total"];
                }
                this.chartdata.datasets = [{
                    label: this.titles[this.type],
                    data: items_data,
                    backgroundColor: this.getBackgroundColorPallete(),
                }];
                if ( this.type === "mito_sequence_number" ) {
                    this.chartdata.type = "horizontalBar";
                    let copy = JSON.stringify(this.chartdata);
                    this.chartdata = JSON.parse(copy);
                }
            },
            buildLabels(data) {
                var labels = [];
                for (let i = 0; i < data.length; i++) {
                    if ( this.type === "mito_sequence_number" ) {
                        labels.push( "Seq " + data[i].mito_sequence_number);
                    } else if ( this.type === "mni_bones" ) {
                        labels.push(data[i].name);
                    } else if ( this.type === "mni_zones" ) {
                        let name = data[i].name + " : " + data[i].display_name.substring(0,2);
                        labels.push(name);
                    }
                }
                this.chartdata.labels = labels;
                return labels;
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
            getBackgroundColorPallete() {
                if ( this.type === "mito_sequence_number" ) {
                    return this.backgroundColor.blue;
                } else if ( this.type === "mni_bones" ) {
                    return this.backgroundColor.green;
                } else if ( this.type === "mni_zones" ) {
                    return this.backgroundColor.orange;
                }
            },
            toggleBar() {
                console.log("toggleBar: "+ this.show_bar);
                this.show_bar = !this.show_bar;
                this.chartdata.type = this.show_bar ? 'horizontalBar' : 'bar';
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
        },
    }
</script>
