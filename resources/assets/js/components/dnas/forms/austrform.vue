<template>

    <v-row>
        <dna-method
            :options="austrmethods"
            :selectedmethod="austrselectedmethod"
            type="austr"
            :disabled="disabled">
        </dna-method>

        <date
            :value="request"
            :label="requestdatelabel"
            type="AustrRequestDate"
            :mdvalue="mdvalue"
            :smvalue="smvalue"
            :colval="colval"
            :textval="textval"
            :disabled="disabled">
        </date>

        <date
            :value="receive"
            :label="receivedatelabel"
            type="AustrReceiveDate"
            :mdvalue="mdvalue"
            :smvalue="smvalue"
            :colval="colval"
            :textval="textval"
            :disabled="disabled">
        </date>

        <results-status
            :options="statuses"
            :selectedstatus="austrstatus"
            type="austr"
            :disabled="disabled">
        </results-status>

        <seqnumber
            :sequencenum="seqNum"
            :label="seqnumberlabel"
            :disabled="disabled"
            type="austr"
            :mdvalue="mdvalue"
            :smvalue="smvalue"
            :colval="colval"
            :textval="'mt-3'">
        </seqnumber>

        <seqsubgroup
            :subgroup="austrsubgroup"
            :label="subgrouplabel"
            :disabled="disabled"
            type="austr"
            >
        </seqsubgroup>

        <seqsimilar
            :seqsimilar="austrseqsimilar"
            :label="seqsimilarlabel"
            type="austr"
            :disabled="disabled">
        </seqsimilar>

        <locinum
            :locinum="austrlocinum"
            type="austr"
            :disabled="disabled">
        </locinum>

        <loci
            :loci="austrloci"
            type="austr"
            :disabled="disabled">
        </loci>

        <date
            :value="austrmccdate"
            :label="mccdatelabel"
            type="AustrMccDate"
            :mdvalue="mdvalue"
            :smvalue="smvalue"
            :colval="colval"
            :textval="textval"
            :disabled="disabled">
        </date>

    </v-row>
</template>

<script>

    export default {
        name: "austrform",

        data: () => ({

            //models
            austrmethods: Object,
            statuses: Object,
            totalFields: 0,
            missingFields: 0,

            austrselectedmethod: '',
            request: '',
            receive: '',
            austrstatus: '',
            seqNum: '',
            austrsubgroup: '',
            austrseqsimilar: '',
            austrmccdate: '',
            austrloci: '',
            austrlocinum: '',


            //labels
            requestdatelabel: 'Request Date',
            receivedatelabel: 'Receive Date',
            seqnumberlabel: "auSTR Sequence Number",
            subgrouplabel: 'auSTR Sequence Subgroup',
            seqsimilarlabel: 'auSTR Sequence Similar',
            mccdatelabel: 'MCC Date',

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
            subgroup: '',
            seqsimilar: '',
            mccdate: '',
            loci: '',
            locinum: '',
            austrmethod: '',
            disabled: Boolean,
        },

        beforeMount() {
            this.austrmethods = this.methodoptions;
            this.austrselectedmethod = this.austrmethod;
            this.request = this.requestdate;
            this.receive = this.receivedate;
            this.statuses = this.statusoptions;
            this.austrstatus = this.selectedstatus;
            this.seqNum = this.sequencenum;
            this.austrsubgroup = this.subgroup;
            this.austrseqsimilar = this.seqsimilar;
            this.austrmccdate = this.mccdate;
            this.austrloci = this.loci;
            this.austrlocinum = this.locinum;
        },

    }
</script>

<style scoped>

</style>