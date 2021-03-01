<template>
    <v-autocomplete v-model="sb_id" :key="sb_id" :label="label" placeholder="Select Bone" dusk="se-bone"
                    :items="items" item-text="name" item-value="id" clearable
                    :required="required" :rules="rules" :disabled="disabled">
    </v-autocomplete>
</template>
<script>
    import {mapGetters, mapState} from "vuex";

    export default {
        name: "bone",
        props: {
            value: { type: [Number, String], default: null },
            name: { type: String, default: "sb_id" },
            label: { type: String, default: "Bone" },
            disabled: { type: Boolean, default: false },
            required: { type: Boolean, default: true },
        },
        data() {
            return {
                sb_id: this.value,
            };
        },
        watch: {
            value(val) {
                this.sb_id = val;
            },
            sb_id(val) {
                this.$emit("input", val);
            }
        },
        computed: {
            ...mapState({
                //
            }),
            ...mapGetters({
                items: 'getBones',
            }),
            rules() {
                return (this.required) ? [() => !!this.sb_id || 'Bone is required'] : [];
            }
        },
    };
</script>
<style scoped>
</style>
