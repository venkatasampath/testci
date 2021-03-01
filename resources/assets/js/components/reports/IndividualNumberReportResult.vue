<template>
  <div id="specimen-table">
    <contentheader :trail="this.trail" ></contentheader>
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

      <template v-slot:item.sequence_numbers="{ item }">
        <span class="mx-1">{{ sequenceNumber }}</span>
      </template>

      <template v-slot:item.individual_number="{ item }">
        <a :href="encodedSpecimenURI(item)" target="_blank">{{ item.individual_number }}</a>
      </template>

      <template v-slot:item.specimens="{ item }">
        <a
          v-for="(specimen, index) in item.specimens"
          :key="index"
          :href="`/skeletalelements/${specimen.id}`"
          target="_blank"
        >
          {{ specimen.key_bone_side }}
          <br />
        </a>
      </template>
    </v-data-table>
  </div>
</template>

<script>
export default {
  name: "IndividualNumberReportResult",

  props: {
    individualNumbers: {
      type: [Array, Object],
      default: () => []
    },
    skeletalElementsCount: {
      type: [Array, Object],
      default: () => []
    },
    skeletalElementsByIndividualNumber: {
      type: [Array, Object],
      default: () => []
    },
    mitoSequenceCountsByIndividualNumber: {
      type: [Array, Object],
      default: () => []
    },
    mitoSequenceNumbersByIndividualNumber: {
      type: [Array, Object],
      default: () => []
    }
  },

  data() {
    return {
      headers: [
        {
          text: "Individual Number",
          value: "individual_number",
          visibility: true
        },
        { text: "Specimen Count", value: "specimen_count", visibility: true },
        { text: "Specimens", value: "specimens", visibility: true },
        {
          text: "Mito Sequence Count",
          value: "mito_sequence_count",
          visibility: true
        },
        {
          text: "Sequence Numbers",
          value: "sequence_numbers",
          visibility: true
        }
      ],
      search: "",
      toggleMultiple: [],
      trail: [{ text: 'Home', disabled: false, href: '/', },
        {text: 'Reports Dashboard', diasbled: false, href: '/reports/dashboard'},
        { text: 'Individual Number Report', disabled: true, href: '/individualnumberdetails', },
      ],
    };
  },

  computed: {
    data() {
      const rows = [];
      Object.values(this.individualNumbers).forEach(individualNumber =>
        rows.push({
          individual_number: individualNumber,
          specimen_count: this.skeletalElementsCount[individualNumber],
          specimens: this.skeletalElementsByIndividualNumber[individualNumber],
          mito_sequence_count: this.mitoSequenceCountsByIndividualNumber[
            individualNumber
          ],
          sequence_numbers: this.mitoSequenceNumbersByIndividualNumber[
            individualNumber
          ]
        })
      );

      return rows;
    },
    columnVisibility() {
      return this.headers.filter(item => item.visibility === true);
    }
  },

  methods: {
    encodedSpecimenURI(item) {
      return "/reports/individualnumber/" + encodeURI(item.individual_number);
    }
  }
};
</script>
