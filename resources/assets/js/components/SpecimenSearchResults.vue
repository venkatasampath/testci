<template>
    <div class="m-2">
        <contentheader :trail="this.trail" :title="this.heading" :help_menu="true"></contentheader>
        <v-alert class="my-1" border="left" colored-border type="info" elevation="2" dismissible>{{defaultSearchDisplay}}</v-alert>
        <v-row>
            <v-col cols="9">
                <v-btn-toggle v-model="toggle_multiple" dense multiple>
                    <v-btn dusk="excel">Excel</v-btn>
                    <v-menu right offset-x :close-on-content-click="false" max-height="500px">
                        <template v-slot:activator="{ on }">
                            <v-btn v-on="on" dusk="column-visibility">Column Visibility<v-icon right>$dropdown</v-icon></v-btn>
                        </template>
                        <v-list>
                            <v-list-item v-for="(header, index) in headers" :key="index">
                                <v-checkbox v-bind:label="header.text" v-model="header.visibility" :value="header.visibility" :dusk="header.text"/>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </v-btn-toggle>
            </v-col>

            <v-col cols="3">
                <v-text-field v-model="search" label="Search" clearable append-icon="mdi-magnify" dusk="search-datatable"/>
            </v-col>
        </v-row>
<!--        :fixed-header="fixedHeader" height="500"-->
        <v-data-table :headers="columnVisibility" :items="items" :items-per-page="perPage" :options.sync="options" :server-items-length="totalSearchCount"
                      calculate-widths="" class="elevation-1" :sort-by="['key']" multi-sort :search="search" :loading="loading"
                      :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }">
            <template v-slot:item.key="{ item }"><a :href="`/skeletalelements/${item.se_id}`" target="_blank">{{ item.key }}</a></template>
            <template v-slot:item.individual_number="{ item }"><a :href="`/reports/individualnumberdetails/${item.individual_number}`" target="_blank">{{ item.individual_number }}</a></template>
            <template v-slot:item.sample_number="{ item }">
                <a      class="mx-1"
                        v-for="(dna, index) in item.dnas"
                        :key="index"
                        :href="`/skeletalelements/${dna.se_id}/dnas/${dna.id}`"
                        target="_blank"
                >{{ dna.sample_number }}</a></template>
            <template v-slot:item.mito_sequence_number="{ item }"><a :href="`/reports/mtdna/${item.mito_sequence_number}`" target="_blank">{{ item.mito_sequence_number }}</a></template>
            <template v-slot:item.measured="{ item }"><v-icon right :color="checkColor(item.measured)">{{ displayCheck(item.measured) }}</v-icon></template>
            <template v-slot:item.isotope_sampled="{ item }"><v-icon right :color="checkColor(item.isotope_sampled)">{{ displayCheck(item.isotope_sampled) }}</v-icon></template>
            <template v-slot:item.clavicle_triage="{ item }"><v-icon right :color="checkColor(item.clavicle_triage)">{{ displayCheck(item.clavicle_triage) }}</v-icon></template>
            <template v-slot:item.ct_scanned="{ item }"><v-icon right :color="checkColor(item.ct_scanned)">{{ displayCheck(item.ct_scanned) }}</v-icon></template>
            <template v-slot:item.xray_scanned="{ item }"><v-icon right :color="checkColor(item.xray_scanned)">{{ displayCheck(item.xray_scanned) }}</v-icon></template>
            <template v-slot:item.inventoried="{ item }"><v-icon right :color="checkColor(item.inventoried)">{{ displayCheck(item.inventoried) }}</v-icon></template>
            <template v-slot:item.reviewed="{ item }"><v-icon right :color="checkColor(item.reviewed)">{{ displayCheck(item.reviewed) }}</v-icon></template>
            <template v-slot:item.associations="{ item }">
                <a :href="`/skeletalelements/${item.se_id}/pairs`" target="_blank">{{ item.pairs_count }}P</a>
                <a :href="`/skeletalelements/${item.se_id}/articulations`" target="_blank">{{ item.articulations_count }}A</a>
                <a :href="`/skeletalelements/${item.se_id}/refits`" target="_blank">{{ item.refits_count }}R</a>
                <a :href="`/skeletalelements/${item.se_id}/morphologys`" target="_blank">{{ item.morphologys_count }}M</a>
            </template>
            <template v-slot:item.bone_group="{ item }"><a :href="`/reports/bonegroup/${item.bone_group_id}`" target="_blank">{{ item.bone_group }}</a></template>

            <!--            <template v-slot:item.pathology="{ item }">-->
<!--                <a :href="`/skeletalelements/${item.se_id}/pathologys`" target="_blank">{{ item.pathologys_count }}P</a>-->
<!--                <a :href="`/skeletalelements/${item.se_id}/traumas`" target="_blank">{{ item.traumas_count }}T</a>-->
<!--                <a :href="`/skeletalelements/${item.se_id}/anomalys`" target="_blank">{{ item.anomalys_count }}A</a>-->
<!--            </template>-->
<!--            <template v-slot:item.methods="{ item }">-->
<!--                <a :href="`/skeletalelements/${item.se_id}/methods`" target="_blank">{{ item.methods_count }}M</a>-->
<!--            </template>-->
            <template v-slot:item.tags="{ item }">
                <v-chip v-for="(tag, index) in item.tags" :key="index" :color="tag.color">
                    <v-avatar left><v-icon>{{ tag.icon }}</v-icon></v-avatar>{{ tag.name }}
                </v-chip>
            </template>
        </v-data-table>
<!--        <v-divider></v-divider>-->
<!--        <v-data-table v-if="totalSearchCount<=250" :headers="columnVisibility" :items="items" :items-per-page="perPage" :options.sync="options"-->
<!--                      calculate-widths="" class="elevation-1" :sort-by="['key']" multi-sort :search="search" :loading="loading"-->
<!--                      :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }">-->
<!--            <template v-slot:item.key="{ item }"><a :href="`/skeletalelements/${item.se_id}`" target="_blank">{{ item.key }}</a></template>-->
<!--            <template v-slot:item.individual_number="{ item }"><a :href="`/reports/individualnumber/${item.individual_number}`" target="_blank">{{ item.individual_number }}</a></template>-->
<!--            <template v-slot:item.sample_number="{ item }"><a :href="`/skeletalelements/${item.se_id}/dnas/${item.dna_id}`" target="_blank">{{ item.sample_number }}</a></template>-->
<!--            <template v-slot:item.mito_sequence_number="{ item }"><a :href="`/reports/mtdna/`" target="_blank">{{ item.mito_sequence_number }}</a></template>-->
<!--            <template v-slot:item.measured="{ item }"><v-icon right :color="checkColor(item.measured)">{{ displayCheck(item.measured) }}</v-icon></template>-->
<!--            <template v-slot:item.isotope_sampled="{ item }"><v-icon right :color="checkColor(item.isotope_sampled)">{{ displayCheck(item.isotope_sampled) }}</v-icon></template>-->
<!--            <template v-slot:item.clavicle_triage="{ item }"><v-icon right :color="checkColor(item.clavicle_triage)">{{ displayCheck(item.clavicle_triage) }}</v-icon></template>-->
<!--            <template v-slot:item.ct_scanned="{ item }"><v-icon right :color="checkColor(item.ct_scanned)">{{ displayCheck(item.ct_scanned) }}</v-icon></template>-->
<!--            <template v-slot:item.xray_scanned="{ item }"><v-icon right :color="checkColor(item.xray_scanned)">{{ displayCheck(item.xray_scanned) }}</v-icon></template>-->
<!--            <template v-slot:item.inventoried="{ item }"><v-icon right :color="checkColor(item.inventoried)">{{ displayCheck(item.inventoried) }}</v-icon></template>-->
<!--            <template v-slot:item.reviewed="{ item }"><v-icon right :color="checkColor(item.reviewed)">{{ displayCheck(item.reviewed) }}</v-icon></template>-->
<!--        </v-data-table>-->
    </div>
</template>

<script>
    import {mapState, mapGetters, mapActions} from 'vuex';
    import axios from 'axios';

    export default {
        name: "SpecimenSearchResults",
        props: {
            heading: { type: String, default: "" },
            // fixedHeader: { type: Boolean, default: true },
        },
        data: () => {
            return {
                searchResults: null,
                items: [],
                options: {},
                search: "",
                toggle_multiple: [],
                loading: false,
                totalSearchCount: 0,
                headers: [
                    {text: 'Key', value: 'key', width: '10rem', visibility: true},
                    {text: 'Bone', value: 'skeletalbone', width: '6rem', visibility: true},
                    {text: 'Side', value: 'side', width: '6rem', visibility: true},
                    {text: 'Bone Group', value: 'bone_group', width: '6rem', visibility: true},
                    {text: 'Individual Number', value: 'individual_number', width: '10rem', visibility: true},
                    {text: 'DNA Sample Number', value: 'sample_number', width: '6rem', visibility: true},
                    {text: 'Mito Sequence Number', value: 'mito_sequence_number', width: '6rem', visibility: true},
                    {text: 'Associations', value: 'associations', width: '6rem', visibility: true},
                    {text: 'Pathology', value: 'pathology', width: '6rem', visibility: true},
                    {text: 'Methods', value: 'methods', width: '6rem', visibility: true},
                    {text: 'Tags', value: 'tags', width: '6rem', visibility: false},
                    {text: 'Measured', value: 'measured', width: '6rem', visibility: true},
                    {text: 'Isotope Sampled', value: 'isotope_sampled', width: '6rem', visibility: true},
                    {text: 'Clavicle Triage', value: 'clavicle_triage', width: '6rem', visibility: true},
                    {text: 'CT Scanned', value: 'ct_scanned', width: '6rem', visibility: false},
                    {text: 'Xray Scanned', value: 'xray_scanned', width: '6rem', visibility: false},
                    {text: 'Inventoried', value: 'inventoried', width: '6rem', visibility: false},
                    {text: 'Reviewed', value: 'reviewed', width: '6rem', visibility: false},
                    {text: 'Inventoried By', value: 'inventoried_by', width: '6rem', visibility: false},
                    {text: 'Inventoried At', value: 'inventoried_at', width: '6rem', visibility: false},
                    {text: 'Reviewed By', value: 'reviewed_by', width: '6rem', visibility: false},
                    {text: 'Reviewed At', value: 'reviewed_at', width: '6rem', visibility: false},
                    {text: 'Created By', value: 'created_by', width: '6rem', visibility: false},
                    {text: 'Created At', value: 'created_at', width: '6rem', visibility: false},
                    {text: 'Updated By', value: 'updated_by', width: '6rem', visibility: false},
                    {text: 'Updated At', value: 'updated_at', width: '6rem', visibility: false},
                ],
                trail: [{ text: 'Home', disabled: false, href: '/', },
                        { text: 'Search', disabled: true, href: '/skeletalelements/search', },
                ],

                // --- not used should be deleted
                pagination: {
                    descending: true,
                    page: 1,
                    rowsPerPage: 10,
                    sortBy: "id",
                    totalItems: 0
                },
            }
        },
        watch: {
            options: {
                handler () {
                    this.loadGeneral();
                },
                deep: true,
            },
        },
        created() {
            // this.loadGeneral();
        },
        methods: {
            loadGeneral: function() {
                this.loading = true;
                console.log("options: " + JSON.stringify(this.options));
                let url = '/api/projects/' + this.theProject.id + '/specimens/search?searchby=' + this.defaultSearchBy + '&searchstring=' + this.defaultSearchString
                    + '&page=' + this.options.page
                    + '&per_page=' + this.options.itemsPerPage;
                axios({
                    url: url,
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': this.$store.getters.bearerToken,
                    }
                })
                    .then(response => {
                        this.searchResults = response.data.data;
                        this.totalSearchCount = response.data.meta.total;
                        // For debugging purposes
                        console.log("meta: " + JSON.stringify(response.data.meta));
                        console.log("links: " + JSON.stringify(response.data.links));
                        this.initializeRows();
                        this.loading = false;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            initializeRows() {
                this.items = [];
                this.searchResults.map(item =>
                    this.items.push(
                    {
                        se_id: item.id,
                        key: item.key,
                        skeletalbone: item.skeletalbone.name,
                        side: item.side,
                        bone_group: item.bone_group,
                        bone_group_id: item.bone_group_id,
                        individual_number: item.individual_number,
                        dna_id: (item.dnas[0]) ? (item.dnas[0]).id : null,
                        dnas: (item.dnas) ,
                        mito_sequence_number: (item.dnas[0]) ? (item.dnas[0]).mito_sequence_number : null,
                        measured: item.measured,
                        isotope_sampled: item.isotope_sampled,
                        clavicle_triage: item.clavicle_triage,
                        ct_scanned: item.ct_scanned,
                        xray_scanned: item.xray_scanned,
                        inventoried: item.inventoried,
                        reviewed: item.reviewed,
                        pairs_count: item.pairs_count,
                        articulations_count: item.articulations_count,
                        refits_count: item.refits_count,
                        morphologys_count: item.morphologys_count,
                        methods_count: item.methods_count,
                        pathologys_count: item.pathologys_count,
                        traumas_count: item.traumas_count,
                        anomalys_count: item.anomalys_count,
                        tags: item.tags,
                        inventoried_by: item.inventoried_by,
                        inventoried_at: item.inventoried_at,
                        reviewed_by: item.reviewed_by,
                        reviewed_at: item.reviewed_at,
                        created_by: item.created_by,
                        created_at: item.created_at,
                        updated_by: item.updated_by,
                        updated_at: item.updated_at,
                    })
                );
            },
            displayCheck(item) {
                return item === true ? '✔' : ''
            },
            checkColor(item) {
                return item === true ? 'success' : ''
            }
        },
        computed: {
            ...mapState({
                perPage: state => state.search.perPage,
                rowsPerPageItems: state => state.search.rowsPerPageItems,
            }),
            ...mapGetters({
                bearerToken: 'bearerToken',
                theProject: 'theProject',
                defaultSearchOption: 'defaultSearchOption',
                defaultSearchFor: 'defaultSearchFor',
                defaultSearchBy: 'defaultSearchBy',
                defaultSearchString: 'defaultSearchString',
                defaultSearchName: 'defaultSearchName',
                defaultSearchDisplay: 'defaultSearchDisplay',
            }),

            columnVisibility(){
                return this.headers.filter(item => item.visibility === true);
            },
        },
    }
</script>
