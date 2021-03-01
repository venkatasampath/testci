<template>
    <v-switch id="measured" name="measured" v-model="measured"
        :label="label" :value="measured" :disabled="disabled" dusk="se-measured">
    </v-switch>
</template>

<script>
    export default {
        name: "Measured",
        props: {
            value: { type: Boolean, default: false },
            disabled: { type: Boolean, default: false },
            label: { type: String, default: 'Measured' },
        },
        data() {
            return {
                measured: this.value
            }
        },
        watch: {
            value(val) {
                this.measured = val;
            },
            measured(val) {
                this.$emit("input", val);
            }
        }
    }
</script>