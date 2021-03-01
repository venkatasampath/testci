<template>
    <div id="instrument">
        <v-autocomplete id="user_instruments" v-model="selected_instruments" :label="'Assigned Instruments: '+instruments_count" prepend-icon="mdi-tools"
                        :items="(!used_for)?items:user_instruments" item-value="id" item-text="full_name" filled chips multiple
                        :hint="hint" persistent-hint :disabled="!action.edit || disabled" :readonly="!isEditing"
                        :loading="loading">
            <template v-slot:append-outer>
                <v-icon :title="isEditing?'Save':'Edit'" :key="`icon-${isEditing}`" color="primary" :disabled="!action.edit || disabled"
                        @click="save" v-text="isEditing?'mdi-content-save':'mdi-circle-edit-outline'">
                </v-icon>
                <v-icon title="Reset/Undo" v-if="isEditing" class="pl-2" color="primary" :disabled="!action.edit || disabled"
                        @click="reset">mdi-undo-variant
                </v-icon>
            </template>
            <template v-slot:selection="data">
                <v-chip v-bind="data.attrs" :input-value="data.selected" :color="data.item.color" close @click="data.select" @click:close="remove(data.index)">
                    <v-avatar left><v-icon small>{{ data.item.icon }}</v-icon></v-avatar>{{ getItemCodeModuleCategory(data.item) }}
                </v-chip>
            </template>
            <template v-slot:item="data">
                <template v-if="typeof data.item !== 'object'">
                    <v-list-item-content v-text="data.item"></v-list-item-content>
                </template>
                <template v-else>
                    <v-list-item-avatar class="headline" left :color="data.item.color"><v-icon small>{{ data.item.icon }}</v-icon></v-list-item-avatar>
                    <v-list-item-content :background-color="data.item.color">
                        <v-list-item-title v-html="getItemCodeModule(data.item)"></v-list-item-title>
                        <v-list-item-subtitle v-html="data.item.category"></v-list-item-subtitle>
                    </v-list-item-content>
                </template>
            </template>
        </v-autocomplete>
    </div>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import axios from "axios";
    import {eventBus} from "../../../eventBus";
    export default {
        name: 'userInstruments',
        props: {
            crud_action: { type: String, default: "Edit" },
            user: { type: Object, required: true},

            // Instruments are used for measurements/methods.
            used_for: { type: String, default: null },
            specimen: { type: Object, default: null },
        },
        data() {
            return {
                loading: false,
                items: [],
                selected_instruments: [],
                user_instruments:[],
                specimen_instruments: [],
                cached_user_instruments: null,
                cached_specimen_instruments: null,
                preparedInstruments: {},
                isEditing: false,
                disabled: false,
                hint: "You can assign instruments for this user/specimen",
            }
        },
        created() {
            // Fetch both the Org and User instruments lists
            let payload = { 'type': 'instruments', 'list': true, 'force': true };
            this.$store.dispatch('fetchOrgList', payload).then(() => this.loading = false);
            this.$store.dispatch('fetchUserList', payload).then(() => this.loading = false);

            if (!this.used_for) {
                // if the component is used for assigning instruments to users
                this.fetchOrgInstruments();
                this.fetchUserInstruments();
            } else {
                // if the component is used for assigning instruments used for specimen measurements, methods
                this.fetchUserInstruments();
                this.fetchSpecimenInstruments();
            }
        },
        methods: {
            fetchOrgInstruments(){
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
            fetchUserInstruments() {
                this.loading = true;
                let url = '/api/users/' + this.user.id + '/instruments';
                axios
                    .request({ url: url, method: "GET",
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        this.loading = false;
                        this.user_instruments = response.data.data;
                        if (!this.used_for) {
                            this.selected_instruments = this.user_instruments.map(el=>el.id);
                        }
                        this.cached_user_instruments = this.selected_instruments;
                    }).catch(error => {
                        this.loading = false;
                    })
            },
            fetchSpecimenInstruments() {
                this.loading = true;
                let url = '/api/specimens/' + this.specimen.id + '/associations?type=instruments';
                axios
                    .request({ url: url, method: "GET",
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        this.specimen_instruments = response.data.data;
                        this.selected_instruments = response.data.data.map(el=>el.id);
                        this.cached_specimen_instruments = Object.assign([], this.selected_instruments);
                        this.loading=false;
                    }).catch(error => {
                        this.loading = false;
                    })
            },
            save: function() {
                if (this.isEditing) {
                    this.loading = true;
                    this.prepareInstrumentsForSave();
                    let url = (!this.used_for) ? '/api/users/'+this.user.id+'/associations' : '/api/specimens/'+this.specimen.id+'/associations';
                    let data = { "type": "instruments", "instrument_type": this.used_for, "listIds": this.preparedInstruments };
                    // console.log("Url: " + url);
                    // console.log("Save: " + JSON.stringify(data));

                    axios
                        .request({ url: url, method: 'PUT', data: data,
                            headers:{ 'Content-Type' : 'application/json', 'Authorization': this.$store.getters.bearerToken, },
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
                this.selected_instruments = (!this.used_for) ? this.cached_user_instruments : this.cached_specimen_instruments;
                this.isEditing = !this.isEditing;
            },
            remove (index) {
                if (index >= 0) {
                    this.selected_instruments.splice(index, 1);
                }
            },
            getItemCodeModule(item) {
                return item.code + " - " + item.module;
            },
            getItemCodeModuleCategory(item) {
                return item.code + " - " + item.module + " - " + item.category;
            },
            prepareInstrumentsForSave() {
                this.preparedInstruments = {};
                let instruments = this.selected_instruments;
                if (!this.used_for) {
                    this.preparedInstruments = instruments.map(el => el.toString())
                } else {
                    for (let i = 0; i < instruments.length; i++) {
                        Vue.set(this.preparedInstruments, instruments[i].toString(), {
                            "type": this.used_for, "created_by": this.user.display_name, "updated_by": this.user.display_name,
                            "org_id": this.theOrg.id, "user_id": this.user.id, "project_id": this.theProject.id,
                        })
                    }
                }
            },
        },
        watch: {
            user() {
                if (this.user.id) {
                    this.fetchUserInstruments();
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
                return (this.selected_instruments) ? this.selected_instruments.length.toString() : "0";
            }
        }
    }
</script>
