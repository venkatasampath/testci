<template>

    <v-col cols="12" md="2" sm="12" class="mt-3">
        <v-switch
                v-model="updatedRecommended"
                :inset="inset"
                :disabled="disabled"
                label="Recommended for Resampling?"
                @input="updateRecommended">
        </v-switch>
    </v-col>

</template>

<script>
    import {eventBus} from "../../eventBus";

    export default {
        name: "resamplingoption",

        data: () => ({
            updatedRecommended: false,
        }),

        props: {
            recommended: Boolean,
            inset: false,
            disabled: {type:Boolean, default: true}
        },

        beforeMount(){
          this.updatedRecommended=this.recommended
        },
        watch: {
            'updatedRecommended'(){
                this.updateRecommended();
            }
        },
        methods: {
            updateRecommended() {
                eventBus.$emit('UpdateResamplingIndicator', this.updatedRecommended)
            }
        }
    }
</script>

<style scoped>

</style>