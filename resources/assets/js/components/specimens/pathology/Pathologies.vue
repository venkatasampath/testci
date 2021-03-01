<template>
    <div id="pathology-component" >
            <isotopevautocomplete
                    :options="listzone"
                    :disabled="disabled"
                    :componentmultiple="true"
                    :componentlabel="'Zones:'"
                    :autocomplete ="true"
                    :componentdeletechips ="true"
                    :componentchips="true"
                    :flex_cols_md="12"
                    :flex_cols_sm="12"
                    :buseventname="'pathologiesVModelChangeZones'"
            ></isotopevautocomplete>
            <isotopevautocomplete
                    :options="listpathology"
                    :disabled="disabled"
                    :componentchips="true"
                    :componentlabel="pathologylabel"
                    :componentdusk="pathologydusk"
                    :flex_cols_md="12"
                    :flex_cols_sm="12"
                    :buseventname="'pathologiesVModelChange'"
            ></isotopevautocomplete>
            <additionalinformation
                    :disabled="disabled"
                    :dusk="'se-pathology-additional_info'"
                    :additionalinformationname="pathologyadditionalinformationnamepc"
                    :additionalinformationlabel="pathologyadditionalinformationlabelpc"
                    :flex_cols_md="12"
                    :flex_cols_sm="12"
                    :buseventname="'pathologiesVModelChangeAdditionalInformation'"
            ></additionalinformation>
    </div>
</template>

<script>
    import {bus} from '../../../coraBaseModules';
    import IsotopeVAutoComplete from "../commonvuetifycomponents/IsotopeVAutoComplete";
    import AdditionalInformation from "./AdditionalInformation.vue";
    import axios from "axios";
    import {mapGetters, mapState} from "vuex";

    export default {
        name: "pathology",
        props: {
            listpathology: Object,
            listzone: Object,
            disabled: Boolean,
            pathologyvmodel: null,
            pathologydusk: String,
            pathologylabel: String,
            pathologyadditionalinformationvmodelpc: null,
            pathologyadditionalinformationnamepc: null,
            pathologyadditionalinformationlabelpc: String,
            specimen_id: String,
            base_url: String,
        },
        data() {
            return {
                zonesMap: {},
                type: 'pathologies',
                typeSubmit: 'pathologys',
                pathologyAdditionalInformationSubmit: null,
                pathologiesSubmit: '',
                zonesSubmit: Array,
            };
        },
        mounted() {
        },
        computed: {
            PathologySubmit(){
                return  {
                    type: this.type,
                    pathology_id: this.pathologySubmit,
                    listIds: this.zonesList,
                }
            },
            ...mapState({
                perPage: state => state.search.perPage,
                rowsPerPageItems: state => state.search.rowsPerPageItems,
                bones: state => state.bones,
            }),
            ...mapGetters({
                bearerToken: 'bearerToken',
                csrfToken: 'csrfToken',
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
            }),
        },
        methods:{
            postPathology: function(){
                  this.zonesSubmit.forEach(item=> {
                    this.zonesMap[item] = {"zone_id":item, "pathology_id":this.pathologiesSubmit.toString(),  "additional_information": this.pathologyAdditionalInformationSubmit.toString(), "abnormality_category":null, "characteristics":null}
                });
                axios
                    .request({
                        url: this.base_url+'/api/specimens/'+this.specimen_id+'/associations?type=pathologys',
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        },
                        data: {
                            "type": "pathologys",
                            "pathology_id":this.pathologiesSubmit.toString(),
                            "listIds": this.zonesMap,
                        }
                    }).then(response=>{
                    succeed = true;
                }).catch(error => {
                    errored = true
                })
            },
        },
        components:{
            IsotopeVAutoComplete,
            AdditionalInformation,
        },
        created(){
            bus.$on('pathologiesVModelChangeAdditionalInformation', (data)=>{
                this.pathologyAdditionalInformationSubmit = data;
            });
            bus.$on('pathologiesVModelChange', (data)=> {
                this.pathologiesSubmit = data;
            });
            bus.$on('pathologiesVModelChangeZones', (data)=> {
                this.zonesSubmit = data;
            });
        }
    }
</script>

<style>
</style>