<template>
    <v-row>
        <v-col>
            <v-switch name="3D_scanned" v-model="scanned['3D_scanned']" :value="scanned['3D_scanned']"
                :label="label" :disabled="disabled" dusk="se-3d_scanned">
            </v-switch>
        </v-col>
        <v-col>
            <date v-if="showDate && scanned['3D_scanned']" v-model="scanned['3D_scanned_date']" name="3D_scanned_date" dusk="3D_scanned_date" label="3D Scanned On" :disabled="disabled"/>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: "Scanned",
        props: {
            disabled: { type: Boolean, default: false },
            value: { type: Object, default: () => {} },
            label: { type: String, default: "3D Scanned" },
            showDate: { type: Boolean, default: true },
        },
        data() {
            return {
                scanned: this.value
            }
        }
    }
</script>
