<template>
    <v-col cols="12" md="3" sm="12" class="mt-3">
    <v-autocomplete
            v-model="updatedGroup"
            :items="getystrhaplo"
            item-text="text"
            item-value="value"
            :label="label"
            placeholder="Select Group"
            @input="updateGroup"
            :disabled="disabled"
    >

    </v-autocomplete>
    </v-col>
</template>

<script>
    import {changeObjectToArray} from "../../coraBaseModules";
    import {eventBus} from "../../eventBus";

    export default {
        name: "group",

        data:()=>({
            updatedGroup:'',
            groupoptions:[Object,Array],
        }),

        props: {
            options: [Object,Array],
            group: '',
            label: '',
            disabled: Boolean,
        },

        beforeMount(){
          this.updatedGroup=this.group
        },

        methods:{
            updateGroup(){
                eventBus.$emit('UpdateMitoHaplo',this.updatedGroup);
                eventBus.$emit('UpdateYstrHaplo',this.updatedGroup)
            }
        },

        computed: {
            getystrhaplo() {
                this.groupoptions = this.options;
                return changeObjectToArray(this.groupoptions);
            }
        },
    }
</script>

<style scoped>

</style>