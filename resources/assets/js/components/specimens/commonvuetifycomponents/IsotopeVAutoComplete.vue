<template>
    <v-col cols="12" v-bind:md="this.flexcols_md"  v-bind:sm="this.flexcols_sm" class="ma-3">
        <v-card v-if="this.options === undefined" tile flat >
            <v-autocomplete
                :items="backendformattedoptions"
                item-text="text"
                item-value="value"
                v-model="componentvmodelchild"
                :label="componentlabel"
                :dusk="componentdusk"
                :required="componentrequired"
                :rules="componentrule"
                :disabled="disabled"
                :name="componentname"
                :multiple="componentmultiple"
                :chips="componentchips"
                :deletable-chips="componentdeletechips"
                :placeholder="componentplaceholder"
                :readonly="readonly"
                :loading="isloading"
                @input="changedVModel"
            />
            <input type="hidden" :id="componentname" :name="componentname" v-bind:value="componentvmodelchild">
        </v-card>
        <v-card v-else tile flat>
            <v-autocomplete
                    :items="changeObjToArray"
                    item-text="text"
                    item-value="value"
                    v-model="componentvmodelchild"
                    :label="componentlabel"
                    :dusk="componentdusk"
                    :required="componentrequired"
                    :rules="componentrule"
                    :disabled="disabled"
                    :name="componentname"
                    :multiple="componentmultiple"
                    :chips="componentchips"
                    :deletable-chips="componentdeletechips"
                    :placeholder="componentplaceholder"
                    :readonly="readonly"
                    :loading="isloading"
                    @input="changedVModel"
            />
            <input type="hidden" :id="componentname" :name="componentname" v-bind:value="componentvmodel">
        </v-card>
    </v-col>
</template>

<script>
    import {bus, changeObjectToArray} from '../../../coraBaseModules';

    export default {
        name: "isotopeVAutoComplete",
        props: {
            options:[Object, Array],
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
            componentrule: Array,
            componentmultiple: Boolean,
            componentchips: Boolean,
            componentdeletechips: Boolean,
            flex_cols_md: Number,
            flex_cols_sm: Number,
            readonly: Boolean,
            buseventname: String,
            backendformattedoptions: Array,
            componentvmodel: null,
            isloading: Boolean,
        },
        data() {
            return {
                flexcols_md: this.flex_cols_md ? this.flex_cols_md : 2,
                flexcols_sm: this.flex_cols_sm ? this.flex_cols_sm : 12,
                componentvmodelchild: this.componentvmodel ? this.componentvmodel: '',
                displayOptipns:[],
            };
        },
        mounted() {

        },
        computed:{
            //Creating array of objects
            changeObjToArray: function () {
                return changeObjectToArray(this.options)
            },
        },
        methods:{
            changedVModel: function(){
                bus.$emit(this.buseventname, this.componentvmodelchild)
            },
        },
        watch:{
            componentvmodel: function(newVal){
                this.componentvmodelchild = newVal;
            }
        }
    }
</script>

<style>
    div.v-application--wrap{
        min-height: 0;
    }
</style>