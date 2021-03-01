<template>
  <div>
    <v-autocomplete
            clearable
            v-model="createdBy"
            :key="createdBy"
            :items="users"
            item-text="text"
            item-value="value"
            :label="label"
            placeholder="Select Created By"
            :disabled="disabled" />
    <input type="hidden" :name="name" :value="createdBy" />
  </div>
</template>

<script>
  import { changeObjectToArray } from "../../coraBaseModules";

  export default {
    name: 'CreatedBy',

    props: {
      value: [Number, String],
      disabled: Boolean,
      options: {
        type: Object,
        default: () => {}
      },
      name: {
        type: String,
        default: 'inventoried_by_user'
      },
      label: {
        type: String,
        default: 'Created By'
      }
    },

    data() {
      return {
        createdBy: this.value,
      };
    },

    computed: {
      users() {
        return changeObjectToArray(this.options);
      }
    },

    watch: {
      value(val) {
        this.createdBy = val;
      },
      createdBy(val) {
        this.$emit("input", val);
      }
    }
  }
</script>
