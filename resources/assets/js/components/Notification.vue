<template>
    <div class="dropdown" id="notification-dropdown">
        <div class="dropdown-content" id="myDropdown">
            <div class="dropdownHeader">
                <span class="triangle"></span>
                <span class="heading">You have {{ unreadNotificationCount }} unread notifications</span>
            </div>
            <ul class="notification-menu list-group">
                <li v-for="(notification, index) in notificationDetails" :key="notification.id" class="notification-list list-group-item">
                    <div class="row">
                        <div class="col-8" style="padding: 0">
                            <a :href="'/users/' + currentUser.id + '/notifications/show/' + notification.id">{{notification.type | getType }} - {{ notification.data.shortMessage }}</a>
                        </div>
                        <div class="float-right col-4">
                            <button v-on:click="markAsRead" :value=notification.id class="btn btn-secondary btn-sm mark-as-read"><i class="fas fa-check-circle"></i> Mark as Read</button>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="dropdownFooter">
                <div class="row">
                    <div class="col-6">
                        <a :href="'/users/' + currentUser.id + '/notifications'" dusk="viewAllBtn" class="btn btn-primary view-all-btn float-left"><span class="heading"><i class="far fa-eye"></i> View All</span></a>
                    </div>
                    <div class="col-6">
                        <button v-if="unreadNotificationCount > 0" v-on:click="markAllRead" class="btn btn-primary mark-all-read float-right"><i class="fas fa-check-double"></i> Mark All Read</button>
                        <button v-else class="btn btn-primary mark-all-read float-right" disabled><i class="fas fa-check-double"></i> Mark All Read</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
    .dropdown {
        position: relative;
        display: block;
    }
    .dropdownHeader {
        background-color: rgba(0, 0, 0, .03);
        padding: 20px;
        position: relative;
        text-align: center;
        font-weight: bold;
        border-radius: inherit;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }
    .dropdownFooter {
        background-color: #fff;
        position: relative;
        text-align: center;
        font-weight: bold;
        border-radius: inherit;
    }
    .notification-menu {
        margin-bottom: 0;
        max-height: 200px;
        overflow-x: hidden;
    }
    .dropdown-content {
        display: block;
        position: absolute;
        background-color: #fff;
        min-width: 375px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        right: -5px;
        left:  auto;
        border-radius: 10px 10px;
        margin-top: 10px;
    }
    .dropdown-content a {
        padding: 8px 12px;
        text-decoration: none;
        display: inline-block;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
        width: 80%;
    }
    .triangle {
        position: absolute;
        top: -7px;
        left: 350px;
        height: 15px;
        width: 15px;
        border-radius: 3px 0px 0px 0px;
        transform: rotate(45deg);
        background-color: white;
    }
    .notification-list:hover {background-color: #ddd}
    .show {display:block;}
    .mark-all-read {
        display: inline-block;
        padding: 8px 12px;
        width: 80%;
        margin: 5px;
    }
    .notification-menu a {
        color: #636b6f;
    }
    .view-all-btn {
        margin: 5px;
    }
</style>
<script>
    export default {
        props: {
            notificationsCount: Number,
            notifications: Array,
            user: Object
        },
        data: function() {
            return {
                showDropDown: false,
                notificationDetails: this.notifications,
                unreadNotificationCount: this.notificationsCount,
                currentUser: this.user
            }
        },
        mounted() {
            console.log('Notification Component mounted.');
        },

        filters: {
          getType: function(notificationType) {
              notificationType = notificationType.replace('App\\Notifications\\', '');
              return notificationType.replace('Complete', '');
          }
        },

        methods: {
            markAsRead: function(event) {
                var self = this;
                $.ajax({
                    type: 'POST',
                    url: '/users/' + this.user.id + '/notifications/markAsRead',
                    data: {'notificationId': event.target.value},
                    success: function(result) {
                        if(result.success) {
                            console.log("Notification marked as read");
                            self.emitUpdateCountEvent(result.unreadNotificationsCount, result.unreadNotifications);
                        }
                    },
                    error: function() {
                        console.log("Marking failed");
                    }
                });

            },

            markAllRead: function(event) {
                var self = this;
                $.ajax({
                    type: 'POST',
                    url: '/users/' + this.user.id + '/notifications/markAllRead',
                    success: function(result) {
                        if(result.success) {
                            console.log("All Notifications marked as read");
                            self.emitUpdateCountEvent(result.unreadNotificationsCount, result.unreadNotifications);
                        }
                    },
                    error: function() {
                        console.log("Marking failed");
                    }
                });

            },

            emitUpdateCountEvent: function(unreadNotificationsCount, unreadNotifications) {
                this.$emit('updatebadge', unreadNotificationsCount);
                this.unreadNotificationCount = unreadNotificationsCount;
                this.notificationDetails = unreadNotifications;
            }
        }
    }
</script>