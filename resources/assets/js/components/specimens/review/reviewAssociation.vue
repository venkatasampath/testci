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
                        <v-autocomplete v-model="state.original" :label="type" filled chips multiple disabled readonly
                                        :items="list_items" item-text="text" item-value="value" :hint="hint"
                                        persistent-hint>
                        </v-autocomplete>
                    </v-col>
                    <v-col cols="6">
                        <v-autocomplete v-model="state.review" :label="type" filled chips deletable-chips multiple
                                        :items="list_items" item-text="text" dusk="association-review-option" item-value="value"
                                        :hint="hint"
                                        persistent-hint>
                        </v-autocomplete>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-row class="justify-center">
                    <v-btn v-if="show_save" color="primary" class="mr-2" @click="save" dusk="association-review-save">
                        <v-icon class="mr-2">mdi-content-save</v-icon>
                        Save
                    </v-btn>
                    <v-btn v-if="show_accept" color="primary" @click="accept" dusk="association-review-accept">
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
        name: 'review-association',
        props: {
            specimen: {
                type: Object | Array,
                required: true,
            },
            type: String
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
                hint: "You can apply multiple " + this.type + " to this specimen",
                placeholder: "Select " + this.type,
                list_items: []
            }
        },
        created() {
            this.loadOriginal();
            this.loadReview();
            this.loadListAssociation();
            this.show_save = (this.theUser.id !== this.specimen.user_id) || (this.isAdminOrOrgAdmin || this.isProjectManager);
            // Should we show the accept button
            this.show_accept = (this.theUser.id === this.specimen.user_id) || (this.isAdminOrOrgAdmin || this.isProjectManager);
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
                    // console.log(response.data.data) // uncomment for debug
                    this.state.original = response.data.data.map(association => association.id.toString());
                    if (this.fully_loaded) {
                        eventBus.$emit('review', {'type': this.state.type, 'state': this.state});
                    }
                    this.loading = false;
                    this.fully_loaded = true;
                }).catch(error => {
                    this.loading = false;
                })
            },
            loadReview() {
                this.loading = true;
                var reviewData = [];
                axios({
                    url: "/api/review/" + this.specimen.id, method: 'GET',
                    headers: {'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken,},
                    params: {"type": this.state.type,},
                }).then((response) => {
                    console.log(response);
                    this.state.reviewRecord = response.data.data;
                    if (this.state.reviewRecord.review) {
                        reviewData = JSON.parse(this.state.reviewRecord.review);
                        reviewData.map(item => this.state.review.push(item.toString()));
                        this.state.action.edit = true;
                    } else {
                        this.state.action.create = true;
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
            loadListAssociation() {
                var data = [];
                axios({
                    url: "/api/review/" + this.specimen.id + "/list-associationdata",
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': this.$store.getters.bearerToken,
                    },
                    params: {
                        "type": this.type
                    }
                }).then((response) => {
                    for (let key in response.data) {
                        this.list_items.push({
                            value: key,
                            text: response.data[key]
                        });
                    }
                    this.show = false
                }).catch((error) => {
                    console.log(error);
                    this.show = false;
                });
            },
            save() {
                this.loading = true;
                var originalData = [];
                var reviewData = [];

                //convert string to int
                this.state.original.map(item => originalData.push(parseInt(item)));
                this.state.review.map(item => reviewData.push(parseInt(item)));

                axios
                    .request({
                        url: "/api/review", method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        },
                        data: {
                            "se_id": this.specimen.id, "type": this.state.type,
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
            remove(item) {
                const index = this.state.review.indexOf(item.id);
                if (index >= 0) this.state.review.splice(index, 1)
            },
        },
        mounted() {

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
                // items: 'get'+this.type.charAt(0).toUpperCase() + name.slice(1),
            }),
        },
        watch: {}
    }
</script>