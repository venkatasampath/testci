<template>

    <v-col cols="12" md="3" sm="12" class="mt-3">
        <v-autocomplete
                v-model="updatedMethod"
                :items="getmethods"
                item-text="text"
                item-value="value"
                label="Method*"
                required
                :disabled="disabledOption"
                :rules="methodRules"
                placeholder="Select Method"
        >

        </v-autocomplete>
    </v-col>


</template>

<script>
    import {changeObjectToArray} from "../../coraBaseModules";
    import {eventBus} from "../../eventBus";

    export default {
        name: "dnamethod",

        data: () => ({
            updatedMethod: String,
            methods: Object,
            disabledOption: false,
        }),


        props: {
            type: String,
            options: Object,
            methodRules: [v => !!v || 'Please select a method'],
            selectedmethod: '',
            disabled: Boolean,
        },
        watch: {
            'updatedMethod'(){
                this.updateMethod();
            }
        },


        methods: {
            updateMethod() {
                switch (this.type) {
                    case "mito":
                        eventBus.$emit('UpdateMitoMethod', this.updatedMethod);
                        break;
                    case "austr":
                        eventBus.$emit('UpdateAustrMethod', this.updatedMethod);
                        break;
                    case "ystr":
                        eventBus.$emit('UpdateYstrMethod', this.updatedMethod);
                        break;
                }

            }
        },


        created() {
            this.disabledOption = this.disabled;
            switch (this.type) {
                case "mito":
                    this.updatedMethod = this.selectedmethod ? this.selectedmethod: 'Sanger';
                    break;
                case "austr":
                    this.updatedMethod = this.selectedmethod ? this.selectedmethod: 'AmpFLSTR Minifiler';
                    break;
                case "ystr":
                    this.updatedMethod = this.selectedmethod ? this.selectedmethod: 'Y filer';
                    break;
            }
        },


        computed: {
            getmethods() {
                this.methods = this.options;
                return changeObjectToArray(this.methods);
            }
        },
    }
</script>

<style scoped>

</style>