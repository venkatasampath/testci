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
        name: "project-highlights-widget",
        props: {
            project_id: { type: Number, default: 0 },
            stats: { type: Object|Array, default: () => ({}) },
        },
        data() {
            return {
                loading: false,
                loaded:false,
                specimen_stats: null,
                dna_stats: null,
                isotope_stats: null,
                items:[
                    { name: 'Specimens', width: 2, visible: true, icon: 'mdi-bone', borderColor: 'primary', },
                    { name: 'Accessions', width: 2, visible: true, icon: 'mdi-map-marker-radius', borderColor: 'success', },
                    { name: 'Provenance1', width: 2, visible: true, icon: 'mdi-map-marker', borderColor: 'warning', },
                    { name: 'Provenance2', width: 2, visible: true, icon: 'mdi-pin', borderColor: 'secondary', },
                    { name: 'Bone Groups', width: 2, visible: true, icon: 'mdi-group', borderColor: 'primary', },
                    { name: 'Unique Individuals', width: 2, visible: true, icon: 'mdi-human', borderColor: 'success', },
                ],
            }
        },
        created() {
            // If data is not passed by parent dashboard container, go fetch it
            // If we stringify the object and the result is simply an
            // opening and closing bracket, we know the object is empty.
            if (JSON.stringify(this.stats) === '{}') {
                this.getHighlights();
            } else {
                this.setItems(this.stats);
            }
        },
        methods: {
            getHighlights: function () {
                this.loading = true;
                axios
                    .request({ url: '/api/dashboard/projects/'+this.project_id+'/highlights', method: 'GET',
                        headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken, },
                    })
                    .then(response => {
                        this.setItemsFromHighlights(response.data.data);
                        this.loading = false;
                    })
            },
            setItems(data) {
                // Set Specimen Stats
                this.items[0].count = this.stats.specimen.se_total;
                this.items[1].count = this.stats.specimen.num_accessions;
                this.items[2].count = this.stats.specimen.num_provenance1;
                this.items[3].count = this.stats.specimen.num_provenance2;
                this.items[4].count = this.stats.specimen.num_unique_bone_groups;
                this.items[5].count = this.stats.specimen.num_unique_individuals;
                this.loaded = true;
            },
            setItemsFromHighlights(data) {
                this.items[0].count = data.specimens;
                this.items[1].count = data.accessions;
                this.items[2].count = data.provenance1;
                this.items[3].count = data.provenance2;
                this.items[4].count = data.bone_groups;
                this.items[5].count = data.individual_number;
                this.loaded = true;
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
