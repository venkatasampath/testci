<!--Grouped component Accession, Provenance1, Provenance2, Designator-->
<template>
    <v-row>
        <v-col cols="12" v-bind="columns">
            <accession :name="accessionModelKey" v-model="values[accessionModelKey]" :options="an" :required="false"/>
        </v-col>
        <v-col cols="12" v-bind="columns">
            <provenance1 :name="provenance1ModelKey" v-model="values[provenance1ModelKey]" :options="p1"/>
        </v-col>
        <v-col cols="12" v-bind="columns">
            <provenance2 :name="provenance2ModelKey" v-model="values[provenance2ModelKey]" :options="p2"/>
        </v-col>
        <v-col cols="12" v-bind="columns" v-if="showDesignator">
            <designator :name="designatorModelKey" v-model="values[designatorModelKey]" :options="dn"/>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: "anp1p2dn",
        props:{
            value: { type: Object, default: () => {} },
            an: { type: Object, default: () => {} },
            p1: { type: Object, default: () => {} },
            p2: { type: Object, default: () => {} },
            dn: { type: Object, default: () => {} },
            modelKeys: { type: Object, default: { an: 'accession_number', p1: 'provenance1', p2: 'provenance2', dn: 'designator' } },
            cols: { type: Object, default: () => {} },
            showDesignator: { type: Boolean, default: true },
        },
        data() {
            return {
                values: this.value
            };
        },
        computed: {
            accessionModelKey() {
                return this.modelKeys.an ? this.modelKeys.an : 'accession_number';
            },
            provenance1ModelKey() {
                return this.modelKeys.p1 ? this.modelKeys.p1 : 'provenance1';
            },
            provenance2ModelKey() {
                return this.modelKeys.p2 ? this.modelKeys.p2 : 'provenance2';
            },
            designatorModelKey() {
                return this.modelKeys.dn ? this.modelKeys.dn : 'designator';
            },
            columns() {
                const columns = {};
                const cols = this.cols ? this.cols : {};
                columns.md = cols.md ? cols.md : 3;
                if (cols.sm) columns.sm = cols.sm;
                if (cols.lg) columns.lg = cols.lg;
                return columns;
            }
        },
        watch: {
            value(val) {
                this.values = val;
            }
        }
    }
</script>
