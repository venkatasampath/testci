<template>
    <v-row cols="12" md="12" class="md-3">
        <v-col md="6" sm="12" class="ma-3">
            <v-card  tile flat>
                <v-autocomplete v-model="componentvmodel" :label="anomalieslabel" dusk="'se-anomaly-list'"
                                :items="changeObjToArray" item-text="text" item-value="value" multiple chips deletable-chips
                                :readonly="!isEditing" :append-icon="isEditing ? '$dropdown': ''">
                    <template v-slot:append-outer>
                        <v-btn :loading="isLoading" color="primary" @click="isEditing = !isEditing" v-if="!isEditing">Edit</v-btn>
                        <v-btn :loading="isLoading" color="success" @click="postAnomlyData() (isEditing=!isEditing)" v-else-if="isEditing">Save</v-btn>
                        <v-btn text v-if="isEditing" >Cancel</v-btn>
                    </template>
                </v-autocomplete>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    import {bus, apiGetCallAxios, changeObjectToArray} from "../../../coraBaseModules";
    import axios from "axios";
    import {mapGetters, mapState} from "vuex";
    import {eventBus} from "../../../eventBus";

    export default {
        name: "Anomalies",
        props: {
            options: [Array, Object],
            anomalieslabel: String,
            specimen_id: String,
            base_url: String,
        },
        data() {
            return {
                Anomalies: null,
                isEditing: false,
                listAnomalies: [],
                componentvmodel: '',
                isLoading: false,
            };
        },
        mounted() {
            this.getAnomlyData()
        },
        computed:{
            changeObjToArray: function () {
                return changeObjectToArray(this.options)
            },
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
        },
        methods:{
            getAnomlyData: function () {
                this.isLoading = true;
                    apiGetCallAxios("/api/specimens/" + this.specimen_id + "/associations?type=anomalies").then(response => {
                    this.listAnomalies= response.data.data.map(item => ({
                        value: item.id,
                        text: item.individuating_trait,
                    }));
                    for(let i = 0; i < this.listAnomalies.length; i++) {
                        if(this.listAnomalies[i].value != null){
                            this.componentvmodel = this.listAnomalies[i].value.toString()
                        }
                    }
                    this.isLoading = false
                });
            },

            postAnomlyData: function () {
                var succeed = null;
                var errored = null;
                axios
                    .request({
                        url: "/api/specimens/" + this.specimen_id + "/associations",
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': this.$store.getters.bearerToken,
                        },
                        data: {
                            "type": "anomalies",
                            "listIds": this.componentvmodel,
                        }
                    }).then(response => {
                    succeed = true;
                        let payload = { 'text': 'Update successful', 'color': 'success', };
                        eventBus.$emit('show-snackbar', payload);
                    }).catch(error => {
                        errored = true
                        let payload = { 'text': 'Update failed', 'color': 'error', };
                        eventBus.$emit('show-snackbar', payload);
                    })
            },
            remove (item) {
                const index = this.componentvmodel.indexOf(item.value);
                if (index >= 0) this.componentvmodel.splice(index, 1)
            },
        }
    }
</script>

<style>
    div.v-application--wrap{
        min-height: 0;
    }
</style>