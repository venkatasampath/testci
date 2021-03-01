<template>
    <div class="m-2 align-center">
        <contentheader :trail="trail"  model_name="dental_chart" :title="heading" :save_menu="true" @eventSave="save"></contentheader>
        <v-card>
            <v-card-text>
                <v-form ref="form">
                    <v-row>
                        <v-col cols="12" md="3">
                            <v-autocomplete v-model="form.accession_number" :items="items_accessions" label="Accession Number" placeholder="Select Accession Number" dusk="se-accession" clearable></v-autocomplete>
                        </v-col>
                        <v-col cols="12" md="3">
                            <v-autocomplete v-model="form.provenance1" :items="items_provenance1" label="Provenance 1" placeholder="Select Provenance 1" dusk="se-provenance1" clearable></v-autocomplete>
                        </v-col>
                        <v-col cols="12" md="3">
                            <v-autocomplete v-model="form.provenance2" :items="items_provenance2" label="Provenance 2" placeholder="Select Provenance 2" dusk="se-provenance2" clearable></v-autocomplete>
                        </v-col>
                        <v-col cols="12" md="3">
                            <v-text-field v-model="form.designator" dusk="se-designator" label="Designator"  placeholder="Designator: e.g. 403, 709"></v-text-field>
                        </v-col>
                    </v-row>
                </v-form>
                <v-row  class="px-2">
                    <v-col>
                        <v-autocomplete v-model="form.bones" dusk="teeth" :items="teethArray"  label="Teeth"
                                        chips deletable-chips multiple clearable item-text="name" item-value="id" @change="teethRemoved">
                        </v-autocomplete>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="3">
                        <v-autocomplete v-model="numberingSelected" :items="numberingSystemOptions" dusk="numbering-system" label="Numbering System"></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3">
                        <v-autocomplete v-model="toothSelected" :items="toothSelectOptions" dusk="tooth-selection" label="Tooth Selection"></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-autocomplete id="dentalCodes" dusk="dental-codes" label="Dental Code" :loading="loading" :items="dentalCodeData" v-model="codeSelected"
                                        item-text="description" item-value="id" placeholder="Select Dental Code for Assignment">
                            <template v-slot:selection="data">
                                <v-chip v-bind="data.attrs" :input-value="data.selected" :color="data.item.color"  @click="data.select">
                                    {{ data.item.description}}
                                </v-chip>
                            </template>
                            <template v-slot:item="data">
                                <template v-if="typeof data.item !== 'object'"><v-list-item-content v-text="data.item"></v-list-item-content></template>
                                <template v-else>
                                    <v-list-item-avatar class="headline" left :color="data.item.color"><v-icon>{{ data.item.icon }}</v-icon></v-list-item-avatar>
                                    <v-list-item-content :background-color="data.item.color">
                                        <v-list-item-title v-html="data.item.description"></v-list-item-title>
                                    </v-list-item-content>
                                </template>
                            </template>
                        </v-autocomplete>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
        <v-card color="white">
            <v-card-text>
                <div v-html="dentalChart()"></div>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import axios from "axios";

    export default {
        name: "dentalCreateByChart",
        props: {
            heading: { type: String, default: "Create Dental Specimen" },
        },
        components: {
        },
        data() {
            return {
                form: {},
                numberingSelected: 'Universal',
                loading: false,
                numberingSystemOptions: ['Universal', 'Palmer', 'Naval', 'WWII', 'FDI'],
                toothSelected: 'Whole Tooth',
                toothSelectOptions: ['Whole Tooth', 'Zones'],
                codeSelected: 1,
                dentalCodeData: [],
                type: 'dentalcodes',
                codeColor: '#EF9A9A',
                teethArray: [],
                teethSelection: [],
                selectedTeeth: null,
                teethZones: null,
                test: null,
                trail: [{ text: 'Home', disabled: false, href: '/', }, { text: 'Dental', disabled: true, href: 'dental' },
                        { text: 'New by Chart', disabled: true, href: 'createbychart' }],
            }
        },
        mounted() {
            let dentalChartSVG = document.getElementById('dentalChart');
            dentalChartSVG.addEventListener('click', this.selectTeeth);
            this.teethArray = this.items_bones.map(item => {
                if(item.dental === true) {
                    if(item.name.charAt(0) === 'T' && item.name != "Tooth") {
                        return {"id": item.id, "name": item.name}
                    }
                } else {return null;}
            });
            this.teethArray = this.teethArray.filter(function (item) {
                return item != null;
            });
            this.form.bones = this.teethArray;
            this.getDentalCodes();
            this.selectedTeeth = new Map();
        },
        created() {
            this.form.org_id = this.theOrg.id;
            this.form.project_id = this.theProject.id;
        },
        watch: {
            teethSelection(newVal, oldVal) {
                for(let i = 0; i < newVal.length; i++) {
                    let toothRemoved = newVal[i];
                    document.getElementById('dentalChart').getElementById(toothRemoved).style.display = 'none';
                    document.getElementById('dentalChart').getElementById(toothRemoved + '-outline').style.display = 'none';
                }
                if(newVal.length < oldVal.length) {
                    let toothRemoved = oldVal.filter(x => !newVal.includes(x))[0];
                    document.getElementById('dentalChart').getElementById(toothRemoved).style.display = 'block';
                    document.getElementById('dentalChart').getElementById(toothRemoved + '-outline').style.display = 'block';
                }
            },
            codeSelected: function(val) {
                for(let i = 0; i < this.dentalCodeData.length; i++) {
                 if(val === this.dentalCodeData[i].id) {
                     this.codeColor = this.dentalCodeData[i].color;
                 }
                }
            },
            numberingSelected: function(val) {
                let universal =  document.getElementById('dentalChart').getElementById('Universal');
                let fdi =  document.getElementById('dentalChart').getElementById('FDI');
                let naval =  document.getElementById('dentalChart').getElementById('Naval');
                let wwii =  document.getElementById('dentalChart').getElementById('WWII');
                let palmer =  document.getElementById('dentalChart').getElementById('Palmer');
                switch (val) {
                    case 'Universal':
                        universal.style.display = 'block';
                        fdi.style.display = 'none';wwii.style.display = 'none';
                        naval.style.display = 'none'; palmer.style.display = 'none';
                        break;
                    case 'Palmer':
                        palmer.style.display = 'block';
                        fdi.style.display = 'none'; wwii.style.display = 'none';
                        naval.style.display = 'none'; universal.style.display = 'none';
                        break;
                    case 'Naval':
                        naval.style.display = 'block';
                        fdi.style.display = 'none'; wwii.style.display = 'none';
                        universal.style.display = 'none'; palmer.style.display = 'none';
                        break;
                    case 'WWII':
                        wwii.style.display = 'block';
                        universal.style.display = 'none'; fdi.style.display = 'none';
                        naval.style.display = 'none'; palmer.style.display = 'none';
                        break;
                    case 'FDI':
                        fdi.style.display = 'block';
                        universal.style.display = 'none'; wwii.style.display = 'none';
                        naval.style.display = 'none'; palmer.style.display = 'none';
                        break;
                }
            },
        },
        methods: {
            teethRemoved() {
                let temp = [];
                for(let i = 0; i < this.teethArray.length; i++) {
                    temp[i] = this.teethArray[i].id;
                }
                this.teethSelection = temp.filter(x => !this.form.bones.includes(x));
            },
            save() {
               //
            },
            getDentalCodes(){
                this.loading = true;
                axios
                    .request({
                        url: '/api/dental/',
                        method: 'GET',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    }).then(response=>{
                        this.dentalCodeData = response.data.data;
                        this.loading = false;
                    }).catch(error => {
                        this.loading = false;
                    })
            },
            selectTeeth(event) {
                let element, elementID;
                let zonesTest;
                switch(this.toothSelected) {
                    case 'Whole Tooth':
                        element = document.getElementsByClassName(event.target.classList[0]);
                        elementID = element[0].id.split('-')[0];
                        zonesTest = { occlusal: this.codeSelected, medial: this.codeSelected, distal: this.codeSelected, lingual: this.codeSelected,
                            facial: this.codeSelected, tooth: this.codeSelected, root: this.codeSelected};
                        this.selectedTeeth.set(elementID, zonesTest);
                        for(let i = 0; i < element.length; i++) {
                            element[i].style.fill = this.codeColor;
                        }
                        console.log(this.selectedTeeth);
                        break;
                    case 'Zones':
                        element = document.getElementById(event.target.id);
                        elementID = event.target.id.split('-')[0];
                        let zoneName = event.target.id.split('-')[1];
                        zonesTest = { occlusal: null, medial: null, distal: null, lingual: null,
                            facial: null, tooth: null, root: null};
                        this.selectedTeeth.set(elementID, zonesTest);
                        element.style.fill = this.codeColor;

                        if(this.selectedTeeth.has(elementID)) {
                            console.log(this.selectedTeeth.get(elementID));
                            switch(zoneName) {
                                case 'root':
                                    zonesTest.root = this.codeSelected;
                                    break;
                                case 'tooth':
                                    zonesTest.tooth = this.codeSelected;
                                    break;
                            }
                        }
                        console.log(this.selectedTeeth);
                        break;
                }
            },
            dentalChart() {
                return require('../../../../../public/images/dentalChart.svg');
            },
        },
        computed: {
            ...mapGetters({
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
                bearerToken: 'bearerToken',
                items_accessions: 'getProjectAccessions',
                items_provenance1: 'getProjectProvenance1',
                items_provenance2: 'getProjectProvenance2',
                items_bones: 'getBones',
            }),
        }
    }
</script>

<style scoped>
</style>