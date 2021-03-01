<template>
    <v-autocomplete id="search_type_select" name="search_type_select" v-model="ZoneSearchType" :key="ZoneSearchType"
                    :label= "label" placeholder="Select A Search Type" :rules="rules"
                    :items="items" item-text="text" item-value="value" :required="required">
    </v-autocomplete>
</template>

<script>
    import {changeObjectToArray} from "../../coraBaseModules";

    export default {
        name: "zonesearchtype",
        props: {
            options:Array,
            label: { type: String, default: "" },
            value: [Number, String],
            required: { type: Boolean, default: true },
        },
        data() {
            return {
                ZoneSearchType:this.value ? this.value.toString() : null,
                items: changeObjectToArray(this.options),
            };
        },
        computed:{
            rules() {
                return (this.required) ? [() => !!this.ZoneSearchType || 'Zone Search Type is required'] : [];
            }
        },
        watch:{
            value(val) {
                this.ZoneSearchType = val;
            },
            ZoneSearchType(val) {
                this.$emit("input", val ? val.toString() : "");
            }
        }
    }
</script>

<style scoped>

</style>