<template>
    <div class="m-2">
        <!-- Add the Content Header Crud component for Bread crumb trail, heading and Create New (crud buttons)-->
        <contentheader :trail="this.trail" :title="this.heading" model_name="notifications"></contentheader>
        <!-- Add the standard alert component-->
        <v-alert v-if="alert" class="my-1" border="left" colored-border type="info" elevation="2" dismissible>{{alertText}}</v-alert>
        <!-- Add the Crud component for Create/Read-View/Update/Delete-->
        <!-- We do not add the notification crud dialog here as it is already available in the header/notification tooptip -->
        <!-- <notification-crud></notification-crud>-->
        <!-- Add the Datatable top row for managing column visibility, search and download functionality-->
        <v-row>
            <v-col cols="9">
                <v-btn-toggle v-model="toggle_multiple" dense dark multiple>
                    <v-btn>Excel</v-btn>
                    <v-menu right offset-x :close-on-content-click="false" max-height="500px">
                        <template v-slot:activator="{ on }">
                            <v-btn v-on="on">Column Visibility<v-icon right>$dropdown</v-icon></v-btn>
                        </template>

                        <v-list>
                            <v-list-item v-for="header in headers" :key="header.id">
                                <v-checkbox v-bind:label="header.text" v-model="header.visibility" :value="header.visibility"></v-checkbox>
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
        <!-- Add the Main listing Datatable here-->
        <v-data-table :headers="columnVisibility" :items="items" :items-per-page="perPage" :options.sync="options"
                      calculate-widths="" class="elevation-1" :sort-by="['name']" multi-sort :search="search" :loading="loading"
                      :footer-props="{ 'items-per-page-options': rowsPerPageItems, showFirstLastPage: true }">
            <template v-slot:item.type="{ item }">{{getNotificationType(item)}}</template>
            <template v-slot:item.read_at="{ item }" ><v-icon right :color="getIconColor(item)" > {{ getBooleanIcon(item) }}</v-icon></template>
            <template v-slot:item.action="{ item }">
                <v-icon color="primary" class="mr-2" @click="editItem(item)">mdi-eye-check</v-icon>
<!--                <v-icon color="error" @click="deleteItem(item)">mdi-delete</v-icon>-->
            </template>
        </v-data-table>
    </div>
</template>

<script>
    import {mapState, mapGetters, mapActions} from 'vuex';
    import {eventBus} from "../../eventBus";
    import axios from "axios";

    export default {
        name: "notification-management",
        props: {
            heading: { type: String, default: "Notification Management" },
            crud_action: { type: String, default: "List" },
        },
        data() {
            return {
                loading: false,
                alert: false,
                alertText: "",
                search: '',
                toggle_multiple: [],
                items: [],
                options: {},
                trail: [{ text: 'Home', disabled: false, href: '/', },
                    { text: 'Notifications', disabled: true, href: '/notifications', },
                ],
                headers: [
                    {text: 'Type',  value: 'type', visibility: true},
                    {text: 'Description', value: 'data.shortMessage', visibility: true},
                    {text: 'Details', value: 'data.longMessage', visibility: true},
                    {text: 'Read',  value: 'read_at', visibility: true},
                    {text: 'Created By', value: 'created_by', visibility: false},
                    {text: 'Created At', value: 'created_at', visibility: false},
                    {text: 'Updated By', value: 'updated_by', visibility: false},
                    {text: 'Updated At', value: 'updated_at', visibility: false},
                    {text: 'Actions', value: 'action',  width: '6rem', visibility: true}
                ],
            };
        },
        created(){
            eventBus.$on('refresh-notification-list', payload => {
                if ((payload.list) && (payload.list === "Notifications" || payload.list === "notifications")) {
                    this.fetchNotifications();
                }
            });
            this.fetchNotifications();
        },
        watch: {
            //
        },
        methods: {
            fetchNotifications() {
                this.loading = true;
                axios
                    .request({ url: '/api/users/' + this.theUser.id + '/notifications', method: 'GET',
                headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        this.items=response.data.data;
                        this.loading = false;
                    });
            },
            markAsRead: function(item) {
                axios
                    .request({ url: '/api/users/'+this.theUser.id+"/notifications/"+item.id+"/markAsRead", method: 'POST',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        console.log("Notification marked as read: "+JSON.stringify(response.data));
                        this.items=response.data.data;
                        this.loading = false;
                    })
            },
            deleteItem(item) {
                let payload = { 'title': 'Delete Notification', 'action': 'Delete', 'item': item };
                eventBus.$emit('show-notification-crud-dialog', payload);
            },
            editItem(item) {
                let payload = { 'title': 'View Notification', 'action': 'Edit', 'item': item };
                eventBus.$emit('show-notification-crud-dialog', payload);

                // Also mark the notification as read
                this.markAsRead(item);
            },
            getBooleanIcon(item) {
                let readAt = item.read_at;
                if(readAt != null) {
                    return  "✔";
                } else {
                    return " ";
                }
            },
            getIconColor(item) {
                let readAt = item.read_at;
                if(readAt != null) {
                    return  "success";
                } else {
                    return " ";
                }
            },
            getNotificationType(item) {
                let type = item.type.replace('App\\Notifications\\', '');
                type = type.replace('Completed', '');
                type = type.replace('Complete', '');
                return type;
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
            }),
            columnVisibility(){
                return this.headers.filter(item => item.visibility === true);
            },
            action() {
                const action = this.crud_action;
                return { list: action === "List", view: action === "View", edit: (action === "Update" || action === "Edit") };
            },
        },
    }
</script>

<style scoped>

</style>