<template>
    <v-card tile flat style="top: 16px; margin-left: 24px; background-color: inherit">
        <v-row>
            <v-autocomplete id="project-search-options" name="options" v-model="currentsearchoption" placeholder="Search" dusk="cora-search-options"
                            :items="searchoptions" item-text="name" item-value="value" label="Search Options">
            </v-autocomplete>
            <v-badge id="project-search-badge" :content="current_selected_items.length" :value="current_selected_items.length" color="green" overlap>
                <v-autocomplete id="project-search-options-bones" name="options-bones" v-if="show_bone"
                                :items="this.$store.state.bones" item-text="name" item-value="value" v-model="selected_bone"
                                placeholder="Select a bone" dusk="cora-search-options-bones">
                    <template v-slot:append-outer>
                        <v-icon title="Search" color="primary" @click="searchgo" :disabled="!selected_bone"dusk="search-btn">mdi-magnify</v-icon>
                        <!--                        <v-icon title="Search History" color="primary history" @click="history_menu = !history_menu" class="px-2">mdi-history</v-icon>-->
                    </template>
                </v-autocomplete>
                <v-autocomplete id="project-search-options-accessions" name="options-accessions" v-if="show_accession"
                                :items="this.$store.state.project.accessions" v-model="selected_accession"
                                placeholder="Select an accession" dusk="cora-search-options-accessions">
                    <template v-slot:append-outer>
                        <v-icon title="Search" color="primary" @click="searchgo" :disabled="!selected_accession" dusk="search-btn">mdi-magnify</v-icon>
                        <!--                        <v-icon title="Search History" color="primary history" @click="history_menu = !history_menu" class="px-2">mdi-history</v-icon>-->
                    </template>
                </v-autocomplete>
                <v-autocomplete id="project-search-options-provenance1" name="options-provenance1" v-if="show_provenance1"
                                :items="this.$store.state.project.provenance1" item-text="name" item-value="value" v-model="selected_provenance1"
                                placeholder="Select a provenance1" dusk="cora-search-options-provenance1">
                    <template v-slot:append-outer>
                        <v-icon title="Search" color="primary" @click="searchgo" :disabled="!selected_provenance1" dusk="search-btn">mdi-magnify</v-icon>
                        <!--                        <v-icon title="Search History" color="primary history" @click="history_menu = !history_menu" class="px-2">mdi-history</v-icon>-->
                    </template>
                </v-autocomplete>
                <v-autocomplete id="project-search-options-provenance2" name="options-provenance2" v-if="show_provenance2"
                                :items="this.$store.state.project.provenance2" item-text="name" item-value="value" v-model="selected_provenance2"
                                placeholder="Select a provenance2" dusk="cora-search-options-provenance2">
                    <template v-slot:append-outer>
                        <v-icon title="Search" color="primary" @click="searchgo" :disabled="!selected_provenance2" dusk="search-btn">mdi-magnify</v-icon>
                        <!--                        <v-icon title="Search History" color="primary history" @click="history_menu = !history_menu" class="px-2">mdi-history</v-icon>-->
                    </template>
                </v-autocomplete>
                <v-autocomplete id="project-search-options-individual-number" name="options-individual-number" v-if="show_individual_number"
                                :items="this.$store.state.project.individual_numbers" item-text="name" item-value="value" v-model="selected_individual_number"
                                placeholder="Select an individual number" dusk="cora-search-options-individual-number">
                    <template v-slot:append-outer>
                        <v-icon title="Search" color="primary" @click="searchgo" :disabled="!selected_individual_number" dusk="search-btn">mdi-magnify</v-icon>
                        <!--                        <v-icon title="Search History" color="primary history" @click="history_menu = !history_menu" class="px-2">mdi-history</v-icon>-->
                    </template>
                </v-autocomplete>
                <v-autocomplete id="project-search-options-tooth" name="options-tooth" v-if="show_tooth"
                              :items="tooth_items" item-text="name" item-value="value" v-model="selected_tooth"
                              placeholder="Select a tooth" dusk="cora-search-options-tooth">
                    <template v-slot:append-outer>
                        <v-icon title="Search" color="primary" @click="searchgo" :disabled="!selected_tooth" dusk="search-btn">mdi-magnify</v-icon>
                        <!--                        <v-icon title="Search History" color="primary history" @click="history_menu = !history_menu" class="px-2">mdi-history</v-icon>-->
                   </template>
                </v-autocomplete>
                <v-autocomplete id="project-search-options-dental-code" name="options-dental-code" v-if="show_dental_code" filled chips deletable-chips dense
                                :items="dental_code_items" item-text="description" item-value="id" v-model="selected_dental_code"
                                placeholder="Select a dental code" dusk="cora-search-options-dental-code" style="top: -7px">
                  <template v-slot:selection="data">
                    <v-chip v-bind="data.attrs" :input-value="data.selected" :color="data.item.color" close @click="data.select">
                      <v-avatar left><v-icon>{{ data.item.icon }}</v-icon></v-avatar>{{ data.item.description }}
                    </v-chip>
                  </template>
                  <template v-slot:item="data">
                    <template v-if="typeof data.item !== 'object'">
                      <v-list-item-content v-text="data.item"></v-list-item-content>
                    </template>
                    <template v-else>
                      <v-list-item-avatar class="headline" left :color="data.item.color"><v-icon>{{ data.item.icon }}</v-icon></v-list-item-avatar>
                      <v-list-item-content :background-color="data.item.color">
                        <v-list-item-title v-html="data.item.description"></v-list-item-title>
                      </v-list-item-content>
                    </template>
                  </template>
                  <template v-slot:append-outer>
                    <v-icon title="Search" color="primary" @click="searchgo" :disabled="!selected_dental_code" dusk="search-btn">mdi-magnify</v-icon>
                    <!--                        <v-icon title="Search History" color="primary history" @click="history_menu = !history_menu" class="px-2">mdi-history</v-icon>-->
                  </template>
                </v-autocomplete>
                <v-autocomplete id="project-search-options-tags" name="options-tags" v-if="show_tag" filled chips deletable-chips multiple dense
                                :items="tag_items" item-text="name" item-value="id" v-model="selected_tags"
                                placeholder="Select a tag" dusk="cora-search-options-tags" style="top: -7px">
                    <template v-slot:selection="data">
                        <v-chip v-bind="data.attrs" :input-value="data.selected" :color="data.item.color" close @click="data.select" @click:close="removeTag(data.item)">
                            <v-avatar left><v-icon>{{ data.item.icon }}</v-icon></v-avatar>{{ data.item.name }}
                        </v-chip>
                    </template>
                    <template v-slot:item="data">
                        <template v-if="typeof data.item !== 'object'">
                            <v-list-item-content v-text="data.item"></v-list-item-content>
                        </template>
                        <template v-else>
                            <v-list-item-avatar class="headline" left :color="data.item.color"><v-icon>{{ data.item.icon }}</v-icon></v-list-item-avatar>
                            <v-list-item-content :background-color="data.item.color">
                                <v-list-item-title v-html="data.item.name"></v-list-item-title>
                                <v-list-item-subtitle v-html="data.item.description"></v-list-item-subtitle>
                            </v-list-item-content>
                        </template>
                    </template>
                    <template v-slot:append-outer>
                        <v-icon title="Search" color="primary" @click="searchgo" :disabled="!selected_tags" dusk="search-btn">mdi-magnify</v-icon>
                        <!--                        <v-icon title="Search History" color="primary history" @click="history_menu = !history_menu" class="px-2">mdi-history</v-icon>-->
                    </template>
                </v-autocomplete>
                <v-text-field type="search" v-model="selected_searchtext" clearable v-on:keydown.enter="searchgo" id="corasearch" dusk="cora-search" class="cora-search" name="q" v-if="show_searchtext" :placeholder="currentplaceholder" size="45" aria-label="Search through project for specimens">
                    <template v-slot:append-outer>
                        <v-icon title="Search" color="primary" @click="searchgo" :disabled="!selected_searchtext">mdi-magnify</v-icon>
                        <!--                        <v-icon title="Search History" color="primary history" @click="history_menu = !history_menu" class="px-2">mdi-history</v-icon>-->
                    </template>
                </v-text-field>
            </v-badge>

            <!-- Now display the Search History/Favorites Menu-->
            <template>
                <v-menu v-model="history_menu" v-if="searchHistory && searchHistory.length > 0" :close-on-content-click="false"
                        offset-y left transition="slide-y-transition">
                    <template v-slot:activator="{ on, attrs }">
                        <v-icon title="Search History" v-bind="attrs" v-on="on" color="primary" class="px-2" style="margin-top: -25px">mdi-history</v-icon>
                    </template>
                    <v-card width="450px">
                        <v-tabs v-model="history_tab" background-color="transparent" grow>
                            <v-tab v-for="item in history_items" :key="item.text"><v-icon class="mr-2">{{ item.icon }}</v-icon>{{ item.text }}</v-tab>
                        </v-tabs>

                        <v-tabs-items v-model="history_tab">
                            <v-tab-item :key="history_items[0].text">
                                <v-data-table dense :headers="headersHistory" :items="searchHistory" hide-default-footer>
                                    <template v-slot:item.actions="{ item }">
                                        <v-icon title="Search" small color="blue" class="mr-2" @click="handleHistorySearch(item)">mdi-magnify</v-icon>
                                        <v-icon title="Add to Favorite" small color="pink" @click="handleAddFavoriteSearch(item)">mdi-heart</v-icon>
                                    </template>
                                </v-data-table>
                            </v-tab-item>

                            <v-tab-item :key="history_items[1].text">
                                <v-data-table dense :headers="headersFavorite" :items="searchFavorite" hide-default-footer>
                                    <template v-slot:item.actions="{ item }">
                                        <v-icon title="Search" small color="blue" class="mr-2" @click="handleHistorySearch(item)">mdi-magnify</v-icon>
                                        <v-icon title="Delete Favorite" small color="red" @click="handleDeleteFavoriteSearch(item)">mdi-trash-can-outline</v-icon>
                                    </template>
                                </v-data-table>
                            </v-tab-item>
                        </v-tabs-items>
                    </v-card>
                </v-menu>
            </template>
        </v-row>
    </v-card>
</template>
<style>
    .v-autocomplete-content .v-select-list .v-subheader {
        color: blue;
    }
    #project-search-badge .v-badge__wrapper {
        margin-left: -42px;
        margin-top: -5px;
    }
</style>
<script>
    import {mapState, mapGetters, mapActions} from 'vuex';
    import axios from 'axios';
    export default {
        name: "ProjectSearchBar",
        props: {
            //
        },
        data: function () {
            return {
                loading: false,
                currentsearchoption: 'SE-SB',
                disablesearchbutton: true,
                currentplaceholder: 'SE e.g. Humerus, Tibia, Cranium',
                currentSearchString: '',
                currentSearchName: '',
                searchoptionslabel: "Search",
                // selected and show variables
                selected_bone: "",
                selected_accession: "",
                selected_provenance1: "",
                selected_provenance2: "",
                selected_designator: "",
                selected_individual_number: "",
                selected_composite_key: "",
                selected_dna_sample_number: "",
                selected_dna_external_number: "",
                selected_mito_seq_number: "",
                selected_tags: "",
                selected_tooth: "",
                selected_dental_code: "",
                selected_searchtext: '',
                show_bone: false,
                show_accession: false,
                show_provenance1: false,
                show_provenance2: false,
                show_designator: false,
                show_individual_number: false,
                show_composite_key: false,
                show_dna_sample_number: false,
                show_dna_external_number: false,
                show_mito_seq_number: false,
                show_tag: false,
                show_tooth: false,
                show_dental_code: false,
                show_searchtext: false,
                current_selected_items: [],
                dental_code_items: [],
                se_placeholdermap: [
                    'SB:SE e.g. Humerus, Tibia, Cranium', 'CK:SE e.g. CIL 2003-116,G-21,X-1,201 or CIL 2003-116,,,201',
                    'AN:SE e.g. CIL 2003-116 or CIL2013-186', 'P1:SE e.g. G-21 or G-212', 'P2:SE e.g. X-1 or Trench 3', 'DN:SE e.g. 201 or 602',
                    'IN:SE e.g. I-212 or I-100', 'TAGS:SE e.g. tag1 tag2',
                ],
                dna_placeholdermap: [
                    'SB:DNA e.g. Humerus, Tibia, Cranium', 'CK:DNA e.g. CIL 2003-116,G-21,X-1,201 or CIL 2003-116,,,201',
                    'AN:DNA e.g. CIL 2003-116 or CIL2013-186', 'P1:DNA e.g. G-21 or G-212', 'P2:DNA e.g. X-1 or Trench 3', 'DN:DNA e.g. 201 or 602',
                    'IN:DNA e.g. I-212 or I-100', 'TAGS:DNA e.g. tag1 tag2',
                    'SN:DNA e.g. 68A or 4619A', 'MS:DNA e.g. 1 or 76', 'EN:DNA e.g. AFDIL# like 2004H2001 or 2015H0860', 'HG:DNA e.g. H or L or A or A2',
                ],
                iso_placeholdermap: [
                    'SB:ISO e.g. Humerus, Tibia, Cranium', 'CK:ISO e.g. CIL 2003-116,G-21,X-1,201 or CIL 2003-116,,,201',
                    'AN:ISO e.g. CIL 2003-116 or CIL2013-186', 'P1:ISO e.g. G-21 or G-212', 'P2:ISO e.g. X-1 or Trench 3', 'DN:ISO e.g. 201 or 602',
                    'SN:ISO e.g. 68A or 4619A', 'TAGS:ISO e.g. tag1 tag2',
                ],
                dental_placeholdermap: [
                    'SB:DL e.g. Tooth 1, Tooth 2, Tooth 3',
                    'DC:SE e.g. X, V, T',
                ],
                searchoptions: [
                    { header: 'Specimens' },
                    { name: 'Bone', value: 'SE-SB', group: 'Specimens' },
                    { name: 'Composite Key', value: 'SE-CK', group: 'Specimens' },
                    { name: 'Accession', value: 'SE-AN', group: 'Specimens' },
                    { name: 'Provenance 1', value: 'SE-P1', group: 'Specimens' },
                    { name: 'Provenance 2', value: 'SE-P2', group: 'Specimens' },
                    { name: 'Designator', value: 'SE-DN', group: 'Specimens' },
                    { name: 'Individual Number', value: 'SE-IN', group: 'Specimens' },
                    { name: 'Tags', value: 'SE-TAGS', group: 'Specimens' },
                    { divider: true },
                    { header: 'DNA' },
                    { name: 'Bone', value: 'DNA-SB', group: 'DNA' },
                    { name: 'Composite Key', value: 'DNA-CK', group: 'DNA' },
                    { name: 'Accession', value: 'DNA-AN', group: 'DNA' },
                    { name: 'Provenance 1', value: 'DNA-P1', group: 'DNA' },
                    { name: 'Provenance 2', value: 'DNA-P2', group: 'DNA' },
                    { name: 'Designator', value: 'DNA-DN', group: 'Specimens' },
                    { name: 'Sample Number', value: 'DNA-SN', group: 'DNA' },
                    { name: 'Mito Seq Number', value: 'DNA-MS', group: 'DNA' },
                    { name: 'External #', value: 'DNA-EN', group: 'DNA' },
                    { name: 'Tags', value: 'DNA-TAGS', group: 'DNA' },
                    { divider: true },
                    { header: 'Isotope' },
                    { name: 'Bone', value: 'ISO-SB', group: 'Isotope' },
                    { name: 'Composite Key', value: 'ISO-CK', group: 'Isotope' },
                    { name: 'Accession', value: 'ISO-AN', group: 'Isotope' },
                    { name: 'Provenance 1', value: 'ISO-P1', group: 'DNA' },
                    { name: 'Provenance 2', value: 'ISO-P2', group: 'DNA' },
                    { name: 'Designator', value: 'ISO-DN', group: 'Specimens' },
                    { name: 'Sample Number', value: 'ISO-SN', group: 'Isotope' },
                    { name: 'Tags', value: 'ISO-TAGS', group: 'DNA' },
                    { divider: true },
                    { header: 'Dental' },
                    { name: 'Tooth', value: 'DL-SB', group: 'Dental' },
                    { name: 'Dental Code', value: 'DL-DC', group: 'Dental' },
                ],
                headersHistory: [
                    { text: 'Search', value: 'searchDisplay'},
                    { text: 'Actions', value: 'actions', sortable: false },
                ],
                headersFavorite: [
                    { text: 'Search', value: 'searchDisplay'},
                    { text: 'Actions', value: 'actions', sortable: false },
                ],
                history_items: [
                    { text: 'History', icon: 'mdi-history'},
                    { text: 'Favorites',icon: 'mdi-heart-multiple' }
                ],
                history_menu: false,
                history_tab: null,
                tag_items: null,
            }
        },
        created() {
            this.loading.true;
        },
        mounted() {
            this.currentsearchoption = this.defaultSearchOption;
            var opt = this.currentsearchoption.split("-");
            this.initialize();
            this.searchoptionschange(opt[0], opt[1]);
            var placeholdermap = (opt[0] === "SE") ? this.se_placeholdermap : (opt[0] === "DNA") ? this.dna_placeholdermap  :(opt[0] === "ISO") ? this.iso_placeholdermap: this.dental_placeholdermap;
            this.searchoptionslabel = (opt[0] === "SE") ? "Specimen Search" : (opt[0] === "DNA") ? "DNA Search"  :  (opt[0] === "ISO") ?  "Isotope Search": "Dental Search";
            document.querySelector("label[for=project-search-options]").innerHTML = this.searchoptionslabel;
            this.getDentalCodes();
        },
        watch: {
            'currentsearchoption': function(val, oldVal) {
                var opt = val.split("-");
                var placeholdermap = (opt[0] === "SE") ? this.se_placeholdermap : (opt[0] === "DNA") ? this.dna_placeholdermap :  (opt[0] === "ISO") ? this.iso_placeholdermap:  this.dental_placeholdermap;
                this.searchoptionslabel = (opt[0] === "SE") ? "Specimen Search" : (opt[0] === "DNA") ? "DNA Search" :  (opt[0] === "ISO") ?  "Isotope Search": "Dental Search";
                document.querySelector("label[for=project-search-options]").innerHTML = this.searchoptionslabel;
                this.$store.commit('setListCount', 0);
                let payload = { 'type': 'accessions', 'force': true };
                if (opt[1] === 'AN') {
                    this.$store.dispatch('fetchProjectList', { 'type': 'accessions' }).then(() => this.loading = false);
                } else if (opt[1] === 'P1') {
                    this.$store.dispatch('fetchProjectList', { 'type': 'provenance1' }).then(() => this.loading = false);
                } else if (opt[1] === 'P2') {
                    this.$store.dispatch('fetchProjectList', { 'type': 'provenance2' }).then(() => this.loading = false);
                } else if (opt[1] === 'IN') {
                    this.$store.dispatch('fetchProjectList', { 'type': 'individual-numbers' }).then(() => this.loading = false);
                } else if (opt[1] === 'TAGS') {
                    this.$store.dispatch('fetchProjectList', { 'type': 'tags' }).then(() => this.loading = false);
                }
                this.searchoptionschange(opt[0], opt[1]);
                // The following loop changes the placeholder based upon the current search option.
                for(var i = 0; i < placeholdermap.length; i++) {
                    var optph = placeholdermap[i].split(":");
                    if (optph[0] === opt[1]) {
                        this.currentplaceholder = optph[1];
                    }
                }
            },
            'selected_searchtext': function (val, oldVal) {
                this.disablesearchbutton = (val) ? (val.length === 0) : false;
            },
        },
        methods: {
            initialize: function(history = null) {
                if (!history) {
                    this.currentsearchoption = this.defaultSearchOption;
                }
                let opt = this.currentsearchoption.split("-");
                let option=opt[0];
                let type = opt[1];
                if (type === 'SB') {
                    if (option === "DL") {
                      this.show_tooth = (option === 'DL');
                      this.selected_tooth = (history) ? history.searchString : this.defaultSearchString;
                    } else {
                      this.show_bone = (type === 'SB');
                      this.selected_bone = (history) ? history.searchString : this.defaultSearchString;
                    }
                } else if (type === 'AN') {
                    this.show_accession = (type === 'AN');
                    this.selected_accession = (history) ? history.searchString : this.defaultSearchString;
                } else if (type === 'P1') {
                    this.show_provenance1 = (type === 'P1');
                    this.selected_provenance1 = (history) ? history.searchString : this.defaultSearchString;
                } else if (type === 'P2') {
                    this.show_provenance2 = (type === 'P2');
                    this.selected_provenance2 = (history) ? history.searchString : this.defaultSearchString;
                } else if (type === 'DN') {
                    this.show_designator = (type === 'DN');
                    this.selected_designator = (history) ? history.searchString : this.defaultSearchString;
                } else if (type === 'IN') {
                    this.show_individual_number = (type === 'IN');
                    this.selected_individual_number = (history) ? history.searchString : this.defaultSearchString;
                } else if (type === 'CK') {
                    this.show_composite_key = (type === 'CK');
                    this.selected_composite_key = (history) ? history.searchString : this.defaultSearchString;
                } else if (type === 'SN') {
                    this.show_dna_sample_number = (type === 'SN');
                    this.selected_dna_sample_number = (history) ? history.searchString : this.defaultSearchString;
                } else if (type === 'MS') {
                    this.show_mito_seq_number = (type === 'MS');
                    this.selected_mito_seq_number = (history) ? history.searchString : this.defaultSearchString;
                } else if (type === 'EN') {
                    this.show_dna_external_number = (type === 'EN');
                    this.selected_dna_external_number = (history) ? history.searchString : this.defaultSearchString;
                } else if (type === 'TAGS') {
                    this.show_tag = (type === 'TAG');
                    this.selected_tags = (history) ? history.searchString : this.defaultSearchString;
                } else if (type === 'DC') {
                    this.show_dental_code = (type === 'DC');
                    this.selected_dental_code = (history) ? history.searchString : this.defaultSearchString;
                } else {
                    this.selected_searchtext = (history) ? history.searchString : this.defaultSearchString;
                }
                // Finally we set the current free form text
                if (this.show_composite_key || this.show_designator ||
                    this.show_dna_sample_number || this.show_mito_seq_number || this.show_dna_external_number) {
                    this.show_searchtext = true;
                    this.selected_searchtext = (history) ? history.searchString : this.defaultSearchString;
                } else {
                    this.show_searchtext = false;
                }
            },
            searchgo: function (event) {
                console.log("Firing Event: SearchGo");
                let searchByOption = this.currentsearchoption.split('-');
                this.searchoptionschange(searchByOption[0], searchByOption[1]);
                let currentSearch = {'searchOption': this.currentsearchoption, 'searchFor': searchByOption[0], 'searchBy': searchByOption[1],
                    'searchString': this.currentSearchString, 'searchName': this.currentSearchName}
                this.$store.dispatch('fetchSearchList', currentSearch).then(() => this.loading = false);
                switch(searchByOption[0]) {
                    case 'SE':
                        return this.returnSpecimenSearchView();
                    case 'DNA':
                        return this.returnDNASearchView();
                    case 'DL':
                        return this.returnDentalSearchView();
                    //case 'ISO':
                    // Create Isotope Search
                }
            },
            searchoptionschange: function (option, type) {
                this.currentSearchString = "";
                this.current_selected_items = [];
                // First set the searchBy
                this.show_bone = (type === 'SB'&& (option !== 'DL'));
                this.show_accession = (type === 'AN');
                this.show_provenance1 = (type === 'P1');
                this.show_provenance2 = (type === 'P2');
                this.show_designator = (type === 'DN');
                this.show_individual_number = (type === 'IN');
                this.show_tag = (type === 'TAGS');
                this.show_composite_key = (type === 'CK');
                this.show_dna_sample_number = (type === 'SN');
                this.show_mito_seq_number = (type === 'MS');
                this.show_dna_external_number = (type === 'EN');
                this.show_tooth = (type === 'SB' && option === 'DL');
                this.show_dental_code = (type === 'DC');
                // Next set the searchString
                if (type === 'SB') {
                    if ( option === "DL") {
                      this.show_tooth = (option === 'DL');
                      this.currentSearchString = this.selected_tooth;
                      this.currentSearchName = 'Tooth';
                    } else {
                      this.show_bone = (type === 'SB');
                      this.currentSearchString = this.selected_bone;
                      this.currentSearchName = 'Bone';
                    }
                } else if (type === 'AN') {
                    this.show_accession = (type === 'AN');
                    this.currentSearchString = this.selected_accession;
                    this.currentSearchName = 'Accession Number';
                    this.current_selected_items = this.$store.state.project.accessions;
                } else if (type === 'P1') {
                    this.show_provenance1 = (type === 'P1');
                    this.currentSearchString = this.selected_provenance1;
                    this.currentSearchName = 'Provenance 1';
                    this.current_selected_items = this.$store.state.project.provenance1;
                } else if (type === 'P2') {
                    this.show_provenance2 = (type === 'P2');
                    this.currentSearchString = this.selected_provenance2;
                    this.currentSearchName = 'Provenance 2';
                    this.current_selected_items = this.$store.state.project.provenance2;
                } else if (type === 'DN') {
                    this.show_designator = (type === 'DN');
                    this.currentSearchString = this.selected_designator;
                    this.currentSearchName = 'Designator';
                } else if (type === 'IN') {
                    this.show_individual_number = (type === 'IN');
                    this.currentSearchString = this.selected_individual_number;
                    this.currentSearchName = 'Individual Number';
                    this.current_selected_items = this.$store.state.project.individual_numbers;
                } else if (type === 'CK') {
                    this.show_composite_key = (type === 'CK');
                    this.currentSearchString = this.selected_composite_key;
                    this.currentSearchName = 'Composite Key';
                } else if (type === 'TAGS') {
                    this.show_tag = (type === 'TAGS');
                    this.currentSearchString = this.selected_tags;
                    this.currentSearchName = 'Tags';
                    if (option === "SE") { this.tag_items = this.$store.state.project.tags.filter(el => el.type === "Specimen") }
                    if (option === "DNA") { this.tag_items = this.$store.state.project.tags.filter(el => el.type === "DNA") }
                    if (option === "ISO") { this.tag_items = this.$store.state.project.tags.filter(el => el.type === "Isotope") }
                    this.current_selected_items = this.tag_items;
                } else if (type === 'SN') {
                    this.show_dna_sample_number = (type === 'SN');
                    this.currentSearchString = this.selected_dna_sample_number;
                    this.currentSearchName = 'Sample Number';
                } else if (type === 'MS') {
                    this.show_mito_seq_number = (type === 'MS');
                    this.currentSearchString = this.selected_mito_seq_number;
                    this.currentSearchName = 'Mito Sequence Number';
                } else if (type === 'EN') {
                    this.show_dna_external_number = (type === 'EN');
                    this.currentSearchString = this.selected_dna_external_number;
                    this.currentSearchName = 'External Number';
                } else if (type === 'DC') {
                    this.show_dental_code = (type === 'DC');
                    this.currentSearchString = this.selected_dental_code;
                    this.currentSearchName = 'Dental Code';
                } else {
                    this.currentSearchString = this.selected_searchtext;
                }
                // Finally we set the current free form text
                if (this.show_composite_key || this.show_designator ||
                    this.show_dna_sample_number || this.show_mito_seq_number || this.show_dna_external_number) {
                    this.show_searchtext = true;
                    this.currentSearchString = this.selected_searchtext;
                } else {
                    this.show_searchtext = false;
                }
            },
            returnSpecimenSearchView: function() {
                axios.get('/skeletalelements/search').then(
                    (response) => location.href="/skeletalelements/search"
                );
            },
            returnDNASearchView: function() {
                axios.get('/dnas/search').then(
                    (response) => location.href="/dnas/search"
                );
            },
            returnDentalSearchView: function() {
                axios.get('/dental/search').then(
                    (response) => location.href="/dental/search"
                );
            },
            handleHistorySearch: function(item) {
                let historyIndex = this.searchHistory.indexOf(item)
                let historyItem = Object.assign({}, item)
                console.log('historyItem: ' + JSON.stringify(historyItem));
                this.currentsearchoption = historyItem.searchOption;
                this.initialize(historyItem);
                this.searchgo();
            },
            handleAddFavoriteSearch: function (item) {
                this.$store.dispatch('fetchFavoriteList', item).then(() => this.loading = false);
            },
            handleDeleteFavoriteSearch: function (item) {
                this.$store.dispatch('deleteFavoriteSearch', item).then(() => this.loading = false);
            },
            removeTag (item) {
                const index = this.$store.state.project.tags.indexOf(item.name)
                if (index >= 0) this.selected_tags.splice(index, 1)
            },
            getDentalCodes() {
                axios
                    .request({
                      url: '/api/dental/',
                      method: 'GET',
                      headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    }).then(response=>{
                      this.dental_code_items = response.data.data;
                    })
            }
        },
        computed: {
            ...mapState({
                //
            }),
            ...mapGetters({
                theUser: 'theUser',
                theProject: 'theProject',
                defaultSearchOption: 'defaultSearchOption',
                defaultSearchString: 'defaultSearchString',
                searchHistory: 'searchHistory',
                searchFavorite: 'searchFavorite',
            }),
          tooth_items(){
             this.tooth_list = this.$store.state.bones.filter(el => el.type === "Tooth");
             return this.tooth_list;
          },
        },
    }
</script>
