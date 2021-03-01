<template>
    <div id="IsotopeCarbonInformation">
        <v-row cols="12" md="12" class="mb-4">
            <isotopetextfield
                    :disabled="disabled"
                    :componentclearable="true"
                    :componentplaceholder="massplaceholder"
                    :componentid="'carbonDelta'"
                    :componentlabel="carbondeltalabel"
                    :componentdusk="'se-mass'"
                    :componentsuffix="ugsuffix"
                    :componenttype="masstype"
                    :componentvmodel="carbondeltavmodel"
                    :componentname="carbondeltaname"
                    :flex_cols_md="3"
                    :flex_cols_sm="12"
            ></isotopetextfield>
            <isotopetextfield
                    :disabled="disabled"
                    :componentclearable="true"
                    :componentplaceholder="massplaceholder"
                    :componentid="'carbonWeight'"
                    :componentlabel="carbonweightlabel"
                    :componentdusk="'se-mass'"
                    :componentsuffix="ugsuffix"
                    :componenttype="masstype"
                    :componentvmodel="carbonweightvmodel"
                    :componentname="carbonweightname"
                    :flex_cols_md="3"
                    :flex_cols_sm="12"
            ></isotopetextfield>
            <isotopetextfield
                    :disabled="disabled"
                    :componentclearable="true"
                    :componentplaceholder="massplaceholder"
                    :componentid="'carbonPercentage'"
                    :componentlabel="carbonpercentagelabel"
                    :componentdusk="'se-mass'"
                    :componentsuffix="percentagesuffix"
                    :componenttype="masstype"
                    :componentvmodel="carbonpercentagevmodel"
                    :componentname="carbonpercentagename"
                    :flex_cols_md="3"
                    :flex_cols_sm="12"
            ></isotopetextfield>
        </v-row>
    </div>
</template>

<script>
    export default {
        name: "isotopeCarbonInformation",
        props: {
            disabled: Boolean,
            ugsuffix: String,
            masstype: String,
            massplaceholder: String,
            percentagesuffix: String,
            carbondeltalabel: String,
            carbonweightlabel: String,
            carbonpercentagelabel: String,
            carbonpercentagevmodel: String,
            carbonweightvmodel: String,
            carbondeltavmodel: String,
            carbonpercentagename: String,
            carbonweightname: String,
            carbondeltaname: String,
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