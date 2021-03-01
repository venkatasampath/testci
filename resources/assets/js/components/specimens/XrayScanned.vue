<template>
    <v-row>
        <v-col>
            <v-switch id="xray_scanned" name="xray_scanned" v-model="xray.xray_scanned"
                      :label="label" :value="xray.xray_scanned" :disabled="disabled" dusk="se-xray_scanned">
            </v-switch>
        </v-col>
        <v-col>
            <date v-if="showDate && xray.xray_scanned" name="xray_scanned_date" dusk="xray_scanned_date" v-model="xray.xray_scanned_date" label="X-ray Scanned On" :disabled="disabled"/>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: "XrayScanned",
        props: {
            value: { type: Object, default: () => { } },
            disabled: { type: Boolean, default: false },
            label: { type: String, default: "X-ray Scanned" },
            showDate: { type: Boolean, default: true },
        },
        data() {
            return {
                xray: this.value
            };
        },
        watch: {
            value(val) {
                this.xray = val;
            },
        }
    };
</script>
