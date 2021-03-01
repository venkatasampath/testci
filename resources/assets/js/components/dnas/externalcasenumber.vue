<template>
    <v-col cols="12" md="3" sm="12" class="mt-3">
    <v-text-field
            v-model="updatedCaseNumber"
            :rules="rules"
            name="external_case_id"
            label="External Case Number"
            placeholder="Example 2004H0114, 20015G1022"
            @input="updateCaseNumber"
            :disabled="disabledOption"
            >

    </v-text-field>
    </v-col>
</template>

<script>
    import {eventBus} from "../../eventBus";

    export default {
        name: "externalcasenumber",

        data:() => ({
            updatedCaseNumber:'',
            disabledOption:false,
        }),

        props: {
            externalcasenumber: String,
            rules: null,
            disabled:Boolean,
        },

        beforeMount(){
          this.updatedCaseNumber=this.externalcasenumber;
          this.disabledOption=this.disabled;
        },

        methods:{
            updateCaseNumber(){
                eventBus.$emit('UpdateCaseNum',this.updatedCaseNumber)
            }
        }
    }
</script>

<style scoped>

</style>