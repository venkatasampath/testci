<template>
    <v-card>
        <v-card-text>
            <v-row>
                <v-col cols="12">
                    <v-autocomplete :id="'linesPerPage'" v-model="linesperpage" :dusk="'se-lines-Per-Page'"
                                    :label="linesperpagelabel" :persistent-hint="true" :hint="linesperpagelabelhelp"
                                    :items="linesperpagedata" item-text="text" item-value="keys">
                    </v-autocomplete>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-switch :id="'welcomeScreen'" :name="'welcomeScreen'" v-model="welcomescreen" :dusk="'se-welcome-screen'"
                              :label="welcomescreenlabel" :persistent-hint="true" :hint="welcomescreenlabelhelp">
                    </v-switch>
                    <input type="hidden" id="welcome_screen_id" name="welcomeScreen" :value="welcomescreen">
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-switch :id="'helpSlideOut'" :name="'helpSlideOut'" v-model="helpslideout" :dusk="'se-help-slide-out'"
                              :label="helpslideoutlabel" :persistent-hint="true" :hint="helpslideoutlabelhelp">
                    </v-switch>
                    <input type="hidden" id="help_slide_out" name="helpSlideOut" :value="helpslideout">
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
    import axios from 'axios';
    import {eventBus} from "../../../eventBus";
    import {changeObjectToArray, apiGetCall, apiPostCall} from '../../../coraBaseModules';

    export default {
        name: "user-profile-general",
        props: {
            linesperpageoptions: Object,
            linesperpagelabel: String,
            linesperpagevmodel: null,
            linesperpagelabelhelp: String,
            welcomescreenlabel: String,
            welcomescreenlabelhelp: String,
            helpslideoutlabel: String,
            helpslideoutlabelhelp: String,
            welcomescreenoptions: null,
            helpslideoutoptions: null,
        },
        data() {
            return {
                welcomescreenoptions_data: '',
                helpslideoutoptions_data: '',
                linesperpage: (this.linesperpagevmodel) ? this.linesperpagevmodel : null,
                welcomescreen: (this.welcomescreenoptions) ? this.welcomescreenoptions : null,
                helpslideout: (this.helpslideoutoptions) ? this.helpslideoutoptions : null,
                linesperpagedata: changeObjectToArray(this.linesperpageoptions),
            }
        },
        mounted() {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrfToken;
        },
        methods: {
            postData: function () {
                axios.post('/users/' + this.theUser.id + '/general', {
                    lines_per_page: this.linesperpage,
                    welcome_screen_on_startup: this.welcomescreen ? 1 : 0,
                    ui_right_sidebar_slideout_help: this.helpslideout ? 1 : 0,
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
