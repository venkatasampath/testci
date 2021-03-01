<template>
    <v-col cols="12" md="3" sm="12" class="mt-3">
        <v-autocomplete
                v-model="updatedCondition"
                :items="getconditions"
                item-text="text"
                item-value="value"
                label="Sample Condition"
                required
                :rules="conditionRules"
                placeholder="Select Condition"
                @input="updateCondition"
                :disabled="disabled">
        </v-autocomplete>
    </v-col>
</template>

<script>
    import {changeObjectToArray} from "../../coraBaseModules";
    import {eventBus} from "../../eventBus";

    export default {
        name: "samplecondition",

        data: () => ({
            updatedCondition: String,
            conditionoptions: Object,
        }),

        props: {
            options: Object,
            conditionRules: '',
            selectedCondition: '',
            disabled:Boolean,

        },

        beforeMount() {
          this.updatedCondition=this.selectedCondition
        },

        methods: {
            updateCondition() {
                eventBus.$emit('UpdateCondition', this.updatedCondition)
            }

        },

        computed: {
            getconditions() {
                this.conditionoptions = this.options;
                return changeObjectToArray(this.conditionoptions);
            }
        }
    }
</script>

<style scoped>

</style>