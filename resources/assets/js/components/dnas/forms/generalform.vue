<template>

        <v-row>
            <samplenumber :samplenum="sampleNum"
                          :rules="numberRules"
                          disabled>
            </samplenumber>

            <labs
                :selectedLab="selectedlab"
                :disabled="isDisabled">
            </labs>

            <externalcasenumber
                    :externalcasenumber="externalCaseNum"
                    :disabled="isDisabled">
            </externalcasenumber>

            <date :value="btbrequest"
                  :label="btbrequestdatelabel"
                  :disabled="isDisabled"
                  type="btbrequestdate"
                  :mdvalue="mdvalue"
                  :smvalue="smvalue"
                  :colval="colval"
                  :textval="textval">
            </date>


            <date :value="btbreceive"
                  :label="btbreceivedatelabel"
                  :disabled="isDisabled"
                  type="btbreceivedate"
                  :mdvalue="mdvalue"
                  :smvalue="smvalue"
                  :colval="colval"
                  :textval="textval">
            </date>


            <disposition :options="dispositions"
                         :selectedDisposition="disposition"
                         :disabled="isDisabled">
            </disposition>


            <sample-condition :options="conditions"
                              :rules="conditionRules"
                              :selectedCondition="condition"
                              :disabled="isDisabled">
            </sample-condition>


            <weight-sample-remaining :weight="remainingweight"
                                     :suffix="weightsuffix"
                                     :disabled="isDisabled">
            </weight-sample-remaining>

            <resamplingoption :recommended="resampleindicator"
                              :disabled="isDisabled">
            </resamplingoption>
        </v-row>

</template>

<script>
    export default {
        name: "generalform",
        props: {
            //v-models
            samplenumber: '',
            btbrequestdate: '',
            btbreceivedate: '',
            dispositionoptions: Object,
            selecteddisposition: '',
            conditionoptions: Object,
            selectedcondition: '',
            remainingweightsuffix: '',
            weight: '',
            externalcasenumber:'',
            recommended:false,
            isDisabled: true,
            lab: '',
        },
        data: () => ({
            sampleNum:'',
            btbrequest:'',
            btbreceive:'',
            dispositions:Object,
            disposition:'',
            conditions:Object,
            condition:'',
            weightsuffix:'',
            remainingweight:'',
            resampleindicator:'',

            //Validation Rules
            numberRules: [v => !!v || 'Please specify the sample number'],
            conditionRules: [v => !!v || 'Please select a value for the sample condition.'],

            selectedtags: [],
            tags: ['1', '2', '3'],

            //label
            btbrequestdatelabel: 'BTB Request Date',
            btbreceivedatelabel: 'BTB Receive Date',
            mdvalue: 3,
            smvalue: 12,
            colval: "mt-5",
            textval:"mr-5"

        }),

        beforeMount() {
            this.sampleNum = this.samplenumber;
            this.btbrequest = this.btbrequestdate;
            this.btbreceive=this.btbreceivedate;
            this.dispositions=this.dispositionoptions;
            this.disposition = this.selecteddisposition;
            this.conditions = this.conditionoptions;
            this.condition = this.selectedcondition;
            this.weightsuffix=this.remainingweightsuffix;
            this.remainingweight=this.weight;
            this.resampleindicator=this.recommended;
            this.selectedlab= this.lab;
            this.externalCaseNum= this.externalcasenumber;
        },
    }

</script>
