<!--Made required field and rules optional for report screens also fetching the data from the props-->
<template>
        <v-autocomplete :name="name" v-model="side" :key="side"
                        :items="items" placeholder="Select Side" :label="label"
                        :required="required" :rules="rules" :disabled="disabled" dusk="se-side" clearable>
        </v-autocomplete>
</template>
<script>
    export default {
        name: "Side",
        props: {
            value: [Number, String],
            disabled: { type: Boolean, default: false },
            name: { type: String, default: "side" },
            label: { type: String, default: "Side" },
            required: { type: Boolean, default: true },
        },
        data() {
            return {
                side: this.value,
                items: ["Left", "Right", "Middle", "Unsided"],
            };
        },
        computed: {
            rules() {
                return (this.required) ? [() => !!this.side || "Side is required"] : [];
            }
        },
        watch: {
            value(val) {
                this.side = val;
            },
            side(val) {
                this.$emit("input", val);
            }
        },
    };
</script>
