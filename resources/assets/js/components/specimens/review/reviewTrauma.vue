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
                <v-expansion-panels v-for="(trauma, index) in this.state.original" :key="trauma.id">
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
                                                    :items="zonesItems" dusk="trauma-zone-review"></v-autocomplete>
                                </v-col>
                            </v-row>
                            <v-row class="align-center justify-center">
                                <v-col cols="2">
                                    <v-row class="align-center justify-center"><span>Pathology</span></v-row>
                                </v-col>
                                <v-col>
                                    <v-autocomplete v-model="state.original[index].trauma_id" :items="trumaItems"
                                                    item-text="text" item-value="value" :disabled="true"
                                                    :readonly="true"></v-autocomplete>
                                </v-col>
                                <v-col>
                                    <v-autocomplete v-model="state.review[index].trauma_id" :items="trumaItems"
                                                    item-text="text" item-value="value" dusk="trauma-state-review"></v-autocomplete>
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
                                                placeholder="Additional Information" dusk="trauma-add-info-review"></v-textarea>
                                </v-col>
                            </v-row>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>
            </v-card-text>
            <v-card-actions>
                <v-row class="justify-center">
                    <v-btn v-if="show_save" color="primary" class="mr-2" @click="save" dusk="trauma-review-save">
                        <v-icon class="mr-2">mdi-content-save</v-icon>
                        Save
                    </v-btn>
                    <v-btn v-if="show_accept" color="primary" @click="accept" dusk="trauma-review-accept">
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
        name: "review-trauma",
        props: {
            specimen: {
                type: Object | Array,
                required: true,
            },
            type: String,
            list_zones: Object | Array,
            list_trauma: Object | Array,
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
            this.trumaItems = changeObjectToArray(this.list_trauma);
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
                    this.state.original = response.data.data.map(trauma => {
                        return {
                            "zone_id": (trauma.zone_id) ? trauma.zone_id.toString() : "",
                            "trauma_id": (trauma.id) ? trauma.id.toString() : "",
                            "id": trauma.id,
                            "name": trauma.name,
                            "additional_information": trauma.additional_information
                        }
                    });
                    this.state.review = response.data.data.map(trauma => {
                        return {"trauma_id": "", "zone_id": "", "additional_information": "", "id": trauma.id}
                    });


                    console.log(response.data.data);
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
                            this.state.review[counter].trauma_id = (value.trauma_id) ? value.trauma_id : "";
                            this.state.review[counter].zone_id = (value.zone_id) ? value.zone_id.toString() : "";
                            this.state.review[counter].additional_information = (value.additional_information) ? value.additional_information : "";
                            counter++;
                        }
                    }

                    counter = 0;
                    if (response.data.data.original) {
                        originalRecords = JSON.parse(response.data.data.original);
                        for (let [key, value] of Object.entries(originalRecords)) {
                            this.state.original[counter].trauma_id = (value.trauma_id) ? value.trauma_id : "";
                            this.state.original[counter].zone_id = (value.zone_id) ? value.zone_id.toString() : "";
                            this.state.original[counter].additional_information = (value.additional_information) ? value.additional_information : "";
                            counter++;
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

                this.state.review.map(traumas => {
                    if (traumas.zone_id != "") {
                        Vue.set(reviewData, traumas.trauma_id + "-" + traumas.zone_id, {
                            "trauma_id": traumas.trauma_id,
                            "zone_id": traumas.zone_id,
                            "additional_information": traumas.additional_information
                        })
                    } else {
                        Vue.set(reviewData, traumas.trauma_id + "-*", {
                            "trauma_id": traumas.trauma_id,
                            "zone_id": "",
                            "additional_information": traumas.additional_information
                        })
                    }

                });
                this.state.original.map(traumas => {
                    if (traumas.zone_id != "") {
                        Vue.set(originalData, traumas.trauma_id + "-" + traumas.zone_id, {
                            "trauma_id": traumas.trauma_id,
                            "zone_id": traumas.zone_id,
                            "additional_information": traumas.additional_information
                        })
                    } else {
                        Vue.set(originalData, traumas.trauma_id + "-*", {
                            "trauma_id": traumas.trauma_id,
                            "zone_id": "",
                            "additional_information": traumas.additional_information
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
                            "review": this.state.review,
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