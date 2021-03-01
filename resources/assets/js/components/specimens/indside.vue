<!--Grouped component Individual Number, Side-->
<template>
    <v-row>
        <IndividualNumber v-model="values" :name="INModelKey" label="Individual Number"
                :options="indno" :required="false" :autocomplete="true">
        </IndividualNumber>
        <Side v-model="values[sideModelKey]" :name="sideModelKey" label="Side"
                :options="side" :required="false" class_value="">
        </Side>
    </v-row>
</template>

<script>
    import IndividualNumber from "./IndividualNumber";
    import Side from "./Side";

    export default {
        components: {
            'IndividualNumber':IndividualNumber,
            'Side':Side,
        },
        name: "indside",
        props:{
            indno:Object,
            side:Object,
            cols: { type: Object, default: () => {} },
            modelKeys: { type: Object, default: () => {} },
            value: { type: Object, default: () => {} },
        },
        data() {
            return {
                values: this.value
            };
        },
        computed:{
            INModelKey() {
                return this.modelKeys.individual_number ? this.modelKeys.individual_number : "individual_number_select";
            },
            sideModelKey() {
                return this.modelKeys.side_INumber ? this.modelKeys.side_INumber : "side_select_INumber";
            },
        }
    }
</script>

<style scoped>

</style>