<template>
  <div class="m-2">
    <contentheader :title="heading" :help_menu="true"
                   :trail="(action.create) ? trail.create : trail.default" model_name="isotopebatch"
                   :isotope_batch= "(action.create) ? null : isotope_batch" :crud_action="action" @eventEdit="edit"  @eventSave="save">
    </contentheader>
    <br>
    <v-card>
      <v-container fluid v-show="showForm">
        <v-row align="center"
               justify="center">
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.lab_id" :items="labOptions" label="Lab" placeholder="Select Lab" item-text="name" item-value="id"
                            :loading="loading" disabled clearable></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-autocomplete v-model="form.status" :items="isotopeStatus" label="Results Status" disabled
                            :loading="loading" placeholder="Select Results Status"></v-autocomplete>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.external_case_id" label="External Case ID" placeholder="External Case ID" :disabled="!this.editable"
                          :loading="loading" clearable></v-text-field>
          </v-col>
          <v-col cols="12" md="3" sm="12">
            <v-text-field v-model="form.batch_num" label="Batch Number" placeholder="Batch Number" :loading="loading" disabled clearable></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-textarea v-model="form.notes" rows="3" type="text" label="Notes" :loading="loading" :disabled="!this.editable" clearable class="pa-sm-3"></v-textarea>
        </v-row>
      </v-container>
      <v-card-text>
        <v-stepper v-model="step">
          <v-stepper-header>
            <v-stepper-step :complete="currentStatusStep > 1" step="1" :editable="currentStatusStep >= 1" >Cleaning</v-stepper-step>
            <v-divider></v-divider>
            <v-stepper-step :complete="currentStatusStep > 2" step="2" :editable="currentStatusStep >= 2" >Demineralizing</v-stepper-step>
            <v-divider></v-divider>
            <v-stepper-step :complete="currentStatusStep > 3" step="3" :editable="currentStatusStep >= 3" >Remove Humic Acid</v-stepper-step>
            <v-divider></v-divider>
            <v-stepper-step :complete="currentStatusStep > 4" step="4" :editable="currentStatusStep >= 4" >Solubilizing</v-stepper-step>
            <v-divider></v-divider>
            <v-stepper-step :complete="currentStatusStep > 5" step="5" :editable="currentStatusStep >= 5" >Freeze Drying</v-stepper-step>
            <v-divider></v-divider>
            <v-stepper-step :complete="currentStatusStep > 6" step="6" :editable="currentStatusStep >= 6" >Collagen Yield</v-stepper-step>
          </v-stepper-header>
          <v-stepper-content step="1" >
            <v-card>
              <v-row>
                <v-col cols="12" md="3" sm="12" >
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 1" class="pa-sm-3" dusk="label-tubes" v-model="form.labeling_tubes" label="Label Tubes and Caps" color="primary" ></v-switch>
                </v-col>
                <v-col cols="12" md="3" sm="12" >
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 1" v-model="form.rsc" dusk="remove-all" label="Remove all visible signs of surface contamination using rotary tool." color="primary"></v-switch>
                </v-col>
                <v-col cols="12" md="3" sm="12" v-if="this.isotopebatch.cleaning_start_date!=null">
                  <date v-model="form.cleaning_start_date" label="Start Date:" color="primary" disabled ></date>
                </v-col>
                <v-col cols="12" md="3" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 1" v-model="form.rinse_samples" dusk="rinse-samples" label="Rinse samples w/dH20" color="primary"></v-switch>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="3" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 1" class="pa-sm-3" v-model="form.sonicate_samples_dh2o_cycle1" dusk="sonicate-samples-cycle1" label="Sonicate samples with dH2O - cycle1" color="primary"> </v-switch>
                </v-col>
                <v-col cols="12" md="3" sm="12" v-if="this.isotopebatch.sonicate_samples_dh2o_cycle1_start_date!=null">
                  <date v-model="form.sonicate_samples_dh2o_cycle1_start_date" label="Start Date:" color="primary" disabled ></date>
                </v-col>
                <v-col cols="12" md="3" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 1" v-model="form.sonicate_samples_dh2o_cycle2" dusk="sonicate-samples-cycle2" label="Sonicate samples with dH2O - cycle2" color="primary"></v-switch>
                </v-col>
                <v-col cols="12" md="3" sm="12" v-show="this.isotopebatch.sonicate_samples_dh2o_cycle2_start_date!=null">
                  <date v-model="form.sonicate_samples_dh2o_cycle2_start_date" label="Start Date:" color="primary" disabled ></date>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="3" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 1" class="pa-sm-3" v-model="form.sonicate_samples_ethanol95" dusk="sonicate-samples-95" label="Sonicate samples with 95% ethanol" color="primary"></v-switch>
                </v-col>
                <v-col cols="12" md="3" sm="12" v-if="this.isotopebatch.sonicate_samples_ethanol95_start_date!=null">
                  <date v-model="form.sonicate_samples_ethanol95_start_date" label="Start Date:" color="primary" disabled ></date>
                </v-col>
                <v-col cols="12" md="3" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 1" v-model="form.sonicate_samples_ethanol100" dusk="sonicate-samples-100" label="Sonicate samples with 100% ethanol" color="primary"></v-switch>
                </v-col>
                <v-col cols="12" md="3" sm="12" v-if="this.isotopebatch.sonicate_samples_ethanol100_start_date!=null">
                  <date v-model="form.sonicate_samples_ethanol100_start_date" label="Start Date:" color="primary" disabled ></date>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="3" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 1" class="pa-sm-3" v-model="form.dry_samples_start" dusk="dry-samples" label="Dry samples in oven." color="primary"></v-switch>
                </v-col>
                <v-col cols="12" md="3" sm="12" v-if="this.isotopebatch.dry_samples_start_date!=null">
                  <date v-model="form.dry_samples_start_date" label="Start Date:" color="primary" disabled></date>
                </v-col>
                <v-col cols="12" md="3" sm="12" v-if="this.isotopebatch.dry_samples_start_date!=null">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 1" v-model="form.dry_samples_end" label="Remove cooled samples from tubes, weigh, and return." color="primary"></v-switch>
                </v-col>
                <v-col cols="12" md="3" sm="12" v-if="this.isotopebatch.dry_samples_end_date!=null">
                  <date v-model="form.dry_samples_end_date" label="End Date:" color="primary" disabled></date>
                </v-col>
              </v-row>
              <v-alert align="center" :color="this.count_weight_samples_cleaned < this.count_samples? 'red': 'green'" text>Count Samples = {{this.count_samples}}
                <br/> Count Samples Weight Cleaned = {{this.count_weight_samples_cleaned}}
              </v-alert>
            </v-card>
          </v-stepper-content>
          <v-stepper-content step="2">
            <v-card>
              <v-row>
                <v-col cols="12" md="3" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 2" class="pa-sm-3" v-model="form.demineralizing_treatment_start" label="Treat samples with 40ml 0.25 M hydrochloric acid until spongy. Change acid every 2-4 days. Treat until there are no hard spots; test with dental pick. Discard waste appropriately" color="primary" ></v-switch>
                </v-col>
                <v-col cols="12" md="3" sm="12" v-if="this.isotopebatch.demineralizing_treatment_start_date!=null">
                  <date v-model="form.demineralizing_treatment_start_date" label="Demineralizing Treatment Start Date:" color="primary" disabled></date>
                </v-col>
                <v-col cols="12" md="3" sm="12" v-if="this.isotopebatch.demineralizing_treatment_start_date!=null">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 2" v-model="form.demineralizing_treatment_end" label="Treatment of samples with 40ml 0.25 M hydrochloric acid complete." color="primary"></v-switch>
                </v-col>
                <v-col cols="12" md="3" sm="12" v-if="this.isotopebatch.demineralizing_treatment_end_date!=null">
                  <date v-model="form.demineralizing_treatment_end_date" label="Demineralizing Treatment End Date:" color="primary" disabled></date>
                </v-col>
                <v-col cols="12" md="3" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 2" class="pa-sm-3" v-if="this.isotopebatch.demineralizing_treatment_end_date!=null" v-model="form.rinse_demineralized_samples" label="Rinse demineralized samples 3x with dH20" color="primary"></v-switch>
                </v-col>
              </v-row>
            </v-card>
          </v-stepper-content>
          <v-stepper-content step="3">
            <v-card>
              <v-row>
                <v-col cols="12" md="4" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 3" class="pa-sm-3" v-model="form.rha_treatment_start" label="Treat samples with 40ml 0.125 M sodium hydroxide for 24 hrs. Discard waste appropriately. Rinse samples 5x with dH20." color="primary" ></v-switch>
                </v-col>
                <v-col cols="12" md="4" sm="12" v-if="this.isotopebatch.rha_treatment_start_date!=null">
                  <date v-model="form.rha_treatment_start_date" label="Removing Humic Acids Start Date:" color="primary" disabled></date>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="3" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 3" class="pa-sm-3" v-model="form.rha_sample_rinse1_start" label="Rinse 1 Start" color="primary"></v-switch>
                </v-col>
                <v-col cols="12" md="3" sm="12" v-if="this.isotopebatch.rha_sample_rinse1_start_date!=null">
                  <date v-model="form.rha_sample_rinse1_start_date" label="Rinse 1 Start Date:" color="primary" disabled></date>
                </v-col>
                <v-col cols="12" md="3" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 3" v-model="form.rha_sample_rinse1_end" label="Rinse 1 End" color="primary"></v-switch>
                </v-col>
                <v-col cols="12" md="3" sm="12" v-if="this.isotopebatch.rha_sample_rinse1_end_date!=null">
                  <date v-model="form.rha_sample_rinse1_end_date" label="Rinse 1 End Date:" color="primary" disabled></date>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="3" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 3" class="pa-sm-3" v-model="form.rha_sample_rinse2_start" label="Rinse 2 Start" color="primary"></v-switch>
                </v-col>
                <v-col cols="12" md="3" sm="12" v-if="this.isotopebatch.rha_sample_rinse2_start_date!=null">
                  <date v-model="form.rha_sample_rinse2_start_date" label="Rinse 2 Start Date:" color="primary" disabled></date>
                </v-col>
                <v-col cols="12" md="3" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 3" v-model="form.rha_sample_rinse2_end" label="Rinse 2 End" color="primary"></v-switch>
                </v-col>
                <v-col cols="12" md="3" sm="12" v-if="this.isotopebatch.rha_sample_rinse2_end_date!=null">
                  <date v-model="form.rha_sample_rinse2_end_date" label="Rinse 2 End Date:" color="primary" disabled></date>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="3" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 3" class="pa-sm-3" v-model="form.rha_sample_rinse3_start" label="Rinse 3 Start" color="primary"></v-switch>
                </v-col>
                <v-col cols="12" md="3" sm="12" v-if="this.isotopebatch.rha_sample_rinse3_start_date!=null">
                  <date v-model="form.rha_sample_rinse3_start_date" label="Rinse 3 Start Date:" color="primary" disabled></date>
                </v-col>
                <v-col cols="12" md="3" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 3" v-model="form.rha_sample_rinse3_end" label="Rinse 3 End" color="primary"></v-switch>
                </v-col>
                <v-col cols="12" md="3" sm="12" v-if="this.isotopebatch.rha_sample_rinse3_end_date!=null">
                  <date v-model="form.rha_sample_rinse3_end_date" label="Rinse 3 End Date:" color="primary" disabled></date>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="3" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 3" class="pa-sm-3" v-model="form.rha_sample_rinse4_start" label="Rinse 4 Start" color="primary"></v-switch>
                </v-col>
                <v-col cols="12" md="3" sm="12" v-if="this.isotopebatch.rha_sample_rinse4_start_date!=null">
                  <date v-model="form.rha_sample_rinse4_start_date" label="Rinse 4 Start Date:" color="primary" disabled></date>
                </v-col>
                <v-col cols="12" md="3" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 3" v-model="form.rha_sample_rinse4_end" label="Rinse 4 End" color="primary"></v-switch>
                </v-col>
                <v-col cols="12" md="3" sm="12" v-if="this.isotopebatch.rha_sample_rinse4_end_date!=null">
                  <date v-model="form.rha_sample_rinse4_end_date" label="Rinse 4 End Date:" color="primary" disabled></date>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="3" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 3" class="pa-sm-3" v-model="form.rha_sample_rinse5_start" label="Rinse 5 Start" color="primary"></v-switch>
                </v-col>
                <v-col cols="12" md="3" sm="12" v-if="this.isotopebatch.rha_sample_rinse5_start_date!=null">
                  <date v-model="form.rha_sample_rinse5_start_date" label="Rinse 5 Start Date:" color="primary" disabled></date>
                </v-col>
                <v-col cols="12" md="3" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 3" v-model="form.rha_sample_rinse5_end" label="Rinse 5 End" color="primary"></v-switch>
                </v-col>
                <v-col cols="12" md="3" sm="12" v-if="this.isotopebatch.rha_sample_rinse5_end_date!=null">
                  <date v-model="form.rha_sample_rinse5_end_date" label="Rinse 5 End Date:" color="primary" disabled></date>
                </v-col>
              </v-row>
              <v-row v-if="this.isotopebatch.rha_sample_rinse5_end_date!=null">
                <v-col cols="12" md="4" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 3" class="pa-sm-3" v-model="form.rha_treatment_end" label="Treatment and Rinse Completed" color="primary"></v-switch>
                </v-col>
                <v-col cols="12" md="4" sm="12" v-if="this.isotopebatch.rha_treatment_end_date!=null">
                  <date v-model="form.rha_treatment_end_date" label="Removing Humic Acids End Date:" color="primary" disabled></date>
                </v-col>
              </v-row>
            </v-card>
          </v-stepper-content>
          <v-stepper-content step="4">
            <v-card>
              <v-row>
                <v-col cols="12" md="3" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 4" class="pa-sm-3" v-model="form.sc_clean_vials_and_lids" label="Clean vials and lids. Label." color="primary" ></v-switch>
                </v-col>
                <v-col cols="12" md="3" sm="12" v-if="this.isotopebatch.sc_clean_vials_and_lids_date!=null">
                  <date v-model="form.sc_clean_vials_and_lids_date" label="Clean Vials and Lids Date:" color="primary" disabled></date>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="3" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 4" class="pa-sm-3" v-model="form.sc_add_solubale" label="Add 15ml pH 3 dH20 to samples and cover tubes with double layer of plastic wrap. Cap tightly." color="primary"></v-switch>
                </v-col>
                <v-col cols="12" md="3" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 4" v-model="form.sc_place_in_oven" label="Place capped tubes in oven for 24 hours." color="primary"></v-switch>
                </v-col>
                <v-col cols="12" md="4" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 4" v-model="form.sc_centrifuge_tubes" label="Centrifuge tubes and transfer supernatant into PTFE beakers. Place beakers in oven to evaporate." color="primary"> </v-switch>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="4" sm="12">
                  <v-text-field :disabled="!this.editable || this.currentStatusStep != 4" class="pa-sm-3" v-model="form.sc_num_acid_heat_treatment" type="number"  label="Number of Acid-Heat Treatments:" clearable></v-text-field>
                </v-col>
                <v-col cols="12" md="4" sm="12">
                  <v-text-field :disabled="!this.editable || this.currentStatusStep != 4" v-model="form.sc_num_collagen_transfers" type="number" label="Number of Collagen Transfers:" clearable></v-text-field>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="4" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 4" class="pa-sm-3" v-model="form.sc_freeze_vials" label="Close vials and freeze until solid. Tilting vials while freezing can help prevent cracking." color="primary"></v-switch>
                </v-col>
                <v-col cols="12" md="4" sm="12" v-if="this.isotopebatch.sc_freeze_vials_date!=null">
                  <date v-model="form.sc_freeze_vials_date" label="Freeze Vials Date:" color="primary" disabled></date>
                </v-col>
              </v-row>
            </v-card>
          </v-stepper-content>
          <v-stepper-content step="5">
            <v-card>
              <v-row>
                <v-col cols="12" md="4" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 5" class="pa-sm-3" v-model="form.fdc_on" label="Turn on freeze-dryer. Replace vial lids with Kimwipe caps. Ensure samples are frozen solid." color="primary" ></v-switch>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="3" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 5" class="pa-sm-3" v-model="form.fdc_samples_start" label="Freeze-dry samples - this may take 1-3 days. Once collagen is dry, cap vials tightly." color="primary"></v-switch>
                </v-col>
                <v-col cols="12" md="3" sm="12"  v-if="this.isotopebatch.fdc_samples_start_date!=null">
                  <date v-model="form.fdc_samples_start_date" label="Freeze-Dry Samples Start Date:" color="primary" disabled></date>
                </v-col>
                <v-col cols="12" md="3" sm="12">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 5" v-model="form.fdc_samples_end" label="Freeze-dry samples step compeleted" color="primary"></v-switch>
                </v-col>
                <v-col cols="12" md="3" sm="12"  v-if="this.isotopebatch.fdc_samples_end_date!=null">
                  <date v-model="form.fdc_samples_end_date" label="Freeze-Dry Samples End Date:" color="primary" disabled></date>
                </v-col>
              </v-row>
            </v-card>
          </v-stepper-content>
          <v-stepper-content step="6">
            <v-card>
              <v-row >
                <v-col cols="9">
                  <v-switch :disabled="!this.editable || this.currentStatusStep != 6" class="pa-sm-3" v-model="form.combined_samples_weight" label="Weigh dry samples in vials with lids and record combined weight." color="primary" ></v-switch>
                </v-col>
              </v-row>
              <v-alert align="center" :color="this.count_weight_collagen < this.count_samples? 'red': 'green'" text>Count Samples = {{this.count_samples}}
                <br/> Count Samples Weight Cleaned = {{this.count_weight_samples_cleaned}}
                <br/> Count Samples with Collagen Weight = {{this.count_weight_collagen}}
              </v-alert>
            </v-card>
          </v-stepper-content>
        </v-stepper>
      </v-card-text>
      <v-card-actions>
        <v-row class="justify-center">
          <v-btn title="Save" dusk="iso-save" color="primary" :disabled="!this.editable"  class="mr-2" @click="save()"><v-icon class="mr-2">mdi-content-save</v-icon>Save</v-btn>
        </v-row>
      </v-card-actions>
    </v-card>
    <div>
      <v-row>
        <v-col cols="9">
          <v-btn-toggle v-model="toggle_multiple" dense multiple>
            <v-btn>Excel</v-btn>
            <v-btn>PDF</v-btn>
            <v-menu right offset-x :close-on-content-click="false" max-height="500px">
              <template v-slot:activator="{ on }">
                <v-btn v-on="on">Column Visibility<v-icon right>$dropdown</v-icon></v-btn>
              </template>
              <v-list>
                <v-list-item v-for="(header, index) in headers" :key="index">
                  <v-checkbox v-bind:label="header.text" v-model="header.visibility" :value="header.visibility"></v-checkbox>
                </v-list-item>
              </v-list>
            </v-menu>
          </v-btn-toggle>
        </v-col>
        <v-spacer></v-spacer>
        <v-col cols="3">
          <v-text-field v-model="search" label="Search" clearable append-icon="mdi-magnify" dusk="search-datatable"></v-text-field>
        </v-col>
      </v-row>

      <v-data-table :headers="columnVisibility" :items="isotopeItems" :items-per-page="perPage" :options.sync="options" calculate-widths="" :loading="loading_table"
                    class="elevation-1" multi-sort :search="search" :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }"
                    :server-items-length="totalSearchCount">
        <template v-slot:item.sample_number="{ item }"><a :href="`/isotopes/${item.se_id}/${item.iso_id}`" target="_blank">{{ item.sample_number }}</a></template>
      </v-data-table>
      <br>
    </div>
  </div>
</template>

<script>
import {mapGetters, mapState} from "vuex";
import axios from 'axios';
import {eventBus} from "../../../../eventBus";
export default {
  name: "isotopebatch",
  props: {
    crud_action: {type: String, default: "View"},
    isotope_batch: { type: Object },
  },
  data() {
    return {
      trail: {
        'create': [{text: 'Home', disabled: false, href: '/',},
          {text: 'Isotope Batches ', disabled: true, href: '/isotopebatch'},
          {text: 'New', disabled: true, href: '/isotopebatch/create'},],
        'default': [{text: 'Home', disabled: false, href: '/',},
          {text: 'Isotope Batches ', disabled: true, href: '/isotopebatch'},]
      },
      headers: [
        {text: 'Project', value: 'project', visibility: true},
        {text: 'Specimen', value: 'specimen', visibility: true},
        {text: 'Sample Number', value: 'sample_number', visibility: true},
        {text: 'Weight Cleaned', value: 'weight_cleaned', visibility: true},
        {text: 'Weight Vial+Lid', value: 'weight_vialLid', visibility: true},
        {text: 'Weight Sample Vial+Lid', value: 'weight_sample_vialLid', visibility: true},
        {text: 'Collagen Weight', value: 'collagen_weight', visibility: true},
        {text: 'Collagen Yield', value: 'collagen_yield', visibility: true}
      ],
      editable: false,
      perPage: 100,
      searchResults: null,
      totalSearchCount: 0,
      toggle_multiple: [],
      form: {},
      step: 1,
      showForm: true,
      heading: '',
      isotopebatch:{},
      isotope_list:[],
      specimens:[],
      options:{},
      loading: true,
      loading_table: true,
      isotopeStatus: ['Cleaning','Demineralizing','Removal Humic Acids','Solubilizing','Freeze Drying Collagen','Determining Collagen Yield','Completed','Open','Associating Isotopes'],
      isotopeStatusStep: {'Cleaning': '1',
        'Demineralizing' : '2',
        'Removal Humic Acids' : '3',
        'Solubilizing' : '4',
        'Freeze Drying Collagen' : '5',
        'Determining Collagen Yield' : '6',
        'Completed' : '7'},
      search:'',
      currentStatusStep: 1,
      count_samples: '',
      count_weight_samples_cleaned: '',
      count_weight_collagen: '',
    };
  },
  created(){
    this.getIsotopeBatch();
  },
  watch: {

  },
  methods: {
    expand(val) {
      this.showForm = val;
    },
    save() {
      this.loading = true;
      axios
          .request({
            url: "/api/isotope/" + this.isotope_batch.id,
            method: "PUT",
            headers: {
              'Content-Type': 'application/json',
              'Authorization': this.$store.getters.bearerToken
            },
            data: this.form
          }).then(response => {
        this.isotopebatch = response.data.isotopebatch;
        this.count_samples = response.data.count_samples;
        this.count_weight_samples_cleaned = response.data.count_weight_samples_cleaned;
        this.count_weight_collagen = response.data.count_weight_collagen;
        this.setFields();
        this.loading = false;
        this.editable = false;
        eventBus.$emit('show_edit');
      }).catch(error => {
        console.log(error);
        this.loading = false;
        this.snackbar=true;
        this.snackbar_text = 'Isotope Batch Update unsuccessful. Please recheck your inputs.';
        this.snackbar_color = 'info';
      })
    },
    edit() {
      this.editable = true;
    },
    getIsotopeBatch() {
      this.loading = true;
      this.loading_table = true;
      axios
          .request({
            url: '/api/isotope/batch/' + this.isotope_batch.id,
            method: "GET",
            headers: {
              'Content-Type': 'application/json',
              'Authorization': this.$store.getters.bearerToken
            },
          }).then(response => {
        this.isotopebatch = response.data.data;
        this.count_samples = response.data.count_samples;
        this.count_weight_samples_cleaned = response.data.count_weight_samples_cleaned;
        this.count_weight_collagen = response.data.count_weight_collagen;
        this.isotope_list = response.data.data.isotopes;
        this.totalSearchCount = this.isotope_list.length;
        this.setFields();
        this.setHeading();
        this.loading = false;
        this.loading_table = false;
      }).catch(error => {
        console.log(error);
        this.loading = false;
        this.loading_table = false;
      })
    },
    setHeading(){
      let count = this.isotope_list.length ?this.isotope_list.length: 0;
      this.heading = "View Isotope Batch - " + this.isotopebatch.batch_num + " - " + count + " samples";
    },
    setFields() {
      this.form = this.isotopebatch;
      let stepVal = this.isotopeStatusStep[this.isotopebatch.status];
      if(stepVal!== undefined){
        this.step = Math.min(6,stepVal);
        this.currentStatusStep = stepVal;
      }
    },
  },
  computed: {
    columnVisibility(){
      return this.headers.filter(item => item.visibility === true);
    },
    isotopeItems() {
      const rows = [];
      if(this.isotope_list !== undefined){
        this.isotope_list.forEach(item => {
          rows.push({
            se_id: item.se_id,
            iso_id: item.id,
            project: this.getProject(item.project_id)[0].name,
            specimen: item.se.key_bone_side,
            sample_number: item.sample_number,
            weight_cleaned: item.weight_sample_cleaned,
            weight_vialLid: item.weight_vial_lid,
            weight_sample_vialLid: item.weight_sample_vial_lid,
            collagen_weight: item.weight_collagen,
            collagen_yield: item.yield_collagen
          })
        });
      }
      return rows;
    },
    ...mapState({
      rowsPerPageItems: state => state.search.rowsPerPageItems,
    }),
    ...mapGetters({
      getLabs: 'getLabs',
      project_id: 'theProjectId',
      getProject: 'getProjectById',
      getBone: 'getBone',
    }),
    labOptions () {
      let type = 'Isotope';
      return this.getLabs(type);
    },
    action() {
      const act = this.crud_action;
      return { create: act === "Create", view: act === "View", edit: (act === "Update" || act === "Edit"), list: act === "List", };
    },
    toolbarProps() {
      if (this.action.create || this.action.edit) {
        return { reset: true, save: {disabled: !this.edited} };
      } else if (this.action.view) {
        return { edit: true };
      } else {
        return {};
      }
    },
  }
}
</script>
<style scoped>
</style>