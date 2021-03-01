<template>
    <div id="dashboard-org-admin" class="m-2">
        <contentheader :trail="trail" :title="theOrg.acronym + ' : ' + heading" model_name="dashboard-org-admin"
                       :collapse_all_menu="true" @eventCollapseAll="eventCollapseAllGo" @eventExpandAll="eventExpandAllGo"
                       :reset_dashboard_menu="true" @eventResetDashboard="resetWidgets"
                       :dashboard_menu="true">
        </contentheader>
        <org-highlights-widget></org-highlights-widget>
        <v-progress-linear v-if="loading" :indeterminate="loading"/>
        <draggable class="row px-2" v-model="widgets" group="widgets" @start="drag=true" @end="drag=false">
            <div v-if="widget.visible" :class="widgetWidth(widget)" v-for="(widget, index) in widgets" :key="index" class="m-0 p-0">
                <map-widget   :index="index" :type="widget.type" v-if="widget.type === 'projects_map' && projects" :default_items="projects"/>
                <table-widget :index="index" :type="widget.type" v-if="widget.type === 'specimen_summary' && specimen_summary" :default_items="specimen_summary"/>
                <table-widget :index="index" :type="widget.type" v-if="widget.type === 'dna_summary' && dna_summary" :default_items="dna_summary"/>
                <table-widget :index="index" :type="widget.type" v-if="widget.type === 'ua_specimens' && ua_specimens" :default_items="ua_specimens" @eventGenerate="generateDetails(widget.type)"/>
                <table-widget :index="index" :type="widget.type" v-if="widget.type === 'ua_dnas' && ua_dnas" :default_items="ua_dnas" @eventGenerate="generateDetails(widget.type)"/>
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
        name: "dashboard-org-admin",
        components: { draggable },
        props: {
            heading: { type: String, default: "Org Admin Dashboard" },
            widgetsList: { type: [Object, Array],
                default: () => ([
                    { type: 'projects_map', width: 12, visible: true, expanded: true },
                    { type: 'specimen_summary', width: 6, visible: true, expanded: true },
                    { type: 'dna_summary', width: 6, visible: true, expanded: true },
                    { type: 'ua_specimens', width: 6, visible: true, expanded: true },
                    { type: 'ua_dnas', width: 6, visible: true, expanded: true },
                ])},
        },
        data() {
            return {
                loading: false,
                key: 'dashboard-org-admin-widgets',
                isCollapseAll: false,
                trail: [{text: 'Home', disabled: false, href: '/',}, {text: 'Dashboard', disabled: true, href: '/dashboard'}, ],

                // Widgets and Draggable
                widgets:    localStorage.getItem("dashboard-org-admin-widgets") ?
                    JSON.parse(localStorage.getItem("dashboard-org-admin-widgets")) :
                    this.widgetsList,

                urls: {
                    all: "/api/dashboard/users/allprojectsummary?by=all", // gets projects, specimens and dnas
                    // below urls not used.
                    specimen: "/api/dashboard/users/allprojectsummary?by=specimen",
                    dna: "/api/dashboard/users/allprojectsummary?by=dna",
                    ua_all: "/api/dashboard/projects/activity?by=all&top=10&forUser=true",
                    ua_specimens: "/api/dashboard/projects/activity?by=specimen&top=10&forUser=true",
                    ua_dnas: "/api/dashboard/projects/activity?by=dna&top=10&forUser=true",
                },
                summary_data: null,
                ua_data: null,
                projects: null,
                specimen_summary: null,
                dna_summary: null,
                ua_specimens: null,
                ua_dnas: null,
            };
        },
        created() {
            eventBus.$on('dashboard-widget-event', payload => {
                console.log("dashboard-widget-event reveived: with payload " + JSON.stringify(payload) )
                this.widgets[payload.index].visible = payload.visible;
                this.widgets[payload.index].expanded = payload.expanded;
            });

            this.getWidgetsData();
        },
        mounted(){
            //
        },
        watch: {
            widgets: {
                deep: true,
                handler(list) {
                    localStorage.setItem("dashboard-org-admin-widgets", JSON.stringify(list));
                }
            },
        },
        methods: {
            getWidgetsData: function () {
                this.loading = true;
                // One call to get the projects, specimens and dnas data
                axios
                    .request({ url: this.urls.all, method: 'GET',
                        headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken },
                    })
                    .then(response => {
                        this.summary_data = response.data.data;
                        this.projects = response.data.data.projects;
                        this.specimen_summary = response.data.data.specimens;
                        this.dna_summary = response.data.data.dnas;
                        this.loading = false;
                    })
                // Second call to get the ua_specimens and ua_dnas data
                axios
                    .request({ url: this.urls.ua_all, method: 'GET',
                        headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken },
                    })
                    .then(response => {
                        this.ua_data = response.data.data;
                        this.ua_specimens = response.data.data.specimens;
                        this.ua_dnas = response.data.data.dnas;
                        for (let i=0;i<this.ua_specimens.length;++i) {
                            this.ua_specimens[i]['key'] = this.ua_specimens[i].accession_number+':'+this.ua_specimens[i].provenance1+':'
                                +this.ua_specimens[i].provenance2+':'+this.ua_specimens[i].designator;
                        }
                        for (let i=0;i<this.ua_dnas.length;++i) {
                            this.ua_dnas[i]['key'] = this.ua_dnas[i].accession_number+':'+this.ua_dnas[i].provenance1+':'
                                +this.ua_dnas[i].provenance2+':'+this.ua_dnas[i].designator;
                        }

                        this.loading = false;
                    })
            },
            widgetWidth(item) {
                return (item.width===12) ? 'col-12': (item.width===6) ? 'col-6': (item.width===4) ? 'col-4': (item.width===3) ? 'col-3': 'col-2';
            },
            resetWidgets() {
                this.$delete(this.widgets, {});
                this.widgetsList.forEach((widget, key) => {
                    // widget.visible = true;
                    // widget.expanded = true;
                    this.$set(this.widgets, key, widget);
                });
                localStorage.setItem("dashboard-org-admin-widgets", JSON.stringify(this.widgets));
            },
            eventCollapseAllGo(model, val) {
                console.log('DashboardOrgAdmin eventCollapseAllGo - captured event: ' + model);
                if (model === "dashboard-org-admin") {
                    this.toggleCollapseAll();
                }
            },
            eventExpandAllGo(model, val) {
                console.log('DashboardOrgAdmin eventExpandAllGo - captured event: ' + model);
                if (model === "dashboard-org-admin") {
                    this.toggleCollapseAll();
                }
            },
            toggleCollapseAll() {
                console.log('DashboardOrgAdmin toggleCollapseAll - captured event: ');
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
