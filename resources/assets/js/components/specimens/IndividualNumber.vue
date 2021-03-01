<template>
    <v-row>
        <v-col v-if="autocomplete" cols="3">
            <v-autocomplete id="InNo" :name="individualNumberName" v-model="individualNumber[individualNumberModelKey]" :key="individualNumber[individualNumberModelKey]"
                            :label="label" placeholder="Select Individual Number" dusk="se-zones" :rules="rules"
                            :items="inNodata" item-text="value" item-value="id" :disabled="disabled" :required="required">
            </v-autocomplete>
            <input type="hidden" :name="individualNumberName" :value="individualNumber[individualNumberModelKey]"/>
        </v-col>
        <v-col v-else cols="3">
            <v-text-field id="individual_number" :name="individualNumberName" v-model="individualNumber[individualNumberModelKey]"
                          :label="label" placeholder="e.g., I-212, I-100" dusk="se-individual_number" :disabled="disabled" clearable>
            </v-text-field>
        </v-col>

        <v-col>
            <date v-if="!autocomplete && individualNumber.individual_number" v-model="individualNumber.identification_date" name="identification_date" label="Identification Date" :disabled="disabled" dusk="se-identification_date">
            </date>
        </v-col>

        <v-col v-if="!autocomplete && individualNumber.individual_number">
            <v-autocomplete id="remains_status" name="remains_status" v-model="individualNumber.remains_status" label="Remains Status" dusk="se-remains_status" :disabled="disabled" :items="itemsRemainsStatus" item-text="text" item-value="value" required clearable>
            </v-autocomplete>
        </v-col>

        <v-col>
            <date v-if="!autocomplete && individualNumber.individual_number && individualNumber.remains_status === 'Released'" v-model="individualNumber.remains_release_date" name="remains_release_date" label="Remains Release Date" :disabled="disabled" dusk="remains_release_date">
            </date>
        </v-col>
    </v-row>
</template>

<script>
    import {changeObjectToArray} from "../../coraBaseModules";
    export default {
        name: "IndividualNumber",
        props: {
            options: { type: Object, default: () => ({"In Lab": "In Lab", "Released": "Released"}) },
            autocomplete: { type: Boolean, default: false },
            value: { type: Object, default: () => { } },
            label: { type: String, default: "Individual Number" },
            disabled: { type: Boolean, default: false },
            required: { type: Boolean, default: false },
            individualNumberName: { type: String, default: "individual_number" },
            individualNumberModelKey: { type: String, default: "individual_number" },
        },
        data() {
            return {
                individualNumber: this.value,
                itemsRemainsStatus: changeObjectToArray(this.options),
            };
        },
        computed: {
            rules() {
                return (this.required) ? [() => !!this.individualNumber || "Individual Number is required"] : [];
            },
            inNodata() {
                const InNodata = [];
                for (const key in this.options) {
                    InNodata.push({ value: key, text: this.options[key] });
                }
                return InNodata;
            }
        },
        watch: {
            value(val) {
                this.individualNumber = val;
            }
        }
    };
</script>