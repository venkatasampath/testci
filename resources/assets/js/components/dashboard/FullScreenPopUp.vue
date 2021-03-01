<template>
    <v-dialog
            v-model="dialogShow"
            fullscreen
            hide-overlay
            transition="dialog-bottom-transition"
            id="dialog"
    >
        <v-card>
            <slot></slot>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: "fullScreenPopup",
        props: {
            visible: Boolean,
            action: String
        },
        data() {
            return {
                dialog: false,
            }
        },
        mounted() {

        },
        methods: {

        },
        computed :{
            dialogShow: {
                get(){
                    return this.visible
                },
                set(value){
                    if(!value){
                        this.$emit('close')
                    }
                }
            }
        },
        watch: {

        }
    }
</script>

<style>
    div.v-application--wrap {
        min-height: 0;
    }
</style>