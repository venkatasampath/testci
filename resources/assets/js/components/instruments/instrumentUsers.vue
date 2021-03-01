<template>
    <div id="instrumentUsers">
        <v-autocomplete id="instrument_users" v-model="instrument_users" label="Assigned Users" prepend-icon="mdi-account-multiple"
                        :items="items" item-value="id" item-text="full_name" filled chips multiple
                        :hint="hint" persistent-hint :disabled="!action.edit || disabled" :readonly="!isEditing" :loading="loading">
            <template v-slot:append-outer>
                <v-icon :title="isEditing?'Save':'Edit'" :key="`icon-${isEditing}`" color="primary" :disabled="!action.edit || disabled"
                        @click="save(instrument_users)" v-text="isEditing?'mdi-content-save':'mdi-circle-edit-outline'">
                </v-icon>
                <v-icon title="Reset/Undo" v-if="isEditing" class="pl-2" color="primary" :disabled="!action.edit || disabled"
                        @click="reset">mdi-undo-variant
                </v-icon>
            </template>
            <template v-slot:selection="data">
                <v-chip v-bind="data.attrs" :input-value="data.selected" @click="data.select" close @click:close="remove(data.index)">
                    <v-avatar left><v-img :src="data.item.avatar"></v-img></v-avatar>{{ data.item.display_name }}
                </v-chip>
            </template>
            <template v-slot:item="data">
                <template v-if="typeof data.item !== 'object'"><v-list-item-content v-text="data.item"></v-list-item-content></template>
                <template v-else>
                    <v-list-item-avatar><img :src="data.item.avatar"></v-list-item-avatar>
                    <v-list-item-content><v-list-item-title v-html="data.item.display_name"></v-list-item-title></v-list-item-content>
                </template>
            </template>
        </v-autocomplete>
    </div>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import {eventBus} from "../../eventBus";
    import axios from "axios";

    export default {
        name: 'instrumentUsers',
        props: {
            crud_action: { type: String, default: "View" },
            instrument: { type: Object, required: true},
        },
        data() {
            return {
                loading: false,
                instrument_users:[],
                isEditing: false,
                cached_instruments: null,
                disabled: false,
                items: [],
                hint: "You can assign multiple users to this instrument",
            }
        },
        created() {
            this.fetchOrgUsers();
            this.fetchInstrumentUsers();

            // Fetch the Org users lists
            let payload = { 'type': 'users', 'list': true, 'force': true };
            this.$store.dispatch('fetchOrgList', payload).then(() => this.loading = false);
        },
        methods: {
            fetchOrgUsers(){
                this.loading = true;
                let url = '/api/orgs/'+ this.theOrg.id + '/users?list=true';
                axios
                    .request({ url: url, method: 'GET',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        this.items=response.data.data;
                        this.loading = false;
                    })
            },
            fetchInstrumentUsers() {
                this.loading = true;
                let url = '/api/instruments/' + this.instrument.id + '/associations?type=users';
                axios
                    .request({ url: url, method: "GET",
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        this.instrument_users = response.data.data.map(user=>user.id);
                        this.cached_instruments = Object.assign([], this.instrument_users);
                        this.loading = false;
                    }).catch(error => {
                        this.loading = false;
                    })
            },
            save: function() {
                if (this.isEditing) {
                    this.loading = true;
                    axios
                        .request({ url: '/api/instruments/'+this.instrument.id+'/associations', method: 'PUT',
                            headers:{ 'Content-Type' : 'application/json', 'Authorization': this.$store.getters.bearerToken, },
                            data: { type: "users", listIds: this.instrument_users.map(user => user.toString()), },
                        })
                        .then(response=>{
                            // this.instrument_users = response.data.data;
                            console.log("instrument_users: " + JSON.stringify(this.instrument_users));
                            let payload = {'text': 'Users successfully saved', 'color': 'success',};
                            eventBus.$emit('show-snackbar', payload);
                            this.loading = false;
                        })
                        .catch(error => {
                            let payload = {'text': 'Users Update failed', 'color': 'error',};
                            eventBus.$emit('show-snackbar', payload);
                            this.loading = false;
                        });
                }
                this.isEditing = !this.isEditing;
            },
            reset() {
                this.instrument_users = this.cached_instruments;
                this.isEditing = !this.isEditing;
            },
            remove (index) {
                if (index >= 0) {
                    this.instrument_users.splice(index, 1)
                }
            },
        },
        computed: {
            ...mapState({
                //
            }),
            ...mapGetters({
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
                // instrument_users: 'getUserInstruments',
                // items: 'getOrgInstruments',
            }),
            action() {
                const act = this.crud_action;
                return { create: act === "Create", view: act === "View", edit: (act === "Update" || act === "Edit"), list: act === "List", };
            },
            instruments_count()  {
                return (this.instrument_users) ? this.instrument_users.length.toString() : "0";
            }
        }
    }
</script>
