<template>
    <v-app>
    <div id="table">
        <v-row>
            <v-col cols="9">
                <v-btn-toggle
                        v-model="toggle_multiple"
                        dense
                        dark
                        multiple>
                    <v-btn>Excel</v-btn>

                    <v-btn>PDF</v-btn>
                 </v-btn-toggle>
             </v-col>

            <!-- ToDo make the column visibility -->
<!--            <template v-slot:activator="{on}">-->
<!--                <v-menu offset-y :close-on-content-click="false" lazy :key="headers.id">Column Visibility-->
<!--                    <v-btn v-on="on">-->
<!--                        Column Visibility-->
<!--                    </v-btn>-->
<!--                </v-menu>-->
<!--            </template>-->

            <v-spacer></v-spacer>

            <v-col cols="3">
                <v-text-field
                    v-model="search"
                    label="Search"
                    single-line
                    hide-details
                >
                </v-text-field>
            </v-col>
        </v-row>

        <v-data-table
            :headers="columnVisibility"
            :items="options_table"
            :sort-by="['key']"
            :item-key="key"
            :item-per-page="5"
            multi-sort
            class="elevation-1"
            :search="search"
            >
            <template v-slot:item.key="{ item }">
                <a :href="/skeletalelements/ + specimen_id ">{{ item.key }}</a>
            </template>

<!--            ToDo Get Bone name from boneData-->
<!--            <template v-slot:item.bone="{ item }">-->
<!--                {{ boneData[item.bone].name }}-->
<!--                &lt;!&ndash;                                <a v-for="names in item.boneData" > {{ names.name }} </a>&ndash;&gt;-->
<!--            </template>-->

            <template v-slot:item.measured="{ item }">
                <v-icon right :color= "getIconColor(item.measured)">{{ getBooleanIcon(item.measured) }}</v-icon>
            </template>

            <template v-slot:item.isotope_sampled="{ item }">
                <v-icon right :color="getIconColor(item.isotope_sampled)">{{ getBooleanIcon(item.isotope_sampled) }}</v-icon>
            </template>

            <template v-slot:item.clavicle_triage="{ item }">
                <v-icon right :color="getIconColor(item.clavicle_triage)">{{ getBooleanIcon(item.clavicle_triage) }}</v-icon>
            </template>

            <template v-slot:item.ct_scanned="{ item }">
                <v-icon right :color="getIconColor(item.ct_scanned)">{{ getBooleanIcon(item.ct_scanned) }}</v-icon>
            </template>

            <template v-slot:item.xray_scanned="{ item }">
                <v-icon right :color="getIconColor(item.xray_scanned)">{{ getBooleanIcon(item.xray_scanned) }}</v-icon>
            </template>

        </v-data-table>
    </div>
    </v-app>
</template>

<script>

    import axios from "axios";
    import {mapGetters, mapState} from "vuex";

    export default{
        name: 'Datatable2',
        props:{
            specimen: Array,
            specimen2: Array,
            option: Object,
            element: String,
            specimen_id: Number,
        },
        data: () => ({
            search: '',
            toggle_multiple: [],
            options_table: [],
            key:'',
            visibility: false,
            boneData: [],
            headers: [
                {text: 'Key', value: 'key', width: '200px', visibility: true},
                {text: 'Bone', value: 'bone', visibility: true},
                {text: 'Side', value: 'side', visibility: true},
                {text: 'Bone Group', value: 'bone_group', visibility: true},
                {text: 'Individual Number', value: 'individual_number', visibility: true},
                {text: 'DNA Sampled', value: 'dna_sampled', visibility: true},
                {text: 'Mito Sequence Number', value: 'mito_sequence_number', visibility: true},
                {text: 'Measured', value: 'measured', visibility: true},
                {text: 'Isotope Sampled', value: 'isotope_sampled', visibility: true},
                {text: 'Clavicle Triage', value: 'clavicle_triage', visibility: true},
                {text: 'CT Scanned', value: 'ct_scanned', visibility: true},
                {text: 'Xray Scanned', value: 'xray_scanned', visibility: true},
                {text: 'Inventoried', value: 'inventoried', visibility: false},
                {text: 'Reviewed', value: 'reviewed', visibility: false},
                {text: 'Inventoried By', value: 'inventoried_by', visibility: false},
                {text: 'Reviewed By', value: 'updated_by', visibility: false},
                {text: 'Inventoried At', value: 'inventoried_at', visibility: false},
                {text: 'Created By', value: 'created_by', visibility: false},
                {text: 'Created At', value: 'created_at', visibility: false},
                {text: 'Updated By', value: 'updated_by', visibility: false},
                {text: 'Updated At', value: 'updated_at', visibility: false},
            ],
        }),
        mounted() {
            // for debugging purposes
            // console.log(this.specimen2);
            // console.log(this.specimen);
            //
            // this.specimen.map(item => console.log(item.key))
        },
        created(){
          this.initializeRows()
        },
        methods: {
            initializeRows () {
                this.specimen2.map(item => this.options_table.push(
                    {
                        key: item.accession_number + ':' + item.provenance1 + '::' + item.designator,
                        bone: item.sb_id,
                        side: item.side,
                        bone_group: item.bone_group,
                        individual_number: item.individual_number,
                        dna_sampled: item.dna_sampled,
                        mito_sequence_number: item.mito_sequence_number,
                        measured: item.measured,
                        isotope_sampled: item.isotope_sampled,
                        clavicle_triage: item.clavicle_triage,
                        ct_scanned:item.ct_scanned,
                        xray_scanned:item.xray_scanned,
                        created_by: item.created_by,
                        created_at: item.created_at
                    })
                )
            },
            getBooleanIcon(item){
                return item === true ? '✔' : ''
            },
            getIconColor(item){
                return item === true ? 'success' : ''
            },
            changeColumnVisibilityState(column){
                this.headers.forEach(function(item){
                    if(item == column){
                        return item.visibility == true
                    }
                })
            },
            fetchBones(){
                axios
                    .request({
                        url: this.base_url+'/api/base-data/bones',
                        method: 'GET',
                        headers:{
                            'Content-Type' : 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        }
                    })
                    .then(response=>{
                        this.boneData=response.data.data;
                    })
            },
        },
        computed:{
            columnVisibility(){
                return this.headers.filter(item => item.visibility == true);
            },
            ...mapState({
                perPage: state => state.search.perPage,
                rowsPerPageItems: state => state.search.rowsPerPageItems,
                bones: state => state.bones,
            }),
            ...mapGetters({
                bearerToken: 'bearerToken',
                csrfToken: 'csrfToken',
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
            }),
        }

    }
</script>
