<template>
    <div>
        <v-autocomplete :items="listZones"
                        v-model="traumaZones"
                        dense
                        chips
                        :multiple="multiple"
                        :disabled="disable"
                        :readonly="disable"
                        placeholder="Zones"
                        item-name="text"
                        item-value="value"
        ></v-autocomplete>

        <v-autocomplete :items="listTraumas"
                        v-model="traumas"
                        dense
                        chips
                        :multiple="multiple"
                        :disabled="disable"
                        :readonly="disable"
                        placeholder="Traumas"
                        item-name="text"
                        item-value="value"
        ></v-autocomplete>

        <v-textarea
                v-model="addInfo"
                dense
                :disabled="disable"
                :readonly="disable"
                placeholder="Additional Information"
        ></v-textarea>
    </div>
</template>

<script>
    import {changeObjectToArray} from "../../../coraBaseModules";

    export default {
        name: 'Traumas',
        props: {
            list_trauma: [Object, Array],
            list_anomaly: [Object, Array],
            list_zones: [Object, Array],
            disable: {
                type: Boolean,
                default: false
            },
            specimen_id: Number,
            base_url: String,
            multiple: {
                type: Boolean,
                default: false
            },
            review: {
                type: Boolean,
                default: false
            },
            loadedTraumas: [Object, Array],
        },
        data: () => ({
            traumas: '',
            traumaZones: '',
            addInfo: '',
        }),
        methods: {},
        computed: {
            listZones() {
                return changeObjectToArray(this.list_zones)
            },
            listTraumas() {
                return changeObjectToArray(this.list_trauma)
            }
        },
        mounted() {
            if (!this.review) {
                this.traumas = this.loadedTraumas.trauma_id.toString();
                this.traumaZones = this.loadedTraumas.zone_id.toString();
                this.addInfo = this.loadedTraumas.additional_information;
            }
        }
    }
</script>

<style>

</style>