<template>
    <div>
        <v-autocomplete :items="changeObject"
                        :id="id"
                        v-model="association"
                        dense
                        chips
                        multiple
                        item-text="text"
                        item-value="value"
                        :disabled="disable"
                        :readonly="disable"
                        :placeholder="placeholdervalues"
        ></v-autocomplete>
    </div>
</template>

<script>
    import {changeObjectToArray} from '../../../coraBaseModules'
    import axios from 'axios';
    import {mapGetters, mapState} from "vuex";

    export default {
        name: 'association',
        props: {
            name: String,
            id: String,
            init_value: [Array, Object],
            specimen_id: '',
            url: String,
            disabled: Boolean,
            type: String,
            base_url: String,
            sb_id: Number,
            list_association: [],
            list_items: [Object, Array],
            disable: {
                type: Boolean,
                default: false
            },
            placeholdervalues: {
                type: String,
                default: 'Association'
            },
            review: {
                type: Boolean,
                default: false
            }
        },
        data: () => ({
            association: [],
            isEditing: false,
            show: true
        }),
        methods: {
            loadAssociation() {
                var data = [];
                axios({
                    url: this.base_url + "/api/review/" + this.specimen_id + "/list-associationdata",
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': this.$store.getters.bearerToken,
                    },
                    params: {
                        "type": this.type
                    }
                }).then((response) => {
                    // data.push(response.data);
                    this.show = false
                }).catch((error) => {
                    console.log(error);
                    this.show = false;
                });
                return data;
            },
            emitAssociation() {
                this.$emit('input', this.association);
            }
        },
        mounted() {
            this.association = this.init_value
        },
        computed: {
            changeObject() {
                return this.list_items !== null ? changeObjectToArray(this.list_items[0]) : null;
            },
            ...mapState({
                perPage: state => state.search.perPage,
                rowsPerPageItems: state => state.search.rowsPerPageItems,
                bones: state => state.bones,
            }),
            ...mapGetters({
                bearerToken: 'bearerToken',
                csrfToken: 'csrfToken',
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
            }),
        },
        watch: {
            association(newVal) {
                this.$emit('association', this.association);
            }
        }
    }
</script>

<style>

</style>