<template>
    <div class="m-2">
        <contentheader :title="this.heading" :help_menu="true" model_name="dna" :trail="(action.create) ? trail.create : trail.default"
                       :specimen= "(action.create) ? specimen : null"></contentheader>
        <snackbar v-if="snackbar === true" :snackbar_color="snackbar_color" :snackbar_text="snackbar_text" :snackbar="snackbar" @close="snackbar = false"></snackbar>
        <specimen-highlights :specimen="specimen"></specimen-highlights>
      <v-row justify="center">
        <v-col cols="12" md="4" sm="12">
                    <v-text-field
                            v-model="form.sample_number"
                            name="sample_number"
                            label="DNA Sample Number"
                            required
                            :rules="sampleNumRules"
                            placeholder="Example 212A, 1446B">
                    </v-text-field>
                </v-col>
        <v-col cols="12" md="4" sm="12">
                    <v-select
                            v-model="form.lab_id"
                            label="Lab"
                            :rules="labRules"
                            :items="labOptions"
                            placeholder="Select Lab" item-text="name" item-value="id"
                    ></v-select>
                </v-col>
        <v-col cols="12" md="4" sm="12">
                    <v-text-field
                            v-model="form.external_case_id"
                            label="External Case #"
                            placeholder="Example 2004H0114, 20015G1022"
                    ></v-text-field>
                </v-col>
            </v-row>
        <v-row>
            <v-col align="center"
                   justify="center">
                <v-btn title="Save" color="primary" class="mr-2" @click="createDNA()"><v-icon class="mr-2">mdi-content-save</v-icon>Save</v-btn>
            </v-col>
        </v-row>
    </div>
</template>
<script>
    import axios from 'axios';
    import {mapGetters} from "vuex";

    export default {
        name: "CreateDNA",

        props: {
            specimen: {type: Object,default: null},
            heading: { type: String, default: " Create DNA" },
            crud_action: {type: String, default: "Create"},
        },
        data() {
            return{
                trail: {
                    'create': [{text: 'Home', disabled: false, href: '/',},
                        {text: 'Specimen', disabled: false, href: "/skeletalelements/" },
                        {text: 'New DNA', disabled: true, href: "/"},],
                    'default': [{text: 'Home', disabled: false, href: '/',},
                        {text: 'Specimen', disabled: false, href: "/skeletalelements/" },
                        {text: 'New DNA', disabled: true, href: "/dnas/create"},],
                },
                sampleNumRules: [v => !!v || 'A sample number must be speficied'],
                labRules: [v => !!v || 'A sample number must be speficied'],
                form: {},
                snackbar: false,
                snackbar_text:'',
                snackbar_color:'',
            }
        },


        created() {
            console.log("the specimen info",this.specimen);
            console.log("the dnas", this.specimen.dnas === null);

        },

        methods: {
            setDisabledValue() {
                if (this.dna.sample_number && this.dna.external_case_id && this.dna.lab_id) {
                    this.valid = true;
                    return this.valid;
                }
            },

            createDNA() {
                axios.request({
                    url: '/api/dnas',
                    method: 'POST',
                    headers: {
                        'content-Type': 'application/json',
                        'Authorization': this.$store.getters.bearerToken,
                    },
                    data: {
                        org_id: this.theOrg.id,
                        project_id: this.project_id,
                        se_id: this.specimen.id,
                        sb_id: this.specimen.sb_id,
                        sample_number: this.form.sample_number ? this.form.sample_number: null,
                        lab_id:this.form.lab_id ? this.form.lab_id: null,
                        external_case_id: this.form.external_case_id ? this.form.external_case_id: null
                    },
                }).then(response => {
                    // uncomment for debugging
                    this.snackbar=true;
                    this.snackbar_text = 'DNA Created successfully';
                    this.snackbar_color = 'success';
                    let dna_id = response.data.data.id;
                    window.location.assign('/skeletalelements/' + this.specimen.id +'/dnas/' + dna_id)
                    // console.log(succeed.response);
                }).catch(error => {
                    this.snackbar=true;
                    this.snackbar_text = 'Failed to Create DNA. Please recheck your inputs.';
                    this.snackbar_color = 'info';
                    // uncomment for debugging
                    // console.log(error.response);
                })
            },
        },
        computed:{
            ...mapGetters({
                getLabs: 'getLabs',
                project_id: 'theProjectId',
                theOrg: 'theOrg',
            }),
            labOptions () {
                let type = 'Genomics';
                return this.getLabs(type);
            },
            action() {
                const act = this.crud_action;
                return { create: act === "Create", view: act === "View", edit: (act === "Update" || act === "Edit"), list: act === "List", };
            },
            toolbarProps() {
                if (this.action.create || this.action.edit) {
                    return { rese: true, save: {disabled: !this.edited} };
                } else if (this.action.view) {
                    return { edit: true };
                } else {
                    return {};
                }
            },
        }

    }
</script>
