<template>

    <v-col cols="12" md="3" sm="12" class="mt-3">

        <v-text-field
                v-model="updatedSubgroup"
                placeholder="e.g.42a,64b"
                :label="label"
                :disabled="disabledOption">

        </v-text-field>
    </v-col>

</template>

<script>
    import {eventBus} from "../../eventBus";

    export default {
        name: "seqsubgroup",

        data: () => ({
            updatedSubgroup: '',
            disabledOption: false,
        }),

        props: {
            subgroup: String,
            label: '',
            disabled: Boolean,
            type:'',
        },

        beforeMount() {
            this.updatedSubgroup = this.subgroup;
            this.disabledOption=this.disabled;
        },

        watch: {
            'updatedSubgroup'(){
                this.updateSubgroup();
            }
        },

        methods: {
            updateSubgroup() {
                switch (this.type) {
                    case "austr":
                        eventBus.$emit('UpdateAustrSubgroup', this.updatedSubgroup);
                        break;
                    case "mito":
                        eventBus.$emit('UpdateMitoSubgroup', this.updatedSubgroup);
                        break;
                    case "ystr":
                        eventBus.$emit('UpdateYstrSubgroup', this.updatedSubgroup);
                        break;
                }

            }
        }

    }
</script>

<style scoped>

</style>