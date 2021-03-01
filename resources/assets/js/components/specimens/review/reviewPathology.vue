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
                <v-expansion-panels v-for="(pathology, index) in this.state.original" :key="pathology.id">
                    <v-expansion-panel>
                        <v-expansion-panel-header>
                            <v-row class="align-center justify-center"><span>{{ state.original[index].name }}</span>
                            </v-row>
                        </v-expansion-panel-header>
                        <v-expansion-panel-content>
                            <v-row class="align-center justify-center">
                                <v-col cols="2">
                                    <v-row class="align-center justify-center"><span>Zone</span></v-row>
                                </v-col>
                                <v-col>
                                    <v-autocomplete v-model="state.original[index].zone_id" :items="zonesItems"
                                                    item-text="text" item-value="value" :disabled="true"
                                                    :readonly="true"></v-autocomplete>
                                </v-col>
                                <v-col>
                                    <v-autocomplete v-model="state.review[index].zone_id"
                                                    :items="zonesItems" dusk="pathology-zone-review"></v-autocomplete>
                                </v-col>
                            </v-row>
                            <v-row class="align-center justify-center">
                                <v-col cols="2">
                                    <v-row class="align-center justify-center"><span>Pathology</span></v-row>
                                </v-col>
                                <v-col>
                                    <v-autocomplete v-model="state.original[index].pathology_id" :items="pathologyItems"
                                                    item-text="text" item-value="value" :disabled="true"
                                                    :readonly="true"></v-autocomplete>
                                </v-col>
                                <v-col>
                                    <v-autocomplete v-model="state.review[index].pathology_id" :items="pathologyItems"
                                                    item-text="text" item-value="value" dusk="pathology-state-review"></v-autocomplete>
                                </v-col>
                            </v-row>
                            <v-row class="align-center justify-center">
                                <v-col cols="2">
                                    <v-row class="align-center justify-center"><span>Additional Information</span>
                                    </v-row>
                                </v-col>
                                <v-col>
                                    <v-textarea v-model="state.original[index].additional_information" dense
                                                :disabled="true" :readonly="true"
                                                placeholder="Additional Information"></v-textarea>
                                </v-col>
                                <v-col>
                                    <v-textarea v-model="state.review[index].additional_information"
                                                placeholder="Additional Information" dusk="pathology-add-info-review"></v-textarea>
                                </v-col>
                            </v-row>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>
            </v-card-text>
            <v-card-actions>
                <v-row class="justify-center">
                    <v-btn v-if="show_save" color="primary" class="mr-2" @click="save" dusk="pathology-review-save">
                        <v-icon class="mr-2">mdi-content-save</v-icon>
                        Save
                    </v-btn>
                    <v-btn v-if="show_accept" color="primary" @click="accept" dusk="pathology-review-accept">
                        <v-icon class="mr-2">mdi-thumb-up-outline</v-icon>
                        Accept
                    </v-btn>
                </v-row>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
    import axios from 'axios';
    import {mapGetters, mapState} from "vuex";
    import {eventBus} from "../../../eventBus";
    import {changeObjectToArray} from "../../../coraBaseModules";

    export default {
        name: "review-pathology",
        props: {
            specimen: {
                type: Object | Array,
                required: true,
            },
            type: String,
            list_zones: Object | Array,
            list_pathology: Object | Array,
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
                hint: "Please can apply multiple zones to this specimen",
                select_all: true,
                intermediateState: true,
                zonesItems: [],
                pathologyItems: [],
            }
        },
        created() {
            this.show_save = (this.theUser.id !== this.specimen.user_id) || (this.isAdminOrOrgAdmin || this.isProjectManager);
            this.show_accept = (this.theUser.id === this.specimen.user_id) || (this.isAdminOrOrgAdmin || this.isProjectManager);
        },
        beforeMount() {
            // this.items = JSON.parse ( JSON.stringify (this.getZonesByBone(this.specimen.sb_id) ));

        },
        mounted() {
            this.loadOriginal();
            this.zonesItems = changeObjectToArray(this.list_zones);
            this.pathologyItems = changeObjectToArray(this.list_pathology);
        },
        methods: {
            loadOriginal() {
                this.loading = true;
                axios.request({
                    url: '/api/specimens/' + this.specimen.id + '/associations?type=' + this.state.type, method: 'GET',
                    headers: {
                        'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken,
                    }
                }).then(response => {
                    console.log(response.data.data)
                    this.state.original = response.data.data.map(pathology => {
                        return {
                            "pathology_id": pathology.id.toString(),
                            "zone_id": pathology.zone_id.toString(),
                            "additional_information": pathology.additional_information,
                            "name": pathology.name,
                            "id": pathology.id
                        }
                    });
                    this.state.review = response.data.data.map(pathology => {
                        return {"pathology_id": "", "zone_id": "", "additional_information": "", "id": pathology.id}
                    });

                    if (this.fully_loaded) {
                        eventBus.$emit('review', {'type': this.state.type, 'state': this.state});
                    }
                    this.loadReview();
                    this.loading = false;
                    this.fully_loaded = true;
                }).catch(error => {
                    this.loading = false;
                })
            },
            loadReview() {
                this.loading = true;
                let reviewRecords = [];
                let originalRecords = [];

                axios({
                    url: "/api/review/" + this.specimen.id, method: 'GET',
                    headers: {'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken,},
                    params: {"type": this.state.type,},
                }).then((response) => {

                    var counter = 0;
                    if (response.data.data.review) {
                        reviewRecords = JSON.parse(response.data.data.review);
                        for (let [key, value] of Object.entries(reviewRecords)) {
                            this.state.review[counter].pathology_id = value.pathology_id === 'undefined' ? "" : value.pathology_id.toString();
                            this.state.review[counter].zone_id = value.zone_id === 'undefined' ? "" : value.zone_id.toString();
                            this.state.review[counter].additional_information = value.additional_information === 'undefined' ? "" : value.additional_information;
                            counter += 1;
                        }
                    }
                    counter = 0;
                    if (response.data.data.original) {
                        originalRecords = JSON.parse(response.data.data.original);
                        for (let [key, value] of Object.entries(originalRecords)) {
                            this.state.original[counter].pathology_id = value.pathology_id === 'undefined' ? "" : value.pathology_id.toString();
                            this.state.original[counter].zone_id = value.zone_id === 'undefined' ? "" : value.zone_id.toString();
                            this.state.original[counter].additional_information = value.additional_information === 'undefined' ? "" : value.additional_information;
                            counter += 1;
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
                var originalData = {};
                var reviewData = {};

                this.state.review.map(pathology => {
                    if (pathology.zone_id != "") {
                        Vue.set(reviewData, pathology.pathology_id + "-" + pathology.zone_id, {
                            "pathology_id": pathology.pathology_id,
                            "zone_id": pathology.zone_id,
                            "additional_information": pathology.additional_information
                        })
                    } else {
                        Vue.set(reviewData, pathology.pathology_id + "-*", {
                            "pathology_id": pathology.pathology_id,
                            "zone_id": "",
                            "additional_information": pathology.additional_information
                        })
                    }

                });
                this.state.original.map(pathology => {
                    if (pathology.zone_id != "") {
                        Vue.set(originalData, pathology.pathology_id + "-" + pathology.zone_id, {
                            "pathology_id": pathology.pathology_id,
                            "zone_id": pathology.zone_id,
                            "additional_information": pathology.additional_information
                        })
                    } else {
                        Vue.set(originalData, pathology.pathology_id + "-*", {
                            "pathology_id": pathology.pathology_id,
                            "zone_id": "",
                            "additional_information": pathology.additional_information
                        })
                    }
                });
                axios
                    .request({
                        url: "/api/review", method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        },
                        data: {
                            "se_id": this.specimen.id,
                            "type": this.state.type,
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
                        eventBus.$emit('review', {'type': this.state.type, 'state': this.state});

                    }).catch(error => {
                    console.log(error.response);
                    this.loading = false;
                    let payload = {'text': 'Update failed', 'color': 'error',};
                    eventBus.$emit('show-snackbar', payload);
                })
            },
            accept() {
                var reviewData = {};
                this.state.review.map(pathology => {
                    if (pathology.zone_id != "") {
                        Vue.set(reviewData, pathology.pathology_id + "-" + pathology.zone_id, {
                            "pathology_id": pathology.pathology_id,
                            "zone_id": pathology.zone_id,
                            "additional_information": pathology.additional_information
                        })
                    } else {
                        Vue.set(reviewData, pathology.pathology_id + "-*", {
                            "pathology_id": pathology.pathology_id,
                            "zone_id": "",
                            "additional_information": pathology.additional_information
                        })
                    }

                });
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
                            "type": this.state.type,
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
                getZonesByBone: 'getZonesByBone',
            }),
        },
    }
</script>

<style>

</style>