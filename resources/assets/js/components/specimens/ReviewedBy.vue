<template>
  <div>
    <v-autocomplete
            clearable
            v-model="reviewedBy"
            :key="reviewedBy"
            :items="users"
            item-text="text"
            item-value="value"
            :label="label"
            placeholder="Select Reviewed By"
            :disabled="disabled" />
    <input type="hidden" :name="name" :value="reviewedBy" />
  </div>
</template>

<script>
  import { changeObjectToArray } from "../../coraBaseModules";

  export default {
    name: 'reviewedBy',

    props: {
      value: [Number, String],
      disabled: Boolean,
      options: {
        type: Object,
        default: () => {}
      },
      name: {
        type: String,
        default: 'reviewed_by_user'
      },
      label: {
        type: String,
        default: 'Reviewed By'
      }
    },

    data() {
      return {
        reviewedBy: this.value,
      };
    },

    computed: {
      users() {
        return changeObjectToArray(this.options);
      }
    },

    watch: {
      value(val) {
        this.reviewedBy = val;
      },
      reviewedBy(val) {
        this.$emit("input", val);
      }
    }
  }
</script>
