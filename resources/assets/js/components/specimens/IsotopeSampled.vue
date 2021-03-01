<template>
    <v-switch  id="isotope_sampled" name="isotope_sampled" v-model="isotopeSampled"
        :label="label" :value="isotopeSampled" :disabled="disabled" dusk="se-isotope_sampled">
    </v-switch>
</template>

<script>
    export default {
        name: "IsotopeSampled",
        props: {
            value: [Boolean, Number],
            disabled: { type: Boolean, default: false },
            label: { type: String, default: 'Isotopes Sampled' },
        },
        data() {
            return {
                isotopeSampled: this.value
            }
        },
        watch: {
            value(val) {
                this.isotopeSampled = val;
            },
            isotopeSampled(val) {
                this.$emit("input", val);
            }
        }
    }
</script>
