<template>
    <div class="m-2">
        <contentheader :title="this.heading" :help_menu="true" :trail="(action.create) ? trail.create : trail.default" model_name="dnas"
                       :crud_action="action" :specimen="(action.list) ? specimen : null" @eventNew="this.newDna">
        </contentheader>
        <specimen-highlights :specimen="specimen"></specimen-highlights>
        <div>
            <v-row>
                <v-col cols="9">
                    <v-btn-toggle v-model="toggle_multiple" dense multiple>
                        <v-btn>Excel</v-btn>
                        <v-btn>PDF</v-btn>
                        <v-menu right offset-x :close-on-content-click="false" max-height="500px">
                            <template v-slot:activator="{ on }">
                                <v-btn v-on="on">Column Visibility<v-icon right>$dropdown</v-icon></v-btn>
                            </template>
                            <v-list>
                                <v-list-item v-for="(header, index) in headers" :key="index">
                                    <v-checkbox v-bind:label="header.text" v-model="header.visibility" :value="header.visibility"></v-checkbox>
                                </v-list-item>
                            </v-list>
                        </v-menu>
                    </v-btn-toggle>
                </v-col>
                <v-spacer></v-spacer>
                <v-col cols="3">
                    <v-text-field v-model="search" label="Search" clearable append-icon="mdi-magnify" dusk="search-datatable"></v-text-field>
                </v-col>
            </v-row>
            <v-data-table :headers="columnVisibility" :items="this.dnas" calculate-widths="" class="elevation-1" multi-sort :search="search">
                <template v-slot:item.sample_number="{ item }"><a :href="`/skeletalelements/${item.se_id}/dnas/${item.id}`" target="_blank">{{ item.sample_number }}</a></template>
                <template v-slot:item.mito_sequence_number="{ item }"><a :href="`/reports/mtdna/${item.mito_sequence_number}`" target="_blank">{{ item.mito_sequence_number }}</a></template>
            </v-data-table>
            <br>
        </div>
        <sumform
                :dna="dna_consensus"
                :show_contentHeader="false"
                :show_general_form="false"
                :show_tags="false"
                :statusoptions="statusoptions"
                :ystrhaplooptions="ystrhaplooptions"
                :ystrmethodoptions="ystrmethodoptions"
                :remainingweightsuffix="remainingweightsuffix"
                :austrmethodoptions="austrmethodoptions"
                :mitohaplooptions="mitohaplooptions"
                :mitomethodoptions="mitomethodoptions"
                :dispositionoptions="dispositionoptions"
                :conditionoptions="conditionoptions">
        </sumform>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    export default {
        name: "dnaList",
        props: {
            heading: { type: String, default: "Specimen" },
            crud_action: { type: String, default: "View" },
            specimen: { type: Object, default: null },
            dnas: { type: Array, default: null },
            austrmethodoptions: { type: Object, default: null },
            mitohaplooptions: { type: Object, default: null },
            mitomethodoptions: { type: Object, default: null },
            statusoptions: { type: Object, default: null },
            ystrhaplooptions: { type: Array, default: null },
            ystrmethodoptions: { type: Object, default: null },
            remainingweightsuffix: { type: String, default: null },
            dispositionoptions:{ type: Object, default: null },
            conditionoptions:{ type: Object, default: null },

        },
        data() {
            return {
                dna_consensus:{},
                trail: {
                    'create': [{text: 'Home', disabled: false, href: '/',},
                        {text: 'Specimen ', disabled: false, href: "/skeletalelements/"+ this.specimen.id},
                        {text: 'DNA Profile', disabled: true, href: "/"},],
                    'default': [{text: 'Home', disabled: false, href: '/',},
                        {text: 'Specimens ', disabled: true, href: "/skeletalelements/"+ this.specimen.id},
                    ],
                },
                headers: [
                    {text: 'Sample Number', value: 'sample_number', visibility: true},
                    {text: 'External Case ID', value: 'external_case_id', visibility: true},
                    {text: 'Results Status', value: 'mito_results_confidence', visibility: true},
                    {text: 'Mito Sequence Number', value: 'mito_sequence_number', visibility: true},
                    {text: 'Mito Sequence Subgroup', value: 'mito_sequence_subgroup', visibility: true},
                    {text: 'Recieve Date', value: 'mito_receive_date', visibility: true},
                    {text: 'Created At', value: 'created_at', width: '6rem', visibility: true},
                    {text: 'Updated At', value: 'updated_at', width: '6rem', visibility: true},
                ],
                toggle_multiple: [],
                showReportCriteria: true,
                search:'',
            };
        },
        created(){
            this.getDnaConsensus()
        },
        watch: {

        },
        methods: {
            newDna() {
                location.assign('/skeletalelements/'+ this.specimen.id + '/dnas/create');
            },
            getDnaConsensus(){
                let date;
                this.dnas.forEach(dna =>{
                    let setDate = new Date(dna.updated_at)? new Date(dna.updated_at): new Date(dna.created_at);
                    date = date === undefined|| date === null ? setDate : date;
                    Object.values(dna).forEach((item, index) => {
                        if (this.dna_consensus[Object.keys(dna)[index]] != null){
                            if(new Date(dna.updated_at) >= date){
                                this.dna_consensus[Object.keys(dna)[index]] = item;
                            }
                        } else{
                            this.dna_consensus[Object.keys(dna)[index]] = item;
                        }
                    });
                   date = dna.updated_at >= date? dna.updated_at: date;
                })
            }
        },
        computed: {
            columnVisibility(){
                return this.headers.filter(item => item.visibility === true);
            },
            ...mapGetters({
                bearerToken: 'bearerToken',
                theOrg: 'theOrg',
            }),
            dnaItems() {
                const rows = [];
                this.dnas.forEach(item =>
                    rows.push({
                        se_id: item.se_id,
                        dna_id: item.id,
                        sample_number: item.sample_number,
                        mito_sequence_number:item.mito_sequence_number,
                        mito_sequence_subgroup:item.mito_sequence_subgroup,
                        result_status: item.mito_results_confidence,
                        external_case_id:item.external_case_id,
                        recieve_date: item.mito_recieve_date,
                        created_at: item.created_at,
                        updated_at: item.updated_at,
                    })
                );
                return rows;
            },
            action() {
                const act = this.crud_action;
                return { create: act === "Create", view: act === "View", edit: (act === "Update" || act === "Edit"), list: act === "List", };
            },
            toolbarProps() {
                if (this.action.create || this.action.edit) {
                    return { rese: true, save: {disabled: !this.edited} };
                } else if (this.action.view) {
                    return { edit: true };
                } else {
                    return {};
                }
            },
        }
    }
</script>

<style scoped>

</style>