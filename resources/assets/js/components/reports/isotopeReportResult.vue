<template>
    <div id="specimen-table">
        <v-row>
            <v-col cols="9">
                <v-btn-toggle v-model="toggle_multiple" dense dark multiple>
                    <v-btn>Excel</v-btn>
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
                            <v-list-item
                                    v-for="(header, index) in headers" :key="index">
                                <v-checkbox
                                        v-bind:label="header.text"
                                        v-model="header.visibility"
                                        :value="header.visibility" />
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </v-btn-toggle>
            </v-col>

            <v-spacer />

            <v-col cols="3">
                <v-text-field
                        v-model="search"
                        label="Search"
                        single-line
                        hide-details />
            </v-col>
        </v-row>

        <v-data-table
                :headers="columnVisibility"
                :items="data"
                :item-per-page="10"
                multi-sort
                :sort-by="['key']"
                calculate-widths=""
                class="elevation-1"
                :search="search">
            <template v-slot:item.key="{ item }">
                <a :href="`/skeletalelements/${item.se_id}`" target="_blank">{{ item.key }}</a>
            </template>
            <template v-slot:item.individual_number="{ item }">
                <a :href="encodedSpecimenURI(item)" target="_blank">{{ item.individual_number }}</a>
            </template>

<!--           <template v-slot:item.sample_number="{ item }">-->
<!--               <a :href="`/skeletalelements/${item.se_id}/dnas/${item.dna_id}`" target="_blank">{{ item.sample_number }}</a>-->
<!--           </template>-->

        </v-data-table>
    </div>
</template>

<script>
    export default {
        name: "isotopeReportResult",
        props:{
            isotopes: { type: [Array,Object], default: null}
        },

        data() {
            return {
                headers: [
                    {text: 'Key', value: 'key', visibility: true},
                    {text: 'Bone', value: 'skeletalelement', visibility: true},
                    {text: 'Side', value: 'side', visibility: true},
                    {text: 'Bone Group', value: 'bone_group', visibility: true},
                    {text: 'Individual Number', value: 'individual_number', visibility: true},
                    {text: 'Results Confidence', value: 'results_confidence', visibility: true},
                    {text: 'Sample Number', value: 'sample_number', visibility: true},
                    {text: 'Created By', value: 'created_by', visibility: false},
                    {text: 'Created At', value: 'created_at', visibility: false},
                    {text: 'Updated By', value: 'updated_by', visibility: false},
                    {text: 'Updated At', value: 'updated_at', visibility: false},
                ],
                options: [],
                search: '',
                toggle_multiple: [],
            }
        },

        computed: {
            data() {
                let rows = [];

                this.isotopes.forEach(item =>
                    rows.push({
                        se_id: item.se_id,
                        key: item.skeletalelement.key,
                        skeletalelement: item.skeletalelement.sb.name,
                        side: item.skeletalelement.side,
                        bone_group: item.skeletalelement.bone_group,
                        individual_number: item.skeletalelement.individual_number,
                        results_confidence: item.results_confidence,
                        sample_number: item.sample_number,
                        created_by: item.created_by,
                        created_at: item.created_at,
                        updated_by: item.updated_by,
                        updated_at: item.updated_at
                    })

                );
                return rows;
            },
            columnVisibility() {
                return this.headers.filter(item => item.visibility === true);
            }
        },

        methods: {

            getBooleanIcon(item) {
                return item === true ? "✔" : "";
            },
            getIconColor(item) {
                return item === true ? "success" : "";
            },
            encodedSpecimenURI(item) {
                return "/reports/individualnumber/" + encodeURI(item.individual_number);
            }
        },
    }
</script>