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
                <v-row>
                    <v-col cols="6">
                        <v-switch v-model="state.original" v-for="(key, value) in list_zones" :key="key"
                                  :value="value"
                                  :label="key" :readonly="true" :disabled="true"
                                  color="primary" dense hoverable>
                        </v-switch>
                    </v-col>
                    <v-col cols="6">
                        <v-switch v-model="state.review" v-for="(key, value) in list_zones" :key="key"
                                  :value="value"
                                  dusk="zones-switch-review"
                                  :label="key" :readonly="!show_save" :disabled="!show_save"
                                  color="primary" dense hoverable>
                        </v-switch>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-row class="justify-center">
                    <v-btn v-if="show_save" color="primary" class="mr-2" @click="save" dusk="zones-review-save">
                        <v-icon class="mr-2">mdi-content-save</v-icon>
                        Save
                    </v-btn>
                    <v-btn v-if="show_accept" color="primary" @click="accept" dusk="zones-review-accept">
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

    export default {
        name: "review-zones",
        props: {
            specimen: {
                type: Object | Array,
                required: true,
            },
            type: String,
            list_zones: Object | Array

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
            }
        },
        created() {
            this.show_save = (this.theUser.id !== this.specimen.user_id) || (this.isAdminOrOrgAdmin || this.isProjectManager);
            this.show_accept = (this.theUser.id === this.specimen.user_id) || (this.isAdminOrOrgAdmin || this.isProjectManager);
        },
        mounted() {
            this.loadReview();
            this.loadOriginal();
        },
        methods: {
            loadOriginal() {
                this.loading = true;
                axios
                    .request({
                        url: '/api/specimens/' + this.specimen.id + '/associations?type=' + this.state.type,
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken,
                        }
                    })
                    .then(response => {
                        var zones = response.data.data;
                        zones.map((zone) => {
                            if (zone.presence) {
                                this.state.original.push(zone.id.toString());
                            }
                        });

                        if (this.fully_loaded) {
                            eventBus.$emit('review', {'type': this.state.type, 'state': this.state});
                        }
                        this.loading = false;
                        this.fully_loaded = true;
                    })
                    .catch(error => {
                        //
                    });
            },
            loadReview() {
                this.loading = true;
                var review = [];
                let url = '/api/review/' + this.specimen.id;
                axios
                    .request({
                        url: url,
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        },
                        params: {
                            "type": this.type
                        }
                    })
                    .then(response => {
                        review = JSON.parse(response.data.data.review);
                        review.map(item => this.state.review.push(item.toString()));
                        this.loading = false
                    })
                    .catch(error => {
                        console.log(error);
                        this.loading = false
                    })
            },
            save() {
                var original = [];
                var review = [];

                //convert to int
                this.state.original.map(item => original.push(parseInt(item)));
                this.state.review.map(item => review.push(parseInt(item)));

                this.loading = true;
                axios
                    .request({
                        url: "/api/review",
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        },
                        data: {
                            "se_id": this.specimen.id,
                            "type": this.state.type,
                            "original": original,
                            "review": review
                        }
                    })
                    .then(response => {
                        this.loading = false;
                        let payload = {'text': 'Update successful', 'color': 'success',};
                        eventBus.$emit('show-snackbar', payload);
                        this.state.action.create = false;
                        this.state.action.edit = true;
                        eventBus.$emit('review', {'type': this.state.type, 'state': this.state});
                    })
                    .catch(error => {
                        console.log(error.response);
                        this.loading = false;
                        let payload = {'text': 'Update failed', 'color': 'error',};
                        eventBus.$emit('show-snackbar', payload);
                    })
            },
            accept() {
                var reviewData = [];

                //convert string to int
                this.state.review.map(item => reviewData.push(parseInt(item)));
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
                bones: state => state.bones,
            }),
            ...mapGetters({
                bearerToken: 'bearerToken',
                csrfToken: 'csrfToken',
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
                isAdminOrOrgAdmin: 'isAdminOrOrgAdmin',
                isProjectManager: 'isProjectManager',
            }),
        },
    }
</script>
