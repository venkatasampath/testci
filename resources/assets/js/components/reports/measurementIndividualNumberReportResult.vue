<template>
    <div id="specimen-table">
        <v-row>
            <v-col cols="9">
                <v-btn-toggle v-model="toggle_multiple" dense dark multiple>
                    <v-btn>Excel</v-btn>
                    <v-menu
                            right
                            offset-x
                            :close-on-content-click="false"
                            max-height="500px"
                    >
                        <template v-slot:activator="{ on }">
                            <v-btn v-on="on">Column Visibility
                                <v-icon right>$dropdown</v-icon>
                            </v-btn>
                        </template>

                        <v-list>
                            <v-list-item v-for="(header, index) in headers" :key="index">
                                <v-checkbox
                                        v-bind:label="header.text"
                                        v-model="header.visibility"
                                        :value="header.visibility" />
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </v-btn-toggle>
            </v-col>

            <v-spacer />

            <v-col cols="3">
                <v-text-field
                        v-model="search"
                        label="Search"
                        single-line
                        hide-details />
            </v-col>
        </v-row>

        <v-data-table
                :headers="columnVisibility"
                :items="data"
                :item-per-page="10"
                multi-sort
                calculate-widths=""
                class="elevation-1"
                :search="search" />
    </div>
</template>

<script>
    export default {
        name: 'MeasurementIndividualNumberReportResult',

        props: {
            skeletalElements: {
                type: Array,
                default: () => []
            },
            measurements: {
                type: Array,
                default: () => []
            }
        },

        data() {
            return {
                headers: [
                    {text: 'Measurement', value: 'measurementname', visibility: true},
                ],
                search: '',
                toggle_multiple: [],
                measurementcolumns: [],
            }
        },

        computed: {
            data() {
                const rows = [];

                for (var i=0; i<this.skeletalElements.length; i++){
                    for(var j=0; j<this.skeletalElements[i].measurements.length; j++){
                        this.measurementcolumns.push({
                            se_id:this.skeletalElements[i].measurements[j].pivot.se_id,
                            measurement_id:this.skeletalElements[i].measurements[j].pivot.measurement_id,
                            measure:this.skeletalElements[i].measurements[j].pivot.measure
                        })
                    }
                }

                this.measurements.forEach(measure =>
                    rows.push({
                        measurementname: measure.name,
                        ...this.getMeasure(measure)
                    })

                );
                return rows;
            },
            columnVisibility() {
                return this.headers.filter(item => item.visibility === true);
            }
        },

        methods: {
            getMeasure(measure){
                var finalcolumns={};
                for(var col=0; col<this.measurementcolumns.length; col++){
                    if (measure.id == this.measurementcolumns[col].measurement_id)
                        finalcolumns[this.measurementcolumns[col].se_id]=this.measurementcolumns[col].measure;
                }
                return finalcolumns;
            },
            getKey(item) {
                var key = `${item.accession_number ? item.accession_number : ''}:${item.provenance1 ? item.provenance1 : ''}:${item.provenance2 ? item.provenance2 : ''}:${item.designator ? item.designator : ''}`;
                var bone = item.skeletalbone.name;
                var side = item.side;
                return `${key}-${bone}-${side}`;
            },
            getHeaders: function(){
                this.skeletalElements.forEach(item =>
                    this.headers.push({
                        text:this.getKey(item),
                        value:item.id.toString(),
                        visibility: true
                    })
                );
            }
        },
        mounted() {
            this.getHeaders();
        }
    }
</script>
