<template>
    <v-toolbar dark>
        <v-toolbar-title>{{title}}</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-tooltip top>
            <template v-slot:activator="{ on }">
                <v-btn icon v-on="on" @click="visible = !visible"><v-icon>mdi-window-minimize</v-icon></v-btn>
            </template>
            <span>Collapse</span>
        </v-tooltip>
        <div v-if="action=='Update'">
            <v-tooltip v-model="showSave" top>
                <template v-slot:activator="{ on }">
                    <v-btn icon v-on="on" @click=""><v-icon>mdi-content-save</v-icon></v-btn>
                </template>
                <span>Save</span>
            </v-tooltip>
            <v-tooltip v-model="undo" top>
                <template v-slot:activator="{ on }">
                    <v-btn icon v-on="on" href=""><v-icon>mdi-undo</v-icon></v-btn>
                </template>
                <span>Undo</span>
            </v-tooltip>
        </div>
        <div v-if="action=='View'">
            <v-tooltip v-model="showEdit" top>
                <template v-slot:activator="{ on }">
                    <v-btn icon v-on="on" href=""><v-icon>mdi-pencil</v-icon></v-btn>
                </template>
                <span>Edit</span>
            </v-tooltip>
        </div>
        <v-tooltip v-model="showURL" top>
            <template v-slot:activator="{ on }">
                <v-btn icon v-on="on" :href="help_url" target="_blank"><v-icon>mdi-help-circle-outline</v-icon></v-btn>
            </template>
            <span>CoRA Docs URL</span>
        </v-tooltip>
    </v-toolbar>
</template>

<script>
    export default {
        name: "toolbar",
        props:{
            title:String,
            action:String,
            visible:{type:Boolean, default: true},
            help_url:String,
        },
        data(){
            return{
                showSave:false,
                showEdit:false,
                showURL:false,
                undo:false,
            }
        }
    }
</script>
