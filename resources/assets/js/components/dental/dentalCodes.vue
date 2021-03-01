<template>
    <div class="m-2">
        <v-card flat>
            <v-row align="center" justify="center">
                <v-col cols="12" :md="cols" class="py-0">
                    <v-toolbar v-if="show_toolbar">
                        <v-badge color="primary" :content="codesCount">Dental Codes</v-badge>
                        <v-spacer></v-spacer>
                        <v-btn icon @click="showCollapse = !showCollapse" color="primary" :loading="loading">
                            <v-icon title="Collapse" v-if="showCollapse">mdi-arrow-collapse-up</v-icon>
                            <v-icon title="Expand" v-if="!showCollapse">mdi-arrow-expand-down</v-icon>
                        </v-btn>
                    </v-toolbar>
                        <v-card outlined v-show="(show_toolbar || show_contentheader) && showCollapse">
                            <v-autocomplete id="codes_id" v-model="codesAssigned" label="Dental Codes" filled chips deletable-chips multiple
                                            :disabled="!action.edit || disabled" :readonly="!isEditing"
                                            :items="assignableCodes" item-text="name" item-value="id" >
                                <template v-slot:prepend>
                                    <v-icon>mdi-tooth</v-icon>
                                </template>
                                <template v-slot:append-outer>
                                    <v-icon :title="isEditing?'Save':'Edit'" :key="`icon-${isEditing}`" color="primary" :disabled="!action.edit || disabled"
                                            @click="save(codesAssigned)" v-text="isEditing?'mdi-content-save':'mdi-circle-edit-outline'">
                                    </v-icon>
                                    <v-icon title="Reset/Undo" v-if="isEditing" class="pl-2" color="primary" :disabled="!action.edit || disabled"
                                            @click="reset(codesAssigned)">mdi-undo-variant
                                    </v-icon>
                                </template>

                                <template v-slot:selection="data">
                                    <v-chip v-bind="data.attrs" :input-value="data.selected" :color="data.item.color" close @click="data.select" @click:close="remove(data.item)">
                                        <v-icon v-if="data.item.icon" left>{{data.item.icon}}</v-icon>{{ data.item.description}}
                                    </v-chip>
                                </template>

                                <template v-slot:item="data">
                                    <template v-if="typeof data.item !== 'object'"><v-list-item-content v-text="data.item"></v-list-item-content></template>
                                    <template v-else>
                                        <v-list-item-avatar class="headline" left :color="data.item.color"><v-icon>{{ data.item.icon }}</v-icon></v-list-item-avatar>
                                        <v-list-item-content :background-color="data.item.color">
                                            <v-list-item-title v-html="data.item.description"></v-list-item-title>
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
    import {mapState, mapGetters} from 'vuex';
    import axios from "axios";

    export default {
        name: "dentalCodes",
        props: {
            specimenID: {type: Number, required: true},
            cols: {type:Number, default: 12},
            toolbar: {type:Boolean, default: true},
            crud_action: {type: String, default: "View"},
            contentheader: {type:Boolean, default: true},
        },
        data() {
            return {
                show_toolbar: this.toolbar,
                assignableCodes: null,
                codesAssigned: null,
                showCollapse: true,
                disabled: false,
                isEditing: false,
                loading: false,
                type: 'dentalcodes',
                show_contentheader: this.contentheader,
            }
        },
        created() {
           //
        },
        mounted() {
            this.getAllCodes();
            this.getCodesAssigned();
        },
        methods:{
            getAllCodes(){
                axios
                    .request({
                        url: '/api/dental/',
                        method: 'GET',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    }).then(response=>{
                        this.assignableCodes = response.data.data;
                    }).catch(error => {
                        //
                    })
            },
            getCodesAssigned(){
                this.loading = true;
                axios
                    .request({
                        url: '/api/specimens/' + this.specimenID + '/associations?type=' + this.type,
                        method: 'GET',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken, },
                    }).then(response=>{
                        this.codesAssigned = response.data.data;
                        this.loading = false;
                    }).catch(error => {
                        this.loading = false;
                })
            },
            reset() {
                this.isEditing = !this.isEditing;
            },
            edit() {
                this.isEditing = !this.isEditing;
            },
            save() {
                if (this.isEditing) {
                    this.loading = true;
                    let passingIds = {};
                    passingIds = this.codesAssigned.map(item => {
                        return {"dc_id": item, "dc_type": this.assignableCodes[item].type}
                    });
                    axios
                        .request({
                            url: '/api/specimens/' + this.specimenID + '/associations',
                            method: 'PUT',
                            headers:{ 'Content-Type' : 'application/json', 'Authorization' : this.$store.getters.bearerToken },
                            data: { type: this.type, se_id: this.specimenID, listIds: passingIds }
                        }).then(response=>{
                            this.loading = false;
                        }).catch(error => {
                            this.loading = false;
                        });
                }
                this.isEditing = !this.isEditing;
            },
            remove(item) {
                const index = this.codesAssigned.indexOf(item.id);
                if (index >= 0) this.codesAssigned.splice(index, 1)
            },
        },
        computed: {
            ...mapState({
                //
            }),
            ...mapGetters({
                //
            }),
            action() {
                const act = this.crud_action;
                return { create: act === "Create", view: act === "View", edit: (act === "Update" || act === "Edit"), list: act === "List", };
            },
            codesCount()  {
                return (this.codesAssigned) ? this.codesAssigned.length.toString() : "0";
            }
        },
    }
</script>

<style scoped>

</style>