<template>
    <v-col cols="12" md="3" sm="12" class="mt-3">
        <v-autocomplete
                v-model="updatedDisposition"
                :items="getdispositions"
                item-text="text"
                item-value="value"
                label="Disposition"
                placeholder="Select Disposition"
                :disabled="disabled">
        </v-autocomplete>
    </v-col>

</template>

<script>
    import {changeObjectToArray} from "../../coraBaseModules";
    import {eventBus} from "../../eventBus";

    export default {
        name: "disposition",

        data: () => ({
            updatedDisposition: String,
            dispositionoptions:Object,

        }),

        props: {
            options: Object,
            selectedDisposition: String,
            disabled:Boolean,
        },
        beforeMount() {
          this.updatedDisposition=this.selectedDisposition
        },
        watch: {
            'updatedDisposition'(){
                this.updateDisposition();
            }
        },
        methods: {
            updateDisposition() {
                eventBus.$emit('UpdateDisposition', this.updatedDisposition);
            }
        },
        computed: {
            getdispositions() {
                this.dispositionoptions = this.options;
                return changeObjectToArray(this.dispositionoptions);
            }
        }
    }
</script>

<style scoped>

</style>