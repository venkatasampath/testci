/**
 * Reports Components...
 */

// Organization Report Components
Vue.component('org-dna-report', require('./orgs/orgDnaReport').default);
Vue.component('org-dna-report-result', require('./orgs/orgDnaReportResult').default);
Vue.component('org-user-report', require('./orgs/orgUserReport').default);
Vue.component('org-isotopes-report', require('./orgs/orgIsotopesReport').default);
Vue.component('org-individual-number-details-report', require('./orgs/orgIndividualNumberDetailsReport').default);

// Project Report Components
Vue.component('project-dna-report', require('./projects/projectDnaReport').default);
Vue.component('project-dna-report-result', require('./projects/projectDnaReportResult').default);
Vue.component('project-individual-number-details-report', require('./projects/projectIndividualNumberDetailsReport').default);
Vue.component('project-articulation-report', require('./projects/projectArticulationReport').default);
Vue.component('se-comparison-report', require('./projects/seComparisonReport').default);
Vue.component('se-comparison-report-result', require('./projects/seComparisonReportResult').default);
Vue.component('project-method-report', require('./projects/projectMethodReport').default);
Vue.component('project-isotope-report', require('./projects/projectIsotopeReport').default);
Vue.component('project-individual-number-report', require('./projects/projectIndividualNumberReport').default);
Vue.component('project-trauma-report', require('./projects/projectTraumaReport').default);
Vue.component('project-measurement-report', require('./projects/projectMeasurementReport').default);
Vue.component('project-anomaly-report', require('./projects/projectAnomalyReport').default);
Vue.component('project-pathology-report', require('./projects/projectPathologyReport').default);
Vue.component('project-advanced-specimen-report', require('./projects/projectAdvancedSpecimenReport').default);
Vue.component('project-zone-report', require('./projects/projectZoneReport').default);
Vue.component('bone-group-report', require('./boneGroupResult').default);


