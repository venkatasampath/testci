<template>
    <div class="m-2 align-center">
        <contentheader :trail="trail" :title="heading_user" model_name="user-profile" :help_menu="true"></contentheader>
        <v-row align="center" justify="center">
            <v-col cols="12" md="8">
                <v-tabs centered show-arrows>
                    <v-tab><v-icon left>mdi-account</v-icon>Profile</v-tab>
                    <v-tab><v-icon left>mdi-information</v-icon>General</v-tab>
                    <v-tab><v-icon left>mdi-folder-text-outline</v-icon>Project</v-tab>
                    <v-tab><v-icon left>mdi-bell</v-icon>Notification</v-tab>
                    <v-tab><v-icon left>mdi-earth</v-icon>Localization</v-tab>
                    <v-tab><v-icon left>mdi-login</v-icon>Last Login</v-tab>
                    <v-tab><v-icon left>mdi-account-details</v-icon>User Activity</v-tab>
                    <v-tab-item>
                        <user-profile
                            :displaynamelabel= "'Name:'"
                            :emaillabel= "'Email:'"
                            :userrolelabel= "'Role:'"
                            :cellphoneplaceholder= "'555-555-5555'"
                            :cellphonelabel= "'Cell Phone:'"
                            :altphoneplaceholder=  "'777-777-7777'"
                            :altphonelabel= "'Alt Phone:'"
                            :slackchannelplaceholder= "'https://slack.com/myChannel'"
                            :slackchannellabel= "'Slack Channel:'"
                            :displaynamevmodel="displaynamevmodel"
                            :displaynamename="'name'"
                            :emailname="'email'"
                            :userrolename="'role'"
                            :userrolevmodel="userrolevmodel"
                            :emailvmodel="emailvmodel"
                            :cellphonevmodel="cellphonevmodel"
                            :altphonevmodel="altphonevmodel"
                            :slackchannelvmodel="slackchannelvmodel"
                            :profilephotovmodel="profilephotovmodel">
                        </user-profile>
                    </v-tab-item>
                    <v-tab-item>
                        <user-profile-general
                            :linesperpagelabel="linesperpagelabel"
                            :linesperpageoptions="linesperpageoptions"
                            :linesperpagevmodel="linesperpagevmodel"
                            :linesperpagelabelhelp="linesperpagelabelhelp"
                            :welcomescreenlabel="welcomescreenlabel"
                            :welcomescreenlabelhelp="welcomescreenlabelhelp"
                            :welcomescreenoptions="welcomescreenoptions"
                            :helpslideoutoptions="helpslideoutoptions"
                            :helpslideoutlabel="helpslideoutlabel"
                            :helpslideoutlabelhelp="helpslideoutlabelhelp">
                        </user-profile-general>
                    </v-tab-item>
                    <v-tab-item>
                        <user-profile-project
                                :useraccessionnumber="useraccessionnumber"
                                :userprovenance1="userprovenance1"
                                :userprovenance2="userprovenance2"
                                :usermrulistspecimens="usermrulistspecimens"
                                :defaultprojectoptions="defaultprojectoptions"
                                :defaultprojectlabel="defaultprojectlabel"
                                :defaultprojectlabelhelp="defaultprojectlabelhelp"
                                :defaultprojectvmodel="defaultprojectvmodel"
                                :defaultsearchoptions="defaultsearchoptions"
                                :defaultsearchlabel="defaultsearchlabel"
                                :defaultsearchlabelhelp="defaultsearchlabelhelp"
                                :defaultsearchvmodel="defaultsearchvmodel"
                                :savelastsearchbyoptions="savelastsearchbyoptions"
                                :savelastsearchbylabel="savelastsearchbylabel"
                                :savelastsearchbylabelhelp="savelastsearchbylabelhelp"
                                :searchopeninnewbrowseroptions="searchopeninnewbrowseroptions"
                                :searchopeninnewbrowserlabel="searchopeninnewbrowserlabel"
                                :searchopeninnewbrowserlabelhelp="searchopeninnewbrowserlabelhelp"
                                :useraccessionnumberlabel="useraccessionnumberlabel"
                                :userprovenance1label="userprovenance1label"
                                :userprovenance2label="userprovenance2label"
                                :usermrulistspecimenslabel="usermrulistspecimenslabel"
                                :useraccessionnumberlabelhelp="useraccessionnumberlabelhelp"
                                :userprovenance1labelhelp="userprovenance1labelhelp"
                                :userprovenance2labelhelp= "userprovenance2labelhelp"
                                :usermrulistspecimenslabelhelp="usermrulistspecimenslabelhelp"
                                :senewredirecturllabel="senewredirecturllabel"
                                :senewredirecturloptions="senewredirecturloptions"
                                :senewredirecturlvmodel="senewredirecturlvmodel"
                                :senewredirecturllabelhelp="senewredirecturllabelhelp"
                                :defaultmitomethodlabel="'Default Mito Method:'"
                                :defaultmitomethodoptions="defaultmitomethodoptions"
                                :defaultmitomethodvmodel="defaultmitomethodvmodel"
                                :defaultmitomethodlabellhelp="defaultmitomethodlabellhelp"
                                :defaultymethodlabel="defaultymethodlabel"
                                :defaultymethodoptions="defaultymethodoptions"
                                :defaultymethodvmodel="defaultymethodvmodel"
                                :defaultymethodlabelhelp="defaultymethodlabelhelp"
                                :defaultautomethodlabel="defaultautomethodlabel"
                                :defaultautomethodoptions="defaultautomethodoptions"
                                :defaultautomethodvmodel="defaultautomethodvmodel"
                                :defaultautomethodlabelhelp="defaultautomethodlabelhelp"
                                :consensusdnauseoldlabel="consensusdnauseoldlabel"
                                :consensusdnauseoldoptions="consensusdnauseoldoptions"
                                :consensusdnauseoldvmodel="consensusdnauseoldvmodel"
                                :consensusdnauseoldlabelhelp="consensusdnauseoldlabelhelp"
                                :userdefaultlablabel="userdefaultlablabel"
                                :userdefaultlaboptions="userdefaultlaboptions"
                                :userdefaultlabvmodel="userdefaultlabvmodel"
                                :userdefaultlablabelhelp="userdefaultlablabelhelp">
                            </user-profile-project>
                    </v-tab-item>
                    <v-tab-item>
                        <user-profile-notification
                                :switcher="switcher"
                                :notifyexportoptions="notifyexportoptions"
                                :notifyexportlabel="'Data Transfer Job Completes'"
                                :notifyexportlabelhelp="notifyexportlabelhelp"
                                :notifyreviewoptions="notifyreviewoptions"
                                :notifyreviewlabel="'Remains Review Completes'"
                                :notifyreviewlabelhelp="notifyreviewlabelhelp"
                                :notifyviaemailoptions="notifyviaemailoptions"
                                :notifyviaemaillabel="'Email'"
                                :notifyviaemaillabelhelp="notifyviaemaillabelhelp"
                                :notifyviasmsoptions="notifyviasmsoptions"
                                :notifyviasmslabel="'SMS to Mobile'"
                                :notifyviasmslabelhelp="notifyviasmslabelhelp"
                                :notifyviaslackoptions="notifyviaslackoptions"
                                :notifyviaslacklabel="'Slack Notification'"
                                :notifyviaslacklabelhelp="notifyviaslacklabelhelp"
                                :emailvmodel="emailvmodel"
                                :cellphonevmodel="cellphonevmodel"
                                :slackchannelvmodel="slackchannelvmodel">
                        </user-profile-notification>
                    </v-tab-item>
                    <v-tab-item>
                        <localization
                                :countries_options="countries_options"
                                :languages_options="languages_options"
                                :timezones_options="timezones_options"
                                :default_country="default_country"
                                :default_language="default_language"
                                :default_time_zone="default_time_zone"
                                :post_url="'/users/' + this.theUser.id + '/localization'">
                        </localization>
                    </v-tab-item>
                    <v-tab-item>
                        <user-profile-lastlogin></user-profile-lastlogin>
                    </v-tab-item>
                    <v-tab-item>
                        <v-card flat>
                            <v-card-text>
                                <user-profile-activity-specimen :table_data="table_data"></user-profile-activity-specimen>
                                <user-profile-activity-dna :dna_table_data="dna_table_data"></user-profile-activity-dna>
                            </v-card-text>
                        </v-card>
                    </v-tab-item>
                </v-tabs>
            </v-col>
        </v-row>
    </div>
</template>
<script>
    import {mapGetters, mapState} from "vuex";

    export default {
        name : "user-profile-main",
        props: {
            heading: { type: String, default: "User Profile" },

            // Profile props
            displaynamevmodel: String,
            userrolevmodel: String,
            emailvmodel: String,
            cellphonevmodel: String,
            altphonevmodel: String,
            slackchannelvmodel: String,
            profilephotovmodel: String,

            // General props
            linesperpagevmodel: null,
            linesperpageoptions: null,
            linesperpagelabel: String,
            linesperpagelabelhelp: String,
            welcomescreenoptions: null,
            welcomescreenlabel: String,
            welcomescreenlabelhelp: String,
            helpslideoutoptions: null,
            helpslideoutlabel: String,
            helpslideoutlabelhelp: String,

            // notification props
            notifyexportoptions: Boolean,
            notifyexportlabel: String,
            notifyexportlabelhelp: String,
            notifyreviewoptions: Boolean,
            notifyreviewlabel: String,
            notifyreviewlabelhelp: String,
            notifyviaemailoptions: Boolean,
            notifyviaemaillabel: String,
            notifyviaemaillabelhelp: String,
            notifyviasmsoptions: null,
            notifyviasmslabel: String,
            notifyviasmslabelhelp: String,
            notifyviaslackoptions: null,
            notifyviaslacklabel: String,
            notifyviaslacklabelhelp: String,

            // Localization props
            countries_options: Object,
            languages_options: Object,
            timezones_options: Object,
            default_country: String,
            default_language: String,
            default_time_zone: String,

            // Project props
            useraccessionnumber:String,
            userprovenance1: String,
            userprovenance2: String,
            usermrulistspecimens: String,
            defaultprojectoptions: Object,
            defaultprojectlabel: String,
            defaultprojectlabelhelp: String,
            defaultprojectvmodel: String,
            defaultsearchoptions: Object,
            defaultsearchlabel: String,
            defaultsearchlabelhelp: String,
            defaultsearchvmodel: null,
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
            defaultmitomethodlabellhelp: String,
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

            dna_table_data: Array,
            lines_options: Object,
            table_data: Array,
            disable_option: Object,
            projects_options: Object,
            search_options: Object,
            lab_options: Object,
            mito_options: Object,
            y_options: Object,
            auto_options: Object,
            disabled: Boolean,
            switcher: Boolean,

            // project tab props
            default_project_options: Object,
            se_new_redirect_url_options: Object,
            default_lab_options: Object,
            mito_method_options: Object,
            y_method_options: Object,
            auto_method_options: Object,
        },
        data() {
            return {
                trail: [{ text: 'Home', disabled: false, href: '/', }, { text: 'User Profile', disabled: true, href: '/', }, ],
                heading_user: this.heading,
            };
        },
        mounted() {
            this.heading_user = this.org_and_role + " - " + this.theUser.display_name;
        },
        computed: {
            ...mapState({
                base_url: state => state.baseURL,
            }),
            ...mapGetters({
                org_and_role: 'org_and_role',
                bearerToken: 'bearerToken',
                csrfToken: 'csrfToken',
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
            }),
        },
    }
</script>


