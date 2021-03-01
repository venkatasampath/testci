<template>
    <div id="IsotopeSulphurInformation">
        <v-row cols="12" md="12" class="mb-6">
            <isotopetextfield
                    :disabled="disabled"
                    :componentclearable="true"
                    :componentplaceholder="massplaceholder"
                    :componentid="'sulpherDelta'"
                    :componentlabel="sulpherdeltalabel"
                    :componentdusk="'se-mass'"
                    :componentsuffix="ugsuffix"
                    :componenttype="masstype"
                    :componentname="sulpherdeltaname"
                    :componentvmodel="sulpherdeltavmodel"
                    :flex_cols_md="4"
                    :flex_cols_sm="12"
            ></isotopetextfield>
            <isotopetextfield
                    :disabled="disabled"
                    :componentclearable="true"
                    :componentplaceholder="massplaceholder"
                    :componentid="'sulpherWeight'"
                    :componentlabel="sulpherweightlabel"
                    :componentdusk="'se-mass'"
                    :componentsuffix="ugsuffix"
                    :componenttype="masstype"
                    :componentname="sulpherweightname"
                    :componentvmodel="sulpherweightvmodel"
                    :flex_cols_md="4"
                    :flex_cols_sm="12"
            ></isotopetextfield>
            <isotopetextfield
                    :disabled="disabled"
                    :componentclearable="true"
                    :componentplaceholder="massplaceholder"
                    :componentid="'sulpherPercentage'"
                    :componentlabel="sulpherpercentagelabel"
                    :componentdusk="'se-mass'"
                    :componentsuffix="percentagesuffix"
                    :componenttype="masstype"
                    :componentname="sulpherpercentagename"
                    :componentvmodel="sulpherpercentagevmodel"
                    :flex_cols_md="4"
                    :flex_cols_sm="12"
            ></isotopetextfield>
        </v-row>
    </div>
</template>

<script>
    export default {
        name: "isotopeSulpherInformation",
        props: {
            disabled: Boolean,
            ugsuffix: String,
            percentagesuffix: String,
            masstype: String,
            massplaceholder: String,
            sulpherdeltalabel: String,
            sulpherweightlabel: String,
            sulpherpercentagelabel: String,
            sulpherpercentagename: String,
            sulpherweightname: String,
            sulpherdeltaname: String,
            sulpherpercentagevmodel: String,
            sulpherweightvmodel: String,
            sulpherdeltavmodel: String,
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