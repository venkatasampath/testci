<template>
    <v-card>
        <v-card-title class="m-0 p-0">
            <v-app-bar>
                <v-toolbar-title>{{title}}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-progress-circular v-if="loading" :indeterminate="loading" color="primary"></v-progress-circular>
            </v-app-bar>
        </v-card-title>
        <v-card-text>
            <div class="mt-4 p-0">
                <h6>Specimens</h6>
                <v-divider class="m-0 p-0"></v-divider>
                <v-data-table :headers="columnVisibility('specimens')" :items="items_specimens" :items-per-page="10" :options.sync="options_specimens"
                              calculate-widths="" class="elevation-1" :sort-by="['key']" multi-sort :loading="loading" :hide-default-footer="true">
                    <!--                          :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }">-->
                    <template v-slot:item.key_bone_side="{ item }"><a :href="`/skeletalelements/${item.id}`" target="_blank">{{ item.key_bone_side }}</a></template>
                </v-data-table>
                <v-divider class="m-0 p-0"></v-divider>
            </div>
            <div class="mt-8 p-0">
                <h6>DNA</h6>
                <v-divider class="m-0 p-0"></v-divider>
                <v-data-table :headers="columnVisibility('dnas')" :items="items_dnas" :items-per-page="10" :options.sync="options_dnas"
                              calculate-widths="" class="elevation-1" :sort-by="['key']" multi-sort :loading="loading" :hide-default-footer="true">
                    <template v-slot:item.key_bone_side="{ item }"><a :href="`/skeletalelements/${item.id}`" target="_blank">{{ item.key_bone_side }}</a></template>
                    <template v-slot:item.mito_sequence_number="{ item }"><a :href="`/reports/mtdna/`" target="_blank">{{ item.mito_sequence_number }}</a></template>
                </v-data-table>
            </div>
        </v-card-text>
    </v-card>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import axios from "axios";

    export default {
        name: "rhsPanelUserActivity",
        props:{
            title: {type:String, default: "User Activity"},
            show: {type:Boolean, default: false},
        },
        data() {
            return {
                loading: false,
                items_specimens: [],
                items_dnas: [],
                options_specimens: {},
                options_dnas: {},
                headers_specimens: [
                    {text: 'Key', value: 'key', width: '10rem', visibility: false},
                    {text: 'Key Bone Side', value: 'key_bone_side', width: '10rem', visibility: true},
                    {text: 'Bone Side', value: 'bone_side', width: '4rem', visibility: false},
                    {text: 'Updated At', value: 'updated_at', width: '6rem', visibility: true},
                ],
                headers_dnas: [
                    {text: 'Key', value: 'key', width: '10rem', visibility: false},
                    {text: 'Key Bone Side', value: 'key_bone_side', width: '10rem', visibility: true},
                    {text: 'Mito Seq No', value: 'mito_sequence_number', width: '4rem', visibility: true},
                    {text: 'Updated At', value: 'updated_at', width: '6rem', visibility: true},
                ],
            }
        },
        mounted() {
            this.getUserActivity("specimen");
            this.getUserActivity("dna");
        },
        methods: {
            getUserActivity: function (type) {
                this.loading = true;
                axios
                    .request({
                        url: '/api/dashboard/projects/activity?by=' + type + '&top=10&forUser=true',
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        }
                    })
                    .then(response=>{
                        // For debugging purposes
                        console.log("data: " + JSON.stringify(response.data));
                        this.initializeRows(type, response.data.data);
                        this.loading = false;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },

            initializeRows(type, data) {
                console.log("type: " + type + " and data.data: " + JSON.stringify(data));
                this.loading = true;
                if (type === "specimen" && data) {
                    data.map(item => {
                        this.items_specimens.push(
                            {
                                id: item.id,
                                key: item.accession_number + (item.provenance1 ? ':' + item.provenance1 : "") +
                                    (item.provenance2 ? ':' + item.provenance2 : "") + (item.designator ? ':' + item.designator : ""),
                                bone_side: this.bones.find(obj => { return obj.id === item.sb_id }).name + " " + item.side,
                                key_bone_side: item.accession_number + (item.provenance1 ? ':' + item.provenance1 : "") +
                                    (item.provenance2 ? ':' + item.provenance2 : "") + (item.designator ? ':' + item.designator : "") + " " +
                                    this.bones.find(obj => { return obj.id === item.sb_id }).name + " " + item.side,
                                updated_at: item.updated_at,
                            })
                        }
                    )
                } else  if (type === "dna" && data) {
                    data.map(item => {
                        this.items_dnas.push(
                            {
                                id: item.id,
                                key: item.accession_number + (item.provenance1 ? ':' + item.provenance1 : "") +
                                    (item.provenance2 ? ':' + item.provenance2 : "") + (item.designator ? ':' + item.designator : ""),
                                key_bone_side: item.accession_number + (item.provenance1 ? ':' + item.provenance1 : "") +
                                    (item.provenance2 ? ':' + item.provenance2 : "") + (item.designator ? ':' + item.designator : "") + " " +
                                    this.bones.find(obj => { return obj.id === item.sb_id }).name + " " + item.side,
                                mito_sequence_number: item.mito_sequence_number,
                                updated_at: item.updated_at,
                            })
                        }
                    )
                }
            },
            columnVisibility(type) {
                if (type === "specimens") {
                    return this.headers_specimens.filter(item => item.visibility === true);
                } else {
                    return this.headers_dnas.filter(item => item.visibility === true);
                }
            },
        },
        computed: {
            ...mapState({
                perPage: state => state.search.perPage,
                rowsPerPageItems: state => state.search.rowsPerPageItems,
                bones: state => state.bones,
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