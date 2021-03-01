<template>
    <v-card flat>
        <v-container fluid class="m-0 p-0">
            <v-toolbar>
                <v-app-bar-nav-icon v-if="show_nav_menu"></v-app-bar-nav-icon>
                <v-breadcrumbs v-if="show_breadcrumbs" :items="breaditems" large class="p-0"></v-breadcrumbs>
                <v-spacer></v-spacer>
                <v-toolbar-title>{{title}}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-tooltip bottom max-width="400px">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn title="Additional Information" icon v-if="show_info_toolip" color="primary" v-bind="attrs" v-on="on"><v-icon>mdi-information</v-icon></v-btn>
                    </template>
                    <span>{{ info_toolip_text }}</span>
                </v-tooltip>
                <!--  Start - Place dynamic buttons here-->
                <v-btn title="New" icon v-if="show_new_menu" color="primary" @click="fireEventNew" dusk="new-button"><v-icon>mdi-plus-circle</v-icon></v-btn>
                <v-btn title="Edit" icon v-if="show_edit_menu" color="primary" @click="fireEventEdit" dusk="edit-button"><v-icon>mdi-pencil</v-icon></v-btn>
                <v-btn title="Save" icon v-if="show_save_menu" color="primary" @click="fireEventSave" dusk="save-button"><v-icon>mdi-content-save</v-icon></v-btn>
                <v-btn title="Delete" icon v-if="show_delete_menu" color="error" @click="fireEventDelete" dusk="delete-button"><v-icon>mdi-trash-can</v-icon></v-btn>
                <v-btn title="Reset/Undo" icon v-if="show_reset_menu" color="primary" @click="fireEventReset" dusk="reset-button"><v-icon>mdi-undo-variant</v-icon></v-btn>
                <v-btn title="Generate" icon v-if="show_generate_menu" color="primary" :disabled="enable_generate" @click="fireEventGenerate" :loading="show_generate_loading" dusk="generate-button"><v-icon>mdi-clipboard-text-play</v-icon></v-btn>
                <v-btn title="Reset Dashboard" icon v-if="show_reset_dashboard_menu" color="primary" @click="fireEventResetDashboard" dusk="reset-dashboard-button"><v-icon>mdi-undo-variant</v-icon></v-btn>
                <v-btn :title="!isCollapse ? 'Collapse' : 'Expand'" icon v-if="show_collapse_menu" color="primary" @click="fireEventCollapse()" dusk="collapse-button">
                    <v-icon v-text="isCollapse ? 'mdi-arrow-collapse-down' : 'mdi-arrow-collapse-up'"></v-icon>
                </v-btn>
                <v-btn :title="!isCollapseAll ? 'Collapse All' : 'Expand All'" icon v-if="show_collapse_all_menu" color="primary" @click="fireEventCollapseAll()">
                    <v-icon v-text="isCollapseAll ? 'mdi-chevron-triple-down' : 'mdi-chevron-triple-up'"></v-icon>
                </v-btn>
                <v-btn title="Help - CoRA Docs" icon v-if="show_help_menu" color="primary" :href="help_url" target="_blank" dusk="help-button"><v-icon>mdi-help-circle-outline</v-icon></v-btn>
                <!--  End - Place dynamic buttons here-->
                <v-progress-circular v-if="loading" :indeterminate="loading" color="primary"></v-progress-circular>
                <v-btn title="Actions" v-if="show_action_menu" color="primary" icon><v-icon>mdi-dots-vertical</v-icon></v-btn>
                <!-- Specimen Action Menu - Start-->
                <v-menu v-if="show_specimen_action_menu" :close-on-content-click="false" offset-y left content-class="p-0 m-0 dropdown-menu" transition="slide-y-transition">
                    <template v-slot:activator="{ on }">
                        <v-btn title="Actions" icon v-on="on" dusk="actions-button"><v-icon>mdi-dots-vertical</v-icon></v-btn>
                    </template>
                    <v-card width="300px">
                        <v-card-title v-if="se_highlights" class="p-0">
                            <v-toolbar>Specimen Highlights</v-toolbar>
                            <v-list-item class="m-0 p-0">
                                <v-list-item-content class="mx-2" style="font-size: 1.25em" >
                                    <v-list-item-title v-text="seKey"></v-list-item-title>
                                    <v-list-item-title v-text="boneside"></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <template v-slot:default="{ active, toggle }">
                                    <v-list-item-action class="mr-2"><v-switch readonly v-model="specimen.dna_sampled" primary /></v-list-item-action>
                                    <v-list-item-content><v-list-item-title>DNA Sampled</v-list-item-title></v-list-item-content>
                                    <v-list-item-action class="mr-2"><v-switch readonly v-model="specimen.measured" primary /></v-list-item-action>
                                    <v-list-item-content><v-list-item-title>Measured</v-list-item-title></v-list-item-content>
                                </template>
                            </v-list-item>
                            <v-list-item>
                                <template v-slot:default="{ active, toggle }">
                                    <v-list-item-action class="mr-2"><v-switch readonly v-model="specimen.inventoried" primary /></v-list-item-action>
                                    <v-list-item-content><v-list-item-title>Inventoried</v-list-item-title></v-list-item-content>
                                    <v-list-item-action class="mr-2"><v-switch readonly v-model="specimen.reviewed" primary /></v-list-item-action>
                                    <v-list-item-content><v-list-item-title>Reviewed</v-list-item-title></v-list-item-content>
                                </template>
                            </v-list-item>
                            <v-divider class="m-0 p-0"></v-divider>
                        </v-card-title>
                        <v-card-text class="px-2 py-0">
                            <!-- Dynamic Menu Generation Start -->
                            <v-list dense>
                                <template v-for="item in items">
                                    <v-row v-if="item.heading" :key="item.heading" align="center">
                                        <v-col cols="6"><v-subheader v-if="item.heading">{{ item.heading }}</v-subheader></v-col>
                                        <v-col cols="6" class="text-center"><a href="#!" class="body-2 black">EDIT</a></v-col>
                                    </v-row>
                                    <v-divider v-else-if="item.divider" class="m-0 p-0"></v-divider>
                                    <v-list-group v-else-if="item.children && item.visible" :key="item.text" v-model="item.model" value="true" :prepend-icon="item.model ? item.icon : item['icon-alt']" :dusk="item.text">
                                        <template v-slot:activator>
                                            <v-list-item-title>{{ item.text }}</v-list-item-title>
                                        </template>
                                        <v-divider class="m-0 p-0"></v-divider>
                                        <v-list-item class="mx-4" v-for="(child, i) in item.children" no-action :key="i" link :href="child.href" :dusk="child.text">
                                            <v-list-item-icon v-if="child.icon"><v-icon>{{ child.icon }}</v-icon></v-list-item-icon>
                                            <v-list-item-title>{{ child.text }}</v-list-item-title>
                                        </v-list-item>
                                        <v-divider class="m-0 p-0"></v-divider>
                                    </v-list-group>
                                    <v-list-item v-else-if="item.visible" :key="item.text" link :href="item.href" :dusk="item.text">
                                        <v-list-item-icon><v-icon>{{ item.icon }}</v-icon></v-list-item-icon>
                                        <v-list-item-title>{{ item.text }}</v-list-item-title>
                                    </v-list-item>
                                </template>
                            </v-list>
                            <!-- Dynamic Menu Generation End -->
                        </v-card-text>
                    </v-card>
                </v-menu>
                <!-- Specimen Action Menu - End-->
                <!-- Specimen Action Menu - Start-->
                <v-btn title="Dashboard Settings" v-if="show_dashboard_menu" color="primary" icon>
                    <v-icon>mdi-view-dashboard</v-icon>
                </v-btn>
                <!-- Specimen Action Menu - End-->
            </v-toolbar>
        </v-container>
    </v-card>
</template>
<style>
    /*Place your styles here*/
</style>
<script>
    import {mapState, mapGetters} from 'vuex';
    import { eventBus } from '../../eventBus';

    export default {
        name: "contentheader",
        props: {
            model_name: { type: String, default: "" },
            title: { type: String, default: "" },
            trail: { type: Array, default: null },
            breadcrumbs: { type: Boolean, default: true },
            crud_action: { type: Object, default: null },
            help_app_url: { type: String, default: "https://cora-docs.readthedocs.io" },
            nav_menu: { type: Boolean, default: false },
            help_menu: { type: Boolean, default: false },
            new_menu: { type: Boolean, default: false },
            edit_menu: { type: Boolean, default: false },
            save_menu: { type: Boolean, default: false },
            delete_menu: { type: Boolean, default: false },
            collapse_menu: { type: Boolean, default: false },
            collapse_all_menu: { type: Boolean, default: false },
            reset_menu: { type: Boolean, default: false },
            reset_dashboard_menu: { type: Boolean, default: false },
            generate_menu: { type: Boolean, default: false },
            disable_generate: { type: Boolean, default: false },
            action_menu: { type: Boolean, default: false },
            info_toolip: { type: Boolean, default: false },
            info_toolip_text: { type: String, default: "Missing info tooltip text" },
            se_action_menu: { type: Boolean, default: false },
            se_highlights: { type: Boolean, default: false },
            specimen: { type: Object, default: null },
            dashboard_menu: { type: Boolean, default: false },
        },

        data() {
            return {
                loading: false,
                isCollapse: false,
                isCollapseAll: false,
                help_url: this.help_app_url,
                show_help_menu: this.help_menu,
                show_nav_menu: this.nav_menu,
                show_breadcrumbs: this.breadcrumbs,
                show_new_menu: this.new_menu,
                show_edit_menu: this.edit_menu,
                show_save_menu: this.save_menu,
                show_delete_menu: this.delete_menu,
                show_collapse_menu: this.collapse_menu,
                show_collapse_all_menu: this.collapse_all_menu,
                show_reset_menu: this.reset_menu,
                show_reset_dashboard_menu: this.reset_dashboard_menu,
                show_generate_menu: this.generate_menu,
                enable_generate: this.disable_generate,
                show_generate_loading: false,
                show_info_toolip: this.info_toolip,
                show_action_menu: this.action_menu,
                show_specimen_action_menu: this.se_action_menu,
                show_dashboard_menu: this.dashboard_menu,
                breaditems: (this.trail) ? this.trail : [ { text: 'Home', disabled: true, href: '/', }, ],
                bone: null,
                specimen_menu: null,
                items: [
                    {
                        icon: 'fa-venus-mars', 'icon-alt': 'fa-venus-mars',
                        text: 'Biological Profile', model: false,
                        visible: (this.specimen) ? this.specimen.sb.methods : false,
                        children: [
                            { text: 'Age', icon: 'mdi-pound', visible: true, href: (this.specimen) ? '/skeletalelements/'+this.specimen.id+'/age' : "/" },
                            { text: 'Sex', icon: 'mdi-human-male-female', visible: true, href: (this.specimen) ? '/skeletalelements/'+this.specimen.id+'/sex' : "/" },
                            { text: 'Ancestry', icon: 'mdi-tree', visible: true, href: (this.specimen) ? '/skeletalelements/'+this.specimen.id+'/ancestry' : "/" },
                            { text: 'Stature', icon: 'mdi-human-male-height', visible: true, href: (this.specimen) ? '/skeletalelements/'+this.specimen.id+'/stature' : "/" },
                        ],
                    },
                    { icon: 'mdi-dna', text: 'DNA Profile', visible: true, href: (this.specimen) ? '/skeletalelements/'+this.specimen.id+'/dnas': "/"},
                    { icon: 'mdi-radioactive', text: 'Isotope Analysis', visible: true, href: (this.specimen) ? '/isotopes/'+this.specimen.id+'/create' : "/" },
                    { icon: '', text: '', href: '', divider: true },
                    { icon: 'mdi-ruler-square', text: 'Measurements', href: (this.specimen) ? '/skeletalelements/'+this.specimen.id+'/measurements' : "/" , visible: (this.specimen) ? this.specimen.sb.measurements : false },
                    { icon: 'mdi-group', text: 'Zone Classification', href: (this.specimen) ? '/skeletalelements/'+this.specimen.id+'/zones/view' : "/" , visible: (this.specimen) ? this.specimen.sb.zones : false },
                    { icon: 'mdi-format-text', text: 'Taphonomy', visible: true, href: (this.specimen) ? '/skeletalelements/'+this.specimen.id+'/taphonomys' : "/" },
                    { icon: '', text: '', href: '', divider: true },
                    {
                        icon: 'mdi-link', 'icon-alt': 'mdi-link',
                        text: 'Associations', model: false,
                        visible: true,
                        children: [
                            { text: 'Articulations', icon: 'mdi-link-variant', href: (this.specimen) ? '/skeletalelements/'+this.specimen.id+'/articulations' : "/", visible: (this.specimen) ? this.specimen.sb.articulated : false },
                            { text: 'Pair Matching', icon: 'fa-exchange-alt', href: (this.specimen) ? '/skeletalelements/'+this.specimen.id+'/pairs' : "/", visible: (this.specimen) ? this.specimen.sb.paired : false },
                            { text: 'Refits', icon: 'fa-puzzle-piece', href: (this.specimen) ? '/skeletalelements/'+this.specimen.id+'/refits' : "/", visible: (this.specimen) ? this.specimen.sb.refit : false },
                            { text: 'Morphology', icon: 'mdi-shape', href: (this.specimen) ? '/skeletalelements/'+this.specimen.id+'/morphologys' : "/", visible: (this.specimen) ? this.specimen.sb.morphology : false },
                        ],
                    },
                    {
                        icon: 'mdi-flask', 'icon-alt': 'mdi-flask-outline',
                        text: 'Pathology', model: false,
                        visible: true,
                        children: [
                            { text: 'Pathology', icon: 'mdi-flask-outline', visible: true, href: (this.specimen) ? '/skeletalelements/'+this.specimen.id+'/pathologys' : "/" },
                            { text: 'Trauma', icon: 'mdi-pistol', visible: true, href: (this.specimen) ? '/skeletalelements/'+this.specimen.id+'/traumas' : "/" },
                            { text: 'Anomaly', icon: 'mdi-flash', visible: true, href: (this.specimen) ? '/skeletalelements/'+this.specimen.id+'/anomalys' : "/" },
                        ],
                    },
                    { icon: '', text: '', href: '', divider: true },
                    { icon: 'mdi-eye-outline', text: 'Review', visible: true, href: (this.specimen) ? '/skeletalelements/'+this.specimen.id+'/review' : "/" },
                ],
            }
        },

        created() {
            console.log('ContentHeader Component created.');
            // Listen for the generate-loading event and its payload.
            eventBus.$on('generate-loading', loading => {
                this.show_generate_loading = loading;
            });

            eventBus.$on('disable_generate', disable => {
                this.enable_generate = disable;
            });
            eventBus.$on('show_edit', this.fireEventSaveToEdit);
            // this.bone = this.$store.getters.getBone(this.specimen.sb_id);
            this.bone = this.$store.getters.getBone(1);

            if (this.crud_action) {
                this.show_new_menu = this.crud_action.list;
                this.show_edit_menu = this.crud_action.view;
                this.show_save_menu = this.crud_action.edit || this.crud_action.create;
                this.show_delete_menu = this.crud_action.edit && this.delete_menu;
                this.show_reset_menu = this.crud_action.edit || this.crud_action.create;
            }
        },
        watch: {
            //
        },
        methods: {
            fireEventNew() {
                this.$emit('eventNew', this.model_name);
                console.log("fireEventNew: " + this.model_name);
            },
            fireEventEdit() {
                this.$emit('eventEdit', this.model_name);
                this.show_edit_menu = false;
                this.show_save_menu = true;
                this.show_reset_menu = true;
                this.show_delete_menu = this.delete_menu;
                console.log("fireEventEdit: " + this.model_name);
            },
            fireEventSave() {
                this.$emit('eventSave', this.model_name);
                this.show_edit_menu = true;
                this.show_save_menu = false;
                this.show_reset_menu = false;
                this.show_delete_menu = this.delete_menu;
                console.log("fireEventSave: " + this.model_name);
            },
            fireEventSaveToEdit(){
              this.show_edit_menu = true;
              this.show_save_menu = false;
              this.show_reset_menu = false;
              this.show_delete_menu = this.delete_menu;
              console.log("fireEventSave: " + this.model_name);
            },
            fireEventReset() {
                this.$emit('eventReset', this.model_name);
                this.show_edit_menu = true;
                this.show_save_menu = false;
                this.show_reset_menu = false;
                this.show_delete_menu = this.delete_menu;
                console.log("fireEventReset: " + this.model_name);
            },
            fireEventDelete() {
                this.$emit('eventDelete', this.model_name);
                console.log("fireEventDelete: " + this.model_name);
            },
            fireEventResetDashboard() {
                this.$emit('eventResetDashboard', this.model_name);
                console.log("fireEventResetDashboard: " + this.model_name);
            },
            fireEventGenerate() {
                this.$emit('eventGenerate', this.model_name);
                console.log("fireEventGenerate: " + this.model_name);
            },
            fireEventCollapse() {
                this.isCollapse ? this.$emit('eventExpand', this.model_name, this.isCollapse) : this.$emit('eventCollapse', this.model_name, this.isCollapse);
                this.isCollapse = !this.isCollapse;
                console.log("fireEventCollapse: " + (this.isCollapse ? 'eventExpand' : 'eventCollapse'));
            },
            fireEventCollapseAll() {
                this.isCollapseAll ? this.$emit('eventExpandAll', this.model_name, this.isCollapseAll) : this.$emit('eventCollapseAll', this.model_name, this.isCollapseAll);
                this.isCollapseAll = !this.isCollapseAll;
                console.log("fireEventCollapseAll: " + (this.isCollapseAll ? 'eventExpandAll' : 'eventCollapseAll'));
            },
        },

        computed: {
            ...mapState({
                //
            }),
            ...mapGetters({
                theUser: 'theUser',
                theProject: 'theProject',
                theProjectId: 'theProjectId',
            }),
            seKey() {
                return this.specimen.accession_number + ":" + this.specimen.provenance1 + ":" + this.specimen.provenance1 + ":" + this.specimen.designator;
            },
            boneside() {
                return this.specimen.sb.name + ":" + this.specimen.side;
            },
        }
    }
</script>
