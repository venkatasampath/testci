<template>
    <div id="project-instruments">
        <v-autocomplete id="project_instruments" v-model="project_instruments" :label="'Assigned Instruments: '+instruments_count" prepend-icon="mdi-tools"
                        :items="items" item-value="id" item-text="name" filled chips multiple :loading="loading" disabled
                        :hint="hint" persistent-hint :disabled="!action.edit || disabled" :readonly="!isEditing">
<!--            <template v-slot:append-outer>-->
<!--                <v-icon :title="isEditing?'Save':'Edit'" :key="`icon-${isEditing}`" color="primary" :disabled="!action.edit || disabled"-->
<!--                        @click="save" v-text="isEditing?'mdi-content-save':'mdi-circle-edit-outline'">-->
<!--                </v-icon>-->
<!--                <v-icon title="Reset/Undo" v-if="isEditing" class="pl-2" color="primary" :disabled="!action.edit || disabled"-->
<!--                        @click="reset">mdi-undo-variant-->
<!--                </v-icon>-->
<!--            </template>-->
            <template v-slot:selection="data">
                <v-chip v-bind="data.attrs" :input-value="data.selected" :color="data.item.color">
                    <v-avatar left><v-icon small>{{ data.item.icon }}</v-icon></v-avatar>{{ getItemCodeModuleCategory(data.item) }}
                </v-chip>
            </template>
<!--            <template v-slot:item="data">-->
<!--                <template v-if="typeof data.item !== 'object'">-->
<!--                    <v-list-item-content v-text="data.item"></v-list-item-content>-->
<!--                </template>-->
<!--                <template v-else>-->
<!--                    <v-list-item-avatar class="headline" left :color="data.item.color"><v-icon small>{{ data.item.icon }}</v-icon></v-list-item-avatar>-->
<!--                    <v-list-item-content :background-color="data.item.color">-->
<!--                        <v-list-item-title v-html="getItemCodeModule(data.item)"></v-list-item-title>-->
<!--                        <v-list-item-subtitle v-html="data.item.category"></v-list-item-subtitle>-->
<!--                    </v-list-item-content>-->
<!--                </template>-->
<!--            </template>-->
        </v-autocomplete>
    </div>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import axios from "axios";
    import {eventBus} from "../../../eventBus";
    export default {
        name: 'projectInstruments',
        props: {
            crud_action: { type: String, default: "View" },
            project: { type: Object, required: true},
        },
        data() {
            return {
                loading: false,
                isEditing: false,
                disabled: false,
                items: [],
                project_instruments:[],
                cached_project_instruments: null,
                hint: "You can assign instruments to this project",
            }
        },
        created() {
            this.fetchOrgInstruments();
            this.fetchProjectInstruments();

            // Fetch the Org instruments lists
            let payload = { 'type': 'instruments', 'list': true, 'force': true };
            this.$store.dispatch('fetchOrgList', payload).then(() => this.loading = false);
        },
        methods: {
            fetchOrgInstruments() {
                this.loading = true;
                let url = '/api/orgs/'+ this.theOrg.id + '/instruments?list=true';
                axios
                    .request({ url: url, method: 'GET',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        this.loading = false;
                        this.items=response.data.data;
                    })
            },
            fetchProjectInstruments() {
                this.loading = true;
                let url = '/api/projects/' + this.project.id + '/associations?type=instruments';
                axios
                .request({ url: url, method: "GET",
                    headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                })
                .then(response=>{
                    this.project_instruments = response.data.data.map(instrument=>instrument.id);
                    this.cached_project_instruments = Object.assign([], this.project_instruments);
                    this.loading = false;
                }).catch(error => {
                    this.loading = false;
                })
            },
            save: function() {
                if (this.isEditing) {
                    this.loading = true;
                    axios
                        .request({ url: '/api/projects/'+this.project.id+'/associations', method: 'PUT',
                            headers:{ 'Content-Type' : 'application/json', 'Authorization': this.$store.getters.bearerToken, },
                            data: { type: "instruments", listIds: this.project_instruments.map(id => id.toString()), },
                        })
                        .then(response=>{
                            let payload = {'text': 'Instruments Update successful', 'color': 'success',};
                            eventBus.$emit('show-snackbar', payload);
                            this.loading = false;
                        })
                        .catch(error => {
                            let payload = {'text': 'Instruments Update failed', 'color': 'error',};
                            eventBus.$emit('show-snackbar', payload);
                            this.loading = false;
                        });
                }
                this.isEditing = !this.isEditing;
            },
            reset() {
                this.project_instruments = this.cached_project_instruments;
                this.isEditing = !this.isEditing;
            },
            remove (index) {
                if (index >= 0) {
                    this.project_instruments.splice(index, 1);
                }
            },
            getItemCodeModule(item) {
                return item.code + " - " + item.module;
            },
            getItemCodeModuleCategory(item) {
                return item.code + " - " + item.module + " - " + item.category;
            },
        },
        watch: {
            project() {
                if (this.project.id) {
                    this.fetchProjectInstruments();
                }
            }
        },
        computed: {
            ...mapState({
                //
            }),
            ...mapGetters({
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
            }),
            action() {
                const act = this.crud_action;
                return { create: act === "Create", view: act === "View", edit: (act === "Update" || act === "Edit"), list: act === "List", };
            },
            instruments_count()  {
                return (this.project_instruments) ? this.project_instruments.length.toString() : "0";
            }
        }
    }
</script>
