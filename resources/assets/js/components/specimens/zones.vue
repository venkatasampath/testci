<template>
    <div class="m-2">
        <contentheader v-if="show_contentheader" :trail="this.trail" :se_action_menu="(!action.create)" model_name="measurements"
                       :specimen="(action.create)?null:specimen" :crud_action="action"
                       @eventEdit="edit" @eventReset="reset" @eventSave="save">
        </contentheader>
        <v-alert v-if="alert" class="my-1" border="left" colored-border type="info" elevation="2" dismissible>{{alertText}}</v-alert>
        <specimen-highlights v-if="show_contentheader" :specimen="specimen"></specimen-highlights>
        <v-card flat>
            <v-row align="center" justify="center">
                <v-col cols="12" :md="cols" class="py-0">
                    <v-toolbar v-show="show_toolbar">
                        <v-badge color="primary" :content="this.count + '/'+ this.items.length">Zones</v-badge>
                        <v-spacer></v-spacer>
                        <v-btn title="Edit" v-if="show_edit && show_toolbar_crud" color="primary" icon @click="edit" dusk="se-zone-edit" :loading="loading"><v-icon>mdi-pencil</v-icon></v-btn>
                        <v-btn title="Save" v-if="show_save && show_toolbar_crud" icon color="primary" @click="save" dusk="se-zone-saveButton" :loading="loading" :disabled="!isFormValid"><v-icon>mdi-content-save</v-icon></v-btn>
                        <v-btn title="Reset/Undo" v-if="show_reset && show_toolbar_crud" icon color="primary" dusk="se-zone-resetUndo" @click="reset"><v-icon>mdi-undo-variant</v-icon></v-btn>
                        <v-btn title="CoRA Docs" v-if="show_help" icon color="primary" :href="items[0].help_url" target="_blank" dusk="se-zone-coraDoc"><v-icon>mdi-help-circle-outline</v-icon></v-btn>
                        <v-btn icon @click="isCollapse = !isCollapse" color="primary" dusk="se-zone-collapse">
                            <v-icon title="Collaspe" v-if="isCollapse">mdi-arrow-collapse-up</v-icon>
                            <v-icon title="Expand" v-if="!isCollapse">mdi-arrow-expand-down</v-icon>
                        </v-btn>
                    </v-toolbar>
                    <v-card class="m-2" v-if="isCollapse">
                        <v-img id="image" v-if="show_image" contain height="200px" :src="img_src" alt="Image not available" class="mx-auto"></v-img>
                        <br>
<!--                        <v-form v-model="isFormValid">-->
                        <v-row justify="space-around" pl="10">
                            <v-col cols="12">
                                <v-checkbox v-model="select_all" label="Select All" :indeterminate="intermediateState" :height="height"
                                        dense loading :readonly="!show_save" :disabled="!show_save" dusk="se-zone-checkbox" @change="selectAllChange">Select All
                                </v-checkbox>
                            </v-col>
                        </v-row>
                        <v-row justify="space-around">
                            <v-col cols="12">
                                <v-switch v-model="item.presence" v-for="item in items" :key="item.id"
                                          :label="item.display_name" :readonly="!show_save" :disabled="!show_save"
                                          color="primary" dense hoverable :height="height" dusk="se-zone-switch" @change="zoneChange()" :dusk="item.display_name">
                                </v-switch>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-col>
            </v-row>
        </v-card>
    </div>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import {eventBus} from "../../eventBus";
    import axios from "axios";

    export default {
        name: 'zones',
        props: {
            crud_action: { type: String, default: "View" },
            specimen: { type: Object, required: true },
            heading: { type: String, default: "Zones" },
            toolbar:{type:Boolean, default: true},
            toolbar_crud:{type:Boolean, default: true},
            contentheader: {type:Boolean, default: true},
            cols: {type:Number, default: 12},
            display_image:{type:Boolean, default: true},
            help_slideout: {type:Boolean, default: true},
            height: { type: Number, default: 2 },

            // Deal with review separately
            review: { type: Boolean, default: false },
            passedZonesData: [Array, Object],
            options_object: Object,
        },
        data() {
            return {
                loading: false,
                type: 'zones',
                items: [],
                zones: {},
                preparedZones: {},
                show_image: this.display_image,
                show_save:false,
                show_edit:false,
                show_help:false,
                show_reset:false,
                isCollapse: true,
                count:0,
                isFormValid:true,
                show_toolbar: this.toolbar,
                show_toolbar_crud: this.toolbar_crud,
                show_contentheader: this.contentheader,
                trail: [{ text: 'Home', disabled: false, href: '/', },
                    { text: 'Specimen', disabled: false, href: (this.specimen) ? '/skeletalelements/'+this.specimen.id : "/" },
                    { text: 'Zones', disabled: true, href: "/" },
                ],
                alert: false,
                alertText: "",
                img_src: "/storage/images/zones/"+this.specimen.sb.image_zones,
                intermediateState: true,
                select_all: true,
            }
        },
        created() {
            console.log('Zones Component created.');
            // First get the list of all possible zones for the specimen
            this.loading = true;
            let payload = { 'type': 'zones', 'list': true };
            this.$store.dispatch('fetchAppList', payload).then(() => this.loading = false);
        },
        beforeMount() {
            // Make a copy, because you cannot change vuex state from outside.
            // Here we need to change by adding zone presence.
            this.items = JSON.parse ( JSON.stringify (this.getZonesByBone(this.specimen.sb_id) ));
        },
        mounted() {
            if (!this.review) {
                this.getZones()
            } else {
                this.Zones = this.passedZonesData
            }

            this.show_edit = this.action.view;
            this.show_save = this.action.edit ;
            this.show_reset = this.action.edit;

            // Help slide out
            let help_slideout = this.getUserProfileValueByName('ui_right_sidebar_slideout_help');
            if (help_slideout && this.help_slideout) {
                let url = this.items[0].help_url;
                eventBus.$emit('help-sideout', url);
            }
        },
        methods:{
            getZones: function () {
                this.loading = true;
                let url = '/api/specimens/'+this.specimen.id+'/associations?type='+this.type
                axios
                    .request({ url: url, method: 'GET',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization': this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        this.zones = response.data.data;

                        // Iterate over all the zones that are present for this specimen.
                        // Find zone in items array and set presence for that specific zone
                        let items = this.items;
                        let count = 0;
                        this.zones.forEach(function (el, index) {
                            let item = items.find(data => {return data.id === el.id});
                            item.presence = el.presence;
                            if (el.presence) {
                                count++;
                            }
                        });
                        this.cachedZones = Object.assign([], this.items);
                        this.intermediateState = (count !== 0 && this.items.length !== count);
                        if (count === 0) {
                            this.select_all = false;
                        }
                        this.count = count;
                        this.loading = false;
                    })
                    .catch(error => {
                        //
                    })
            },
            edit:function(){
                this.show_edit = !this.show_edit;
                this.show_save = !this.show_save;
                this.show_reset = !this.show_reset;
            },
            reset:function(){
                this.show_edit = !this.show_edit;
                this.show_save = !this.show_save;
                this.show_reset = !this.show_reset;

                let items = this.items;
                let count = 0;
                this.zones.forEach(function (el, index) {
                    let item = items.find(data => {return data.id === el.id});
                    item.presence = el.presence;
                    if (el.presence) { count++; }
                });
                this.select_all = (this.items.length === count);
                this.count = count;
                this.intermediateState = (count !== 0 && this.items.length !== count);
                this.cachedMeasurements = Object.assign([], this.items);
            },
            save() {
                this.prepareZonesForSave();
                let url = '/api/specimens/' + this.specimen.id + '/associations';
                let data = { "type": "zones", "listIds": this.preparedZones };
                // console.log("Edit: Zones Array: data: " + JSON.stringify(data));

                axios
                    .request({ url: url, method: 'PUT', data: data,
                        headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken, },
                    })
                    .then(response => {
                        let payload = { 'text': 'Zones update successful', 'color': 'success', };
                        eventBus.$emit('show-snackbar', payload);
                        location.reload(); // relaod the current page
                    })
                    .catch(error => {
                        let payload = { 'text': 'Zones update failed', 'color': 'error', };
                        eventBus.$emit('show-snackbar', payload);
                    });
            },
            prepareZonesForSave() {
                let zones = this.items;
                // console.log("prepareZonessForSave zones count:"+zones.length);
                this.preparedZones = {};
                for (var i = 0; i < zones.length; i++) {
                    if (zones[i].presence) {
                        Vue.set(this.preparedZones, zones[i].id.toString(), {
                            "id": zones[i].id.toString(),
                            "presence": zones[i].presence.toString(),
                        })
                    }
                }
            },
            selectAllChange: function (value) {
                // console.log("selectAllChange: " + value);
                let count = 0;
                this.items.forEach(function (item) {
                    item.presence = value;
                    if (item.presence) { count++}
                });

                // console.log("selectAllChange: Value: " + value + " and " + count + "/" + this.items.length);
                this.intermediateState = (count !== 0 && this.items.length !== count);
                this.count = count;
            },
            zoneChange() {
                let count = 0;
                this.items.forEach(function (el) {
                    if (el.presence) { count++; }
                });

                // console.log("zoneChange: " + count + "/" + this.items.length);
                this.intermediateState = (count !== 0 && this.items.length !== count);
                this.count = count;
            },
        },
        watch: {
            //
        },
        computed: {
            ...mapState({
                //
            }),
            ...mapGetters({
                bearerToken: 'bearerToken',
                csrfToken: 'csrfToken',
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
                getZonesByBone: 'getZonesByBone',
                getUserProfileValueByName: 'getUserProfileValueByName',
                getOrgProfileValueByName: 'getOrgProfileValueByName',
            }),
            action() {
                const act = this.crud_action;
                return { create: act === "Create", view: act === "View", edit: (act === "Update" || act === "Edit"), list: act === "List", };
            },
        },
    }
</script>

<style scoped>
    #zone-component{
        
    }
</style>