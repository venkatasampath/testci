<template>
    <v-btn :disabled="disabled">
        Save Changes
    </v-btn>
</template>

<script>
    export default {
        name: "SaveBtn",

        // data:()=> ({
        //     disabledValue: Boolean,
        // }),

        props:{
            disabled: false,
        },

        // beforeMount() {
        //    this.disabledValue = this.disabled;
        // }
    }
</script>

<style scoped>

</style>