<template>
    <div>
        <v-progress-linear v-if="loading" indeterminate color="cyan"></v-progress-linear>
        <v-card>
            <v-card-title>
                <v-row class="align-center justify-center">
                    <v-col>
                        <v-row class="align-center justify-center"><span>Original</span></v-row>
                    </v-col>
                    <v-col>
                        <v-row class="align-center justify-center"><span>Review</span></v-row>
                    </v-col>
                </v-row>
            </v-card-title>
            <v-card-text>
                <v-expansion-panels v-for="(item, index) in Features" :key="index">
                    <v-expansion-panel>
                        <v-expansion-panel-header>
                            <v-row class="align-center justify-center"><span>{{ displayName(item[0].method_id, 'type') }} - {{displayName(item[0].method_id, 'name')}}</span>
                            </v-row>
                        </v-expansion-panel-header>
                        <v-expansion-panel-content>
                            <v-row>
                                <v-col cols="6">
                                    <v-autocomplete v-for="(feature,index) in item" :key="feature.id"
                                                    :label="feature.display_name"
                                                    :items="menu(JSON.parse(feature.display_values))" item-text="text"
                                                    item-value="value" v-model="state.original[feature.id].score"
                                                    disabled readonly>

                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="6">
                                    <v-autocomplete v-for="(feature, index) in item" :key="feature.id"
                                                    :label="feature.display_name"
                                                    :items="menu(JSON.parse(feature.display_values))" item-text="text"
                                                    item-value="value" v-model="state.review[feature.id].score">

                                    </v-autocomplete>
                                </v-col>
                            </v-row>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>

            </v-card-text>
            <v-card-actions>
                <v-row class="justify-center">
                    <v-btn v-if="show_save" color="primary" class="mr-2" @click="save">
                        <v-icon class="mr-2" dusk="methods-review-save">mdi-content-save</v-icon>
                        Save
                    </v-btn>
                    <v-btn v-if="show_accept" color="primary" @click="accept">
                        <v-icon class="mr-2" dusk="methods-review-accept">mdi-thumb-up-outline</v-icon>
                        Accept
                    </v-btn>
                </v-row>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
    import axios from 'axios';
    import {changeObjectToArray, apiGetCall, apiPostCallZones, apiPostCall} from '../../../coraBaseModules';
    import {mapGetters, mapState} from "vuex";
    import {eventBus} from "../../../eventBus";

    export default {
        name: "review-methods",
        props: {
            specimen: {
                type: Object | Array,
                required: true,
            }
        },
        data() {
            return {
                loading: true,
                fully_loaded: false,
                show_save: true,
                show_accept: false,
                state: {
                    type: this.type,
                    original: [],
                    review: [],
                    diff: null,
                    action: {
                        create: false,
                        edit: false,
                    },
                    reviewRecord: null,
                },
                hint: "",
                select_all: true,
                intermediateState: true,
                Methods: [],
                Features: [],
                items: [],
                errored: false
            }
        },
        created() {
            this.show_save = (this.theUser.id !== this.specimen.user_id) || (this.isAdminOrOrgAdmin || this.isProjectManager);
            this.show_accept = (this.theUser.id === this.specimen.user_id) || (this.isAdminOrOrgAdmin || this.isProjectManager);
        },
        beforeMount() {

        },
        mounted() {
            this.loadOriginal();
        },
        updated() {

        },
        methods: {
            loadOriginal() {
                console.log('entered Load Methods');
                this.show = true;
                var data = [];
                axios({
                    url: "/api/specimens/" + this.specimen.id + "/associations?type=methodfeatures",
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': this.$store.getters.bearerToken,
                    },
                }).then((response) => {
                    response.data.data.map(item => this.Methods.includes(item.method_id) ? "" : this.Methods.push(item.method_id));
                    this.Methods.map(method => this.Features.push(this.getMethodFeaturesByMethodId(method)));
                    var method;
                    var originaldata = {};
                    var reviewdata = {};

                    for (var item in response.data.data) {
                        method = response.data.data[item];
                        Vue.set(originaldata, method.method_feature_id, {
                            "method_id": method.method_id,
                            "score": method.score,
                            "feature_id": method.method_feature_id,
                        });
                        Vue.set(reviewdata, method.method_feature_id, {
                            "method_id": method.method_id,
                            "score": "",
                            "feature_id": method.method_feature_id
                        });
                    }

                    this.loadReview();
                    this.state.original = originaldata;
                    this.state.review = reviewdata;
                    this.loading = false;

                }).catch(error => {
                    this.loading = false;
                    // uncomment for debugging
                    this.errored = true
                });
                return data;
            },
            loadReview() {
                this.loading = true;
                axios({
                    url: "/api/review/" + this.specimen.id, method: 'GET',
                    headers: {'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken,},
                    params: {"type": 'methods'},
                }).then((response) => {

                    if (response.data.data.review) {
                        let responseData = JSON.parse(response.data.data.review);
                        let score = '';
                        for (const item in responseData.methods) {
                            for (const item2 in responseData.methods[item].features) {
                                score = responseData.methods[item].features[item2].score;
                                this.state.review[item2].score = score.toString();
                            }
                        }

                    }
                    if (this.fully_loaded) {
                        eventBus.$emit('review', {'type': this.state.type, 'state': this.state});
                    }
                    this.loading = false;
                    this.fully_loaded = true;
                }).catch((error) => {
                    console.log(error);
                    this.loading = false;
                });
            },
            save() {
                this.loading = true;
                var originalData = {"methods": {}};
                var reviewData = {"methods": {}};

                originalData.methods = Object.values(this.state.original).reduce((c, v) => {
                    c[v.method_id] = c[v.method_id] ?? {"features": {}};
                    c[v.method_id].features[v.feature_id] = c[v.method_id].features[v.feature_id] ?? {};
                    c[v.method_id].features[v.feature_id] = {"score": v.score};
                    return c;
                }, {});

                reviewData.methods = Object.values(this.state.review).reduce((c, v) => {
                    c[v.method_id] = c[v.method_id] ?? {"features": {}};
                    c[v.method_id].features[v.feature_id] = c[v.method_id].features[v.feature_id] ?? {};
                    c[v.method_id].features[v.feature_id] = {"score": v.score};
                    return c;
                }, {});


                axios
                    .request({
                        url: "/api/review", method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        },
                        data: {
                            "se_id": this.specimen.id,
                            "type": "methods",
                            "original": originalData,
                            "review": reviewData,
                        }
                    })
                    .then(response => {
                        this.loading = false;
                        let payload = {'text': 'Update successful', 'color': 'success',};
                        eventBus.$emit('show-snackbar', payload);
                        this.state.action.create = false;
                        this.state.action.edit = true;
                        eventBus.$emit('review', {'type': 'methods', 'state': this.state});
                    }).catch(error => {
                    console.log(error.response);
                    this.loading = false;
                    let payload = {'text': 'Update failed', 'color': 'error',};
                    eventBus.$emit('show-snackbar', payload);
                })
            },
            accept() {
                let reviewData = {"methods": {}};

                reviewData.methods = Object.values(this.state.review).reduce((c, v) => {
                    c[v.method_id] = c[v.method_id] ?? {"features": {}};
                    c[v.method_id].features[v.feature_id] = c[v.method_id].features[v.feature_id] ?? {};
                    c[v.method_id].features[v.feature_id] = {"score": v.score};
                    return c;
                }, {});

                this.loading = true;
                axios
                    .request({
                        url: "/api/review/" + this.specimen.id + "/accept", method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        },
                        data: {
                            "se_id": this.specimen.id,
                            "type": "methods",
                            "review": reviewData,
                        }
                    })
                    .then(response => {
                        this.loading = false;
                        let payload = {'text': 'Update successful', 'color': 'success',};
                        eventBus.$emit('show-snackbar', payload);
                        this.state.action.create = false;
                        this.state.action.edit = true;
                        eventBus.$emit('review', {'type': this.state.type, 'state': this.state});
                        location.reload();
                    }).catch(error => {
                    console.log(error.response);
                    this.loading = false;
                    let payload = {'text': 'Update failed', 'color': 'error',};
                    eventBus.$emit('show-snackbar', payload);
                })
            },
            menu(val) {
                return changeObjectToArray(val);
            },
            displayName(method_id, value) {
                let display_value = null;

                if (value == 'name') {
                    display_value = this.getMethodById(method_id);
                    display_value = display_value.map(item => item.name);
                } else if (value == 'type') {
                    display_value = this.getMethodById(method_id);
                    display_value = display_value.map(item => item.type);
                }

                return display_value.toString();
            },
        },
        computed: {
            ...mapState({
                perPage: state => state.search.perPage,
                rowsPerPageItems: state => state.search.rowsPerPageItems,
                // bones: state => state.bones,
            }),
            ...mapGetters({
                bearerToken: 'bearerToken',
                csrfToken: 'csrfToken',
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
                isAdminOrOrgAdmin: 'isAdminOrOrgAdmin',
                isProjectManager: 'isProjectManager',
                getMethodFeaturesByMethodId: 'getMethodFeaturesByMethodId',
                getMethodById: 'getMethodById',
            }),
        }
    }
</script>