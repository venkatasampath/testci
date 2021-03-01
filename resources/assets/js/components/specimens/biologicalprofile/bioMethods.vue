<template>
    <div class="m-2">
        <contentheader v-if="show_contentheader" :trail="trail" :title="heading" :se_action_menu="true" :specimen="(action.create) ? null : specimen">
        </contentheader>
        <v-alert v-if="alert" class="my-1" border="left" colored-border type="info" elevation="2" dismissible>{{alertText}}</v-alert>
        <specimen-highlights v-if="show_contentheader" :specimen="specimen"></specimen-highlights>
        <v-card flat>
            <v-row align="center" justify="center">
                <v-col cols="12" :md="cols" class="py-0">
                    <v-toolbar v-if="show_toolbar">
                        <v-badge v-if="methods && methodfeatures" color="primary" :content="this.methods.length.toString() + '/' + this.items.length.toString()">Methods</v-badge>
                        <v-spacer></v-spacer>
                        <v-btn icon @click="showCollapse = !showCollapse" color="primary">
                            <v-icon title="Collaspe" v-if="showCollapse" :loading="loading">mdi-arrow-collapse-up</v-icon>
                            <v-icon title="Expand" v-if="!showCollapse" :loading="loading">mdi-arrow-expand-down</v-icon>
                        </v-btn>
                    </v-toolbar>

                    <div v-if="showCollapse && methods && methodfeatures">
                        <v-tabs v-model="tab" background-color="transparent" grow>
                            <v-tab v-if="count_items(tab_item.search)" v-for="tab_item in tab_items" :key="tab_item.index" @click="search = tab_item.search">
                                <v-icon class="mr-2">{{tab_item.icon}}</v-icon>
                                <v-badge color="primary" :content="count_methods(tab_item.search).toString() + '/' + count_items(tab_item.search).toString()">{{ tab_item.text }}</v-badge>
                            </v-tab>
                        </v-tabs>
                        <!-- We filter (using search) datatable based on tab selection -->
                        <v-data-table :headers="columnVisibility" :items="items" :items-per-page="10" calculate-widths="" class="elevation-1"
                                      :sort-by="['type', 'name']" multi-sort :loading="loading" :search="search">
                            <!--                        <template v-slot:item="{ item, index }">-->
                            <!--                        </template>-->
                            <template v-slot:item.uses_feature_score="{ item }">
                                <v-icon right :color= "getIconColor(item.uses_feature_score)">{{ getBooleanIcon(item.uses_feature_score) }}</v-icon>
                            </template>
                            <template v-slot:item.action="{ item }">
                                <v-icon v-if="!item.present" title="Create" class="mr-2" color="primary" @click="createMethod(item)">mdi-plus-circle</v-icon>
                                <v-icon v-if="item.present" title="View" class="mr-2" color="primary" @click="viewMethod(item)">mdi-eye</v-icon>
                                <v-icon v-if="item.present" title="Edit" class="mr-2" color="primary" @click="editMethod(item)">mdi-pencil</v-icon>
                                <v-icon v-if="item.present" title="Delete" class="mr-2" color="error" @click="deleteMethod(item)">mdi-delete</v-icon>
                            </template>
                        </v-data-table>

                        <!-- Method Features for new or selected method-->
                        <v-card v-if="show_methodfeatures && selected_method">
                            <v-card-title class="m-0 p-0">
                                <v-toolbar class="mb-2" dense>
                                    <v-btn icon><v-icon color="gray" class="p-2">mdi-bio</v-icon></v-btn>
                                    <v-spacer></v-spacer>
                                    <v-toolbar-title>Method Features: {{selected_method.name}}</v-toolbar-title>
                                    <v-spacer></v-spacer>
                                    <v-progress-circular v-if="loading_methodfeatures" :indeterminate="loading" color="primary"></v-progress-circular>
                                    <v-btn icon @click="closeMethod"><v-icon>mdi-close</v-icon></v-btn>
                                </v-toolbar>
                            </v-card-title>
                            <v-card-text class="mt-4">
                                <v-list subheader dense>
                                    <v-list-item dense v-for="feature in selected_method.features" :key="feature.feature" @click="" :disabled="selected_method_action.view || selected_method_action.delete ">
                                        <v-list-item-content>
                                            <v-autocomplete v-model="feature.score" :label="feature.display_name" :hint="feature.display_help"
                                                            :items="convert_feature_display_values(feature.display_values)" item-value="value" item-text="text"
                                                            @change="calc_computed_feature(feature)" persistent-hint dense :clearable="!feature.computed" :readonly="feature.computed">
                                            </v-autocomplete>
                                        </v-list-item-content>
                                        <v-list-item-content class="ml-4">
                                            <v-autocomplete v-if="feature.score && feature.display_interval" v-model="feature.score" :label="selected_method.type + ' Range or Interval'"
                                                            :items="convert_feature_display_values(feature.display_interval)" item-value="value" item-text="text" dense readonly>
                                            </v-autocomplete>
                                        </v-list-item-content>
                                    </v-list-item>
                                </v-list>
                            </v-card-text>
                            <v-divider class="m-0 p-0"></v-divider>
                            <v-card-actions v-if="selected_method_action.edit || selected_method_action.create">
                                <v-row align="center" justify="center" class="m-0 p-0">
                                    <v-btn color="primary" text @click="save" :disabled="!selected_method.features.some(e => (typeof e.score !== 'undefined'))"><v-icon class="p-2">mdi-content-save</v-icon>Save</v-btn>
                                    <v-btn color="primary" text @click="closeMethod"><v-icon class="p-2">mdi-cancel</v-icon>Cancel</v-btn>
                                </v-row>
                            </v-card-actions>
                            <v-card-actions v-else-if="selected_method_action.delete">
                                <v-row align="center" justify="center" class="m-0 p-0">
                                    <span color="warning"><v-icon color="warning" class="p-2">mdi-alert</v-icon>Are you sure you want to delete this item?</span>
                                    <v-btn color="error" text @click="trash"><v-icon class="p-2">mdi-delete</v-icon>Delete</v-btn>
                                    <v-btn color="primary" text @click="closeMethod"><v-icon class="p-2">mdi-cancel</v-icon>Cancel</v-btn>
                                </v-row>
                            </v-card-actions>
                        </v-card>
                    </div>
                </v-col>
            </v-row>
        </v-card>
    </div>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import {eventBus} from "../../../eventBus";
    import axios from 'axios';

    export default {
        name: "bio-methods",
        props: {
            specimen: {type: Object, required: true},
            method_type: { type: String, default: "Age" },
            crud_action: { type: String, default: "Edit" },
            heading: { type: String, default: "Methods" },
            toolbar:{type:Boolean, default: true},
            toolbar_crud:{type:Boolean, default: true},
            contentheader: {type:Boolean, default: true},
            cols: {type:Number, default: 12},
            readonly: {type: Boolean, default: false},
        },
        data() {
            return {
                methods: null,
                methodfeatures: null,
                type:'methods',
                errored: null,
                isEditing: false,
                loading: false,
                loading_methodfeatures: false,
                showCollapse:true,
                showSave:false,
                showEdit:false,
                showReset:false,
                show_toolbar: this.toolbar,
                show_toolbar_crud: this.toolbar_crud,
                show_contentheader: this.contentheader,
                trail: [{ text: 'Home', disabled: false, href: '/', },
                    { text: 'Specimen', disabled: false, href: (this.specimen) ? '/skeletalelements/'+this.specimen.id : "/" },
                    { text: 'Biological Profile', disabled: true, href: "/" },
                ],
                headers: [
                    {text: 'Type', value: 'type', width: '3rem', visibility: true},
                    {text: 'Name', value: 'name', width: '6rem', visibility: true},
                    {text: 'Sub Method', value: 'submethod', width: '3rem', visibility: true},
                    {text: 'Reference', value: 'reference', width: '10rem', visibility: true},
                    {text: 'Description', value: 'description', width: '8rem', visibility: true},
                    {text: 'Uses Feature Scoring', value: 'uses_feature_score', width: '4rem', visibility: true},
                    {text: 'Action', value: 'action', width: '6rem', visibility:true}
                ],
                method_steps: [
                    {text: 'All', icon: 'mdi-clipboard-text-multiple', step: '1', visibility: true},
                    {text: 'Age', icon: 'mdi-pound', step: '2', visibility: true},
                    {text: 'Sex', icon: 'mdi-human-male-female', step: '3', visibility: true},
                    {text: 'Ancestry', icon: 'mdi-tree', step: '4', visibility: true},
                    {text: 'Stature', icon: 'mdi-human-male-height', step: '5', visibility: true},
                ],
                items: [],
                selected_method: null,
                selected_method_action: { create: false, view: false, edit: false, delete: false },
                current_method_step: 1,
                show_methodfeatures: true,
                alert: false,
                alertText: "",
                methods_badge: "",
                preparedMethodFeatures: {},

                // tabs
                search: "",
                tab: 0,
                tab_items: [
                    {index: 0, text: 'All', icon: 'mdi-clipboard-text-multiple', search: '', visibility: true},
                    {index: 1, text: 'Age', icon: 'mdi-pound', search: 'Age', visibility: true},
                    {index: 2, text: 'Sex', icon: 'mdi-human-male-female', search: 'Sex', visibility: true},
                    {index: 3, text: 'Ancestry', icon: 'mdi-tree', search: 'Ancestry', visibility: true},
                    {index: 4, text: 'Stature', icon: 'mdi-human-male-height', search: 'Stature', visibility: true},
                ],
            };
        },
        created() {
            console.log('Specimen Component created.');
            // First get the methods and method features for the specimen
            this.getMethods();
            this.getMethodFeatures();

            // Next get the list of all possible methods & related features for the specimen
            let payload = { 'type': 'methods', 'list': true };
            this.$store.dispatch('fetchAppList', payload).then(() => this.loading = false);
        },
        beforeMount() {
            // Make a copy, because you cannot change vuex state from outside.
            // Here we need to change by adding score.
            this.items = JSON.parse ( JSON.stringify (this.getMethodsByBone(this.specimen.sb_id) ));
        },
        mounted() {
            // Iterate over all the methods that are present for this specimen.
            // Find method in items array and set present flag for that specific method
            // let items = this.items;
            // this.methods.forEach(function (el, index) {
            //     let item = items.find(data => {return data.id === el.id});
            //     item.present = !!(item);
            // });
            // // Iterate over the methods features for this specimen.
            // // Find all method features in items array and set the score for the method features
            // this.methodfeatures.forEach(function (el, index) {
            //     let item = items.find(data => {return data.id === el.method_id});
            //     let feature = item.features.find(data => {return data.id === el.id});
            //     feature.score = el.pivot.score;
            //     if (feature) {
            //         feature.score = el.pivot.score;
            //     }
            // });

            let type = this.search = this.method_type;
            this.tab = this.tab_items.findIndex((element) => element.text === type);
        },
        methods:{
            // ToDO this function will get replaced
            //get the method values associated with current specimen
            getMethods: function() {
                this.loading=true;
                axios
                    .request({
                        url: this.base_url+'/api/specimens/'+this.specimen.id+'/associations/methods',
                        method: 'GET',
                        headers:{
                            'Content-Type' : 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        }
                    })
                    .then(response=>{
                        // this.methods = response.data.data.map(method=>method.id);
                        this.methods = response.data.data[0].methods;
                        console.log("this.data: "+JSON.stringify(this.methods));
                        // Iterate over all the methods that are present for this specimen.
                        // Find method in items array and set present flag for that specific method
                        let items = this.items;
                        this.methods.forEach(function (el, index) {
                            let item = items.find(data => {return data.id === el.id});
                            item.present = !!(item);
                        });
                        this.loading=false;
                        this.cachedMethods = Object.assign([], this.methods);
                    })
                    .catch(error => {
                        this.errored = true
                    });
            },
            getMethodFeatures: function() {
                this.loading=true;
                axios
                    .request({
                        url: this.base_url+'/api/specimens/'+this.specimen.id+'/associations?type=methodfeatures',
                        method: 'GET',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization': this.$store.getters.bearerToken, }
                    })
                    .then(response=>{
                        this.methodfeatures = response.data.data;
                        // // Iterate over the methods features for this specimen.
                        // // Find all method features in items array and set the score for the method features
                        let items = this.items;
                        this.methodfeatures.forEach(function (el, index) {
                            let item = items.find(data => {return data.id === el.method_id});
                            let feature = item.features.find(data => {return data.id === el.id});
                            if (feature) { feature.score = el.score; }
                        });
                        this.loading=false;
                        this.cachedMethodFeatures = Object.assign([], this.methodfeatures);
                    })
                    .catch(error => {
                        this.errored = true
                    });
            },
            edit() {
                this.isEditing = !this.isEditing;
            },
            reset() {
                this.methods = Object.assign([], this.cachedMethod);
                this.isEditing = !this.isEditing;
            },
            save() {
                let url = '/api/specimens/' + this.specimen.id + '/associations';
                let data = [];
                if (this.selected_method_action.create) {
                    this.methods.push(this.selected_method);
                    // let methodsArray = [];
                    // this.methods.forEach(function (el, index) {
                    //     methodsArray[index] = el.id;
                    // });
                    // data = methodsArray.map(data => data.toString());
                    // console.log("Create: MethodsArray: " + JSON.stringify(data));

                    this.prepareMethodFeaturesForSave();
                    data = { "type": "methodfeatures", "method_id": this.selected_method.id.toString(), "listIds": this.preparedMethodFeatures };
                    console.log("Create: MethodsArray: data: " + JSON.stringify(data));
                } else if (this.selected_method_action.edit) {
                    this.prepareMethodFeaturesForSave();
                    data = { "type": "methodfeatures", "method_id": this.selected_method.id.toString(), "listIds": this.preparedMethodFeatures };
                    console.log("Edit: MethodsArray: data: " + JSON.stringify(data));
                }

                axios
                    .request({ url: url, method: 'PUT', data: data,
                        headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken, },
                    })
                    .then(response => {
                        let payload = { 'text': 'Method and Features update successful', 'color': 'success', };
                        eventBus.$emit('show-snackbar', payload);
                        location.reload(); // relaod the current page
                    })
                    .catch(error => {
                        let payload = { 'text': 'Method and Features update failed', 'color': 'error', };
                        eventBus.$emit('show-snackbar', payload);
                    });
                this.isEditing = !this.isEditing;
            },
            trash() {
                let url = '/api/specimens/' + this.specimen.id + '/associations';
                let data = [];
                if (this.selected_method_action.delete) {
                    let current_method_id = this.selected_method.id;
                    // Remove the selected method
                    this.methods = this.methods.filter(data => {return data.id === current_method_id});
                    this.prepareMethodFeaturesForSave();
                    data = { "type": "methods", "method_id": this.selected_method.id.toString(), "listIds": this.preparedMethodFeatures };
                    console.log("Delete: MethodsArray: data: " + JSON.stringify(data));
                }

                axios
                    .request({ url: url, method: 'DELETE', data: data,
                        headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken, },
                    })
                    .then(response => {
                        let payload = { 'text': 'Method and Features delete successful', 'color': 'success', };
                        eventBus.$emit('show-snackbar', payload);
                        location.reload(); // relaod the current page
                    })
                    .catch(error => {
                        let payload = { 'text': 'Method and Features delete failed', 'color': 'error', };
                        eventBus.$emit('show-snackbar', payload);
                    });
                this.show_methodfeatures = false;
            },
            remove(item) {
                const index = this.methods.indexOf(item.id);
                if (index >= 0) this.methods.splice(index, 1)
            },
            getBooleanIcon(item) {
                return item === true ? '✔' : 'x'
            },
            getIconColor(item) {
                return item === true ? 'success' : 'error'
            },
            createMethod(item) {
                this.selected_method_action = { create: true, view: false, edit: false, delete: false };
                this.selected_method = item;
                this.show_methodfeatures = true;
            },
            editMethod(item) {
                this.selected_method_action = { create: false, view: false, edit: true, delete: false };
                this.selected_method = item;
                this.show_methodfeatures = true;
            },
            deleteMethod(item) {
                this.selected_method_action = { create: false, view: false, edit: false, delete: true };
                this.selected_method = item;
                this.show_methodfeatures = true;
            },
            viewMethod(item) {
                this.selected_method_action = { create: false, view: true, edit: false, delete: false };
                this.selected_method = item;
                this.show_methodfeatures = true;
            },
            closeMethod() {
                let current_method_id = this.selected_method.id;
                this.show_methodfeatures = false;
                this.selected_method = null;
                let item = this.methods.find(data => {return data.id === current_method_id});
                if (!item) {
                    return;
                }

                // Find the selected method in the items array. Iterate over the features of the selected item.
                // and replace of scores of the selected item features form the original method features
                item = this.items.find(data => {return data.id === current_method_id});
                console.log("Item: "+JSON.stringify(item));
                let methodfeatures = this.methodfeatures;
                item.features.forEach(function (el, index) {
                    let feature = methodfeatures.find(data => {return data.id === el.id});
                    console.log("Feature: "+JSON.stringify(feature));
                    el.score = feature.pivot.score;
                });
            },
            convert_feature_display_values(items) {
                const returnItems = [];
                let objItems = JSON.parse(items);
                // console.log("JSON parse: items: " + objItems);
                for (let key in objItems) {
                    returnItems.push({ value: key, text: objItems[key]});
                }
                // console.log("Convert: " + JSON.stringify(returnItems));
                return returnItems;
            },
            setScoresForSelectedMethod(item) {
                if (!item) {
                    item = this.selected_method;
                }

                for (let feature of item.features) {
                    let sel = this.methodfeatures.find(el => { return el.id === feature.id});
                    if (sel) {
                        return feature.score = sel.score;
                    }
                }
            },
            getMethodFeatureScore(item) {
                let sel = this.methodfeatures.find(el => { return el.id === item.id});
                if (sel) {
                    return item.score = sel.score;
                }
                return null;
            },
            calc_computed_feature(feature) {
                // ToDo: This needs to be updated to have more generic logic.
                if (this.selected_method.uses_composite_score) {
                    // console.log("selected_method " + this.selected_method.name + " uses composite score")
                    let computed_features = this.selected_method.features.filter(el => el.computed === true)
                    // console.log("number of computed_features: " + computed_features.length);
                    // console.log("computed method features are: " + JSON.stringify(computed_features));
                    for (let computed_feature of computed_features) {
                        let compute_rule = computed_feature.compute_rule;
                        // console.log("compute_rule: " + compute_rule)
                        compute_rule = compute_rule.split(',');
                        let score = 0;
                        for (let rule of compute_rule) {
                            // console.log("rule: " + rule);
                            let f = this.selected_method.features.find(el => el.feature === rule)
                            // console.log("f: " + JSON.stringify(f))
                            score += (f.score && !f.computed) ? parseInt(f.score) : 0;
                        }
                        computed_feature.score = score.toString();
                        console.log("computed_feature: " + JSON.stringify(computed_feature))
                    }

                    // swap to null and back to get reactivity.
                    let swap = this.selected_method;
                    this.selected_method = null;
                    this.selected_method = swap;
                }
            },
            isMethodPresentOrSelected(item) {
                if (this.selected_method) {
                    if (item.id === this.selected_method.id) {
                        return "primary";
                    }
                }
                return (item.present) ? "success" : "";
            },
            prepareMethodFeaturesForSave() {
                let features = this.selected_method.features;
                // console.log("prepareMethodFeaturesForSave features count:"+features.length);
                this.preparedMethodFeatures = {};
                for (var i = 0; i < features.length; i++) {
                    if (features[i].score) {
                        Vue.set(this.preparedMethodFeatures, features[i].id.toString(), {
                            "id": features[i].id.toString(),
                            "method_id": features[i].method_id.toString(),
                            "score": features[i].score.toString()
                        })
                    }
                }
            },
            items_for(type) {
                return (type === "") ? this.items : this.items.filter(data => {return data.type === type});
            },
            count_items(type) {
                return this.items_for(type).length;
            },
            methods_for(type) {
                return (type === "") ? this.methods : this.methods.filter(data => {return data.type === type});
            },
            count_methods(type) {
                return this.methods_for(type).length;
            },
        },
        watch: {
            'selected_method': function() {
                if (this.selected_method) {
                    console.log("Watch: selected_method changed: "+this.selected_method.id+" - " + this.selected_method.name);
                } else {
                    console.log("Watch: selected_method changed: null");
                }
            },
        },
        computed: {
            ...mapState({
                base_url: state => state.baseURL,
            }),
            ...mapGetters({
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
                bearerToken: 'bearerToken',
                csrfToken: 'csrfToken',
                getMethodsByBone: 'getMethodsByBone',
            }),
            columnVisibility() {
                return this.headers.filter(item => item.visibility === true);
            },
            action() {
                const act = this.crud_action;
                return { create: act === "Create", view: act === "View", edit: (act === "Update" || act === "Edit"), list: act === "List", };
            },
        },
    }
</script>