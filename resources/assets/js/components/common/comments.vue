<template>
    <div class="m-2">
        <v-card flat>
            <v-row align="center" justify="center">
                <v-col cols="12" :md="cols" class="py-0">
                    <v-toolbar v-if="show_toolbar">
                        <v-badge color="primary" :content="comments_count">Comments</v-badge>
                        <v-spacer></v-spacer>
                        <v-btn :title="showCollapse?'Collapse':'Expand'" icon @click="showCollapse = !showCollapse" color="primary" :loading="loading" dusk="comment-tag">
                            <v-icon v-text="showCollapse?'mdi-arrow-collapse-up':'mdi-arrow-collapse-down'"></v-icon>
                        </v-btn>
                    </v-toolbar>
                    <v-card outlined v-show="showCollapse">
                        <v-timeline v-model="comments" align-top dense>
                            <v-timeline-item :right="right" :left="left" class="white--text mb-4" large>
                                <template v-slot:icon><v-avatar><img :src="theUser.avatar" alt=""></v-avatar></template>
<!--                                <v-text-field v-model="new_comment" hide-details flat solo label="Leave a comment..." @keydown.enter="save" prepend-icon="mdi-comment-text-outline">-->
                                <v-textarea v-model="new_comment" rows="2" counter="500" label="Leave a comment..." prepend-icon="mdi-comment-text-outline"  dusk="comment-text">
                                    <template v-slot:append-outer><v-icon class="mr-4" :disabled="!new_comment" @click="save" color="primary" dusk="comment-save">mdi-content-save</v-icon></template>
                                </v-textarea>
                            </v-timeline-item>
                            <v-timeline-item class="white--text" hide-dot :right="right" :left="left"><span>History</span></v-timeline-item>
                            <v-timeline-item class="grey--text" v-for="item in comments" v-bind:key="item.id" :ref="item.id" color="primary" :right="right" :left="left" large>
                                <template v-slot:icon><v-avatar><img :src="getUserAvatar(item)" alt=""></v-avatar></template>
                                <v-row align="start"><v-col cols="4" v-text="getUserDisplayName(item)"/><v-col cols="6" v-text="getComentDateTime(item)"/></v-row>
                                <v-row align="start"><v-col cols="12" v-text="item.text"/></v-row>
                            </v-timeline-item>
                        </v-timeline>
                    </v-card>
                </v-col>
            </v-row>
        </v-card>
    </div>
</template>

<script>
    import {mapState, mapGetters, mapActions} from 'vuex';
    import {eventBus} from "../../eventBus";
    import moment from 'moment';
    import axios from "axios";

    export default {
        name: "comments",
        props: {
            crud_action: { type: String, default: "View" },
            type: { type: String, default: "Specimen", }, // allowed values are (Specimen, DNA, Isotope, Media)
            url_for_type: { type: String, default: "specimens", }, // allowed values are (specimens, dnas, isotopes, medias)
            comment_model: { type: Object, required: true },
            toolbar:{type:Boolean, default: true},
            cols: {type:Number, default: 12},
        },
        data() {
            return {
                loading: false,
                comments: null,
                new_comment: null,
                showCollapse:true,
                show_toolbar: this.toolbar,
                right: true,
                left: false,
                rules: [ v => (v && v.length >= 10) || 'Comment must be at least 10 characters', v => v.length <= 128 || 'Max 128 characters'],
            }
        },
        created() {
            this.fetchModelComments();
        },
        methods: {
            fetchModelComments(){
                this.loading=true;
                let url = '/api/'+ this.url_for_type +'/'+this.comment_model.id+'/associations?type=comments';
                axios
                    .request({ url: url, method: 'GET',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization': this.$store.getters.bearerToken, }
                    })
                    .then(response=>{
                        this.comments = response.data.data;
                        this.loading=false;
                    })
                    .catch(error => {
                        this.loading=false;
                    });
            },
            save: function() {
                this.loading = true;
                let comment = this.new_comment;
                let data = { text: comment, commentable_id: this.comment_model.id, commentable_type: "App\\SkeletalElement", user_id: this.theUser.id, }
                axios
                    .request({ url: '/api/comments', method: 'POST', data: data,
                        headers:{ 'Content-Type' : 'application/json', 'Authorization': this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        this.comments.unshift(response.data.data);
                        let payload = {'text': 'Comments successfully saved', 'color': 'success',};
                        eventBus.$emit('show-snackbar', payload);
                        this.loading = false;
                        this.new_comment = null;
                        // this.fetchModelComments(); // fetch comments.
                    })
                    .catch(error => {
                        let payload = {'text': 'Comments Update failed', 'color': 'error',};
                        eventBus.$emit('show-snackbar', payload);
                        this.loading = false;
                    });
            },
            getUserAvatar(item) {
                let user = this.$store.getters.getOrgUserById(item.user_id);
                return user.avatar;
            },
            getUserDisplayName(item) {
                let user = this.$store.getters.getOrgUserById(item.user_id);
                return user.display_name;
            },
            getComentDateTime(item) {
                return moment(item.created_at).format("ddd, MMM Do YYYY, h:mm a");
            },
        },
        computed: {
            ...mapState({
                //
            }),
            ...mapGetters({
                bearerToken: 'bearerToken',
                csrfToken: 'csrfToken',
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
            }),
            action() {
                const act = this.crud_action;
                return { create: act === "Create", view: act === "View", edit: (act === "Update" || act === "Edit"), list: act === "List", };
            },
            comments_count()  {
                return (this.comments) ? this.comments.length.toString() : "0";
            }
        },
    }
</script>

<style scoped>
</style>