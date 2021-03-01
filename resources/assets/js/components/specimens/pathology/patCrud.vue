<template>
    <v-dialog v-model="dialog" max-width="50%">
        <v-card>
            <v-card-title class="m-0 p-0">
                <v-toolbar dense>
                    <v-btn icon><v-icon color="gray" class="p-2">mdi-skull</v-icon></v-btn>
                    <v-spacer></v-spacer>
                    <v-toolbar-title>{{title}}</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-progress-circular v-if="loading" :indeterminate="loading" color="primary"></v-progress-circular>
                    <v-btn icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
                </v-toolbar>
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="6">
                        <v-autocomplete v-model="item.zone_ids" label="Select Zones" :disabled="disabled" chips deletable-chips multiple
                                        :items="zones" item-value="id" item-text="display_name">
                        </v-autocomplete>
                    </v-col>
                    <v-col cols="6" v-if="show_pathology">
                        <v-autocomplete v-model="item.id" label="Select Pathology" :disabled="disabled" chips deletable-chips
                                        :items="pathologies" item-value="id" item-text="name">
                        </v-autocomplete>
                    </v-col>
                    <v-col cols="6" v-if="show_trauma">
                        <v-autocomplete v-model="item.id" label="Select Trauma" :disabled="disabled" chips deletable-chips
                                        :items="traumas" item-value="id" item-text="name">
                        </v-autocomplete>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <v-textarea v-model="item.additional_information" label="Additional Information" :disabled="disabled"/>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions v-if="action.edit || action.create">
                <v-row align="center" justify="center" class="m-0 p-0">
                    <v-btn color="primary" text @click="save"><v-icon class="p-2">mdi-content-save</v-icon>Save</v-btn>
                    <v-btn color="primary" text @click="close"><v-icon class="p-2">mdi-cancel</v-icon>Cancel</v-btn>
                </v-row>
            </v-card-actions>
            <v-card-actions v-else-if="action.delete">
                <v-row align="center" justify="center" class="m-0 p-0">
                    <span color="warning"><v-icon color="warning" class="p-2">mdi-alert</v-icon>Are you sure you want to delete this item?</span>
                    <v-btn color="error" text @click="trash"><v-icon class="p-2">mdi-delete</v-icon>Delete</v-btn>
                    <v-btn color="primary" text @click="close"><v-icon class="p-2">mdi-cancel</v-icon>Cancel</v-btn>
                </v-row>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import {eventBus} from "../../../eventBus";
    import axios from "axios";

    export default {
        name: "pat-crud",
        props: {
            specimen: {type: Object, required: true},
            default_crud_action: "Edit",
            default_title: "Modal title",
        },
        data() {
            return {
                loading: false,
                dialog: false,
                crud_action: "Edit",
                title: "Modal title",
                index: -1,
                item: { id: "", zone_ids: [], pathology: '', trauma: '', additional_information: '', project_id: 0, org: 0, },
                defaultItem: { id: "", zone_ids: [], pathology: '', trauma: '', additional_information: '', project_id: 0, org: 0, },

                type: "Pathology",
                show_pathology: true,
                show_trauma: true,
                preparedPat: {},
                pathologies: this.$store.getters.getPathologies,
                traumas: this.$store.getters.getTraumas,
                anomalies: this.$store.getters.getAnomaliesByBone(this.specimen.sb.id),
                zones: this.$store.getters.getZonesByBone(this.specimen.sb.id),
            };
        },
        created() {
            this.defaultItem.project_id = this.item.project_id = this.theProject.id;
            eventBus.$on('show-crud-dialog', payload => {
                this.dialog = !this.dialog;
                this.title = (payload.title) ? payload.title : "No Modal Title";
                this.crud_action = (payload.action) ? payload.action : "Edit";
                this.item = (payload.item) ? payload.item : this.defaultItem;
                this.index = (payload.index) ? payload.index : this.index;

                this.type = (payload.type) ? payload.type : "Pathology";
                this.show_pathology = (this.type === "Pathology");
                this.show_trauma = (this.type === "Trauma");
                // console.log('tagCrud payload event: ' + JSON.stringify(payload));
            });
        },
        mounted() {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrfToken;
        },
        watch: {
            dialog (val) {
                val || this.close()
            },
        },
        methods: {
            close() {
                console.log("pat crud close");
                this.title = "No Modal Title";
                this.crud_action = "Edit";
                this.type = "Pathology";
                this.item = this.defaultItem;
                this.index = -1;
                this.dialog = false;
            },
            preparePatForSave() {
                let zones = this.item.zone_ids;
                this.preparedPat = {};
                if (this.type === "Pathology") {
                    if (zones.length === 0) { // meaning zone_id is null
                        Vue.set(this.preparedPat, "null", {
                            "zone_id": null,
                            "pathology_id": this.item.id.toString(),
                            "additional_information": (this.item.additional_information)?this.item.additional_information : "",
                            "abnormality_category": null,
                            "characteristics": null,
                        })
                    } else { // one of more zones have been selected
                        for (var i = 0; i < zones.length; i++) {
                            Vue.set(this.preparedPat, zones[i].toString(), {
                                "zone_id": zones[i].toString(),
                                "pathology_id": this.item.id.toString(),
                                "additional_information": (this.item.additional_information)?this.item.additional_information : "",
                                "abnormality_category": null,
                                "characteristics": null,
                            })
                        }
                    }
                } else { // Trauma
                    if (zones.length === 0) { // meaning zone_id is null
                        Vue.set(this.preparedPat, "null", {
                            "zone_id": null,
                            "trauma_id": this.item.id.toString(),
                            "additional_information": (this.item.additional_information)?this.item.additional_information : "",
                            "abnormality_category": null,
                            "characteristics": null,
                        })
                    } else { // one of more zones have been selected
                        for (var i = 0; i < zones.length; i++) {
                            Vue.set(this.preparedPat, zones[i].toString(), {
                                "zone_id": zones[i].toString(),
                                "trauma_id": this.item.id.toString(),
                                "additional_information": (this.item.additional_information)?this.item.additional_information : "",
                                "abnormality_category": null,
                                "characteristics": null,
                            })
                        }
                    }
                }
            },
            save () {
                this.loading = true;
                let url = '/api/specimens/' + this.specimen.id + '/associations';
                let data = [];
                this.preparePatForSave();
                if (this.tyoe === "Pathology") {
                    data = { "type": "pathologys", "pathology_id": this.item.id.toString(), "listIds": this.preparedPat };
                } else {
                    data = { "type": "traumas", "trauma_id": this.item.id.toString(), "listIds": this.preparedPat };
                }
                console.log("Save Pat: data: " + JSON.stringify(data));

                axios
                    .request({ url: url, method: 'PUT', data: data,
                        headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken, },
                    }).then(response => {
                        let payload = { 'text': this.type + ' Update successful', 'color': 'success', };
                        eventBus.$emit('show-snackbar', payload);
                        eventBus.$emit('refresh-list', { 'list': this.type, } );
                        this.loading = false;
                        this.close();
                    }).catch(error => {
                    console.log(error.response);
                        let payload = { 'text': this.type + ' Update failed', 'color': 'error', };
                        eventBus.$emit('show-snackbar', payload);
                        this.loading = false;
                        this.close();
                    })
            },
            trash() {
                this.loading = true;
                let url = '/api/specimens/' + this.specimen.id + '/associations';
                let data = [];
                this.preparePatForSave();
                if (this.tyoe === "Pathology") {
                    data = { "type": "pathologys", "pathology_id": this.item.id.toString(), "listIds": this.preparedPat };
                } else {
                    data = { "type": "traumas", "trauma_id": this.item.id.toString(), "listIds": this.preparedPat };
                }
                console.log("Save Pat: data: " + JSON.stringify(data));

                axios
                    .request({ url: url, method: 'DELETE', data: data,
                        headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken, },
                    })
                    .then(response => {
                        console.log("then response: " + JSON.stringify(response));
                        let payload = { 'text': this.type + ' Delete successful', 'color': 'success', };
                        eventBus.$emit('show-snackbar', payload);
                        eventBus.$emit('refresh-list', { 'list': this.type, } );
                        this.loading = false;
                        this.close();
                    })
                    .catch(error => {
                        console.log(error.response);
                        let payload = { 'text': this.type + ' Delete failed', 'color': 'error', };
                        eventBus.$emit('show-snackbar', payload);
                        this.loading = false;
                        this.close();
                    });
            },
        },
        computed: {
            ...mapState({
                //
            }),
            ...mapGetters({
                theOrg: 'theOrg',
                theProject: 'theProject',
                projectlist: 'theUserProjects',
            }),
            action() {
                const action = this.crud_action;
                return { list: action === "List", create: action === "Create", view: action === "View", edit: action === "Update" || action === "Edit" , delete: action === "Delete",};
            },
            disabled() {
                return this.action.delete;
            },
            tag_color: function () {
                return this.colorPicker.color;
            },
        },
    }
</script>

<style scoped>
    .v-text-field__slot { top: -5px; }
</style>