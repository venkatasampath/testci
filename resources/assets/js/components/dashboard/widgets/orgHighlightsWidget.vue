<template>
    <v-row class="mx-2 align-center" justify="center">
        <v-col class="my-2 p-0" cols="12" md="2" v-for="(item, index) in items" :key="`label-${index}`">
            <v-card>
                <v-row class="no-gutters">
                    <div class="col-auto"><div :class="item.borderColor + ' fill-height'">&nbsp;</div></div>
                    <div class="col pl-2 primary--text">
                        <v-icon :title="item.name" class="pr-2" :color="item.borderColor" :loading="loading">{{item.icon}}</v-icon>
                        <span v-if="loaded">{{item.name+": "+item.count}}</span>
                    </div>
                </v-row>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import axios from "axios";

    export default {
        name: "org-highlights-widget",
        props: {
            //
        },
        data() {
            return {
                loading: false,
                loaded:false,
                response: null,
                items:[
                    { name: 'Projects', width: 2, visible: true, icon: 'mdi-briefcase-variant', borderColor: 'primary', },
                    { name: 'Users', width: 2, visible: true, icon: 'mdi-account-multiple', borderColor: 'success', },
                    { name: 'Specimens', width: 2, visible: true, icon: 'mdi-bone', borderColor: 'warning', },
                    { name: 'DNA Samples', width: 2, visible: true, icon: 'mdi-dna', borderColor: 'primary', },
                    { name: 'Isotope Samples', width: 2, visible: true, icon: 'mdi-radioactive', borderColor: 'success', },
                    { name: 'Instruments', width: 2, visible: true, icon: 'mdi-tools', borderColor: 'warning', },
                ],
            }
        },
        mounted() {
            this.getHighlights();
        },
        methods: {
            getHighlights: function () {
                this.loading = true;
                axios
                    .request({ url: '/api/dashboard/orgs/'+this.theOrg.id+'/highlights', method: 'GET',
                        headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken, },
                    })
                    .then(response => {
                        this.response = response.data;
                        this.items[0].count = response.data.data.projects;
                        this.items[1].count = response.data.data.users;
                        this.items[2].count = response.data.data.specimens;
                        this.items[3].count = response.data.data.dnas;
                        this.items[4].count = response.data.data.isotopes;
                        this.items[5].count = response.data.data.instruments;
                        this.loading = false;
                        this.loaded = true;
                    })
            },
        },
        computed:{
            ...mapState({
                //
            }),
            ...mapGetters({
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
                bearerToken: 'bearerToken',
                csrfToken: 'csrfToken',
            }),
        },
    }
</script>
