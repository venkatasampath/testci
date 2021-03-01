<template>
    <v-card>
        <v-card-text>
            <v-row>
                <v-col cols="12">
                    <v-autocomplete id="country" class="countries" v-model="defaultcountry" dusk="default-country"
                                    :items="country_items" item-value="value" item-text="text" label="Default Country"
                                    required :rules="[v => !!v || 'Country is required']">
                    </v-autocomplete>
                </v-col>
                <v-col cols="12">
                    <v-autocomplete id="language" class="languages" v-model="defaultlanguage" dusk="default-language"
                                    :items="language_items" item-value="value" item-text="text" label="Default Language"
                                    required :rules="[v => !!v || 'Language is required']">
                    </v-autocomplete>
                </v-col>
                <v-col cols="12">
                    <v-autocomplete id="timeZone" class="timeZones" v-model="defaulttimezone" dusk="default-timezones"
                                    :items="timezone_items" item-value="value" item-text="text" label="Default Time Zone"
                                    required :rules="[v => !!v || 'Time Zone is required']">
                    </v-autocomplete>
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
    import {changeObjectToArray} from '../../../coraBaseModules';
    import axios from "axios";
    import {eventBus} from "../../../eventBus";

    export default {
        name: "localization",
        props: {
            countries_options: Object,
            languages_options: Object,
            timezones_options: Object,
            default_country: String,
            default_language: String,
            default_time_zone: String,
            post_url: { type: String, default: "/org/localization" },
        },
        data() {
            return {
                defaultcountry: (this.default_country) ? this.default_country : "",
                defaultlanguage: (this.default_language) ? this.default_language : "",
                defaulttimezone: (this.default_time_zone) ? this.default_time_zone : "",
                country_items: changeObjectToArray(this.countries_options),
                language_items: changeObjectToArray(this.languages_options),
                timezone_items: changeObjectToArray(this.timezones_options),
            };
        },
        mounted() {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrfToken;
        },
        methods:{
            postData: function() {
                axios.post(this.post_url , {
                    default_country: this.defaultcountry,
                    default_language: this.defaultlanguage,
                    default_timezone: this.defaulttimezone,
                }).then(response=>{
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
