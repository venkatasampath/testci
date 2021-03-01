<template>
    <v-col cols="12" md="3" sm="12" class="mt-3">

        <v-text-field
                v-model="updatedSeqSimilar"
                placeholder="e.g.43a,65b"
                :label="label"
                @input="updateSeqSimilar"
                :disabled="disabledOption">

        </v-text-field>
    </v-col>
</template>

<script>
    import {eventBus} from "../../eventBus";

    export default {
        name: "austr-seqsimilar",

        data: () => ({
            updatedSeqSimilar: '',
            disabledOption:false,
        }),

        props: {
            seqsimilar: String,
            label: '',
            disabled:Boolean,
            type:''
        },

        watch: {
            'updatedSeqSimilar'(){
                this.updateSeqSimilar();
            }
        },

        beforeMount() {
            this.updatedSeqSimilar = this.seqsimilar;
            this.disabledOption=this.disabled;
        },

        methods: {
            updateSeqSimilar() {
                switch (this.type) {
                    case "mito":
                        eventBus.$emit('UpdateMitoSeqSimilar', this.updatedSeqSimilar);
                        break;
                    case "austr":
                        eventBus.$emit('UpdateAustrSeqSimilar', this.updatedSeqSimilar);
                        break;
                    case "ystr":
                        eventBus.$emit('UpdateYstrSeqSimilar', this.updatedSeqSimilar);
                        break;
                }



            }
        }
    }
</script>

<style scoped>

</style>