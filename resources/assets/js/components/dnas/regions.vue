<template>
    <v-col cols="12" md="3" sm="12" class="mt-3">
        <v-text-field
                v-model="updatedRegion"
                label="Confirmed Regions"
                placeholder="e.g.16024-16391,35-369"
                @input="updateRegion"
                :disabled="disabledOption">

        </v-text-field>
    </v-col>

</template>

<script>
    import {eventBus} from "../../eventBus";

    export default {
        name: "regions",

        data: () => ({
            updatedRegion: String,
        }),

        props: {
            region: '',
            disabled: Boolean,
        },

        beforeMount(){
            this.updatedRegion=this.region;
            this.disabledOption=this.disabled;
        },

        methods: {
            updateRegion() {
                eventBus.$emit('UpdateRegion', this.updatedRegion);
            }
        }
    }
</script>

<style scoped>

</style>