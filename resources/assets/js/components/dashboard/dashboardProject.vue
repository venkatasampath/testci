<template>
    <div id="dashboard-project" class="m-2">
        <contentheader :trail="trail" :title="theProject.name + ' : ' + heading" model_name="dashboard-project"
                       :collapse_all_menu="true" @eventCollapseAll="eventCollapseAllGo" @eventExpandAll="eventExpandAllGo"
                       :reset_dashboard_menu="true" @eventResetDashboard="resetWidgets"
                       :dashboard_menu="true">
        </contentheader>
        <project-highlights-widget v-if="stats.latest.specimen" :project_id="project_id" :stats="stats.latest"></project-highlights-widget>
        <v-progress-linear v-if="loading" :indeterminate="loading"/>
        <draggable class="row px-2" v-model="widgets" group="widgets" @start="drag=true" @end="drag=false">
            <div v-if="widget.visible" :class="widgetWidth(widget)" v-for="(widget, index) in widgets" :key="index" class="m-0 p-0">
                <!-- Special Project specific widgets-->
                <cabanatuan-widget :index="index" v-if="widget.type === 'cabanautan' && project_id === 11"/>
                <!-- Pie Charts-->
                <pie-chart-widget :index="index" :type="widget.type" :default_items="stats.latest" v-if="widget.type === 'complete' && stats.latest.specimen" @eventGenerate="generateDetails(widget.type)" dusk="complete-widget"/>
                <pie-chart-widget :index="index" :type="widget.type" :default_items="stats.latest" v-if="widget.type === 'individual_assigned' && stats.latest.specimen"@eventGenerate="generateDetails(widget.type)"/>
                <pie-chart-widget :index="index" :type="widget.type" :default_items="stats.latest" v-if="widget.type === 'dna_sampled' && stats.latest.specimen" @eventGenerate="generateDetails(widget.type)"/>
                <pie-chart-widget :index="index" :type="widget.type" :default_items="stats.latest" v-if="widget.type === 'dna_mito_results' && stats.latest.specimen" @eventGenerate="generateDetails(widget.type)"/>
                <pie-chart-widget :index="index" :type="widget.type" :default_items="stats.latest" v-if="widget.type === 'dna_ystr_results' && stats.latest.specimen"@eventGenerate="generateDetails(widget.type)"/>
                <pie-chart-widget :index="index" :type="widget.type" :default_items="stats.latest" v-if="widget.type === 'dna_austr_results' && stats.latest.specimen"@eventGenerate="generateDetails(widget.type)"/>
                <pie-chart-widget :index="index" :type="widget.type" :default_items="stats.latest" v-if="widget.type === 'measured' && stats.latest.specimen" @eventGenerate="generateDetails(widget.type)"/>
                <pie-chart-widget :index="index" :type="widget.type" :default_items="stats.latest" v-if="widget.type === 'ct_scanned' && stats.latest.specimen" @eventGenerate="generateDetails(widget.type)"/>
                <pie-chart-widget :index="index" :type="widget.type" :default_items="stats.latest" v-if="widget.type === 'xray_scanned' && stats.latest.specimen" @eventGenerate="generateDetails(widget.type)"/>
                <pie-chart-widget :index="index" :type="widget.type" :default_items="stats.latest" v-if="widget.type === 'clavicle_triage' && stats.latest.specimen" @eventGenerate="generateDetails(widget.type)"/>
                <pie-chart-widget :index="index" :type="widget.type" :default_items="stats.latest" v-if="widget.type === 'isotope_sampled' && stats.latest.specimen" @eventGenerate="generateDetails(widget.type)"/>
                <!-- Bar Charts-->
                <bar-chart-widget :index="index" :type="widget.type" :default_items="mni_widgets_data.mito_sequences" v-if="widget.type === 'mito_sequence_number' && mni_widgets_data" @eventGenerate="generateDetails(widget.type)"/>
                <bar-chart-widget :index="index" :type="widget.type" :default_items="mni_widgets_data.mni_by_bones" v-if="widget.type === 'mni_bones' && mni_widgets_data" @eventGenerate="generateDetails(widget.type)"/>
                <bar-chart-widget :index="index" :type="widget.type" :default_items="mni_widgets_data.mni_by_zones" v-if="widget.type === 'mni_zones' && mni_widgets_data" @eventGenerate="generateDetails(widget.type)"/>
                <!-- Stacked Bar Charts-->
                <stacked-bar-chart-widget :index="index" :type="widget.type" v-if="widget.type === 'mni_mito_bones_side'" @eventGenerate="generateDetails(widget.type)"/>
                <stacked-bar-chart-widget :index="index" :type="widget.type" v-if="widget.type === 'mni_bones_side'" @eventGenerate="generateDetails(widget.type)"/>
                <stacked-bar-chart-widget :index="index" :type="widget.type" v-if="widget.type === 'mni_zones_side'" @eventGenerate="generateDetails(widget.type)"/>
<!--                <stacked-bar-chart-widget :index="index" :type="widget.type" :default_items="mni_widgets_data.mni_by_mito_bones_and_side"-->
<!--                                          v-if="widget.type === 'mni_mito_bones_side' && mni_widgets_data" :sorted_list="mni_widgets_data.mito_sequences" />-->
<!--                <stacked-bar-chart-widget :index="index" :type="widget.type" :default_items="mni_widgets_data.mni_by_bones_and_side"-->
<!--                                          v-if="widget.type === 'mni_bones_side' && mni_widgets_data"/>-->
<!--                <stacked-bar-chart-widget :index="index" :type="widget.type" :default_items="mni_widgets_data.mni_by_bones_side_zones"-->
<!--                                          v-if="widget.type === 'mni_zones_side' && mni_widgets_data"/>-->
                <!-- Line Charts-->
                <line-chart-widget :index="index" :type="widget.type" :default_items="stats.records" v-if="widget.type === 'specimens' && stats.records" :project_id="project_id"/>
                <line-chart-widget :index="index" :type="widget.type" :default_items="stats.records" v-if="widget.type === 'dnas' && stats.records" :project_id="project_id"/>
            </div>
        </draggable>
    </div>
</template>

<script>
    import draggable from "vuedraggable";
    import {mapGetters, mapState} from "vuex";
    import {eventBus} from "../../eventBus";
    import axios from "axios";

    export default {
        name: "dashboard-project",
        components: { draggable },
        props: {
            default_project_id: { type: Number, default: 0 },
            heading: { type: String, default: "Project Dashboard" },
            widgetsList: { type: [Object, Array],
                default: () => ([
                    // Special Project specific widgets
                    { type: 'cabanautan', width: 12, visible: true, expanded: true },
                    // Pie Charts
                    { type: 'complete', width: 4, visible: true, expanded: true, },
                    { type: 'individual_assigned', width: 4, visible: true, expanded: true, },
                    { type: 'dna_sampled', width: 4, visible: true, expanded: true, },
                    { type: 'dna_mito_results', width: 4, visible: true, expanded: true, },
                    { type: 'dna_ystr_results', width: 4, visible: true, expanded: true, },
                    { type: 'dna_austr_results', width: 4, visible: true, expanded: true,},
                    { type: 'measured', width: 4, visible: true, expanded: true, },
                    { type: 'ct_scanned', width: 4, visible: true, expanded: true, },
                    { type: 'xray_scanned', width: 4, visible: true, expanded: true, },
                    { type: 'clavicle_triage', width: 4, visible: true, expanded: true, },
                    { type: 'isotope_sampled', width: 4, visible: true, expanded: true, },
                    // Bar Charts
                    { type: 'mito_sequence_number', width: 4, visible: true, expanded: true,},
                    { type: 'mni_bones', width: 4, visible: true, expanded: true, },
                    { type: 'mni_zones', width: 4, visible: true, expanded: true, },
                    // Stacked Bar Charts
                    { type: 'mni_mito_bones_side', width: 4, visible: true, expanded: true, },
                    { type: 'mni_bones_side', width: 4, visible: true, expanded: true, },
                    { type: 'mni_zones_side', width: 4, visible: true, expanded: true, },
                    // Stacked Bar Charts
                    { type: 'specimens', width: 6, visible: true, expanded: true, },
                    { type: 'dnas', width: 6, visible: true, expanded: true, },
                    { type: 'isotopes', width: 6, visible: true, expanded: true, },
                ])},
        },
        data() {
            return {
                loading: false,
                project_id: this.default_project_id,
                key: 'dashboard-project-widgets',
                isCollapseAll: false,
                trail: [{text: 'Home', disabled: false, href: '/',}, {
                    text: 'Dashboard',
                    disabled: true,
                    href: '/dashboard'
                },],

                // Widgets and Draggable
                 widgets: localStorage.getItem("dashboard-project-widgets") ?
                    JSON.parse(localStorage.getItem("dashboard-project-widgets")) :
                    this.widgetsList,

                urls: {
                    pie: "/api/dashboard/projects/specimens/all",
                    mni: "/api/dashboard/projects/mni?by=all&top=10",
                    mito: "/api/dashboard/projects/dnas/mito",
                },

                stats: {
                    latest: {
                        specimen: null, dna: null, isotope: null, dental: null, user: null, project: null,
                    },
                    records: null,
                    records_count: 0,
                },

                pie_widgets_data: null,
                mni_widgets_data: null,
            };
        },
        created() {
            this.project_id = (this.default_project_id) ? this.default_project_id : this.theProject.id;
            eventBus.$on('dashboard-widget-event', payload => {
                console.log("dashboard-widget-event reveived: with payload " + JSON.stringify(payload))
                this.widgets[payload.index].visible = payload.visible;
                this.widgets[payload.index].expanded = payload.expanded;
            });

            this.getProjectSummary();
            this.getPieWidgetsData();
            this.getMniWidgetsData();
        },
        mounted(){
            //
        },
        watch: {
            widgets: {
                deep: true,
                handler(list) {
                    localStorage.setItem("dashboard-project-widgets", JSON.stringify(list));
                }
            },
        },
        methods: {
            getProjectSummary: function () {
                this.loading = true;
                axios
                    .request({ url: '/api/dashboard/projects/'+this.project_id+'/summary?top=30', method: 'GET',
                        headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken, },
                    })
                    .then(response => {
                        this.setItems(response.data.data);
                        this.loading = false;
                    })
            },
            setItems(data) {
                let latest = data.latest;
                this.stats.latest.specimen = JSON.parse(latest.specimen_stats);
                this.stats.latest.dna = JSON.parse(latest.dna_stats);
                this.stats.latest.isotope = JSON.parse(latest.isotope_stats);
                this.stats.records = data.records;
                this.stats.records_count = data.count;
                this.loaded = true;
            },
            getPieWidgetsData: function () {
                this.loading = true;
                // One call to get the projects, specimens and dnas data
                axios
                    .request({ url: this.urls.pie, method: 'GET',
                        headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken },
                    })
                    .then(response => {
                        this.pie_widgets_data = response.data.data;
                        this.loading = false;
                    })
            },
            getMniWidgetsData: function () {
                this.loading = true;
                // One call to get the projects, specimens and dnas data
                axios
                    .request({ url: this.urls.mni, method: 'GET',
                        headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken },
                    })
                    .then(response => {
                        this.mni_widgets_data = response.data.data;
                        this.loading = false;
                    })
            },
            widgetWidth(item) {
                return (item.width===12) ? 'col-12': (item.width===9) ? 'col-9' : (item.width===8) ? 'col-8' : (item.width===6) ? 'col-6': (item.width===4) ? 'col-4': (item.width===3) ? 'col-3': 'col-2';
            },
            resetWidgets() {
                this.$delete(this.widgets, {});
                this.widgetsList.forEach((widget, key) => {
                    // widget.visible = true;
                    // widget.expanded = true;
                    this.$set(this.widgets, key, widget);
                });
                localStorage.setItem("dashboard-project-widgets", JSON.stringify(this.widgets));
            },
            eventCollapseAllGo(model, val) {
                console.log('DashboardProject eventCollapseAllGo - captured event: ' + model);
                if (model === "dashboard-project") {
                    this.toggleCollapseAll();
                }
            },
            eventExpandAllGo(model, val) {
                console.log('DashboardProject eventExpandAllGo - captured event: ' + model);
                if (model === "dashboard-project") {
                    this.toggleCollapseAll();
                }
            },
            toggleCollapseAll() {
                console.log('DashboardProject toggleCollapseAll - captured event: ');
                this.isCollapseAll = !this.isCollapseAll;
                this.widgets.map(widget => {
                    widget.expanded = this.isCollapseAll;
                    return widget;
                });

                // emit event for widgets
                let payload = { 'expanded': this.isCollapseAll };
                eventBus.$emit('dashboard-event', payload);
            },
            generateDetails(chart) {
                window.open('/drilldown/'+ chart)
            },
        },
        computed: {
            ...mapState({
                //
            }),
            ...mapGetters({
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
            }),
        },
    };
</script>
