<template>
    <div class="m-2 align-center">
<!--        <contentheader :trail="this.trail" :title="this.heading" :se_action_menu="(!action.create)" model_name="specimen"-->
<!--                       :specimen="(action.create) ? null : specimen" :edit_menu="(action.view)" @eventEdit="edit"-->
<!--                       :reset_menu="(action.edit)" @eventReset="reset" :save_menu="(action.edit || action.create)" @eventSave="save"-->
<!--                       :se_highlights="(!action.create)">-->
<!--        </contentheader>-->
        <contentheader :trail="(action.create) ? trail.create : trail.default" :se_action_menu="(!action.create)" model_name="specimen"
                       :specimen="(action.create) ? null : specimen" :crud_action="action"
                       @eventEdit="edit" @eventReset="reset" @eventSave="save" @eventDelete="trash">
        </contentheader>
        <v-alert v-if="alert" class="my-1" border="left" colored-border type="info" elevation="2" dismissible>{{alertText}}</v-alert>
<!--        <v-row class="my-2">-->
<!--            <v-col class="py-0" md="12">-->
<!--                <specimen-toolbar :expanded="showForm" :title="heading" v-bind="toolbarProps"-->
<!--                                  @expand="expand" @reset="reset" @save="save" @edit="edit" panel>-->
<!--                </specimen-toolbar>-->
<!--            </v-col>-->
<!--        </v-row>-->

        <v-container fluid v-show="showForm">
            <v-row>
                <v-col cols="12" md="3"><Accession :disabled="action.view" v-model="form.accession_number"/></v-col>
                <v-col cols="12" md="3"><Provenance1 :disabled="action.view" v-model="form.provenance1"/></v-col>
                <v-col cols="12" md="3"><Provenance2 :disabled="action.view" v-model="form.provenance2"/></v-col>
                <v-col cols="12" md="3"><Designator :disabled="action.view" v-model="form.designator"/></v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="3"><Bone :disabled="action.view" class_value v-model="form.sb_id" dusk="se-bone"/></v-col>
                <v-col cols="12" md="3"><Side :disabled="action.view" class_value v-model="form.side" dusk="se-side"/></v-col>
                <v-col cols="12" md="3"><Completeness :disabled="action.view" class_value v-model="form.completeness"/></v-col>
            </v-row>

            <template v-if="!action.create">
                <v-row v-if="specimen.sb && specimen.sb.countable">
                    <v-col cols="12" md="3"><count :disabled="action.view" v-model="form.count"/></v-col>
                    <v-col cols="12" md="3"><mass :disabled="action.view" :uom="uom" v-model="form.mass"/></v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="3"><measured :disabled="action.view" v-model="form.measured"/></v-col>
                    <v-col cols="12" md="3"><dnasampled :disabled="action.view" v-model="form.dna_sampled"/></v-col>
                    <v-col cols="12" md="3"><isotopesampled :disabled="action.view" v-model="form.isotope_sampled"/></v-col>
                    <v-col cols="12" md="3" v-if="isClavicle"><clavicletriage :disabled="action.view" v-model="form.clavicle_triage"/></v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="3"><ctscanned :disabled="action.view" v-model="form"/></v-col>
                    <v-col cols="12" md="3"><xrayscanned :disabled="action.view" v-model="form"/></v-col>
                    <v-col cols="12" md="3"><scanned :disabled="action.view" v-model="form"/></v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="3"><inventorycompleted :disabled="action.view" v-model="form"/></v-col>
                    <v-col cols="12" md="3" v-if="!Object.keys(specimen).length && (theUser.id !== specimen.user_id || !specimen.user_id) || isAdminOrOrgAdmin">
                        <reviewed :disabled="action.view" v-model="form"/>
                    </v-col>
                </v-row>
                <v-row><v-col cols="12"><individualnumber :disabled="action.view" v-model="form"/></v-col></v-row>
                <v-row><v-col cols="12"><dental-codes v-if="dentalSpecimen" :disabled="action.view" :crud_action="crud_action" :specimenID="specimen.id"></dental-codes></v-col></v-row>
                <v-row><v-col cols="12"><tags v-if="show_tags" :disabled="action.view" :tag_model="specimen" type="Specimen" :crud_action="crud_action"/></v-col></v-row>
                <v-row><v-col cols="12"><comments v-if="show_comments" :disabled="action.view" :comment_model="specimen" type="Specimen" :crud_action="crud_action"/></v-col></v-row>
                <v-row><v-col cols="12"><audits :specimen_id="specimen.id" :disabled="action.view" :audits_model="specimen" type="Specimen" :crud_action="crud_action"/></v-col></v-row>
            </template>
        </v-container>
    </div>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import {eventBus} from "../../eventBus";
    import axios from 'axios';

    export default {
        props: {
            data: { type: Object, default: () => {} },
            heading: { type: String, default: "Specimen" },
            crud_action: { type: String, default: "View" },
            specimen: { type: Object, default: null },
            list_sb: { type: Object, default: null },
            list_accession: { type: Object, default: null },
            list_provenance1: { type: Object, default: null },
            list_provenance2: { type: Object, default: null },
            list_remains_status: { type: Object, default: null },
            show_tags: { type: Boolean, default: true },
            show_comments: { type: Boolean, default: true },
        },
        data() {
            return {
                loading: false,
                formSubmitssionDisabled: false,
                form: this.getFormData(),
                initialFormData: this.getFormData(),
                showForm: true,
                trail: {
                    'create': [{ text: 'Home', disabled: false, href: '/', },
                            { text: 'Specimen ', disabled: true, href: "/" },
                            { text: 'New', disabled: true, href: "/" }, ],
                    'default': [{ text: 'Home', disabled: false, href: '/', },
                        { text: 'Specimen ', disabled: true, href: (this.specimen) ? '/skeletalelements/'+this.specimen.id : "/" },
                        { text: (this.specimen)?this.specimen.key_bone_side:"", disabled: true, href: "/" }, ],
                },
                alert: false,
                alertText: "",
                isClavicle: (this.specimen.sb_id === 12), // id of Clavicle is 12.
                uom: "grams",
                dentalSpecimen: this.specimen.sb.dental,
            };
        },
        created() {
            console.log('Specimen Component created.');
            this.uom = this.getOrgProfileValueByName("org_mass_unit_of_measure");
        },
        watch: {
            "form.inventoried"(val) {
                if (val && !this.form.inventoried_at) {
                    this.form.inventoried_at = this.getCurrentDate();
                } else {
                    this.form.inventoried_at = this.initialFormData.inventoried_at;
                }
            },
            "form.reviewed"(val) {
                if (val && !this.form.reviewed_at) {
                    this.form.reviewed_at = this.getCurrentDate();
                } else {
                    this.form.reviewed_at = this.initialFormData.reviewed_at;
                }
            },
            "form.ct_scanned"(val) {
                if (val && !this.form.ct_scanned_date) {
                    this.form.ct_scanned_date = this.getCurrentDate();
                } else {
                    this.form.ct_scanned_date = this.initialFormData.ct_scanned_date;
                }
            },
            "form.xray_scanned"(val) {
                if (val && !this.form.xray_scanned_date) {
                    this.form.xray_scanned_date = this.getCurrentDate();
                } else {
                    this.form.xray_scanned_date = this.initialFormData.xray_scanned_date;
                }
            },
            "form.3D_scanned"(val) {
                if (val && !this.form["3D_scanned_date"]) {
                    this.form["3D_scanned_date"] = this.getCurrentDate();
                } else {
                    this.form["3D_scanned_date"] = this.initialFormData["3D_scanned_date"];
                }
            }
        },
        methods: {
            getCurrentDate() {
                const date = new Date();

                return (
                    date.getFullYear() + "-" +
                    ("0" + (date.getMonth() + 1)).slice(-2) + "-" +
                    ("0" + date.getDate()).slice(-2)
                );
            },
            getFormData() {
                return {
                    accession_number: this.specimen.accession_number,
                    provenance1: this.specimen.provenance1,
                    provenance2: this.specimen.provenance2,
                    designator: this.specimen.designator,
                    sb_id: this.specimen.sb_id ? this.specimen.sb_id : null,
                    side: this.specimen.side ? this.specimen.side : 'Left',
                    completeness: this.specimen.completeness ? this.specimen.completeness : 'Complete',
                    count: this.specimen.count,
                    mass: this.specimen.mass,
                    measured: this.specimen.measured,
                    dna_sampled: this.specimen.dna_sampled,
                    isotope_sampled: this.specimen.isotope_sampled,
                    clavicle_triage: this.specimen.clavicle_triage,
                    inventoried: this.specimen.inventoried,
                    inventoried_at: this.specimen.inventoried_at,
                    reviewed: this.specimen.reviewed,
                    reviewed_at: this.specimen.reviewed_at,
                    ct_scanned: this.specimen.ct_scanned,
                    ct_scanned_date: this.specimen.ct_scanned_date,
                    xray_scanned: this.specimen.xray_scanned,
                    xray_scanned_date: this.specimen.xray_scanned_date,
                    "3D_scanned": this.specimen["3D_scanned"],
                    "3D_scanned_date": this.specimen["3D_scanned_date"],
                    individual_number: this.specimen.individual_number,
                    identification_date: this.specimen.identification_date,
                    remains_status: this.specimen.remains_status,
                    remains_release_date: this.specimen.remains_release_date,
                    tags: null,
                };
            },
            expand(val) {
                this.showForm = val;
            },
            reset() {
                this.form = this.getFormData();
            },
            save() {
                axios
                    .request({
                        url: '/api/specimens/' + this.specimen.id,
                        method: 'PUT',
                        headers: {'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken,},
                        data: this.form,
                    })
                    .then(response => {
                        this.loading = false;
                        let status = response.data;
                        console.log(status);
                        console.log("Specimen Update Save: data: " + JSON.stringify(response.data));
                        let payload = {'text': 'Update successful', 'color': 'success',};
                        eventBus.$emit('show-snackbar', payload);
                        if (this.save_and_add) {
                            // Stay on this screen, clear certain/some old data fields
                            this.save_and_add = false;
                        } else {
                            this.se_id = response.data.data.id;
                            window.location.href = '/skeletalelements/' + this.se_id;
                        }
                    }).catch(error => {
                    console.log(error.response);
                    let msg = error.response.data.data.message;
                    this.loading = false;
                    this.save_and_add = false;
                    let payload = {'text': 'Update failed' + "\n" + msg, 'color': 'error', 'multiline': true };
                    eventBus.$emit('show-snackbar', payload);
                })             },
            edit() {
                window.location = `/skeletalelements/${this.specimen.id}/edit`;
            },
            trash() {
                // implement model specimen delete
            },
        },
        computed: {
            ...mapState({
                base_url: state => state.baseURL,
            }),
            ...mapGetters({
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
                bearerToken: 'bearerToken',
                isAdminOrOrgAdmin: 'isAdminOrOrgAdmin',
                getOrgProfileValueByName: 'getOrgProfileValueByName',
            }),
            action() {
                const act = this.crud_action;
                return { create: act === "Create", view: act === "View", edit: (act === "Update" || act === "Edit"), list: act === "List", };
            },
            edited() {
                return JSON.stringify(this.form) !== JSON.stringify(this.initialFormData);
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
        },
    };
</script>
