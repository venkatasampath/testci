<template>
    <v-card>
        <v-card-text>
            <v-row>
                <v-col cols="12">
                    <v-autocomplete :id="'mass'" v-model="mass" :label="masslabel" :dusk="'mass-unit'"
                                    :items="mass_items" item-text="text" item-value="keys"
                                    :persistent-hint="true" :hint="masslabelhelp">
                    </v-autocomplete>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-autocomplete :id="'length'" v-model="length" :label="lengthlabel" :dusk="'length-unit'"
                                    :items="length_items" item-text="text" item-value="keys"
                                    :persistent-hint="true" :hint="lengthlabelhelp">
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
    import {eventBus} from "../../../eventBus";
    import axios from 'axios';
    import {changeObjectToArray, apiGetCall, apiPostCall} from '../../../coraBaseModules';

    export default {
        name: "org-profile-uom",
        props: {
            //Units props
            massoptions: Object,
            masslabel: String,
            massvmodel: String,
            masslabelhelp: String,
            lengthlabel: String,
            lengthvmodel: String,
            lengthlabelhelp: String,
            lengthoptions: Object,
        },
        data() {
            return {
                mass: (this.massoptions) ? this.massvmodel : null,
                length: (this.lengthoptions) ? this.lengthvmodel : null,
                mass_items: changeObjectToArray(this.massoptions),
                length_items: changeObjectToArray(this.lengthoptions),
            }
        },
        mounted() {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrfToken;
        },
        methods: {
            postData: function () {
                axios.post('/org/measurements', {
                    org_mass_unit_of_measure: this.mass,
                    org_length_unit_of_measure: this.length,
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

<style scoped>
</style>
