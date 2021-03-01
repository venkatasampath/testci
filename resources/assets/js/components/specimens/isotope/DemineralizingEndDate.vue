<template>

    <v-menu
            v-model="DemineralizingEndDate"
            :close-on-content-click="false"
            :nudge-right="40"
            lazy
            offset-y
            max-width="290px"
            min-width="290px"
            transition="scale-transition"
    >
        <template v-slot:activator="{ on }">
            <v-text-field
                    label="Demineralizing End Date:"
                    placeholder="mm/dd/yyyy"
                    readonly
                    :value="fromDateDisp"
                    v-on="on"
                    dusk="dna-demineralizing_end_date"
            />
        </template>
        <v-date-picker
                reactive
                v-model="fromDateVal"
                @input="DemineralizingEndDate = false"
                :disabled="disableOption"
        />
    </v-menu>

</template>

<script>
    export default {
        props: {
            disabled: Boolean,
        },
        data: vm => ({
            DemineralizingEndDate: false,
            fromDateVal: null,
            dateFormatted: vm.formatDate(new Date().toISOString().substr(0, 10)),
            disableOption: this.disabled,
        }),
        computed: {
            fromDateDisp() {
                return this.formatDate(this.fromDateVal);
            },
        },

        watch: {
            fromDateVal (val) {
                this.dateFormatted = this.formatDate(this.fromDateVal)
            },
        },

        methods: {
            formatDate (fromDateVal) {
                if (!fromDateVal) return null
                const [year, month, day] = fromDateVal.split('-')
                return `${month}/${day}/${year}`
            },
            parseDate (fromDateVal) {
                if (!fromDateVal) return null
                const [month, day, year] = fromDateVal.split('/')
                return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
            },
        },
    }
</script>

<style>
    div.v-application--wrap{
        min-height: 0;
    }
</style>