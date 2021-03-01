<template>
    <div id="IsotopeWeightInformation">
        <v-row cols="12" md="12" class="mb-6">
            <isotopetextfield
                    :disabled="disabled"
                    :componentclearable="true"
                    :componentplaceholder="massplaceholder"
                    :componentid="'weightVialnLid'"
                    :componentlabel="weightvialnlidlabel"
                    :componentdusk="'se-mass'"
                    :componentsuffix="masssuffix"
                    :componenttype="masstype"
                    :componentvmodel="weightvialnlidvmode"
                    :componentname="weightvialnlidname"
                    :flex_cols_md="3"
                    :flex_cols_sm="12"
            ></isotopetextfield>
            <isotopetextfield
                    :disabled="disabled"
                    :componentclearable="true"
                    :componentplaceholder="massplaceholder"
                    :componentid="'weightCollagen'"
                    :componentlabel="weightcollagenlabel"
                    :componentdusk="'se-mass'"
                    :componentsuffix="masssuffix"
                    :componenttype="masstype"
                    :componentvmodel="weightcollagenvmode"
                    :componentname="weightcollagenname"
                    :flex_cols_md="3"
                    :flex_cols_sm="12"
            ></isotopetextfield>
            <isotopetextfield
                    :disabled="disabled"
                    :componentclearable="true"
                    :componentplaceholder="massplaceholder"
                    :componentid="'weightSampleVialnLid'"
                    :componentlabel="weightsamplevialnlidlabel"
                    :componentdusk="'se-mass'"
                    :componentsuffix="masssuffix"
                    :componenttype="masstype"
                    :componentvmodel="weightsamplevialnlidvmode"
                    :componentname="weightsamplevialnlidname"
                    :flex_cols_md="3"
                    :flex_cols_sm="12"
            ></isotopetextfield>
            <isotopetextfield
                    :disabled="disabled"
                    :componentclearable="true"
                    :componentplaceholder="massplaceholder"
                    :componentid="'yieldCollagen'"
                    :componentlabel="yieldcollagenlabel"
                    :componentdusk="'se-mass'"
                    :componentsuffix="percentagesuffix"
                    :componenttype="masstype"
                    :componentvmodel="yieldcollagenvmode"
                    :componentname="yieldcollagenname"
                    :flex_cols_md="3"
                    :flex_cols_sm="12"
            ></isotopetextfield>
        </v-row>
    </div>
</template>

<script>
    export default {
        name: "isotopeWeightInformation",
        props: {
            disabled: Boolean,
            masssuffix: String,
            masstype: String,
            massplaceholder: String,
            weightvialnlidlabel: String,
            weightcollagenlabel: String,
            weightsamplevialnlidlabel: String,
            yieldcollagenlabel: String,
            percentagesuffix: String,
            yieldcollagenname: String,
            yieldcollagenvmode: String,
            weightsamplevialnlidname: String,
            weightsamplevialnlidvmode: String,
            weightcollagenvmode: String,
            weightcollagenname: String,
            weightvialnlidvmode: String,
            weightvialnlidname: String,
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