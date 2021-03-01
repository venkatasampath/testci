<template>
    <div class="m-2">
        <contentheader :trail="this.trail" :title="this.heading" :crud_action="action" model_name="users" @eventNew="eventNewGo"></contentheader>
        <v-alert v-if="alert" class="my-1" border="left" colored-border type="info" elevation="2" dismissible>{{alertText}}</v-alert>
        <user-crud></user-crud>
        <reset-password></reset-password>
        <v-row>
            <v-col cols="9">
                <v-btn-toggle v-model="toggle_multiple" dense dark multiple>
                    <v-btn>Excel</v-btn>
                    <v-menu right offset-x :close-on-content-click="false" max-height="500px">
                        <template v-slot:activator="{ on }">
                            <v-btn v-on="on">Column Visibility<v-icon right>$dropdown</v-icon></v-btn>
                        </template>

                        <v-list>
                            <v-list-item v-for="(header, index) in headers" :key="index">
                                <v-checkbox v-bind:label="header.text" v-model="header.visibility" :value="header.visibility"/>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </v-btn-toggle>
            </v-col>
            <v-spacer></v-spacer>
            <v-col cols="3">
                <v-text-field v-model="search" label="Search" single-line hide-details></v-text-field>
            </v-col>
        </v-row>
        <v-data-table :headers="columnVisibility" :items="items" :items-per-page="perPage" :options.sync="options"
                      calculate-widths="" class="elevation-1" :sort-by="['name', 'role']" multi-sort :search="search" :loading="loading"
                      :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }">
            <template v-slot:item.name="{ item }">
                <v-list-item class="m-0 p-0">
                    <v-list-item-avatar class="m-0 p-0"><v-img :src="item.avatar" class="m-0 p-0" style="max-height: 32px; max-width: 32px;"/></v-list-item-avatar>
                    <v-list-item-content class="m-0 p-0"><a href="#" @click="editItem(item)">{{ item.name }}</a></v-list-item-content>
                </v-list-item>
            </template>
            <template v-slot:item.role_id="{ item }">{{ getRoleDisplayName(item) }}</template>
            <template v-slot:item.active="{ item }"><v-icon right :color= "getIconColor(item.active)">{{ getBooleanIcon(item.active) }}</v-icon></template>
            <template v-slot:item.last_login_at="{ item }">
                <v-list-item class="m-0 p-0">
                    <v-list-item-avatar class="m-0 p-0"><v-icon title="Inactivity Lock" small left color="error" v-if="showInavtivityLock(item.last_login_at)">mdi-lock</v-icon></v-list-item-avatar>
                    <v-list-item-content class="m-0 p-0">{{ item.last_login_at }}</v-list-item-content>
                </v-list-item>
            </template>
            <template v-slot:item.action="{ item }">
                <v-icon title="Edit" color="primary" class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
                <v-icon title="Reset Password" color="primary" class="mr-2" @click="resetPassword(item)">mdi-lock-reset</v-icon>
                <v-icon title="Reset Inactivity Lock" color="primary" class="mr-2" @click="resetInactivityLock(item)" v-if="showInavtivityLock(item.last_login_at)">mdi-lock-open-variant</v-icon>
            </template>
        </v-data-table>
    </div>
</template>

<script>
    import {mapState, mapGetters} from 'vuex';
    import {eventBus} from "../../eventBus";
    import axios from 'axios';

    export default {
        name: "user-management",
        props: {
            heading: { type: String, default: "User Management" },
            crud_action: { type: String, default: "List" },
        },
        data: () => ({
            loading: false,
            items: [],
            options: {},
            headers: [
                {text: 'Name', value: 'name', width: '8rem', visibility: true},
                {text: 'Role', value: 'role_id', width: '6rem', visibility: true},
                {text: 'Email', value: 'email', width: '8rem', visibility: true},
                {text: 'Cell Phone', value: 'cell_phone', width: '6rem', visibility: false},
                {text: 'Active', value: 'active', width: '4rem', visibility: true},
                {text: 'Country', value: 'default_country', width: '4rem', visibility: true},
                {text: 'Language', value: 'default_language', width: '4rem', visibility: true},
                {text: 'Time Zone', value: 'default_timezone', width: '6rem', visibility: true},
                {text: 'Last IP Address', value: 'last_login_ip_address', width: '6rem', visibility: true},
                {text: 'Last Activity', value: 'last_login_at', width: '8rem', visibility: true},
                {text: 'Days Since Last Activity', value: 'days_since_last_activity', width: '6rem', visibility: false},
                {text: 'Last Login Device', value: 'last_login_device', width: '6rem', visibility: false},
                {text: 'Created By', value: 'created_by', width: '6rem', visibility: false},
                {text: 'Created At', value: 'created_at', width: '6rem', visibility: false},
                {text: 'Updated By', value: 'updated_by', width: '6rem', visibility: false},
                {text: 'Updated At', value: 'updated_at', width: '6rem', visibility: false},
                {text: 'Action', value: 'action', width: '8rem', visibility:true}
            ],
            trail: [{ text: 'Home', disabled: false, href: '/', },
                { text: 'Users', disabled: true, href: '/users', },
            ],
            alert: false,
            alertText: "",
            search: '',
            toggle_multiple: [],
        }),
        mounted() {
            //
        },
        created(){
            console.log("userManagement component created");
            eventBus.$on('refresh-list', payload => {
                if ((payload.list) && (payload.list === "Users" || payload.list === "users")) {
                    this.fetchUsers();
                }
            });
            this.fetchUsers();
        },
        methods: {
            fetchUsers() {
                this.loading = true;
                axios
                    .request({ url: '/api/users', method: 'GET',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        this.items=response.data.data;
                        this.loading = false;
                    })
            },
            getBooleanIcon(item) {
                return item === true ? '✔' : 'x'
            },
            getIconColor(item) {
                return item === true ? 'success' : 'error'
            },
            showInavtivityLock(ts) {
                //                                          day hour  min  sec  msec
                let inactivity_ts = new Date().getTime() - (60 * 24 * 60 * 60 * 1000);
                let last_activity_ts = new Date(ts).getTime();
                return ((last_activity_ts < inactivity_ts) && ts) ;
            },
            editItem(item) {
                let payload = { 'title': 'Edit User', 'action': 'Edit', 'item': item };
                eventBus.$emit('show-crud-dialog', payload);
            },
            resetPassword(item) {
                let payload = { 'title': 'Reset Password - '+item.display_name, 'action': 'Edit', 'item': item };
                eventBus.$emit('show-reset-password-dialog', payload);
            },
            resetInactivityLock(item) {
                axios
                .request({ url: '/api/users/' + item.id + '/resetInactivityLock', method: "POST",
                    headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                })
                .then(response=>{
                    this.loading = false;
                    let payload = { 'text': 'Update successful', 'color': 'success', };
                    eventBus.$emit('show-snackbar', payload);
                    location.reload();
                }).catch(error => {
                    console.log(error.response);
                    this.loading = false;
                    let payload = { 'text': 'Update failed', 'color': 'error', };
                    eventBus.$emit('show-snackbar', payload);
                })
            },
            eventNewGo(val) {
                if (val === "users" || val === "user") {
                    let payload = { 'title': 'Create New User', 'action': 'Create', };
                    eventBus.$emit('show-crud-dialog', payload);
                }
            },
            getRoleDisplayName(item) {
                let role = this.roles.find(el => { return el.id === item.role_id});
                return role.display_name;
            },
        },
        computed: {
            ...mapState({
                perPage: state => state.search.perPage,
                rowsPerPageItems: state => state.search.rowsPerPageItems,
            }),
            ...mapGetters({
                bearerToken: 'bearerToken',
                csrfToken: 'csrfToken',
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
                roles: 'getRoles',
            }),
            columnVisibility() {
                return this.headers.filter(item => item.visibility === true);
            },
            action() {
                const action = this.crud_action;
                return { list: action === "List", create: action === "Create", view: action === "View", edit: action === "Update", passwordReset: action === "Reset" };
            },
        },
    }
</script>

<style>

</style>