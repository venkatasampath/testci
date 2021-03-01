<template>
    <v-col cols="12" md="3" sm="12" class="mt-3">
        <v-text-field
                v-model="updatedBasePairs"
                label="Base Pairs"
                placeholder="e.g.611,704,1107"
                @input="updateBasepairs"
                :disabled="disabledOption"
        >

        </v-text-field>
    </v-col>
</template>

<script>
    import {eventBus} from "../../eventBus";
    export default {
        name: "basepairs",

        data:()=>({
            updatedBasePairs:String,
        }),

        props: {
            basepairs: '',
            disabled: Boolean

        },

        beforeMount(){
          this.updatedBasePairs=this.basepairs;
            this.disabledOption=this.disabled;
        },

        methods:{
            updateBasepairs(){
                eventBus.$emit('UpdateBasepairs',this.updatedBasePairs);
            }
        }
    }
</script>

<style scoped>

</style>