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
                        <v-col cols="4"><v-text-field v-model="item.first_name" label="First Name" :disabled="disabled" :rules="rules.first_name" /></v-col>
                        <v-col cols="4"><v-text-field v-model="item.last_name" label="Last Name" :disabled="disabled" :rules="rules.last_name"/></v-col>
                        <v-col cols="4" v-if="action.edit"><v-text-field v-model="item.display_name" label="Display Name" :disabled="disabled"/></v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6"><v-text-field autocomplete="username" v-model="item.email" label="Email" :disabled="disabled || !action.create" :rules="rules.emailRules"/></v-col>
                        <v-col cols="6"><v-switch v-model="item.active" label="Active" :disabled="disabled"></v-switch></v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="4">
                            <v-autocomplete v-model="item.role_id" label="Role" :rules="rules.role" :disabled="disabled"
                                            :items="items_roles" item-text="display_name" item-value="id">
                            </v-autocomplete>
                        </v-col>
                        <v-col cols="4"><v-text-field label="Cell Phone" v-model="item.cell_phone" :disabled="disabled"></v-text-field></v-col>
                        <v-col cols="4"><v-text-field label="Alternate Phone" v-model="item.phone" :disabled="disabled"></v-text-field></v-col>
                    </v-row>
                    <v-row v-if="action.create">
                        <v-col cols="6">
                            <v-text-field autocomplete="new-password" v-model="item.password" label="Password" :type="show_password?'text':'password'" :rules="rules.passwordRules"
                                          :append-icon="show_password ?'mdi-eye-off':'mdi-eye'" @click:append="() => (show_password = !show_password)">
                            </v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-text-field autocomplete="new-password" v-model="item.password_confirmation" label="Confirm Password" :type="show_password_confirmation?'text':'password'"
                                          :append-icon="show_password_confirmation?'mdi-eye-off':'mdi-eye'" @click:append="() => (show_password_confirmation = !show_password_confirmation)"
                                          :rules="rules.passwordRules">
                            </v-text-field>
                        </v-col>
                    </v-row>
                    <v-row v-if="action.edit && item.id">
                        <v-col cols="4"><v-autocomplete v-model="item.default_country" label="Country" :disabled="disabled" :items="items_country"></v-autocomplete></v-col>
                        <v-col cols="4"><v-autocomplete v-model="item.default_language"  label="Language" :disabled="disabled" :items="items_language"></v-autocomplete></v-col>
                        <v-col cols="4"><v-autocomplete v-model="item.default_timezone"  label="Time Zone" :disabled="disabled" :items="items_timezone"></v-autocomplete></v-col>
                    </v-row>
                    <v-row v-if="action.edit && item.id"><v-col cols="12"><user-instruments :user="item"></user-instruments></v-col></v-row>
                    <v-row v-if="action.edit && item.id"><v-col cols="12"><user-projects :user="item"></user-projects></v-col></v-row>
                    <v-row v-if="action.edit && item.id">
                        <v-col cols="12">
                            <v-textarea auto-grow rows="1" outlined v-model="item.api_token" label="API Token" prepend-icon="mdi-shield-key">
                                <template v-slot:append-outer>
                                    <v-icon title="Change API Token" color="primary" @click="generateAPIToken">mdi-key-change</v-icon>
                                </template>
                            </v-textarea>
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions v-if="action.edit || action.create">
                <v-row align="center" justify="center" class="m-0 p-0">
                    <v-btn v-if="action.edit" color="primary" text @click="resetPassword"><v-icon class="p-2">mdi-lock-reset</v-icon>Reset Password</v-btn>
                    <v-btn v-if="action.edit" color="primary" text @click="resetInactivityLock"><v-icon class="p-2">mdi-lock-open-variant</v-icon>Reset Inactivity Lock</v-btn>
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
        name: "user-crud",
        props: {
            default_crud_action: "Edit",
            default_title: "Modal title",
        },
        data() {
            return {
                isFormValid: true,
                show_validation: false,
                show_password: false,
                show_password_confirmation: false,
                loading: false,
                crud_action: "Edit",
                dialog: false,
                title: "Modal title",
                items: [],
                index: -1,
                item: { id: 0, first_name: '', last_name: '', name: '', display_name: '', email: '', active: true, role_id: 5,
                    password: '', password_confirmation: '', phone: '', cell_phone: '', slack_channel: '',
                    default_country: 'US', default_language: 'en', default_timezone: 'America/Chicago' },
                defaultItem: { id: 0, first_name: '', last_name: '', name: '', display_name: '', email: '', active: true, role_id: 5,
                    password: '', password_confirmation: '', phone: '', cell_phone: '', slack_channel: '',
                    default_country: 'US', default_language: 'en', default_timezone: 'America/Chicago' },
                cached_item: {},
                menu: false,
                rules: {
                    first_name: [ v => !!v || 'First name is required' ],
                    last_name: [ v => !!v || 'Last name is required' ],
                    role: [ v => !!v || 'Role is required' ],
                    email: [ v => !!v || 'Email is required', v => !v || /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v)
                        || 'E-mail must be valid e.g spawaskar@unomaha.edu'],
                    passwordRules: [
                        v => !!v || 'Password is required, min 10 characters, 1 uppercase, 1 number and 1 special character [!@#$%]',
                        v => (v && v.length >= 10) || 'Password must min 10 characters',
                        v => /(?=.*[A-Z])/.test(v) || 'Must have one uppercase character',
                        v => /(?=.*\d)/.test(v) || 'Must have one number',
                        v => /([!@$%])/.test(v) || 'Must have one special character [!@#$%]'
                    ],
                    emailRules: [
                        v => !!v || 'Email is required',
                        v => /.+@.+/.test(v) || 'E-mail must be valid, e.g spawaskar@unomaha.edu'
                    ],
                },
            };
        },
        created() {
            console.log("userCrud component created");
            this.defaultItem.project_id = this.item.project_id = this.theProject.id;
            this.item.start_date = this.defaultItem.start_date = this.current_date;
            eventBus.$on('show-crud-dialog', payload => {
                this.dialog = !this.dialog;
                this.title = (payload.title) ? payload.title : "No Modal Title";
                this.crud_action = (payload.action) ? payload.action : "Edit";
                this.item = (payload.item) ? payload.item : this.defaultItem;
                this.index = (payload.index) ? payload.index : this.index;
                this.cached_item = this.item;
            });

            let payload = { 'type': 'users', 'list': true, 'force': true };
            this.$store.dispatch('fetchOrgList', payload).then(() => this.loading = false);
            payload = { 'type': 'instruments', 'list': true, 'force': true };
            this.$store.dispatch('fetchOrgList', payload).then(() => this.loading = false);
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
                let url = (this.action.create) ? '/api/users' : '/api/users/' + this.item.id;
                let method = (this.action.create) ? "POST" : "PUT";
                let data = { first_name: this.item.first_name, last_name: this.item.last_name, name: this.item.first_name + " " + this.item.last_name,
                        display_name: this.item.display_name, email: this.item.email, role_id: this.item.role_id, active: this.item.active,
                        default_country: this.item.default_country, default_language: this.item.default_language, default_timezone: this.item.default_timezone,
                        phone: this.item.phone, cell_phone: this.item.cell_phone, slack_channel: this.item.slack_channel};
                if (this.action.create) {
                    data['password'] = this.item.password;
                    data['password_confirmation'] = this.item.password_confirmation;
                    data['display_name'] = this.item.first_name + " " + this.item.last_name;
                }

                console.log("Save Data: " + JSON.stringify(data));
                axios
                    .request({ url: url, method: method, data: data,
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        this.loading = false;
                        let payload = { 'text': 'Update successful', 'color': 'success', };
                        eventBus.$emit('show-snackbar', payload);
                        eventBus.$emit('refresh-list', { 'list': 'users', } );
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
            generateAPIToken() {
                axios
                .request({ url: '/api/users/' + this.item.id + '/generateAPIToken', method: "POST",
                    headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                })
                .then(response=>{
                    this.loading = false;
                    this.item.api_token = response.data.data.api_token;
                    let payload = { 'text': 'Update successful', 'color': 'success', };
                    eventBus.$emit('show-snackbar', payload);
                    // eventBus.$emit('refresh-list', { 'list': 'users', } );
                }).catch(error => {
                    console.log(error.response);
                    this.loading = false;
                    let payload = { 'text': 'Update failed', 'color': 'error', };
                    eventBus.$emit('show-snackbar', payload);
                })
            },
            resetInactivityLock() {
                axios
                .request({ url: '/api/users/' + this.item.id + '/resetInactivityLock', method: "POST",
                    headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                })
                .then(response=>{
                    this.loading = false;
                    let payload = { 'text': 'Update successful', 'color': 'success', };
                    eventBus.$emit('show-snackbar', payload);
                    eventBus.$emit('refresh-list', { 'list': 'users', } );
                    this.close();
                }).catch(error => {
                    console.log(error.response);
                    this.loading = false;
                    let payload = { 'text': 'Update failed', 'color': 'error', };
                    eventBus.$emit('show-snackbar', payload);
                    this.close();
                })
            },
            resetPassword() {
                let payload = { 'title': 'Reset Password - '+this.item.display_name, 'action': 'Edit', 'item': this.item };
                eventBus.$emit('show-reset-password-dialog', payload);
            },
        },
        computed: {
            ...mapState({
                //
            }),
            ...mapGetters({
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
                projectlist: 'theUserProjects',
                projectsData: 'getProjectsIdNameArray',
                users: 'getOrgUsers',
                instruments: 'getOrgInstruments',
                items_roles: 'getRoles',
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