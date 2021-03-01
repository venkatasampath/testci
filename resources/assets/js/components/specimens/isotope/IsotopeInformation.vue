<template>
    <div id="IsotopeInformation">
        <v-row cols="12" md="12">
            <Lab
                    :options="laboptions"
                    :disabled="labdisabled"
                    :isotopelabname="isotopelabname"
                    :isotopelabvmodel="isotopelabvmodel"
                    :buseventname:="'isotopeLab'"
                    :flex_cols_md="4"
                    :flex_cols_sm="12"
                    :se_id="se_id"
                    @input="changedVModel"
            ></Lab>
            <isotopetextfield
                    :disabled="externalcasenumberdisabled"
                    :componentclearable="true"
                    :componentplaceholder="externalcasenumberplaceholder"
                    :componentid="'externalCaseNumber'"
                    :componentlabel="externalcasenumberlabel"
                    :componentdusk="'dna-external_case'"
                    :componentvmodel="isotopecasenumbervmodel"
                    :componentname="externalcaseidname"
                    :buseventname="'isotopeExternalCaseNumber'"
                    :flex_cols_md="4"
                    :flex_cols_sm="12"
                    @input="changedVModel"
            ></isotopetextfield>
            <isotopesamplenumber
                    :componentlabel="isotopesamplenumberlabel"
                    :componentplaceholder="isotopesamplenumberplaceholder"
                    :isotopesamplenumbervmodel="isotopesamplenumbervmodel"
                    :isotopesamplenumbername="isotopesamplenumbername"
                    :disabled="isotopesamplenumberdisabled"
                    :buseventname="'isotopeSampleNumber'"
                    :flex_cols_md="4"
                    :flex_cols_sm="12"
                    @input="changedVModel"
            ></isotopesamplenumber>
        </v-row>
    </div>
</template>

<script>
    import Lab from "./Lab";
    import IsotopeSampleNumber from "./IsotopeSampleNumber";
    import IsotopeTextField from "../commonvuetifycomponents/IsotopeTextField";
    import {bus} from "../../../coraBaseModules";

    export default {
        name: "isotopeInformation",
        props: {
            labdisabled: Boolean,
            laboptions: Object,
            externalcasenumberdisabled: Boolean,
            externalcasenumberlabel: String,
            externalcasenumberplaceholder: String,
            isotopesamplenumberlabel: String,
            isotopesamplenumberplaceholder: String,
            isotopecasenumbervmodel: null,
            isotopesamplenumbervmodel: null,
            isotopelabdefaultvalue: null,
            isotopelabvmodel: null,
            externalcaseidname: String,
            isotopelabname: String,
            isotopesamplenumbername: String,
            isotopesamplenumberdisabled: Boolean,
            se_id: String,
            buseventname: String,

            //Isotope Information VModel
            isotopeLab: '',
            externalCaseNumber: '',
            isotopeSampleNumber: '',
        },
        data() {
            return {}
        },
        mounted() {
        },
        methods: {

        },
        components: {
            Lab,
            IsotopeSampleNumber,
            IsotopeTextField,
        },
        created(){
            bus.$on('isotopeLab', (data) => {
                this.isotopeLab = data;
            })
            bus.$on('isotopeExternalCaseNumber', (data) => {
                this.externalCaseNumber = data;
            })
            bus.$on('isotopeSampleNumber', (data) => {
                this.isotopeSampleNumber = data;
            })
        }
    }
</script>

<style>
    div.v-application--wrap {
        min-height: 0;
    }
</style>