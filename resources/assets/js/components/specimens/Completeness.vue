<template>
        <v-autocomplete id="completeness" name="completeness" v-model="completeness" :key="completeness"
                        :label="label" placeholder="Select Completeness" dusk="se-completeness" :rules="rules"
                        :items="items" :disabled="disabled" :required="required" clearable>
        </v-autocomplete>
</template>

<script>
    export default {
        name: "Completeness",
        props: {
            value: String,
            options: Object,
            disabled: { type: Boolean, default: false },
            required: { type: Boolean, default: true },
            label: { type: String, default: "Completeness" },
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
