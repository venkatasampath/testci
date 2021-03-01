<template>
    <div style="margin-top: 5px">
        <subHeader :widgetList="widgetList" v-if="IsPanelVisible === true" id="subHeader" :IsPanelVisible="IsPanelVisible" @clicked="onClickClose"></subHeader>
        <projectheader style="margin-bottom:5px" v-bind:slot1= "'Specimens: '+SkeletalElementsCount"
                       v-bind:slot2= "'Accessions: '+AccessionsCount"
                       v-bind:slot3= "'Provenance1: '+Provenance1Count"
                       v-bind:slot4= "'Provenance2: '+Provenance2Count"
                       v-bind:slot5= "'Bone Groups: '+BoneGroupCount"
                       v-bind:slot6= "'Unique Individuals: '+LatestSummaryRecord.num_unique_individuals">
        </projectheader>

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
            projectData: Object,
            LatestSummaryRecord: Object,
            LatestDnaSummaryRecord: Object,
            SkeletalElementsCount: Number,
            AccessionsCount: Number,
            Provenance1Count: Number,
            Provenance2Count: Number,
            BoneGroupCount: Number,
            mitoSequenceArray: Array,
            mitoSequenceLabels: Array,
            mniBoneArray: Array,
            mniBoneLabels: Array,
            mniZoneArray: Array,
            mniZoneLabels: Array,
            inventoryLabels: Array,
            inventoryData: Array,
            fullListMito:Array,
            fullListBone:Array,
            fullListZone:Array,
            mitoSequences: Array,
            mniBones: Array,
            mniZones: Array,
            mniZoneLabelsStacked: Array,
            SeDateFormatted: String,
            DnaDateFormatted: String,
            CurrentDateFormatted: String,
            UserSeActivity: Array,
            UserDnaActivity: Array,
            IsPanelVisible: false
        },
        name: 'app',
        data() {
            return{
                /* (id, name, size, visible, type, dataValues, dataList, chartLabels, chartColors, chartType, datasetLabel, chartHelp, dataType, cardStyle)*/
                widgetList:[
                    new Widget(1,'Complete: '+this.LatestSummaryRecord.num_complete,4,true,'Pie', [this.LatestSummaryRecord.se_total - this.LatestSummaryRecord.num_complete, this.LatestSummaryRecord.num_complete],null,  ['Incomplete', 'Complete'], ['#05909D', '#42C088'], null, null, 'Number of complete skeletal elements in the current project.', null, this.SeDateFormatted, "margin-bottom: 10px;"),
                    new Widget(2,'Specimens Assoc. To Individual #: '+this.LatestSummaryRecord.num_individuals,4,true,'Pie', [this.LatestSummaryRecord.se_total - this.LatestSummaryRecord.num_individuals, this.LatestSummaryRecord.num_individuals], null, ['Unassociated', 'Associated'], ['#F94050','#F19A40'], null, null, 'Number of skeletal elements associated to an individual number.', null, this.SeDateFormatted,"margin-bottom: 10px;"),
                    new Widget(3,'DNA Sampled: '+this.LatestDnaSummaryRecord.num_sampled,4,true,'Pie', [this.LatestDnaSummaryRecord.num_sampled - this.LatestDnaSummaryRecord.num_results_received, this.LatestDnaSummaryRecord.num_results_reportable, this.LatestDnaSummaryRecord.num_results_inconclusive, this.LatestDnaSummaryRecord.num_results_unable_to_assign, this.LatestDnaSummaryRecord.num_results_cancelled ], null, ['Pending', 'Reportable', 'Inconclusive', 'Unable to Assign', 'Cancelled'], ['#F19A40', '#05909D', '#42C088','#F94050', '#F3F064'], null, null, 'Number of skeletal elements sampled for DNA analysis.', null, this.DnaDateFormatted, "margin-bottom: 10px;"),
                    new Widget(8,'Measured: '+this.LatestSummaryRecord.num_measured,4,false,'Pie', [this.LatestSummaryRecord.se_total - this.LatestSummaryRecord.num_measured, this.LatestSummaryRecord.num_measured], null, ['Not Measured', 'Measured'], ['#42C088', '#F3F064'], null, null, 'Number of skeletal elements that have been measured.', null, this.SeDateFormatted, "margin-bottom: 10px;"),
                    new Widget(9,'CT Scan: '+this.LatestSummaryRecord.num_ct_scanned,4,false,'Pie', [this.LatestSummaryRecord.se_total - this.LatestSummaryRecord.num_ct_scanned, this.LatestSummaryRecord.num_ct_scanned], null, ['Not Scanned', 'Scanned'], ['#05909D', '#F3F064'], null, null, 'Number of skeletal elements that have been CT scanned.', null, this.SeDateFormatted, "margin-bottom: 10px;"),
                    new Widget(10,'X-Ray: '+this.LatestSummaryRecord.num_xray_scanned,4,false,'Pie', [this.LatestSummaryRecord.se_total - this.LatestSummaryRecord.num_xray_scanned, this.LatestSummaryRecord.num_xray_scanned], null, ['Not X-Rayed', 'X-Rayed'], ['#05909D', '#42C088'], null, null, 'Number of skeletal elements that have been Xrayed.', null, this.SeDateFormatted, "margin-bottom: 10px;"),
                    new Widget(11,'Clavicle Triage: '+this.LatestSummaryRecord.num_clavicle_triage,4,false,'Pie', [this.LatestSummaryRecord.num_clavicle - this.LatestSummaryRecord.num_clavicle_triage, this.LatestSummaryRecord.num_clavicle_triage], null, ['Not Triaged', 'Triaged'], ['#F19A40', '#42C088'], null, null, 'Number of clavicles that have been triaged for future CXR analysis.', null,this.SeDateFormatted,"margin-bottom: 10px;"),
                    new Widget(12,'Isotope Sampled: '+this.LatestSummaryRecord.num_isotope_sampled,4,false,'Pie', [this.LatestSummaryRecord.se_total - this.LatestSummaryRecord.num_isotope_sampled, this.LatestSummaryRecord.num_isotope_sampled], null, ['Not Sampled', 'Sampled'], ['#F94050', '#F3F064'], null, null, 'Number of skeletal elements that have been sampled for isotope analysis.', null, this.SeDateFormatted, "margin-bottom: 10px;"),
                    new Widget(4,'Mito Sequences',4,false, 'Bar', this.mitoSequenceArray, null, this.mitoSequenceLabels, ['#F19A40', '#F19A40', '#F19A40', '#F19A40', '#F19A40'], 'horizontalBar', 'Mito', 'Number of unique mitochondrial DNA sequences, with the total number of skeletal elements per sequence to indicate the sequence with the most skeletal elements.',  null, this.CurrentDateFormatted, "margin-bottom: 10px;"),
                    new Widget(5,'MNI Bones',4,false,'Bar', this.mniBoneArray, null, this.mniBoneLabels, ['#05909D', '#05909D', '#05909D', '#05909D', '#05909D'], 'horizontalBar', 'MNI Bones', 'The number of individual specimens (NISP) by bone is shown to indicate the most represented skeletal element in the project, regardless of side. Each skeletal element shows the total number by side to estimate the minimum number of individuals (MNI) in the project by bone.', null, this.CurrentDateFormatted, "margin-bottom: 10px;"),
                    new Widget(6,'MNI Zones',4,false,'Bar', this.mniZoneArray, null, this.mniZoneLabels, ['#42C088', '#42C088', '#42C088', '#42C088', '#42C088'], 'horizontalBar', 'MNI Zones', 'The number of individual specimens (NISP) by zone indicates the most represented zone in the project, regardless of side. Each zone shows the total number by side to estimate the minimum number of individuals (MNI) in the project by zone.', null, this.CurrentDateFormatted, "margin-bottom: 10px;"),
                    new Widget(13,'MNI Bones & Side',4,false,'StackedBar', this.mniBones, this.fullListBone, this.mniBoneLabels, null, 'bar', null, 'The number of individual specimens (NISP) by bone is shown to indicate the most represented skeletal element in the project, regardless of side. Each skeletal element shows the total number by side to estimate the minimum number of individuals (MNI) in the project by bone. This view is further described by side.', 'MNIBone', this.CurrentDateFormatted, "margin-bottom: 10px;"),
                    new Widget(14,'MNI Zones & Side',4,false,'StackedBar', this.mniZones, this.fullListZone, this.mniZoneLabelsStacked, null, 'bar', null, 'The number of individual specimens (NISP) by zone indicates the most represented zone in the project, regardless of side. Each zone shows the total number by side to estimate the minimum number of individuals (MNI) in the project by zone. This view is further described by side.', 'MNIZone', this.CurrentDateFormatted, "margin-bottom: 10px;"),
                    new Widget(15,'Mito Bones & Side',4,false,'StackedBar',this.mitoSequences, this.fullListMito, this.mitoSequenceLabels, null, 'bar', null, 'Number of unique mitochondrial DNA sequences, with the total number of skeletal elements per sequence to indicate the sequence with the most skeletal elements. This view is further described by side and bone.', 'MitoBone', this.CurrentDateFormatted, "margin-bottom: 10px;"),
                    new Widget(7,'Inventory',12,false,'Line', this.inventoryData, null, this.inventoryLabels, null, null, null, null, 'No help text has been provided.', this.SeDateFormatted, "margin-bottom: 10px;"),
                    new Widget(16,'User Activity: Specimens',6,true,'Table', this.UserSeActivity, null, ['Key', 'Name', 'Side', 'Completeness', 'Updated At'], null, null,['skeletalElementsKey', 'name', 'side', 'completeness', 'updated_at'], 'No help text has been provided.', null, null, "margin-bottom: 10px;"),
                    new Widget(17,'User Activity: DNA',6,true,'Table', this.UserDnaActivity, null, ['Key', 'Mito Sequence Number', 'Mito Sequence Subgroup', 'Updated At' ], null, null,['skeletalElementsKey', 'mito_sequence_number', 'mito_sequence_subgroup', 'updated_at'], 'No help text has been provided.', null, null, "margin-bottom: 10px;")
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