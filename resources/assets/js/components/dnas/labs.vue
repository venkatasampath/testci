<template>
    <v-col cols="12" md="3" sm="12" class="mt-3">
        <v-autocomplete
                v-model="updatedLabs"
                :items="labOptions"
                label="Lab"
                placeholder="Select Lab"
                item-text="name"
                item-value="id"
                dusk="dna-lab"
                @input="updateLabs"
                clearable
                :disabled="disabled">
        </v-autocomplete>
    </v-col>
</template>

<script>
    import {eventBus} from "../../eventBus";
    import {mapGetters} from "vuex";
    export default {
        name: "labs",
        data: () => ({
            updatedLabs: '',

        }),
        props: {
            options: Object,
            selectedLab:'',
            disabled:Boolean,
        },
        beforeMount() {
            this.updatedLabs=this.selectedLab
        },
        methods: {
            updateLabs() {
                eventBus.$emit('UpdateLab', this.updatedLabs);
            }
        },
        computed: {
            ...mapGetters({
                getLabs: 'getLabs',
            }),
            labOptions() {
                let type = 'Genomics';
                return this.getLabs(type);
            },

        }
    }
</script>

<style scoped>

</style>