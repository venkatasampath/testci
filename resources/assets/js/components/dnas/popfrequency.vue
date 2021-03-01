<template>

        <v-text-field
                v-model.number="updatedPop"
                label="Total Count"
                placeholder="e.g.1,2,3"
                :disabled="disabledOption"
                :label="label"
        >

        </v-text-field>


</template>

<script>
    import {eventBus} from "../../eventBus";

    export default {
        name: "popfrequency",

        data: () => ({
            updatedPop: '',
            disabledOption: false,
        }),

        props: {
            popfrequency: '',
            disabled: Boolean,
            label:'',
            type:'',
        },

        beforeMount() {
            this.updatedPop = this.popfrequency;
            this.disabledOption=this.disabled;

        },
        watch: {
            'updatedPop'(){
                this.updatePop();
            }
        },
        methods: {
            updatePop() {
              switch (this.type) {
                 case "mito":
                    eventBus.$emit('UpdateMitoPop', this.updatedPop);
                    break;
                 case "ystr":
                    eventBus.$emit('UpdateYstrPop', this.updatedPop);
                    break;
              }
            }
        }
    }
</script>

<style scoped>

</style>