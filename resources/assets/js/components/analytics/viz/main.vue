<template>
    <div class="m-2 align-center">
        <v-card flat>
            <v-container fluid class="m-0 p-0">
                <v-toolbar>
                    <v-breadcrumbs :items="trail" large class="p-0"></v-breadcrumbs>
                    <v-spacer></v-spacer>
                    <v-toolbar-title class="pt-5">
                        <v-row class="mx-4">
                            <v-col cols="12" md="3">
                                <v-badge class="project-canvas" :content="listAccession.length" :value="listAccession.length" color="green" overlap>
                                    <v-autocomplete v-model="accession_number" name="accession_number" :items="listAccession" clearable
                                                    label="Accession Number" placeholder="Select Accession Number">
                                    </v-autocomplete>
                                </v-badge>
                            </v-col>
                            <v-col cols="12" md="3">
                                <v-badge class="project-canvas" :content="listProvenance1.length" :value="listProvenance1.length" color="green" overlap>
                                    <v-autocomplete v-model="provenance1" name="provenance1" :items="listProvenance1" clearable
                                                    label="Provenance1" placeholder="Select Provenance1">
                                    </v-autocomplete>
                                </v-badge>
                            </v-col>
                            <v-col cols="12" md="3">
                                <v-badge class="project-canvas" :content="listProvenance2.length" :value="listProvenance2.length" color="green" overlap>
                                    <v-autocomplete v-model="provenance2" name="provenance2" :items="listProvenance2" clearable
                                                    label="Provenance2" placeholder="Select Provenance2">
                                        <template v-slot:append-outer>
                                            <v-icon title="View" color="primary" @click="getSpecimens" :loading="loading">mdi-magnify</v-icon>
                                        </template>
                                    </v-autocomplete>
                                </v-badge>
                            </v-col>
                            <v-col cols="12" md="3">
                                <v-badge class="project-canvas-specimens" :content="listSpecimens.length" :value="listSpecimens.length" color="green" overlap>
                                    <v-autocomplete v-model="selected_specimen_id" name="selected_specimen" label="Specimen" placeholder="Select Specimen" clearable
                                                    :items="listSpecimens" item-text="key_bone_side" item-value="id" :loading="loading" @change="selectSpecimen">
                                    </v-autocomplete>
                                </v-badge>
                            </v-col>
                        </v-row>
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <!--  Start - Place dynamic buttons here-->
                    <v-btn title="Reset/Undo" icon color="primary" @click="resetCanvas"><v-icon>mdi-undo-variant</v-icon></v-btn>
                    <!-- Right Visualization Filter Menu Start -->
                    <v-menu offset-y left content-class="p-0 m-0 dropdown-menu viz-toolbar" transition="slide-y-transition" :close-on-content-click="false">
                        <template v-slot:activator="{ on }"><v-icon color="primary" v-on="on">mdi-eye-settings</v-icon></template>
                        <v-card class="p-0 m-0" width="400px">
                            <v-card-title class="m-0 p-0">
                                <v-toolbar dense>
                                    <v-spacer></v-spacer>
                                    <v-chip class="ma-2" color="primary"><v-avatar left><v-icon>mdi-toolbox</v-icon></v-avatar>Viz Toolbar</v-chip>
                                    <v-spacer></v-spacer>
                                </v-toolbar>
                            </v-card-title>
                            <v-card-text class="m-2 p-2">
                                <v-autocomplete id= "taphonomy_id" v-model="taphonomys" label="Taphonomies" filled chips deletable-chips multiple dusk="se-taphonomys-menu"
                                                :hint="hint" persistent-hint :items="list_items" item-text="name" item-value="id" :placeholder="placeholder">
                                    <template v-slot:selection="data">
                                        <v-chip v-bind="data.attrs" :input-value="data.selected" :color="data.item.color" close @click="data.select" @click:close="remove(data.item)">
                                            <v-icon v-if="data.item.icon" left>{{data.item.icon}}</v-icon>{{ data.item.name}}
                                        </v-chip>
                                    </template>
                                    <template v-slot:item="data">
                                        <template v-if="typeof data.item !== 'object'"><v-list-item-content v-text="data.item"></v-list-item-content></template>
                                        <template v-else>
                                            <v-list-item-avatar class="headline" left :color="data.item.color"><v-icon>{{ data.item.icon }}</v-icon></v-list-item-avatar>
                                            <v-list-item-content :background-color="data.item.color">
                                                <v-list-item-title v-html="data.item.name"></v-list-item-title>
                                            </v-list-item-content>
                                        </template>
                                    </template>
                                </v-autocomplete>

                            </v-card-text>
                            <v-card-actions class="m-0">
                                <v-row align="center" justify="center" class="m-0 p-0">
                                    <v-btn title="View All" color="primary" text :href="'/users/'+theUser.id+'/notifications'"><v-icon class="p-2">mdi-eye</v-icon>View All</v-btn>
                                    <v-btn title="Filter" color="primary" text @click="filter"><v-icon class="p-2">mdi-filter</v-icon>Filter</v-btn>
                                </v-row>
                            </v-card-actions>
                        </v-card>
                    </v-menu>
                    <!-- Right Visualization Filter Menu End -->

                </v-toolbar>
            </v-container>
        </v-card>
<!--        <v-card v-if="specimen" :key="specimen.id">-->
        <v-card>
<!--            <v-alert v-if="alert" class="my-1" border="left" colored-border type="info" elevation="2" dismissible>{{alertText}}</v-alert>-->
<!--            <specimen-highlights v-if="show_specimen" :specimen="specimen"></specimen-highlights>-->

            <!-- D3 Canvas resides here-->
            <v-card-text id="graph-canvas">
            </v-card-text>
        </v-card>
    </div>
</template>
<style scoped>
    .v-autocomplete-content .v-select-list .v-subheader {
        color: blue;
    }
    .project-canvas .v-badge__wrapper {
        margin-left: -10px;
        margin-top: -5px;
    }
    .project-canvas-specimens .v-badge__wrapper {
        margin-left: -42px;
        margin-top: -5px;
    }
    .node text {
        pointer-events: none;
        font: 10px sans-serif;
    }
</style>
<script>
    import {mapGetters, mapState} from "vuex";
    import {eventBus} from "../../../eventBus";
    import axios from "axios";
    import * as d3 from "d3";

    export default {
        name: 'project-canvas',
        props: {
            // possible values "taphonomy", "pairs", "pathology", "trauma", "anomaly", "dna"
            type: { type: String, default: "taphonomy" },
            heading: { type: String, default: "Taphonomy" },
        },
        data() {
            return {
                loading: false,
                listSpecimens: [],
                accession_number: "",
                provenance1: "",
                provenance2: "",
                selected_specimen_id: null,
                specimen: null,
                show_specimen: false,
                isCollapseAll: false,

                viz: {
                    taphonomy: { heading: "Taphonomy"},
                    pairs: { heading: "Pair Matches"},
                    pathology: { heading: "Pathology"},
                    trauma: { heading: "Trauma"},
                    anomaly: { heading: "Anomaly"},
                },
                trail: [ { text: 'Home', disabled: false, href: '/', },
                    { text: 'Visualization Dashboard', disabled: false,  href: "/visualizations" },
                    { text: "Placeholder", disabled: true,  href: "" },],
                alert: false,
                alertText: "",
                tabs: null,

                // D3 canvas related
                graph: null,
                cached_graph: null,
                temp_graph: null,
                graph_example: {
                    nodes: [
                        { "id": 1269, "key": "CIL 2003-116:G-01:X-233E:201", "key_bone_side": "CIL 2003-116:G-01:X-233E:201 :: Humerus-Left" },
                        { "id": 1270, "key": "CIL 2003-116:G-01:X-233E:202", "key_bone_side": "CIL 2003-116:G-01:X-233E:202 :: Humerus-Right" },
                        { "id": 1271, "key": "CIL 2003-116:G-01:X-233E:203", "key_bone_side": "CIL 2003-116:G-01:X-233E:203 :: Humerus-Right" },
                    ],
                    links: [
                        { "source": 1269, "target": 1270 },
                        { "source": 1269, "target": 1271 }
                    ]
                },

                // Viz Toolbar related
                taphonomys: null,
                hint: "You can apply multiple taphonomies to this specimen",
                placeholder: "Select Taphonomies",
            };
        },
        created() {
            console.log('Specimen Component created.');
            this.$store.dispatch('fetchProjectList', { 'type': 'accessions' }).then(() => this.loading = false);
            this.$store.dispatch('fetchProjectList', { 'type': 'provenance1' }).then(() => this.loading = false);
            this.$store.dispatch('fetchProjectList', { 'type': 'provenance2' }).then(() => this.loading = false);
        },
        mounted() {
            this.$store.commit('setListCount', 0);
            this.accession_number = (this.listAccession && this.listAccession.length) ? this.listAccession[0] : "";
            this.provenance1 = (this.listProvenance1 && this.listProvenance1.length) ? this.listProvenance1[0] : "";
            this.provenance2 = (this.listProvenance2 && this.listProvenance2.length) ? this.listProvenance2[0] : "";

            // D3 canvas related
            this.chart(this.graph);
        },
        watch: {
            graph() {
                if (this.graph) {
                    this.listSpecimens = this.graph.nodes.filter( el => { return el.type === "specimen"});
                    let filtered_nodes = this.graph.nodes.filter( el => { return el.type === "taphonomy"});
                    this.taphonomys = filtered_nodes.map(el => el.id);
                } else {
                    this.listSpecimens = [];
                    this.taphonomys = null;
                }
            },
        },
        methods: {
            getSpecimens() {
                this.loading = true;
                let url = '/api/analytics/' + this.type;
                let params = {};
                (this.accession_number) ? params.an = [this.accession_number] : null;
                (this.provenance1) ? params.p1 = [this.provenance1] : null;
                (this.provenance2) ? params.p2 = [this.provenance2] : null;
                (this.type === "pairs") ? params.bone = 37 : null;

                axios({ url: url, method: 'GET', params: params,
                    headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, }
                })
                .then(response=>{
                    // For debugging purposes
                    console.log("data: " + JSON.stringify(response.data.data));
                    this.graph = response.data.data;
                    this.cached_graph = JSON.parse(JSON.stringify(this.graph)); // make a copy
                    this.loading = false;
                    // D3
                    this.resetCanvas();
                    this.chart(this.graph);
                })
                .catch((error) => {
                    console.log(error);
                });
            },
            expand(val) {
                // this.showForm = val;
            },
            search(val) {
                // this.showForm = val;
            },
            setSpecimen(item) {
                this.specimen = item;
            },
            toggleCollapseAll() {
                this.isCollapseAll = !this.isCollapseAll;
                this.widgets.map(widget => {
                    widget.expanded = !widget.expanded;
                    return widget;
                });
            },
            resetCanvas() {
                var svg = d3.select("#graph-canvas");
                svg.selectAll("*").remove();
            },
            remove(item) {
                const index = this.taphonomys.indexOf(item.id);
                if (index >= 0) this.taphonomys.splice(index, 1)
            },
            filter() {
                if (this.graph) {
                    this.temp_graph = JSON.parse(JSON.stringify(this.cached_graph));
                    let filtered_nodes = this.temp_graph.nodes.filter( el => { return el.type === "taphonomy"});
                    for (let i=0; i<filtered_nodes.length; i++) {
                        if (!this.taphonomys.includes(filtered_nodes[i].id)) {
                            console.log("length: " + filtered_nodes.length);
                            console.log("Deleting: " + JSON.stringify(filtered_nodes[i]));
                            let deleted_node = filtered_nodes.splice(i, 1);
                            console.log("length: " + filtered_nodes.length);
                            console.log("Deleted: " + JSON.stringify(deleted_node));
                            i--;

                            // Remove the effected links for the deleted node
                            let links = this.temp_graph.links.filter(el => { return el.source !== deleted_node[0].id });
                            this.temp_graph.links = links;
                        }
                    }
                    console.log("nodes: " + this.temp_graph.nodes.length);
                    console.log("links: " + this.temp_graph.links.length);

                    // Reset the canvas and draw the chart
                    this.graph = JSON.parse(JSON.stringify(this.temp_graph));
                    // this.removeNodesWithoutLinks(this.graph);
                    this.resetCanvas();
                    this.chart(this.graph);
                }
            },
            selectSpecimen() {
                let selected_specimen = this.listSpecimens.find(el => { return el.id === this.selected_specimen_id});
                console.log("selectSpecimen: "+JSON.stringify(selected_specimen));
            },
            // Does not work properly, needs to be rewritten and tested.
            removeNodesWithoutLinks(graph) {
                for (let i=0; i<graph.nodes.length; i++) {
                    let node = graph.nodes[i];
                    let links = graph.links.filter(el => { return el.target === node.id });
                    if (links.length) {
                        graph.nodes = graph.nodes.filter(el => {return el.id !== node.id})
                    }
                    i--;
                }
            },

            // D3 Canvas related
            chart(data) {
                let height = 600;
                let width = 1600;
                let radius = 6;

                let nodes = [];
                let links = [];
                if (data) {
                    console.log("chart called: " + JSON.stringify(data));
                    links = data.links.map(d => Object.create(d));
                    nodes = data.nodes.map(d => Object.create(d));
                }

                const simulation = d3.forceSimulation(nodes)
                .force("link", d3.forceLink(links).id(d => d.id))
                .force("charge", d3.forceManyBody())
                .force("center", d3.forceCenter(width / 2, height / 2));

                // const svg = d3.create("svg")
                // .attr("viewBox", [0, 0, width, height]);

                const svg = d3.select("#graph-canvas").append("svg")
                .attr("viewBox", [0, 0, width, height]);

                const link = svg.append("g")
                .attr("stroke", "#999")
                .attr("stroke-opacity", 0.6)
                .selectAll("line")
                .data(links)
                .join("line")
                .attr("stroke-width", d => Math.sqrt(d.value));

                link.append("title")
                .text(d => d.relation);

                const node = svg.append("g")
                .attr("stroke", "#fff")
                .attr("stroke-width", 1.5)
                .selectAll("circle")
                .data(nodes)
                .join("circle")
                .attr("r", 5)
                .attr("fill", this.color())
                .call(this.drag(simulation));

                node.append("title")
                .text(d => d.key_bone_side);

                // node.append("text")
                // .attr("dx", 12)
                // .attr("dy", ".35em")
                // .text(function(d) { return d.key_bone_side });
                //
                simulation.on("tick", () => {
                    link
                    .attr("x1", d => d.source.x)
                    .attr("y1", d => d.source.y)
                    .attr("x2", d => d.target.x)
                    .attr("y2", d => d.target.y);

                    // node
                    // .attr("cx", d => d.x)
                    // .attr("cy", d => d.y);

                    node
                    .attr("cx", function(d) { return d.x = Math.max(radius, Math.min(width - radius, d.x)); })
                    .attr("cy", function(d) { return d.y = Math.max(radius, Math.min(height - radius, d.y)); });
                });

                // invalidation.then(() => simulation.stop());

                return svg.node();
            },
            color() {
                const scale = d3.scaleOrdinal(d3.schemeCategory10);
                return d => scale(d.group);
            },
            drag(simulation) {

                function dragstarted(event, d) {
                    if (!event.active) simulation.alphaTarget(0.3).restart();
                    d.fx = d.x;
                    d.fy = d.y;
                }

                function dragged(event,d) {
                    d.fx = event.x;
                    d.fy = event.y;
                }

                function dragended(event,d) {
                    if (!event.active) simulation.alphaTarget(0);
                    d.fx = null;
                    d.fy = null;
                }

                return d3.drag()
                .on("start", dragstarted)
                .on("drag", dragged)
                .on("end", dragended);
            },
        },
        computed: {
            ...mapState({
                list_items: state => state.taphonomies,
            }),
            ...mapGetters({
                theUser: 'theUser',
                theProject: 'theProject',
                listAccession: 'getProjectAccessions',
                listProvenance1: 'getProjectProvenance1',
                listProvenance2: 'getProjectProvenance2',
            }),
            edited() {
                // return JSON.stringify(this.form) !== JSON.stringify(this.initialFormData);
            },
            action() {
                const action = "View"; // ToDo: temporary hard-coded
                return { create: action === "Create", view: action === "View", edit: action === "Update" };
            },
        },
    };
</script>
