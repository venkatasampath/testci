<template>
    <v-col cols="12" md="3" sm="12" class="mt-3">
        <v-text-field
                v-model="updatedLoci"
                label="Loci"
                placeholder="e.g.D13S317,D7S820,AMEL"
                @input="updateLoci"
                :disabled="disabled">

        </v-text-field>
    </v-col>

</template>

<script>
    import {eventBus} from "../../eventBus";

    export default {
        name: "loci",

        data: () => ({
            updatedLoci: String,
        }),

        props: {
            loci: '',
            disabled: Boolean,
            type:''
        },

        beforeMount() {
            this.updatedLoci = this.loci
        },

        methods: {
            updateLoci() {
                switch (this.type) {
                    case "austr":
                        eventBus.$emit('UpdateAustrLoci',this.updatedLoci);
                        break;
                    case "ystr":
                        eventBus.$emit('UpdateYstrLoci', this.updatedLoci);
                        break;
                }


            }
        }
    }
</script>

<style scoped>

</style>