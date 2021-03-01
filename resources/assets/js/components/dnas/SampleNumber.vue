<template>
    <v-col cols="12" md="3" sm="12" class="mt-3">
        <v-text-field
                v-model="updatedsamplenum"
                name="sample_number"
                label="Sample Number"
                required
                :rules="rules"
                placeholder="Specify Sample Number"
                @input="updateSampleNum"
                disabled
                >
        </v-text-field>
    </v-col>
</template>

<script>
    import {eventBus} from "../../eventBus";

    export default {
        name: "samplenumber",

        data: () => ({
            updatedsamplenum: String,
            disabledOption: false,
            rules: [v => !!v || 'A sample number must be speficied'],
        }),

        props: {
            samplenum: '',
            disabled: Boolean,
        },

        beforeMount() {
            this.updatedsamplenum = this.samplenum;
            this.disabledOption=this.disabled;
        },

        methods: {
            updateSampleNum() {
                eventBus.$emit('updateSampleNum', this.updatedsamplenum)
            },
        },

    }
</script>

<style scoped>

</style>