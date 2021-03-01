<template>
    <v-autocomplete :name="name" v-model="provenance1" :key="provenance1"
                    :label="label" placeholder="Select Provenance 1" dusk="se-provenance1"
                    :items="(items) ? items : items_provenance1" item-text="text" item-value="value"
                    :disabled="disabled" clearable>
    </v-autocomplete>
</template>
<script>
    import {changeObjectToArray} from "../../coraBaseModules";
    import {mapGetters, mapState} from "vuex";

    export default {
        name: "Provenance1",
        props: {
            value: { type: String, default: '' },
            options: { type: [Object, Array], default: null },
            disabled: { type: Boolean, default: false },
            name: { type: String, default: 'provenance1' },
            label: { type: String, default: 'Provenance1' },
        },
        data() {
            return {
                provenance1: this.value,
                items: (this.options) ? changeObjectToArray(this.options) : null,
            };
        },
        watch: {
            value(val) {
                this.provenance1 = val;
            },
            provenance1(val) {
                this.$emit("input", val);
            }
        },
        computed: {
            ...mapState({
                //
            }),
            ...mapGetters({
                items_provenance1: 'getProjectProvenance1',
            }),
        },
    }
</script>
<style scoped>
</style>
