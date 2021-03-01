<template>
    <div id="IsotopeNitrogenInformation">
        <v-row cols="12" md="12" class="ma-3">
            <isotopetextfield
                    :disabled="disabled"
                    :componentclearable="true"
                    :componentplaceholder="massplaceholder"
                    :componentid="'nitrogenDelta'"
                    :componentlabel="nitrogendeltalabel"
                    :componentdusk="'se-mass'"
                    :componentsuffix="ugsuffix"
                    :componenttype="masstype"
                    :componentname="nitrogendeltaname"
                    :componentvmodel="nitrogendeltavmodel"
                    :flex_cols_md="3"
                    :flex_cols_sm="12"
            ></isotopetextfield>
            <isotopetextfield
                    :disabled="disabled"
                    :componentclearable="true"
                    :componentplaceholder="massplaceholder"
                    :componentid="'nitrogenWeight'"
                    :componentlabel="nitrogenweightlabel"
                    :componentdusk="'se-mass'"
                    :componentsuffix="ugsuffix"
                    :componenttype="masstype"
                    :componentname="nitrogenweightname"
                    :componentvmodel="nitrogenweightvmodel"
                    :flex_cols_md="3"
                    :flex_cols_sm="12"
            ></isotopetextfield>
            <isotopetextfield
                    :disabled="disabled"
                    :componentclearable="true"
                    :componentplaceholder="massplaceholder"
                    :componentid="'nitrogenPercentage'"
                    :componentlabel="nitrogenpercentagelabel"
                    :componentdusk="'se-mass'"
                    :componentsuffix="percentagesuffix"
                    :componenttype="masstype"
                    :componentname="nitrogenpercentagename"
                    :componentvmodel="nitrogenpercentagevmodel"
                    :flex_cols_md="3"
                    :flex_cols_sm="12"
            ></isotopetextfield>
            <isotopetextfield
                    :disabled="disabled"
                    :componentclearable="true"
                    :componentplaceholder="massplaceholder"
                    :componentid="'carbonNitrogenRatio'"
                    :componentlabel="carbonnitrogenratiolabel"
                    :componentdusk="'se-mass'"
                    :componentsuffix="percentagesuffix"
                    :componenttype="masstype"
                    :componentname="carbonnitrogenrationame"
                    :componentvmodel="carbonnitrogenratiovmodel"
                    :flex_cols_md="3"
                    :flex_cols_sm="12"
            ></isotopetextfield>
        </v-row>
    </div>
</template>

<script>
    export default {
        name: "isotopeNitrogenInformation",
        props: {
            disabled: Boolean,
            masstype: String,
            massplaceholder: String,
            ugsuffix: String,
            percentagesuffix: String,
            nitrogendeltalabel: String,
            nitrogenweightlabel: String,
            nitrogenpercentagelabel: String,
            carbonnitrogenratiolabel: String,
            nitrogendeltaname: String,
            carbonnitrogenrationame: String,
            nitrogenpercentagename: String,
            nitrogenweightname: String,
            carbonnitrogenratiovmodel: String,
            nitrogenpercentagevmodel: String,
            nitrogenweightvmodel: String,
            nitrogendeltavmodel: String,
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