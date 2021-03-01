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
                        <v-col cols="12"><v-text-field autocomplete="username" v-model="item.email" :name="item.email" label="Email" disabled></v-text-field></v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field autocomplete="new-password" v-model="password" :name="password" label="Password" :type="show_password?'text':'password'"
                                          :append-icon="show_password?'mdi-eye-off':'mdi-eye'" @click:append="() => (show_password = !show_password)" :rules="rules.passwordRules" required>
                            </v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field autocomplete="new-password" v-model="password_confirmation" :name="password_confirmation" label="Confirm Password" :type="show_password_confirmation?'text':'password'"
                                          :append-icon="show_password_confirmation?'mdi-eye-off':'mdi-eye'" @click:append="() => (show_password_confirmation = !show_password_confirmation)"
                                          :rules="rules.passwordRules" required>
                            </v-text-field>
                        </v-col>
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
    name: "reset-password",
    props: {
        default_title: "Reset Password",
    },
    data() {
        return {
            password: '',
            password_confirmation: '',
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
            item: { first_name: '', last_name: '', email: '', },
            defaultItem: { first_name: '', last_name: '', email: '', },
            cached_item: {},
            rules: {
                passwordRules: [
                    v => !!v || 'Password is required, min 10 characters, 1 uppercase, 1 number and 1 special character [!@#$%]',
                    v => (v && v.length >= 10) || 'Password must min 10 characters',
                    v => /(?=.*[A-Z])/.test(v) || 'Must have one uppercase character',
                    v => /(?=.*\d)/.test(v) || 'Must have one number',
                    v => /([!@$%])/.test(v) || 'Must have one special character [!@#$%]'
                ],
            },
        };
    },
    created() {
        console.log("resetPassword component created");
        eventBus.$on('show-reset-password-dialog', payload => {
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
            this.show_password = this.show_password_confirmation = false;
            this.password = this.password_confirmation = "";
            this.index = -1;
            this.item = this.defaultItem;
            this.dialog = false;
            this.show_validation = false;
            this.$refs.form.resetValidation();
        },
        save () {
            this.loading = true;
            let data = { "password": this.password , "password_confirmation": this.password_confirmation};
            axios
            .request({ url: '/api/users/' + this.item.id + '/resetPassword', method: "POST", data: data,
                headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
            })
            .then(response=>{
                this.loading = false;
                let payload = { 'text': 'Update successful', 'color': 'success', };
                eventBus.$emit('show-snackbar', payload);
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
            theProject: 'theProject',
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

</style>