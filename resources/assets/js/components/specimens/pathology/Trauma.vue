<template>
        <div id="trauma-component">
                <zone
                        :options_object="listzone"
                        :disabled="disabled"
                        :autocomplete ="true"
                        :deletedchips ="true"
                        :flex_cols_md="12"
                        :flex_cols_sm="12"
                        :buseventname="'traumaVModelChangeZones'"
                ></zone>
                <isotopevautocomplete
                        :options="listtrauma"
                        :disabled="disabled"
                        :componentchips="true"
                        :componentlabel="traumalabel"
                        :componentdusk="traumadusk"
                        :flex_cols_md="12"
                        :flex_cols_sm="12"
                        :buseventname="'traumaVModelChange'"
                ></isotopevautocomplete>
                <additionalinformation
                        :disabled="disabled"
                        :dusk="'se-trauma-additional_info'"
                        :additionalinformationname="traumaadditionalinformationnamepc"
                        :additionalinformationlabel="traumaadditionalinformationnamelabelpc"
                        :flex_cols_md="12"
                        :flex_cols_sm="12"
                        :buseventname="'traumaVModelChangeAdditionalInformation'"
                ></additionalinformation>
        </div>
</template>

<script>
        import {apiGetCall, apiPostCall, apiPostCallZones, bus} from '../../../coraBaseModules';
    export default {
        name: "Trauma",
        props: {
            listtrauma: Object,
            listzone: Object,
            disabled: Boolean,
            traumavmodel: null,
            traumadusk: String,
            traumalabel: String,
            additionalinformationvmodelpc: null,
            traumaadditionalinformationnamepc: null,
            traumaadditionalinformationnamelabelpc: String,
            specimen_id: String,
            base_url: String,
        },
        data() {
            return {
                    traumaAdditionalInformationSubmit: null,
                    traumaSubmit: null,
                    zonesSubmit: null,
                    traumasMap: {},
                    type: 'traumas',
            };
        },
        mounted: {

        },
        methods:{
                postTraumas: function(){

                },
        },
        computed: {
        },
        created(){
                bus.$on('traumaVModelChangeAdditionalInformation', (data)=>{
                        this.traumaAdditionalInformationSubmit = data;
                }),
                bus.$on('traumaVModelChange', (data)=> {
                        this.traumaSubmit = data;
                }),
                bus.$on('traumaVModelChangeZones', (data)=> {
                        this.zonesSubmit = data;
                })
        },
    }
</script>

<style>
</style>