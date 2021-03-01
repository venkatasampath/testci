<!--Grouped component Bone, Side-->
<template>
       <v-row>
           <v-col cols="6" md="3">
                <bone :name="boneModelKey" v-model="values[boneModelKey]" label="Bone" :options="bone" :required="required" class_value></bone>
           </v-col>
           <v-col cols="6" md="3">
                <side :name="sideModelKey" v-model="values[sideModelKey]" :options="side" :required="false" class_value></side>
           </v-col>
       </v-row>
</template>

<script>
    export default {
        name: "boneside",
        props: {
            required: { type: Boolean, default: true },
            value: { type: Object, default: () => {} },
            modelKeys: { type: Object, default: () => {} },
            bone: { type: Object, default: () => {} },
            side: { type: Object, default: () => {} },
        },
        data() {
            return {
                values: this.value
            };
        },
        computed: {
            boneModelKey() {
                return this.modelKeys.bone ? this.modelKeys.bone : "sb_id";
            },
            sideModelKey() {
                return this.modelKeys.side ? this.modelKeys.side : "side";
            }
        },
        watch: {
            value(val) {
                this.values = val;
            }
        }
    };
</script>
