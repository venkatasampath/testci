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

      <template v-slot:item.measured="{ item }">
        <v-icon right :color="getIconColor(item.measured)" small>{{ getBooleanIcon(item.measured) }}</v-icon>
      </template>

      <template v-slot:item.isotope_sampled="{ item }">
        <v-icon
          right
          :color="getIconColor(item.isotope_sampled)"
          small
        >{{ getBooleanIcon(item.isotope_sampled) }}</v-icon>
      </template>

      <template v-slot:item.ct_scanned="{ item }">
        <v-icon
          right
          :color="getIconColor(item.ct_scanned)"
          small
        >{{ getBooleanIcon(item.ct_scanned) }}</v-icon>
      </template>

      <template v-slot:item.xray_scanned="{ item }">
        <v-icon
          right
          :color="getIconColor(item.xray_scanned)"
          small
        >{{ getBooleanIcon(item.xray_scanned) }}</v-icon>
      </template>

      <template v-slot:item.clavicle_triage="{ item }">
        <v-icon
          right
          :color="getIconColor(item.clavicle_triage)"
          small
        >{{ getBooleanIcon(item.clavicle_triage) }}</v-icon>
      </template>
    </v-data-table>
  </div>
</template>

<script>
export default {
  name: "AdvancedSpecimenReportResult",

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
        { text: "Bone", value: "bone", visibility: true, width: "12rem" },
        { text: "Side", value: "side", visibility: true },
        { text: "Bone Group", value: "bone_group", visibility: true },
        {
          text: "Individual Number",
          value: "individual_number",
          visibility: true
        },
        { text: "DNA Sampled", value: "dna_sampled", visibility: true },
        {
          text: "Mito Sequence Number",
          value: "mito_sequence_number",
          visibility: true
        },
        { text: "Measured", value: "measured", visibility: true },
        { text: "Isotope Sampled", value: "isotope_sampled", visibility: true },
        { text: "Clavicle Triage", value: "clavicle_triage", visibility: true },
        { text: "CT Scanned", value: "ct_scanned", visibility: true },
        { text: "XRay Scanned", value: "xray_scanned", visibility: true },
        { text: "Inventoried By", value: "inventoried_by" },
        { text: "Inventoried At", value: "inventoried_at" },
        { text: "Reviewed By", value: "reviewed_by" },
        { text: "Reviewed At", value: "reviewed_at" },
        { text: "Created By", value: "created_by" },
        { text: "Created At", value: "created_at" },
        { text: "Updated By", value: "updated_by" },
        { text: "Updated At", value: "updated_at" }
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
          bone: item.skeletalbone ? item.skeletalbone.name : null,
          side: item.side,
          bone_group: item.bone_group,
          individual_number: item.individual_number,
          dna_sampled: item.dna_sampled ? item.dna_sampled : "",
          dnas: item.dnas,
          mito_sequence_number: item.mito_sequence_number,
          measured: item.measured,
          isotope_sampled: item.isotope_sampled,
          clavicle_triage: item.clavicle_triage,
          ct_scanned: item.ct_scanned,
          xray_scanned: item.xray_scanned,
          inventoried_by: item.user ? item.user.name : null,
          inventoried_at: item.inventoried_at,
          reviewed_by: item.reviewer ? item.reviewer.name : null,
          reviewed_at: item.reviewed_at,
          created_by: item.created_by,
          created_at: item.created_at,
          updated_by: item.updated_by,
          updated_at: item.updated_at
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
