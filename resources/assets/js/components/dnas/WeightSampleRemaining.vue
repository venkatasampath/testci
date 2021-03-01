<template>
    <v-col cols="12" md="3" sm="12" class="mt-3">
        <v-text-field
                v-model.number="updatedWeight"
                label="Weight Sample Remaining"
                :suffix="suffix"
                placeholder="e.g.0.22,0.5"
                @input = updateWeight
                :disabled="disabled">
        </v-text-field>
    </v-col>
</template>

<script>
    import {eventBus} from "../../eventBus";

    export default {
        name: "WeightSampleRemaining",

        data:() => ({
            updatedWeight:Number,
        }),

        props: {
            weight: '',
            suffix: '',
            disabled:Boolean,
        },

        beforeMount() {
            this.updatedWeight=this.weight
        },

        methods:{
            updateWeight() {
                eventBus.$emit('UpdateWeight',this.updatedWeight);
            },
        }

    }
</script>

<style scoped>

</style>