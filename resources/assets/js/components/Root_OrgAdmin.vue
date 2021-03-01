<template>
    <div>
        <subHeader :widgetList="widgetList" v-if="IsPanelVisible === true" id="subHeader" :IsPanelVisible="IsPanelVisible" @clicked="onClickClose"></subHeader>
        <widgetsRow_Col4 :widgetList="widgetList"></widgetsRow_Col4>
        <widgetsRow_Col3 :widgetList="widgetList"></widgetsRow_Col3>
        <widgetsRow_Col6 :widgetList="widgetList"></widgetsRow_Col6>
        <widgetsRow_Col12 :widgetList="widgetList"></widgetsRow_Col12>

    </div>
</template>
<script>
    import subHeader from './subHeader.vue'
    import widgetsRow_Col12 from './widgetsRow_Col12.vue'
    import widgetsRow_Col4 from './widgetsRow_Col4.vue'
    import widgetsRow_Col6 from './widgetsRow_Col6.vue'
    import widgetsRow_Col3 from './widgetsRow_Col3.vue'
    import Widget from '../Widget_Model'
    export default {
        props: {
            projectDetails: Array,
            SeSummaryRecord: Array,
            DnaSummaryRecord: Array,
            IsPanelVisible: false
        },
        name: 'app',
        data() {
            return{
                /* (id, name, size, visible, type, dataValues, dataList, chartLabels, chartColors, chartType, datasetLabel, chartHelp, dataType, updatedDatetime, chartstyle)*/
                widgetList:[
                    new Widget(100,'Project Map',6,true,'Map', this.projectDetails, null, null, null, null, null, 'No help text has been provided.', null, null, "margin-bottom: 10px; height: 400px;"),
                    new Widget(101,'DNA Summary',6,true,'Table', this.DnaSummaryRecord, null, ['Name','Specimen Total','Sampled','Results Rec','Reportable','Mito Seq'], null, null, ['projectName','se_total','num_sampled','num_results_received','num_results_reportable','num_mito_sequences'], 'No help text has been provided.', null, null, "margin-bottom: 10px;"),
                    new Widget(102,'Specimen Summary',12,true,'Table',this.SeSummaryRecord, null, ['Name','Specimen Total','Complete','Measured','Isotope','CT','X-Ray','Clavicle','Inventoried','Reviewed','SE with Ind','Unique Ind'], null, null, ['projectName','se_total','num_complete','num_measured','num_isotope_sampled','num_ct_scanned','num_xray_scanned','num_clavicle_triage','num_inventoried', 'num_reviewed','num_individuals','num_unique_individuals'], 'No help text has been provided.', null, null, "margin-bottom: 10px"),
                ]
            }
        },
        components: {
            'subHeader': subHeader,
            'widgetsRow_Col6': widgetsRow_Col6,
            'widgetsRow_Col4': widgetsRow_Col4,
            'widgetsRow_Col3': widgetsRow_Col3,
            'widgetsRow_Col12': widgetsRow_Col12
        },
        methods: {
            onClickClose (value) {
                this.IsPanelVisible = value
            }
        }
    }
</script>

<style>
    .text-center {
        text-align: center;
    }
    #subHeader {
        position:absolute;
        right: 0;
        z-index: 1000;
        background-color: lightgrey;
        width: 100%;
    }
</style>