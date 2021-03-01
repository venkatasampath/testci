<template>
    <v-text-field :name="name" v-model="designator" :class="(required) ? 'required':''"
                  :label="label" placeholder="Designator: e.g., 403, 709" dusk="se-designator"
                  :required="required" :disabled="disabled" :rules="rules" clearable>
    </v-text-field>
</template>
<script>
    export default {
        name: "Designator",
        props: {
            value: { type: String, default: "" },
            disabled: { type: Boolean, default: false },
            name: { type: String, default: "designator" },
            label: { type: String, default: "Designator" },
            required: { type: Boolean, default: true },
        },
        data() {
            return {
                designator: this.value
            };
        },
        computed: {
            rules() {
                return (this.required) ? [() => !!this.designator || "Designator is required"] : [];
            }
        },
        watch: {
            value(val) {
                this.designator = val;
            },
            designator(val) {
                this.$emit("input", val);
            }
        }
    };
</script>
<style scoped>
    .required label::after {
        content: "*";
        color: red;
    }
</style>
