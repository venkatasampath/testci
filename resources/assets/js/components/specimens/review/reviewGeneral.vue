<template>
    <div>
        <v-progress-linear v-if="loading" indeterminate color="primary"></v-progress-linear>
        <v-card>
            <v-card-title>
                <v-row class="align-center justify-center">
                    <v-col><v-row class="align-center justify-center"><span>Original</span></v-row></v-col>
                    <v-col><v-row class="align-center justify-center"><span>Review</span></v-row></v-col>
                </v-row>
            </v-card-title>
            <v-card-text>
                <v-row class="justify-center">
                    <v-col><Bone :value="state.original.sb_id" :disabled="true" /></v-col>
                    <v-col><Bone :value="state.review.sb_id" @input="(val) => {state.review.sb_id = val}" dusk="bone-review"/></v-col>
                </v-row>
                <v-row class="justify-center">
                    <v-col><side :value="state.original.side" :disabled="true" /></v-col>
                    <v-col><side :value="state.review.side" @input="(val) => {state.review.side = val}" dusk="side-review"/></v-col>
                </v-row>
                <v-row class="justify-center">
                    <v-col><completeness :value="state.original.completeness" :disabled="true" /></v-col>
                    <v-col><completeness :value="state.review.completeness" @input="(val) => {state.review.completeness = val}" dusk="completeness-review"/></v-col>
                </v-row>
                <!-- ToDo: Add the mass and count fields here later for sb that are countable-->
            </v-card-text>
            <v-card-actions>
                <v-row class="justify-center">
                    <v-btn v-if="show_save" color="primary" class="mr-2" @click="save" dusk="review-save"><v-icon class="mr-2">mdi
                      -content-save</v-icon>Save</v-btn>
                    <v-btn v-if="show_accept" color="primary" @click="accept" dusk="review-accept"><v-icon class="mr-2">mdi-thumb-up-outline</v-icon>Accept</v-btn>
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
        name: "review-general",
        props: {
            specimen: { type: Object|Array, required: true },
        },
        data() {
            return {
                loading: true,
                show_save: true,
                show_accept: false,
                state: {
                    type: "general",
                    action: { create: false, edit: false, },
                    original: { sb_id: null, side: null, completeness: null, mass: null, count: null, },
                    review: { sb_id: null, side: null, completeness: null, mass: null, count: null, },
                    reviewRecord: null,
                },
            };
        },
        created() {
            this.loadOriginal();
            this.loadReview();

            // Should we show the Save (Review) button
            this.show_save = (this.theUser.id !== this.specimen.user_id) || (this.isAdminOrOrgAdmin || this.isProjectManager);
            // Should we show the accept button
            this.show_accept = (this.theUser.id === this.specimen.user_id) || (this.isAdminOrOrgAdmin || this.isProjectManager);
        },
        mounted() {
            //
        },
        methods: {
            loadOriginal() {
                this.state.original.sb_id = this.specimen.sb_id;
                this.state.original.side = this.specimen.side;
                this.state.original.completeness = this.specimen.completeness;
                this.state.original.mass = this.specimen.mass;
                this.state.original.count = this.specimen.count;
            },
            loadReview() {
                this.loading = true;
                axios({ url: "/api/review/" + this.specimen.id, method: 'GET',
                    headers: {'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken,},
                    params: {"type": this.state.type,},
                }).then((response) => {
                    this.state.reviewRecord = response.data.data;
                    if (this.state.reviewRecord.review) {
                        this.state.review = JSON.parse(this.state.reviewRecord.review);
                        this.state.action.edit = true;
                    } else {
                        this.state.action.create = true;
                    }
                    eventBus.$emit('review', {'type': this.state.type, 'state': this.state});
                    this.loading = false;
                }).catch((error) => {
                    console.log(error);
                    this.loading = false;
                });
            },
            save() {
                axios
                    .request({ url: "/api/review", method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken,},
                        data: {
                            "se_id": this.specimen.id, "type": this.state.type,
                            "original": this.state.original,
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

                    }).catch(error => {
                        console.log(error.response);
                        this.loading = false;
                        let payload = {'text': 'Update failed', 'color': 'error',};
                        eventBus.$emit('show-snackbar', payload);
                })
            },
            accept() {
                axios
                    .request({ url: "/api/review/" + this.specimen.id + "/accept", method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken,},
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
                //
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
        }
    }
</script>

<style scoped>

</style>