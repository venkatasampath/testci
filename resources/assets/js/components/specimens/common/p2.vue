<template>
    <v-combobox v-model="provenance2" :search-input.sync="search" :label="label" dusk="se-provenance2"
                :items="items" item-text="text" item-value="value" :disabled="disabled" placeholder="Select Provenance2" clearable>
        <template v-slot:no-data>
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title>No results matching "<strong>{{ search }}</strong>". Press <kbd>enter</kbd> to create a new one</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </template>
    </v-combobox>
<!--    <v-autocomplete :name="name" v-model="provenance2" :key="provenance2" dusk="se-provenance2" :label="label" placeholder="Select Provenance 2"-->
<!--                    :items="items" item-text="text" item-value="value" :disabled="disabled" clearable>-->
<!--    </v-autocomplete>-->
</template>
<script>
    import {mapGetters, mapState} from "vuex";

    export default {
        name: "provenance2",
        props: {
            value: { type: String, default: '' },
            disabled: { type: Boolean, default: false },
            name: { type: String, default: 'provenance2' },
            label: { type: String, default: 'Provenance2' },
        },
        data() {
            return {
                provenance2: this.value,
                search: null,
            };
        },
        created() {
            //
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
            ...mapGetters({
                items: 'getProjectProvenance2',
            }),
        },
    }
</script>
<style scoped>
</style>
