<template>
    <div>
        <!-- Change password component-->
        <change-password></change-password>
        <!-- Main component-->
        <v-menu offset-y left content-class="p-0 m-0 dropdown-menu notification" transition="slide-y-transition">
            <template v-slot:activator="{ on }">
                <v-avatar v-on="on" class="m-2"  dusk="profile-img"><img v-bind:src="theUser.avatar"></v-avatar>
            </template>
            <v-card width="450">
                <v-card-title class="px-2 py-0">
                    <v-list-item class="m-0 p-0">
                        <v-list-item-avatar class="mx-2" size="100">
                            <v-img v-bind:src="theUser.avatar"></v-img>
                        </v-list-item-avatar>
                        <v-list-item-content class="mx-2">
                            <v-list-item-title v-text="theUser.display_name"></v-list-item-title>
                            <v-list-item-title v-text="theUser.email"></v-list-item-title>
                            <v-list-item-title v-text="org_and_role"></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-card-title>
                <v-divider class="m-0"></v-divider>
                <v-card-text class="px-2 py-0">
                    <v-list-item class="m-0 p-0">
                        <v-list-item-content class="m-0 p-0">
                                <v-list-item-title class="m-0 p-0">
                                <v-subheader class="m-0 p-0"><b>Community:</b>
                                <v-btn href="https://github.com/spawaskar-cora/cora-docs" text icon color="primary">
                                    <v-icon>mdi-gitlab</v-icon>
                                </v-btn>
                                <v-btn  href="/forums" text icon color="primary">
                                    <v-icon>mdi-forum</v-icon>
                                </v-btn>
                                <v-btn href="https://cora-spawaskar.slack.com" text icon color="primary">
                                    <v-icon>mdi-slack</v-icon>
                                </v-btn>
                                </v-subheader>
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item class="m-0 p-0">
                        <v-list-item-content class="m-0 p-0">
                            <v-list-item-title class="m-0 p-0"><v-icon>mdi-lock-reset</v-icon><v-btn class="p-1" text color="primary" href="/password/change">Change Password</v-btn></v-list-item-title>
<!--                            <v-list-item-title class="m-0 p-0"><v-icon>mdi-lock-reset</v-icon><v-btn class="p-1" text color="primary" @click="changePassword">Change Password</v-btn></v-list-item-title>-->
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item class="m-0 p-0">
                        <v-list-item-content class="m-0 p-0">
                            <v-list-item-title class="m-0 p-0"><v-icon>mdi-help-circle</v-icon><v-btn class="p-1" text color="primary" href="https://cora-docs.readthedocs.io/" target="_blank">Online Help</v-btn></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item class="m-0 p-0">
                        <v-list-item-content class="m-0 p-0">
                            <v-list-item-title class="m-0 p-0"><v-icon>mdi-information</v-icon><v-btn class="p-1" text color="primary" href="/about" dusk="about-menu">About Application</v-btn></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-card-text>
                <v-card-actions class="p-2">
                    <v-btn depressed color="primary"  class="float-left" v-bind:href="'/users/' + theUser.id + '/profile'">
                        <v-icon left>mdi-account-settings</v-icon>My Profile
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn v-if="isOrgAdmin || isAdmin" depressed color="primary" v-bind:href="'/org/' + theOrg.id + '/profile'">
                        <v-icon left>mdi-office-building</v-icon>Org Profile
                    </v-btn>
                    <v-spacer></v-spacer>
                    <form id="logout-form" action="/logout" method="POST">
                        <input type="hidden" name="_token" :value="csrfToken">
                        <v-btn type="submit" form="logout-form" depressed color="warning" href="#" @click.prevent="logout" dusk="logout-menu">
                            <v-icon left>mdi-logout</v-icon>Logout
                        </v-btn>
                    </form>
                </v-card-actions>
            </v-card>
        </v-menu>
    </div>
</template>
<script>
    import {mapState, mapGetters} from 'vuex';
    import {eventBus} from "../../../eventBus";

    export default{
        props:{
            //
        },
        data () {
            return {
                //
            }
        },
        methods:{
            logout() {
                document.getElementById('logout-form').submit()
            },
            changePassword() {
                let payload = { 'title': 'Change Password - '+this.theUser.display_name, 'action': 'Edit', 'item': this.theUser };
                eventBus.$emit('show-change-password-dialog', payload);
            },
        },
        computed: {
            ...mapGetters({
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
                isAdmin: 'isAdmin',
                isOrgAdmin: 'isOrgAdmin',
                csrfToken: 'csrfToken',
                org_and_role: 'org_and_role',
            }),
        },
    }
</script>
<style scoped>
    .v-menu__content { border: 0;}
</style>