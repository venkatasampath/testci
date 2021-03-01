<template>
    <v-col cols="12" v-bind:md="this.flexcols_md" v-bind:sm="this.flexcols_sm" class="ma-3">
        <v-card tile flat>
            <v-select
                    :items="changeObjToArray"
                    item-text="text"
                    item-value="value"
                    v-model="isotopelabchildvmodel"
                    label="Lab"
                    dusk="dna-lab"
                    required
                    :name="isotopelabname"
                    :rules="rules"
                    :disabled="disabled"
                    @input="changedVModel"

            />
        </v-card>
    </v-col>
</template>

<script>
    import {bus, changeObjectToArray} from "../../../coraBaseModules";

    export default {
        name: "Lab",

        data() {
            return {
                labOptions:Object,
                disableOption: false,
                flexcols_md: this.flex_cols_md?this.flex_cols_md:2,
                flexcols_sm:this.flex_cols_sm?this.flex_cols_sm:2,
                isotopelabchildvmodel: [String,Number],
            };
        },

        props: {
            options: [Object, Array],
            disabled: Boolean,
            isotopelabname: String,
            isotopelabvmodel: [String,Number],
            flex_cols_md: Number,
            flex_cols_sm: Number,
            selectedlabid: String,
            buseventname: String,
            rules:Array,
        },

        beforeMount() {
            this.labOptions=this.options;
            this.isotopelabchildvmodel = this.isotopelabvmodel;
        },

        computed: {
            changeObjToArray: function () {
                return changeObjectToArray(this.labOptions);
            },
            changedVModel: function(){
                bus.$emit(this.buseventname, this.isotopelabchildvmodel);
            },
        }
    }
</script>

<style>
    div.v-application--wrap {
        min-height: 0;
    }
</style>