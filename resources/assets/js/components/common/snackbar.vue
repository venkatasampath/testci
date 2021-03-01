<template>
    <v-snackbar :value="show" @input="close" :timeout="timeout" :color="color" app :multi-line="multiline" elevation="5"
            :top="position_x === 'top'" :bottom="position_x === 'bottom'" :right="position_y === 'right'" :left="position_y === 'left'">
        <span>{{text}}</span>
        <template v-slot:action="{ attrs }"><v-icon @click="close">mdi-close</v-icon></template>
    </v-snackbar>
</template>

<script>
    import {eventBus} from "../../eventBus";

    export default {
        name: "snackbar",
        props:{
            snackbar: { type:Boolean, default: false },
            snackbar_color: { type:String, default: 'success' },
            snackbar_text: { type:String, default: 'Missing snackbar text' },
            snackbar_timeout: { type:Number, default: 3000 },
            position_x: { type:String, default: 'top' },
            position_y: String
        },
        data() {
            return {
                show: this.snackbar,
                text: this.snackbar_text,
                color: this.snackbar_color,
                timeout: this.snackbar_timeout,
                multiline: false,
            }
        },
        created() {
            // Listen for the snackbar event and its payload.
            eventBus.$on('show-snackbar', payload => {
                this.show = !this.show;
                this.text = (payload.text) ? payload.text : this.snackbar_text;
                this.color = (payload.color) ? payload.color : this.snackbar_color;
                this.timeout = (payload.timeout) ? payload.timeout : this.snackbar_timeout;
                this.multiline = (payload.multiline) ? payload.multiline : false;
            });
        },
        methods: {
            close() {
                // console.log("snackbar close");
                this.show = !this.show;
                this.text = this.snackbar_text;
                this.color= this.snackbar_color;
                this.timeout = this.snackbar_timeout;
                this.multiline = false;
                this.$emit('close-snackbar');
            }
        },
    }
</script>

<style scoped>

</style>