<template>
    <v-card>
        <v-card-title class="m-0 p-0">
            <v-app-bar>
                <v-toolbar-title>{{title}}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-progress-circular v-if="loading" :indeterminate="loading" color="primary"></v-progress-circular>
            </v-app-bar>
        </v-card-title>
        <v-card-text>
            <v-list subheader three-line >
                <v-subheader class="p-0">Scheme</v-subheader>
                <v-list-item>
                    <template v-slot:default="{ active, toggle }">
                        <v-list-item-action>
                            <v-switch v-model="themeDark" primary/>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>Dark</v-list-item-title>
                            <v-list-item-subtitle>The application layout scheme to use (Dark or Light)</v-list-item-subtitle>
                        </v-list-item-content>
                    </template>
                </v-list-item>
            </v-list>

            <v-list two-line subheader>
                <v-subheader class="p-0">Drawer</v-subheader>
                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title>
                            <v-radio-group v-model="leftDrawer.type" column>
                                <v-radio v-for="drawer in drawers" :key="drawer" primary :label="drawer" :value="drawer.toLowerCase()" @change="leftDrawerChange"/>
                            </v-radio-group>
                        </v-list-item-title>
                        <v-list-item-subtitle style="white-space: normal;">The application drawer can be set to display permanent, temporary or default</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item>
                    <template v-slot:default="{ active, toggle }">
                        <v-list-item-action>
                            <v-switch v-model="leftDrawer.clipped" primary @change="leftDrawerChange"/>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>Clipped</v-list-item-title>
                            <v-list-item-subtitle style="white-space: normal;">The application left drawer is set to clipped when drawer is permanent</v-list-item-subtitle>
                        </v-list-item-content>
                    </template>
                </v-list-item>
                <v-list-item>
                    <template v-slot:default="{ active, toggle }">
                        <v-list-item-action>
                            <v-switch v-model="leftDrawer.floating" primary @change="leftDrawerChange"/>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>Floating</v-list-item-title>
                            <v-list-item-subtitle style="white-space: normal;">The application left drawer is set to floating when drawer is permanent</v-list-item-subtitle>
                        </v-list-item-content>
                    </template>
                </v-list-item>
                <v-list-item>
                    <template v-slot:default="{ active, toggle }">
                        <v-list-item-action>
                            <v-switch v-model="leftDrawer.mini" primary @change="leftDrawerChange"/>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>Mini</v-list-item-title>
                            <v-list-item-subtitle style="white-space: normal;">The application left drawer is displayed as mini</v-list-item-subtitle>
                        </v-list-item-content>
                    </template>
                </v-list-item>
            </v-list>

            <v-list subheader three-line >
                <v-subheader class="p-0">Footer</v-subheader>
                <v-list-item>
                    <template v-slot:default="{ active, toggle }">
                        <v-list-item-action>
                            <v-switch v-model="footer.inset" primary />
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>Inset</v-list-item-title>
                            <v-list-item-subtitle>The application footer at the bottom will be inset with drawer</v-list-item-subtitle>
                        </v-list-item-content>
                    </template>
                </v-list-item>
            </v-list>
        </v-card-text>
    </v-card>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import { eventBus } from '../../eventBus';
    import axios from "axios";

    export default {
        name: "rhsPanelLayoutOptions",
        props:{
            title: {type:String, default: "Layout Options"},
            show: {type:Boolean, default: false},
        },
        data() {
            return {
                loading: false,
                drawers: ['Default (no property)', 'Permanent', 'Temporary'],
                // leftDrawer: {},
                // rightDrawer: {},
                // footer: {},
            }
        },
        created() {
            console.log('rhsPanelLayoutOptions Component created.');
            // this.leftDrawer = this.$store.getters.appLeftDrawer;
            // this.rightDrawer = this.$store.getters.appRightDrawer;
            // this.footer = this.$store.getters.appFooter;
        },

        mounted() {
            console.log('rhsPanelLayoutOptions Component mounted.');
        },

        methods: {
            leftDrawerChange() {
                console.log("Storing and firing event leftDrawerChange: ", JSON.stringify(this.leftDrawer));
                this.$store.commit('setLeftDrawer', this.leftDrawer);
                this.$emit('app-left-drawer-change', this.leftDrawer);
            }
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
            }),
            themeDark: {
                get() { return this.$store.getters.themeDark; },
                set(val) {
                    this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
                    this.$store.commit('setThemeDark', val);
                }
            },
            leftDrawer: {
                get() { return this.$store.getters.appLeftDrawer; },
                set(val) {
                    console.log("set leftDrawer " + JSON.stringify(val));
                    this.$store.commit('setLeftDrawer', val);
                }
            },
            rightDrawer: {
                get() { return this.$store.getters.appRightDrawer; },
                set(val) {
                    this.$store.commit('setRightDrawer', val);
                }
            },
            footer: {
                get() { return this.$store.getters.appFooter; },
                set(val) {
                    this.$store.commit('setFooter', val);
                }
            },
        },
    }
</script>

<style scoped>
    .wrap-text {
        -webkit-line-clamp: unset !important;
    }
    .v-list-item__title {
        white-space: normal;
    }
</style>