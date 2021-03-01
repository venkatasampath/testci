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
                                                    label="Accession Number" placeholder="Select Accession Number" @change="getSpecimens">
                                    </v-autocomplete>
                                </v-badge>
                            </v-col>
                            <v-col cols="12" md="3">
                                <v-badge class="project-canvas" :content="listProvenance1.length" :value="listProvenance1.length" color="green" overlap>
                                    <v-autocomplete v-model="provenance1" name="provenance1" :items="listProvenance1" clearable
                                                    label="Provenance1" placeholder="Select Provenance1" @change="getSpecimens">
                                    </v-autocomplete>
                                </v-badge>
                            </v-col>
                            <v-col cols="12" md="3">
                                <v-badge class="project-canvas" :content="listProvenance2.length" :value="listProvenance2.length" color="green" overlap>
                                    <v-autocomplete v-model="provenance2" name="provenance2" :items="listProvenance2" clearable
                                                    label="Provenance2" placeholder="Select Provenance2" @change="getSpecimens">
                                        <template v-slot:append-outer>
                                            <v-icon title="View" color="primary" @click="getSpecimensAnP1P2" :loading="loading"
                                                    :disabled="!accession_number && !provenance1 && !provenance2">mdi-magnify</v-icon>
                                        </template>
                                    </v-autocomplete>
                                </v-badge>
                            </v-col>
                            <v-col cols="12" md="3">
                                <v-badge class="project-canvas-specimens" :content="listSpecimens.length" :value="listSpecimens.length" color="green" overlap>
                                    <v-autocomplete v-model="selected_specimen_id" name="selected_specimen" label="Specimen" placeholder="Select Specimen" clearable
                                                    :items="listSpecimens" item-text="key_bone_side" item-value="id" :loading="loading" @change="getSpecimen">
                                    </v-autocomplete>
                                </v-badge>
                            </v-col>
                        </v-row>
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <!--  Start - Place dynamic buttons here-->
                    <v-btn title="Reset/Undo" icon color="primary" @click="resetCanvas"><v-icon>mdi-undo-variant</v-icon></v-btn>
                    <v-btn title="Tools" icon color="primary" @click.stop="canvasDrawer.model = !canvasDrawer.model"><v-icon>mdi-cogs</v-icon></v-btn>
                    <!-- Right Drawer Start -->
<!--                    <v-navigation-drawer v-model="canvasDrawer.model" :clipped="canvasDrawer.clipped" right temporary hide-overlay height="600px" :width="($vuetify.breakpoint.smAndDown) ? 250 : 450">-->
<!--                        &lt;!&ndash; Tabs Inside Right Drawer Start&ndash;&gt;-->
<!--                        <v-tabs v-model="tabs" grow>-->
<!--                            <v-tab class="primary&#45;&#45;text"><v-icon>mdi-wrench</v-icon></v-tab>-->
<!--                            <v-tab class="primary&#45;&#45;text"><v-icon>mdi-help-circle-outline</v-icon></v-tab>-->
<!--                        </v-tabs>-->
<!--                        <v-tabs-items v-model="tabs" class="elevation-1">-->
<!--                            <v-tab-item>-->
<!--                                <v-card>-->
<!--                                    <v-card-title>Layout Options</v-card-title>-->
<!--                                    <v-card-text>-->
<!--                                        <v-list subheader three-line>-->
<!--                                            <v-subheader class="p-0">Scheme</v-subheader>-->
<!--                                            <v-list-item>-->
<!--                                                <template v-slot:default="{ active, toggle }">-->
<!--                                                    <v-list-item-action><v-switch v-model="themeDark" primary/></v-list-item-action>-->
<!--                                                    <v-list-item-content>-->
<!--                                                        <v-list-item-title>Dark</v-list-item-title>-->
<!--                                                        <v-list-item-subtitle>The application layout scheme to use (Dark or Light)</v-list-item-subtitle>-->
<!--                                                    </v-list-item-content>-->
<!--                                                </template>-->
<!--                                            </v-list-item>-->
<!--                                        </v-list>-->

<!--                                    </v-card-text>-->
<!--                                </v-card>-->
<!--                                &lt;!&ndash;  <rhs-panel-layout-options></rhs-panel-layout-options>&ndash;&gt;-->
<!--                            </v-tab-item>-->

<!--                            <v-tab-item><rhs-panel-user-settings></rhs-panel-user-settings></v-tab-item>-->
<!--                        </v-tabs-items>-->
<!--                        &lt;!&ndash; Tabs Inside Right Drawer End&ndash;&gt;-->
<!--                    </v-navigation-drawer>-->
                    <!-- Right Drawer End -->

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
    import {eventBus} from "../../eventBus";
    import axios from "axios";
    import * as d3 from "d3";

    export default {
        name: 'project-canvas',
        props: {
            heading: { type: String, default: "Project Canvas" },
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

                trail: [ { text: 'Home', disabled: false, href: '/', }, { text: 'Project Canvas', disabled: true,  href: "/" }, ],
                alert: false,
                alertText: "",
                tabs: null,
                canvasDrawer: { model: null, clipped: true, },

                // D3 canvas related
                gdp: [
                    { country: "USA", value: 21.5 },
                    { country: "China", value: 14.2 },
                    { country: "Japan", value: 5.2 },
                    { country: "Germany", value: 3.9 },
                    // { country: "India", value: 2.9 }
                ],
                graph: null,
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
            // this.generateArc();
            this.chart(this.graph);
        },
        watch: {
            // widgets: {
            //     deep: true,
            //     handler(list) {
            //         localStorage.setItem("project-canvas-widgets", JSON.stringify(list));
            //     }
            // },
        },
        methods: {
            getSpecimens() {
                this.loading = true;
                // Use this below for testing
                let url = '/api/projects/' + this.theProject.id + '/specimens/advanced-search?list=true';
                let params = {};
                (this.accession_number) ? params.an = [this.accession_number] : null;
                (this.provenance1) ? params.p1 = [this.provenance1] : null;
                (this.provenance2) ? params.p2 = [this.provenance2] : null;

                axios({ url: url, method: 'GET', params: params,
                    headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                })
                .then(response=>{
                    // For debugging purposes
                    console.log("data: " + JSON.stringify(response.data.data));
                    this.listSpecimens = response.data.data;
                    this.loading = false;
                })
                .catch((error) => {
                    console.log(error);
                    let payload = { 'text': 'Too many specimen, Please refine your search', 'color': 'error', };
                    eventBus.$emit('show-snackbar', payload);
                });
            },
            getSpecimen() {
                if (!this.selected_specimen_id) {
                    this.resetCanvas();
                    return;
                }
                this.loading = true;
                let url = '/api/analytics/specimens/' + this.selected_specimen_id + "/degree/1";
                console.log("getSpecimen url: "+url);
                axios({ url: url, method: 'GET',
                    headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, }
                })
                .then(response=>{
                    // For debugging purposes
                    console.log("data: " + JSON.stringify(response.data.data));
                    this.graph = response.data.data;
                    this.loading = false;

                    // D3 related
                    this.resetCanvas();
                    this.chart(this.graph);
                    // this.generateArc();
                })
                .catch((error) => {
                    console.log(error);
                });
            },
            getSpecimensAnP1P2() {
                this.loading = true;
                let url = '/api/analytics/anp1p2/specimens';
                console.log("getSpecimen url: "+url);
                axios({ url: url, method: 'GET', params: { an: [this.accession_number], p1: [this.provenance1], p2: [this.provenance2] },
                    headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, }
                })
                .then(response=>{
                    // For debugging purposes
                    console.log("data: " + JSON.stringify(response.data.data));
                    this.graph = response.data.data;
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

            // D3 Canvas related
            generateArc() {
                const w = 500;
                const h = 500;

                const svg = d3
                .select("#graph-canvas")
                .append("svg")
                .attr("width", w)
                .attr("height", h);

                const sortedGDP = this.gdp.sort((a, b) => (a.value > b.value ? 1 : -1));
                const color = d3.scaleOrdinal(d3.schemeDark2);

                const max_gdp = d3.max(sortedGDP, o => o.value);

                const angleScale = d3
                .scaleLinear()
                .domain([0, max_gdp])
                .range([0, 1.5 * Math.PI]);

                const arc = d3
                .arc()
                .innerRadius((d, i) => (i + 1) * 25)
                .outerRadius((d, i) => (i + 2) * 25)
                .startAngle(angleScale(0))
                .endAngle(d => angleScale(d.value));

                const g = svg.append("g");

                g.selectAll("path")
                .data(sortedGDP)
                .enter()
                .append("path")
                .attr("d", arc)
                .attr("fill", (d, i) => color(i))
                .attr("stroke", "#FFF")
                .attr("stroke-width", "1px")
                .on("mouseenter", function() {
                    d3.select(this)
                    .transition()
                    .duration(200)
                    .attr("opacity", 0.5);
                })
                .on("mouseout", function() {
                    d3.select(this)
                    .transition()
                    .duration(200)
                    .attr("opacity", 1);
                });

                g.selectAll("text")
                .data(this.gdp)
                .enter()
                .append("text")
                .text(d => `${d.country} -  ${d.value} Trillion`)
                .attr("x", -150)
                .attr("dy", -8)
                .attr("y", (d, i) => -(i + 1) * 25);

                g.attr("transform", "translate(200,300)");
            },

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
                //
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
            themeDark: {
                get() {
                    return this.$store.getters.themeDark;
                },
                set(val) {
                    this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
                    this.$store.commit('setThemeDark', val);
                }
            },
        },
    };
</script>
