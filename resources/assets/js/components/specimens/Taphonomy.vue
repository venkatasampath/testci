<template>
    <div class="m-2">
        <contentheader v-if="show_contentheader" :trail="this.trail" :se_action_menu="(!action.create)" model_name="taphonomy"
                       :specimen="(action.create) ? null : specimen" :crud_action="action"
                       @eventEdit="edit" @eventReset="reset" @eventSave="save">
        </contentheader>
        <v-alert v-if="alert" class="my-1" border="left" colored-border type="info" elevation="2" dismissible>{{alertText}}</v-alert>
        <v-card flat>
            <v-row align="center" justify="center">
                <v-col cols="12" :md="cols" class="py-0">
                    <v-toolbar v-if="show_toolbar">
                        <v-badge color="primary" :content="(this.taphonomys) ? this.taphonomys.length : 0">Taphonomies</v-badge>
                        <v-spacer></v-spacer>
                        <v-btn icon @click="showCollapse = !showCollapse" color="primary" :loading="loading" dusk="se-taphonomy-collapse">
                            <v-icon title="Collapse" v-if="showCollapse">mdi-arrow-collapse-up</v-icon>
                            <v-icon title="Expand" v-if="!showCollapse">mdi-arrow-expand-down</v-icon>
                        </v-btn>
                    </v-toolbar>
                    <v-card outlined v-show="(show_toolbar || show_contentheader) && showCollapse">
                        <v-autocomplete id= "taphonomy_id" v-model="taphonomys" label="Taphonomies" filled chips deletable-chips multiple dusk="se-taphonomys-menu"
                                        :hint="hint" persistent-hint :disabled="!action.edit || disabled" :readonly="!isEditing"
                                        :items="list_items" item-text="name" item-value="id" :placeholder="placeholder">
                            <template v-slot:append-outer>
                                <v-icon :title="isEditing?'Save':'Edit'" :key="`icon-${isEditing}`" color="primary" :disabled="!action.edit || disabled" dusk="se-taphonomy-edit"
                                        @click="save(taphonomys)" v-text="isEditing?'mdi-content-save':'mdi-circle-edit-outline'">
                                </v-icon>
                                <v-icon title="Reset/Undo" v-if="isEditing" class="pl-2" color="primary" :disabled="!action.edit || disabled" dusk="se-taphonomy-reset"
                                        @click="reset(taphonomys)">mdi-undo-variant
                                </v-icon>
                            </template>

                            <template v-slot:selection="data">
                                <v-chip v-bind="data.attrs" :input-value="data.selected" :color="data.item.color" close @click="data.select" @click:close="remove(data.item)">
                                    <v-icon v-if="data.item.icon" left>{{data.item.icon}}</v-icon>{{ data.item.name}}
                                </v-chip>
                            </template>

                            <template v-slot:item="data">
                                <template v-if="typeof data.item !== 'object'"><v-list-item-content v-text="data.item"></v-list-item-content></template>
                                <template v-else>
                                    <v-list-item-avatar class="headline" left :color="data.item.color"><v-icon>{{ data.item.icon }}</v-icon></v-list-item-avatar>
                                    <v-list-item-content :background-color="data.item.color">
                                        <v-list-item-title v-html="data.item.name"></v-list-item-title>
<!--                                        <v-list-item-subtitle v-html="data.item.description"></v-list-item-subtitle>-->
                                    </v-list-item-content>
                                </template>
                            </template>
                        </v-autocomplete>
                    </v-card>
                </v-col>
            </v-row>
        </v-card>
    </div>
</template>

<script>
    import axios from 'axios';
    import {mapGetters, mapState} from "vuex";
    import {changeObjectToArray, apiGetCall, apiPostCall} from '../../coraBaseModules';
    import {eventBus} from "../../eventBus";

    export default {
        name: "Taphonomy",
        props: {
            list: {type: Object, },
            specimen: {type: Object, },
            readonly: {type: Boolean, default: false},
            crud_action: { type: String, default: "Edit" },
            heading: { type: String, default: "Taphonomy" },
            toolbar:{type:Boolean, default: true},
            toolbar_crud:{type:Boolean, default: true},
            contentheader: {type:Boolean, default: true},
            cols: {type:Number, default: 12},
            placeholder: { type: String, default: "Select Taphonomies", },
        },
        data() {
            return {
                loading: false,
                taphonomys: null,
                cached_taphonomys: null,
                dialog: false,
                disabled: false,
                isEditing: false,
                showCollapse:true,
                show_toolbar: this.toolbar,
                items: [],
                hint: "You can apply multiple taphonomies to this specimen",

                type:'taphonomys',
                showSave:false,
                showEdit:false,
                showReset:false,
                show_toolbar_crud: this.toolbar_crud,
                show_contentheader: this.contentheader,
                trail: [{ text: 'Home', disabled: false, href: '/', },
                    { text: 'Specimen', disabled: false, href: (this.specimen) ? '/skeletalelements/'+this.specimen.id : "/" },
                    { text: 'Taphonomy', disabled: true, href: "/" },
                ],
                alert: false,
                alertText: "",
            };
        },
        created() {
            console.log('Taphonomies Component created.');
            this.loading = true;
            let payload = { 'type': 'taphonomies', 'list': true };
            this.$store.dispatch('fetchAppList', payload).then(() => this.loading = false);
        },
        mounted() {
            // on mounted load data asynchronous
            this.getTaphonomy();
        },
        methods:{
            // ToDO this function will get replaced
            //get the Taphonomy values associated with current specimen
            getTaphonomy: function(){
                this.loading=true;
                axios
                    .request({ url: '/api/specimens/'+this.specimen.id+'/associations?type='+this.type, method: 'GET',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization': this.$store.getters.bearerToken,
                        }
                    })
                    .then(response=>{
                        this.taphonomys = response.data.data.map(taphonomy=>taphonomy.id);
                        this.cached_taphonomys = Object.assign([], this.taphonomys);
                        this.loading=false;
                    })
                    .catch(error => {
                        //
                    });
            },
            reset() {
                this.taphonomys = Object.assign([], this.cached_taphonomys);
                this.isEditing = !this.isEditing;
            },
            edit() {
                this.isEditing = !this.isEditing;
            },
            save() {
                if (this.isEditing) {
                    this.loading = true;
                    axios
                        .request({ url: '/api/specimens/'+this.specimen.id+'/associations', method: 'PUT',
                            headers:{ 'Content-Type' : 'application/json', 'Authorization': this.$store.getters.bearerToken, },
                            data: { type: "taphonomys", listIds: this.taphonomys.map(taphonomy => taphonomy.toString()), },
                        })
                        .then(response=>{
                            this.taphonomys = response.data.data.map(taphonomy=>taphonomy.id);
                            let payload = {'text': 'Taphonomies successfully saved', 'color': 'success',};
                            eventBus.$emit('show-snackbar', payload);
                            this.cached_taphonomys = Object.assign([], this.taphonomys);
                            this.loading = false;
                        })
                        .catch(error => {
                            let payload = {'text': 'Taphonomies Update failed', 'color': 'error',};
                            eventBus.$emit('show-snackbar', payload);
                            this.loading = false;
                        });
                }
                this.isEditing = !this.isEditing;
            },
            remove(item) {
                const index = this.taphonomys.indexOf(item.id);
                if (index >= 0) this.taphonomys.splice(index, 1)
            },
        },
        computed: {
            ...mapState({
                list_items: state => state.taphonomies,
            }),
            ...mapGetters({
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
                bearerToken: 'bearerToken',
                csrfToken: 'csrfToken',
            }),
            action() {
                const act = this.crud_action;
                return { create: act === "Create", view: act === "View", edit: (act === "Update" || act === "Edit"), list: act === "List", };
            },
            taphonmies_count()  {
                return (this.taphonomys) ? this.taphonomys.length.toString() : "0";
            }
        },
    }
</script>