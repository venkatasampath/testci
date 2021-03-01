<template>
    <div>
        <v-autocomplete :items="listZones"
                        v-model="pathologyZones"
                        dense
                        chips
                        :multiple="multiple"
                        :disabled="disable"
                        :readonly="disable"
                        placeholder="Zones"
                        item-name="text"
                        item-value="value"
        ></v-autocomplete>

        <v-autocomplete :items="listPathology"
                        v-model="pathology"
                        dense
                        chips
                        :multiple="multiple"
                        :disabled="disable"
                        :readonly="disable"
                        placeholder="Pathology"
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
        props: {
            list_zones: [Object, Array],
            list_pathology: [Object, Array],
            list_trauma: [Object, Array],
            list_anomaly: [Object, Array],
            disable: {
                type: Boolean,
                default: false
            },
            base_url: String,
            specimen_id: Number,
            loadedPathologys: [Array, Object],
            multiple: {
                type: Boolean,
                default: false
            },
            review: {
                type: Boolean,
                default: false
            },
            keypathology: [String, Number]
        },
        name: 'pathology',
        data: () => ({
            pathologyZones: '',
            pathology: '',
            addInfo: '',
            inset: false,
            reviewPathology: {},
            originalPatholog: {}
        }),
        mounted() {
            if (!this.review) {
                this.pathology = this.loadedPathologys.pathology_id.toString();
                this.pathologyZones = this.loadedPathologys.zone_id.toString();
                this.addInfo = this.loadedPathologys.additional_information;
            } else {

            }
        },
        computed: {
            listZones() {
                return changeObjectToArray(this.list_zones);
            },
            listPathology() {
                return changeObjectToArray(this.list_pathology);
            }
        },
    }
</script>

<style>

</style>