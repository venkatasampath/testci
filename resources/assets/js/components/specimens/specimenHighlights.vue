<template>
    <div class="mx-2 align-center">
        <v-row>
            <v-col lg="4" cols="sm" class="p-2">
                <v-card dusk="specimenhighlight-review">
                    <v-row class="no-gutters">
                        <div class="col-auto"><div class="primary fill-height">&nbsp;</div></div>
                        <div class="col pl-2 primary--text"><v-icon title="Composite Key, Bone and Side" class="pr-2">mdi-key</v-icon>{{seKeyBoneSide}}</div>
                    </v-row>
                </v-card>
            </v-col>
            <v-col lg="2" cols="sm" class="p-2">
                <v-card>
                    <v-row class="no-gutters">
                        <div class="col-auto"><div :class="(specimen.dna_sampled) ? 'success fill-height':'error fill-height'">&nbsp;</div></div>
                        <div class="col pl-2">
                            <v-icon title="DNA Sampled" class="pr-2 float-left">mdi-dna</v-icon>
                            <v-icon title="DNA Sampled" color="success" v-if="specimen.dna_sampled" class="pr-2 float-left">mdi-check</v-icon>
                            <v-badge :title="'Mito Seq #: '+ specimen.mito_sequence_number" v-if="specimen.mito_sequence_number" :content="specimen.mito_sequence_number"></v-badge>
                            <v-icon title="DNA Sampled" color="error" v-if="!specimen.dna_sampled" class="pr-2 float-left">mdi-close</v-icon>
                        </div>
                        <div class="col pr-2">
                            <v-icon title="Isotope Sampled" class="pl-2 float-right">mdi-radioactive</v-icon>
                            <v-icon title="Isotope Sampled" color="success" v-if="specimen.isotope_sampled" class="float-right">mdi-check</v-icon>
                            <v-icon title="Isotope Sampled" color="error" v-if="!specimen.isotope_sampled" class="float-right">mdi-close</v-icon>
                        </div>
                        <div class="col-auto"><div :class="(specimen.isotope_sampled) ? 'success fill-height':'error fill-height'">&nbsp;</div></div>
                    </v-row>
                </v-card>
            </v-col>
            <v-col lg="2" cols="sm" class="p-2">
                <v-card height="48px;">
                    <v-row class="no-gutters">
                        <div class="col-auto"><div :class="(specimen.measured) ? 'success fill-height':'error fill-height'">&nbsp;</div></div>
                        <div class="col pl-2">
                            <v-icon title="Measured" class="pr-2 float-left">mdi-ruler-square</v-icon>
                            <v-icon title="Measured" color="success" v-if="specimen.measured" class="float-left">mdi-check</v-icon>
                            <v-icon title="Measured" color="error" v-if="!specimen.measured" class="float-left">mdi-close</v-icon>
                        </div>
                        <div class="col pr-2">
                            <v-icon title="Completeness" class="pl-2 float-right">mdi-bone</v-icon>
                            <v-icon title="Completeness" color="success" v-if="specimen.completeness === 'Complete'" class="float-right">mdi-check</v-icon>
                            <v-icon title="Completeness" color="error" v-if="specimen.completeness !== 'Complete'" class="float-right">mdi-close</v-icon>
                        </div>
                        <div class="col-auto"><div :class="(specimen.completeness === 'Complete') ? 'success fill-height':'error fill-height'">&nbsp;</div></div>
                    </v-row>
                </v-card>
            </v-col>
            <v-col lg="2" cols="sm" class="p-2">
                <v-card>
                    <v-row class="no-gutters">
                        <div class="col-auto"><div :class="(specimen.xray_scanned) ? 'success fill-height':'error fill-height'">&nbsp;</div></div>
                        <div class="col pl-2">
                            <v-icon :title="(specimen.xray_scanned)?'Xray: '+specimen.xray_scanned_date:'No Xray'" class="pr-2 float-left">mdi-radiology-box</v-icon>
                            <v-icon :title="(specimen.xray_scanned)?'Xray: '+specimen.xray_scanned_date:'No Xray'" color="success" v-if="specimen.xray_scanned" class="float-left">mdi-check</v-icon>
                            <v-icon :title="(specimen.xray_scanned)?'Xray: '+specimen.xray_scanned_date:'No Xray'" color="error" v-if="!specimen.xray_scanned" class="float-left">mdi-close</v-icon>
                        </div>
<!--                        <div class="col pr-2">-->
<!--                            <v-icon :title="(scan_3d)?'3D scan: '+scan_3d_date:'No 3D scan'" :color="scan_3d?'success':'error'" class="pl-2 float-right">mdi-laser-pointer</v-icon>-->
<!--                            <v-icon :title="(scan_3d)?'3D scan: '+scan_3d_date:'No 3D scan'" color="success" v-if="scan_3d" class="float-right">mdi-check</v-icon>-->
<!--                            <v-icon :title="(scan_3d)?'3D scan: '+scan_3d_date:'No 3D scan'" color="error" v-if="!scan_3d" class="float-right">mdi-close</v-icon>-->
<!--                        </div>-->
                        <div class="col pr-2">
                            <v-icon :title="(specimen.ct_scanned)?'CT scan: '+specimen.ct_scanned_date:'No CT scan'" class="pl-2 float-right">mdi-skull-scan</v-icon>
                            <v-icon :title="(specimen.ct_scanned)?'CT scan: '+specimen.ct_scanned_date:'No CT scan'" color="success" v-if="specimen.ct_scanned" class="float-right">mdi-check</v-icon>
                            <v-icon :title="(specimen.ct_scanned)?'CT scan: '+specimen.ct_scanned_date:'No CT scan'" color="error" v-if="!specimen.ct_scanned" class="float-right">mdi-close</v-icon>
                        </div>
                        <div class="col-auto"><div :class="(specimen.ct_scanned) ? 'success fill-height':'error fill-height'">&nbsp;</div></div>
                    </v-row>
                </v-card>
            </v-col>
            <v-col lg="2" cols="sm" class="p-2">
                <v-card>
                    <v-row class="no-gutters">
                        <div class="col-auto"><div :class="(specimen.inventoried) ? 'success fill-height':'error fill-height'">&nbsp;</div></div>
                        <div class="col pl-2">
                            <v-icon :title="(specimen.inventoried)? 'Inventoried: '+specimen.inventoried_at:'Not Inventoried'" class="pr-2 float-left">mdi-clipboard-text</v-icon>
                            <v-icon :title="(specimen.inventoried)? 'Inventoried: '+specimen.inventoried_at:'Not Inventoried'" color="success" v-if="specimen.inventoried" class="float-left">mdi-check</v-icon>
                            <v-icon :title="(specimen.inventoried)? 'Inventoried: '+specimen.inventoried_at:'Not Inventoried'" color="error" v-if="!specimen.inventoried" class="float-left">mdi-close</v-icon>
                        </div>
                        <div class="col pr-2">
                            <v-icon :title="(specimen.reviewed)?'Reviewed: '+specimen.reviewed_at:'Not Reviewed'" class="pl-2 float-right">mdi-eye-check</v-icon>
                            <v-icon :title="(specimen.reviewed)?'Reviewed: '+specimen.reviewed_at:'Not Reviewed'" color="success" v-if="specimen.reviewed" class="float-right">mdi-check</v-icon>
                            <v-icon :title="(specimen.reviewed)?'Reviewed: '+specimen.reviewed_at:'Not Reviewed'" color="error" v-if="!specimen.reviewed" class="float-right">mdi-close</v-icon>
                        </div>
                        <div class="col-auto"><div :class="(specimen.reviewed) ? 'success fill-height':'error fill-height'">&nbsp;</div></div>
                    </v-row>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>

<script>
    import {mapGetters, mapState} from "vuex";

    export default {
        props: {
            specimen: { type: Object, required: true },
        },
        data() {
            return {
                seKey: "",
                seBoneSide: "",
                seKeyBoneSide: "",
                show_highlights: true,
                scan_3d: this.specimen["3D_scanned"],
                scan_3d_date: this.specimen["3D_scanned_date"],
            };
        },
        created() {
            console.log('Specimen Component created.');
            this.seKey = this.specimen.accession_number + ":" + this.specimen.provenance1 + ":" +
                this.specimen.provenance1 + ":" + this.specimen.designator;
            this.seKeyBoneSide = this.seKey + " :: " + this.specimen.sb.name + ":" + this.specimen.side;
            this.seBoneSide = this.specimen.sb.name + ":" + this.specimen.side;
        },
        computed: {
            ...mapState({
                //
            }),
            ...mapGetters({
                theUser: 'theUser',
            }),
        },
    };
</script>
