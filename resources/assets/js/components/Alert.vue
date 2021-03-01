<template>
    <div>
        <v-alert :type="color" :dense="dense">{{ textBody }}</v-alert>
    </div>
</template>

<script>
    export default {
        name: 'alert',
        props: {
            textBody: String,
            color: String,
            dense: {
                type: Boolean,
                default: true
            }
        },
        data: () => ({})
    }
</script>

<style>

</style>