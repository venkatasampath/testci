<template>
    <v-card>
        <v-card-text>
            <v-row>
                <v-col cols="12">
                    <v-switch :id="'notifyExport'" :name="'notifyExport'" v-model="notifyexport" :dusk="'notify-export'"
                              :label="notifyexportlabel" :disabled="false" :persistent-hint="true" :hint="notifyexportlabelhelp">
                    </v-switch>
                    <input type="hidden" id="notify_export" name="notifyExport" :value="notifyexport">
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-switch :id="'notifyReview'" :name="'notifyReview'" v-model="notifyreview" :dusk="'notify-export'"
                              :label="notifyreviewlabel" :disabled="false" :persistent-hint="true" :hint="notifyreviewlabelhelp">
                    </v-switch>
                </v-col>
                <input type="hidden" id="notify_review" name="notifyReview" :value="notifyreview">
            </v-row>
            <v-row>
                <v-col cols="12">
                    <input type="hidden" id="notify_via_email" name="notifyViaEmail" :value="notifyviaemail">
                    <v-switch id="'notifyViaEmail'" :name="'notifyViaEmail'" v-model="notifyviaemail" :dusk="'notify-via-email'"
                              :label="notifyviaemaillabel" :disabled="false" :persistent-hint="true"
                              :hint="notifyviaemaillabelhelp">
                    </v-switch>
                    <v-text-field id="email" v-model="emailvmodel" dusk="notify-via-email-address" :disabled="true"/>
                </v-col>
                <v-col cols="12">
                    <input type="hidden" id="notify_via_SMS" name="notifyViaSMS" :value="notifyviasms">
                    <v-switch id="'notifyViaSMS'" :name="'notifyViaSMS'" v-model="notifyviasms" :dusk="'notify-via-email'"
                              :label="notifyviasmslabel" :disabled="false" :persistent-hint="true" :hint="notifyviasmslabelhelp">
                    </v-switch>
                    <v-text-field id="cellPhone" v-model="cellphonevmodel" dusk="cell-phone" :disabled="true"/>
                </v-col>
                <v-col cols="12">
                    <input type="hidden" id="notify_via_slack" name="notifyViaSlack" :value="notifyviaslack">
                    <v-switch id="'notifyViaSlack'" :name="'notifyViaSlack'" v-model="notifyviaslack" :dusk="'notify-via-slack'"
                              :label="notifyviaslacklabel" :disabled="false" :persistent-hint="true" :hint="notifyviaslacklabelhelp">
                    </v-switch>
                    <v-text-field id="slackChannel" v-model="slackchannelvmodel" dusk="slack-channel-url" :disabled="true"/>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12"><v-btn color="primary" @click="postData">Save</v-btn></v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import {eventBus} from "../../../eventBus";
    import axios from "axios";

    export default {
        name: "user-profile-notification",
        props: {
            notifyexportoptions: Boolean,
            notifyexportlabel: String,
            notifyexportlabelhelp: String,
            notifyreviewoptions: Boolean,
            notifyreviewlabel: String,
            notifyreviewlabelhelp: String,
            notifyviaemailoptions: Boolean,
            notifyviaemaillabel: String,
            notifyviaemaillabelhelp: String,
            notifyviasmsoptions: Boolean,
            notifyviasmslabel: String,
            notifyviasmslabelhelp: String,
            notifyviaslackoptions: Boolean,
            notifyviaslacklabel: String,
            notifyviaslacklabelhelp: String,
            emailvmodel: String,
            cellphonevmodel: String,
            slackchannelvmodel: String,
        },
        data() {
            return {
                notifyexport: (this.notifyexportoptions) ? this.notifyexportoptions : '',
                notifyreview: (this.notifyreviewoptions) ? this.notifyreviewoptions : '',
                notifyviaemail: (this.notifyviaemailoptions) ? this.notifyviaemailoptions : '',
                notifyviasms: (this.notifyviasmsoptions) ? this.notifyviasmsoptions : '',
                notifyviaslack: (this.notifyviaslackoptions) ? this.notifyviaslackoptions : '',
            };
        },
        mounted() {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrfToken;
        },
        methods: {
            postData: function () {
                axios.post('/users/' + this.theUser.id + '/notifications', {
                    notify_export_import_completion: this.notifyexport ? 1 : 0,
                    notify_se_review_completion: this.notifyreview ? 1 : 0,
                    notify_via_email: this.notifyviaemail ? 1 : 0,
                    notify_via_sms: this.notifyviasms ? 1 : 0,
                    notify_via_slack: this.notifyviaslack ? 1 : 0,
                })
                .then(response=>{
                    console.log("then response: " + JSON.stringify(response));
                    let payload = { 'text': 'Update successful', 'color': 'success', };
                    eventBus.$emit('show-snackbar', payload);
                })
                .catch(error => {
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
