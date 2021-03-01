<template>
    <v-col cols="12" v-bind:md="this.flexcols_md"  v-bind:sm="this.flexcols_sm" class="ma-3">
        <v-card tile flat >
        <v-text-field
                v-model="componentvmodelchild"
                :name="componentname"
                :placeholder="componentplaceholder"
                :clearable="componentclearable"
                :required="componentrequired"
                :label="componentlabel"
                :dusk="componentdusk"
                :disabled="disabled"
                :type="componenttype"
                :suffix="componentsuffix"
                :rules="rules"
                @input="changedVModel"
        />
        </v-card>
    </v-col>
</template>

<script>
    import {bus} from "../../../coraBaseModules";

    export default {
        name: "reusableIsotopeTextField",
        props: {
            disabled: Boolean,
            componentid: String,
            componentname: String,
            componentplaceholder: String,
            componentclearable: Boolean,
            componentrequired: Boolean,
            componentlabel: String,
            componentdusk: String,
            componenttype: String,
            componentsuffix: String,
            flex_cols_md: Number,
            flex_cols_sm: Number,
            componentvmodel: String,
            buseventname: String,
            rules: Array,
        },
        data() {
            return {
                flexcols_md: this.flex_cols_md ? this.flex_cols_md : 2,
                flexcols_sm: this.flex_cols_sm ? this.flex_cols_sm : 12,
                componentvmodelchild: this.componentvmodel ? this.componentvmodel : '',
            }
        },
        mounted() {
        },
        methods:{
            changedVModel: function(){
                bus.$emit(this.buseventname, this.componentvmodelchild)
            },
        }

    }
</script>

<style>
    div.v-application--wrap {
        min-height: 0;
    }
</style>