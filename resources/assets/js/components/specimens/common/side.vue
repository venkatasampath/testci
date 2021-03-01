<template>
    <v-autocomplete :name="name" v-model="side" :key="side" placeholder="Select Side" :label="label"
                    :items="items" :rules="rules" :disabled="disabled" :required="required" clearable>
    </v-autocomplete>
</template>
<script>
    export default {
        name: "side",
        props: {
            value: [Number, String],
            name: { type: String, default: "side" },
            label: { type: String, default: "Side" },
            disabled: { type: Boolean, default: false },
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
