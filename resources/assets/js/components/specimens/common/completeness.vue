<template>
    <v-autocomplete id="completeness" name="completeness" v-model="completeness" :key="completeness" dusk="se-completeness" :label="label" placeholder="Select Completeness"
                    :items="items" :rules="rules" :disabled="disabled" :required="required" clearable>
    </v-autocomplete>
</template>

<script>
    export default {
        name: "completeness",
        props: {
            label: { type: String, default: "Completeness" },
            value: { type: String, default: 'Complete' },
            disabled: { type: Boolean, default: false },
            required: { type: Boolean, default: true },
        },
        data() {
            return {
                completeness: this.value,
                items: ["Complete", "Incomplete"],
            };
        },
        computed: {
            rules() {
                return (this.required) ? [() => !!this.completeness || "Completeness is required"] : [];
            }
        },
        watch: {
            value(val) {
                this.completeness = val;
            },
            completeness(val) {
                this.$emit("input", val);
            }
        }
    };
</script>

<style scoped>
</style>
