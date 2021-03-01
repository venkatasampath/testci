// /**
//  * First we will load all of this project's JavaScript dependencies which
//  * includes Vue and other libraries. It is a great starting point when
//  * building robust, powerful web applications using Vue and Laravel.
//  */

window.Vue = require('vue');

window.Vuetify = require('vuetify');

import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-loader

Vue.use(Vuetify);

import VueCharts from 'vue-chartjs';
Vue.use(VueCharts);

Vue.component('app', require('./App.vue').default);
Vue.component('projectswitcher', require('./components/ProjectSwitcher.vue').default);
Vue.component('projectsearchbar', require('./components/ProjectSearchBar.vue').default);
Vue.component('specimensearchresults', require('./components/SpecimenSearchResults.vue').default);
Vue.component('dnasearchresults', require('./components/DNASearchResults.vue').default);
Vue.component('projectheader', require('./components/ProjectHeader.vue').default);
Vue.component('piechart', require('./components/PieChart.vue').default);
Vue.component('linechart', require('./components/LineChart.vue').default);
Vue.component('barchart', require('./components/BarChart.vue').default);
Vue.component('root', require('./components/Root_Manager.vue').default);
Vue.component('googlemap', require('./components/GoogleMap.vue').default);
Vue.component('datatable', require('./components/Datatable.vue').default);
Vue.component('datatable2', require('./components/Datatable2.vue').default);
Vue.component('stackedbarchart', require('./components/StackedBarChart.vue').default);
Vue.component('rootorgadmin', require('./components/Root_OrgAdmin.vue').default);
Vue.component('rootuser', require('./components/Root_User.vue').default);
Vue.component('notification', require('./components/Notification.vue').default);
Vue.component('coraheader', require('./components/layout/Header.vue').default);
Vue.component('corafooter', require('./components/layout/Footer.vue').default);
Vue.component('CoraContainer', require('./components/layout/Container.vue').default);
Vue.component('contentheader', require('./components/layout/ContentHeader.vue').default);
Vue.component('AccountTooltip', require('./components/layout/header/AccountTooltip.vue').default);
Vue.component('NotificationTooltip', require('./components/layout/header/NotificationTooltip.vue').default);
Vue.component('Accession', require('./components/specimens/Accession.vue').default);
Vue.component('Provenance1', require('./components/specimens/Provenance1.vue').default);
Vue.component('Provenance2', require('./components/specimens/Provenance2.vue').default);
Vue.component('Designator', require('./components/specimens/Designator.vue').default);
Vue.component('Bone', require('./components/specimens/Bone.vue').default);
Vue.component('Side', require('./components/specimens/Side.vue').default);
Vue.component('Completeness', require('./components/specimens/Completeness.vue').default);
Vue.component('taphonomy', require('./components/specimens/Taphonomy.vue').default);
Vue.component('Articulation', require('./components/specimens/Association/Articulation.vue').default);
Vue.component('individualnumber', require('./components/specimens/IndividualNumber.vue').default);
Vue.component('scanned', require('./components/specimens/3DScanned.vue').default);
Vue.component('ctscanned', require('./components/specimens/CTScanned.vue').default);
Vue.component('dnasampled', require('./components/specimens/DNASampled.vue').default);
Vue.component('inventorycompleted', require('./components/specimens/InventoryCompleted.vue').default);
Vue.component('isotopesampled', require('./components/specimens/IsotopeSampled.vue').default);
Vue.component('measured', require('./components/specimens/Measured.vue').default);
Vue.component('reviewed', require('./components/specimens/Reviewed.vue').default);
Vue.component('xrayscanned', require('./components/specimens/XrayScanned.vue').default);
Vue.component('clavicletriage', require('./components/specimens/ClavicleTriage.vue').default);
Vue.component('count', require('./components/specimens/Count.vue').default);
Vue.component('mass', require('./components/specimens/Mass.vue').default);
Vue.component('refits', require('./components/specimens/Association/Refits.vue').default);
Vue.component('morphology', require('./components/specimens/Association/Morphology.vue').default);
Vue.component('specimen', require('./components/specimens/Specimen.vue').default);
Vue.component('created-by', require('./components/specimens/CreatedBy.vue').default);
Vue.component('reviewed-by', require('./components/specimens/ReviewedBy.vue').default);
Vue.component('associations', require('./components/specimens/Associations.vue').default);
Vue.component('alert', require('./components/Alert.vue').default);
Vue.component('expansionpanel', require('./components/ExpansionPanel.vue').default);
Vue.component('file-import', require('./components/Import/fileImport.vue').default);

// Grouped components
Vue.component('anp1p2dn', require('./components/specimens/anp1p2dn.vue').default);
Vue.component('boneside', require('./components/specimens/boneside.vue').default);
Vue.component('indside', require('./components/specimens/indside.vue').default);
Vue.component('groupside',require('./components/specimens/groupside').default);

// Core Components
Vue.component('date',require('./components/CoreComponents/date').default);
Vue.component('savebtn',require('./components/CoreComponents/SaveBtn').default);

//DNA Elements
Vue.component('samplenumber', require('./components/dnas/SampleNumber').default);
Vue.component('sample-condition',require('./components/dnas/SampleCondition').default);
Vue.component('weight-sample-remaining',require('./components/dnas/WeightSampleRemaining').default);
Vue.component('disposition',require('./components/dnas/Disposition').default);
Vue.component('resamplingoption',require('./components/dnas/ResamplingOption').default);
Vue.component('dna-method',require('./components/dnas/dnamethod').default);
Vue.component('dna-tag',require('./components/dnas/DNA-Tag').default);
Vue.component('date',require('./components/CoreComponents/date').default);
Vue.component('count',require('./components/dnas/count').default);
Vue.component('popfrequency',require('./components/dnas/popfrequency').default);
Vue.component('count-frequency',require('./components/dnas/countvsfrequency').default);
Vue.component('loci',require('./components/dnas/loci').default);
Vue.component('locinum',require('./components/dnas/NumofLoci').default);
Vue.component('results-status',require('./components/dnas/ResultStatus').default);
Vue.component('regions',require('./components/dnas/regions').default);
Vue.component('basepairs',require('./components/dnas/basepairs').default);
Vue.component('haplogroup',require('./components/dnas/haplogroup').default);
Vue.component('seqnumber',require('./components/dnas/seqnum').default);
Vue.component('seqsimilar',require('./components/dnas/seqsimilar').default);
Vue.component('seqsubgroup',require('./components/dnas/seqsubgroup').default);
Vue.component('poly',require('./components/dnas/polymorphisms').default);
Vue.component('savebtn',require('./components/CoreComponents/SaveBtn').default);
Vue.component('externalcasenumber',require('./components/dnas/externalcasenumber').default);

//Forms under DNA
Vue.component('generalform',require('./components/dnas/forms/generalform').default);
Vue.component('mitoform',require('./components/dnas/forms/mitoform').default);
Vue.component('austrform',require('./components/dnas/forms/austrform').default);
Vue.component('ystrform',require('./components/dnas/forms/ystrform').default);
Vue.component('editdna',require('./components/dnas/forms/EditDNA').default);
Vue.component('createdna',require('./components/dnas/forms/CreateDNA').default);
Vue.component('sumform',require('./components/dnas/forms/sumform').default);

//Isotope Components
Vue.component('isotopesamplenumber', require('./components/specimens/isotope/IsotopeSampleNumber.vue').default);
Vue.component('Lab', require('./components/specimens/isotope/Lab.vue').default);
Vue.component('demineralizingstartdate', require('./components/specimens/isotope/DemineralizingStartDate.vue').default);
Vue.component('demineralizingsenddate', require('./components/specimens/isotope/DemineralizingEndDate.vue').default);
Vue.component('isotopetextfield', require('./components/specimens/commonvuetifycomponents/IsotopeTextField.vue').default);
Vue.component('isotopevautocomplete', require('./components/specimens/commonvuetifycomponents/IsotopeVAutoComplete.vue').default);
Vue.component('isotopeinformation', require('./components/specimens/isotope/IsotopeInformation.vue').default);
Vue.component('isotopecreate', require('./components/specimens/isotope/IsotopeCreate.vue').default);
Vue.component('isotopebasicinformation', require('./components/specimens/isotope/IsotopeBasicInformation.vue').default);
Vue.component('isotopeanalysisinformation', require('./components/specimens/isotope/IsotopeAnalysisInformation.vue').default);
Vue.component('isotopeweightinformation', require('./components/specimens/isotope/IsotopeWeightInformation.vue').default);
Vue.component('isotopecarboninformation', require('./components/specimens/isotope/IsotopeCarbonInformation.vue').default);
Vue.component('isotopenitrogeninformation', require('./components/specimens/isotope/IsotopeNitrogenInformation.vue').default);
Vue.component('isotopeoxygeninformation', require('./components/specimens/isotope/IsotopeOxygenInformation.vue').default);
Vue.component('isotopesulphurinformation', require('./components/specimens/isotope/IsotopeSulpherInformation.vue').default);
Vue.component('isotope', require('./components/specimens/isotope/Isotope.vue').default);
Vue.component('isotopeviewtable', require('./components/specimens/isotope/IsotopeViewTable.vue').default);

Vue.component('pairmatch', require('./components/specimens/PairMatch.vue').default);
Vue.component('toolbar1', require('./components/CoreComponents/toolbar1').default);
Vue.component('specimen-toolbar', require('./components/CoreComponents/SpecimenToolbar').default);

// Pathology Components
Vue.component('anomalies', require('./components/specimens/pathology/Anomalies.vue').default);
Vue.component('pathologies', require('./components/specimens/pathology/Pathologies.vue').default);
Vue.component('additionalinformation', require('./components/specimens/pathology/AdditionalInformation.vue').default);
Vue.component('trauma', require('./components/specimens/pathology/Trauma.vue').default);

// Core Components
Vue.component('toolbar',require('./components/CoreComponents/toolbar').default);

// Review Components
Vue.component('traumas', require('./components/specimens/pathology/Traumas').default);
Vue.component('taphonomys', require('./components/specimens/Taphonomys').default);

// Report Components
Vue.component('measurementreport',require('./components/reports/measurementReport').default);
Vue.component('zonereport',require('./components/reports/zoneReport').default);
Vue.component('articulationsreport',require('./components/reports/articulationReport').default);
Vue.component('methodsreport',require('./components/reports/methodsReport').default);
Vue.component('traumareport',require('./components/reports/traumaReport').default);
Vue.component('anomalyreport',require('./components/reports/anomalyReport').default);
Vue.component('pathologyreport',require('./components/reports/pathologyReport').default);

Vue.component('zonesearchtype',require('./components/specimens/zonesearchtype').default);
Vue.component('group',require('./components/specimens/group').default);
Vue.component('advanced-specimen-report', require('./components/reports/advancedSpecimenReport.vue').default);
Vue.component('advanced-specimen-report-result', require('./components/reports/advancedSpecimenReportResult.vue').default);
Vue.component('articulation-report-result', require('./components/reports/articulationReportResult.vue').default);
Vue.component('measurement-individual-number-report-result', require('./components/reports/measurementIndividualNumberReportResult.vue').default);
Vue.component('measurement-report-result', require('./components/reports/measurementReportResult.vue').default);
Vue.component('pathology-report-result', require('./components/reports/pathologyReportResult.vue').default);
Vue.component('trauma-report-result', require('./components/reports/traumaReportResult.vue').default);
Vue.component('anomalies-report-result', require('./components/reports/anomalyReportResult.vue').default);
Vue.component('methods-report-result', require('./components/reports/methodsReportResult.vue').default);
Vue.component('specimen-individual-report', require('./components/reports/specimenIndividualReport.vue').default);
Vue.component('specimen-individual-report-resut', require('./components/reports/specimenIndividualReportResult.vue').default);
Vue.component('individual-number-report-resut', require('./components/reports/IndividualNumberReportResult.vue').default);
Vue.component('isotope-report', require('./components/reports/isotopeReport').default);
Vue.component('isotope-report-result', require('./components/reports/isotopeReportResult').default);

Vue.component('zones-report-result', require('./components/reports/zoneReportResult.vue').default);

//Files
Vue.component('file-exports', require('./components/files/fileExport.vue').default);
Vue.component('file-manager', require('./components/files/fileManager.vue').default);
Vue.component('file-export-advanced', require('./components/files/fileExportAdvanced').default);
// Bootstrap Components
require('./components/bootstrap');

// Vuex State management related
const debug = process.env.NODE_ENV !== 'production';
Vue.config.productionTip = false;

import store from './store/index'
new Vue({
    el: '#vue-app',
    vuetify: new Vuetify(),
    theme: { disable: true },
    store: store,

    methods: {
        // switchproject(to) {
        //     alert("switchproject: Parent switch project to: " + to);
        //     return;
        //     let formProjectSwitch =  $("form.project-switch");
        //     $("input#currentProject", formProjectSwitch).val(to);
        //     formProjectSwitch.submit();
        // },
        //
        // executesearch(option, val) {
        //     alert("executesearch: Parent Search Go: " + option + " - " + val);
        //     return;
        //
        //     let formProjectSearch =  $("form.project-search");
        //     let option_results = option.split('-');
        //     let searchtype = option_results[0];
        //     $("input#searchby", formProjectSearch).val(option_results[1]);
        //     $("input#searchstring", formProjectSearch).val(val);
        //     // alert("Parent Search Go: " + option + " - " + val + "\n Options: " + option_results[0] + ' and ' + option_results[1]);
        //
        //     if (searchtype === 'DNA') {
        //         let url = formProjectSearch.attr('action');
        //         let new_url = url.replace("skeletalelements", "dnas");
        //         formProjectSearch.attr('action', new_url);
        //     }
        //     formProjectSearch.submit();
        // },
    },
});

// New stuff added by Sachin.
/*
 * confirmDelete: Asks the user for confirmation when a record is being deleted
 */
function confirmDelete() {
    var x = confirm("Are you sure you want to delete?");

    if (x) {
        return true;
    } else {
        return false;
    }
}

function confirmProjectChange() {
    var x = confirm("Are you sure you want to change your current project?");

    if (x) {
        return true;
    } else {
        return false;
    }
}

function confirmMsg(msg) {
    var x = confirm(msg);

    if (x) {
        return true;
    } else {
        return false;
    }
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function(){
    let table;
    if ( $.fn.dataTable.isDataTable( 'table.mav-datatable' ) ) {
        table = $('table.mav-datatable').DataTable();
    } else {
        table = $('table.mav-datatable').DataTable( {
            "columnDefs": [ {
                "targets"  : 'no-sort',
                "orderable": false
            }]
        });
    }
    $('.mav-select').select2();
    $("input[required]").parent("label").addClass("required");
});

function setPageLength(pagelength) {
    var oTableApi = $('table.mav-datatable').dataTable().api();
    oTableApi.page.len( pagelength ).draw();
}

function deleteConfirm() {
    var x = confirm("Are you sure you want to delete?");

    if (x) {
        return true;
    } else {
        return false;
    }
}