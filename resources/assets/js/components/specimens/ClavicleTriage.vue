<template>
    <v-switch id="clavicle_triage" name="clavicle_triage" v-model="clavicle_triage"
              :label="label" :value="clavicle_triage" :disabled="disabled" dusk="se-clavicle_triage">
    </v-switch>
</template>

<script>
    export default {
        name: "ClavicleTriage",
        props: {
            value: { type: Boolean, default: false },
            disabled: { type: Boolean, default: false },
            label: { type: String, default: 'Clavicle Triage' },
        },
        data() {
            return {
                clavicle_triage: this.value,
            };
        },
        watch: {
            value(val) {
                this.clavicle_triage = val;
            },
            clavicle_triage(val) {
                this.$emit("input", val);
            }
        }
    }
</script>
