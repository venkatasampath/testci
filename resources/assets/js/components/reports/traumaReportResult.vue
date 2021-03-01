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
              <v-list-item v-for="(column, index) in columns" :key="index">
                <v-checkbox
                  :label="column.text"
                  v-model="column.visibility"
                  :value="column.visibility"
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
      :headers="visibleColumns"
      :items="data"
      :item-per-page="10"
      multi-sort
      :sort-by="['key']"
      calculate-widths
      class="elevation-1"
      :search="search"
    >
      <template v-slot:item.key="{ item }">
        <a :href="`/skeletalelements/${item.id}`" target="_blank">{{ item.key }}</a>
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
  name: "TraumaReportResult",

  props: {
    skeletalElements: {
      type: Array,
      default: () => []
    },
    traumas: {
      type: Array,
      default: () => []
    },
    traumasByZonesList: {
      type: [Array, Object],
      default: () => {}
    }
  },

  data() {
    return {
      columns: [],
      search: "",
      toggleMultiple: []
    };
  },

  computed: {
    data() {
      const rows = [];

      this.skeletalElements.forEach(item => {
        let traumaColumns = {};
        this.traumas.forEach(
          trauma =>
            (traumaColumns[trauma.name] = this.traumasByZonesList[item.id][
              trauma.name
            ])
        );

        rows.push({
          id: item.id,
          key: this.getKey(item),
          bone: item.skeletalbone ? item.skeletalbone.name : "",
          side: item.side,
          bone_group: item.bone_group,
          ct_scanned: item.ct_scanned,
          dna_sampled: item.dna_sampled,
          dnas: item.dnas,
          mito_sequence_number: item.mito_sequence_number,
          isotope_nmber: item.isotope_nmber,
          ...traumaColumns
        });
      });

      return rows;
    },

    visibleColumns() {
      return this.columns.filter(item => item.visibility === true);
    }
  },

  methods: {
    getColumns() {
      const columns = [
        { text: "Key", value: "key", visibility: true, width: "12rem" },
        { text: "Bone", value: "bone", visibility: true },
        { text: "Side", value: "side", visibility: true },
        { text: "Bone Group", value: "bone_group", visibility: true },
        { text: "CT Scanned", value: "ct_scanned", visibility: true },
        { text: "DNA Sampled", value: "dna_sampled", visibility: true },
        {
          text: "Mito Sequence Number",
          value: "mito_sequence_number",
          visibility: true
        },
        { text: "Isotope Number", value: "isotope_nmber", visibility: true }
      ];

      this.traumas.forEach(trauma => {
        columns.push({
          text: trauma.name,
          value: trauma.name,
          visibility: true
        });
      });

      return columns;
    },

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
  },

  mounted() {
    this.columns = this.getColumns();
  }
};
</script>
