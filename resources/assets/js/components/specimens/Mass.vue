<template>
    <div>
        <!--    <div data-app="true">-->
        <v-text-field
                id="mass"
                name="mass"
                v-model="Mass"
                placeholder="e.g 11.3, 20.45"
                clearable
                :label="label"
                :suffix="units"
                dusk="se-mass"
                type="number"
                :disabled="disableOption"
        />
    </div>
</template>

<script>
    export default {
        name: "Mass",
        props: {
            disabled: Boolean,
            uom: String,
            label: {
                type: String,
                default: 'Mass'
            }
        },
        data() {
            return {
                Mass: null,
                disableOption: this.disabled,
                units: this.uom,
            }
        },
        mounted(){
        }
    }
</script>

<style scoped>

</style>