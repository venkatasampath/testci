<template>
    <div :id="key" class="m-2">
        <contentheader :trail="trail" :title="heading" :model_name="key"
                       :collapse_all_menu="true" @eventCollapseAll="eventCollapseAllGo" @eventExpandAll="eventExpandAllGo"
                       :reset_dashboard_menu="true" @eventResetDashboard="resetVisualizations">
        </contentheader>
        <draggable class="row m-0 p-0" v-model="visualizations" group="visualizations" @start="drag=true" @end="drag=false">
            <v-card class="col-md-6 mb-3 m-0 p-2" v-for="(viz, key) in visualizations" :key="key" v-if="viz.visible">
                <v-card-title class="mt-0 p-0" outlined flat tile>
                    <v-toolbar dense>
                        <v-toolbar-title>{{ viz.name }}</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn title="Go" icon color="primary" @click="goToViz(viz.url)"><v-icon>mdi-play</v-icon></v-btn>
                        <v-btn :title="!viz.expanded ? 'Collapse' : 'Expand'" icon color="primary" @click="viz.expanded = !viz.expanded">
                            <v-icon>{{ viz.expanded ? 'mdi-arrow-collapse-up' : 'mdi-arrow-expand-down' }}</v-icon>
                        </v-btn>
                        <v-btn title="Close" icon color="primary" @click="viz.visible = false"><v-icon>mdi-close</v-icon></v-btn>
                    </v-toolbar>
                </v-card-title>
                <v-card-text class="m-0 p-3" v-if="viz.expanded">
                    <div>{{ viz.description }}</div>
                    <img :src="`/storage/images/visualizations/${viz.type}.png`" :alt="viz.name" class="img-fluid mt-2"/>
                </v-card-text>
            </v-card>
        </draggable>
    </div>
</template>

<script>
    import draggable from "vuedraggable";

    export default {
        name: "dashboard-project-visualizations",
        components: { draggable },
        props: {
            heading: { type: String, default: "Project Visualizations Dashboard" },
            vizList: { type: [Object, Array],
                default: () => ([
                    { type: 'taphomony', width: 6, visible: true, expanded: true, name: 'Taphonomy', tags: 'Taphonomy, viz',
                        url: '/visualizations?type=taphonomy',  description: 'This will allow you to visualize taphonomy relationships.', },
                    { type: 'pairs', width: 6, visible: true, expanded: true, name: 'Pair Matches', tags: 'Pairs, viz',
                        url: '/visualizations?type=pairs',  description: 'This will allow you to visualize pair matches.', },
                    { type: 'pathology', width: 6, visible: true, expanded: true, name: 'Pathology', tags: 'Pathology, viz',
                        url: '/visualizations?type=pathology',  description: 'This will allow you to visualize pathology relationships.', },
                    { type: 'trauma', width: 6, visible: true, expanded: true, name: 'Trauma', tags: 'Trauma, viz',
                        url: '/visualizations?type=trauma',  description: 'This will allow you to visualize trauma relationships.', },
                    { type: 'anomaly', width: 6, visible: true, expanded: true, name: 'Anomaly', tags: 'Anomaly, viz',
                        url: '/visualizations?type=anomaly',  description: 'This will allow you to visualize anomaly relationships.', },
                ])},
        },
        data() {
            return {
                key: "project-visualizations-dashboard",
                collapsed: true,
                trail: [{text: 'Home', disabled: false, href: '/',}, {text: 'Project Visualizations Dashboard', disabled: true, href: '/visualizations/org/dashboard'}, ],
                visualizations: null,
            };
        },
        created() {
            // Visualizations Widgets and Draggable
            this.visualizations = localStorage.getItem(this.key) ? JSON.parse(localStorage.getItem(this.key)) : this.vizList;
        },
        mounted() {
            //
        },
        watch: {
            visualizations: {
                deep: true,
                handler(list) {
                    localStorage.setItem(this.key, JSON.stringify(list));
                }
            }
        },
        methods: {
            goToViz(url) {
                console.log("Visualization url: " + url);
                window.location = url;
            },
            resetVisualizations() {
                this.$delete(this.visualizations, {});
                this.vizList.forEach((viz, key) => {
                    viz.visible = true;
                    viz.expanded = true;
                    this.$set(this.visualizations, key, viz);
                });

                this.collapsed = true;
                localStorage.setItem(this.key, JSON.stringify(this.visualizations));
            },
            eventCollapseAllGo(model, val) {
                console.log('DashboardVisualizations eventCollapseAllGo - captured event: ' + model);
                if (model === this.key) {
                    this.toggleCollapse();
                }
            },
            eventExpandAllGo(model, val) {
                console.log('DashboardVisualizations eventExpandAllGo - captured event: ' + model);
                if (model === this.key) {
                    this.toggleCollapse();
                }
            },
            toggleCollapse() {
                this.collapsed = !this.collapsed;
                this.visualizations.map(viz => {
                    viz.expanded = this.collapsed;
                    return viz;
                });
            },
        },
    };
</script>
