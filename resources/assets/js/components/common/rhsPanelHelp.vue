<template>
    <v-card>
        <v-card-title class="m-0 p-0">
            <v-app-bar>
                <v-toolbar-title>{{title}}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-progress-circular v-if="loading" :indeterminate="loading" color="primary"></v-progress-circular>
            </v-app-bar>
        </v-card-title>
        <v-card-text v-if="show_help">
            <iframe style="width:100%; height:725px" :src="url" ></iframe>
        </v-card-text>
    </v-card>
</template>

<script>
    import {eventBus} from "../../eventBus";

    export default {
        name: "rhsPanelHelp",
        props:{
            title: {type:String, default: "Help"},
            help_url: {type:String, default: "https://cora-docs.readthedocs.io"},
            show_help: {type:Boolean, default: true},
        },
        data() {
            return {
                loading: false,
                url: this.help_url,
            }
        },
    }
</script>

<style scoped>

</style>