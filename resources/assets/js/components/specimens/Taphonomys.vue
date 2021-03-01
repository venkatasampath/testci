<template>
    <div>
        <v-autocomplete v-model="Taphonomy" :placeholder="placeholdervalues"
                        :items="objects" item-name="text" item-value="value"
                        :disabled="disabled" :readonly="disabled" dense chips multiple>
        </v-autocomplete>
    </div>
</template>

<script>
    export default {
        name: 'taphonomys',
        props: {
            name: { type: String, default: "" },
            id: { type: String, default: "" },
            disabled: { type: Boolean, default: false },
            disable: { type: Boolean, default: false },
            placeholdervalues: { type: String, default: 'Taphonomy' },
            list_taphonomy: [],
            init_value: [Array, Object],
            objects: [Array, Object]
        },
        data: () => ({
            Taphonomy: [],
            isEditing: false,
            list_items: [],
        }),
        methods: {},
        mounted() {
            if (this.init_value && this.init_value !== null) {
                this.Taphonomy = this.init_value;
            }
        },
        computed: {},
        watch: {
            Taphonomy() {
                this.$emit('taphonomyinput', this.Taphonomy);
            }
        }
    }
</script>
