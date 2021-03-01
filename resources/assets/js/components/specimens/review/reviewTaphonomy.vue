<template>
    <div>
        <v-progress-linear v-if="loading" indeterminate color="primary"></v-progress-linear>
        <v-card>
            <v-card-title>
                <v-row class="align-center justify-center">
                    <v-col><v-row class="align-center justify-center"><span>Original</span></v-row></v-col>
                    <v-col><v-row class="align-center justify-center"><span>Review</span></v-row></v-col>
                </v-row>
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="6">
                        <v-autocomplete v-model="state.original" label="Taphonomies" filled chips multiple disabled readonly dusk="se-taphonomys-menu"
                                        :items="list_items" item-text="name" item-value="id" :hint="hint" persistent-hint>
                            <template v-slot:selection="data">
                                <v-chip v-bind="data.attrs" :input-value="data.selected" :color="data.item.color">
                                    <v-icon v-if="data.item.icon" left>{{data.item.icon}}</v-icon>{{ data.item.name}}
                                </v-chip>
                            </template>
                        </v-autocomplete>
                    </v-col>
                    <v-col cols="6">
                        <v-autocomplete v-model="state.review" label="Taphonomies" filled chips deletable-chips multiple dusk="se-taphonomys-menu"
                                        :items="list_items" item-text="name" item-value="id" :hint="hint" persistent-hint>
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
                                    </v-list-item-content>
                                </template>
                            </template>
                        </v-autocomplete>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-row class="justify-center">
                    <v-btn v-if="show_save" color="primary" class="mr-2" @click="save" dusk="taphonomy-review-save"><v-icon class="mr-2">mdi
                      -content-save</v-icon>Save</v-btn>
                    <v-btn v-if="show_accept" color="primary" @click="accept" dusk="taphonomy-review-accept"><v-icon class="mr-2">mdi-thumb-up
                      -outline</v-icon>Accept</v-btn>
                </v-row>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import axios from 'axios';
    import {eventBus} from "../../../eventBus";

    export default{
        name: 'review-taphonomy',
        props:{
            specimen: { type: Object|Array, required: true },
        },
        data() {
            return {
                loading: true,
                fully_loaded: false,
                show_save: true,
                show_accept: false,
                state: {
                    type: "taphonomys",
                    original: [],
                    review: [],
                    diff: null,
                    action: {create: false, edit: false,},
                    reviewRecord: null,
                },
                hint: "You can apply multiple taphonomies to this specimen",
                placeholder: "Select Taphonomies",
                list_items: [],
            };
        },
        created() {
            console.log("reviewTaphonomy component created");
            this.loadOriginal();
            this.loadReview();

            // Should we show the Save (Review) button
            this.show_save = (this.theUser.id !== this.specimen.user_id) || (this.isAdminOrOrgAdmin || this.isProjectManager);
            // Should we show the accept button
            this.show_accept = (this.theUser.id === this.specimen.user_id) || (this.isAdminOrOrgAdmin || this.isProjectManager);
        },
        mounted() {
            console.log("reviewTaphonomy mounted created");
            this.list_items = this.items;
        },
        methods: {
            loadOriginal() {
                this.loading=true;
                axios
                .request({ url: '/api/specimens/'+this.specimen.id+'/associations?type='+this.state.type, method: 'GET',
                    headers:{ 'Content-Type' : 'application/json', 'Authorization': this.$store.getters.bearerToken,
                    }
                })
                .then(response=>{
                    this.state.original = response.data.data.map(taphonomy=>taphonomy.id);
                    if (this.fully_loaded) {
                        eventBus.$emit('review', {'type': this.state.type, 'state': this.state});
                    }
                    this.loading=false;
                    this.fully_loaded=true;
                })
                .catch(error => {
                    //
                });
            },
            loadReview() {
                this.loading = true;
                axios({ url: "/api/review/" + this.specimen.id, method: 'GET',
                    headers: {'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken,},
                    params: {"type": this.state.type,},
                }).then((response) => {
                    this.state.reviewRecord = response.data.data;
                    if (this.state.reviewRecord.review) {
                        this.state.review = JSON.parse(this.state.reviewRecord.review);
                        this.state.action.edit = true;
                    } else {
                        this.state.action.create = true;
                    }

                    if (this.fully_loaded) {
                        eventBus.$emit('review', {'type': this.state.type, 'state': this.state});
                    }
                    this.loading = false;
                    this.fully_loaded=true;
                }).catch((error) => {
                    console.log(error);
                    this.loading = false;
                });
            },
            save() {
                axios
                .request({ url: "/api/review", method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken,},
                    data: {
                        "se_id": this.specimen.id, "type": this.state.type,
                        "original": this.state.original,
                        "review": this.state.review,
                    }
                })
                .then(response => {
                    this.loading = false;
                    let payload = {'text': 'Update successful', 'color': 'success',};
                    eventBus.$emit('show-snackbar', payload);
                    this.state.action.create = false;
                    this.state.action.edit = true;
                    eventBus.$emit('review', {'type': this.state.type, 'state': this.state});

                }).catch(error => {
                    console.log(error.response);
                    this.loading = false;
                    let payload = {'text': 'Update failed', 'color': 'error',};
                    eventBus.$emit('show-snackbar', payload);
                })
            },
            accept() {
                axios
                .request({ url: "/api/review/" + this.specimen.id + "/accept", method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken,},
                    data: {
                        "se_id": this.specimen.id,
                        "type": this.state.type,
                        "review": this.state.review,
                    }
                })
                .then(response => {
                    this.loading = false;
                    let payload = {'text': 'Update successful', 'color': 'success',};
                    eventBus.$emit('show-snackbar', payload);
                    this.state.action.create = false;
                    this.state.action.edit = true;
                    eventBus.$emit('review', {'type': this.state.type, 'state': this.state});
                    location.reload();
                }).catch(error => {
                    console.log(error.response);
                    this.loading = false;
                    let payload = {'text': 'Update failed', 'color': 'error',};
                    eventBus.$emit('show-snackbar', payload);
                })
            },
            remove(item) {
                const index = this.state.review.indexOf(item.id);
                if (index >= 0) this.state.review.splice(index, 1)
            },
        },
        computed:{
            ...mapState({
                //
            }),
            ...mapGetters({
                bearerToken: 'bearerToken',
                csrfToken: 'csrfToken',
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
                isAdminOrOrgAdmin: 'isAdminOrOrgAdmin',
                isProjectManager: 'isProjectManager',
                items: 'getTaphonomies',
            }),
        },
    }
</script>

<style scoped>

</style>