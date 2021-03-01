<template>
    <v-row>
        <v-col>
            <v-switch id="ctscanned" name="ct_scanned" v-model="ctScan.ct_scanned"
                      :label="label" :disabled="disabled" :value="ctScan.ct_scanned" dusk="se-ct_scanned">
            </v-switch>
        </v-col>
        <v-col>
            <date v-if="showDate && ctScan.ct_scanned" name="ct_scanned_date" dusk="ct_scanned_date" v-model="ctScan.ct_scanned_date" label="CTScanned At" :disabled="disabled"/>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: "ctscanned",
        props: {
            value: { type: Object, default: () => {} },
            disabled: { type: Boolean, default: false },
            label: { type: String, default: "CT Scanned" },
            showDate: { type: Boolean, default: true },
        },
        data() {
            return {
                ctScan: this.value
            }
        },
        watch: {
            value(val) {
                this.ctScan = val;
            }
        }
    }
</script>
