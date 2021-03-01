<template>
    <div id="isotope-table">
        <v-card>
            <v-toolbar flat>
                <v-spacer></v-spacer>
                <v-dialog v-model="newIsotopeDialog" max-width="60%">
                    <template v-slot:activator="{ on }">
                        <v-btn color="primary" dark class="mb-2" v-on="on" @click="resetEditDialog()">Create New</v-btn>
                    </template>
                    <!--                    Creating New Isotope-->
                    <v-card>
                        <div id="newIsotopeInformation">
                            <v-toolbar dark color="primary">
                                <v-btn icon dark @click="newIsotopeDialog = false">
                                    <v-icon>mdi-close</v-icon>
                                </v-btn>
                                <v-toolbar-title>New Isotope</v-toolbar-title>
                                <v-spacer></v-spacer>
                            </v-toolbar>
                            <v-form v-model="saveNewIstopeForm" ref="newIsotopeForm">
                                <v-row cols="12" md="12">
                                    <isotopevautocomplete
                                            :options="laboptions"
                                            :componentname="'lab_id'"
                                            :componentlabel="'Lab:'"
                                            :componentrequired="true"
                                            :componentvmodel="isotopelabvmodelgpc"
                                            :flex_cols_md="3"
                                            :flex_cols_sm="12"
                                            :buseventname="'labVModelChange'"
                                            :componentrule="[v => !!v || 'Lab is a required field']"
                                    ></isotopevautocomplete>
                                    <isotopetextfield
                                            :disabled="false"
                                            :componentclearable="true"
                                            :componentplaceholder="placeholder_external_id"
                                            :componentlabel="externalcasenumberlabel"
                                            :componentdusk="'dna-external_case'"
                                            :componentvmodel="isotopecasenumbervmodel"
                                            :componentname="'external_case_id'"
                                            :flex_cols_md="3"
                                            :flex_cols_sm="12"
                                            :buseventname="'caseNumberVModelChange'"
                                            :rules="[v => (v || '').indexOf(' ') < 0 || 'No spaces are allowed']"
                                    ></isotopetextfield>
                                    <isotopesamplenumber
                                            :componentlabel="'Isotope Sample Number:'"
                                            :componentplaceholder="placeholder_external_id"
                                            :isotopesamplenumbervmodel="isotopesamplenumbervmodel"
                                            :isotopesamplenumbername="'sample_number'"
                                            :disabled="false"
                                            :flex_cols_md="3"
                                            :flex_cols_sm="12"
                                            :buseventname="'sampleNumberVModelChange'"
                                    ></isotopesamplenumber>
                                </v-row>
                            </v-form>
                        </div>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" text @click="newIsotopeDialog = false">Close</v-btn>
                            <v-btn color="blue darken-1" text @click="postNewIsotope();" :disabled="!saveNewIstopeForm">
                                Save
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-toolbar>
            <!--            Editing Exsisting Isotope-->
            <v-dialog v-model="editIsotopeComponent" fullscreen hide-overlay transition="dialog-bottom-transition"
                      ref="editIsotopeForm">
                <v-card>
                    <v-toolbar dark color="primary">
                        <v-btn icon dark @click="editIsotopeComponent = false; editAble = true; getIsotopeTableData();">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                        <v-toolbar-title>Edit Isotope</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-toolbar-items>
                            <v-btn dark text @click="editAble = !editAble">Edit</v-btn>
                            <v-btn dark text @click="postAll(); editAble = true" :disabled="editAble">
                                Save All
                            </v-btn>
                        </v-toolbar-items>
                    </v-toolbar>
                    <v-skeleton-loader
                            :loading="isotopeDataloading"
                            type="list-item-three-line"
                    >
                        <v-container>
                            <v-card flat>
                                <div id="IsotopeInformation">
                                    <v-row cols="12" md="12">
                                        <isotopevautocomplete
                                                :options="laboptions"
                                                :disabled="editAble"
                                                :componentname="'lab_id'"
                                                :componentlabel="'Lab:'"
                                                :componentrequired="true"
                                                :componentvmodel="isotopelabvmodelgpc"
                                                :flex_cols_md="3"
                                                :flex_cols_sm="12"
                                                :buseventname="'labVModelChange'"
                                                :rules="[v => !!v || 'Lab Value is required']"
                                        ></isotopevautocomplete>
                                        <isotopetextfield
                                                :disabled="editAble"
                                                :componentclearable="true"
                                                :componentplaceholder="placeholder_external_id"
                                                :componentlabel="externalcasenumberlabel"
                                                :componentdusk="'dna-external_case'"
                                                :componentvmodel="isotopecasenumbervmodel"
                                                :componentname="'external_case_id'"
                                                :flex_cols_md="3"
                                                :flex_cols_sm="12"
                                                :buseventname="'caseNumberVModelChange'"
                                                :rules="[v => (v || '').indexOf(' ') < 0 || 'No spaces are allowed']"
                                        ></isotopetextfield>
                                        <isotopesamplenumber
                                                :componentlabel="'Isotope Sample Number:'"
                                                :componentplaceholder="placeholder_external_id"
                                                :isotopesamplenumbervmodel="isotopesamplenumbervmodel"
                                                :isotopesamplenumbername="'sample_number'"
                                                :disabled="true"
                                                :flex_cols_md="3"
                                                :flex_cols_sm="12"
                                                :buseventname="'sampleNumberVModelChange'"
                                        ></isotopesamplenumber>
                                    </v-row>
                                </div>
                            </v-card>
                            <v-btn color="primary" @click="postIsotopeInformation()">Save</v-btn>
                        </v-container>
                        <v-spacer></v-spacer>
                        <v-stepper v-model="e6">
                            <v-stepper-step editable step="1">
                                <v-badge
                                        bordered
                                        color="blue-grey"
                                        :content="basicInfoCounter"
                                        inline
                                >
                                    Basic Information
                                </v-badge>
                            </v-stepper-step>
                            <v-stepper-content step="1">
                                <v-card flat>
                                    <div id="IsotopeBasicInformation">
                                        <v-row cols="12" md="12" class="mb-6">
                                            <isotopevautocomplete
                                                    :disabled="editAble"
                                                    :componentlabel="isotopebatchlabel"
                                                    :options="isotopebatchoptions"
                                                    :componentdusk="'dna-batch_id'"
                                                    :componentvmodel="isotopebatchoptionsvmodel"
                                                    :componentname="'batch_id'"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                                    :buseventname="'isotopeBatch'"
                                            ></isotopevautocomplete>
                                            <isotopevautocomplete
                                                    :disabled="editAble"
                                                    :componentlabel="labels_results_status"
                                                    :options="list_confidence"
                                                    :componentdusk="'isotope-results_confidence'"
                                                    :componentvmodel="resultsstatusoptionsvmodel"
                                                    :componentname="'results_confidence'"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                                    :buseventname="'isotopeResultsStatus'"
                                            ></isotopevautocomplete>
                                            <isotopetextfield
                                                    :disabled="editAble"
                                                    :componentclearable="true"
                                                    :componentplaceholder="placeholder_mass"
                                                    :componentlabel="'Weight Sample Cleaned:'"
                                                    :componentdusk="'se-mass'"
                                                    :componentsuffix="org_mass_unit_of_measure"
                                                    :componenttype="masstype"
                                                    :componentvmodel="weightsampledcleanedtypevmode"
                                                    :componentname="'weight_sample_cleaned'"
                                                    :buseventname="'isotopeWeightSampleCleaned'"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                            ></isotopetextfield>
                                            <isotopetextfield
                                                    :disabled="true"
                                                    :componentclearable="true"
                                                    :componentplaceholder="'mm/dd/yyy'"
                                                    :componentid="'demineralizingStartDate'"
                                                    :componentlabel="'Demineralizing Start Date:'"
                                                    :componentdusk="'dna-demineralizing_start_date'"
                                                    :componentname="'demineralizing_start_date'"
                                                    :componentvmodel="demineralizingStartDateVmodel"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                            ></isotopetextfield>
                                            <isotopetextfield
                                                    :disabled="true"
                                                    :componentclearable="true"
                                                    :componentplaceholder="'mm/dd/yyy'"
                                                    :componentid="'demineralizingEndtDate'"
                                                    :componentlabel="'Demineralizing End Date:'"
                                                    :componentdusk="'dna-demineralizing_end_date'"
                                                    :componentname="'demineralizing_end_date'"
                                                    :componentvmodel="demineralizingEndDateVmodel"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                            ></isotopetextfield>
                                        </v-row>
                                    </div>
                                </v-card>
                                <v-btn color="primary" @click="postBasicInformation(); basicInformationCounter()">Save
                                </v-btn>
                                <v-btn @click="e6 = 2">Next</v-btn>
                            </v-stepper-content>
                            <v-stepper-step editable :complete="e6 > 2" step="2">
                                <v-badge
                                        bordered
                                        color="blue-grey"
                                        :content="weightInfoCounter"
                                        inline
                                >
                                    Weight Information
                                </v-badge>
                            </v-stepper-step>
                            <v-stepper-content step="2">
                                <v-card flat>
                                    <div id="IsotopeWeightInformation">
                                        <v-row cols="12" md="12" class="mb-6">
                                            <isotopetextfield
                                                    :disabled="editAble"
                                                    :componentclearable="true"
                                                    :componentplaceholder="placeholder_mass"
                                                    :componentid="'weightVialnLid'"
                                                    :componentlabel="'Weight Vial and Lid:'"
                                                    :componentdusk="'se-mass'"
                                                    :componentsuffix="org_mass_unit_of_measure"
                                                    :componenttype="masstype"
                                                    :componentvmodel="weightvialnlidvmode"
                                                    :componentname="'weight_vial_lid'"
                                                    :buseventname="'isotopeWeightVialnLid'"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                            ></isotopetextfield>
                                            <isotopetextfield
                                                    :disabled="editAble"
                                                    :componentclearable="true"
                                                    :componentplaceholder="placeholder_mass"
                                                    :componentid="'weightCollagen'"
                                                    :componentlabel="'Weight Collagen:'"
                                                    :componentdusk="'se-mass'"
                                                    :componentsuffix="org_mass_unit_of_measure"
                                                    :componenttype="masstype"
                                                    :componentvmodel="weightcollagenvmode"
                                                    :componentname="'weight_collagen'"
                                                    :buseventname="'isotopeWeightCollagen'"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                            ></isotopetextfield>
                                            <isotopetextfield
                                                    :disabled="editAble"
                                                    :componentclearable="true"
                                                    :componentplaceholder="placeholder_mass"
                                                    :componentid="'weightSampleVialnLid'"
                                                    :componentlabel="'Weight Sample, Vial and Lid:'"
                                                    :componentdusk="'se-mass'"
                                                    :componentsuffix="org_mass_unit_of_measure"
                                                    :componenttype="masstype"
                                                    :componentvmodel="weightsamplevialnlidvmode"
                                                    :componentname="'weight_sample_vial_lid'"
                                                    :buseventname="'isotopeWeightSampleVialnLid'"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                            ></isotopetextfield>
                                            <isotopetextfield
                                                    :disabled="editAble"
                                                    :componentclearable="true"
                                                    :componentplaceholder="placeholder_mass"
                                                    :componentid="'yieldCollagen'"
                                                    :componentlabel="'Yield Collagen:'"
                                                    :componentdusk="'se-mass'"
                                                    :componentsuffix="percentagesuffix"
                                                    :componenttype="masstype"
                                                    :componentvmodel="yieldcollagenvmode"
                                                    :componentname="'yield_collagen'"
                                                    :buseventname="'isotopeYieldCollagen'"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                            ></isotopetextfield>
                                        </v-row>
                                    </div>
                                </v-card>
                                <v-btn color="primary" @click="postWeightInformation(); weightInformationCounter">Save
                                </v-btn>
                                <v-btn @click="e6 = 3">Next</v-btn>
                            </v-stepper-content>
                            <v-stepper-step editable :complete="e6 > 3" step="3">
                                <v-badge
                                        bordered
                                        color="blue-grey"
                                        :content="analysisInfoCounter"
                                        inline
                                >
                                    Analysis Information
                                </v-badge>
                            </v-stepper-step>
                            <v-stepper-content step="3">
                                <v-card flat>
                                    <div id="IsotopeAnalysisInformation">
                                        <v-row cols="12" md="12" class="mb-6">
                                            <isotopetextfield
                                                    :disabled="editAble"
                                                    :componentclearable="true"
                                                    :componentplaceholder="placeholder_mass"
                                                    :componentid="'collagenWeightUsedforAnalysis'"
                                                    :componentlabel="'Collagen Weight used for Analysis:'"
                                                    :componentdusk="'se-mass'"
                                                    :componentsuffix="'mg'"
                                                    :componenttype="masstype"
                                                    :componentname="'collagen_weight_used_for_analysis'"
                                                    :componentvmodel="collagenweightusedforanalysisvmodel"
                                                    :buseventname="'isotopeWeightUsedforAnalysis'"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                            ></isotopetextfield>
                                            <isotopetextfield
                                                    :disabled="editAble"
                                                    :componentclearable="true"
                                                    :componentplaceholder="placeholder_external_id"
                                                    :componentid="'analysisRequested'"
                                                    :componentlabel="'Analysis Requested:'"
                                                    :componentdusk="'dna-external_case'"
                                                    :componenttype="masstype"
                                                    :componentname="'analysis_requested'"
                                                    :componentvmodel="analysisrequestedvmodel"
                                                    :buseventname="'isotopeAnalysisRequest'"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                            ></isotopetextfield>
                                            <isotopetextfield
                                                    :disabled="editAble"
                                                    :componentclearable="true"
                                                    :componentplaceholder="placeholder_external_id"
                                                    :componentid="'wellLocation'"
                                                    :componentlabel="'Well Location:'"
                                                    :componentdusk="'dna-external_case'"
                                                    :componenttype="masstype"
                                                    :componentname="'well_location'"
                                                    :componentvmodel="welllocationvmodel"
                                                    :buseventname="'isotopeWellLocation'"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                            ></isotopetextfield>
                                        </v-row>
                                    </div>
                                </v-card>
                                <v-btn color="primary" @click="postAnalysisInformation(); analysisInformationCounter">
                                    Save
                                </v-btn>
                                <v-btn @click="e6 = 4">Next</v-btn>
                            </v-stepper-content>
                            <v-stepper-step editable :complete="e6 > 4" step="4">
                                <v-badge
                                        bordered
                                        color="blue-grey"
                                        :content="carbonInfoCounter"
                                        inline
                                >
                                    Carbon Information
                                </v-badge>
                            </v-stepper-step>
                            <v-stepper-content step="4">
                                <v-card flat>
                                    <div id="IsotopeCarbonInformation">
                                        <v-row cols="12" md="12" class="mb-4">
                                            <isotopetextfield
                                                    :disabled="editAble"
                                                    :componentclearable="true"
                                                    :componentplaceholder="placeholder_mass"
                                                    :componentid="'carbonDelta'"
                                                    :componentlabel="'Carbon Delta:'"
                                                    :componentdusk="'se-mass'"
                                                    :componentsuffix="ugsuffix"
                                                    :componenttype="masstype"
                                                    :componentvmodel="carbondeltavmodel"
                                                    :componentname="'c_delta'"
                                                    :buseventname="'isotopeCarbonDelta'"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                            ></isotopetextfield>
                                            <isotopetextfield
                                                    :disabled="editAble"
                                                    :componentclearable="true"
                                                    :componentplaceholder="placeholder_mass"
                                                    :componentid="'carbonWeight'"
                                                    :componentlabel="'Carbon Weight:'"
                                                    :componentdusk="'se-mass'"
                                                    :componentsuffix="ugsuffix"
                                                    :componenttype="masstype"
                                                    :componentvmodel="carbonweightvmodel"
                                                    :componentname="'c_weight'"
                                                    :buseventname="'isotopeCarbonWeight'"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                            ></isotopetextfield>
                                            <isotopetextfield
                                                    :disabled="editAble"
                                                    :componentclearable="true"
                                                    :componentplaceholder="placeholder_mass"
                                                    :componentid="'carbonPercentage'"
                                                    :componentlabel="'Carbon Percentage:'"
                                                    :componentdusk="'se-mass'"
                                                    :componentsuffix="percentagesuffix"
                                                    :componenttype="masstype"
                                                    :componentvmodel="carbonpercentagevmodel"
                                                    :componentname="'c_percent'"
                                                    :buseventname="'isotopeCarbonPercentage'"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                            ></isotopetextfield>
                                        </v-row>
                                    </div>
                                </v-card>
                                <v-btn color="primary" @click="postCarbonInformation(); carbonInformationCounter">Save
                                </v-btn>
                                <v-btn @click="e6 = 5">Next</v-btn>
                            </v-stepper-content>
                            <v-stepper-step editable :complete="e6 > 5" step="5">
                                <v-badge
                                        bordered
                                        color="blue-grey"
                                        :content="nitrogenInfoCounter"
                                        inline
                                >
                                    Nitrogen Information
                                </v-badge>
                            </v-stepper-step>
                            <v-stepper-content step="5">
                                <v-card flat>
                                    <div id="IsotopeNitrogenInformation">
                                        <v-row cols="12" md="12" class="ma-3">
                                            <isotopetextfield
                                                    :disabled="editAble"
                                                    :componentclearable="true"
                                                    :componentplaceholder="placeholder_mass"
                                                    :componentid="'nitrogenDelta'"
                                                    :componentlabel="'Nitrogen Delta:'"
                                                    :componentdusk="'se-mass'"
                                                    :componentsuffix="ugsuffix"
                                                    :componenttype="masstype"
                                                    :componentname="'n_delta'"
                                                    :componentvmodel="nitrogendeltavmodel"
                                                    :buseventname="'isotopeNitrogenDelta'"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                            ></isotopetextfield>
                                            <isotopetextfield
                                                    :disabled="editAble"
                                                    :componentclearable="true"
                                                    :componentplaceholder="placeholder_mass"
                                                    :componentid="'nitrogenWeight'"
                                                    :componentlabel="'Nitrogen Weight:'"
                                                    :componentdusk="'se-mass'"
                                                    :componentsuffix="ugsuffix"
                                                    :componenttype="masstype"
                                                    :componentname="'n_weight'"
                                                    :componentvmodel="nitrogenweightvmodel"
                                                    :buseventname="'isotopeNitrogenWeight'"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                            ></isotopetextfield>
                                            <isotopetextfield
                                                    :disabled="editAble"
                                                    :componentclearable="true"
                                                    :componentplaceholder="placeholder_mass"
                                                    :componentid="'nitrogenPercentage'"
                                                    :componentlabel="'Nitrogen Percentage:'"
                                                    :componentdusk="'se-mass'"
                                                    :componentsuffix="percentagesuffix"
                                                    :componenttype="masstype"
                                                    :componentname="'n_percent'"
                                                    :componentvmodel="nitrogenpercentagevmodel"
                                                    :buseventname="'isotopeNitrogenPercentage'"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                            ></isotopetextfield>
                                            <isotopetextfield
                                                    :disabled="editAble"
                                                    :componentclearable="true"
                                                    :componentplaceholder="placeholder_mass"
                                                    :componentid="'carbonNitrogenRatio'"
                                                    :componentlabel="'Carbon/Nitrogen Ratio:'"
                                                    :componentdusk="'se-mass'"
                                                    :componentsuffix="percentagesuffix"
                                                    :componenttype="masstype"
                                                    :componentname="'c_to_n_ratio'"
                                                    :componentvmodel="carbonnitrogenratiovmodel"
                                                    :buseventname="'isotopeCarbontoNitrogenPercentage'"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                            ></isotopetextfield>
                                        </v-row>
                                    </div>
                                </v-card>
                                <v-btn color="primary" @click="postNitrogenInformation(); nitrogenInformationCounter()">
                                    Save
                                </v-btn>
                                <v-btn @click="e6 = 6">Next</v-btn>
                            </v-stepper-content>
                            <v-stepper-step editable :complete="e6 > 6" step="6">
                                <v-badge
                                        bordered
                                        color="blue-grey"
                                        :content="oxygenInfoCounter"
                                        inline
                                >
                                    Oxygen Information
                                </v-badge>
                            </v-stepper-step>
                            <v-stepper-content step="6">
                                <v-card flat>
                                    <div id="IsotopeOxygenInformation">
                                        <v-row cols="12" md="12" class="mb-6">
                                            <isotopetextfield
                                                    :disabled="editAble"
                                                    :componentclearable="true"
                                                    :componentplaceholder="placeholder_mass"
                                                    :componentid="'oxygenDelta'"
                                                    :componentlabel="'Oxygen Delta:'"
                                                    :componentdusk="'se-mass'"
                                                    :componentsuffix="ugsuffix"
                                                    :componenttype="masstype"
                                                    :componentvmodel="oxygendeltavmodel"
                                                    :componentname="'o_delta'"
                                                    :buseventname="'isotopeOxygenDelta'"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                            ></isotopetextfield>
                                            <isotopetextfield
                                                    :disabled="editAble"
                                                    :componentclearable="true"
                                                    :componentplaceholder="placeholder_mass"
                                                    :componentid="'oxygenWeight'"
                                                    :componentlabel="'Oxygen Weight:'"
                                                    :componentdusk="'se-mass'"
                                                    :componentsuffix="ugsuffix"
                                                    :componenttype="masstype"
                                                    :componentvmodel="oxygenweightvmodel"
                                                    :componentname="'o_weight'"
                                                    :buseventname="'isotopeOxygenWeight'"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                            ></isotopetextfield>
                                            <isotopetextfield
                                                    :disabled="editAble"
                                                    :componentclearable="true"
                                                    :componentplaceholder="placeholder_mass"
                                                    :componentid="'oxygenPercentage'"
                                                    :componentlabel="'Oxygen Percentage:'"
                                                    :componentdusk="'se-mass'"
                                                    :componentsuffix="percentagesuffix"
                                                    :componenttype="masstype"
                                                    :componentvmodel="oxygenpercentagevmodel"
                                                    :componentname="'o_percent'"
                                                    :buseventname="'isotopeOxygenPercentage'"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                            ></isotopetextfield>
                                            <isotopetextfield
                                                    :disabled="editAble"
                                                    :componentclearable="true"
                                                    :componentplaceholder="placeholder_mass"
                                                    :componentid="'carbonOxygenRatio'"
                                                    :componentlabel="'Carbon/Oxygen Ratio:'"
                                                    :componentdusk="'se-mass'"
                                                    :componentsuffix="percentagesuffix"
                                                    :componenttype="masstype"
                                                    :componentvmodel="carbonoxygenratiovmodel"
                                                    :componentname="'c_to_o_ratio'"
                                                    :buseventname="'isotopeCarbontoOxygenPercentage'"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                            ></isotopetextfield>
                                        </v-row>
                                    </div>
                                </v-card>
                                <v-btn color="primary" @click="postOxygenInformation(); oxygenInformationCounter()">
                                    Save
                                </v-btn>
                                <v-btn @click="e6 = 7">Next</v-btn>
                            </v-stepper-content>
                            <v-stepper-step editable :complete="e6 > 7" step="7">
                                <v-badge
                                        bordered
                                        color="blue-grey"
                                        :content="sulphurInfoCounter"
                                        inline
                                >
                                    Sulphur Information
                                </v-badge>
                            </v-stepper-step>
                            <v-stepper-content step="7">
                                <v-card flat>
                                    <div id="IsotopeSulphurInformation">
                                        <v-row cols="12" md="12" class="mb-6">
                                            <isotopetextfield
                                                    :disabled="editAble"
                                                    :componentclearable="true"
                                                    :componentplaceholder="placeholder_mass"
                                                    :componentid="'sulpherDelta'"
                                                    :componentlabel="'Sulphur Delta:'"
                                                    :componentdusk="'se-mass'"
                                                    :componentsuffix="ugsuffix"
                                                    :componenttype="masstype"
                                                    :componentname="'s_delta'"
                                                    :componentvmodel="sulpherdeltavmodel"
                                                    :buseventname="'isotopeSulpherDelta'"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                            ></isotopetextfield>
                                            <isotopetextfield
                                                    :disabled="editAble"
                                                    :componentclearable="true"
                                                    :componentplaceholder="placeholder_mass"
                                                    :componentid="'sulpherWeight'"
                                                    :componentlabel="'Sulphur Weight:'"
                                                    :componentdusk="'se-mass'"
                                                    :componentsuffix="ugsuffix"
                                                    :componenttype="masstype"
                                                    :componentname="'s_weight'"
                                                    :componentvmodel="sulpherweightvmodel"
                                                    :buseventname="'isotopeSulpherWeight'"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                            ></isotopetextfield>
                                            <isotopetextfield
                                                    :disabled="editAble"
                                                    :componentclearable="true"
                                                    :componentplaceholder="placeholder_mass"
                                                    :componentid="'sulpherPercentage'"
                                                    :componentlabel="'Sulphur Percentage:'"
                                                    :componentdusk="'se-mass'"
                                                    :componentsuffix="percentagesuffix"
                                                    :componenttype="masstype"
                                                    :componentname="'s_percent'"
                                                    :componentvmodel="sulpherpercentagevmodel"
                                                    :buseventname="'isotopeSulpherPercentage'"
                                                    :flex_cols_md="3"
                                                    :flex_cols_sm="12"
                                            ></isotopetextfield>
                                        </v-row>
                                    </div>
                                </v-card>
                                <v-btn color="primary" @click="postSulphurInformation(); sulphurInformationCounter()">
                                    Save
                                </v-btn>
                                <v-btn @click="e6 = 1">Next</v-btn>
                            </v-stepper-content>
                        </v-stepper>
                    </v-skeleton-loader>
                    <snackbar :snackbar_color="'success'" :snackbar_text="'Isotope Updated Sucessfully'"
                              :snackbar="snackbarUpdate" @close="snackbarUpdate = false"></snackbar>
                </v-card>
            </v-dialog>

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
                <v-spacer></v-spacer>
                <v-col cols="3">
                    <v-text-field
                            v-model="search"
                            label="Search"
                            single-line
                            hide-details
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-data-table
                    :headers="columnVisibility"
                    :items="options"
                    :item-per-page="10"
                    sort-by="sample_number"
                    class="elevation-1"
                    :search="search"
                    :loading="isLoading"
            >
                <template v-slot:item.sample_number="{ item }">
                    <a href="#" @click="editItem(item); isotopeDataloading = true; getIsotopeData()"> {{
                        item.sample_number }}</a>
                </template>
            </v-data-table>
            <snackbar :snackbar_color="'success'" :snackbar_text="'Isotope Saved Sucessfully'" :snackbar="snackbarNew"
                      @close="snackbarNew = false"></snackbar>
        </v-card>
    </div>
</template>

<script>
    import {apiGetCallAxios, bus} from "../../../coraBaseModules";
    import Lab from "./Lab";
    import IsotopeSampleNumber from "./IsotopeSampleNumber";
    import IsotopeTextField from "../commonvuetifycomponents/IsotopeTextField";
    import axios from "axios";
    import {mapGetters, mapState} from "vuex";

    export default {
        name: 'isotopeTable',
        props: {
            //API Related Data
            base_url: null,
            specimen_id: null,
            org_id: String,
            project_id: String,
            sb_id: String,
            se_id: String,
            isotopeid: '',
            //Isotope Information
            laboptions: Object,
            externalcasenumberlabel: String,
            placeholder_external_id: String,
            list_lab: Object,
            external_case_number_label: String,
            placeholder_sampleNumber: String,
            labels_isotope_batches: String,
            org_mass_unit_of_measure: String,
            placeholder_mass: String,
            //Isotope Batch Information
            isotopebatchlabel: String,
            isotopebatchoptions: Object,
            list_confidence: Object,
            labels_results_status: String,
        },
        data: () => ({
            search: '',
            options: [],
            headers: [
                {text: 'Sample Number', value: 'sample_number', width: '6rem', visibility: true},
                {text: 'External Case ID', value: 'external_case_id', width: '6rem', visibility: true},
                {text: 'WeightSample Cleaned', value: 'weight_sample_cleaned', width: '6rem', visibility: true},
                {text: 'Yeild Collagen', value: 'yeild_collagen', width: '6rem', visibility: true},
                {text: 'Weight Vial Lid', value: 'weight_vial_lid', width: '6rem', visibility: true},
                {text: 'Created By', value: 'created_by', width: '6rem', visibility: false},
                {text: 'Created At', value: 'created_at', width: '6rem', visibility: false},
                {text: 'Updated By', value: 'updated_by', width: '6rem', visibility: false},
                {text: 'Updated At', value: 'updated_at', width: '6rem', visibility: false},
            ],
            saveNewIstopeForm: false,
            renderKey: 1,
            toggle_multiple: false,
            isLoading: false,
            dialog: false,
            succeed: false,
            editIsotope: -1,
            editIsotopeComponent: false,
            isotopeDataloading: false,
            e6: 1,
            editAble: true,
            newIsotopeDialog: false,
            snackbarNew: false,
            snackbarUpdate: false,
            //Counters
            basicInfoCounter: '',
            weightInfoCounter: '',
            analysisInfoCounter: '',
            carbonInfoCounter: '',
            nitrogenInfoCounter: '',
            oxygenInfoCounter: '',
            sulphurInfoCounter: '',
            //Componenet General Display Values
            percentagesuffix: '%',
            ugsuffix: 'ug',
            masstype: 'number',
            //vModel Data
            //Isotope Information
            isotopelabvmodelgpc: '',
            isotopecasenumbervmodel: '',
            isotopesamplenumbervmodel: '',
            //Isotope Basic Information
            isotopebatchoptionsvmodel: '',
            resultsstatusoptionsvmodel: '',
            weightsampledcleanedtypevmode: '',
            //Isotope Weight Information
            weightvialnlidvmode: '',
            weightcollagenvmode: '',
            weightsamplevialnlidvmode: '',
            yieldcollagenvmode: '',
            //Isotope Analysis Information
            collagenweightusedforanalysisvmodel: '',
            analysisrequestedvmodel: '',
            welllocationvmodel: '',
            //Isotope Carbon Information
            carbondeltavmodel: '',
            carbonweightvmodel: '',
            carbonpercentagevmodel: '',
            //Isotope Nitrogen Information
            nitrogendeltavmodel: '',
            nitrogenweightvmodel: '',
            nitrogenpercentagevmodel: '',
            carbonnitrogenratiovmodel: '',
            //Isotope Oxygen Information
            oxygendeltavmodel: '',
            oxygenweightvmodel: '',
            oxygenpercentagevmodel: '',
            carbonoxygenratiovmodel: '',
            //Isotope Sulpher Information
            sulpherdeltavmodel: '',
            sulpherweightvmodel: '',
            sulpherpercentagevmodel: '',

            allSpecimenIsotope: [],
            demineralizingStartDateVmodel: '',
            demineralizingEndDateVmodel: '',
        }),
        computed: {
            columnVisibility() {
                return this.headers.filter(item => item.visibility === true);
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
        },
        mounted() {
            this.getIsotopeTableData()
            // console.log(getElementById("newIsotopeForm"));
        },
        methods: {
            getIsotopeTableData() {
                this.isLoading = true;
                this.options = [];
                apiGetCallAxios("/api/isotopes?se_id=" + this.specimen_id).then(response => {
                    this.options = response.data.data.map(item => ({
                        sample_number: item.sample_number,
                        external_case_id: item.external_case_id,
                        weight_sample_cleaned: item.weight_sample_cleaned,
                        yeild_collagen: item.yeild_collagen,
                        weight_vial_lid: item.weight_vial_lid,
                        id: item.id
                    }));
                    this.isLoading = false
                });
            },
            resetEditDialog() {
                this.$refs['newIsotopeForm'].reset();
            },
            postNewIsotope() {
                var succeed = null;
                var errored = null;
                axios
                    .request({
                        url: "/api/isotopes/",
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        },
                        data: {
                            "org_id": this.org_id,
                            "project_id": this.project_id,
                            "sb_id": this.sb_id,
                            "se_id": this.specimen_id,
                            "lab_id": this.isotopelabvmodelgpc,
                            "sample_number": this.isotopesamplenumbervmodel,
                            "external_case_id": this.isotopecasenumbervmodel
                        }
                    }).then(response => {
                    succeed = true;
                    this.snackbarNew = true;
                    this.getIsotopeTableData();
                    console.log(this.$refs['newIsotopeForm']);
                    this.$refs['newIsotopeForm'].reset();
                    this.newIsotopeDialog = false
                }).catch(error => {
                    errored = true
                })
            },
            postIsotopeInformation() {
                var succeed = null;
                var errored = null;
                axios
                    .request({
                        url: "/api/isotopes/" + this.editIsotope.id,
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        },
                        data: {
                            "lab_id": this.isotopelabvmodelgpc,
                            "sample_number": this.isotopesamplenumbervmodel,
                            "external_case_id": this.isotopecasenumbervmodel
                        }
                    }).then(response => {
                    succeed = true;
                    this.snackbarUpdate = true

                }).catch(error => {
                    errored = true
                })
            },
            postBasicInformation() {
                var succeed = null;
                var errored = null;
                axios
                    .request({
                        url: "/api/isotopes/" + this.editIsotope.id,
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        },
                        data: {
                            "batch_id": this.isotopebatchoptionsvmodel,
                            "results_confidence": this.resultsstatusoptionsvmodel,
                            "weight_sample_cleaned": this.weightsampledcleanedtypevmode
                        }
                    }).then(response => {
                    succeed = true;
                    this.snackbarUpdate = true
                }).catch(error => {
                    errored = true
                })
            },
            postWeightInformation() {
                var succeed = null;
                var errored = null;
                axios
                    .request({
                        url: "/api/isotopes/" + this.editIsotope.id,
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        },
                        data: {
                            "weight_vial_lid": this.weightvialnlidvmode,
                            "weight_collagen": this.weightcollagenvmode,
                            "weight_sample_vial_lid": this.weightsamplevialnlidvmode,
                            "yield_collagen": this.yieldcollagenvmode
                        }
                    }).then(response => {
                    succeed = true;
                    this.snackbarUpdate = true
                }).catch(error => {
                    errored = true
                })
            },
            postAnalysisInformation() {
                var succeed = null;
                var errored = null;
                axios
                    .request({
                        url: "/api/isotopes/" + this.editIsotope.id,
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        },
                        data: {
                            "collagen_weight_used_for_analysis": this.collagenweightusedforanalysisvmodel,
                            "analysis_requested": this.analysisrequestedvmodel,
                            "well_location": this.welllocationvmodel,
                        }
                    }).then(response => {
                    succeed = true;
                    this.snackbarUpdate = true
                }).catch(error => {
                    errored = true
                })
            },
            postCarbonInformation() {
                var succeed = null;
                var errored = null;
                axios
                    .request({
                        url: "/api/isotopes/" + this.editIsotope.id,
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        },
                        data: {
                            "c_delta": this.carbondeltavmodel,
                            "c_weight": this.carbonweightvmodel,
                            "c_percent": this.carbonpercentagevmodel
                        }
                    }).then(response => {
                    succeed = true;
                    this.snackbarUpdate = true
                }).catch(error => {
                    errored = true
                })
            },
            postNitrogenInformation() {
                var succeed = null;
                var errored = null;
                axios
                    .request({
                        url: "/api/isotopes/" + this.editIsotope.id,
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        },
                        data: {
                            "n_delta": this.nitrogendeltavmodel,
                            "n_weight": this.nitrogenweightvmodel,
                            "n_percent": this.nitrogenpercentagevmodel,
                            "c_to_n_ratio": this.carbonnitrogenratiovmodel
                        }
                    }).then(response => {
                    succeed = true;
                    this.snackbarUpdate = true
                }).catch(error => {
                    errored = true
                })
            },
            postOxygenInformation() {
                var succeed = null;
                var errored = null;
                axios
                    .request({
                        url: "/api/isotopes/" + this.editIsotope.id,
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        },
                        data: {
                            "o_delta": this.oxygendeltavmodel,
                            "o_weight": this.oxygenweightvmodel,
                            "o_percent": this.oxygenpercentagevmodel,
                            "c_to_o_ratio": this.carbonoxygenratiovmodel
                        }
                    }).then(response => {
                    this.snackbarUpdate = true;
                    succeed = true;
                }).catch(error => {
                    errored = true
                })
            },
            postSulphurInformation() {
                var succeed = null;
                var errored = null;
                axios
                    .request({
                        url: "/api/isotopes/" + this.editIsotope.id,
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        },
                        data: {
                            "s_delta": this.sulpherdeltavmodel,
                            "s_weight": this.sulpherweightvmodel,
                            "s_percent": this.sulpherpercentagevmodel
                        }
                    }).then(response => {
                    succeed = true;
                    this.snackbarUpdate = true
                }).catch(error => {
                    errored = true
                })
            },
            postAll() {
                this.postIsotopeInformation();
                this.postBasicInformation();
                this.postWeightInformation();
                this.postAnalysisInformation();
                this.postCarbonInformation();
                this.postNitrogenInformation();
                this.postOxygenInformation();
                this.postSulphurInformation();
                this.basicInformationCounter();

            },
            editItem(item) {
                this.editIsotope = item;
                this.renderKey++;
                this.$nextTick().then(() => {
                    this.editIsotopeComponent = true;
                });
            },
            getIsotopeData() {
                this.isotopeDataloading = true;
                apiGetCallAxios(this.base_url + '/api/isotopes?se_id=' + this.specimen_id).then(response => {
                    this.allSpecimenIsotope = response.data.data.map(item => ({
                        sample_number: item.sample_number,
                        external_case_id: item.external_case_id,
                        weight_sample_cleaned: item.weight_sample_cleaned,
                        yeild_collagen: item.yeild_collagen,
                        weight_vial_lid: item.weight_vial_lid,
                        id: item.id,
                        lab_id: item.lab_id,
                        batch_id: item.batch_id,
                        results_confidence: item.results_confidence,
                        weight_sample_vial_lid: item.weight_sample_vial_lid,
                        weight_collagen: item.weight_collagen,
                        yield_collagen: item.yield_collagen,
                        demineralizing_start_date: item.demineralizing_start_date,
                        demineralizing_end_date: item.demineralizing_end_date,
                        analysis_requested: item.analysis_requested,
                        well_location: item.well_location,
                        collagen_weight_used_for_analysis: item.collagen_weight_used_for_analysis,
                        c_weight: item.c_weight,
                        n_weight: item.n_weight,
                        o_weight: item.o_weight,
                        s_weight: item.s_weight,
                        c_delta: item.c_delta,
                        n_delta: item.n_delta,
                        o_delta: item.o_delta,
                        s_delta: item.s_delta,
                        c_percent: item.c_percent,
                        n_percent: item.n_percent,
                        o_percent: item.o_percent,
                        s_percent: item.s_percent,
                        c_to_n_ratio: item.c_to_n_ratio,
                        c_to_o_ratio: item.c_to_o_ratio,
                    }));
                    for (var i = 0; i < this.allSpecimenIsotope.length; i++) {
                        if (this.allSpecimenIsotope[i].id === this.editIsotope.id) {
                            if (this.allSpecimenIsotope[i].lab_id != null) {
                                this.isotopelabvmodelgpc = this.allSpecimenIsotope[i].lab_id.toString()
                            } else {
                                this.isotopelabvmodelgpc = this.allSpecimenIsotope[i].lab_id
                            }
                            if (this.allSpecimenIsotope[i].batch_id != null) {
                                this.isotopebatchoptionsvmodel = this.allSpecimenIsotope[i].batch_id.toString()
                            } else {
                                this.isotopebatchoptionsvmodel = this.allSpecimenIsotope[i].batch_id
                            }
                            if (this.allSpecimenIsotope[i].results_confidence != null) {
                                this.resultsstatusoptionsvmodel = this.allSpecimenIsotope[i].results_confidence.toString()
                            } else {
                                this.resultsstatusoptionsvmodel = this.allSpecimenIsotope[i].results_confidence
                            }
                            this.demineralizingStartDateVmodel = this.allSpecimenIsotope[i].demineralizing_start_date;
                            this.demineralizingEndDateVmodel = this.allSpecimenIsotope[i].demineralizing_end_date;
                            this.isotopecasenumbervmodel = this.allSpecimenIsotope[i].external_case_id;
                            this.isotopesamplenumbervmodel = this.allSpecimenIsotope[i].sample_number;
                            this.weightsampledcleanedtypevmode = this.allSpecimenIsotope[i].weight_sample_cleaned;
                            this.weightvialnlidvmode = this.allSpecimenIsotope[i].weight_vial_lid;
                            this.weightcollagenvmode = this.allSpecimenIsotope[i].weight_collagen;
                            this.weightsamplevialnlidvmode = this.allSpecimenIsotope[i].weight_sample_vial_lid;
                            this.yieldcollagenvmode = this.allSpecimenIsotope[i].yield_collagen;
                            this.collagenweightusedforanalysisvmodel = this.allSpecimenIsotope[i].collagen_weight_used_for_analysis;
                            this.analysisrequestedvmodel = this.allSpecimenIsotope[i].analysis_requested;
                            this.welllocationvmodel = this.allSpecimenIsotope[i].well_location;
                            this.carbondeltavmodel = this.allSpecimenIsotope[i].c_delta;
                            this.carbonweightvmodel = this.allSpecimenIsotope[i].c_weight;
                            this.carbonpercentagevmodel = this.allSpecimenIsotope[i].c_percent;
                            this.nitrogendeltavmodel = this.allSpecimenIsotope[i].n_delta;
                            this.nitrogenweightvmodel = this.allSpecimenIsotope[i].n_weight;
                            this.nitrogenpercentagevmodel = this.allSpecimenIsotope[i].n_percent;
                            this.carbonnitrogenratiovmodel = this.allSpecimenIsotope[i].c_to_n_ratio;
                            this.oxygendeltavmodel = this.allSpecimenIsotope[i].o_delta;
                            this.oxygenweightvmodel = this.allSpecimenIsotope[i].o_weight;
                            this.oxygenpercentagevmodel = this.allSpecimenIsotope[i].o_percent;
                            this.carbonoxygenratiovmodel = this.allSpecimenIsotope[i].c_to_o_ratio;
                            this.sulpherdeltavmodel = this.allSpecimenIsotope[i].s_delta;
                            this.sulpherweightvmodel = this.allSpecimenIsotope[i].s_weight;
                            this.sulpherpercentagevmodel = this.allSpecimenIsotope[i].s_percent;
                            this.isotopeDataloading = false;
                            this.basicInformationCounter();
                            this.weightInformationCounter();
                            this.analysisInformationCounter();
                            this.carbonInformationCounter();
                            this.nitrogenInformationCounter();
                            this.oxygenInformationCounter();
                            this.sulphurInformationCounter();
                            break
                        }
                    }
                });
            },
            basicInformationCounter() {
                var counter = 0;
                if (this.isotopebatchoptionsvmodel != null) {
                    counter++
                }
                if (this.resultsstatusoptionsvmodel != null) {
                    counter++
                }
                if (this.weightsampledcleanedtypevmode != null) {
                    counter++
                }
                this.basicInfoCounter = counter + '/5'
            },
            weightInformationCounter() {
                var counter = 0;
                if (this.weightvialnlidvmode != null) {
                    counter++
                }
                if (this.weightcollagenvmode != null) {
                    counter++
                }
                if (this.weightsamplevialnlidvmode != null) {
                    counter++
                }
                if (this.yieldcollagenvmode != null) {
                    counter++
                }
                this.weightInfoCounter = counter + '/4'
            },
            analysisInformationCounter() {
                var counter = 0;
                if (this.collagenweightusedforanalysisvmodel != null) {
                    counter++
                }
                if (this.analysisrequestedvmodel != null) {
                    counter++
                }
                if (this.welllocationvmodel != null) {
                    counter++
                }
                this.analysisInfoCounter = counter + '/4'
            },
            carbonInformationCounter() {
                var counter = 0;
                if (this.carbondeltavmodel != null) {
                    counter++
                }
                if (this.carbonweightvmodel != null) {
                    counter++
                }
                if (this.carbonpercentagevmodel != null) {
                    counter++
                }
                this.carbonInfoCounter = counter + '/3'
            },
            nitrogenInformationCounter() {
                var counter = 0;
                if (this.nitrogendeltavmodel != null) {
                    counter++
                }
                if (this.nitrogenweightvmodel != null) {
                    counter++
                }
                if (this.nitrogenpercentagevmodel != null) {
                    counter++
                }
                if (this.carbonnitrogenratiovmodel != null) {
                    counter++
                }
                this.nitrogenInfoCounter = counter + '/4'
            },
            oxygenInformationCounter() {
                var counter = 0;
                if (this.oxygendeltavmodel != null) {
                    counter++
                }
                if (this.oxygenweightvmodel != null) {
                    counter++
                }
                if (this.oxygenpercentagevmodel != null) {
                    counter++
                }
                if (this.carbonoxygenratiovmodel != null) {
                    counter++
                }
                this.oxygenInfoCounter = counter + '/4'
            },
            sulphurInformationCounter() {
                var counter = 0;
                if (this.sulpherdeltavmodel != null) {
                    counter++
                }
                if (this.sulpherweightvmodel != null) {
                    counter++
                }
                if (this.sulpherpercentagevmodel != null) {
                    counter++
                }
                this.sulphurInfoCounter = counter + '/3'
            },

        },
        components: {
            Lab,
            IsotopeSampleNumber,
            IsotopeTextField,
        },
        watch: {},
        created() {
            //Isotope Information
            bus.$on('labVModelChange', (data) => {
                this.isotopelabvmodelgpc = data;
            });
            bus.$on('caseNumberVModelChange', (data) => {
                this.isotopecasenumbervmodel = data;
            });
            bus.$on('sampleNumberVModelChange', (data) => {
                this.isotopesamplenumbervmodel = data;
            });
            //Isotope Basic Information
            bus.$on('isotopeBatch', (data) => {
                this.isotopebatchoptionsvmodel = data;
            });
            bus.$on('isotopeResultsStatus', (data) => {
                this.resultsstatusoptionsvmodel = data;
            });
            bus.$on('isotopeWeightSampleCleaned', (data) => {
                this.weightsampledcleanedtypevmode = data;
            });
            //Isotope Weight Information
            bus.$on('isotopeWeightVialnLid', (data) => {
                this.weightvialnlidvmode = data;
            });
            bus.$on('isotopeWeightCollagen', (data) => {
                this.weightcollagenvmode = data;
            });
            bus.$on('isotopeWeightSampleVialnLid', (data) => {
                this.weightsamplevialnlidvmode = data;
            });
            bus.$on('isotopeYieldCollagen', (data) => {
                this.yieldcollagenvmode = data;
            });
            //Isotope Analysis Information
            bus.$on('isotopeWeightUsedforAnalysis', (data) => {
                this.collagenweightusedforanalysisvmodel = data;
            });
            bus.$on('isotopeAnalysisRequest', (data) => {
                this.analysisrequestedvmodel = data;
            });
            bus.$on('isotopeWellLocation', (data) => {
                this.welllocationvmodel = data;
            });
            //Isotope Carbon Information
            bus.$on('isotopeCarbonDelta', (data) => {
                this.carbondeltavmodel = data;
            });
            bus.$on('isotopeCarbonWeight', (data) => {
                this.carbonweightvmodel = data;
            });
            bus.$on('isotopeCarbonPercentage', (data) => {
                this.carbonpercentagevmodel = data;
            });
            //Isotope Nitrogen Information
            bus.$on('isotopeNitrogenDelta', (data) => {
                this.nitrogendeltavmodel = data;
            });
            bus.$on('isotopeNitrogenWeight', (data) => {
                this.nitrogenweightvmodel = data;
            });
            bus.$on('isotopeNitrogenPercentage', (data) => {
                this.nitrogenpercentagevmodel = data;
            });
            bus.$on('isotopeCarbontoNitrogenPercentage', (data) => {
                this.carbonnitrogenratiovmodel = data;
            });
            //Isotope Oxygen Information
            bus.$on('isotopeOxygenDelta', (data) => {
                this.oxygendeltavmodel = data;
            });
            bus.$on('isotopeOxygenWeight', (data) => {
                this.oxygenweightvmodel = data;
            });
            bus.$on('isotopeOxygenPercentage', (data) => {
                this.oxygenpercentagevmodel = data;
            });
            bus.$on('isotopeCarbontoOxygenPercentage', (data) => {
                this.carbonoxygenratiovmodel = data;
            });
            //Isotope Sulpher Information
            bus.$on('isotopeSulpherDelta', (data) => {
                this.sulpherdeltavmodel = data;
            });
            bus.$on('isotopeSulpherWeight', (data) => {
                this.sulpherweightvmodel = data;
            });
            bus.$on('isotopeSulpherPercentage', (data) => {
                this.sulpherpercentagevmodel = data;
            })
        }
    }
</script>
