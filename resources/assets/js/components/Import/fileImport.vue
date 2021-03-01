<template>
  <div class="m-2" style="width: 100%">
    <contentheader :trail="this.trail" :title="this.heading" :help_menu="true"></contentheader>
    <v-container>
      <v-row>
        <v-col cols="12">
          <p>Choose an Import File type</p>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12" sm="4">
          <v-overflow-btn style="width: 100%;text-align:center; height: 75%"
                          v-model="importId"
                          :items="importRows"
                          item-text="name" item-value="id"
                          dusk="import-type-select" id="selectImportRows"
                          filled
                          label="Select Import Type"
                          target="#dropdown-example">
          </v-overflow-btn>
        </v-col>
        <v-col>
          <v-btn color="primary" dusk="download-button" @click="downloadTemplate()" :disabled="importId === ''">Download Template</v-btn>
        </v-col>
      </v-row>
      <v-row>
        <label>File
          <input type="file" dusk="browse-files" ref="file" @change="handleFileUpLoad()"/>
        </label>
      </v-row>
      <v-row>
        <v-col align="center" >
          <v-btn color="green" dusk="upload-file-btn" @click="submitFile()" :disabled="importId === '' || isFileUploaded === false">Upload</v-btn>
        </v-col>
      </v-row>
    </v-container>
    <div>
    </div>
  </div>
</template>
<script>
import { mapState, mapGetters, mapActions } from 'vuex';
import axios from 'axios';

export default {
  name: "fileImports",
  props: {
    heading: {type: String, default: "Import File"},
  },
  data: function () {
    return {
      importAttachment: '',
      form:{},
      importId:'',
      isFileUploaded:false,
      rows:[],
      Import:{},
      trail: [{ text: 'Home', disabled: false, href: '/', },
        { text: 'File Import', disabled: true, href: '/', }]
    }
  },
  watch: {
    options: {
      handler () {
        //this.loadGeneral();
      },
      deep: true,
    },
  },
  created() {

  },
  mounted(){
    this.loadGeneral();

  },
  methods: {

    submitFile() {
      this.importRows.push(this.importId);
      let formData = new FormData();
      formData.append('importAttachment', this.file);
      formData.append('importFileType', this.importId);
      axios
          .request({
            url: '/api/files/uploadFile',
            method: 'POST',
            headers:{ 'Content-Type' : 'application/json',
              'Authorization' : this.$store.getters.bearerToken,
              'X-CSRF-TOKEN': document.head.querySelector(
                  'meta[name="csrf-token"]'
              ).content
            },
            data: this.importAttachment = formData,
          }).then(response=>{
        console.log("success");
      }).catch(error => {
        console.log(error);
      });
      this.isFileUploaded=false;
    },
    handleFileUpLoad(){
      this.file = this.$refs.file.files[0];
      this.isFileUploaded =true;
    },
    loadGeneral: function () {
      this.loading = true;
      axios({
        url: '/api/files/import-types',
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': this.$store.getters.bearerToken,
        }
      })
          .then(response => {
            this.Import = response.data.data.importTypes;
            this.totalSearchCount = response.data.data.count;
            console.log(this.Import);
            this.loading = false;
          })
          .catch((error) => {
            console.log(error);
          });

    },
    downloadTemplate(){
      this.importRows.push(this.importId);
      axios({
        url: '/api/files/importFile/downloadTemplate',
        method: 'GET',
        headers: {
          'Content-Type' :'text/csv',
          'Content-Description' :'File Download',
          'Authorization': this.$store.getters.bearerToken,
        },
        params:{
          importId: this.importId ? this.importId : null,
        }
      })
          .then(response => {
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            let fileName = this.rows.filter(row => row.id === this.importId)[0].name + '_sample_template.csv';
            link.setAttribute('download', fileName);
            document.body.appendChild(link);
            link.click();
          })
          .catch((error) => {
            console.log(error);
          })
    }
  },

  computed: {
    importRows() {
      const rows = [];
      Object.values(this.Import).forEach(item =>
          rows.push(
              {
                name: item.name,
                id: item.id,
              })
      );
      this.rows=rows;
      return rows;
    },
    ...mapGetters({
      theOrg: 'theOrg',
      theProject: 'theProject',
      theUser: 'theUser',
    }),
  },


}
</script>