<template>
    <div id="IsotopeOxygenInformation">
        <v-row cols="12" md="12" class="mb-6">
            <isotopetextfield
                    :disabled="disabled"
                    :componentclearable="true"
                    :componentplaceholder="massplaceholder"
                    :componentid="'oxygenDelta'"
                    :componentlabel="oxygendeltalabel"
                    :componentdusk="'se-mass'"
                    :componentsuffix="ugsuffix"
                    :componenttype="masstype"
                    :componentvmodel="oxygendeltavmodel"
                    :componentname="oxygendeltaname"
                    :flex_cols_md="3"
                    :flex_cols_sm="12"
            ></isotopetextfield>
            <isotopetextfield
                    :disabled="disabled"
                    :componentclearable="true"
                    :componentplaceholder="massplaceholder"
                    :componentid="'oxygenWeight'"
                    :componentlabel="oxygenweightlabel"
                    :componentdusk="'se-mass'"
                    :componentsuffix="ugsuffix"
                    :componenttype="masstype"
                    :componentvmodel="oxygenweightvmodel"
                    :componentname="oxygenweightname"
                    :flex_cols_md="3"
                    :flex_cols_sm="12"
            ></isotopetextfield>
            <isotopetextfield
                    :disabled="disabled"
                    :componentclearable="true"
                    :componentplaceholder="massplaceholder"
                    :componentid="'oxygenPercentage'"
                    :componentlabel="oxygenpercentagelabel"
                    :componentdusk="'se-mass'"
                    :componentsuffix="percentagesuffix"
                    :componenttype="masstype"
                    :componentvmodel="oxygenpercentagevmodel"
                    :componentname="oxygenpercentagename"
                    :flex_cols_md="3"
                    :flex_cols_sm="12"
            ></isotopetextfield>
            <isotopetextfield
                    :disabled="disabled"
                    :componentclearable="true"
                    :componentplaceholder="massplaceholder"
                    :componentid="'carbonOxygenRatio'"
                    :componentlabel="carbonoxygenratiolabel"
                    :componentdusk="'se-mass'"
                    :componentsuffix="percentagesuffix"
                    :componenttype="masstype"
                    :componentvmodel="carbonoxygenratiovmodel"
                    :componentname="carbonoxygenrationame"
                    :flex_cols_md="3"
                    :flex_cols_sm="12"
            ></isotopetextfield>
        </v-row>
    </div>
</template>

<script>
    export default {
        name: "isotopeOxygenInformation",
        props: {
            disabled: Boolean,
            ugsuffix: String,
            percentagesuffix: String,
            masstype: String,
            massplaceholder: String,
            oxygendeltalabel: String,
            oxygenweightlabel: String,
            oxygenpercentagelabel: String,
            carbonoxygenratiolabel: String,
            oxygendeltavmodel: String,
            carbonoxygenratiovmodel: String,
            oxygenpercentagevmodel: String,
            oxygenweightvmodel: String,
            oxygendeltaname: String,
            oxygenpercentagename: String,
            carbonoxygenrationame: String,
            oxygenweightname: String,
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