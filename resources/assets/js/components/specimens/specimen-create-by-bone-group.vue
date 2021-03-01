<template>
    <div class="m-2">
        <contentheader :trail="this.trail" :title="this.heading" :save_menu="true" model_name="specimen-group"></contentheader>
        <v-alert v-if="alert" class="my-1" border="left" colored-border type="info" elevation="2" dismissible>{{alertText}}</v-alert>
        <v-card>
            <v-form action="storebygroup/" method="POST" @submit.prevent="buildSubmitObject" ref="myFormGroup" v-model="isFormValid">
                <input type="hidden" name="_token" :value="csrfToken">
            <v-card-text>
                <v-stepper v-model="step">
                    <v-stepper-header>
                        <v-stepper-step editable :complete="step > 1" step="1" dusk="se-grouping">Bone Group</v-stepper-step>
                        <v-divider></v-divider>
                        <v-stepper-step editable :complete="step > 2" step="2" dusk="accession-number-group">Accession</v-stepper-step>
                        <v-divider></v-divider>
                        <v-stepper-step editable :complete="step > 3" step="3" dusk="se-pathology-select">Pathology <small>Optional</small></v-stepper-step>
                    </v-stepper-header>
                    <v-stepper-content step="1">
                        <v-card>
                            <v-row class="px-2">
                                <v-col cols="3">
                                    <v-autocomplete v-model="form.bone_group" label="Bone Group" dusk="se-bone-grouping"
                                                    :items="items_boneGroups" clearable @change="changeBoneGroup">
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="3">
                                    <v-autocomplete  v-model="form.side" label="Side" placeholder="Select Side" dusk="se-side"
                                                     :items="items_side" :disabled="disable_side" clearable>
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="3"><completeness @input="(val) => {form.compleatness = val}"/></v-col>
                            </v-row>
                            <v-row  class="px-2">
                                <v-col>
                                    <v-autocomplete v-model="form.bones" :items="items_bones" :label="(form.bones)?'Bones: '+form.bones.length.toString():'Bones'" dusk="se-bone-select"
                                                    :disabled="disabled" :loading="loading" chips deletable-chips multiple clearable>
                                    </v-autocomplete>
                                </v-col>
                            </v-row>
                        </v-card>
                        <v-card-actions>
                            <v-row class="justify-center">
                                <v-btn title="Next" color="primary" dusk="se-next" @click="step = 2"><v-icon>mdi-step-forward</v-icon>Next</v-btn>
                            </v-row>
                        </v-card-actions>
                    </v-stepper-content>

                    <v-stepper-content step="2">
                        <v-card flat>
                            <v-row  class="px-2">
                                <v-col cols="12" md="3"><an :value="form.accession_number" @input="(val) => {form.accession_number = val}"/></v-col>
                                <v-col cols="12" md="3"><p1 :value="form.provenance1" @input="(val) => {form.provenance1 = val}"/></v-col>
                                <v-col cols="12" md="3"><p2 :value="form.provenance2" @input="(val) => {form.provenance2 = val}"/></v-col>
                                <v-col cols="12" md="3" v-if="!theProject.use_auto_incrementing_designator">
                                    <dn label="Starting Designator" @input="(val) => {form.starting_designator = val}"/>
                                </v-col>
                            </v-row>
                        </v-card>
                        <v-card-actions>
                            <v-row class="justify-center">
                                <v-btn title="Next" class="mr-2" color="primary" dusk="se-next1" @click="step = 3"><v-icon>mdi-step-forward</v-icon>Next</v-btn>
                                <v-btn title="Previous" color="primary" dusk="se-previous" @click="step = 1"><v-icon>mdi-step-backward</v-icon>Previous</v-btn>
                            </v-row>
                        </v-card-actions>
                    </v-stepper-content>

                    <v-stepper-content step="3">
                        <v-card flat>
                            <v-row class="px-2">
                                <v-col cols="12" md="4">
                                    <v-autocomplete v-model="form.taphonomys" label="Taphonomies" filled chips deletable-chips multiple clearable dusk="se-taphonomys"
                                                    :hint="hint.taphonomy" persistent-hint placeholder="Select taphonomies"
                                                    :items="items_taphonomies" item-text="name" item-value="id">
                                        <template v-slot:selection="data">
                                            <v-chip v-bind="data.attrs" :input-value="data.selected" :color="data.item.color" close @click="data.select" dusk="clear-se-taph" @click:close="remove(data.item)">
                                                <v-icon v-if="data.item.icon" left>{{data.item.icon}}</v-icon>{{ data.item.name}}
                                            </v-chip>
                                        </template>
                                        <template v-slot:item="data">
                                            <template v-if="typeof data.item !== 'object'"><v-list-item-content v-text="data.item" dusk="se-taph"></v-list-item-content></template>
                                            <template v-else>
                                                <v-list-item-avatar class="headline" left :color="data.item.color"><v-icon>{{ data.item.icon }}</v-icon></v-list-item-avatar>
                                                <v-list-item-content :background-color="data.item.color" dusk="se-taph">
                                                    <v-list-item-title v-html="data.item.name"></v-list-item-title>
                                                </v-list-item-content>
                                            </template>
                                        </template>
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="12" md="4">
                                    <v-autocomplete v-model="form.pathologys" label="Pathologies" filled chips deletable-chips multiple dusk="se-pathologys"
                                                    :hint="hint.pathology" persistent-hint placeholder="Select pathologies"
                                                    :items="items_pathologies" item-name="name" item-value="id">
                                        <template v-slot:selection="data">
                                            <v-chip v-bind="data.attrs" :input-value="data.selected" :color="data.item.color" close @click="data.select" dusk="clear-se-path" @click:close="remove(data.item)">
                                                <v-icon v-if="data.item.icon" left>{{data.item.icon}}</v-icon>{{ data.item.name}}
                                            </v-chip>
                                        </template>
                                        <template v-slot:item="data">
                                            <template v-if="typeof data.item !== 'object'"><v-list-item-content v-text="data.item" dusk="se-path"></v-list-item-content></template>
                                            <template v-else>
                                                <v-list-item-avatar class="headline" left :color="data.item.color"><v-icon>{{ data.item.icon }}</v-icon></v-list-item-avatar>
                                                <v-list-item-content :background-color="data.item.color" dusk="se-path">
                                                    <v-list-item-title v-html="data.item.name"></v-list-item-title>
                                                </v-list-item-content>
                                            </template>
                                        </template>
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="12" md="4">
                                    <v-autocomplete v-model="form.traumas" label="Traumas" filled chips deletable-chips multiple dusk="se-traumas"
                                                    :hint="hint.trauma" persistent-hint placeholder="Select traumas"
                                                    :items="items_traumas" item-name="name" item-value="id">
                                        <template v-slot:selection="data">
                                            <v-chip v-bind="data.attrs" :input-value="data.selected" :color="data.item.color" close @click="data.select" dusk="clear-se-trauma" @click:close="remove(data.item)">
                                                <v-icon v-if="data.item.icon" left>{{data.item.icon}}</v-icon>{{ data.item.name}}
                                            </v-chip>
                                        </template>
                                        <template v-slot:item="data">
                                            <template v-if="typeof data.item !== 'object'"><v-list-item-content v-text="data.item" dusk="se-trauma"></v-list-item-content></template>
                                            <template v-else>
                                                <v-list-item-avatar class="headline" left :color="data.item.color"><v-icon>{{ data.item.icon }}</v-icon></v-list-item-avatar>
                                                <v-list-item-content :background-color="data.item.color" dusk="se-trauma">
                                                    <v-list-item-title v-html="data.item.name"></v-list-item-title>
                                                </v-list-item-content>
                                            </template>
                                        </template>
                                    </v-autocomplete>
                                </v-col>
                            </v-row>
                        </v-card>
                        <v-card-actions>
                            <v-row class="justify-center">
                                <v-btn title="Previous" color="primary" dusk="se-previous" @click="step = 2"><v-icon>mdi-step-backward</v-icon>Previous</v-btn>
                            </v-row>
                        </v-card-actions>
                    </v-stepper-content>
                </v-stepper>
            </v-card-text>
            <v-card-actions>
                <v-row class="justify-center">
                    <v-btn title="Save" color="primary" dusk = "save-button" class="mr-2" type="submit" :disabled="!isFormValid"><v-icon class="mr-2">mdi-content-save</v-icon>Save</v-btn>
<!--                    <v-btn title="Save" color="primary" class="mr-2" @click="save_n_add" :disabled="!isFormValid"><v-icon class="mr-2">mdi-content-save</v-icon>Save and Add</v-btn>-->
                </v-row>
            </v-card-actions>
            </v-form>
        </v-card>
    </div>
</template>

<script>
    import {mapState, mapGetters, mapActions} from 'vuex';
    import {bus} from "../../coraBaseModules";
    import axios from "axios";

    export default {
        name: "specimenCreateByBoneGroup",
        props: {
            heading: { type: String, default: "" },
            text: {type: Object, default: () => {}},
        },
        data() {
            return {
                loading: false,
                disable_side: false,
                showSave: false,
                showEdit: false,
                step: 1,
                items_bones: [],
                disabled: true,
                submitObject: {},
                isFormValid: false,
                trail: [{ text: 'Home', disabled: false, href: '/', },
                    { text: 'Create Specimens by Bone Group', disabled: true, href: '/skeletalelements/createbygroup', },
                ],
                rules: {
                    bone_group: [v => !!v || 'Bone group is required'],
                    bones: [v => !!v || 'Bones are required'],
                    side: [v => !!v || 'Side is required'],
                    completeness: [v => !!v || 'Completeness is required'],
                    accession_number: [v => !!v || 'Accession is required'],
                    starting_designator: [v => !!v || 'Starting Designator is required'],
                },
                form: { org_id: null, project_id: null, bone_group: "", bones: [], side: 'Left', completeness: 'Complete',
                    accession_number: null, provenance1: null, provenance2: null, starting_designator: null,
                    taphonomys: null, traumas: null, pathologys: null,
                },
                hint: {
                    taphonomy: "You can apply multiple taphonomies to this bone group",
                    trauma: "You can apply multiple traumas to this bone group",
                    pathology: "You can apply multiple pathologies to this bone group",
                },
                side: "Left",
                items_side: null,
                items_side_all: ["Left", "Right", "Middle", "Unsided"],
                items_side_minus_middle: ["Left", "Right", "Unsided"],
                bone_group_list:[],
                alert: false,
                alertText: "",
            }
        },
        created() {
            this.items_side = this.items_side_all;

            //Bone Pathology
            bus.$on('boneTrauma', (data) => { this.boneTrauma = data; });
            bus.$on('bonePathology', (data) => { this.bonePathology = data; });
            bus.$on('boneTaphonomy', (data) => { this.boneTaphonomy = data; });
        },
        mounted() {
            //
        },
        methods: {
            changeBoneGroup() {
                console.log("changeBoneGroup fired: group: " + this.form.bone_group);
                if (this.form.bone_group) {
                    // first get the bones in this bone group from server.
                    this.getBoneList();

                    // next change side based on bone group.
                    let groups = this.$store.getters.getBonesInGroup(this.form.bone_group.toString());
                    this.items_side = (groups[0].middle)?this.items_side_all:this.items_side_minus_middle;
                    this.form.side = (groups[0].middle)?"Middle":"Left";
                    this.disable_side = !!(groups[0].middle);
                } else {
                    this.items_bones = this.form.bones = [];
                    this.items_side = this.items_side_all;
                    this.form.side = "Left";
                    this.disable_side = false;
                }
            },
            getBoneList() {
                console.log(this.form.bone_group);
                this.disabled = false;
                this.loading = true;
                this.form.bones = [];
                axios
                    .request({ url: "/api/base-data/bones-in-group", method: 'GET', params: { "group": this.form.bone_group.toString(), },
                        headers: { 'Content-Type': 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    }).then(response => {
                        // console.log(response.data.data);
                        this.form.bones = Object.keys(response.data.data);
                        this.items_bones = Object.keys(response.data.data);
                        this.loading = false
                    }).catch(error => {
                        console.log(error.response);
                        this.loading = false
                    })
            },
            buildSubmitObject(e) {
                //submit the form
                e.target.elements.bone_select.value = this.form.bones;
                e.target.elements.trauma_select.value = this.boneTrauma;
                e.target.elements.pathology_select.value = this.bonePathology;
                e.target.elements.taphonomy_select.value = this.boneTaphonomy;

                console.log(e.target.elements.bone_select);
                this.$refs.myFormGroup.$el.submit();
            },
            remove(item) {
                const index = this.taphonomys.indexOf(item.id);
                if (index >= 0) this.taphonomys.splice(index, 1)
            },
        },
        watch: {
            //
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
                csrfToken: 'csrfToken',
                items_taphonomies: 'getTaphonomies',
                items_pathologies: 'getPathologies',
                items_traumas: 'getTraumas',
            }),
            items_boneGroups() {
                this.bone_group_list = this.$store.getters.getBoneGroupsList;
                if(this.text.bone_group_filter){
                    this.bone_group_list = this.bone_group_list.filter( el => { return el.includes("dentition")})
                }
                return this.bone_group_list;
            },
        },
    }
</script>