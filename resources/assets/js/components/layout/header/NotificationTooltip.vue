<template>
    <div>
        <v-menu offset-y left content-class="p-0 m-0 dropdown-menu notification" transition="slide-y-transition" :close-on-content-click="false">
            <template v-slot:activator="{ on }">
                <v-badge overlap class="ma-2">
                    <template v-slot:badge><span>{{unreadNotifications.length}}</span></template >
                    <v-avatar :color="(unreadNotifications.length)?'success':''" v-on="on"><v-icon dark>{{(unreadNotifications.length)?'mdi-bell-ring':'mdi-bell'}}</v-icon></v-avatar>
                </v-badge>
            </template>
            <v-card class="p-0 m-0" width="500px">
                <v-card-title class="m-0 p-0">
                    <v-toolbar dense>
                        <v-spacer></v-spacer>
                        <v-chip class="ma-2" color="primary"><v-avatar left><v-icon>mdi-bell-ring</v-icon></v-avatar>{{unreadNotifications.length}} unread notifications</v-chip>
                        <v-spacer></v-spacer>
                    </v-toolbar>
                </v-card-title>
                <v-card-text class="m-0 p-0">
                    <v-data-table dense :headers="headers" :items="unreadNotifications" hide-default-footer>
                        <template v-slot:item.type="{ item }">{{getNotificationType(item)}}</template>
                        <template v-slot:item.data="{ item }">{{getNotificationDetails(item)}}</template>
                        <template v-slot:item.actions="{ item }">
                            <v-icon title="Mark As Read" small color="blue" class="mr-1" @click="markAsRead(item)">mdi-bell-check</v-icon>
                            <v-icon title="View" small color="blue" @click="viewItem(item)">mdi-eye-check</v-icon>
                        </template>
                    </v-data-table>
                </v-card-text>
                <v-card-actions class="m-0">
                    <v-row align="center" justify="center" class="m-0 p-0">
                        <v-btn title="View All" color="primary" text :href="'/users/'+theUser.id+'/notifications'"><v-icon class="p-2">mdi-eye</v-icon>View All</v-btn>
                        <v-btn title="Mark All Read" color="primary" text @click="markAllRead"><v-icon class="p-2">mdi-check-all</v-icon>Mark All Read</v-btn>
                    </v-row>
                </v-card-actions>
            </v-card>
        </v-menu>
        <!-- Add the Crud component for viewing notifications -->
        <notification-crud></notification-crud>
    </div>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import {eventBus} from "../../../eventBus";
    import axios from "axios";

    export default {
        name: "notification-tooltip",
        props: {
            // notifications: { type: Object, default: () => {} },
        },
        data: function() {
            return {
                loading: false,
                items: [],
                total_count: 0,
                headers: [
                    { text: 'Type', value: 'type', width: '4rem'},
                    { text: 'Details', value: 'data', width: '16rem'},
                    { text: 'Actions', value: 'actions', width: '4rem', sortable: false },
                ],
            }
        },
        created() {
            console.log('Notification Component created.');
            this.fetchNotifications();
        },
        methods: {
            fetchNotifications() {
                this.loading = true;
                axios
                    .request({ url: '/api/users/'+this.theUser.id+"/associations?type=notifications", method: 'GET',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        this.items=response.data.data;
                        // console.log("Notification: "+JSON.stringify(response.data));
                        this.total_count = response.data.meta.total;
                        this.loading = false;
                    })
            },
            markAsRead: function(item) {
                axios
                    .request({ url: '/api/users/'+this.theUser.id+"/notifications/"+item.id+"/markAsRead", method: 'POST',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        // console.log("Notification marked as read: "+JSON.stringify(response.data));
                        this.items=response.data.data;
                        this.loading = false;
                    })
            },
            markAllRead: function(event) {
                axios
                    .request({ url: '/api/users/'+this.theUser.id+"/notifications/markAllRead", method: 'POST',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        // console.log("All Notification marked as read: "+JSON.stringify(response.data));
                        this.items=response.data.data;
                        this.loading = false;
                    })
            },
            viewItem(item) {
                let payload = { 'title': 'View Notification', 'action': 'View', 'item': item };
                eventBus.$emit('show-notification-crud-dialog', payload);

                // Also mark the notification as read
                this.markAsRead(item);
            },
            getNotificationType(item) {
                // console.log("getNotificationType: " + JSON.stringify(item));
                let type = item.type.replace('App\\Notifications\\', '');
                type = type.replace('Completed', '');
                type = type.replace('Complete', '');
                return type;
            },
            getNotificationDetails(item) {
                let payload = item.data;
                // console.log("getNotificationDetails: payload: " + JSON.stringify(payload));
                let shortMessage = payload.shortMessage;
                if (shortMessage) {
                    // console.log("shortMessage: " + JSON.stringify(shortMessage));
                    return shortMessage;
                }
                // let job_timestamp = payload.job_timestamp;
                let longMessage = payload.longMessage;
                if (longMessage) {
                    // console.log("longMessage: " + JSON.stringify(longMessage));
                    return longMessage;
                }
            },
        },
        computed: {
            ...mapState({
                //
            }),
            ...mapGetters({
                bearerToken: 'bearerToken',
                csrfToken: 'csrfToken',
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
                getProjectById: 'getProjectById',
                getProjectNameById: 'getProjectNameById',
            }),
            action() {
                const action = this.crud_action;
                return { list: action === "List", create: action === "Create", view: action === "View", edit: (action === "Update" || action === "Edit") };
            },
            title() {
                return "You have " + this.unreadNotifications.length + " unread notifications";
            },
            unreadNotifications() {
                return this.items.filter( el => { return el.read_at === null});
            }
        },
    }
</script>

<style scoped>
    .v-menu__content { border: 0;}
</style>