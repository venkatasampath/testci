<template>
    <div id="specimen-table">
        <v-row>
            <v-col cols="9">
                <v-btn-toggle v-model="toggleMultiple" dense dark multiple>
                    <v-btn>Excel</v-btn>
                    <v-menu
                            right
                            offset-x
                            :close-on-content-click="false"
                            max-height="500px">
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

            <template v-slot:item.dna_sampled="{ item }">
                <template v-if="item.dna_sampled">
                    <a
                            v-for="(dna, index) in item.dnas"
                            :key="index"
                            :href="`/skeletalelements/${item.se_id}/dnas/${dna.id}`"
                            target="_blank"
                    >{{ dna.sample_number }}
                        <br /></a>
                </template>
            </template>

            <template v-slot:item.individual_number="{ item }">
                <a :href="encodedSpecimenURI(item)" target="_blank">{{ item.individual_number }}</a>
            </template>

            <template v-slot:item.isotope_sampled="{ item }">
                <v-icon
                        right
                        :color="getIconColor(item.isotope_sampled)"
                        small
                >{{ getBooleanIcon(item.isotope_sampled) }}</v-icon>
            </template>
        </v-data-table>
    </div>
</template>

<script>
    export default {
        name: "MethodsReportResult",
        props:{
            skeletalElements: {
                type: [Array, Object],
                default: () => []
            }
        },

        data() {
            return {
                headers: [
                    {text: 'Key', value: 'key', visibility: true},
                    {text: 'Bone', value: 'bone', visibility: true},
                    {text: 'Side', value: 'side', visibility: true},
                    {
                        text: "Individual Number",
                        value: "individual_number",
                        visibility: true
                    },
                    { text: "DNA Sampled", value: "dna_sampled", visibility: true },
                    {
                        text: "Mito Sequence Number",
                        value: "mito_sequence_number",
                        visibility: true
                    },
                    { text: "Isotope Sampled", value: "isotope_sampled", visibility: true },
                    {text: 'Method', value: 'method', visibility: true},
                    {text: 'Method Feature', value: 'method_feature', visibility: true},
                    {text: 'Score', value: 'score', visibility: true},
                ],
                search: '',
                toggleMultiple: [],
            }
        },

        computed: {
            data() {
                const rows = [];
                Object.values(this.skeletalElements).forEach(item =>
                    rows.push({
                        se_id:item.id,
                        key: this.getKey(item),
                        bone: item.skeletalbone ? item.skeletalbone.name : null,
                        side: item.side,
                        individual_number: item.individual_number,
                        dna_sampled: item.dna_sampled ? item.dna_sampled : false,
                        dnas: item.dnas,
                        mito_sequence_number: item.mito_sequence_number,
                        isotope_sampled: item.isotope_sampled,
                        method: this.getMethod(item),
                        method_feature: this.getMethodFeature(item),
                        score: item.score,
                    })
                );

                return rows;
            },
            columnVisibility() {
                return this.headers.filter(item => item.visibility === true);
            },
        },

        methods: {
            getKey(item) {
                return `${item.accession_number ? item.accession_number : ''}:${item.provenance1 ? item.provenance1 : ''}:${item.provenance2 ? item.provenance2 : ''}:${item.designator ? item.designator : ''}`;
            },
            getMethod(item) {
                for(var i=0;i<item.methods.length;i++){
                    if (item.method_id == item.methods[i].id)
                        return item.methods[i].name;
                }
            },
            getMethodFeature(item) {
                for(var i=0;i<item.methodfeatures.length;i++){
                    if (item.method_feature_id == item.methodfeatures[i].id)
                        return item.methodfeatures[i].display_name;
                }
            },
            getBooleanIcon(item) {
                return item === true ? "✔" : "";
            },
            getIconColor(item) {
                return item === true ? "success" : "";
            },
            encodedSpecimenURI(item) {
                return "/reports/individualnumber/" + encodeURI(item.individual_number);
            }
        }
    }
</script>

<style scoped>

</style>