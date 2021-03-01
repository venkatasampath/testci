<template>
    <v-card>
        <v-card-text>
            <v-row>
                <v-col cols="12">
                        <v-text-field :id="'slackwebhook'" :name="slackwebhook" v-model="slackwebhook" :dusk="'slack-web-hook'"
                                      :label="slackwebhooklabel" :persistent-hint="true" :hint="slackwebhooklabelhelp">
                        </v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-text-field :id="'slackchannel'" :name="slackchannel" v-model="slackchannel" :dusk="'slack-channel'"
                                  :label="slackchannellabel" :persistent-hint="true" :hint="slackchannellabelhelp">
                    </v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-text-field :id="'googlemaps'" :name="googlemaps" v-model="googlemaps" :dusk="'google-maps'"
                                  :label="googlemapslabel" :persistent-hint="true" :hint="googlemapslabelhelp">
                    </v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-btn color="primary" @click="postData">Save</v-btn>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import {apiGetCall, apiPostCall} from '../../../coraBaseModules';
    import axios from 'axios';
    import {eventBus} from "../../../eventBus";

    export default {
        name: "org-profile-apikeys",
        props: {
            slackwebhooklabel: String,
            slackchannellabel: String,
            googlemapslabel: String,
            slackchannellabelhelp: String,
            slackwebhooklabelhelp: String,
            googlemapslabelhelp: String,
            slackwebhookvmodel: String,
            slackchannelvmodel: String,
            googlemapsvmodel: String,
        },
        data() {
            return {
                slackwebhook: (this.slackwebhookvmodel) ? this.slackwebhookvmodel : "",
                slackchannel: (this.slackchannelvmodel) ? this.slackchannelvmodel : "",
                googlemaps: (this.googlemapsvmodel) ? this.googlemapsvmodel : "",
            }
        },
        mounted() {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrfToken;
        },
        methods:{
            postData: function() {
                axios.post('/org/apikeys', {
                    org_api_slack_channel: this.slackchannel,
                    org_api_slack_webhook: this.slackwebhook,
                    org_api_google_maps: this.googlemaps
                }).then(response => {
                    console.log("then response: " + JSON.stringify(response));
                    let payload = { 'text': 'Update successful', 'color': 'success', };
                    eventBus.$emit('show-snackbar', payload);
                }).catch(error => {
                    console.log(error.response);
                    let payload = { 'text': 'Update failed', 'color': 'error', };
                    eventBus.$emit('show-snackbar', payload);
                })
            }
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
            }),
        },
    }
</script>
