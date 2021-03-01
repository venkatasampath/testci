<template>
    <nav data-app>
        <!-- Main Navigation Left Drawer Start -->
        <v-navigation-drawer v-model="leftDrawer.model" :clipped="leftDrawer.clipped" :floating="leftDrawer.floating" app overflow dusk="left-navbar"
                             :mini-variant="leftDrawer.mini" :permanent="leftDrawer.type === 'permanent'" :temporary="leftDrawer.type === 'temporary'">
            <!-- Dynamic Menu Generation Start -->
            <v-list dense>
                <template v-for="item in items">
                    <v-row v-if="item.heading" :key="item.heading" align="center">
                        <v-col cols="6"><v-subheader v-if="item.heading">{{ item.heading }}</v-subheader></v-col>
                        <v-col cols="6" class="text-center"><a href="#!" class="body-2 black">EDIT</a></v-col>
                    </v-row>
                    <v-divider v-else-if="item.divider" class="m-0 p-0"></v-divider>
                    <v-list-group v-else-if="item.children && canAnyChildren(item)" :key="item.text"
                                  v-model="item.model" value="true"
                                  :prepend-icon="item.model?item['icon-alt']:item.icon" :dusk="item.text">
                        <template v-slot:activator><v-list-item-title>{{ item.text }}</v-list-item-title></template>
                        <v-divider class="m-0 p-0"></v-divider>
                        <v-list-item class="mx-4" v-if="can(child.permission)" v-for="(child, i) in item.children" no-action :key="i" link :href="child.href" :dusk="child.text">
                            <v-list-item-icon v-if="child.icon"><v-icon>{{ child.icon }}</v-icon></v-list-item-icon>
                            <v-list-item-title>{{ child.text }}</v-list-item-title>
                        </v-list-item>
                        <v-divider class="m-0 p-0"></v-divider>
                    </v-list-group>
                    <v-list-item v-else-if="!item.children" :key="item.text" link :href="item.href" :dusk="item.text">
                        <v-list-item-icon><v-icon>{{ item.icon }}</v-icon></v-list-item-icon>
                        <v-list-item-title>{{ item.text }}</v-list-item-title>
                    </v-list-item>
                </template>
            </v-list>
            <!-- Dynamic Menu Generation End -->
        </v-navigation-drawer>
        <!-- Main Navigation Left Drawer End -->

        <!-- Main App Bar Start -->
        <v-app-bar :clipped-left="leftDrawer.clipped" :clipped-right="rightDrawer.clipped" app :prominent="$vuetify.breakpoint.mdAndDown">
            <v-app-bar-nav-icon v-if="leftDrawer.type !== 'permanent'" @click.stop="leftDrawer.model = !leftDrawer.model" dusk="leftSideBar-menu"/>
            <a class="hidden-sm-and-down" href="/" ><v-img src="/cora-logo-new-gray.svg" style="max-height: 32px; max-width: 128px; margin-right: 24px"></v-img></a>
            <div class="hidden-md-and-up"><v-app-bar-nav-icon><v-img src="/favicon.ico" width="32px" height="32px" max-width="32px"/></v-app-bar-nav-icon></div>
            <v-toolbar-items>
                <projectswitcher class="float-left"/>
            </v-toolbar-items>
            <v-toolbar-items class="hidden-xs-only">
                <projectsearchbar/>
            </v-toolbar-items>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <NotificationTooltip></NotificationTooltip>
                <AccountTooltip></AccountTooltip>
                <div><v-app-bar-nav-icon><v-icon @click.stop="rightDrawer.model = !rightDrawer.model">mdi-cogs</v-icon></v-app-bar-nav-icon></div>
            </v-toolbar-items>
        </v-app-bar>
        <!-- Main App Bar End -->

        <!-- Right Drawer Start -->
        <v-navigation-drawer v-model="rightDrawer.model" :clipped="leftDrawer.clipped" right app temporary hide-overlay :width="($vuetify.breakpoint.smAndDown) ? 250 : 450">
            <!-- Tabs Inside Right Drawer Start-->
            <v-tabs v-model="tabs" grow>
                <v-tab class="primary--text"><v-icon>mdi-wrench</v-icon></v-tab>
                <v-tab class="primary--text"><v-icon>mdi-help-circle-outline</v-icon></v-tab>
                <v-tab class="primary--text"><v-icon>mdi-home</v-icon></v-tab>
                <v-tab class="primary--text"><v-icon>mdi-settings</v-icon></v-tab>
            </v-tabs>
            <v-tabs-items v-model="tabs" class="elevation-1">
                <v-tab-item>
                    <v-card>
                        <v-card-title>Layout Options</v-card-title>
                        <v-card-text>
                            <v-list subheader three-line>
                                <v-subheader class="p-0">Scheme</v-subheader>
                                <v-list-item>
                                    <template v-slot:default="{ active, toggle }">
                                        <v-list-item-action><v-switch v-model="themeDark" primary/></v-list-item-action>
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
                                                <v-radio v-for="drawer in drawers" :key="drawer" primary :label="drawer" :value="drawer.toLowerCase()"/>
                                            </v-radio-group>
                                        </v-list-item-title>
                                        <v-list-item-subtitle style="white-space: normal;">The application drawer can be set to display permanent, temporary or default</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>

                                <v-list-item>
                                    <template v-slot:default="{ active, toggle }">
                                        <v-list-item-action><v-switch v-model="leftDrawer.clipped" primary/></v-list-item-action>
                                        <v-list-item-content>
                                            <v-list-item-title>Clipped</v-list-item-title>
                                            <v-list-item-subtitle style="white-space: normal;">The application left drawer is set to clipped when drawer is permanent</v-list-item-subtitle>
                                        </v-list-item-content>
                                    </template>
                                </v-list-item>
                                <v-list-item>
                                    <template v-slot:default="{ active, toggle }">
                                        <v-list-item-action><v-switch v-model="leftDrawer.floating" primary/></v-list-item-action>
                                        <v-list-item-content>
                                            <v-list-item-title>Floating</v-list-item-title>
                                            <v-list-item-subtitle style="white-space: normal;">The application left drawer is set to floating when drawer is permanent</v-list-item-subtitle>
                                        </v-list-item-content>
                                    </template>
                                </v-list-item>
                                <v-list-item>
                                    <template v-slot:default="{ active, toggle }">
                                        <v-list-item-action><v-switch v-model="leftDrawer.mini" primary/></v-list-item-action>
                                        <v-list-item-content>
                                            <v-list-item-title>Mini</v-list-item-title>
                                            <v-list-item-subtitle style="white-space: normal;">The application left drawer is displayed as mini</v-list-item-subtitle>
                                        </v-list-item-content>
                                    </template>
                                </v-list-item>
                            </v-list>

                            <v-list subheader three-line>
                                <v-subheader class="p-0">Footer</v-subheader>
                                <v-list-item>
                                    <template v-slot:default="{ active, toggle }">
                                        <v-list-item-action><v-switch v-model="footer.inset" primary/></v-list-item-action>
                                        <v-list-item-content>
                                            <v-list-item-title>Inset</v-list-item-title>
                                            <v-list-item-subtitle>The application footer at the bottom will be inset with drawer</v-list-item-subtitle>
                                        </v-list-item-content>
                                    </template>
                                </v-list-item>
                            </v-list>
                        </v-card-text>
                    </v-card>
                    <!--  <rhs-panel-layout-options></rhs-panel-layout-options>-->
                </v-tab-item>

                <v-tab-item><rhs-panel-help :help_url="help_url"></rhs-panel-help></v-tab-item>
                <v-tab-item><rhs-panel-user-activity></rhs-panel-user-activity></v-tab-item>
                <v-tab-item><rhs-panel-user-settings></rhs-panel-user-settings></v-tab-item>
            </v-tabs-items>
            <!-- Tabs Inside Right Drawer End-->
        </v-navigation-drawer>
        <!-- Right Drawer End -->

        <!-- Application Snackbar-->
        <snackbar></snackbar>
    </nav>
</template>
<script>
    import {mapState, mapGetters} from 'vuex';
    import AccountTooltip from './header/AccountTooltip';
    import NotificationTooltip from './header/NotificationTooltip';
    import RhsPanelLayoutOptions from "../common/rhsPanelLayoutOptions";
    import {eventBus} from "../../eventBus";

    export default {
        name: "coraheader",
        props: {
            user: {type: Object, default: null, required: true},
            org: {type: Object, default: null, required: true},
            project: {type: Object, default: null, required: true},
            role: {type: Object, default: null, required: true},
            projects: {type: Array, default: null, required: true},
            roles: {type: Array, default: null},
            permissions: {type: Array, default: null},
            base_url: {type: String, default: null},
        },
        components: {
            RhsPanelLayoutOptions,
            AccountTooltip,
            NotificationTooltip,
        },
        data() {
            return {
                loading: false,
                drawers: ['Default (no property)', 'Permanent', 'Temporary'],
                leftDrawer: {
                    model: null,
                    // type: 'default (no property)',
                    type: 'temporary',
                    clipped: true,
                    floating: false,
                    mini: false,
                },
                rightDrawer: {
                    model: null,
                    clipped: true,
                },
                footer: {
                    inset: false,
                },
                tabs: null,
                right: null,
                ToggleSidebar: null,
                ToggleLeftSideBar: null,
                ToggleRightSideBar: null,
                ToggleRightSideBarSkin: null,
                help_url: "https://cora-docs.readthedocs.io",
                items: [
                    { text: 'Dashboard', icon: 'mdi-monitor-dashboard', href: '/dashboard', permission: 'browse_skeletal_elements', },
                    { text: 'Specimen', icon: 'mdi-skull', 'icon-alt': 'mdi-skull-outline', model: false, permission: 'browse_skeletal_elements',
                        children: [
                            { text: 'New Specimen', icon: 'mdi-plus-circle', href: '/skeletalelements/create', permission: 'add_skeletal_elements' },
                            { text: 'New via Bone Group', icon: 'mdi-plus-circle-multiple', href: '/skeletalelements/createbygroup', permission: 'add_skeletal_elements' },
                            { text: 'New via Homunculus', icon: 'mdi-human-handsdown', href: '/skeletalelements/createbygroup', permission: 'add_skeletal_elements' },
                            { text: 'Advanced Specimen Report', icon: 'mdi-magnify-plus-outline', href: '/reports/advanced', permission: 'browse_skeletal_elements' },
                        ],
                    },
                    { text: 'DNA', icon: 'mdi-dna', 'icon-alt': 'mdi-dna', model: false, permission: 'browse_dnas',
                        children: [
                            { text: 'mito DNA Report', icon: 'mdi-alpha-m-box-outline', href: '/reports/mtdna', permission: 'browse_dnas' },
                            { text: 'auStr DNA Report', icon: 'mdi-alpha-a-box-outline', href: '/reports/austrdna', permission: 'browse_dnas' },
                            { text: 'yStr DNA Report', icon: 'mdi-alpha-y-box-outline', href: '/reports/ystrdna', permission: 'browse_dnas' },
                        ],
                    },
                    { text: 'Isotope', icon: 'mdi-radioactive', 'icon-alt': 'mdi-radioactive', model: false, permission: 'browse_isotopes',
                        children: [
                            { text: 'Isotope Batches', icon: 'mdi-radioactive', href: '/isotopebatch', permission: 'browse_isotopes' },
                            { text: 'New Isotope Batch', icon: 'mdi-plus-circle', href: '/isotopebatch/create', permission: 'browse_isotopes' },

                        ],
                    },
                    { text: 'Dental', icon: 'mdi-tooth', 'icon-alt': 'mdi-tooth-outline', model: false, permission: 'browse_skeletal_elements',
                        children: [
                            { text: 'New Tooth', icon: 'mdi-plus-circle', href: '/dental/create', permission: 'add_skeletal_elements', },
                            { text: 'New via Dentition Group', icon: 'mdi-plus-circle-multiple', href: '/dental/createbygroup', permission: 'add_skeletal_elements' },
                            { text: 'New via Dental Chart', icon: 'mdi-image-frame', href: '/dental/createbychart', permission: 'add_skeletal_elements' },
                        ],
                    },
                    { text: 'File Export/Import', icon: 'mdi-file-multiple', 'icon-alt': 'mdi-file-multiple-outline', model: false, permission: 'browse_skeletal_elements',
                        children: [
                            { text: 'File Export', icon: 'mdi-file-export', href: '/exportOptions', permission: 'add_skeletal_elements', },
                            { text: 'File Import', icon: 'mdi-file-import', href: '/importFile', permission: 'add_skeletal_elements', },
                            { text: 'File Manager', icon: 'mdi-file-find', href: '/exportFileManager', permission: 'add_skeletal_elements', },
                        ],
                    },
                    { text: 'Project Reports', icon: 'mdi-clipboard-text-multiple', href: '/reports/dashboard', permission: 'browse_skeletal_elements', },
                    { text: 'Org Reports', icon: 'mdi-notebook-multiple', href: '/reports/org/dashboard', permission: 'browse_skeletal_elements', },
                    { text: 'Analytics', icon: 'mdi-graphql', 'icon-alt': 'mdi-graphql', model: false, permission: 'browse_orgs',
                        children: [
                            { text: 'Specimen Canvas', icon: 'mdi-bone', href: '/analytics/specimen-canvas', permission: 'browse_orgs', },
                            { text: 'Project Canvas', icon: 'mdi-briefcase-variant', href: '/analytics/project-canvas', permission: 'browse_orgs', },
                            { text: 'Individual Homunculus', icon: 'mdi-human-handsdown', href: '/analytics/individual-numbers', permission: 'browse_orgs', },
                        ],
                    },
                    { text: 'Visualizations', icon: 'mdi-eye-circle', href: '/visualizations/dashboard', permission: 'browse_skeletal_elements', },
                    { text: 'Administration', icon: 'mdi-account-supervisor', 'icon-alt': 'mdi-account-supervisor-outline', model: false,
                        children: [
                            { text: 'Org Management', icon: 'mdi-office-building', href: '/orgs', permission: 'browse_orgs' },
                            { text: 'User Management', icon: 'mdi-account-multiple', href: '/users', permission: 'browse_users' },
                            { text: 'Project Management', icon: 'mdi-briefcase-variant', href: '/projects', permission: 'browse_projects' },
                            { text: 'Accession Management', icon: 'mdi-map-marker-radius', href: '/accessions', permission: 'browse_accessions' },
                            { text: 'Instrument Management', icon: 'mdi-tools', href: '/instruments', permission: 'browse_instruments' },
                            { text: 'Haplogroup Management', icon: 'mdi-tree', href: '/haplogroups', permission: 'browse_haplogroups' },
                            { text: 'Tag Management', icon: 'mdi-tag-multiple', href: '/tags', permission: 'browse_tags' },
                        ],
                    },
                ],
            }
        },

        created() {
            console.log('Cora Header Component created.');

            // We call the userLogin action on the Vuex store to setup important application state data
            // such as theUser, theOrg, theProject, etc.
            if (this.user) {
                this.loading = true;
                // Expecting user, org, project to be sent
                this.$store.dispatch('userLogin', {
                    'user': this.user,
                    'org': this.org,
                    'project': this.project,
                    'projects': this.projects,
                    'baseURL': this.base_url
                }).then(() => this.loading = false);
            }

            // Set the vuetify theme
            const theme = localStorage.getItem("theme-dark");
            this.$vuetify.theme.dark = !!(theme && theme === "true");

            eventBus.$on('help-sideout', url => {
                console.log("Header: Event received help-sideout with ", JSON.stringify(url))
                this.tabs = 1;
                this.rightDrawer.model = true;
                this.help_url = url;
            });

            // this.leftDrawer = this.$store.getters.appLeftDrawer;
            // this.rightDrawer = this.$store.getters.appRightDrawer;
            // this.footer = this.$store.getters.appFooter;
            //
            // // Listen for the generate-loading event and its payload.
            // eventBus.$on('app-left-drawer-change', drawer => {
            //     console.log("Event received app-left-drawer-change with ", JSON.stringify(drawer))
            //     this.leftDrawer = drawer;
            // });
        },
        methods: {
            canAnyChildren (item) {
                if (item.children) {
                    for (let child of item.children) {
                        // console.log("child: " + JSON.stringify(child))
                        if (this.can(child.permission)) {
                            return true;
                        }
                    }
                    return false;
                }
                return true;
            },
        },
        computed: {
            ...mapState({
                //
            }),
            ...mapGetters({
                can: 'can',
            }),
            themeDark: {
                get() {
                    return this.$store.getters.themeDark;
                },
                set(val) {
                    this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
                    this.$store.commit('setThemeDark', val);
                }
            },
            isMobilePhone() {
                return this.$vuetify.breakpoint.xsOnly;
            },
            isMobile() {
                return this.$vuetify.breakpoint;
            },
        }
    }
</script>
<style scoped>
    nav {
        clear: both;
        min-height: 64px;
        width: 100%;
    }
</style>
