<template>
    <v-col cols="12" v-bind:md="this.flexcols_md" v-bind:sm="this.flexcols_sm" class="ma-3">
        <v-card tile flat>
            <v-text-field
                    v-model="isotopesamplenumberchildvmodel"
                    :placeholder="componentplaceholder"
                    clearable
                    required
                    :name="isotopesamplenumbername"
                    :label="componentlabel"
                    :rules="fieldRules"
                    dusk="'dna-sample_number"
                    :disabled="disableOption"
                    @input="changedVModel"
            />
        </v-card>
    </v-col>
</template>

<script>
    import {bus} from "../../../coraBaseModules";

    export default {
        name: "isotopeSampleNumber",
        props: {
            disabled: Boolean,
            componentplaceholder: String,
            componentlabel: String,
            isotopesamplenumbervmodel: String,
            isotopesamplenumbername: String,
            flex_cols_md: Number,
            buseventname: String,
            flex_cols_sm: Number,
        },
        data() {
            return {
                disableOption: this.disabled,
                flexcols_md: this.flex_cols_md ? this.flex_cols_md : 2,
                flexcols_sm: this.flex_cols_sm ? this.flex_cols_sm : 12,
                isotopesamplenumberchildvmodel: this.isotopesamplenumbervmodel ? this.isotopesamplenumbervmodel: '',
                fieldRules: [v => !!v || 'Isotope Sample Number is a required field', v => (v || '').indexOf(' ') < 0 || 'No spaces are allowed'],
            }
        },
        methods:{
            changedVModel: function(){
                bus.$emit(this.buseventname, this.isotopesamplenumberchildvmodel)
            },
        }
    }
</script>

<style>
    div.v-application--wrap {
        min-height: 0;
    }
</style>