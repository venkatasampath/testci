<template>
    <div id="associationForm">
        <v-app>
            <v-card>
                <v-container>
                    <v-row>

                        <v-col md="6">
                            <articulation
                                    :options="options"
                                    :specimen_id="specimen_id"
                                    :base_url="base_url"
                                    :specimen="specimen"
                                    :specimen2= "specimen_articulation">
                            </articulation>
                        </v-col>

                        <v-col md="6">
                            <refits :options="options"
                                    :specimen_id="specimen_id"
                                    :base_url="base_url"
                                    :specimen="specimen"
                                    :specimen2= "specimen_refits">
                            </refits>
                        </v-col>

                        <v-col md="6">
                            <pairmatch :options="options"
                                       :specimen_id="specimen_id"
                                       :base_url="base_url"
                                       :specimen="specimen"
                                       :specimen_pairmatch= "specimen_pairmatch">
                            </pairmatch>
                        </v-col>

                        <v-col md="6">
                            <morphology :options="options"
                                        :specimen_id="specimen_id"
                                        :base_url="base_url"
                                        :specimen="specimen"
                                        :specimen2= "specimen_morphology">
                            </morphology>
                        </v-col>

                    </v-row>
                </v-container>
            </v-card>
        </v-app>
    </div>
</template>

<script>
    import Articulation from './Association/Articulation'
    import Refits from './Association/Refits'
    import Morphology from './Association/Morphology'
    import PairMatch from './PairMatch'


    export default {
        name: "Associations",
        props:{
            options: Object,
            specimen_id: Number,
            base_url: String,
            specimen: Array,
            specimen_articulation: Array,
            specimen_refits: Array,
            specimen_pairmatch: Array,
            specimen_morphology: Array,
        },
        data: () => ({
        }),
        components:{
            Articulation,
            Refits,
            PairMatch,
            Morphology,
        },
    }
</script>

<style scoped>
</style>