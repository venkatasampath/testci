<template>

    <v-col cols="12" md="3" sm="12" class="mt-3">
        <v-autocomplete
                v-model="updatedStatus"
                :items="getstatus"
                item-text="text"
                item-value="value"
                label="Results Status"
                placeholder="Select Status"
                @input="updateStatus"
                :disabled="disabledOption"
        >

        </v-autocomplete>
    </v-col>

</template>

<script>
    import {changeObjectToArray} from "../../coraBaseModules";
    import {eventBus} from "../../eventBus";

    export default {
        name: "result-status",

        data: () => ({
            updatedStatus: String,
            statuses: Object,
            disabledOption:false,
        }),

        props: {
            options: Object,
            selectedstatus: '',
            disabled:Boolean,
            type: '',
        },
        watch: {
            'updatedStatus'(){
                this.updateStatus();
            }
        },

        beforeMount() {
            this.updatedStatus = this.selectedstatus;
            this.disabledOption=this.disabled;
        },

        methods: {
            updateStatus() {
                switch (this.type) {
                    case "mito":
                        eventBus.$emit('UpdateMitoStatus', this.updatedStatus);
                        break;
                    case "austr":
                        eventBus.$emit('UpdateAustrStatus', this.updatedStatus);
                        break;
                    case "ystr":
                        eventBus.$emit('UpdateYstrStatus', this.updatedStatus);
                        break;
                }
            },
        },

        computed: {
            getstatus: function () {
                this.statuses = this.options;
                return changeObjectToArray(this.statuses);

            }
        },
    }
</script>

<style scoped>

</style>