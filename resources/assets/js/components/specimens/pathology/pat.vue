<template>
    <div class="m-2">
        <!-- Add the Content Header Crud component for Bread crumb trail, heading and Create New (crud buttons)-->
        <contentheader v-if="show_contentheader" :trail="this.trail" :se_action_menu="(!action.create)" model_name="pathology"
                       :specimen="(action.create)?null:specimen" :new_menu="true" @eventNew="eventNewGo">
<!--                       @eventEdit="edit" @eventReset="reset" @eventSave="save">-->
        </contentheader>
        <!-- Add the standard alert component-->
        <v-alert v-if="alert" class="my-1" border="left" colored-border type="info" elevation="2" dismissible>{{alertText}}</v-alert>
        <!-- Add the Crud component for Create/Read-View/Update/Delete-->
        <pat-crud :specimen="specimen"></pat-crud>
        <!-- Add the specimen highlights for this specimen-->
        <specimen-highlights v-if="show_contentheader" :specimen="specimen"></specimen-highlights>
        <!-- Add the Tabs for PAT -->
        <v-card flat>
            <v-row align="center" justify="center">
                <v-col cols="12" :md="cols" class="py-0">
                    <v-toolbar v-show="show_toolbar">
                        <v-badge color="primary" :content="this.items_pathology.length + 'P ' + this.items_anomaly.length + 'A ' + this.items_trauma.length + 'T '">Pathology</v-badge>
                        <v-spacer></v-spacer>
                        <v-btn title="New" v-if="show_new && show_toolbar_crud && tab !== 1" color="primary" icon @click="eventNewGo('pathology')" :loading="loading"><v-icon>mdi-plus-circle</v-icon></v-btn>
                        <v-btn title="Edit" v-if="show_edit && show_toolbar_crud" color="primary" icon @click="edit" :loading="loading"><v-icon>mdi-pencil</v-icon></v-btn>
                        <v-btn title="Save" v-if="show_save && show_toolbar_crud" icon color="primary" @click="save" :loading="loading" :disabled="!isFormValid"><v-icon>mdi-content-save</v-icon></v-btn>
                        <v-btn title="Reset/Undo" v-if="show_reset && show_toolbar_crud" icon color="primary" @click="reset"><v-icon>mdi-undo-variant</v-icon></v-btn>
                        <v-btn icon @click="isCollapse = !isCollapse" color="primary">
                            <v-icon title="Collaspe" v-if="isCollapse">mdi-arrow-collapse-up</v-icon>
                            <v-icon title="Expand" v-if="!isCollapse">mdi-arrow-expand-down</v-icon>
                        </v-btn>
                    </v-toolbar>
                    <v-card class="m-2" v-if="isCollapse">
                        <v-tabs v-model="tab" background-color="transparent" grow>
                            <v-tab v-for="tab_item in tab_items" :key="tab_item.index">
                                <v-icon class="mr-2">{{tab_item.icon}}</v-icon>
                                <v-badge color="primary" :content="count_for(tab_item.text)">{{ tab_item.text }}</v-badge>
                            </v-tab>
                            <!-- Pathology Vertical Tabs-->
                            <v-tab-item>
                                <v-card flat>
                                    <v-card>
                                        <v-card-title>
                                            <v-btn color="primary" class="mb-2" @click="eventNewGo('pathology')"><v-icon left>mdi-plus-circle</v-icon>Create New</v-btn>
                                            <v-spacer></v-spacer>
                                            <v-text-field v-model="search_pathology" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
                                        </v-card-title>
                                        <v-card-text>
                                            <v-data-table :headers="headers_pathology" :items="items_pathology" :search="search_pathology" :disabled="disabled" :loading="loading">
                                                <template v-slot:item.action="{ item }">
                                                    <v-icon color="primary" class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
                                                    <v-icon color="error" @click="deleteItem(item)">mdi-delete</v-icon>
                                                </template>
                                            </v-data-table>
                                        </v-card-text>
                                    </v-card>
                                </v-card>
                            </v-tab-item>
                            <!-- Anomalies Vertical Tabs-->
                            <v-tab-item>
                                <v-card flat>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-autocomplete v-model="items_anomaly" label="Select Anomalies" :disabled="!action.edit || disabled" :readonly="!isEditing"
                                                            :items="anomalies" item-value="id" item-text="individuating_trait" chips deletable-chips multiple>
                                                <template v-slot:append-outer>
                                                    <v-icon :title="isEditing?'Save':'Edit'" :key="`icon-${isEditing}`" color="primary" :disabled="!action.edit || disabled"
                                                            @click="saveAnomalies(items_anomaly)" v-text="isEditing?'mdi-content-save':'mdi-circle-edit-outline'">
                                                    </v-icon>
                                                    <v-icon title="Reset/Undo" v-if="isEditing" class="pl-2" color="primary" :disabled="!action.edit || disabled"
                                                            @click="resetAnomalies(items_anomaly)">mdi-undo-variant
                                                    </v-icon>
                                                </template>
                                            </v-autocomplete>
                                        </v-col>
                                    </v-row>
                                </v-card>
                            </v-tab-item>
                            <!-- Trauma Vertical Tabs-->
                            <v-tab-item>
                                <v-card flat>
                                    <v-card>
                                        <v-card-title>
                                            <v-btn color="primary" class="mb-2" @click="eventNewGo('trauma')"><v-icon left>mdi-plus-circle</v-icon>Create New</v-btn>
                                            <v-spacer></v-spacer>
                                            <v-text-field v-model="search_trauma" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
                                        </v-card-title>
                                        <v-card-text>
                                            <v-data-table :headers="headers_trauma" :items="items_trauma" :search="search_trauma" :disabled="disabled" :loading="loading" >
                                                <template v-slot:item.action="{ item }">
                                                    <v-icon color="primary" class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
                                                    <v-icon color="error" @click="deleteItem(item)">mdi-delete</v-icon>
                                                </template>
                                            </v-data-table>
                                        </v-card-text>
                                    </v-card>
                                </v-card>
                            </v-tab-item>
                        </v-tabs>
                    </v-card>
                </v-col>
            </v-row>
        </v-card>
    </div>
</template>

<script>
    import Pathologies from "./Pathologies";
    import Trauma from "./Trauma";
    import Anomalies from "./Anomalies";
    import IsotopeVAutoComplete from "../commonvuetifycomponents/IsotopeVAutoComplete";
    import AdditionalInformation from "./AdditionalInformation";
    import {apiGetCallAxios} from "../../../coraBaseModules";
    import {mapGetters, mapState} from "vuex";
    import {eventBus} from "../../../eventBus";
    import axios from "axios";

    export default {
        name: "patComponenet",
        props: {
            specimen: {type: Object, required: true},
            pat_type: { type: String, default: "Pathology" },
            crud_action: { type: String, default: "Edit" },
            heading: { type: String, default: "Pathology" },
            toolbar:{type:Boolean, default: true},
            toolbar_crud:{type:Boolean, default: true},
            contentheader: {type:Boolean, default: true},
            cols: {type:Number, default: 12},
            list: {type: Object, },
            readonly: {type: Boolean, default: false},
            disabled: {type:Boolean, default: false},
        },
        data() {
            return {
                loading: false,
                show_new: true,
                show_save:false,
                show_edit:false,
                show_reset:false,
                isCollapse: true,
                isEditing: false,
                show_toolbar: this.toolbar,
                show_toolbar_crud: this.toolbar_crud,
                show_contentheader: this.contentheader,
                trail: [{ text: 'Home', disabled: false, href: '/', },
                    { text: 'Specimen', disabled: false, href: (this.specimen) ? '/skeletalelements/'+this.specimen.id : "/" },
                    { text: 'Pathology', disabled: true, href: "/" },
                ],
                headers_pathology: [
                    { text: 'Pathology', value: 'name', width: '4rem', visibility: true },
                    { text: 'Zone', value: 'zone_name', width: '4rem', visibility: true },
                    { text: 'Additional Information', value: 'additional_information', width: '16rem', visibility: true },
                    { text: 'Created By', value: 'created_by', width: '4rem', visibility: true },
                    { text: 'Created At', value: 'created_at', width: '4rem', visibility: true },
                    { text: 'Actions', value: 'action', sortable: false, width: '3rem', visibility: true },
                ],
                headers_trauma: [
                    { text: 'Trauma', value: 'name', width: '4rem', visibility: true },
                    { text: 'Zone', value: 'zone_name', width: '4rem', visibility: true },
                    { text: 'Additional Information', value: 'additional_information', width: '16rem', visibility: true },
                    { text: 'Created By', value: 'created_by', width: '4rem', visibility: true },
                    { text: 'Created At', value: 'created_at', width: '4rem', visibility: true },
                    { text: 'Actions', value: 'action', sortable: false, width: '3rem', visibility: true },
                ],
                // tabs
                search: "",
                search_pathology: "",
                search_trauma: "",
                tab: 0, // 0-Pathology, 1-Anomaly, 2-Trauma
                tab_items: [
                    {index: 0, text: 'Pathology', icon: 'mdi-flask-outline', search: 'Pathology', visibility: true},
                    {index: 1, text: 'Anomaly', icon: 'mdi-flash', search: 'Anomaly', visibility: true},
                    {index: 2, text: 'Trauma', icon: 'mdi-pistol', search: 'Trauma', visibility: true},
                ],
                items_pathology: [],
                items_trauma: [],
                items_anomaly: [],
                zones: [],
                pathologies: [],
                traumas: [],
                anomalies: [],
                cached_items_anomaly: [],
                alert: false,
                alertText: "",
            }
        },
        created() {
            console.log('PAT Component created.');

            // Next get the list of all possible methods & related features for the specimen
            let payload = { 'type': 'pathologies', 'list': true };
            this.$store.dispatch('fetchAppList', payload).then(() => this.loading = false);
            payload = { 'type': 'traumas', 'list': true };
            this.$store.dispatch('fetchAppList', payload).then(() => this.loading = false);
            payload = { 'type': 'anomalies', 'list': true };
            this.$store.dispatch('fetchAppList', payload).then(() => this.loading = false);
            payload = { 'type': 'zones', 'list': true };
            this.$store.dispatch('fetchAppList', payload).then(() => this.loading = false);

            eventBus.$on('refresh-list', payload => {
                if ((payload.list) && (payload.list === "Pathology" || (payload.list === "Trauma"))) {
                    location.reload() // Relaod to refresh updated lists
                    // this.getPat();
                }
            });
        },
        beforeMount() {
            // Make a copy, because you cannot change vuex state from outside.
            // Here we need to change by adding score.
            // this.items = JSON.parse ( JSON.stringify (this.getMethodsByBone(this.specimen.sb_id) ));
        },
        mounted() {
            this.pathologies = this.$store.getters.getPathologies;
            this.traumas = this.$store.getters.getTraumas;
            this.anomalies = this.$store.getters.getAnomaliesByBone(this.specimen.sb.id);
            this.zones = this.$store.getters.getZonesByBone(this.specimen.sb.id);

            this.getPat();
            this.tab = (this.pat_type === "Trauma") ? 2 : (this.pat_type === "Anomaly") ? 1 : 0;
        },
        methods: {
            eventNewGo(val) {
                console.log('Pathology eventNewGo - captured event: ' + val);
                if (val === "pathologies" || val === "pathology" || val === "traumas" || val === "trauma") {
                    console.log('Tab: ' + this.tab);
                    let type = this.tab_items[this.tab].text;
                    let payload = { 'title': 'Create New '+type, 'action': 'Create', 'type': type};
                    eventBus.$emit('show-crud-dialog', payload);
                }
            },
            editItem(item) {
                let type = this.tab_items[this.tab].text;
                console.log("tab: "+ this.tab);
                console.log("tab_item: "+ JSON.stringify(this.tab_items[this.tab]));
                let payload = { 'title': 'Edit '+type, 'action': 'Edit', 'type': type, 'item': item };
                eventBus.$emit('show-crud-dialog', payload);
            },
            deleteItem(item) {
                let type = this.tab_items[this.tab].text;
                let payload = { 'title': 'Delete '+type, 'action': 'Delete', 'type': type, 'item': item };
                eventBus.$emit('show-crud-dialog', payload);
            },
            count_for(type) {
                if (type === "Pathology") {
                    return this.items_pathology.length.toString();
                } else if (type === "Anomaly") {
                    return this.items_anomaly.length.toString();
                } else if (type === "Trauma") {
                    return this.items_trauma.length.toString();
                } else {
                    return "";
                }
            },
            getPat: function () {
                this.loading = true;
                let url = "/api/specimens/" + this.specimen.id + "/pat";
                axios
                    .request({ url: url, method: 'GET',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization': this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        console.log("PAT: "+JSON.stringify(response.data.data));
                        this.items_pathology = response.data.data[0].pathologys;
                        console.log("Pathology: "+JSON.stringify(this.items_pathology));
                        let zones = this.zones;
                        this.items_pathology.forEach((item, index) => {
                            item.zone_id = item.pivot.zone_id;
                            item.zone_ids = [];
                            (item.zone_id) ? item.zone_ids.push(item.zone_id) : null;
                            item.zone = (item.pivot.zone_id) ? zones.find(el => { return el.id === item.pivot.zone_id}) : null;
                            item.zone_name = (item.zone) ? item.zone.display_name : null;
                            item.additional_information = item.pivot.additional_information;
                            item.created_by = item.pivot.created_by;
                            item.created_at = item.pivot.created_at;
                        })

                        this.items_trauma = response.data.data[0].traumas;
                        console.log("Traumas: "+JSON.stringify(this.items_trauma));
                        this.items_trauma.forEach((item, index) => {
                            item.zone_id = item.pivot.zone_id;
                            item.zone_ids = [];
                            (item.zone_id) ? item.zone_ids.push(item.zone_id) : null;
                            item.zone = (item.pivot.zone_id) ? zones.find(el => { return el.id === item.pivot.zone_id}) : null;
                            item.zone_name = (item.zone) ? item.zone.display_name : null;
                            item.additional_information = item.pivot.additional_information;
                            item.created_by = item.pivot.created_by;
                            item.created_at = item.pivot.created_at;
                        })

                        this.items_anomaly = response.data.data[0].anomalys;
                        this.cached_items_anomaly = this.items_anomaly;
                        console.log("Anomaly: "+JSON.stringify(this.items_anomaly));
                        this.loading = false
                    })
                    .catch(error => {
                        let payload = {'text': 'Pathologies (PAT) request failed', 'color': 'error',};
                        eventBus.$emit('show-snackbar', payload);
                        this.loading = false;
                    });
            },
            // Deprecated or not being used.
            getPathologyData: function () {
                this.loading = true;
                apiGetCallAxios("/api/specimens/" + this.specimen.id + "/associations?type=pathologies").then(response => {
                    this.items_pathology = response.data.data;
                    let zones = this.zones;
                    this.items_pathology.forEach((item, index) => {
                        item.zone = (item.zone_id) ? zones.find(el => { return el.id === item.zone_id}) : null;
                        item.zone_name = (item.zone) ? item.zone.display_name : null;
                    })
                    console.log("Traumas: "+this.items_pathology);
                    this.loading = false
                });
            },
            // Deprecated or not being used.
            getTraumaData: function () {
                this.loading = true;
                apiGetCallAxios("/api/specimens/" + this.specimen.id + "/associations?type=traumas").then(response => {
                    this.items_trauma = response.data.data;
                    let zones = this.zones;
                    this.items_trauma.forEach((item, index) => {
                        item.zone = (item.zone_id) ? zones.find(el => { return el.id === item.zone_id}) : null;
                        item.zone_name = (item.zone) ? item.zone.display_name : null;
                    })
                    console.log("Traumas: "+this.items_trauma);
                    this.loading = false
                });
            },
            // Deprecated or not being used.
            getAnomalyData: function () {
                this.loading = true;
                apiGetCallAxios("/api/specimens/" + this.specimen.id + "/associations?type=anomalys").then(response => {
                    this.items_anomaly = response.data.data;
                    this.cached_items_anomaly = this.items_anomaly;
                    console.log("Anomaly: "+this.items_anomaly);
                    this.loading = false
                });
            },
            saveAnomalies(selected) {
                if (this.isEditing) {
                    this.loading = true;
                    let url = '/api/specimens/'+this.specimen.id+'/associations';
                    let data = { type: "anomalys", listIds: this.items_anomaly.map(tag => tag.toString()), };
                    console.log("Data: "+JSON.stringify(data));
                    axios
                        .request({ url: url, method: 'PUT',
                            headers:{ 'Content-Type' : 'application/json', 'Authorization': this.$store.getters.bearerToken, },
                            data: { type: "anomalys", listIds: this.items_anomaly.map(tag => tag.toString()), },
                        })
                        .then(response=>{
                            console.log("Response: "+JSON.stringify(response.data.data));
                            this.items_anomaly = response.data.data.map(tag=>tag.id);
                            let payload = {'text': 'Anomalies successfully saved', 'color': 'success',};
                            eventBus.$emit('show-snackbar', payload);
                            this.loading = false;
                            this.cached_items_anomaly = Object.assign([], this.items_anomaly);
                        })
                        .catch(error => {
                            let payload = {'text': 'Anomalies Update failed', 'color': 'error',};
                            eventBus.$emit('show-snackbar', payload);
                            this.loading = false;
                        });
                }
                this.isEditing = !this.isEditing;
            },
            resetAnomalies() {
                this.items_anomaly = this.cached_items_anomaly;
                this.isEditing = !this.isEditing;
            },
        },
        watch: {},
        components: {
            Pathologies,
            Trauma,
            Anomalies,
            IsotopeVAutoComplete,
            AdditionalInformation,
        },
        computed: {
            ...mapState({
                perPage: state => state.search.perPage,
                rowsPerPageItems: state => state.search.rowsPerPageItems,
                bones: state => state.bones,
                base_url: state => state.baseURL,
            }),
            ...mapGetters({
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
                bearerToken: 'bearerToken',
                csrfToken: 'csrfToken',
                getPathologies: 'getPathologies',
                getTraumas: 'getTraumas',
                getAnomalies: 'getAnomalies',
                getAnomaliesByBone: 'getAnomaliesByBone',
                getZones: 'getZones',
                getZonesByBone: 'getZonesByBone',
            }),
            action() {
                const act = this.crud_action;
                return { create: act === "Create", view: act === "View", edit: (act === "Update" || act === "Edit"), list: act === "List", };
            },
        },
    }
</script>
