<template>
    <v-autocomplete :name="name" v-model="provenance2" :key="provenance2"
                    :label="label" placeholder="Select Provenance 2" dusk="se-provenance2"
                    :items="(items) ? items : items_provenance2" item-text="text" item-value="value"
                    :disabled="disabled" clearable>
    </v-autocomplete>
</template>
<script>
    import { changeObjectToArray } from "../../coraBaseModules";
    import {mapGetters, mapState} from "vuex";

    export default {
        name: "Provenance2",
        props: {
            value: { type: String, default: '' },
            options: { type: [Object, Array], default: null },
            disabled: { type: Boolean, default: false },
            name: { type: String, default: 'provenance2' },
            label: { type: String, default: 'Provenance2'},
        },
        data() {
            return {
                provenance2: this.value,
                items: (this.options) ? changeObjectToArray(this.options) : null,
            };
        },
        watch: {
            value(val) {
                this.provenance2 = val;
            },
            provenance2(val) {
                this.$emit("input", val);
            }
        },
        computed: {
            ...mapState({
                //
            }),
            ...mapGetters({
                items_provenance2: 'getProjectProvenance2',
            }),
        },
    }
</script>
<style scoped>
</style>
