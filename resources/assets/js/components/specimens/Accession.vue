<!--Made required field and rules optional for report screens-->
<template>
    <v-autocomplete :name="name" v-model="accessionNumber" :key="accessionNumber" :class="classname"
                    :label="label" placeholder="Select Accession Number" dusk="se-accession"
                    :items="(items) ? items : items_accessions" item-text="text" item-value="value"
                    :required="required" :disabled="disabled" :rules="rules" clearable>
    </v-autocomplete>
</template>
<script>
    import {changeObjectToArray} from "../../coraBaseModules";
    import {mapGetters, mapState} from "vuex";

    export default {
        name: "Accession",
        props: {
            value: { type: String, default: '' },
            options: { type: [Object, Array], default: null },
            disabled: { type: Boolean, default: false },
            required: { type: Boolean, default: true },
            name: { type: String, default: "accession_number" },
            label: { type: String, default: "Accession Number" },
        },
        data() {
            return {
                accessionNumber: this.value,
                items: (this.options) ? changeObjectToArray(this.options) : null,
            };
        },
        watch: {
            value(val) {
                this.accessionNumber = val;
            },
            accessionNumber(val) {
                this.$emit("input", val);
            }
        },
        computed: {
            ...mapState({
                //
            }),
            ...mapGetters({
                items_accessions: 'getProjectAccessions',
            }),
            rules() {
                return (this.required) ? [() => !!this.accessionNumber || 'Accession number is required'] : [];
            },
            classname() {
                return (this.required) ? "required" : "";
            }
        },
    };
</script>

<style scoped>
    .required label::after {
        content: "*";
        color: red;
    }
</style>
