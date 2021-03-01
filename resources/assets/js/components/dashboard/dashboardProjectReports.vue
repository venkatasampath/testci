<template>
    <div :id="key" class="m-2">
        <contentheader :trail="trail" :title="heading" :model_name="key"
                       :collapse_all_menu="true" @eventCollapseAll="eventCollapseAllGo" @eventExpandAll="eventExpandAllGo"
                       :reset_dashboard_menu="true" @eventResetDashboard="resetReports">
        </contentheader>
        <draggable class="row m-0 p-0" v-model="reports" group="reports" @start="drag=true" @end="drag=false">
            <v-card class="col-md-6 mb-3 m-0 p-2" v-for="(report, key) in reports" :key="key" v-if="report.visible">
                <v-card-title class="mt-0 p-0" outlined flat tile>
                    <v-toolbar dense>
                        <v-toolbar-title>{{ report.name }}</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn title="Go" icon color="primary" @click="goToReport(report.url)"
                               :dusk="report.type"><v-icon>mdi-play</v-icon></v-btn>
                        <v-btn :title="!report.expanded ? 'Collapse' : 'Expand'" icon color="primary" @click="report.expanded = !report.expanded">
                            <v-icon>{{ report.expanded ? 'mdi-arrow-collapse-up' : 'mdi-arrow-expand-down' }}</v-icon>
                        </v-btn>
                        <v-btn title="Close" icon color="primary" @click="report.visible = false"><v-icon>mdi-close</v-icon></v-btn>
                    </v-toolbar>
                </v-card-title>
                <v-card-text class="m-0 p-3" v-if="report.expanded">
                    <div>{{ report.description }}</div>
                    <img :src="`/storage/images/reports/${report.type}.png`" :alt="report.name" class="img-fluid mt-2"/>
                </v-card-text>
            </v-card>
        </draggable>
    </div>
</template>

<script>
    import draggable from "vuedraggable";
    import {mapGetters, mapState} from "vuex";

    export default {
        name: "dashboard-project-reports",
        components: { draggable },
        props: {
            heading: { type: String, default: "Project Reports Dashboard" },
            reportsList: { type: [Object, Array],
                default: () => ([
                    { type: 'dna_mito', width: 6, visible: true, expanded: true, name: 'DNA Mito Report', tags: 'DNA, mito, mtDNA',
                        url: '/reports/mtdna', description: 'This will allow you to report by mitochondrial DNA.',},
                    { type: 'dna_ystr', width: 6, visible: true, expanded: true, name: 'DNA Ystr Report', tags: 'DNA, ystr, ystrDNA',
                        url: '/reports/ystrdna',  description: 'This will allow you to report by Ystr DNA.', },
                    { type: 'dna_austr', width: 6, visible: true, expanded: true, name: 'DNA Austr Report', tags: 'DNA, austr, autoDNA',
                        url: '/reports/austrdna',  description: 'This will allow you to report by AuStr DNA.', },
                    { type: 'zones', width: 6, visible: true, expanded: true, name: 'Zones Report', tags: 'Specimens, Zones',
                        url: '/reports/zones',  description: 'This will allow you to report by zones', },
                    { type: 'measurements', width: 6, visible: true, expanded: true, name: 'Measurements Report', tags: 'Specimens, Measurements',
                        url: '/reports/measurements',  description: 'This will allow you to report by measurements', },
                    { type: 'methods', width: 6, visible: true, expanded: true, name: 'Methods Report', tags: 'Specimens, Methods, Age, Sex, Ancestry, Stature',
                        url: '/reports/methods',  description: 'This will allow you to report by methods, feature scores, etc', },
                    { type: 'articulations', width: 6, visible: true, expanded: true, name: 'Articulations Report', tags: 'Specimens, Articulations',
                        url: '/reports/articulation',  description: 'This will allow you to report by articulations.', },
                    { type: 'pathologys', width: 6, visible: true, expanded: true, name: 'Pathology Report', tags: 'Specimens, Pathology',
                        url: '/reports/pathologys',  description: 'This will allow you to report by pathologies.', },
                    { type: 'anomalys', width: 6, visible: true, expanded: true, name: 'Anomaly Report', tags: 'Specimens, Anomaly',
                        url: '/reports/anomalys',  description: 'This will allow you to report by anomalies.', },
                    { type: 'traumas', width: 6, visible: true, expanded: true, name: 'Trauma Report', tags: 'Specimens, Trauma',
                        url: '/reports/traumas',  description: 'This will allow you to report by traumas.', },
                    { type: 'individual_number', width: 6, visible: true, expanded: true, name: 'Individual Number Report', tags: 'Specimens, Individual Number',
                        url: '/reports/individualnumber',  description: 'This will allow you to view all individual numbers and related specimen counts', },
                    { type: 'specimens_by_individual_number', width: 6, visible: true, expanded: true, name: 'Specimens By Individual Number Report', tags: 'Specimens, Individual Number',
                        url: '/reports/individualnumberdetails',  description: 'This will allow you to create reports on specimens by individual number.', },
                    { type: 'advanced_specimen', width: 6, visible: true, expanded: true, name: 'Advanced Specimen Report', tags: 'Specimens',
                        url: '/reports/advanced',  description: 'This will allow you to report specimens using advanced search criteria.', },
                    { type: 'isotopes', width: 6, visible: true, expanded: true, name: 'Isotopes Report', tags: 'Specimens, Isotopes',
                        url: '/reports/isotopes',  description: 'This will allow you to report by isotopes.', },
                    { type: 'secomparisons', width: 6, visible: true, expanded: true, name: 'Specimen Comparison Report', tags: 'Specimens, Comparison',
                        url: '/reports/secomparisons',  description: 'This will allow you to compare multiple specimens side by side (up to 4 specimens).', },
                ])},
        },
        data() {
            return {
                key: "project-reports-dashboard",
                collapsed: true,
                trail: [{text: 'Home', disabled: false, href: '/',}, {text: 'Project Reports Dashboard', disabled: true, href: '/reports/project/dashboard'}, ],
                reports: null,
            };
        },
        created() {
            // Setup Reports Widgets and Draggable and localStorage key
            this.key = "project-" + this.theProject.id + "-reports-dashboard";
            this.reports = localStorage.getItem(this.key) ? JSON.parse(localStorage.getItem(this.key)) : this.reportsList;
        },
        mounted() {
            //
        },
        watch: {
            reports: {
                deep: true,
                handler(list) {
                    localStorage.setItem(this.key, JSON.stringify(list));
                }
            }
        },
        methods: {
            goToReport(url) {
                console.log("Reoprt url: " + url);
                window.location = url;
            },
            resetReports() {
                this.$delete(this.reports, {});
                this.reportsList.forEach((report, key) => {
                    report.visible = true;
                    report.expanded = true;
                    this.$set(this.reports, key, report);
                });

                this.collapsed = true;
                localStorage.setItem(this.key, JSON.stringify(this.reports));
            },
            eventCollapseAllGo(model, val) {
                console.log('DashboardReports eventCollapseAllGo - captured event: ' + model);
                if (model === "reports-dashboard") {
                    this.toggleCollapse();
                }
            },
            eventExpandAllGo(model, val) {
                console.log('DashboardReports eventExpandAllGo - captured event: ' + model);
                if (model === "reports-dashboard") {
                    this.toggleCollapse();
                }
            },
            toggleCollapse() {
                this.collapsed = !this.collapsed;
                this.reports.map(report => {
                    report.expanded = this.collapsed;
                    return report;
                });
            },
            // getReports() {
            //     if (localStorage.getItem("reports")) {
            //         return JSON.parse(localStorage.getItem("reports"));
            //     }
            //
            //     const reports = [];
            //     this.reportsList.forEach((report, key) => {
            //         reports.push({ key, ...report, visible: true, expanded: true });
            //     });
            //
            //     return reports;
            // }
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
