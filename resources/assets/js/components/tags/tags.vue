<template>
    <div class="m-2">
        <v-card flat>
            <v-row align="center" justify="center">
                <v-col cols="12" :md="cols" class="py-0">
                    <v-toolbar v-if="show_toolbar">
                        <v-badge color="primary" :content="tags_count">Tags</v-badge>
                        <v-spacer></v-spacer>
<!--                        <v-tooltip v-if="show_toolbar_crud && !isEditing" v-model="showEdit" top>-->
<!--                            <template v-slot:activator="{ on }">-->
<!--                                <v-btn icon v-on="on" @click="edit" color="primary" :loading="loading"><v-icon>mdi-pencil</v-icon></v-btn>-->
<!--                            </template>-->
<!--                            <span>Edit</span>-->
<!--                        </v-tooltip>-->
<!--                        <v-tooltip v-if="show_toolbar_crud && isEditing" v-model="showReset" top>-->
<!--                            <template v-slot:activator="{ on }">-->
<!--                                <v-btn icon v-on="on" @click="reset" color="primary" :loading="loading"><v-icon>mdi-undo-variant</v-icon></v-btn>-->
<!--                            </template>-->
<!--                            <span>Reset</span>-->
<!--                        </v-tooltip>-->
<!--                        <v-tooltip v-if="show_toolbar_crud && isEditing" v-model="showSave" top>-->
<!--                            <template v-slot:activator="{ on }">-->
<!--                                <v-btn icon v-on="on" @click="save" color="primary" :loading="loading"><v-icon>mdi-content-save</v-icon></v-btn>-->
<!--                            </template>-->
<!--                            <span>Save</span>-->
<!--                        </v-tooltip>-->
                        <v-btn icon @click="showCollapse = !showCollapse" color="primary" :loading="loading" dusk="tag_button">
                            <v-icon title="Collapse" v-if="showCollapse">mdi-arrow-collapse-up</v-icon>
                            <v-icon title="Expand" v-if="!showCollapse">mdi-arrow-expand-down</v-icon>
                        </v-btn>
                    </v-toolbar>

                    <v-card outlined v-show="showCollapse">
                        <v-autocomplete id="tags" v-model="tags" label="Tags" filled chips deletable-chips multiple prepend-icon="mdi-tag-multiple"
                                        :hint="hint" persistent-hint :disabled="!action.edit || disabled" :readonly="!isEditing"
                                        :items="items" item-text="name" item-value="id" :placeholder="placeholder" dusk="tag-select">
                            <template v-slot:append-outer>
                                <v-icon :title="isEditing?'Save':'Edit'" :key="`icon-${isEditing}`" color="primary" :disabled="!action.edit || disabled"
                                        @click="save(tags)" v-text="isEditing?'mdi-content-save':'mdi-circle-edit-outline'" dusk="tag-edit-save">
                                </v-icon>
                                <v-icon title="Reset/Undo" v-if="isEditing" class="pl-2" color="primary" :disabled="!action.edit || disabled"
                                        @click="reset(tags)" dusk="tag-reset">mdi-undo-variant</v-icon>
                                <v-btn title="New" icon color="primary" @click="createTag" dusk="new-tag" :disabled="!action.edit || disabled"><v-icon>mdi-plus-circle</v-icon></v-btn>
                            </template>


                            <template v-slot:selection="data">
                                <v-chip v-bind="data.attrs" :input-value="data.selected" :color="data.item.color" close @click="data.select" @click:close="remove(data.item)">
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
                    </v-card>
                </v-col>
            </v-row>
        </v-card>
        <tag-crud :type="this.type"></tag-crud>
    </div>
</template>

<script>
    import {mapState, mapGetters, mapActions} from 'vuex';
    import {eventBus} from "../../eventBus";
    import axios from "axios";

    export default {
        name: "tags",
        props: {
            placeholder: { type: String, default: "Select Tags", },
            crud_action: { type: String, default: "View" },
            type: { type: String, default: "Specimen", }, // allowed values are (Specimen, DNA, Isotope, Media)
            url_for_type: { type: String, default: "specimens", }, // allowed values are (specimens, dnas, isotopes, medias)
            tag_model: { type: Object, required: true },
            toolbar:{type:Boolean, default: true},
            cols: {type:Number, default: 12},
        },
        data() {
            return {
                loading: false,
                tags: null,
                cached_tags: null,
                dialog: false,
                disabled: false,
                isEditing: false,
                showCollapse:true,
                show_toolbar: this.toolbar,
                items: [],
                hint: "You can apply multiple tags to this " + this.type,
            }
        },
        created() {
            this.fetchTags();
            this.fetchModelTags();
            eventBus.$on('updateTagList', this.fetchTags)
        },
        methods: {
            fetchTags(){
                axios
                    .request({ url: '/api/tags?type=' + this.type, method: 'GET',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    })
                    .then(response=>{
                        this.items=response.data.data;
                    })
            },
            fetchModelTags(){
                this.loading=true;
                let url = '/api/'+ this.url_for_type +'/'+this.tag_model.id+'/associations?type=tags';
                axios
                    .request({ url: url, method: 'GET',
                        headers:{ 'Content-Type' : 'application/json',
                            'Authorization': this.$store.getters.bearerToken, }
                    })
                    .then(response=>{
                        let filtered_tags = response.data.data.filter( el => { return el.type === this.type});
                        this.tags = filtered_tags.map(tag=>tag.id);
                        this.cached_tags = Object.assign([], this.tags);
                        this.loading=false;
                    })
                    .catch(error => {
                        this.loading=false;
                    });
            },
            createTag(){
                console.log('Tags eventNewGo - captured event: ');
                let payload = { 'title': 'Create New Tag', 'action': 'Create', };
                eventBus.$emit('show-crud-dialog', payload);
            },
            reset() {
                this.tags = this.cached_tags;
                this.isEditing = !this.isEditing;
            },
            save() {
                if (this.isEditing) {
                    this.loading = true;
                    axios
                        .request({ url: '/api/specimens/'+this.tag_model.id+'/associations', method: 'PUT',
                            headers:{ 'Content-Type' : 'application/json', 'Authorization': this.$store.getters.bearerToken, },
                            data: { type: "tags", listIds: this.tags.map(tag => tag.toString()), },
                        })
                        .then(response=>{
                            this.tags = response.data.data.map(tag=>tag.id);
                            let payload = {'text': 'Tags successfully saved', 'color': 'success',};
                            eventBus.$emit('show-snackbar', payload);
                            this.loading = false;
                            // this.cachedTaphonomy = Object.assign([], this.taphonomy);
                        })
                        .catch(error => {
                            let payload = {'text': 'Tags Update failed', 'color': 'error',};
                            eventBus.$emit('show-snackbar', payload);
                            this.loading = false;
                        });
                }
                this.isEditing = !this.isEditing;
            },
            remove (item) {
                const index = this.items.indexOf(item.name)
                if (index >= 0) this.tags.splice(index, 1)
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
            tags_count()  {
                return (this.tags) ? this.tags.length.toString() : "0";
            }
        },
    }
</script>

<style scoped>
</style>