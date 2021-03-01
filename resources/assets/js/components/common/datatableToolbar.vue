<template>
    <v-row>
        <v-col cols="9">
            <v-btn-toggle v-model="toggle_multiple" dense dark multiple>
                <v-btn v-if="csv">CSV</v-btn>
                <v-btn v-if="excel">Excel</v-btn>
                <v-btn v-if="pdf">PDF</v-btn>
                <v-menu v-if="colvis" right offset-x :close-on-content-click="false" max-height="500px">
                    <template v-slot:activator="{ on }">
                        <v-btn v-on="on">Column Visibility<v-icon right>$dropdown</v-icon></v-btn>
                    </template>

                    <v-list>
                        <v-list-item v-for="(header, index) in headers" :key="index">
                            <v-checkbox v-bind:label="header.text" v-model="header.visibility" :value="header.visibility"/>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </v-btn-toggle>
        </v-col>
        <v-spacer></v-spacer>
        <v-col cols="3">
            <v-text-field v-model="search" label="Search" clearable single-line hide-details append-icon="mdi-magnify" dusk="search-datatable"/>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: "datatableToolbar",
        props:{
            csv: {type:Boolean, default: true},
            excel: {type:Boolean, default: false},
            pdf: {type:Boolean, default: false},
            colvis: {type:Boolean, default: true},
            colvisHeaders: {type:Array, required: true},
        },
        data() {
            return {
                search: '',
                toggle_multiple: [],
                headers: this.colvisHeaders,
            }
        },
        watch:{
            search(val){
                this.$emit('dt-search', val);
            }
        }
    }
</script>

<style scoped>

</style>