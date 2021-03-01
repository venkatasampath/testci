<template>
    <v-col cols="12" md="3" sm="12">
        <v-autocomplete
                v-model="selectedtags"
                :items="tags"
                chips
                multiple
                :disabled="disabled"
                label="DNA Tags"
                placeholder="Select a tag"
        >
        </v-autocomplete>
    </v-col>
</template>

<script>
    import {eventBus} from "../../eventBus";
    export default {
        name: "dnatag",

        props: {
            selectedtags: Array,
            tags: Array,
            disabled: Boolean,
        }
    }
</script>

<style scoped>

</style>