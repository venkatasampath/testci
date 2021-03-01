<template>
    <v-card>
        <v-card-text>
            <v-expansion-panels v-model="panel" accordian>
                <v-expansion-panel>
                    <v-expansion-panel-header>Project</v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <v-col cols="12">
                            <v-autocomplete id="defaultProject" class="defaultProject" name="defaultProject" v-model="defaultproject" dusk="se-default-project"
                                            :items="defaultprojectdata" item-value="value" item-text="text" :label="defaultprojectlabel"
                                             required :rules="[v => !!v || 'Default Project is required']" :persistent-hint="true" :hint="defaultprojectlabelhelp">
                            </v-autocomplete>
                        </v-col>
                    </v-expansion-panel-content>
                </v-expansion-panel>
                <v-expansion-panel>
                    <v-expansion-panel-header>Specimen</v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <v-row>
                            <v-col cols="12">
                                <v-text-field id="userAccessionNumber" name="userAccessionNumber" class="userAccessionNumber" v-model="accessionnumber" dusk="se-user-accession-number"
                                              :label="useraccessionnumberlabel" :persistent-hint="true" :hint="useraccessionnumberlabelhelp">
                                </v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field id="userProvenance1" name="userProvenance1" class="userProvenance1" v-model="provenance1" dusk="se-user-provenance1"
                                              :label="userprovenance1label" :persistent-hint="true" :hint="userprovenance1labelhelp">
                                </v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field id="userProvenance2" name="userProvenance2" class="userProvenance2" v-model="provenance2" dusk="se-user-provenance2"
                                              :label="userprovenance2label" :persistent-hint="true" :hint="userprovenance2labelhelp">
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-text-field id="MRUListSpecimens" name="MRUListSpecimens" class="MRUListSpecimens" v-model="mrulistspecimens" dusk="se-MRU-list-specimens"
                                        :label="usermrulistspecimenslabel" :persistent-hint="true" :hint="usermrulistspecimenslabelhelp">
                                </v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-autocomplete id="newRedirectURL" class="newRedirectURL" name="newRedirectURL" v-model="senewredirecturl" dusk="se_new_redirect_url"
                                                :items="senewredirecturldata"  item-value="value" item-text="text"
                                                :label="senewredirecturllabel" :persistent-hint="true" :hint="senewredirecturllabelhelp">
                                </v-autocomplete>
                            </v-col>
                        </v-row>
                    </v-expansion-panel-content>
                </v-expansion-panel>

                <v-expansion-panel>
                    <v-expansion-panel-header>DNA</v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <v-row>
                            <v-col cols="12">
                                <v-autocomplete id="userDefaultLab" class="userDefaultLab" name="userDefaultLab" v-model="defaultlab" dusk="se-default-mito-method"
                                                :items="userdefaultlablabeldata" item-value="value" item-text="text"
                                                :label="userdefaultlablabel" :persistent-hint="true" :hint="userdefaultlablabelhelp">
                                </v-autocomplete>
                            </v-col>
                            <v-col cols="12">
                                <v-autocomplete id="defaultMitoMethod" class="defaultMitoMethod" name="defaultMitoMethod" v-model="defaultmitomethod" dusk="se-default-mito-method"
                                                :items="defaultmitomethoddata" item-value="value" item-text="text"
                                                :label="defaultmitomethodlabel" :persistent-hint="true" :hint="defaultsearchlabelhelp">
                                </v-autocomplete>
                            </v-col>
                            <v-col cols="12">
                                <v-autocomplete id="defaultYMethod" class="defaultYMethod" name="defaultYMethod" v-model="defaultymethod" dusk="se-default-y-method"
                                                :items="defaultymethoddata" item-value="value" item-text="text"
                                                :label="defaultymethodlabel" :persistent-hint="true" :hint="defaultymethodlabelhelp">
                                </v-autocomplete>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-autocomplete id="defaultAutoMethod" class="defaultAutoMethod" name="defaultAutoMethod" v-model="defaultautomethod" dusk="se-default-y-method"
                                                :items="defaultautomethoddata" item-value="value" item-text="text"
                                                :label="defaultautomethodlabel" :persistent-hint="true" :hint="defaultautomethodlabelhelp">
                                </v-autocomplete>
                            </v-col>
                            <v-col cols="12">
                                <v-switch :id="'consensusDNAUseOld'" :name="'consensusDNAUseOld'" v-model="consensusdnauseold" :dusk="'se-consensus-DNA-use-old'"
                                          :label="consensusdnauseoldlabel" :disabled="false" :persistent-hint="true" :hint="consensusdnauseoldlabelhelp">
                                </v-switch>
                                <input type="hidden" id="consensus_DNA_use_old" name="consensusDNAUseOld" :value="consensusdnauseold"/>
                            </v-col>
                        </v-row>
                    </v-expansion-panel-content>
                </v-expansion-panel>

                <v-expansion-panel>
                    <v-expansion-panel-header>Search</v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <v-row>
                            <v-col cols="12">
                                <v-autocomplete id="defaultSearch" class="defaultSearch" name="defaultSearch" v-model="defaultsearch" dusk="se-default-search"
                                                :items="defaultsearchdata" item-value="value" item-text="text"
                                                :label="defaultsearchlabel" :persistent-hint="true" :hint="defaultsearchlabelhelp">
                                </v-autocomplete>
                            </v-col>
                            <v-col cols="12">
                                <v-switch :id="'saveLastSearch'" :name="'saveLastSearch'" v-model="savelastsearchby" :dusk="'se-save-last-search'"
                                          :label="savelastsearchbylabel" :disabled="false" :persistent-hint="true" :hint="savelastsearchbylabelhelp">
                                </v-switch>
                                <input type="hidden" id="save_last_search" name="saveLastSearch" :value="savelastsearchby"/>
                            </v-col>
                            <v-col cols="12">
                                <v-switch :id="'searchOpenInNewBrowser'" :name="'searchOpenInNewBrowser'" v-model="searchopeninnewbrowser" :dusk="'se-notify-via-email'"
                                          :label="searchopeninnewbrowserlabel" :disabled="false" :persistent-hint="true" :hint="searchopeninnewbrowserlabelhelp">
                                </v-switch>
                                <input type="hidden" id="search_open_in_new_browser" name="searchOpenInNewBrowser" :value="searchopeninnewbrowser"/>
                            </v-col>
                        </v-row>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels>

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
    import {changeObjectToArray, apiGetCall} from '../../../coraBaseModules';

    export default {
        name: "user-profile-project",
        props: {
            defaultprojectoptions: Object,
            defaultprojectlabel: null,
            defaultprojectlabelhelp: null,
            defaultprojectvmodel: String,
            defaultsearchoptions: Object,
            defaultsearchlabel: String,
            defaultsearchlabelhelp: String,
            defaultsearchvmodel: String,
            savelastsearchbyoptions: Boolean,
            savelastsearchbylabel: String,
            savelastsearchbylabelhelp: String,

            searchopeninnewbrowseroptions: Boolean,
            searchopeninnewbrowserlabel: String,
            searchopeninnewbrowserlabelhelp: String,
            useraccessionnumberlabel: String,
            userprovenance1label: String,
            userprovenance2label: String,
            usermrulistspecimenslabel: String,
            useraccessionnumberlabelhelp: String,
            userprovenance1labelhelp: String,
            userprovenance2labelhelp: String,
            usermrulistspecimenslabelhelp: String,
            senewredirecturllabel: String,
            senewredirecturloptions: Object,
            senewredirecturlvmodel: String,
            senewredirecturllabelhelp: String,
            userdefaultlablabel: String,
            userdefaultlaboptions: Object,
            userdefaultlabvmodel: String,
            userdefaultlablabelhelp: String,
            defaultmitomethodoptions: Object,
            defaultmitomethodvmodel: String,
            defaultmitomethodlabelhelp: String,
            defaultmitomethodlabel: String,
            defaultymethodlabel: String,
            defaultymethodoptions: Object,
            defaultymethodvmodel: String,
            defaultymethodlabelhelp: String,
            defaultautomethodlabel: String,
            defaultautomethodoptions: Object,
            defaultautomethodvmodel: String,
            defaultautomethodlabelhelp: String,
            consensusdnauseoldlabel: String,
            consensusdnauseoldoptions: Boolean,
            consensusdnauseoldvmodel: String,
            consensusdnauseoldlabelhelp: String,
            useraccessionnumber: String,
            userprovenance1: String,
            userprovenance2: String,
            usermrulistspecimens: String,
        },
        data() {
            return {
                defaultproject: (this.defaultprojectvmodel) ? this.defaultprojectvmodel : "",
                accessionnumber: (this.useraccessionnumber) ? this.useraccessionnumber : "",
                provenance1: (this.userprovenance1) ? this.userprovenance1 : "",
                provenance2: (this.userprovenance2) ? this.userprovenance2 : "",
                mrulistspecimens: (this.usermrulistspecimens) ? this.usermrulistspecimens : "",
                senewredirecturl: (this.senewredirecturlvmodel) ? this.senewredirecturlvmodel : "",
                defaultlab: (this.userdefaultlabvmodel) ? this.userdefaultlabvmodel : "",
                defaultmitomethod: (this.defaultmitomethodvmodel) ? this.defaultmitomethodvmodel : "",
                defaultymethod: (this.defaultymethodvmodel) ? this.defaultymethodvmodel : "",
                defaultautomethod: (this.defaultautomethodvmodel) ? this.defaultautomethodvmodel : "",
                consensusdnauseold: (this.consensusdnauseoldoptions) ? this.consensusdnauseoldoptions : "",
                defaultsearch: (this.defaultsearchvmodel) ? this.defaultsearchvmodel : "",
                savelastsearchby: (this.savelastsearchbyoptions) ? this.savelastsearchbyoptions : "",
                searchopeninnewbrowser:(this.searchopeninnewbrowseroptions) ? this.searchopeninnewbrowseroptions : "",
                panel: '',

                defaultprojectdata: changeObjectToArray(this.defaultprojectoptions),
                defaultsearchdata: changeObjectToArray(this.defaultsearchoptions),
                senewredirecturldata: changeObjectToArray(this.senewredirecturloptions),
                defaultmitomethoddata: changeObjectToArray(this.defaultmitomethodoptions),
                defaultymethoddata: changeObjectToArray(this.defaultymethodoptions),
                defaultautomethoddata: changeObjectToArray(this.defaultautomethodoptions),
                userdefaultlablabeldata: changeObjectToArray(this.userdefaultlaboptions),
            };
        },
        mounted() {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrfToken;
        },
        methods: {
            postData: function () {
                axios.post('/users/' + this.theUser.id + '/projects', {
                    default_project: this.defaultproject,
                    accession: this.accessionnumber,
                    provenance1: this.provenance1,
                    provenance2: this.provenance2,
                    mru_list_skeletalelements: this.mrulistspecimens,
                    se_new_redirect_url: this.senewredirecturl,
                    default_lab: this.defaultlab,
                    default_mito_method: this.defaultmitomethod,
                    default_y_method: this.defaultymethod,
                    default_auto_method: this.defaultautomethod,
                    default_search_option: this.defaultsearch,
                    user_save_last_search_by: this.savelastsearchby ? 1 : 0,
                    consensus_dna_use_old: this.consensusdnauseold ? 1 : 0,
                    se_search_open_in_new_browser_tab: this.searchopeninnewbrowser ? 1 : 0
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

<style scoped>
</style>
