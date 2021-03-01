<template>
    <div id="project-users">
        <v-autocomplete id="project_users" v-model="project_users" :label="'Assigned Users: '+users_count" prepend-icon="mdi-account-multiple"
                        :items="items" item-value="id" item-text="name" filled chips multiple :loading="loading"
                        :hint="hint" persistent-hint :disabled="!action.edit || disabled" :readonly="!isEditing">
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
                    <v-avatar left><v-img :src="data.item.avatar"></v-img></v-avatar>{{ data.item.display_name }}
                </v-chip>
            </template>
            <template v-slot:item="data">
                <template v-if="typeof data.item !== 'object'"><v-list-item-content v-text="data.item"></v-list-item-content></template>
                <template v-else>
                    <v-list-item-avatar><img :src="data.item.avatar"></v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title v-html="data.item.display_name"></v-list-item-title>
                        <v-list-item-subtitle v-html="getRoleDisplayName(data.item)"></v-list-item-subtitle>
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
        name: 'projectUsers',
        props: {
            crud_action: { type: String, default: "Edit" },
            project: { type: Object, required: true},
        },
        data() {
            return {
                loading: false,
                isEditing: false,
                disabled: false,
                items: [],
                project_users:[],
                cached_project_users: null,
                hint: "You can assign users to this project",
            }
        },
        created() {
            this.fetchOrgUsers();
            this.fetchProjectUsers();

            // Fetch the Org users lists
            let payload = { 'type': 'users', 'list': true, 'force': true };
            this.$store.dispatch('fetchOrgList', payload).then(() => this.loading = false);
        },
        methods: {
            fetchOrgUsers() {
                this.loading = true;
                let url = '/api/orgs/'+ this.theOrg.id + '/users?list=true';
                axios
                    .request({ url: url, method: 'GET',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        this.loading = false;
                        this.items=response.data.data;
                    })
            },
            fetchProjectUsers() {
                this.loading = true;
                let url = '/api/projects/' + this.project.id + '/associations?type=users';
                axios
                .request({ url: url, method: "GET",
                    headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                })
                .then(response=>{
                    this.project_users = response.data.data.map(user=>user.id);
                    this.cached_project_users = Object.assign([], this.project_users);
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
                            data: { type: "users", listIds: this.project_users.map(id => id.toString()), },
                        })
                        .then(response=>{
                            let payload = {'text': 'Users Update successful', 'color': 'success',};
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
                this.project_users = this.cached_project_users;
                this.isEditing = !this.isEditing;
            },
            remove (index) {
                if (index >= 0) {
                    this.project_users.splice(index, 1);
                }
            },
            getRoleDisplayName(item) {
                let role = this.roles.find(el => { return el.id === item.role_id});
                return (role)?role.display_name:"";
            },
        },
        watch: {
            project() {
                if (this.project.id) {
                    this.fetchProjectUsers();
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
                roles: 'getRoles',
            }),
            action() {
                const act = this.crud_action;
                return { create: act === "Create", view: act === "View", edit: (act === "Update" || act === "Edit"), list: act === "List", };
            },
            users_count()  {
                return (this.project_users) ? this.project_users.length.toString() : "0";
            }
        }
    }
</script>
