<!--<template>-->
<!--    <v-dialog v-model="show_dialog" max-width="50%" id="modal">-->
<!--        <v-card>-->
<!--            <slot></slot>-->
<!--        </v-card>-->
<!--    </v-dialog>-->
<!--</template>-->
<template>
    <v-row justify="center">
        <v-dialog v-model="show_dialog" persistent max-width="50%">
<!--            <template v-slot:activator="{ on, attrs }">-->
<!--                <v-btn color="primary" dark v-bind="attrs" v-on="on">Open Dialog</v-btn>-->
<!--            </template>-->
            <v-card>
                <v-card-title>
                    <v-toolbar dense>
                        <v-toolbar-title>{{title}}</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn icon @click="show_dialog = false"><v-icon>mdi-close</v-icon></v-btn>
                    </v-toolbar>
                </v-card-title>
                <v-card-text>
                    <!-- slot content provided by caller-->
                    <slot></slot>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="show_dialog = false"><v-icon>mdi-close</v-icon>Close</v-btn>
                    <v-btn color="blue darken-1" text @click="show_dialog = false"><v-icon>mdi-close</v-icon>Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>

    export default {
        name: 'modal-common',
        props:{
            title: { type: String, default: "No title provided" },
            dialog: { type: Boolean, default: false },
            action: { type: String, default: "" },
        },
        data: () => ({
            show_dialog: (this.dialog) ? this.dialog : false,
        }),
        computed :{
            // dialogShow: {
            //     get(){
            //         return this.visible
            //     },
            //     set(value){
            //         if(!value){
            //             this.$emit('close')
            //         }
            //     }
            // },
        },
    }
</script>

<style>

</style>
