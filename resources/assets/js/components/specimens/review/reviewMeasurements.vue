<template>
    <div>
        <v-progress-linear v-if="loading" indeterminate color="primary"></v-progress-linear>
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
                <v-row>
                    <v-col cols="6">
                        <v-form>
                            <v-text-field name="Measurements" v-model="item.measure" :label="item.display_name"
                                          v-for="item in state.original" v-bind:key="item.id"
                                          v-bind:id="item.id.toString()"
                                          type="number" :suffix="uom" :readonly="true" :disabled="true">
                            </v-text-field>
                        </v-form>
                    </v-col>
                    <v-col cols="6">
                        <v-form>
                            <v-text-field name="Measurements" v-model="item.measure" :label="item.display_name"
                                          v-for="item in state.review" v-bind:key="item.id"
                                          v-bind:id="item.id.toString()"
                                          type="number" :suffix="uom" :readonly="false" :disabled="false" dusk="measurements-review">
                            </v-text-field>
                        </v-form>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-row class="justify-center">
                    <v-btn v-if="show_save" color="primary" class="mr-2" @click="save" dusk="measurements-review-save">
                        <v-icon class="mr-2">mdi-content-save</v-icon>
                        Save
                    </v-btn>
                    <v-btn v-if="show_accept" color="primary" @click="accept" dusk="measurements-review-accept">
                        <v-icon class="mr-2">mdi-thumb-up-outline</v-icon>
                        Accept
                    </v-btn>
                </v-row>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
    import axios from "axios";
    import {mapGetters, mapState} from "vuex";
    import {eventBus} from "../../../eventBus";

    export default {
        name: "review-measurements",
        props: {
            specimen: {type: Object | Array, required: true},
        },
        data() {
            return {
                loading: true,
                fully_loaded: false,
                show_save: true,
                show_accept: false,
                items: [],
                state: {
                    type: "measurements",
                    original: [],
                    review: [],
                    diff: null,
                    action: {create: false, edit: false,},
                    reviewRecord: null,
                },
                hint: "",
                placeholder: "Enter Measurements",
                list_items: [],
                uom: "mm",
            }
        },
        created() {
            console.log("reviewMeasurements component created");
            this.loadOriginal();
            this.loadReview();

            // Should we show the Save (Review) button
            this.show_save = (this.theUser.id !== this.specimen.user_id) || (this.isAdminOrOrgAdmin || this.isProjectManager);
            // Should we show the accept button
            this.show_accept = (this.theUser.id === this.specimen.user_id) || (this.isAdminOrOrgAdmin || this.isProjectManager);
        },
        beforeMount() {
            this.state.original = JSON.parse(JSON.stringify(this.getMeasurementsByBone(this.specimen.sb_id)));
            this.state.review = JSON.parse(JSON.stringify(this.getMeasurementsByBone(this.specimen.sb_id)));
        },
        mounted() {

        },

        methods: {
            loadOriginal() {
                this.loading = true;
                let url = '/api/specimens/' + this.specimen.id + '/associations?type=' + this.state.type
                axios
                    .request({
                        url: url, method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        },
                    })
                    .then(response => {

                        // Iterate over all the measurements that are present for this specimen.
                        // Find measurement in items array and set measure for that specific measurement
                        let items = this.state.original;
                        let count = 0;

                        response.data.data.forEach(function (el, index) {
                            let item = items.find(data => {
                                return data.id === el.id
                            });
                            item.measure = el.measure;
                            if (el.measure) {
                                count++;
                            }
                        });

                        this.loading = false;
                    })
                    .catch(error => {
                        this.errored = true;
                    })
            },
            loadReview() {
                this.loading = true;
                axios({
                    url: "/api/review/" + this.specimen.id, method: 'GET',
                    headers: {'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken,},
                    params: {"type": this.state.type,},
                }).then((response) => {
                    let items = this.state.review;
                    let count = 0;

                    var responseData = JSON.parse(response.data.data.review);

                    Object.keys(responseData).forEach(function (el, index) {
                        let item = items.find(data => {
                            return data.id === parseInt(el)
                        });
                        item.measure = responseData[el];
                    });

                    this.loading = false;


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
                var original = this.prepareMeasurementsForSave(this.state.original);
                var review = this.prepareMeasurementsForSave(this.state.review);
                this.loading = true;
                axios
                    .request({
                        url: "/api/review", method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        },
                        data: {
                            "se_id": this.specimen.id, "type": this.state.type,
                            "original": original,
                            "review": review,
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
                            "review": this.prepareMeasurementsForSave(this.state.review),
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
            prepareMeasurementsForSave(arr) {
                let measurements = arr;
                var preparedMeasurements = {};
                for (var i = 0; i < measurements.length; i++) {
                    if (measurements[i].measure) {
                        Vue.set(preparedMeasurements, measurements[i].id.toString(), measurements[i].measure.toString())
                    }
                }
                return preparedMeasurements;
            }
        },
        computed: {
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
                getMeasurementsByBone: 'getMeasurementsByBone',
                isAdminOrOrgAdmin: 'isAdminOrOrgAdmin',
                isProjectManager: 'isProjectManager',
                // items: 'getMeasurements',
            }),
        }
    }
</script>
