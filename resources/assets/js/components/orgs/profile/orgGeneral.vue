<template>
    <v-card>
        <v-card-text>
            <v-row>
                <v-col cols="12">
                    <v-text-field id="welcome_screen_url" v-model="welcomeScreen" dusk="welcome_screen_url"
                                  :label="welcomescreenlabel" :persistent-hint="true" :hint="welcomescreenlabelhelp">
                    </v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-switch id="add_cora_demo_project_for_new_users" name="add_cora_demo_project_for_new_users" v-model="addCoraDemoProjects"
                              :label="addcorademoprojectslabel" dusk="add_cora_demo_project_for_new_users"
                              :persistent-hint="true" :hint="addcorademoprojectslabelhelp">
                    </v-switch>
                    <input type="hidden" :value="addCoraDemoProjects">
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
    import axios from 'axios';
    import {eventBus} from "../../../eventBus";

    export default {
        name: "org-profile-general",
        props: {
            welcomescreenlabel: String,
            welcomescreenlabelhelp: String,
            welcomescreenvalue: String,
            addcorademoprojectslabelhelp: String,
            addcorademoprojectslabel: String,
            addcorademoprojectsvalue: Boolean,
        },
        data() {
            return {
                addCoraDemoProjects: this.addcorademoprojectsvalue,
                welcomeScreen: this.welcomescreenvalue,
            }
        },
        mounted() {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrfToken;
        },
        methods:{
            postData: function() {
                axios.post('/org/general', {
                    welcome_screen_url: this.welcomeScreen,
                    add_cora_demo_project_for_new_users: this.addCoraDemoProjects?1:0,
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
