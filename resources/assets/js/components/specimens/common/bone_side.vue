<!--Grouped component Bone, Side-->
<template>
   <v-row>
       <v-col cols="6">
           <v-autocomplete v-model="sb_id" label="Bone" :rules="rules.sb_id" :required="required" :disabled="disabled" dusk="se-bone" clearable
                           :items="items" item-text="name" item-value="id" @change="changeBone" placeholder="Select Bone">
           </v-autocomplete>
       </v-col>
       <v-col cols="6">
           <v-autocomplete  v-model="side" label="Side" placeholder="Select Side" dusk="se-side"
                            :items="items_side" :disabled="disabled  || disable_side" :required="required" clearable>
           </v-autocomplete>
       </v-col>
   </v-row>
</template>

<script>
import {mapGetters, mapState} from "vuex";

export default {
    name: "bone_side",
    props: {
        disabled: { type: Boolean, default: false },
        required: { type: Boolean, default: true },
        bone_value: { type: Number, default: 0 },
        side_value: { type: String, default: "Left" },
    },
    data() {
        return {
            disable_side: false,
            sb_id: this.bone_value,
            side: this.side_value,
            items_side: null,
            items_side_all: ["Left", "Right", "Middle", "Unsided"],
            items_side_minus_middle: ["Left", "Right", "Unsided"],
            rules: {
                sb_id: [ v => !!v || 'Bone is required' ],
            },
        };
    },
    created() {
         this.items_side = this.items_side_all;
    },
    watch: {
        sb_value(val) {
            this.side = val;
        },
        sb_id(val) {
            this.$emit("input-sb", val);
        },
        side_value(val) {
            this.sb_id = val;
        },
        side(val) {
            this.$emit("input-side", val);
        },
    },
    methods: {
        changeBone() {
            console.log("changeBone fired: sb_id: " + this.sb_id);
            let bone = this.items.find(el => { return el.id === this.sb_id});
            console.log("changeBone fired: bone " + JSON.stringify(bone));
            if (bone) {
                console.log("changeBone fired: bone " + JSON.stringify(bone));
                this.items_side = (bone.middle)?this.items_side_all:this.items_side_minus_middle;
                this.side = (bone.middle)?"Middle":"Left";
                this.disable_side = !!(bone.middle);
            } else {
                this.items_side = this.items_side_all;
                this.side = "Left";
                this.disable_side = false;
            }
        },
    },
    computed: {
        ...mapState({
            //
        }),
        ...mapGetters({
            items: 'getBones',
        }),
        // rules() {
        //     return (this.required) ? [() => !!this.side || "Side is required"] : [];
        // }
    },
};
</script>
