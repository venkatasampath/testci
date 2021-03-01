<template>
    <v-col :cols="colval" :md="mdvalue" :sm="smvalue" :class="textval">

        <v-text-field
                v-model="updatedSeqnum"
                :label="label"
                placeholder="e.g.1,2,3"
                :disabled="disabledOption">
        </v-text-field>
    </v-col>
</template>

<script>
    import {eventBus} from "../../eventBus";

    export default {
        name: "seqnumber",

        data: () => ({
            updatedSeqnum:String,
            disabledOption:false,
        }),

        props: {
            sequencenum: '',
            label: '',
            disabled:Boolean,
            type: '',
            mdvalue: {type: Number, default: null},
            smvalue: {type: Number, default: null},
            colval: {type: String, default: null},
            textval:{type: String, default: null}
        },
        watch: {
            'updatedSeqnum'(){
                this.updateSequenceNum();
            }
        },

        beforeMount() {
            this.updatedSeqnum=this.sequencenum;
            this.disabledOption=this.disabled;
        },

        methods: {
            updateSequenceNum() {
                switch (this.type) {
                    case "mito":
                        eventBus.$emit('UpdateMitoSequenceNum', this.updatedSeqnum);
                        break;
                    case "austr":
                        eventBus.$emit('UpdateAustrSequenceNum',this.updatedSeqnum);
                        break;
                    case "ystr":
                        eventBus.$emit('UpdateYstrSequenceNum',this.updatedSeqnum);
                        break;
                }

            },
        }

    }
</script>

<style scoped>

</style>