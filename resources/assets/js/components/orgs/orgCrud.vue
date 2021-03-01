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
                    <v-btn v-if="this.action.create || this.action.edit" :title="(show_validation)?'Reset Validation':'Validate'" icon @click="toggleValidation">
                        <v-icon :color="(show_validation)?'error':''">mdi-shield-star</v-icon>
                    </v-btn>
                    <v-btn title="Close" icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
                </v-toolbar>
            </v-card-title>
            <v-card-text>
                <v-form ref="form" v-model="isFormValid">
                    <v-row>
                        <v-col cols="6"><v-text-field v-model="item.name" label="Organization Name" counter="128" :rules="rules.name" :disabled="disabled"/></v-col>
                        <v-col cols="3"><v-text-field v-model="item.acronym" label="Acronym" counter="5" :rules="rules.acronym" /></v-col>
                        <v-col cols="3"><v-switch v-model="item.active" label="Active" :disabled="disabled"></v-switch></v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12"><v-textarea auto-grow clearable rows="2" outlined v-model="item.description" label="Organization Description" counter="255" :rules="rules.description" :disabled="disabled"></v-textarea></v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6"><v-text-field v-model="item.contact_name" label="Contact Name"/></v-col>
                        <v-col cols="6"><v-text-field v-model="item.contact_email" label="Contact Email"/></v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12"><v-text-field v-model="item.address" label="Address" placeholder="e.g. 1235 N, 135th Street" :disabled="disabled"/></v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="4"><v-text-field v-model="item.city" label="City" placeholder="e.g. Omaha" :disabled="disabled"/></v-col>
                        <v-col cols="4"><v-text-field v-model="item.state" label="State" placeholder="e.g. NE" :disabled="disabled"/></v-col>
                        <v-col cols="4"><v-text-field v-model="item.zip" label="Zip" placeholder="e.g. 61864" :disabled="disabled"/></v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="4"><v-autocomplete v-model="item.default_country" label="Country" :disabled="disabled" :items="items_country"></v-autocomplete></v-col>
                        <v-col cols="4"><v-autocomplete v-model="item.default_language"  label="Language" :disabled="disabled" :items="items_language"></v-autocomplete></v-col>
                        <v-col cols="4"><v-autocomplete v-model="item.default_timezone"  label="Time Zone" :disabled="disabled" :items="items_timezone"></v-autocomplete></v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6"><v-text-field v-model="item.geo_lat" label="Geo Latitude" placeholder="e.g. 41.2473820" :rules="rules.geo_location" :disabled="disabled"/></v-col>
                        <v-col cols="6"><v-text-field v-model="item.geo_long" label="Geo Longitude" placeholder="e.g. -96.0167990" :rules="rules.geo_location"  :disabled="disabled"/></v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12"><v-text-field v-model="item.website" label="Organization Website"/></v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="4"><v-text-field v-model="item.phone" label="Phone"/></v-col>
                        <v-col cols="4"><v-text-field v-model="item.toll_free" label="Toll Free"/></v-col>
                        <v-col cols="4"><v-text-field v-model="item.fax" label="Fax"/></v-col>
                    </v-row>
                </v-form>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions v-if="action.edit || action.create">
                <v-row align="center" justify="center" class="m-0 p-0">
                    <v-btn color="primary" text @click="save" :disabled="!isFormValid"><v-icon class="p-2">mdi-content-save</v-icon>Save</v-btn>
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
        name: "orgCrud",
        props: {
            default_crud_action: "Edit",
            default_title: "Modal title",
        },
        data() {
            return {
                isFormValid: true,
                show_validation: false,
                loading: false,
                crud_action: "Edit",
                dialog: false,
                title: "Modal title",
                items: [],
                index: -1,
                item: { id: 0, name: '', acronym: '', description: '', active: true, geo_lat: '', geo_long: '', website: '',
                    address: '', city: '', state: '', zip: '', phone: '', toll_free: '', fax: '', contact_name: '', contact_email: '',
                    default_country: 'US', default_language: 'en', default_timezone: 'America/Chicago' },
                defaultItem: { id: 0, name: '', acronym: '', description: '', active: true, geo_lat: '', geo_long: '', website: '',
                    address: '', city: '', state: '', zip: '', phone: '', toll_free: '', fax: '', contact_name: '', contact_email: '',
                    default_country: 'US', default_language: 'en', default_timezone: 'America/Chicago' },
                cached_item: {},
                menu: false,
                rules: {
                    name: [ v => !!v || 'Name is required', v => (v && v.length >= 3) || 'Name must be at least 3 characters',
                        v => v.length <= 128 || 'Max 128 characters'],
                    acronym: [ v => !!v || 'Acronym is required', v => (v && v.length >= 2) || 'Acronym must be at least 2 characters',
                        v => v.length <= 10 || 'Max 10 characters'],
                    description: [ v => !!v || 'Description is required', v => (v && v.length >= 10) || 'Description must be at least 10 characters',
                        v => v.length <= 255 || 'Max 255 characters'],
                    geo_location: [ v => !!v || 'Geo location field is required',
                        v => (v && v.length <= 12) || 'geo_location must max 12 characters',
                    ],
                },
            };
        },
        created() {
            this.defaultItem.org_id = this.item.org_id = this.theOrg.id;
            eventBus.$on('show-crud-dialog', payload => {
                this.dialog = !this.dialog;
                this.title = (payload.title) ? payload.title : "No Modal Title";
                this.crud_action = (payload.action) ? payload.action : "Edit";
                this.item = (payload.item) ? payload.item : this.defaultItem;
                this.index = (payload.index) ? payload.index : this.index;
                this.cached_item = this.item;
            });
        },
        mounted() {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrfToken;
            this.show_validation = false;
        },
        watch: {
            dialog (val) {
                val || this.close()
            },
        },
        methods: {
            close() {
                this.title = "No Modal Title";
                this.crud_action = "Edit";
                this.item = this.cached_item;
                this.index = -1;
                this.item = this.defaultItem;
                this.dialog = false;
                this.show_validation = false;
                this.$refs.form.resetValidation();
            },
            save () {
                this.loading = true;
                let url = (this.action.create) ? '/api/orgs' : '/api/orgs/' + this.item.id;
                let method = (this.action.create) ? "POST" : "PUT";
                let data = { name: this.item.name, acronym: this.item.acronym, description: this.item.description, active: this.item.active,
                    website: this.item.website, contact_name: this.item.contact_name, contact_email: this.item.contact_email,
                    default_country: this.item.default_country, default_language: this.item.default_language, default_timezone: this.item.default_timezone,
                    address: this.item.address, city: this.item.city, state: this.item.state, zip: this.item.zip,
                    phone: this.item.phone, toll_free: this.item.toll_free, fax: this.item.fax, geo_lat: this.item.geo_lat, geo_long: this.item.geo_long, };

                console.log("Save Data: " + JSON.stringify(data));
                axios
                    .request({ url: url, method: method, data: data,
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        this.loading = false;
                        let payload = { 'text': 'Update successful', 'color': 'success', };
                        eventBus.$emit('show-snackbar', payload);
                        eventBus.$emit('refresh-list', { 'list': 'orgs', } );
                        this.close();
                    }).catch(error => {
                    console.log(error.response);
                    this.loading = false;
                    let payload = { 'text': 'Update failed', 'color': 'error', };
                    eventBus.$emit('show-snackbar', payload);
                    this.close();
                })
            },
            toggleValidation () {
                this.show_validation = !this.show_validation;
                if (this.show_validation) {
                    this.validateForm();
                } else {
                    this.resetFormValidation();
                }
            },
            validateForm () {
                this.$refs.form.validate();
            },
            resetFormValidation () {
                this.$refs.form.resetValidation();
            },
            resetForm () {
                this.$refs.form.reset();
                this.item = (this.action.create) ? this.defaultItem : this.cached_item;
            },
        },
        computed: {
            ...mapState({
                //
            }),
            ...mapGetters({
                theOrg: 'theOrg',
                theUser: 'theUser',
                items_country: 'getCountryCodes',
                items_language: 'getLanguageCodes',
                items_timezone: 'getTimezoneCodes',
            }),
            action() {
                const action = this.crud_action;
                return { list: action === "List", create: action === "Create", view: action === "View", edit: action === "Update" || action === "Edit" };
            },
            disabled() {
                return this.action.delete;
            },
        },
    }
</script>

<style scoped>
    .v-text-field__slot { top: -5px; }
</style>