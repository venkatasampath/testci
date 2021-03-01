<template>
    <div>
        <v-progress-linear v-if="loading" indeterminate color="primary"></v-progress-linear>
        <v-card>
            <v-card-title>
                <v-row class="align-center justify-center">
                    <v-col>
                        <v-row class="align-center justify-center"><span>Original</span></v-row>
                    </v-col>
                    <v-col>
                        <v-row class="align-center justify-center"><span>Review</span></v-row>
                    </v-col>
                </v-row>
            </v-card-title>
            <v-card-text>
                <!-- First Layer -->
                <div v-if="constructDisplayDNAItems != null || constructDisplayDNAItems.length !== 0">
                <v-expansion-panels v-for="(dna, index) in constructDisplayDNAItems" :key="index">
                    <v-expansion-panel>
                        <v-expansion-panel-header>{{ index }}</v-expansion-panel-header>
                        <v-expansion-panel-content>
                            <!--  Second layer -->
                            <v-expansion-panels>
                                <v-expansion-panel>
                                    <v-expansion-panel-header>General</v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <v-row>
                                            <v-col cols="6">
                                                <!--                                                <v-text-field v-for="(item, key) in dna.base" v-if="key.lastIndexOf('date') === -1 && key!='id' && key.indexOf('lab_id')" :label="generateLabel(key)" v-model="state.original[index][key]"></v-text-field>-->
                                                <v-text-field v-for="(item, key) in dna.base"
                                                              :key="key"
                                                              v-if="key.lastIndexOf('date') === -1 && key!='id' && key.indexOf('lab_id') && key.indexOf('disposition')"
                                                              :label="generateLabel(key)"
                                                              :value="state.original[index][key]"
                                                              @change="v => state.original[index][key] = v"></v-text-field>
                                                <v-autocomplete v-for="(item, key) in dna.base"
                                                                :key="key"
                                                                v-if="key.indexOf('lab_id') !== -1"
                                                                :label="generateLabel(key)"
                                                                v-model="state.original[index][key]"
                                                                :items="list_options.labs"></v-autocomplete>
                                                <v-autocomplete v-for="(item, key) in dna.base"
                                                                :key="key"
                                                                v-if="key.indexOf('disposition') !== -1"
                                                                :label="generateLabel(key)"
                                                                v-model="state.original[index][key]"
                                                                :items="list_options.dispositionoptions"></v-autocomplete>
                                                <v-menu v-for="(item, key) in dna.base"
                                                        :key="key"
                                                        v-if="key.lastIndexOf('date') !== -1"
                                                        v-model="state.original[index][key]"
                                                        :close-on-content-click="false"
                                                        :nudge-right="40"
                                                        transition="scale-transition"
                                                        offset-y
                                                        min-width="290px"
                                                >
                                                    <template v-slot:activator="{ on, attrs }">
                                                        <v-text-field
                                                                :label="generateLabel(key)"
                                                                prepend-icon="mdi-calendar"
                                                                readonly
                                                                v-bind="attrs"
                                                                v-on="on"
                                                        ></v-text-field>
                                                    </template>
                                                    <v-date-picker

                                                    ></v-date-picker>
                                                </v-menu>
                                            </v-col>
                                            <v-col cols="6">
                                                <v-text-field v-for="(item, key) in dna.base"
                                                              :key="key"
                                                              v-if="key.lastIndexOf('date') === -1 && key!='id' && key.indexOf('lab_id') && key.indexOf('disposition')"
                                                              :label="generateLabel(key)"
                                                              :value="state.review[index][key]"
                                                              @change="v => state.review[index][key] = v"></v-text-field>
                                                <v-autocomplete v-for="(item, key) in dna.base"
                                                                :key="key"
                                                                v-if="key.indexOf('lab_id') !== -1"
                                                                :label="generateLabel(key)"
                                                                v-model="state.review[index][key]"
                                                                :items="list_options.labs"></v-autocomplete>
                                                <v-autocomplete v-for="(item, key) in dna.base"
                                                                :key="key"
                                                                v-if="key.indexOf('disposition') !== -1"
                                                                :label="generateLabel(key)"
                                                                v-model="state.original[index][key]"
                                                                :items="list_options.dispositionoptions"></v-autocomplete>
                                                <v-menu v-for="(item, key) in dna.base"
                                                        :key="key"
                                                        v-if="key.lastIndexOf('date') !== -1"
                                                        :close-on-content-click="false"
                                                        :nudge-right="40"
                                                        transition="scale-transition"
                                                        offset-y
                                                        min-width="290px"
                                                >
                                                    <template v-slot:activator="{ on, attrs }">
                                                        <v-text-field
                                                                :label="generateLabel(key)"
                                                                prepend-icon="mdi-calendar"
                                                                readonly
                                                                v-bind="attrs"
                                                                v-on="on"
                                                                v-model="state.review[index][key]"
                                                        ></v-text-field>
                                                    </template>
                                                    <v-date-picker

                                                    ></v-date-picker>
                                                </v-menu>
                                            </v-col>
                                        </v-row>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                            </v-expansion-panels>
                            <v-expansion-panels>
                                <v-expansion-panel>
                                    <v-expansion-panel-header>auSTR</v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <v-row>
                                            <v-col cols="6">
                                                <v-autocomplete v-for="(item, key) in dna.austr"
                                                                :key="key"
                                                                v-if="key.indexOf('austr_method') !== -1"
                                                                :label="generateLabel(key)"
                                                                v-model="state.original[index][key]"
                                                                :items="list_options.austrmethodoptions"></v-autocomplete>
                                                <v-autocomplete v-for="(item, key) in dna.austr"
                                                                :key="key"
                                                                v-if="key.indexOf('austr_results_confidence') !== -1"
                                                                :label="generateLabel(key)"
                                                                v-model="state.original[index][key]"
                                                                :items="list_options.austrstatusoptions"></v-autocomplete>
                                                <v-text-field v-for="(item, key) in dna.austr"
                                                              :key="key"
                                                              v-if="key.lastIndexOf('date') === -1 && key.indexOf('austr_results_confidence') && key.indexOf('austr_method')"
                                                              :label="generateLabel(key)"
                                                              v-model="state.original[index][key]"></v-text-field>
                                                <v-menu v-for="(item, key) in dna.austr"
                                                        :key="key"
                                                        v-if="key.lastIndexOf('date') !== -1"
                                                        :close-on-content-click="false"
                                                        :nudge-right="40"
                                                        transition="scale-transition"
                                                        offset-y
                                                        min-width="290px"
                                                >
                                                    <template v-slot:activator="{ on, attrs }">
                                                        <v-text-field
                                                                :label="generateLabel(key)"
                                                                prepend-icon="mdi-calendar"
                                                                readonly
                                                                v-bind="attrs"
                                                                v-on="on"
                                                        ></v-text-field>
                                                    </template>
                                                    <v-date-picker

                                                    ></v-date-picker>
                                                </v-menu>
                                            </v-col>
                                            <v-col cols="6">
                                                <v-autocomplete v-for="(item, key) in dna.austr"
                                                                :key="key"
                                                                v-if="key.indexOf('austr_method') !== -1"
                                                                :label="generateLabel(key)"
                                                                v-model="state.review[index][key]"
                                                                :items="list_options.austrmethodoptions"></v-autocomplete>
                                                <v-autocomplete v-for="(item, key) in dna.austr"
                                                                :key="key"
                                                                v-if="key.indexOf('austr_results_confidence') !== -1"
                                                                :label="generateLabel(key)"
                                                                v-model="state.review[index][key]"
                                                                :items="list_options.austrstatusoptions"></v-autocomplete>
                                                <v-text-field v-for="(item, key) in dna.austr"
                                                              :key="key"
                                                              v-if="key.lastIndexOf('date') === -1 && key.indexOf('austr_results_confidence') && key.indexOf('austr_method')"
                                                              :label="generateLabel(key)"
                                                              v-model="state.review[index][key]"></v-text-field>
                                                <v-menu v-for="(item, key) in dna.austr"
                                                        :key="key"
                                                        v-if="key.lastIndexOf('date') !== -1"
                                                        :close-on-content-click="false"
                                                        :nudge-right="40"
                                                        transition="scale-transition"
                                                        offset-y
                                                        min-width="290px"
                                                >
                                                    <template v-slot:activator="{ on, attrs }">
                                                        <v-text-field
                                                                :label="generateLabel(key)"
                                                                prepend-icon="mdi-calendar"
                                                                readonly
                                                                v-bind="attrs"
                                                                v-on="on"
                                                        ></v-text-field>
                                                    </template>
                                                    <v-date-picker

                                                    ></v-date-picker>
                                                </v-menu>
                                            </v-col>
                                        </v-row>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                            </v-expansion-panels>
                            <v-expansion-panels>
                                <v-expansion-panel>
                                    <v-expansion-panel-header>Mito</v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <v-row>
                                            <v-col cols="6">
                                                <v-autocomplete v-for="(item, key) in dna.mito"
                                                                :key="key"
                                                                v-if="key.indexOf('mito_method') !== -1"
                                                                :label="generateLabel(key)"
                                                                v-model="state.original[index][key]"
                                                                :items="list_options.mitomethodoptions"></v-autocomplete>
                                                <v-text-field v-for="(item, key) in dna.mito"
                                                              :key="key"
                                                              v-if="key.lastIndexOf('date') === -1 && key.indexOf('mito_results_confidence') && key.indexOf('mito_haplogroup_id') && key.indexOf('mito_method')"
                                                              :label="generateLabel(key)"
                                                              v-model="state.original[index][key]"></v-text-field>
                                                <v-autocomplete v-for="(item, key) in dna.mito"
                                                                :key="key"
                                                                v-if="key.indexOf('mito_results_confidence') !== -1"
                                                                :label="generateLabel(key)"
                                                                v-model="state.original[index][key]"
                                                                :items="list_options.list_confidence"></v-autocomplete>
                                                <v-autocomplete v-for="(item, key) in dna.mito"
                                                                :key="key"
                                                                v-if="key.indexOf('mito_haplogroup_id') !== -1"
                                                                :label="generateLabel(key)"
                                                                v-model="state.original[index][key]"
                                                                :items="list_options.mitohaplooptions"></v-autocomplete>
                                                <v-menu v-for="(item, key) in dna.mito"
                                                        :key="key"
                                                        v-if="key.lastIndexOf('date') !== -1"
                                                        :close-on-content-click="false"
                                                        :nudge-right="40"
                                                        transition="scale-transition"
                                                        offset-y
                                                        min-width="290px"
                                                >
                                                    <template v-slot:activator="{ on, attrs }">
                                                        <v-text-field
                                                                :label="generateLabel(key)"
                                                                prepend-icon="mdi-calendar"
                                                                readonly
                                                                v-bind="attrs"
                                                                v-on="on"
                                                        ></v-text-field>
                                                    </template>
                                                    <v-date-picker

                                                    ></v-date-picker>
                                                </v-menu>
                                            </v-col>
                                            <v-col cols="6">
                                                <v-autocomplete v-for="(item, key) in dna.mito"
                                                                :key="key"
                                                                v-if="key.indexOf('mito_method') !== -1"
                                                                :label="generateLabel(key)"
                                                                v-model="state.review[index][key]"
                                                                :items="list_options.mitomethodoptions"></v-autocomplete>
                                                <v-text-field v-for="(item, key) in dna.mito"
                                                              :key="key"
                                                              v-if="key.lastIndexOf('date') === -1 && key.indexOf('mito_results_confidence') && key.indexOf('mito_haplogroup_id') && key.indexOf('mito_method')"
                                                              :label="generateLabel(key)"
                                                              v-model="state.review[index][key]"></v-text-field>
                                                <v-autocomplete v-for="(item, key) in dna.mito"
                                                                :key="key"
                                                                v-if="key.indexOf('mito_results_confidence') !== -1"
                                                                :label="generateLabel(key)"
                                                                v-model="state.review[index][key]"
                                                                :items="list_options.list_confidence"></v-autocomplete>
                                                <v-autocomplete v-for="(item, key) in dna.mito"
                                                                :key="key"
                                                                v-if="key.indexOf('mito_haplogroup_id') !== -1"
                                                                :label="generateLabel(key)"
                                                                v-model="state.review[index][key]"
                                                                :items="list_options.mitohaplooptions"></v-autocomplete>
                                                <v-menu v-for="(item, key) in dna.mito"
                                                        :key="key"
                                                        v-if="key.lastIndexOf('date') !== -1"
                                                        :close-on-content-click="false"
                                                        :nudge-right="40"
                                                        transition="scale-transition"
                                                        offset-y
                                                        min-width="290px"
                                                >
                                                    <template v-slot:activator="{ on, attrs }">
                                                        <v-text-field
                                                                :label="generateLabel(key)"
                                                                prepend-icon="mdi-calendar"
                                                                readonly
                                                                v-bind="attrs"
                                                                v-on="on"
                                                        ></v-text-field>
                                                    </template>
                                                    <v-date-picker

                                                    ></v-date-picker>
                                                </v-menu>
                                            </v-col>
                                        </v-row>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                            </v-expansion-panels>
                            <v-expansion-panels>
                                <v-expansion-panel>
                                    <v-expansion-panel-header>ySTR</v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <v-row>
                                            <v-col cols="6">
                                                <v-autocomplete v-for="(item, key) in dna.ystr"
                                                                :key="key"
                                                                v-if="key.indexOf('ystr_method') !== -1"
                                                                :label="generateLabel(key)"
                                                                v-model="state.original[index][key]"
                                                                :items="list_options.ystrmethodoptions"></v-autocomplete>
                                                <v-text-field v-for="(item, key) in dna.ystr"
                                                              :key="key"
                                                              v-if="key.lastIndexOf('date') === -1 && key.indexOf('ystr_method') && key.indexOf('ystr_results_confidence') && key.indexOf('ystr_haplogroup') "
                                                              :label="generateLabel(key)"
                                                              v-model="state.original[index][key]"></v-text-field>
                                                <v-autocomplete v-for="(item, key) in dna.ystr"
                                                                :key="key"
                                                                v-if="key.indexOf('ystr_results_confidence') !== -1"
                                                                :label="generateLabel(key)"
                                                                v-model="state.original[index][key]"
                                                                :items="list_options.list_confidence"></v-autocomplete>
                                                <v-autocomplete v-for="(item, key) in dna.ystr"
                                                                :key="key"
                                                                v-if="key.indexOf('ystr_haplogroup') !== -1"
                                                                :label="generateLabel(key)"
                                                                v-model="state.original[index][key]"
                                                                :items="list_options.ystrhaplooptions"></v-autocomplete>


                                                <v-menu v-for="(item, key) in dna.ystr"
                                                        :key="key"
                                                        v-if="key.lastIndexOf('date') !== -1"
                                                        :close-on-content-click="false"
                                                        :nudge-right="40"
                                                        transition="scale-transition"
                                                        offset-y
                                                        min-width="290px"
                                                >
                                                    <template v-slot:activator="{ on, attrs }">
                                                        <v-text-field
                                                                :label="generateLabel(key)"
                                                                prepend-icon="mdi-calendar"
                                                                readonly
                                                                v-bind="attrs"
                                                                v-on="on"
                                                        ></v-text-field>
                                                    </template>
                                                    <v-date-picker

                                                    ></v-date-picker>
                                                </v-menu>
                                            </v-col>
                                            <v-col cols="6">
                                                <v-autocomplete v-for="(item, key) in dna.ystr"
                                                                :key="key"
                                                                v-if="key.indexOf('ystr_method') !== -1"
                                                                :label="generateLabel(key)"
                                                                v-model="state.review[index][key]"
                                                                :items="list_options.ystrmethodoptions"></v-autocomplete>
                                                <v-text-field v-for="(item, key) in dna.ystr"
                                                              :key="key"
                                                              v-if="key.lastIndexOf('date') === -1 && key.indexOf('ystr_method') && key.indexOf('ystr_results_confidence') && key.indexOf('ystr_haplogroup')"
                                                              :label="generateLabel(key)"
                                                              v-model="state.review[index][key]"></v-text-field>
                                                <v-autocomplete v-for="(item, key) in dna.ystr"
                                                                :key="key"
                                                                v-if="key.indexOf('ystr_results_confidence') !== -1"
                                                                :label="generateLabel(key)"
                                                                v-model="state.review[index][key]"
                                                                :items="list_options.list_confidence"></v-autocomplete>
                                                <v-autocomplete v-for="(item, key) in dna.ystr"
                                                                :key="key"
                                                                v-if="key.indexOf('ystr_haplogroup') !== -1"
                                                                :label="generateLabel(key)"
                                                                v-model="state.review[index][key]"
                                                                :items="list_options.ystrhaplooptions"></v-autocomplete>
                                                <v-menu v-for="(item, key) in dna.ystr"
                                                        :key="key"
                                                        v-if="key.lastIndexOf('date') !== -1"
                                                        :close-on-content-click="false"
                                                        :nudge-right="40"
                                                        transition="scale-transition"
                                                        offset-y
                                                        min-width="290px"
                                                >
                                                    <template v-slot:activator="{ on, attrs }">
                                                        <v-text-field
                                                                :label="generateLabel(key)"
                                                                prepend-icon="mdi-calendar"
                                                                readonly
                                                                v-bind="attrs"
                                                                v-on="on"
                                                        ></v-text-field>
                                                    </template>
                                                    <v-date-picker

                                                    ></v-date-picker>
                                                </v-menu>
                                            </v-col>
                                        </v-row>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                            </v-expansion-panels>
                            <v-row class="justify-center pt-5">
                                <v-btn v-if="show_save" color="primary" class="mr-2" @click="save(index)"
                                       dusk="dna-review-save">
                                    <v-icon class="mr-2">mdi-content-save</v-icon>
                                    Save
                                </v-btn>
                                <v-btn v-if="show_accept" color="primary" @click="accept(index)"
                                       dusk="dna-review-accept">
                                    <v-icon class="mr-2">mdi-thumb-up-outline</v-icon>
                                    Accept
                                </v-btn>
                            </v-row>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>
                </div>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
    import axios from 'axios';
    import {mapGetters, mapState} from "vuex";
    import {eventBus} from "../../../eventBus";
    import {changeObjectToArray} from "../../../coraBaseModules";


    export default {
        name: "review-dna",
        props: {
            specimen: {type: Object | Array, required: true},
            methodoptions: Object,
            haplooptions: Object,
            austrmethodoptions: Object,
            ystrmethodoptions: Object,
            ystrhaplooptions: [Object, Array],
            austrstatusoptions: '',
            statusoptions: Object,
            dispositionoptions: Object,
            conditionoptions: Object,
            mitohaplooptions: [Object, Array],
            mitomethodoptions: [Object, Array],
            list_confidence: [Object, Array],
        },
        data() {
            return {
                loading: true,
                fully_loaded: false,
                show_save: true,
                show_accept: false,
                items: [],
                list_options: [],
                state: {
                    type: "dnas",
                    original: {},
                    review: {},
                    diff: null,
                    action: {create: false, edit: false,},
                    reviewRecord: null,
                },
                hint: "",
                placeholder: "",
                list_items: [],
            }
        },
        created() {
            this.loadOriginal();
            this.show_save = (this.theUser.id !== this.specimen.user_id) || (this.isAdminOrOrgAdmin || this.isProjectManager);
            this.show_accept = (this.theUser.id === this.specimen.user_id) || (this.isAdminOrOrgAdmin || this.isProjectManager);
        },
        mounted() {
            this.initDropdownList();
        },
        methods: {
            loadOriginal() {
                for (const dna in this.specimen.dnas) {
                    this.state.original[this.specimen.dnas[dna].sample_number] = this.specimen.dnas[dna];
                    this.state.review[this.specimen.dnas[dna].sample_number] = Object.assign({}, this.specimen.dnas[dna]);
                }
                for (let item in this.state.review) {
                    Object.keys(this.state.review[item]).forEach((key) => {
                        if (key !== 'id' && key !== "se_id" && key !== "org_id" && key !== "project_id" && key !== "uuid" && key !== "user_id" && key !== "sb_id" && key !== "created_at" && key !== "created_by") {
                            if (key === 'additional_testing') {
                                this.state.review[item][key] = false;
                            } else {
                                this.state.review[item][key] = null;
                            }
                        }
                    })
                }
                this.loadReview();
            },
            loadReview() {
                this.loading = true;
                Object.keys(this.state.review).forEach((key) => {
                    this.loading = true;
                    axios({
                        url: "/api/review/" + this.specimen.id, method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        },
                        params: {"type": "dna" + "-" + key,},
                    }).then((response) => {
                        if (response.data.data.review) {
                            var responseData = JSON.parse(response.data.data.review);
                            for (const dna in responseData) {
                                this.state.review[key] = responseData;
                            }
                        }
                        this.loading = false;
                        if (this.fully_loaded) {
                            eventBus.$emit('review', {'type': this.state.type, 'state': this.state});
                        }
                        this.loading = false;
                        this.fully_loaded = true;
                    }).catch((error) => {
                        console.log(error);
                        this.loading = false;
                    });
                })
            },
            save(key) {
                this.loading = true;
                axios
                    .request({
                        url: "/api/review", method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        },
                        data: {
                            "se_id": this.specimen.id,
                            "type": "dna",
                            "original": this.state.original[key],
                            "review": this.state.review[key],
                            "dna_id": key,
                        }
                    })
                    .then(response => {
                        this.loading = false;
                        let payload = {'text': 'Update successful', 'color': 'success',};
                        eventBus.$emit('show-snackbar', payload);
                        this.state.action.create = false;
                        this.state.action.edit = true;
                        eventBus.$emit('review', {'type': this.state.type, 'state': this.state});

                    }).catch(error => {
                    console.log(error.response);
                    this.loading = false;
                    let payload = {'text': 'Update failed', 'color': 'error',};
                    eventBus.$emit('show-snackbar', payload);
                })
            },
            accept(key) {
                this.loading = true;
                axios
                    .request({
                        url: "/api/review/" + this.specimen.id + "/accept", method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        },
                        data: {
                            "se_id": this.specimen.id,
                            "type": "dna",
                            "review": this.state.review[key],
                            "dna_id": key,
                        }
                    })
                    .then(response => {
                        this.loading = false;
                        // console.log(response);
                        let payload = {'text': 'Update successful', 'color': 'success',};
                        eventBus.$emit('show-snackbar', payload);
                        this.state.action.create = false;
                        this.state.action.edit = true;
                        eventBus.$emit('review', {'type': this.state.type, 'state': this.state});
                        location.reload();
                    }).catch(error => {
                    console.log(error.response);
                    this.loading = false;
                    let payload = {'text': 'Update failed', 'color': 'error',};
                    eventBus.$emit('show-snackbar', payload);
                })
            },
            initDropdownList() {
                const labs = this.getLabs("Genomics");

                this.list_options = {};
                this.list_options["labs"] = labs.map(lab => {
                    return {"text": lab.name, "value": lab.id}
                });
                this.list_options["methodoptions"] = changeObjectToArray(this.methodoptions);
                this.list_options["haplooptions"] = this.haplooptions;
                this.list_options["austrmethodoptions"] = changeObjectToArray(this.austrmethodoptions);
                this.list_options["ystrmethodoptions"] = changeObjectToArray(this.ystrmethodoptions);
                this.list_options["ystrhaplooptions"] = this.ystrhaplooptions;
                this.list_options["statusoptions"] = this.statusoptions;
                this.list_options["dispositionoptions"] = changeObjectToArray(this.dispositionoptions);
                this.list_options["conditionoptions"] = changeObjectToArray(this.conditionoptions);
                this.list_options["austrstatusoptions"] = changeObjectToArray(this.austrstatusoptions);
                this.list_options["mitohaplooptions"] = changeObjectToArray(this.mitohaplooptions);
                this.list_options["mitomethodoptions"] = changeObjectToArray(this.mitomethodoptions);
                this.list_options["list_confidence"] = changeObjectToArray(this.list_confidence);
            },
            generateLabel(key) {
                if (key === null) return null;
                if (key === 'external_sample_number') return 'Sample Number';

                key = key.replace(/_/g, ' ').replace(/(?: |\b)(\w)/g, function (key) {
                    return key.toUpperCase()
                });
                if (key.lastIndexOf("Id")) {
                    key = key.replace("Id", "");
                }
                return key;
            }
        },
        computed: {
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
                getMeasurementsByBone: 'getMeasurementsByBone',
                isAdminOrOrgAdmin: 'isAdminOrOrgAdmin',
                isProjectManager: 'isProjectManager',
                getLabs: 'getLabs',
            }),
            constructDisplayDNAItems() {
                const austrArray = ["austr_loci", "austr_match_count", "austr_mcc_date", "austr_method", "austr_num_loci", "austr_total_count",
                    "austr_sequence_number", "austr_results_confidence"];

                const baseArray = ["external_sample_number", "dispostion_of_evidence", "lab_id", "locus", "notes", "dispostion_of_evidence",
                    "disposition", "btb_request_date", "btb_results_date", "additional_testing", "external_case_id", "id"];

                const mitoArray = ["mito_base_pairs", "mito_confirmed_regions", "mito_fasta_sequence", "mito_haplogroup_id", "mito_haplosubgroup", "mito_match_count",
                    "mito_mcc_date", "mito_method", "mito_num_loci", "mito_polymorphism", "mito_receive_date", "mito_request_date", "mito_results_confidence",
                    "mito_sequence_number", "mito_sequence_similar", "mito_sequence_subgroup", "mito_total_count"];

                const ystrArray = ["ystr_haplogroup", "ystr_loci", "ystr_match_count", "ystr_mcc_date", "ystr_method", "ystr_num_loci", "ystr_receive_date",
                    "ystr_request_date", "ystr_results_confidence", "ystr_sequence_number", "ystr_sequence_similar", "ystr_sequence_subgroup", "ystr_total_count"];

                let displayArray = {};


                if (this.specimen.dnas !== 'undefined') {
                    this.specimen.dnas.map((dna) => {
                        let tempArray = {};

                        tempArray["austr"] = {};
                        tempArray["ystr"] = {};
                        tempArray["mito"] = {};
                        tempArray["base"] = {};


                        for (const [key, value] of Object.entries(dna)) {
                            if (austrArray.includes(key)) {
                                tempArray.austr[key] = value;
                            }

                            if (baseArray.includes(key)) {
                                tempArray.base[key] = value;
                            }

                            if (mitoArray.includes(key)) {
                                tempArray.mito[key] = value;
                            }

                            if (ystrArray.includes(key)) {
                                tempArray.ystr[key] = value;
                            }
                        }

                        displayArray[dna.sample_number] = tempArray;
                    });
                }
                return displayArray;
            }

        }
    }
</script>