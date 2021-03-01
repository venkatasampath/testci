<template>
    <v-col cols="12" md="3" sm="12" class="mt-3">
        <v-text-field
                v-model.number="updatedLociNum"
                label="Number of Loci"
                :disabled="disabledOption"
                placeholder="e.g.9,24"
                @input="updateLociNum">

        </v-text-field>
    </v-col>
</template>

<script>
    import {eventBus} from "../../eventBus";

    export default {
        name: "NumofLoci",

        data: () => ({
            updatedLociNum: Number,
            disabledOption:false,
        }),

        props: {
            locinum: '',
            disabled:Boolean,
            type:''
        },

        beforeMount() {
          this.updatedLociNum=this.locinum;
          this.disabledOption=this.disabled;
        },

        methods: {
            updateLociNum() {
                switch (this.type) {
                    case "austr":
                        eventBus.$emit('UpdateAustrLociNum', this.updatedLociNum);
                        break;
                    case "ystr":
                        eventBus.$emit('UpdateYstrLociNum', this.updatedLociNum);
                        break;
                }

            }
        }
    }
</script>

<style scoped>

</style>