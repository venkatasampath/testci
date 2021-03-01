<template>

        <v-text-field
                v-model.number="updatedCount"
                :label="label"
                placeholder="e.g.0,1,2"
                :disabled="disabledOption"
        >


        </v-text-field>

</template>

<script>
    import {eventBus} from "../../eventBus";

    export default {
        name: "mito-count",

        data: () => ({
            updatedCount: '',
            disabledOption: false,

        }),

        props: {
            count: '',
            disabled: Boolean,
            label:'',
            type:'',
        },

        beforeMount() {
            this.updatedCount = this.count;
            this.disabledOption=this.disabled;
        },
            watch: {
              'updatedCount'(){
                this.updateCount();
              }
            },

        methods: {
            updateCount() {
                    switch (this.type) {
                            case "mito":
                                    eventBus.$emit('UpdateMitoCount', this.updatedCount);
                                    break;
                            case "ystr":
                                    eventBus.$emit('UpdateYstrCount', this.updatedCount);
                                    break;
                    }
            }
        }
    }
</script>

<style scoped>

</style>