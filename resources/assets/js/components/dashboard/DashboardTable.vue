<template>
    <div>
        <v-btn color="primary" dark @click="dialogBox = true; getTableData();">
            View Details
        </v-btn>
        <v-card>
            <fullscreenpopup
                    :visible="dialogBox" @close="dialogBox=false" action="viewDrillDowns"
            >

                <v-toolbar dark color="primary">
                    <v-btn icon dark @click="dialogBox = false">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                    <v-toolbar-title>{{drilldowntitle}}</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <div class="text-center">
                <v-card flat align="center">
                    <slot></slot>
                </v-card>
                </div>
                <v-row>
                    <v-col cols="9">
                        <v-btn-toggle
                                v-model="toggle_multiple"
                                dense
                                dark
                                multiple>
                            <v-btn>Excel</v-btn>

                            <v-btn>PDF</v-btn>
                            <v-menu
                                    right
                                    offset-x
                                    :close-on-content-click="false"
                                    max-height="500px"
                            >
                                <template v-slot:activator="{ on }">
                                    <v-btn v-on="on">Column Visibility
                                        <v-icon right>$dropdown</v-icon>
                                    </v-btn>
                                </template>

                                <v-list>
                                    <v-list-item v-for="(header, index) in headers" :key="index">
                                        <v-checkbox
                                                v-bind:label="header.text"
                                                v-model="header.visibility"
                                                :value="header.visibility"
                                        >
                                        </v-checkbox>
                                    </v-list-item>
                                </v-list>

                            </v-menu>
                        </v-btn-toggle>
                    </v-col>

                    <v-spacer></v-spacer>

                    <v-col cols="3">
                        <v-text-field
                                v-model="search"
                                label="Search"
                                single-line
                                hide-details
                        ></v-text-field>
                    </v-col>
                </v-row>
                <div>
                    <v-data-table
                            :headers="columnVisibility"
                            :items="dashboarditems"
                            class="elevation-1"
                            :loading="isLoading"
                            :search="search"
                    >
                        <template v-slot:item.key="{ item }">
                        <a :href="`/skeletalelements/${item.id}`" target="_blank">{{ item.key }}</a>
                        </template>

                        <template v-slot:item.bone_group="{ item }">
                            <a :href="`/reports/bonegroup/${item.bone_group_id}`" target="_blank">{{ item.bone_group }}</a>
                        </template>

                        <template v-slot:item.measured="{ item }">
                            <v-icon right :color= "getIconColor(item.measured)">{{ getBooleanIcon(item.measured) }}</v-icon>
                        </template>

                        <template v-slot:item.dna_sampled="{ item }">
                            <v-icon right :color= "getIconColor(item.dna_sampled)">{{ getBooleanIcon(item.dna_sampled) }}</v-icon>
                        </template>

                        <template v-slot:item.ct_scanned="{ item }">
                            <v-icon right :color= "getIconColor(item.ct_scanned)">{{ getBooleanIcon(item.ct_scanned) }}</v-icon>
                        </template>

                        <template v-slot:item.xray_scanned="{ item }">
                            <v-icon right :color= "getIconColor(item.xray_scanned)">{{ getBooleanIcon(item.xray_scanned) }}</v-icon>
                        </template>

                        <template v-slot:item.clavicle_triage="{ item }">
                            <v-icon right :color= "getIconColor(item.clavicle_triage)">{{ getBooleanIcon(item.clavicle_triage) }}</v-icon>
                        </template>

                        <template v-slot:item.inventoried="{ item }">
                            <v-icon right :color= "getIconColor(item.inventoried)">{{ getBooleanIcon(item.inventoried) }}</v-icon>
                        </template>

                        <template v-slot:item.reviewed="{ item }">
                            <v-icon right :color= "getIconColor(item.reviewed)">{{ getBooleanIcon(item.reviewed) }}</v-icon>
                        </template>

                        <template v-slot:item.isotope_sampled="{ item }">
                            <v-icon right :color= "getIconColor(item.isotope_sampled)">{{ getBooleanIcon(item.isotope_sampled) }}</v-icon>
                        </template>

                    </v-data-table>
                </div>
            </fullscreenpopup>
        </v-card>
    </div>
</template>

<script>
    import axios from "axios";
    import barchart from "./widgets/chartjs/barchart";
    import piechart from "./widgets/chartjs/piechart";
    import Loading from "vue-loading-overlay";
    import {mapGetters, mapState} from "vuex";

    export default {
        components: {
            'bar-chart': barchart,
            'pie-chart': piechart,
        },
        name: "dashbaordTable",
        props: {
            reporturl: String,
            drilldowntitle: String,
            headers: Array,
        },
        data() {
            return {
                search: '',
                isLoading: true,
                dashboarditems: [],
                dialogBox: false,
                toggle_multiple: [],
                tableHeaders: this.headers ? this.headers: [],
            }
        },
        mounted() {
        },
        methods: {
            getTableData() {
                this.isLoading = true;
                var succeed = null;
                var errored = null;
                axios
                    .request({
                        url: this.reporturl,
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        },
                    }).then(response => {
                    // this.headers = Object.keys(response.data.data[0]).map(value => ({
                    //     text: value.split('_').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' '),
                    //     value,
                    // }));
                    // console.log(this.headers);
                    this.dashboarditems = response.data.data;
                    succeed = true;
                    this.isLoading = false
                }).catch(error => {
                    errored = true
                });
            },
            getBooleanIcon(item){
                return item === true ? '✔' : ''
            },
            getIconColor(item){
                return item === true ? 'success' : ''
            }
        },
        watch: {
        },
        computed:{
            columnVisibility(){
                return this.tableHeaders.filter(item => item.visibility === true);
            },
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
        }
    }
</script>

<style>
    div.v-application--wrap {
        min-height: 0;
    }
</style>