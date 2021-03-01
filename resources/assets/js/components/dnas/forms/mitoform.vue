<template>

    <v-container fluid>
        <v-row>

                <dna-method
                    :options="methods"
                    :selectedmethod="mitoselectedmethod"
                    type="mito"
                    :disabled="disabled">
                </dna-method>


                <date
                    :value="request"
                    :label="requestdatelabel"
                    type="MitoRequestDate"
                    :mdvalue="mdvalue"
                    :smvalue="smvalue"
                    :colval="colval"
                    :textval="textval"
                    :disabled="disabled">
                </date>


                <date
                    :value="receive"
                    :label="receivedatelabel"
                    type="MitoReceiveDate"
                    :mdvalue="mdvalue"
                    :smvalue="smvalue"
                    :colval="colval"
                    :textval="textval"
                    :disabled="disabled">
                </date>


                <results-status
                    :options="statuses"
                    :selectedstatus="status"
                    type="mito"
                    :disabled="disabled">
                </results-status>


                <seqnumber
                    :sequencenum="seqNum"
                    :label="seqnumberlabel"
                    :disabled="disabled"
                    :type="'mito'"
                    :mdvalue="mdvalue"
                    :smvalue="smvalue"
                    :colval="colval"
                    :textval="'mt-3'">
                </seqnumber>


                <seqsubgroup
                    :subgroup="mitosubgroup"
                    :label="subgrouplabel"
                    type="mito"
                    :disabled="disabled"
                    >
                </seqsubgroup>


                <seqsimilar
                    :seqsimilar="mitoseqsimilar"
                    :label="seqsimilarlabel"
                    type="mito"
                    :disabled="disabled">
                </seqsimilar>


                <basepairs
                    :basepairs="mitobasepairs"
                    :disabled="disabled">
                </basepairs>


                <count-frequency
                    :popfrequency="mitopopfrequency"
                    :count="mitocount"
                    type="mito"
                    :disabled="disabled">
                </count-frequency>

                <regions
                    :region="mitoregion"
                    :disabled="disabled">
                </regions>


                <poly
                    :poly="mitopoly"
                    :label="polylabel"
                    :disabled="disabled">
                </poly>


                <haplogroup
                    :options="haplos"
                    :group="mitohaplogroup"
                    :label="haplolabel"
                    :disabled="disabled">
                </haplogroup>


                <date
                    :value="mitomccdate"
                    :label="mccdatelabel"
                    type="MitoMccDate"
                    :mdvalue="mdvalue"
                    :smvalue="smvalue"
                    :colval="colval"
                    :textval="textval"
                    :disabled="disabled">
                </date>

        </v-row>
    </v-container>
</template>

<script>
    import {changeObjectToArray, bus} from "../../../coraBaseModules";

    export default {
        name: "mitoform",

        data: () => ({

            methods: Object,
            statuses: Object,
            haplos: Object,
            totalFields: 0,
            missingFields: 0,

            mitoselectedmethod: '',
            request: '',
            receive: '',
            status: '',
            seqNum: '',
            mitosubgroup: '',
            mitoseqsimilar: '',
            mitobasepairs: '',
            mitoregion: '',
            mitopoly: '',
            mitomccdate: '',
            mitocount: '',
            mitopopfrequency: '',
            mitohaplogroup: '',

            //labels
            requestdatelabel: 'Request Date',
            receivedatelabel: 'Receive Date',
            seqnumberlabel: "Mito Sequence Number",
            subgrouplabel: 'Mito Sequence Subgroup',
            seqsimilarlabel: 'Mito Sequence Similar',
            polylabel: 'Mito Polymorphisims',
            haplolabel: 'Mito Haplogroup',
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
            basepairs: '',
            region: '',
            poly: '',
            haplooptions: Object,
            mccdate: '',
            count: '',
            popfrequency: '',
            selectedmethod: '',
            haplogroup: '',
            disabled: Boolean,
        },

        beforeMount() {
            this.methods = this.methodoptions;
            this.mitoselectedmethod = this.selectedmethod;
            this.request = this.requestdate;
            this.receive = this.receivedate;
            this.statuses = this.statusoptions;
            this.status = this.selectedstatus;
            this.seqNum = this.sequencenum;
            this.mitosubgroup = this.subgroup;
            this.mitoseqsimilar = this.seqsimilar;
            this.mitobasepairs = this.basepairs;
            this.mitoregion = this.region;
            this.mitopoly = this.poly;
            this.haplos = this.haplooptions;
            this.mitomccdate = this.mccdate;
            this.mitocount = this.count;
            this.mitopopfrequency = this.popfrequency;
            this.mitohaplogroup = this.haplogroup;
        },
    }
</script>
