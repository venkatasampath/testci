<template>
    <div class="col-12 m-2">
        <contentheader :trail="this.trail" model_name="report-austrdna" :reset_menu="true" @eventReset="reset"
                       :collapse_menu="true" @eventCollapse="onExpand(false)" @eventExpand="onExpand(true)"
                       :generate_menu="true" @eventGenerate="generate" :info_toolip="true" :info_toolip_text="options.report_help">
        </contentheader>
        <v-card>
            <v-container fluid v-show="showReportCriteria">
                <anp1p2dn v-model="form" :an="options.accession" :p1="options.provenance1" :p2="options.provenance2"
                          :model-keys="{ an: 'an_select', p1: 'p1_select', p2: 'p2_select',}"/>

                <v-row>
                    <v-col cols="12">
                        <individualnumber v-model="form" individual-number-name="individual_number_select" individual-number-model-key="individual_number_select"
                                          label="Individual Number" :options="options.individual_number" :required="true" :autocomplete="true">
                        </individualnumber>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <boneside v-model="form" :bone="options.bone" :side="options.side" :model-keys="{ bone: 'sb_select', side: 'side_select',}"/>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>

        <v-row v-if="Object.keys(skeletalElements).length">
            <v-col><specimen-individual-report-resut :skeletal-elements="skeletalElements"/></v-col>
        </v-row>
    </div>
</template>

<script>
    import {eventBus} from "../../eventBus";

    export default {
        name: "SpecimenIndividualReport",
        props: {
            title: String,
            formData: { type: Object, default: () => {} },
            options: { type: Object, default: () => {} },
            reportResult: { type: [Array, Object], default: () => [] },
        },
        data() {
            return {
                form: this.formData,
                info: false,
                showReportCriteria: true,
                skeletalElements: this.reportResult.skeletalElements
                    ? this.reportResult.skeletalElements
                    : [],
                trail: [{text: 'Home', disabled: false, href: '/',},
                    {text: 'Reports Dashboard', diasbled: false, href: '/reports/dashboard'},
                    {text: 'Specimens by Individual Number Report', disabled: true, href: '/individualnumber',},
                ],
            };
        },
        methods: {
            reset() {
                this.form = {};
                this.skeletalElements = [];
            },
            onExpand(val) {
                this.showReportCriteria = val;
            },
            generate() {
                eventBus.$emit('generate-loading', true);
                document.getElementById("specimen-individual-report").submit();
            }
        }
    };
</script>
