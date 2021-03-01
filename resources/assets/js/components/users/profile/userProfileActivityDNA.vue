<template>
    <v-container>
        <h6>User Activity Feed for DNA</h6>
        <v-data-table :headers="headers" calculate-widths="" class="elevation-1"
                :items="items" :item-per-page="10" multi-sort :sort-by="['key']">
            <template v-slot:item.key="{ item }">
                <a :href="`/skeletalelements/${item.se_id}`" target="_blank">{{ item.key }}</a>
            </template>
        </v-data-table>
    </v-container>
</template>

<script>
    export default {
        name: "user-profile-activity-dna",
        props:{
            dna_table_data: { type: [Array, Object], default: () => [] },
        },
        data() {
            return {
                headers: [
                    {text: 'Key', value: 'key', visibility: true},
                    {text: 'Mito Sequence Number', value: 'mito_sequence_number', visibility: true},
                    {text: 'Mito Sequence Subgroup', value: 'mito_sequence_subgroup', visibility: true},
                    {text: "Updated At", value: "updated_at", visibility: true },
                ],
            }
        },
        computed: {
            items() {
                const rows = [];
                Object.values(this.dna_table_data).forEach(item =>
                    rows.push({
                        se_id:item.id,
                        key: this.getKey(item),
                        mito_sequence_number: item.mito_sequence_number,
                        mito_sequence_subgroup: item.mito_sequence_subgroup,
                        updated_at: item.updated_at,
                    })
                );

                return rows;
            },
        },
        methods: {
            getKey(item) {
                return `${item.accession_number ? item.accession_number : ''}:${item.provenance1 ? item.provenance1 : ''}:${item.provenance2 ? item.provenance2 : ''}:${item.designator ? item.designator : ''}`;
            }
        }
    }
</script>

<style scoped>

</style>