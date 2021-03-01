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
                    <v-btn title="Close" icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
                </v-toolbar>
            </v-card-title>
            <v-card-text>
                <v-form ref="form">
                    <v-row><v-col cols="6"><v-text-field v-model="this.getNotificationType(item)" label="Type" disabled/></v-col></v-row>
                    <v-row><v-col cols="12"><v-text-field v-model="this.getDescription(item)" label="Description / Short Message" disabled/></v-col></v-row>
                    <v-row><v-col cols="12"><v-textarea outlined auto-grow v-model="this.getDetails(item)" label="Details / Long Message" disabled/></v-col></v-row>
                </v-form>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions v-if="action.edit || action.view">
                <v-row align="center" justify="center" class="m-0 p-0">
<!--                    <v-btn color="primary" text @click="markAsRead(item)"><v-icon class="p-2">mdi-bell-check</v-icon>Mark as Read</v-btn>-->
                    <v-btn color="primary" text @click="close"><v-icon class="p-2">mdi-cancel</v-icon>Cancel</v-btn>
                </v-row>
            </v-card-actions>
            <v-card-actions v-else-if="action.delete">
                <v-row align="center" justify="center" class="m-0 p-0">
                    <span><v-icon color="warning" class="p-2">mdi-alert</v-icon>Are you sure you want to delete this item?</span>
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
        name: "notification-crud",
        props: {
            default_crud_action: "Edit",
            default_title: "Modal title",
        },
        data() {
            return {
                loading: false,
                crud_action: "Edit",
                dialog: false,
                title: "Modal title",
                items: [],
                index: -1,
                item: { },
                defaultItem: { },
                cached_item: {},
                menu: false,
            };
        },
        created() {
            this.defaultItem.project_id = this.item.project_id = this.theProject.id;
            this.item.start_date = this.defaultItem.start_date = this.current_date;
            eventBus.$on('show-notification-crud-dialog', payload => {
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
            },
            markAsRead: function(item) {
                this.loading = true;
                axios
                    .request({ url: '/api/users/'+this.theUser.id+"/notifications/"+item.id+"/markAsRead", method: 'POST',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        this.items=response.data.data;
                        this.loading = false;
                        let payload = { 'text': 'Notification mark as read successful', 'color': 'success', };
                        eventBus.$emit('show-snackbar', payload);
                        eventBus.$emit('refresh-notification-list', { 'list': 'notifications', } );
                        this.close();
                    }).catch(error =>{
                    console.log(error.response);
                    this.loading = false;
                    let payload = { 'text': 'Notification mark as read failed', 'color': 'error', };
                    eventBus.$emit('show-snackbar', payload);
                    this.close();
                })
            },
            getBooleanValue(item) {
                let readAt = item.read_at;
                return readAt != null;
            },
            trash() {
                // There isn't a destroy method at this time
            },
            getNotificationType(item) {
                if(item.type != null){
                    let type = item.type.replace('App\\Notifications\\', '');
                    type = type.replace('Completed', '');
                    type = type.replace('Complete', '');
                    return type;
                }
            },
            getDescription(item) {
                if(item.data != null) {
                    let payload = item.data;
                    return payload.shortMessage;
                }
            },
            getDetails(item) {
                if(item.data != null) {
                    let payload = item.data;
                    return payload.longMessage;
                }
            }
        },
        computed: {
            ...mapState({
                //
            }),
            ...mapGetters({
                theOrg: 'theOrg',
                theProject: 'theProject',
                theUser: 'theUser',
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