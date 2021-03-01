<template>
    <div id="IsotopeBasicInformation">
        <v-row cols="12" md="12" class="mb-6">
            <isotopevautocomplete
                    :disabled="disabled"
                    :componentlabel="isotopebatchlabel"
                    :options="isotopebatchoptions"
                    :componentdusk="'dna-batch_id'"
                    :componentvmodel="isotopebatchoptionsvmodel"
                    :componentname="isotopebatchoptionsname"
                    :flex_cols_md="3"
                    :flex_cols_sm="12"
                    :buseventname="'isotopeBatch'"
                    @input="changedBatchVModel"
            ></isotopevautocomplete>
            <isotopevautocomplete
                    :disabled="disabled"
                    :componentlabel="resultsstatuslabel"
                    :options="resultsstatusoptions"
                    :componentdusk="'isotope-results_confidence'"
                    :componentvmodel="resultsstatusoptionsvmodel"
                    :componentname="resultsstatusoptionsname"
                    :flex_cols_md="3"
                    :flex_cols_sm="12"
                    :buseventname="'isotopeResultsStatus'"
                    @input="changedResStatVModel"
            ></isotopevautocomplete>
            <isotopetextfield
                    :disabled="disabled"
                    :componentclearable="true"
                    :componentplaceholder="weightsampledcleanedplaceholder"
                    :componentlabel="weightsampledcleanedlabel"
                    :componentdusk="'se-mass'"
                    :componentsuffix="weightsampledcleanedsuffix"
                    :componenttype="weightsampledcleanedtype"
                    :componentvmodel="weightsampledcleanedtypevmode"
                    :componentname="weightsampledcleanedtypename"
                    :buseventname="'isotopeWeightSampleCleaned'"
                    :flex_cols_md="3"
                    :flex_cols_sm="12"
                    @input="changedWeightSampledCleanedVModel"
            ></isotopetextfield>
            <!--            <demineralizingstartdate :disabled="true"></demineralizingstartdate>-->
            <!--            <demineralizingsenddate :disabled="true"></demineralizingsenddate>-->
        </v-row>
    </div>
</template>

<script>
    import {bus} from "../../../coraBaseModules";

    export default {
        name: "isotopeBasicInformation",
        props: {
            disabled: Boolean,
            isotopebatchoptions: Object,
            isotopebatchlabel: String,
            resultsstatuslabel: String,
            resultsstatusoptions: Object,
            weightsampledcleanedplaceholder: String,
            weightsampledcleanedlabel: String,
            weightsampledcleanedsuffix: String,
            weightsampledcleanedtype: String,
            isotopebatchoptionsname: String,
            resultsstatusoptionsname: String,
            weightsampledcleanedtypename: String,
            buseventname: String,
        },
        data() {
            return {
                disableOption: this.disabled,
                isotopebatchoptionsvmodel: '',
                resultsstatusoptionsvmodel: '',
                weightsampledcleanedtypevmode: '',
            }
        },
        mounted() {
        },
        methods: {
            changedBatchVModel: function(){
                bus.$emit('isotopeBatchInformationData', this.isotopebatchoptionsvmodel)
            },
            changedResStatVModel: function(){
                bus.$emit('isotopeResultStatusData', this.resultsstatusoptionsvmodel)
            },
            changedWeightSampledCleanedVModel: function(){
                bus.$emit('isotopeWeightSampledCleanedData', this.weightsampledcleanedtypevmode)
            },
        },
        created(){
            bus.$on('isotopeBatch', (data) => {
                this.isotopebatchoptionsvmodel = data;
            })
            bus.$on('isotopeResultsStatus', (data) => {
                this.resultsstatusoptionsvmodel = data;
            })
            bus.$on('isotopeWeightSampleCleaned', (data) => {
                this.weightsampledcleanedtypevmode = data;
            })
        }
    }
</script>

<style>
    div.v-application--wrap {
        min-height: 0;
    }
</style>