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

    export default {
        name: "dashboard-org-reports",
        components: { draggable },
        props: {
            heading: { type: String, default: "Org Reports Dashboard" },
            reportsList: { type: [Object, Array],
                default: () => ([
                    { type: 'dna_mito', width: 6, visible: true, expanded: true, name: 'DNA Mito Report', tags: 'DNA, mito, mtDNA',
                        url: '/reports/org/dna/mito',  description: 'This will allow you to report by mitochondrial DNA.', },
                    { type: 'dna_ystr', width: 6, visible: true, expanded: true, name: 'DNA Ystr Report', tags: 'DNA, ystr, ystrDNA',
                        url: '/reports/org/dna/ystr',  description: 'This will allow you to report by YStr DNA.', },
                    { type: 'dna_austr', width: 6, visible: true, expanded: true, name: 'DNA Austr Report', tags: 'DNA, austr, autoDNA',
                        url: '/reports/org/dna/austr',  description: 'This will allow you to report by AuStr DNA.', },
                    { type: 'UserReport', width: 6, visible: true, expanded: true, name: 'User Report', tags: 'UserReport',
                        url: '/reports/org/user',  description: 'This will allow you to report User Activities', },
                  { type: 'isotopes', width: 6, visible: true, expanded: true, name: 'Isotopes Report', tags: 'isotopes',
                    url: '/reports/org/isotopes',  description: 'This will allow you to report by Isotopes.', },
                  { type: 'individual_number_details', width: 6, visible: true, expanded: true, name: 'Specimen by Individual Number Details Report', tags: 'specimen',
                    url: '/reports/org/individual/number/details',  description: 'This will allow you to report specimen details by Individual Number.', },
                ])},
        },
        data() {
            return {
                key: "org-reports-dashboard",
                collapsed: true,
                trail: [{text: 'Home', disabled: false, href: '/',}, {text: 'Org Reports Dashboard', disabled: true, href: '/reports/org/dashboard'}, ],
                reports: null,
            };
        },
        created() {
            // Reports Widgets and Draggable
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
                if (model === this.key) {
                    this.toggleCollapse();
                }
            },
            eventExpandAllGo(model, val) {
                console.log('DashboardReports eventExpandAllGo - captured event: ' + model);
                if (model === this.key) {
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
        },
    };
</script>
