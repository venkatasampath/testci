<template>
    <v-combobox v-model="provenance1" :search-input.sync="search" :label="label" dusk="se-provenance1"
                :items="items" item-text="text" item-value="value" :disabled="disabled" placeholder="Select Provenance1" clearable>
        <template v-slot:no-data>
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title>No results matching "<strong>{{ search }}</strong>". Press <kbd>enter</kbd> to create a new one</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </template>
    </v-combobox>

<!--    <v-autocomplete :name="name" v-model="provenance1" :key="provenance1" dusk="se-provenance1" :label="label" placeholder="Select Provenance 1"-->
<!--                    :items="items" item-text="text" item-value="value" :disabled="disabled" clearable>-->
<!--    </v-autocomplete>-->
</template>
<script>
    import {mapGetters, mapState} from "vuex";

    export default {
        name: "provenance1",
        props: {
            value: { type: String, default: '' },
            disabled: { type: Boolean, default: false },
            name: { type: String, default: 'provenance1' },
            label: { type: String, default: 'Provenance1' },
        },
        data() {
            return {
                provenance1: this.value,
                search: null,
            };
        },
        created() {
            //
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
            ...mapGetters({
                items: 'getProjectProvenance1',
            }),
        },
    }
</script>
<style scoped>
</style>
