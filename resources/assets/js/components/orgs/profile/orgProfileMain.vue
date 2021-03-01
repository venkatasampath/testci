<template>
    <div class="m-2 align-center">
        <contentheader :trail="trail" :title="heading_org" model_name="org-profile" :help_menu="true"></contentheader>
        <v-row align="center" justify="center">
            <v-col cols="12" md="8">
                <v-tabs centered>
                    <v-tab><v-icon left>mdi-office-building</v-icon>About</v-tab>
                    <v-tab><v-icon left>mdi-information</v-icon>General</v-tab>
                    <v-tab><v-icon left>mdi-counter</v-icon>Unit of Measure</v-tab>
                    <v-tab><v-icon left>mdi-earth</v-icon>Localization</v-tab>
                    <v-tab><v-icon left>mdi-shield-key</v-icon>API Keys</v-tab>
                    <v-tab-item centered>
                        <org-profile-about
                                :orgnamelabel="orgnamelabel"
                                :orgnamevmodel="orgnamevmodel"
                                :org_acronymlabel="org_acronymlabel"
                                :org_acronymvmodel="org_acronymvmodel"
                                :org_descriptionlabel="org_descriptionlabel"
                                :org_descriptionvmodel="org_descriptionvmodel"
                                :addresslabel="addresslabel"
                                :addressvmodel="addressvmodel"
                                :citylabel="citylabel"
                                :cityvmodel="cityvmodel"
                                :statelabel="statelabel"
                                :statevmodel="statevmodel"
                                :ziplabel="ziplabel"
                                :zipvmodel="zipvmodel"
                                :websitelabel="websitelabel"
                                :websitevmodel="websitevmodel"
                                :phone_number="phone_number"
                                :phone_label="phone_label"
                                :tfphone="tfphone"
                                :tfphone_label="tfphone_label"
                                :fax_number="fax_number"
                                :fax_label="fax_label"
                                :contact_name="contact_name"
                                :contact_name_label="contact_name_label"
                                :contact_email="contact_email"
                                :contact_email_label="contact_email_label"
                                :geo_lat="geo_lat"
                                :geo_lat_label="geo_lat_label"
                                :geo_long="geo_long"
                                :geo_long_label="geo_long_label">
                        </org-profile-about>
                    </v-tab-item>
                    <v-tab-item>
                        <org-profile-general
                                :welcomescreenlabel="welcomescreenlabel"
                                :welcomescreenlabelhelp="welcomescreenlabelhelp"
                                :welcomescreenvalue="welcomescreenvalue"
                                :addcorademoprojectslabelhelp="addcorademoprojectslabelhelp"
                                :addcorademoprojectslabel="addcorademoprojectslabel"
                                :addcorademoprojectsvalue="addcorademoprojectsvalue">
                        </org-profile-general>
                    </v-tab-item>
                    <v-tab-item>
                        <org-profile-uom
                                :massoptions="massunitoptions"
                                :lengthoptions="lengthunitoptions"
                                :massvmodel="massunitvmodel"
                                :lengthvmodel="lengthunitvmodel"
                                :lengthlabel="lengthunitlabel"
                                :lengthlabelhelp="lengthunitlabelhelp"
                                :masslabelhelp="massunitlabelhelp"
                                :masslabel="massunitlabel">
                        </org-profile-uom>
                    </v-tab-item>
                    <v-tab-item>
                        <localization
                                :countries_options="countries_options"
                                :languages_options="languages_options"
                                :timezones_options="timezones_options"
                                :default_country="default_country"
                                :default_language="default_language"
                                :default_time_zone="default_time_zone"
                                :post_url="this.base_url + '/org/localization'">
                        </localization>
                    </v-tab-item>
                    <v-tab-item>
                        <org-profile-apikeys
                                :slackwebhooklabel="slackwebhooklabel"
                                :slackchannellabel="slackchannellabel"
                                :googlemapslabel= "googlemapslabel"
                                :slackchannellabelhelp="slackchannellabelhelp"
                                :slackwebhooklabelhelp="slackwebhooklabelhelp"
                                :googlemapslabelhelp="googlemapslabelhelp"
                                :slackwebhookvmodel="slackwebhookvmodel"
                                :slackchannelvmodel="slackchannelvmodel"
                                :googlemapsvmodel="googlemapsvmodel">
                        </org-profile-apikeys>
                    </v-tab-item>
                </v-tabs>
            </v-col>
        </v-row>
    </div>
</template>
<script>
    import {mapGetters, mapState} from "vuex";

    export default {
        name : "org-profile-main",
        props: {
            heading: { type: String, default: "Org Profile" },

            // Localization props
            countries_options: Object,
            languages_options: Object,
            timezones_options: Object,
            default_country: String,
            default_language: String,
            default_time_zone: String,
            post_url: String,

            // About
            orgname_name:String,
            orgnamevmodel:String,
            orgnamelabel:String,
            org_acronymlabel:String,
            org_acronym_name:String,
            org_acronymvmodel:String,
            org_descriptionlabel:String,
            org_description_name:String,
            org_descriptionvmodel:String,
            addresslabel:String,
            address_name:String,
            addressvmodel:String,
            city_name:String,
            citylabel:String,
            cityvmodel:String,
            statelabel:String,
            state_name:String,
            statevmodel:String,
            zip_name:String,
            ziplabel:String,
            zipvmodel:String,
            website_name:String,
            websitelabel:String,
            websitevmodel:String,
            phone_number:String,
            phone_label:String,
            tfphone:String,
            tfphone_label:String,
            fax_number:String,
            fax_label:String,
            contact_name:String,
            contact_name_label:String,
            contact_email:String,
            contact_email_label:String,
            geo_lat:String,
            geo_lat_label:String,
            geo_long:String,
            geo_long_label:String,

            // General
            welcomescreenlabel: String,
            welcomescreenlabelhelp: String,
            welcomescreenvalue: String,
            addcorademoprojectslabelhelp: String,
            addcorademoprojectslabel: String,
            addcorademoprojectsvalue: Boolean,

            // Units props
            massunitoptions: Object,
            massunitlabel: String,
            massunitvmodel: String,
            massunitlabelhelp: String,
            lengthunitlabel: String,
            lengthunitvmodel: String,
            lengthunitlabelhelp: String,
            lengthunitoptions: Object,

            // API keys
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
                trail: [{ text: 'Home', disabled: false, href: '/', }, { text: 'Org Profile', disabled: true, href: '/', }, ],
                heading_org: this.heading,
            };
        },
        mounted() {
            this.heading_org = this.theOrg.acronym + " : " + this.theOrg.name;
        },
        computed: {
            ...mapState({
                base_url: state => state.baseURL,
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
