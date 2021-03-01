<template>
    <div class="m-2">
        <v-card flat>
            <v-row align="center" justify="center">
                <v-col cols="12" :md="cols" class="py-0">
                    <v-toolbar v-if="show_toolbar">
                        <v-badge color="primary" >Audits</v-badge>
                        <v-spacer></v-spacer>
                        <v-btn :title="showCollapse?'Collapse':'Expand'" icon @click="showCollapse = !showCollapse" color="primary" :loading="loading" dusk="comment-tag">
                            <v-icon v-text="showCollapse?'mdi-arrow-collapse-up':'mdi-arrow-collapse-down'"></v-icon>
                        </v-btn>
                    </v-toolbar>
                    <v-card outlined v-show="showCollapse">
                        <v-timeline v-model="audits" v-for="item in audits" v-bind:key="item.id"  align-top dense>
                            <v-timeline-item :right="right" :left="left" class="grey--text" large>
                                <template v-slot:icon><v-avatar><img :src="getUserAvatar(item)" alt=""></v-avatar></template>
                                <v-row align="start"><v-col cols="2" v-text="getUserDisplayName(item)"/><v-col cols="2">{{item.event}}</v-col><v-col cols="6" v-text="getChangeDateTime(item)"/></v-row>
                                <v-row>
                                    <v-col>
                                    <v-card class="elevation-2">
                                        <v-card-title class="headline">Old Values</v-card-title>
                                        <v-card-text>{{item.old_values}}</v-card-text>
                                    </v-card>
                                    </v-col>
                                    <v-col>
                                    <v-card class="elevation-2">
                                        <v-card-title class="headline">New Values</v-card-title>
                                        <v-card-text>{{item.new_values}}</v-card-text>
                                    </v-card>
                                    </v-col>
                                </v-row>
                            </v-timeline-item>
                        </v-timeline>
                    </v-card>
                </v-col>
            </v-row>
        </v-card>
    </div>
</template>

<script>
    import axios from 'axios';
    import moment from "moment";
    import {mapGetters, mapState} from "vuex";
    let date = new Date();

    export default {
        name: "audits",
        props: {
            toolbar: {type: Boolean, default: true},
            cols: {type: Number, default: 12},
            specimen_id: {type: Number, required: true}
        },
        data() {
            return {
                audits: {},
                show_toolbar: this.toolbar,
                showCollapse: true,
                right: true,
                left: false,
                type: "audits",
                loading: false

            }
        },
        mounted() {
            this.getAudits();
        },
        methods: {
            getAudits() {
                this.loading = true;
                axios
                    .request({
                        url: '/api/specimens/' + this.specimen_id + '/associations?type=' + this.type,
                        method: 'GET',
                        headers: {'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken,}
                    }).then(response => {
                    this.loading = false;
                    this.audits = response.data.data;
                }).catch(error => {
                    this.loading = false;
                })
            },
            getUserDisplayName(item) {
                let user = this.$store.getters.getOrgUserById(item.user_id);
                return user.display_name;
            },
            getChangeDateTime(item) {
                return moment(item.created_at).format("ddd, MMM Do YYYY, h:mm a");
            },
            getUserAvatar(item) {
                let user = this.$store.getters.getOrgUserById(item.user_id);
                return user.avatar;
            },
        },
        computed: {
            ...mapGetters({
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
            }),
        }
    }
</script>

<style scoped>

</style>

