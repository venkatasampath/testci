<template>
    <div id="project">
        <v-autocomplete id="user_projects" v-model="user_projects" :label="'Assigned Projects: '+projects_count" prepend-icon="mdi-briefcase-variant"
                        :items="items" item-value="id" item-text="name" filled chips multiple
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
                    <v-avatar left><v-icon small>{{ data.item.icon }}</v-icon></v-avatar>{{ data.item.name }}
                </v-chip>
            </template>
            <template v-slot:item="data">
                <template v-if="typeof data.item !== 'object'">
                    <v-list-item-content v-text="data.item"></v-list-item-content>
                </template>
                <template v-else>
                    <v-list-item-avatar class="headline" left :color="data.item.color"><v-icon small>{{ data.item.icon }}</v-icon></v-list-item-avatar>
                    <v-list-item-content :background-color="data.item.color">
                        <v-list-item-title v-html="data.item.name"></v-list-item-title>
                        <v-list-item-subtitle v-html="data.item.description"></v-list-item-subtitle>
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
        name: 'userProjects',
        props: {
            crud_action: { type: String, default: "Edit" },
            user: { type: Object, required: true},
        },
        data() {
            return {
                loading: false,
                isEditing: false,
                disabled: false,
                items: [],
                user_projects:[],
                cached_user_projects: null,
                hint: "You can assign projects for this user",
            }
        },
        created() {
            this.fetchOrgProjects();
            this.fetchUserProjects();

            // Fetch the Org projects lists
            let payload = { 'type': 'projects', 'list': true, 'force': true };
            this.$store.dispatch('fetchOrgList', payload).then(() => this.loading = false);
        },
        methods: {
            fetchOrgProjects() {
                this.loading = true;
                let url = '/api/orgs/'+ this.theOrg.id + '/projects?list=true';
                axios
                    .request({ url: url, method: 'GET',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        this.loading = false;
                        this.items=response.data.data;
                    })
            },
            fetchUserProjects() {
                this.loading = true;
                let url = '/api/users/' + this.user.id + '/associations?type=projects';
                axios
                .request({ url: url, method: "GET",
                    headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                })
                .then(response=>{
                    this.user_projects = response.data.data.map(project=>project.id);
                    this.cached_user_projects = Object.assign([], this.user_projects);
                    this.loading = false;
                }).catch(error => {
                    this.loading = false;
                })
            },
            save: function() {
                if (this.isEditing) {
                    this.loading = true;
                    axios
                        .request({ url: '/api/users/'+this.user.id+'/associations', method: 'PUT',
                            headers:{ 'Content-Type' : 'application/json', 'Authorization': this.$store.getters.bearerToken, },
                            data: { type: "projects", listIds: this.user_projects.map(id => id.toString()), },
                        })
                        .then(response=>{
                            let payload = {'text': 'Projects Update successful', 'color': 'success',};
                            eventBus.$emit('show-snackbar', payload);
                            this.loading = false;
                        })
                        .catch(error => {
                            let payload = {'text': 'Projects Update failed', 'color': 'error',};
                            eventBus.$emit('show-snackbar', payload);
                            this.loading = false;
                        });
                }
                this.isEditing = !this.isEditing;
            },
            reset() {
                this.user_projects = this.cached_user_projects;
                this.isEditing = !this.isEditing;
            },
            remove (index) {
                if (index >= 0) {
                    this.user_projects.splice(index, 1);
                }
            },
        },
        watch: {
            user() {
                if (this.user.id) {
                    this.fetchUserProjects();
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
            projects_count()  {
                return (this.user_projects) ? this.user_projects.length.toString() : "0";
            }
        }
    }
</script>
