<template>

        <v-row>
            <dna-method
                :options="methods"
                :selectedmethod="ystrselectedmethod"
                type="ystr"
                :disabled="disabled">
            </dna-method>

            <date
                :value="request"
                :label="requestdatelabel"
                type="YstrRequestDate"
                :mdvalue="mdvalue"
                :smvalue="smvalue"
                :colval="colval"
                :textval="textval"
                :disabled="disabled">
            </date>

            <date
                :value="receive"
                :label="receivedatelabel"
                type="YstrReceiveDate"
                :mdvalue="mdvalue"
                :smvalue="smvalue"
                :colval="colval"
                :textval="textval"
                :disabled="disabled">
            </date>

            <results-status
                :options="statuses"
                :selectedstatus="ystrselectedstatus"
                type="ystr"
                :disabled="disabled">
            </results-status>

            <seqnumber
                :sequencenum="ystrsequencenum"
                :label="seqnumberlabel"
                :disabled="disabled"
                :type="'ystr'"
                :mdvalue="mdvalue"
                :smvalue="smvalue"
                :colval="colval"
                :textval="'mt-3'">
            </seqnumber>

            <seqsubgroup
                    :subgroup="ystrsubgroup"
                    :label="subgrouplabel"
                    type="ystr"
                    :disabled="disabled"
            >
            </seqsubgroup>

            <seqsimilar
                :seqsimilar="ystrseqsimilar"
                :label="seqsimilarlabel"
                :type="'ystr'"
                :disabled="disabled">
            </seqsimilar>

            <locinum
                :locinum="ystrlocinum"
                :type="'ystr'"
                :disabled="disabled">
            </locinum>

            <loci
                :loci="ystrloci"
                :type="'ystr'"
                :disabled="disabled">
            </loci>

            <count-frequency
                :popfrequency="ystrpopfrequency"
                :count="ystrcount"
                type="ystr"
                :disabled="disabled">
            </count-frequency>

            <haplogroup
                :options="ystrhaplos"
                :group="ystrselectedhaplogroup"
                :label="haplolabel"
                :disabled="disabled">
            </haplogroup>

            <date
                :value="ystrmccdate"
                :label="mccdatelabel"
                type="YstrMccDate"
                :mdvalue="mdvalue"
                :smvalue="smvalue"
                :colval="colval"
                :textval="textval"
                :disabled="disabled">
            </date>
        </v-row>

</template>

<script>
    import {changeObjectToArray} from "../../../coraBaseModules";

    export default {
        name: "ystrform",

        data: () => ({
            //models
            methods: Object,
            statuses: Object,
            ystrhaplos: [Object,Array],
            totalFields: 0,
            missingFields: 0,

            request: '',
            receive: '',
            ystrselectedstatus: '',
            ystrsequencenum: '',
            ystrseqsimilar: '',
            ystrmccdate: '',
            ystrloci: '',
            ystrlocinum: '',
            ystrcount: '',
            ystrselectedmethod: '',
            ystrselectedhaplogroup: '',
            ystrpopfrequency: '',


            //labels
            requestdatelabel: 'Request Date',
            receivedatelabel: 'Receive Date',
            seqnumberlabel: 'Y-STR Sequence Number',
            subgrouplabel: 'Y-STR Sequence Subgroup',
            seqsimilarlabel: 'Y-STR Sequence Similar',
            mccdatelabel: 'MCC Date',
            haplolabel: 'Y Haplogroup',

            mdvalue: 3,
            smvalue: 12,
            colval: "mt-5",
            textval:"mr-5"
        }),

        props: {
            //models
            methodoptions: Object,
            requestdate: '',
            receivedate: '',
            statusoptions: Object,
            selectedstatus: '',
            sequencenum: '',
            seqsimilar: '',
            mccdate: '',
            loci: '',
            haplooptions: [Object,Array],
            locinum: '',
            count: '',
            selectedmethod: '',
            selectedhaplogroup: '',
            popfrequency: '',
            disabled: Boolean,
            subgroup:''

        },

        beforeMount() {
            this.methods = this.methodoptions;
            this.request = this.requestdate;
            this.receive = this.receivedate;
            this.statuses = this.statusoptions;
            this.ystrselectedstatus = this.selectedstatus;
            this.ystrsequencenum = this.sequencenum;
            this.ystrseqsimilar = this.seqsimilar;
            this.ystrmccdate = this.mccdate;
            this.ystrloci = this.loci;
            this.ystrhaplos = this.haplooptions;
            this.ystrlocinum = this.locinum;
            this.ystrcount = this.count;
            this.ystrselectedmethod = this.selectedmethod;
            this.ystrselectedhaplogroup = this.selectedhaplogroup;
            this.ystrpopfrequency = this.popfrequency;
            this.ystrsubgroup = this.subgroup;
        },

        computed: {
            getTotalFields() {
                let data = changeObjectToArray(this.ystr);
                this.totalFields = data.length;
                return this.totalFields;
            },

            getMissingFields() {
                let data = changeObjectToArray(this.ystr);
                for (let value in data) {
                    if (value.indexOf(1) === 0) {
                        this.missingFields += 1;
                    }
                }
                return this.missingFields;
            }
        }
    }
</script>