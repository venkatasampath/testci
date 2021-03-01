<template>
    <div id="toolbar1">
        <v-toolbar dense dark :width="width">

                <v-badge color="primary" :content="badgeContent">{{ title }}</v-badge>


            <v-spacer></v-spacer>

            <slot></slot>
            <v-btn-toggle v-model="value" group dense>
            <v-btn icon v-if="save_enabled" value="save" v-model="value" @click="buttonClicked">
                <v-icon>mdi-content-save</v-icon>
            </v-btn>

            <v-btn icon v-if="edit_enabled" value="edit" v-model="value" @click="buttonClicked">
                <v-icon>mdi-lead-pencil</v-icon>
            </v-btn>

            <v-btn icon v-if="undo_enabled" value="undo" v-model="value" @click="buttonClicked">
                <v-icon>mdi-undo</v-icon>
            </v-btn>
            </v-btn-toggle>
        </v-toolbar>
    </div>
</template>

<script>
    export default {
        name: "toolbar1",
        props:{
            title: String,
            save_enabled: {
                default: true,
                type: Boolean
            },
            edit_enabled:{
                default: true,
                type: Boolean
            },
            undo_enabled:{
                default: true,
                type: Boolean
            },
            badgeContent: Number,
            width:{
                default: '400px',
                type: String
            }
        },
        data: () => ({
            value: null
        }),
        methods:{
            buttonClicked(){
                this.$nextTick(() => {
                    this.$emit('buttonclicked', this.value)
                })
            }
        }
    }
</script>

<style scoped>

</style>