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
                        <v-autocomplete v-model="item.project_id" label="Select Project" :disabled="item.org || disabled || !isOrgAdmin"
                                        :items="this.projectsData" item-value="projectsValue" item-text="projectsText">
                        </v-autocomplete>
                    </v-col>
                    <v-col cols="6">
                        <v-switch v-if="isOrgAdmin" v-model="item.org" primary label="Org Tag" :disabled="disabled"/>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="6"><v-text-field v-model="item.name" label="Tag name" :disabled="disabled"/></v-col>
                    <v-col cols="6"><v-text-field v-model="item.description" label="Description" :disabled="disabled"/>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="6"><v-text-field v-model="item.category" label="Category" :disabled="disabled"/></v-col>
                    <v-col cols="6">
                        <v-autocomplete v-model="item.type" label="Select Tag" :items="tag_type_items" :disabled="disabled || !isOrgAdmin"/>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="6">
                        <v-text-field v-model="tag_color" label="Color" :background-color="tag_color" :disabled="disabled">
                            <template v-slot:append-outer>
                                <v-btn class="homunculus-pen-color" small icon @click.stop="colorPickerDialog = true">
                                    <v-icon :color="tag_color">mdi-format-color-highlight</v-icon>
                                </v-btn>
                                <v-dialog v-model="colorPickerDialog" max-width="400px">
                                    <v-card>
                                        <v-card-title class="headline" style="text-align: center;">Tag Color</v-card-title>
                                        <v-card-text>
                                            <template>
                                                <v-color-picker v-model="colorPicker.color" :hide-canvas="colorPicker.hideCanvas"
                                                                :hide-inputs="colorPicker.hideInputs" :hide-mode-switch="colorPicker.hideModeSwitch"
                                                                :mode.sync="colorPicker.mode" :show-swatches="colorPicker.showSwatches"
                                                                class="mx-auto">
                                                </v-color-picker>
                                            </template>
                                        </v-card-text>
                                    </v-card>
                                </v-dialog>
                            </template>
                        </v-text-field>
                    </v-col>
<!--                    <v-col cols="6"><v-text-field v-model="item.icon" label="Icon" :disabled="disabled"/></v-col>-->
                    <v-col cols="6">
                        <v-text-field v-model="item.icon" label="Icon" :disabled="disabled" clearable>
                            <template v-slot:append-outer>
                                <v-chip :color="item.color" label><v-icon left title="Tag Icon">{{ item.icon }}</v-icon>{{ item.name }}</v-chip>
                            </template>
                        </v-text-field>
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
    import {eventBus} from "../../eventBus";
    import axios from "axios";

    export default {
        name: "tag-crud",
        props: {
            default_crud_action: "Edit",
            default_title: "Modal title",
            type: String,
        },
        data() {
            return {
                loading: false,
                crud_action: "Edit",
                dialog: false,
                title: "Modal title",
                items: [],
                index: -1,
                item: { name: '', description: '', color: '#00FF00', category: '', type: 'Specimen', icon:'', project_id: 0, org: false, },
                defaultItem: { name: '', description: '', color: '#00FF00', category: '', type: 'Specimen', icon:'', project_id: 0, org: false, },
                menu: false,
                tag_type_items: ['Specimen', 'Dna', 'Isotope', 'Media'],
                colorPickerDialog: false,
                colorPicker: {
                    color: '#00FF00',
                    hideCanvas: false,
                    hideInputs: false,
                    hideModeSwitch: false,
                    mode: 'rgba',
                    modes: ['rgba', 'hsla', 'hexa'],
                    showSwatches: true,
                },
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
                this.colorPicker.color = this.item.color;
                console.log('tagCrud payload event: ' + JSON.stringify(payload));
                this.item.type = this.type;
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
                console.log("tag crud close");
                this.title = "No Modal Title";
                this.crud_action = "Edit";
                this.item = this.defaultItem;
                this.index = -1;
                this.dialog = false;
            },
            save () {
                this.loading = true;
                let url = (this.action.create) ? '/api/tags' : '/api/tags/' + this.item.id;
                let method = (this.action.create) ? "POST" : "PUT";
                this.item.color = this.tag_color;
                console.log("Tag Item: " + JSON.stringify(this.item));
                axios
                    .request({
                        url: url,
                        method: method,
                        headers:{
                            'Content-Type' : 'application/json',
                            'Authorization' : this.$store.getters.bearerToken,
                        },
                        data:{
                            org_id: this.theOrg.id,
                            project_id: (this.item.org) ? null : this.item.project_id,
                            name: this.item.name,
                            description: this.item.description,
                            color: this.item.color,
                            category: this.item.category,
                            type: this.item.type,
                            icon: this.item.icon,
                        },
                    })
                    .then(response=>{
                        this.loading = false;
                        let payload = { 'text': 'Update successful', 'color': 'success', };
                        eventBus.$emit('show-snackbar', payload);
                        eventBus.$emit('refresh-list', { 'list': 'tags', } );
                        eventBus.$emit('updateTagList');
                        this.close();
                    }).catch(error => {
                        console.log(error.response);
                        this.loading = false;
                        let payload = { 'text': 'Update failed', 'color': 'error', };
                        eventBus.$emit('show-snackbar', payload);
                        this.close();
                    })
            },
            trash() {
                this.loading = true;
                axios
                    .request({
                        url: '/api/tags/' + this.item.id,
                        method: 'DELETE',
                        headers:{
                            'Content-Type' : 'application/json',
                            'Authorization' : this.$store.getters.bearerToken,
                        }
                    })
                    .then(response=>{
                        console.log("then response: " + JSON.stringify(response));
                        this.loading = false;
                        let payload = { 'text': 'Delete successful', 'color': 'success', };
                        eventBus.$emit('show-snackbar', payload);
                        eventBus.$emit('refresh-list', { 'list': 'tags', } );
                        this.close();
                    }).catch(error => {
                        console.log(error.response);
                        this.loading = false;
                        let payload = { 'text': 'Delete failed', 'color': 'error', };
                        eventBus.$emit('show-snackbar', payload);
                        this.close();
                    })
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
                projectsData: 'getProjectsIdNameArray',
                isOrgAdmin: 'isOrgAdmin',
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