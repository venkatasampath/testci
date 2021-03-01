<template>
    <v-combobox v-model="accession" :search-input.sync="search" :label="label" placeholder="Select Accession Number" dusk="se-accession"
                :items="items" item-text="text" item-value="value" :disabled="disabled" :rules="rules" clearable :required="required">
        <template v-slot:no-data>
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title>No results matching "<strong>{{ search }}</strong>". Press <kbd>enter</kbd> to create a new one</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </template>
    </v-combobox>

<!--    <v-autocomplete :name="name" v-model="accession" :key="accession" :label="label" placeholder="Select Accession Number" dusk="se-accession"-->
<!--                    :items="items" item-text="text" item-value="value" :disabled="disabled" :rules="rules" clearable-->
<!--                    :required="required" :class="(required) ? 'required':''">-->
<!--    </v-autocomplete>-->
</template>
<script>
    import {mapGetters, mapState} from "vuex";

    export default {
        name: "accession",
        props: {
            value: { type: String, default: '' },
            disabled: { type: Boolean, default: false },
            required: { type: Boolean, default: true },
            name: { type: String, default: "accession_number" },
            label: { type: String, default: "Accession Number" },
        },
        data() {
            return {
                accession: this.value,
                search: null,
            };
        },
        created() {
            //
        },
        watch: {
            value(val) {
                this.accession = val;
            },
            accession(val) {
                this.$emit("input", val);
            }
        },
        computed: {
            ...mapState({
                //
            }),
            ...mapGetters({
                items: 'getProjectAccessions',
            }),
            rules() {
                return (this.required) ? [() => !!this.accession || 'Accession number is required'] : [];
            },
        },
    };
</script>

<style scoped>
    .required label::after {
        content: "*";
        color: red;
    }
</style>
