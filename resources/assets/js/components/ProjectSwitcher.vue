<template>
    <v-card tile flat style="top: 16px; background-color: inherit">
        <v-form id="form-project-switch" :action="url" method="post">
            <input type="hidden" id="currentProject" name="currentProject">
            <input type="hidden" id="_token" name="_token">
            <v-autocomplete id="project-switcher-projects" name="projects" v-model="currentselection"
                            :items="projectsData" item-text="projectsText" item-value="projectsValue" required
                            label="Current Project" placeholder="Select Project" dusk="project-switcher-current-project">
                <template v-slot:append-outer>
                    <v-icon title="Switch Project" color="primary" @click="switchproject" :disabled="disableswitchbutton">mdi-briefcase-variant</v-icon>
                </template>
            </v-autocomplete>
        </v-form>
    </v-card>
</template>
<style>
    /*Place your styles here*/
</style>
<script>
    import {mapState, mapGetters} from 'vuex';

    export default {
        name: "ProjectSwitcher",
        props: {
            disabled: { type: Boolean, default: false },
        },

        data: function () {
            return {
                loading: false,
                currentselection: 0,
                disableswitchbutton: true,
                url: "",
            }
        },

        created() {
            console.log('ProjectSwitcher Component created.');
            this.loading = true;
            this.currentselection = this.theProjectId;
            this.url =  "/users/" + this.theUser.id + "/refreshDashboard";
        },

        watch: {
            'currentselection': function(val, oldVal) {
                console.log("currentselection: " + val + " oldVal: " + oldVal);
                this.$store.commit("setCurrentProjectSelection", val);
                this.disableswitchbutton = (this.theProjectId === val);
            },
        },

        methods: {
            switchproject: function (event) {
                console.log("currentselection: " + this.currentselection + " and theProject.id: " + this.theProject.id);
                if (this.currentselection === this.theProject.id) {
                    console.log("You are currently in project " + this.theProject.name);
                    alert("You are currently in project " + this.theProject.name);
                } else {
                    this.loading = true;
                    if (confirm("Are you sure you want to switch the project?")) {
                        this.$store.dispatch('switchProjectAPI', this.theUser)
                            .then(() => {
                                this.loading = false;
                                this.disableswitchbutton = true;
                                console.log("Firing Event: Project switched");
                            })
                    } else {
                        this.currentselection = this.theProject.id;
                    }
                    this.loading = false;
                }
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
                projectsData: 'getProjectsIdNameArray',
            }),

            // url: "/users/" + this.theUser.id + "/refreshDashboard",
        }
    }
</script>
