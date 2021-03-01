<template>
    <v-card>
        <v-card-text>
            <v-row no-gutters>
                <v-col cols="3"><v-card class="py-2 px-2" outlined tile>Last Login Time</v-card></v-col>
                <v-col><v-card class="py-2 px-2" outlined tile>{{theUser.last_login_at}}</v-card></v-col>
            </v-row>
            <v-row no-gutters>
                <v-col cols="3"><v-card class="py-2 px-2" outlined tile>Device</v-card></v-col>
                <v-col><v-card class="py-2 px-2" outlined tile>{{theUser.last_login_device}}</v-card></v-col>
            </v-row>
            <v-row no-gutters>
                <v-col cols="3"><v-card class="py-2 px-2" outlined tile>Total Number of Logins</v-card></v-col>
                <v-col><v-card class="py-2 px-2" outlined tile>{{theUser.number_of_logins}}</v-card></v-col>
            </v-row>
            <v-row no-gutters>
                <v-col cols="3"><v-card class="py-2 px-2" outlined tile>IP Address</v-card></v-col>
                <v-col><v-card class="py-2 px-2" outlined tile>{{theUser.last_login_ip_address}}</v-card></v-col>
            </v-row>
            <v-row no-gutters>
                <v-col cols="3"><v-card class="py-2 px-2" outlined tile>Password Last Changed</v-card></v-col>
                <v-col><v-card class="py-2 px-2" outlined tile>{{theUser.password_updated_at}}</v-card></v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>
<script>
    import {mapGetters} from "vuex";

    export default {
        name: "user-profile-lastlogin",
        computed: {
            ...mapGetters({
                theUser: 'theUser',
            }),
        },
    }
</script>
