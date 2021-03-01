<template>

    <v-col cols="12" md="3" sm="12" class="mt-3">
        <v-text-field
                v-model="updatedPoly"
                :label="label"
                placeholder="e.g.16069,73,263,315.1"
                @input="updatePoly"
                :disabled="disabledOption">

        </v-text-field>
    </v-col>


</template>

<script>
    import {eventBus} from "../../eventBus";

    export default {
        name: "polymorphisms",

        data: () => ({
            updatedPoly:String,
            disabledOption:false,
        }),

        props: {
            poly: '',
            label: '',
            disabled: Boolean,
        },

        beforeMount(){
          this.updatedPoly=this.poly;
          this.disabledOption=this.disabled;
        },

        methods: {
            updatePoly() {
                eventBus.$emit('UpdatePoly', this.updatedPoly)
            }
        }
    }
</script>

<style scoped>

</style>