<template>
    <v-container>
        <h6>User Activity Feed for Specimens</h6>
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
        name: "user-profile-activity-specimen",
        props:{
            table_data: { type: [Array, Object], default: () => [] },
        },
        data() {
            return {
                headers: [
                    {text: 'Key', align: 'left', value: 'key'},
                    {text: 'Name', value: 'name'},
                    {text: 'Side', value: 'side'},
                    {text: 'Completeness', value: 'completeness'},
                    {text: 'Updated At', value: 'updated_at'},
                ],
            }
        },
        computed: {
            items() {
                const rows = [];
                Object.values(this.table_data).forEach(item =>
                    rows.push({
                        se_id:item.id,
                        key: this.getKey(item),
                        name: item.name,
                        side: item.side,
                        completeness: item.completeness,
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