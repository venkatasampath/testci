<template>
    <v-col cols="12" v-bind:md="this.flexcols_md"  v-bind:sm="this.flexcols_sm" class="ma-3">
        <v-textarea
                    v-model="additionalinformationvmodel"
                    :label="additionalinformationlabel"
                    :dusk="duskId"
                    auto-grow
                    clearable
                    :disabled="disableOption"
                    :name="additionalinformationname"
                    @input="changedVModel"
            />
    </v-col>
</template>

<script>
    import {bus} from '../../../coraBaseModules'
    export default {
        name: "AdditionalInformation",
        props: {
            disabled: Boolean,
            dusk: String,
            additionalinformationname: String,
            additionalinformationlabel: String,
            flex_cols_md: Number,
            flex_cols_sm: Number,
            buseventname: String,
        },
        data() {
            return {
                disableOption: this.disabled,
                duskId: this.dusk,
                flexcols_md: this.flex_cols_md ? this.flex_cols_md : 2,
                flexcols_sm: this.flex_cols_sm ? this.flex_cols_sm : 12,
                additionalinformationvmodel: '',
            }
        },
        mounted(){
        },
        methods:{
            changedVModel: function(){
                bus.$emit(this.buseventname, this.additionalinformationvmodel)
            }
        }
    }
</script>

<style>
    div.v-application--wrap{
        min-height: 0;
    }
</style>