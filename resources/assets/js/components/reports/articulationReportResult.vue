<template>
  <div>
    <v-row>
      <v-col cols="9">
        <v-btn-toggle v-model="toggleMultiple" dense dark multiple>
          <v-btn>Excel</v-btn>
          <v-menu right offset-x :close-on-content-click="false" max-height="500px">
            <template v-slot:activator="{ on }">
              <v-btn v-on="on">
                Column Visibility
                <v-icon right>$dropdown</v-icon>
              </v-btn>
            </template>

            <v-list>
              <v-list-item v-for="(header, index) in columns" :key="index">
                <v-checkbox
                  v-bind:label="header.text"
                  v-model="header.visibility"
                  :value="header.visibility"
                />
              </v-list-item>
            </v-list>
          </v-menu>
        </v-btn-toggle>
      </v-col>

      <v-spacer />

      <v-col cols="3">
        <v-text-field v-model="search" label="Search" single-line hide-details />
      </v-col>
    </v-row>

    <v-data-table
      :headers="columnVisibility"
      :items="data"
      :item-per-page="10"
      multi-sort
      :sort-by="['composite_key']"
      calculate-widths
      class="elevation-1"
      :search="search"
    >
      <template v-slot:item.composite_key="{ item }">
        <a :href="`/skeletalelements/${item.composite_key_id}`" target="_blank">{{ item.composite_key }}</a>
      </template>

      <template v-slot:item.articulated_composite_key="{ item }">
        <a
          :href="`/skeletalelements/${item.id}`"
          target="_blank"
        >{{ item.articulated_composite_key }}</a>
      </template>

      <template v-slot:item.dna_sampled="{ item }">
        <template v-if="item.dna_sampled">
          <a
            class="mx-1"
            v-for="(dna, index) in item.dnas"
            :key="index"
            :href="`/skeletalelements/${item.id}/dnas/${dna.id}`"
            target="_blank"
          >{{ dna.sample_number }}</a>
        </template>
      </template>

      <template v-slot:item.ct_scanned="{ item }">
        <v-icon
          right
          :color="getIconColor(item.ct_scanned)"
          small
        >{{ getBooleanIcon(item.ct_scanned) }}</v-icon>
      </template>
    </v-data-table>
  </div>
</template>

<script>
export default {
  name: "ArticulationReportResult",

  props: {
    skeletalElements: {
      type: Array,
      default: () => []
    },
    skeletalElement: {
      type: Object,
      default: () => {}
    }
  },

  data() {
    return {
      columns: [
        {
          text: "Composite Key",
          value: "composite_key",
          visibility: true,
          width: "12rem"
        },
        { text: "Bone", value: "bone", visibility: true },
        {
          text: "Articulated Composite Key",
          value: "articulated_composite_key",
          visibility: true,
          width: "12rem"
        },
        {
          text: "Articulated Bone",
          value: "articulated_bone",
          visibility: true
        },
        { text: "Bone Group", value: "bone_group", visibility: true },
        { text: "CT Scanned", value: "ct_scanned", visibility: true },
        { text: "DNA Sampled", value: "dna_sampled", visibility: true },
        {
          text: "Mito Sequence Number",
          value: "mito_sequence_number",
          visibility: true
        },
        { text: "Isotope Number", value: "isotope_nmber", visibility: true },
        { text: "Created By", value: "created_by", visibility: false },
        { text: "Created At", value: "created_at", visibility: false },
        { text: "Updated By", value: "updated_by", visibility: false },
        { text: "Updated At", value: "updated_at", visibility: false }
      ],
      search: "",
      toggleMultiple: []
    };
  },

  computed: {
    data() {
      const rows = [];
      this.skeletalElements.forEach(item =>
        rows.push({
          id: item.id,
          composite_key: this.getKey(this.skeletalElement),
          composite_key_id: this.skeletalElement.id,
          bone: this.skeletalElement.skeletalbone
            ? this.skeletalElement.skeletalbone.name
            : "",
          articulated_composite_key: this.getKey(item),
          articulated_bone: item.skeletalbone ? item.skeletalbone.name : "",
          bone_group: item.bone_group,
          ct_scanned: item.ct_scanned,
          dna_sampled: item.dna_sampled,
          dnas: item.dnas,
          mito_sequence_number: item.mito_sequence_number,
          isotope_nmber: item.isotope_nmber,
          created_by: item.created_by,
          created_at: item.created_at,
          updated_by: item.updated_by,
          updated_at: item.updated_at
        })
      );

      return rows;
    },

    columnVisibility() {
      return this.columns.filter(item => item.visibility === true);
    }
  },

  methods: {
    getKey(item) {
      return `${item.accession_number ? item.accession_number : ""}:${
        item.provenance1 ? item.provenance1 : ""
      }:${item.provenance2 ? item.provenance2 : ""}:${
        item.designator ? item.designator : ""
      }`;
    },

    getBooleanIcon(item) {
      return item === true ? "✔" : "";
    },

    getIconColor(item) {
      return item === true ? "success" : "";
    }
  }
};
</script>
