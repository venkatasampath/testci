<template>
    <v-div>
        <!--    <div data-app="true">-->
        <v-text-field
                id="count"
                name="count"
                v-model="Count"
                placeholder="e.g 1,2"
                clearable
                :label="label"
                dusk="se-count"
                type="number"
                :disabled="disableOption"
        />
    </v-div>
</template>

<script>
    export default {
        name: "Count",
        props: {
            disabled: Boolean,
            label: {
                type: String,
                default: 'Count'
            }
        },
        data() {
            return {
                message1: null,
                disableOption: this.disabled,
            }
        },
        mounted(){
        }
    }
</script>

<style scoped>

</style>