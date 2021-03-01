<template>
  <div id="specimen-table">
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
              <v-list-item v-for="(header, index) in headers" :key="index">
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
    </v-data-table>
  </div>
</template>

<script>
export default {
  name: "SpecimenIndividualReportResult",

  props: {
    skeletalElements: {
      type: [Array, Object],
      default: () => []
    }
  },

  data() {
    return {
      headers: [
        { text: "Key", value: "key", visibility: true, width: "12rem" },
        {
          text: "Individual Number",
          value: "individual_number",
          visibility: true
        },
        { text: "Bone", value: "bone", visibility: true, width: "12rem" },
        { text: "Side", value: "side", visibility: true },
        { text: "DNA Sample Number", value: "dna_sampled", visibility: true },
        {
          text: "DNA Sequence Number",
          value: "dna_sequence_number",
          visibility: true
        },
        { text: "Traumas", value: "traumas", visibility: true },
        { text: "Pathologies", value: "pathologies", visibility: true },
        { text: "Anomalies", value: "anomalies", visibility: true }
      ],
      search: "",
      toggleMultiple: []
    };
  },

  computed: {
    data() {
      const rows = [];
      Object.values(this.skeletalElements).forEach(item =>
        rows.push({
          id: item.id,
          key: this.getKey(item),
          individual_number: item.individual_number,
          bone: item.skeletalbone ? item.skeletalbone.name : null,
          side: item.side,
          dna_sampled: item.dna_sampled ? item.dna_sampled : "",
          dnas: item.dnas,
          dna_sequence_number: item.mito_sequence_number,
          traumas: item.uniquetraumaslist ? item.uniquetraumaslist : null,
          pathologies: item.uniquepathologyslist ? item.uniquepathologyslist : null,
          anomalies: item.uniqueanomalyslist ? item.uniqueanomalyslist : null
        })
      );

      return rows;
    },
    columnVisibility() {
      return this.headers.filter(item => item.visibility === true);
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
