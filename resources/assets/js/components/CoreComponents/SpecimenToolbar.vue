<template>
  <v-toolbar dense dark fixed :width="width">
    <h2 class="h6 mb-0">{{ title }}</h2>

    <v-badge v-if="badgeContent" color="primary" :content="badgeContent" />

    <v-spacer></v-spacer>

    <slot></slot>

    <v-btn-toggle group dense>
      <v-tooltip top>
        <template v-slot:activator="{ on }">
          <v-btn icon v-if="panel" @click="onExpand" v-on="on">
            <v-icon>{{ isPanelExpanded ? 'mdi-arrow-collapse-up' : 'mdi-arrow-expand-down' }}</v-icon>
          </v-btn>
        </template>
        <span>{{ isPanelExpanded ? 'Collapse' : 'Expand' }}</span>
      </v-tooltip>

      <v-tooltip top>
        <template v-slot:activator="{ on }">
          <v-btn
                  v-if="actionBtn"
                  :disabled="actionBtn.disabled"
                  :loading="actionBtn.loading"
                  :color="actionBtn.color"
                  @click="onAction"
                  icon
                  v-on="on"
          >
            <v-icon v-if="actionBtn.icon">{{ actionBtn.icon }}</v-icon>
            <template v-if="actionBtn.label">{{ actionBtn.label }}</template>
          </v-btn>
        </template>
        <span>Generate</span>
      </v-tooltip>

      <v-tooltip top>
        <template v-slot:activator="{ on }">
          <v-btn icon v-if="save" @click="onSave" v-on="on" :disabled="save.disabled">
            <v-icon>mdi-content-save</v-icon>
          </v-btn>
        </template>
        <span>Save</span>
      </v-tooltip>

      <v-tooltip top>
        <template v-slot:activator="{ on }">
          <v-btn icon v-if="edit" @click="onEdit" v-on="on">
            <v-icon>mdi-lead-pencil</v-icon>
          </v-btn>
        </template>
        <span>Edit</span>
      </v-tooltip>

      <v-tooltip top>
        <template v-slot:activator="{ on }">
          <v-btn icon v-if="reset" @click="onReset" v-on="on">
            <v-icon>mdi-undo</v-icon>
          </v-btn>
        </template>
        <span>Reset</span>
      </v-tooltip>
    </v-btn-toggle>
  </v-toolbar>
</template>

<script>
  export default {
    name: "SpecimenToolbar",

    props:{
      title: String,
      badgeContent: Number,
      width: [Number, String],
      panel: Boolean,
      expanded: Boolean,
      save: {
        type: Object,
        default: () => {}
      },
      edit: Boolean,
      reset: Boolean,
      actionBtn: {
        type: Object,
        default: () => {}
      }
    },
      data() {
          return {
              isPanelExpanded: this.expanded
          }
      },

    methods:{
      onAction() {
        this.$emit('action');
      },
      onExpand() {
        this.isPanelExpanded = !this.isPanelExpanded;
        this.$emit('expand', this.isPanelExpanded);
      },
      onSave() {
        this.$emit('save');
      },
      onEdit() {
        this.$emit('edit');
      },
      onReset() {
        this.$emit('reset');
      }
    }
  }
</script>
