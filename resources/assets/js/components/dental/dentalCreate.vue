<template>
    <div class="m-2 align-center">
        <contentheader :trail="trail"  model_name="dental_create" :title="heading" dusk="tooth-save-add" :save_menu="true" @eventSave="save"></contentheader>
        <v-card>
            <v-card-text>
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
                        <v-text-field v-model="form.designator" label="Designator" placeholder="Designator: e.g. 403, 709" dusk="se-designator"></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="3">
                        <v-autocomplete v-model="form.sb_id" :items="teethArray" label="Tooth" placeholder="Select Tooth" item-text="name" item-value="id" dusk="se-tooth" clearable></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="3">
                        <v-autocomplete v-model="form.completeness" :items="completeOptions" label="Completeness" placeholder="Select Completeness" dusk="se-completeness" clearable></v-autocomplete>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
    import { mapGetters, mapState } from "vuex";
    import axios from "axios";
    import {eventBus} from "../../eventBus";


    export default {
        name: "dentalCreate",
        props: {
            heading: { type: String, default: "Create Dental Specimen" },
        },
        data() {
            return {
                form: {},
                teethArray: [],
                completeSelect: 'Complete',
                completeOptions: ['Complete', 'Incomplete'],
                se_id: 0,
                trail: [{ text: 'Home', disabled: false, href: '/', },
                    { text: 'Dental ', disabled: true, href: 'dental' },
                    { text: 'New', disabled: true, href: 'create' }, ],
            }
        },
        mounted() {
            this.teethArray = this.items_bones.map(item => {
                if(item.dental === true) {
                    return {"id": item.id, "name": item.name}
                } else {
                    return null;
                }
            });
            this.teethArray = this.teethArray.filter(function (item) {
                return item != null;
            });
        },
        created() {
            this.form.org_id = this.theOrg.id;
            this.form.project_id = this.theProject.id;
            this.form.side = 'Left';
        },
        watch: {
            //
        },
        methods: {
            reset() {
                //
            },
            save() {
                axios
                    .request({
                        url: '/api/specimens/',
                        method: 'POST',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken },
                        data: this.form
                    }).then(response=>{
                        this.se_id = response.data.data.id;
                        window.location.href = '/skeletalelements/' + this.se_id;
                    }).catch(error => {
                        //
                    });
            },
        },
        computed: {
            ...mapState({
                //
            }),
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
        },
    }
</script>

<style scoped>

</style>
