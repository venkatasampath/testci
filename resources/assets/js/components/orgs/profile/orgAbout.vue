<template>
    <v-card>
        <v-card-text>
            <v-row>
                <v-col cols="8">
                    <v-text-field id="org_name" name="org_name" v-model="orgname" dusk="se-org-name" :label="orgnamelabel"/>
                </v-col>
                <v-col cols="4">
                    <v-text-field id="org_acronym" name="org_acronym" v-model="org_acronym" dusk="se-org_acronym" :label="org_acronymlabel" :disabled="true"/>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-textarea id="org_description" name="org_description" v-model="org_description" dusk="se-org_description" :label="org_descriptionlabel" rows="3"/>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-text-field id="address" name="address" v-model="address" dusk="address" :label="addresslabel"/>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="4">
                    <v-text-field id="city" name="city" v-model="city" dusk="city" :label="citylabel"/>
                </v-col>
                <v-col cols="4">
                    <v-text-field id="state" name="state" v-model="state" dusk="state" :label="statelabel"/>
                </v-col>
                <v-col cols="4">
                    <v-text-field id="zip" name="zip" v-model="zip" dusk="zip" :label="ziplabel"/>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-text-field id="website" name="website" v-model="website" dusk="website" :label="websitelabel"></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="4">
                    <v-text-field id="phone" name="phone" v-model="phone" dusk="se-phone" :label="phone_label" max="12" type="integer" placeholder="555-555-5555"/>
                </v-col>
                <v-col cols="4">
                    <v-text-field id="tfphone" name="tfPhone" v-model="tollFreePhone" dusk="se-tfphone" :label="tfphone_label" max="12" type="integer" placeholder="555-555-5555"/>
                </v-col>
                <v-col cols="4">
                    <v-text-field id="fax" name="fax" v-model="fax" dusk="se-fax" :label="fax_label" max="12" type="integer" placeholder="555-555-5555"/>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="6">
                    <v-text-field id="contact_name" name="contact_name" v-model="contactName" dusk="se-contact_name" :label="contact_name_label" placeholder="John Doe"/>
                </v-col>
                <v-col cols="6">
                    <v-text-field id="contact_email" name="contact_email" v-model="contactEmail" dusk="se-contact_email" :label="contact_email_label" placeholder="johndoe@gmail.com"/>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="6">
                    <v-text-field id="lat" name="lat" v-model="geoLatitude" dusk="lat" :label="geo_lat_label"/>
                </v-col>
                <v-col cols="6">
                    <v-text-field id="long" name="long" v-model="geoLongitude" dusk="long" :label="geo_long_label"/>
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
    import axios from "axios";
    import {eventBus} from "../../../eventBus";

    export default {
        name: "org-profile-about",
        props: {
            orgnamelabel: String,
            orgnamevmodel: String,
            org_acronymlabel: String,
            org_acronymvmodel: String,
            org_descriptionlabel: String,
            org_descriptionvmodel: String,
            addresslabel: String,
            addressvmodel: String,
            citylabel: String,
            cityvmodel: String,
            statelabel: String,
            statevmodel: String,
            ziplabel: String,
            zipvmodel: String,
            websitelabel: String,
            websitevmodel: String,
            phone_number: String,
            phone_label: String,
            tfphone: String,
            tfphone_label: String,
            fax_number: String,
            fax_label: String,
            contact_name: String,
            contact_name_label: String,
            contact_email: String,
            contact_email_label: String,
            geo_lat: String,
            geo_lat_label: String,
            geo_long: String,
            geo_long_label: String
        },
        data() {
            return {
                orgname: null,
                org_acronym: null,
                org_description: null,
                address: null,
                city: null,
                state: null,
                zip: null,
                website: null,
                phone: this.phone_number,
                tollFreePhone: this.tfphone,
                fax: this.fax_number,
                contactName: this.contact_name ? this.contact_name : '',
                contactEmail: this.contact_email ? this.contact_email : '',
                geoLatitude: this.geo_lat ? this.geo_lat : '',
                geoLongitude: this.geo_long ? this.geo_long : '',
            }
        },
        mounted() {
            if (this.orgnamevmodel) {
                this.orgname = this.orgnamevmodel
            }
            if (this.org_acronymvmodel) {
                this.org_acronym = this.org_acronymvmodel
            }
            if (this.org_descriptionvmodel) {
                this.org_description = this.org_descriptionvmodel
            }
            if (this.addressvmodel) {
                this.address = this.addressvmodel
            }
            if (this.cityvmodel) {
                this.city = this.cityvmodel
            }
            if (this.statevmodel) {
                this.state = this.statevmodel
            }
            if (this.zipvmodel) {
                this.zip = this.zipvmodel
            }
            if (this.websitevmodel) {
                this.website = this.websitevmodel
            }
            axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrfToken;
        },
        methods: {
            postData: function () {
                axios.post('/org/about', {
                    org_name: this.orgname,
                    org_acronym: this.org_acronym,
                    org_description: this.org_description,
                    address: this.address,
                    city: this.city,
                    state: this.state,
                    zip: this.zip,
                    website: this.website,
                    phone: this.phone,
                    tfphone: this.tollFreePhone,
                    fax: this.fax,
                    contact_name: this.contactName,
                    contact_email: this.contactEmail,
                    lat: this.geoLatitude,
                    long: this.geoLongitude,
                })
                .then(response=>{
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
