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
                        <v-badge color="primary" :content="this.count + '/'+ this.items.length">Measurements</v-badge>
                        <v-spacer></v-spacer>
                        <v-btn title="Edit" v-if="show_edit && show_toolbar_crud" color="primary" icon @click="edit" :loading="loading" dusk="edit-button-measurements"><v-icon>mdi-pencil</v-icon></v-btn>
                        <v-btn title="Save" v-if="show_save && show_toolbar_crud" icon color="primary" @click="save" :loading="loading" :disabled="!isFormValid" dusk="save-button-measurements"><v-icon>mdi-content-save</v-icon></v-btn>
                        <v-btn title="Reset/Undo" v-if="show_reset && show_toolbar_crud" icon color="primary" @click="reset" dusk="reset-button-measurements"><v-icon>mdi-undo-variant</v-icon></v-btn>
                        <v-btn title="CoRA Docs" v-if="show_help" icon color="primary" :href="items[0].help_url" target="_blank" dusk="help-button-measurements"><v-icon>mdi-help-circle-outline</v-icon></v-btn>
                        <v-btn icon @click="isCollapse = !isCollapse" color="primary" dusk="collapse-button-measurements">
                            <v-icon title="Collaspe" v-if="isCollapse" dusk="collapse-icon-measurements">mdi-arrow-collapse-up</v-icon>
                            <v-icon title="Expand" v-if="!isCollapse" dusk="expand-icon-measurements">mdi-arrow-expand-down</v-icon>
                        </v-btn>
                    </v-toolbar>
                    <v-card class="m-2" v-if="isCollapse">
                        <v-img id="image" v-if="show_image" contain height="200px" :src="img_src" alt="Image not available" class="mx-auto"></v-img>
                        <br>
<!--                        <user-instruments></user-instruments>-->
<!--                        <user-instruments :crud_action="crud_action"></user-instruments>-->
                        <user-instruments :user="theUser" used_for="Measurements" :specimen="specimen" dusk="user-instruments"></user-instruments>

                        <v-form v-model="isFormValid">
                            <v-text-field name="Measurements" v-model="item.measure" :label="item.display_name" dusk="se-measurements"
                                          v-for="item in items" v-bind:key="item.id" v-bind:id="item.id.toString()"
                                          type="number" :suffix="uom" :readonly="!show_save" :disabled="!show_save" :hint="measurementHint(item)"
                                          :rules="[(value) => { return (measurementRules(item, value)) }]" :dusk="item.display_name">
                                <template slot="prepend-inner">
                                    <v-icon v-if="item.stature" dusk="item-stature">mdi-human-male-height</v-icon>
                                    <v-icon v-if="item.sex" dusk="sex-stature">mdi-human-male-female</v-icon>
                                </template>
                                <template slot="prepend">
                                    <v-icon v-if="measurementWarning(item)" color="orange">mdi-alert</v-icon>
                                </template>
                                <v-menu offset-y left nudge-bottom="10px" slot="append-outer" right max-width="400px" :close-on-content-click="false" dusk="menu-measurements">
                                    <template v-slot:activator="{ on }"><v-icon v-on="on">mdi-information-outline</v-icon></template>
                                    <v-card>
                                        <v-card-title>{{item.display_name}}</v-card-title>
                                        <v-card-text class="py-1" v-if="item.stature || item.sex">
                                            <v-chip v-if="item.stature"><v-icon class="mr-2">mdi-human-male-height</v-icon>Stature<v-icon class="ml-2" color="success">mdi-check</v-icon></v-chip>
                                            <v-chip v-if="item.sex"><v-icon class="mr-2">mdi-human-male-female</v-icon>Sex<v-icon class="ml-2" color="success">mdi-check</v-icon></v-chip>
                                        </v-card-text>
                                        <v-card-text class="py-1"><b>Min: </b>{{item.min_value}} and <b>Max: </b>{{item.max_value}} </v-card-text>
                                        <v-card-text class="py-1"><b>Threshold Min: </b> {{item.min_threshold}} and <b>Threshold Max: </b> {{item.max_threshold}}</v-card-text>
                                        <v-card-text class="py-1" v-if="item.instrument"> <b>Instrument: </b>{{item.instrument}}</v-card-text>
                                        <v-card-text class="py-1" v-if="item.display_help"> <b>Help: </b>{{item.display_help}}</v-card-text>
                                        <v-card-text class="py-1" v-if="item.comment"><b>Comment: </b>{{item.comment}}</v-card-text>
                                    </v-card>
                                </v-menu>
                            </v-text-field>
                        </v-form>
                    </v-card>
                </v-col>
            </v-row>
        </v-card>
    </div>
</template>

<script>
    import axios from "axios";
    import {mapGetters, mapState} from "vuex";
    import {eventBus} from "../../eventBus";

    export default {
        name: "Measurements",
        props: {
            crud_action: { type: String, default: "View" },
            specimen: { type: Object, required: true },
            heading: { type: String, default: "Measurements" },
            toolbar: {type:Boolean, default: true},
            toolbar_crud: {type:Boolean, default: true},
            contentheader: {type:Boolean, default: true},
            cols: {type:Number, default: 12},
            display_image: {type:Boolean, default: true},
            help_slideout: {type:Boolean, default: true},
        },
        data() {
            return {
                loading: false,
                type: 'measurements',
                items: [],
                measurements: {},
                preparedMeasurements: {},
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
                    { text: 'Measurements', disabled: true, href: "/" },
                ],
                alert: false,
                alertText: "",
                img_src: "/storage/images/measurements/"+this.specimen.sb.image_measurements,
                uom: "mm",
            };
        },
        created() {
            console.log('Measurements Component created.');
            // First get the list of all possible measurements for the specimen
            this.loading = true;
            let payload = { 'type': 'measurements', 'list': true };
            this.$store.dispatch('fetchAppList', payload).then(() => this.loading = false);
        },
        beforeMount() {
            // Make a copy, because you cannot change vuex state from outside.
            // Here we need to change by adding measure.
            this.items = JSON.parse ( JSON.stringify (this.getMeasurementsByBone(this.specimen.sb_id) ));
        },
        mounted() {
            this.getMeasurements();
            this.uom = this.getOrgProfileValueByName("org_length_unit_of_measure");

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
            getMeasurements: function () {
                this.loading = true;
                let url = '/api/specimens/'+this.specimen.id+'/associations?type='+this.type
                axios
                    .request({ url: url, method: 'GET',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization': this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        this.measurements = response.data.data;

                        // Iterate over all the measurements that are present for this specimen.
                        // Find measurement in items array and set measure for that specific measurement
                        let items = this.items;
                        let count = 0;
                        this.measurements.forEach(function (el, index) {
                            let item = items.find(data => {return data.id === el.id});
                            item.measure = el.measure;
                            if (el.measure) {
                                count++;
                            }
                        });
                        this.cachedMeasurements = Object.assign([], this.items);
                        this.count = count;
                        this.loading = false;
                    })
                    .catch(error => {
                        this.errored = true;
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
                this.measurements.forEach(function (el, index) {
                    let item = items.find(data => {return data.id === el.id});
                    item.measure = el.measure;
                    if (el.measure) {
                        count++;
                    }
                });
                this.cachedMeasurements = Object.assign([], this.items);
                this.count = count;
            },
            save() {
                this.prepareMeasurementsForSave();
                let url = '/api/specimens/' + this.specimen.id + '/associations';
                let data = { "type": "measurements", "listIds": this.preparedMeasurements };
                // console.log("Edit: Mearsurements Array: data: " + JSON.stringify(data));

                axios
                    .request({ url: url, method: 'PUT', data: data,
                        headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken, },
                    })
                    .then(response => {
                        let payload = { 'text': 'Measurements update successful', 'color': 'success', };
                        eventBus.$emit('show-snackbar', payload);
                        location.reload(); // relaod the current page
                    })
                    .catch(error => {
                        let payload = { 'text': 'Measurements update failed', 'color': 'error', };
                        eventBus.$emit('show-snackbar', payload);
                    });
            },
            measurementHint(item) {
                let hint='Min: '+item.min_value+' Max: '+item.max_value;
                hint+=' and Threshold min: '+item.min_threshold+' Threshold max: '+item.max_threshold;
                return hint;
            },
            measurementRules(item, value) {
                let val = Number(value);
                if (!value) { return true; }

                if (val < item.min_value )
                    return "Value is below minumum value";
                else if (val > item.max_value)
                    return "Value is above maximum value";

                return true;
            },
            measurementWarning(item) {
                let val = Number(item.measure);
                // console.log("measurementWarning: "+ val);
                if (val < item.min_threshold && val > item.min_value)
                    return true;
                else if (val > item.max_threshold && val < item.max_value)
                    return true;

                return false;
            },
            prepareMeasurementsForSave() {
                let measurements = this.items;
                // console.log("prepareMeasurementsForSave measurements count:"+measurements.length);
                this.preparedMeasurements = {};
                for (var i = 0; i < measurements.length; i++) {
                    if (measurements[i].measure) {
                        Vue.set(this.preparedMeasurements, measurements[i].id.toString(), {
                            "id": measurements[i].id.toString(),
                            "measure": measurements[i].measure.toString(),
                        })
                    }
                }
            },
        },
        watch:{
            //
        },
        computed:{
            ...mapState({
                //
            }),
            ...mapGetters({
                bearerToken: 'bearerToken',
                csrfToken: 'csrfToken',
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
                getMeasurementsByBone: 'getMeasurementsByBone',
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
