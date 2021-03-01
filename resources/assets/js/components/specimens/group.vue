<template>
    <v-autocomplete id="type" v-model="group" :key="group" :items="groupData" item-text="text"
                    item-value="value" :label="label" placeholder="Select Group" dusk="se-group">
    </v-autocomplete>
</template>

<script>
  import { changeObjectToArray } from "../../coraBaseModules";

  export default {
    name: "group",
    props: {
      value: [Number, String],
      options: Object,
      disabled: Boolean,
      name: {
        type: String,
        default: "group_side_select"
      },
      label: {
        type: String,
        default: "Group"
      },
      sm_value: Number,
      md_value: Number,
      class_value: {
        type: String,
        default: "ma-3"
      }
    },
    data() {
      return {
        group: null,
        md: this.md_value ? this.md_value : 2,
        sm: this.sm_value ? this.sm_value : 12,
        col_class: this.class_value
      };
    },
    watch: {
      value(val) {
        this.group = val;
      },
      group(val) {
        this.$emit("input", val);
      }
    },
    computed: {
      groupData() {
        return changeObjectToArray(this.options);
      }
    }
  };
</script>

<style scoped>
</style>
