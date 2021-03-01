<template>
    <v-card>
        <v-card-text>
            <v-row align="center" justify="center">
                <v-col cols="9">
                    <v-row>
                        <v-col cols="6">
                            <v-text-field disabled :id="'email'" :name="emailname" v-model="email" :label="emaillabel" :dusk="'email'"></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-text-field disabled :id="'userrole'" :name="userrolename" v-model="userrole" :label="userrolelabel" :dusk="'user-role'"></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field :id="'displayname'" :name="displaynamename" v-model="displayname" :label="displaynamelabel" :dusk="'display-name'"></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6">
                            <v-text-field :id="'cellPhone'" v-model="cellphone" :label="cellphonelabel" :placeholder="cellphoneplaceholder" :dusk="'cell-phone'"></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-text-field :id="'altPhone'" v-model="altphone" :label="altphonelabel" :placeholder="altphoneplaceholder" :dusk="'alt-phone'"></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field :id="'slackChannel'" v-model="slackchannel" :label="slackchannellabel" :placeholder="slackchannelplaceholder" :dusk="'slack-channel'"></v-text-field>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col cols="3">
                    <v-row align="center" justify="center">
                        <v-col cols="12">
                            <v-img class="mx-auto" :src="profilephotovmodel" :max-height=200 :max-width=200></v-img>
                        </v-col>
                    </v-row>
                    <v-row align="center" justify="center">
                        <v-col cols="12">
                            <v-btn class="mx-auto" color="primary">Upload Photo</v-btn>
                        </v-col>
                    </v-row>
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
    import axios from 'axios';
    import {apiGetCall, apiPostCall} from '../../../coraBaseModules';

    export default {
        name: "user-profile",
        props: {
            displaynamename: String,
            displaynamelabel: String,
            emaillabel: String,
            emailname: String,
            userrolelabel: String,
            userrolename: String,
            cellphoneplaceholder: null,
            cellphonelabel: String,
            altphoneplaceholder: null,
            altphonelabel: String,
            slackchannelplaceholder: String,
            slackchannellabel: String,
            displaynamevmodel: String,
            userrolevmodel: String,
            emailvmodel: String,
            cellphonevmodel: String,
            altphonevmodel: String,
            slackchannelvmodel: String,
            profilephotovmodel: String,
        },
        data() {
            return {
                displayname: (this.displaynamevmodel) ? this.displaynamevmodel : null,
                email: (this.emailvmodel) ? this.emailvmodel : null,
                userrole: (this.userrolevmodel) ? this.userrolevmodel : null,
                cellphone: (this.cellphonevmodel) ? this.cellphonevmodel : null,
                altphone: (this.altphonevmodel) ? this.altphonevmodel : null,
                slackchannel: (this.slackchannelvmodel) ? this.slackchannelvmodel : null,
            }
        },
        mounted() {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrfToken;
        },
        methods:{
            postData: function() {
                axios.post('/users/' + this.theUser.id + '/updateProfile', {
                    display_name: this.displayname,
                    phone: this.altphone,
                    cell_phone: this.cellphone,
                    slack_channel: this.slackchannel
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
