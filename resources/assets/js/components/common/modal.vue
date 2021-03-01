<template>
    <v-dialog v-model="show_dialog" max-width="50%" id="modal">
        <v-card>
            <slot></slot>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: 'modal',
        props:{
            visible: { type: Boolean, default: false },
        },
        data: () => ({
            dialog: false,
        }),
        computed :{
            show_dialog: {
                get() { return this.visible },
                set(value){ if(!value) { this.$emit('close') } }
            }
        },
    }
</script>
