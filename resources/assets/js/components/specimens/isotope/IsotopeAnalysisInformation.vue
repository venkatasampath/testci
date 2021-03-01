<template>
    <div id="IsotopeAnalysisInformation">
        <v-row cols="12" md="12" class="mb-6">
            <isotopetextfield
                    :disabled="disabled"
                    :componentclearable="true"
                    :componentplaceholder="massplaceholder"
                    :componentid="'collagenWeightUsedforAnalysis'"
                    :componentlabel="collagenweightusedforanalysislabel"
                    :componentdusk="'se-mass'"
                    :componentsuffix="masssuffix"
                    :componenttype="masstype"
                    :componentname="collagenweightusedforanalysisname"
                    :componentvmodel="collagenweightusedforanalysisvmodel"
                    :flex_cols_md="4"
                    :flex_cols_sm="12"
            ></isotopetextfield>
            <isotopetextfield
                    :disabled="disabled"
                    :componentclearable="true"
                    :componentplaceholder="textfieldplaceholder"
                    :componentid="'analysisRequested'"
                    :componentlabel="analysisrequestedlabel"
                    :componentdusk="'dna-external_case'"
                    :componenttype="textfieldtype"
                    :componentname="analysisrequestedname"
                    :componentvmodel="analysisrequestedvmodel"
                    :flex_cols_md="4"
                    :flex_cols_sm="12"
            ></isotopetextfield>
            <isotopetextfield
                    :disabled="disabled"
                    :componentclearable="true"
                    :componentplaceholder="textfieldplaceholder"
                    :componentid="'wellLocation'"
                    :componentlabel="welllocationlabel"
                    :componentdusk="'dna-external_case'"
                    :componenttype="textfieldtype"
                    :componentname="welllocationname"
                    :componentvmodel="welllocationvmodel"
                    :flex_cols_md="4"
                    :flex_cols_sm="12"
            ></isotopetextfield>
        </v-row>
    </div>
</template>

<script>
    export default {
        name: "isotopeAnalysisInformation",
        props: {
            disabled: Boolean,
            masssuffix: String,
            masstype: String,
            massplaceholder: String,
            textfieldtype: String,
            textfieldplaceholder: String,
            collagenweightusedforanalysislabel: String,
            analysisrequestedlabel: String,
            welllocationlabel: String,
            collagenweightusedforanalysisname: String,
            collagenweightusedforanalysisvmodel: String,
            analysisrequestedname: String,
            analysisrequestedvmodel: String,
            welllocationname: String,
            welllocationvmodel: String,
        },
        data() {
            return {
                disableOption: this.disabled,
            }
        },
        mounted() {
        },
        methods: {}
    }
</script>

<style>
    div.v-application--wrap {
        min-height: 0;
    }
</style>