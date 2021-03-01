/**
 * Analytics Components...
 */
Vue.component('dashboard-project-reports', require('./dashboardProjectReports').default);
Vue.component('dashboard-org-reports', require('./dashboardOrgReports').default);
Vue.component('dashboard-org-admin', require('./dashboardOrgAdmin').default);
Vue.component('dashboard-project', require('./dashboardProject').default);
Vue.component('dashboard-user', require('./dashboardUser').default);
Vue.component('dashboard-visualizations', require('./dashboardVisualizations').default);

// Dashboard Highlights Widgets
Vue.component('org-highlights-widget', require('./widgets/orgHighlightsWidget').default);
Vue.component('project-highlights-widget', require('./widgets/projectHighlightsWidget').default);

// Dashboard Widgets
Vue.component('map-widget', require('./widgets/mapWidget').default);
Vue.component('line-chart-widget', require('./widgets/lineChartWidget').default);
Vue.component('pie-chart-widget', require('./widgets/pieChartWidget').default);
Vue.component('bar-chart-widget', require('./widgets/barChartWidget').default);
Vue.component('stacked-bar-chart-widget', require('./widgets/stackedBarChartWidget').default);
Vue.component('table-widget', require('./widgets/tableWidget').default);
Vue.component('cabanatuan-widget', require('./widgets/cabanatuanWidget').default);
Vue.component('cabanatuan-details', require('./widgets/cabanatuanDetails').default);
Vue.component('cabanatuan', require('./widgets/cabanatuan').default); // This has been merged into cabanatuan-widget and can be deleted.

// Dashboard Components - need to get rid of these after refactoring
Vue.component('fullscreenpopup', require('./FullScreenPopUp').default);
Vue.component('dashboardtable', require('./DashboardTable').default);

// Drilldown Components
Vue.component('specimen-pie-chart', require('./drilldowns/specimenPieChart').default);
Vue.component('dna-pie-chart', require('./drilldowns/dnaPieChart').default);
Vue.component('specimen-bar-chart', require('./drilldowns/specimenBarChart').default);
Vue.component('specimen-stacked-chart', require('./drilldowns/specimenStackedChart').default);
Vue.component('specimen-user-activity', require('./drilldowns/specimenUserActivity').default);
Vue.component('dna-user-activity', require('./drilldowns/dnaUserActivity').default);

