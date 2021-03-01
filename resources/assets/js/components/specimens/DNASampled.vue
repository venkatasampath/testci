<template>
    <v-switch id="dna_sampled" name="dna_sampled" v-model="dnaSampled"
        :label="label" :value="dnaSampled" :disabled="disabled" dusk="se-dna_sampled">
    </v-switch>
</template>

<script>
    export default {
        name: "DNASampled",
        props: {
            value: { type: Boolean, default: false },
            disabled: { type: Boolean, default: false },
            label: { type: String, default: 'DNA Sampled' },
        },
        data(){
            return {
                dnaSampled: this.value,
            }
        },
        watch: {
            value(val) {
                this.dnaSampled = val;
            },
            dnaSampled(val) {
                this.$emit("input", val);
            }
        }
    }
</script>
