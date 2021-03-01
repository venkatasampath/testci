<template>

    <v-col cols="12" :md="mdvalue" :sm="smvalue" class="mt-3">
        <tr>
            <td>
                <count :count="updatedCount"
                       :mdvalue="mdvalue"
                       :smvalue="smvalue"
                       :label="countlabel"
                       :type="type"
                       :disabled="disabled"/>
            </td>
            /
            <td>
                <popfrequency :popfrequency="updatedPopfrequency"
                              :mdvalue="mdvalue"
                              :smvalue="smvalue"
                              :label="poplabel"
                              :type="type"
                              :disabled="disabled"/>
            </td>
        </tr>
    </v-col>
</template>


<script>

    export default {
        name: "countvsfrequency",

        data: () => ({
            updatedCount: String,
            updatedPopfrequency: String,
            mdvalue: 3,
            smvalue: 12,
            countlabel: 'Count',
            poplabel: 'Population Frequency',
        }),

        props: {
            count: '',
            popfrequency: '',
            disabled: Boolean,
            type: ''

        },

        beforeMount() {
            this.updatedCount = this.count;
            this.updatedPopfrequency = this.popfrequency;
        },


    }
</script>


<style scoped>

</style>