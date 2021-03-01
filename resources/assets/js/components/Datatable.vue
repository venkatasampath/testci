<template>
    <div class="table-responsive">
        <table class="table table-bordered table-striped" :id=table>
            <thead>
            <tr>
                <th v-for="label in labels">{{label}}</th>
            </tr>
            </thead>
            <tbody> <!-- Table Body -->
            <tr v-for="(item, index) in TableObject">
                <td v-for="choice in columns">
                    <template v-if="choice === 'projectName'">
                            <a :href="'/projectDashboard/' + item.link">{{item[choice]}}</a>
                    </template>
                    <template v-else-if="choice === 'skeletalElementsKey'">
                        <a :href="'/skeletalelements/' + item.id">{{skeletalElementsKey(index)}}</a>
                    </template>
                    <template v-else-if="choice === 'mito_sequence_number'">
                        <a :href="'/reports/mtdna/' + item.mito_sequence_number">{{item[choice]}}</a>
                    </template>
                    <template v-else>
                        {{item[choice]}}
                    </template>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    export default {
        name: "Datatable",
        props: {
            TableObject: Array,
            labels: Array,
            columns: Array,
            table: String,
            sortColumn: String,
            sortDirection: String,
            searching: Boolean,
            pagination: Boolean,
            pageLength: Number,
            dynamicLength: Boolean,
            chartClass: String

        },
        calculated: {
            sort: function() {
                if (this.sortColumn != null) {
                    return [[ this.sortColumn, '"'+this.sortDirection+'"' ]];
                } else {
                    return null
                }
            },
            scrollHeight: function() {
                var height;
                if(this.table == 'widget6table_101' || this.table == 'widget6table_101 ||' || this.table == 'widget6table_16' || this.table == 'widget6table_17')
                {
                    height =  "300px";
                }
                return height;
            },
            isScroll: function() {
                if(this.table == 'widget6table_101' || this.table == 'widget6table_101 ||' || this.table == 'widget6table_16' || this.table == 'widget6table_17')
                {
                    return true;
                }
                return false;
            },
            details: function() {
                if(this.table == 'widget6table_101' || this.table == 'widget6table_101 ||' || this.table == 'widget6table_16' || this.table == 'widget6table_17')
                {
                    return true;
                }
                return false;
            }
        },
        methods: {
            skeletalElementsKey: function (index) {
                if(this.TableObject[index].provenance1 === null && this.TableObject[index].provenance2 === null ){
                    return this.TableObject[index].accession_number + '-' + this.TableObject[index].designator
                }
                else if(this.TableObject[index].provenance1 === null) {
                    return this.TableObject[index].accession_number + '-' +
                        '-' +
                        this.TableObject[index].provenance2 + '-' + this.TableObject[index].designator
                }
                else if(this.TableObject[index].provenance2 === null) {
                    return this.TableObject[index].accession_number + '-' + this.TableObject[index].provenance1 + '-' +
                         '-' +
                        this.TableObject[index].designator
                }
                else {
                    return this.TableObject[index].accession_number + '-' + this.TableObject[index].provenance1 + '-' +
                    this.TableObject[index].provenance2 + '-' + this.TableObject[index].designator
                }
            }
        },

        mounted() {
            $('#'+ this.table).DataTable({
                "order": this.sort,
                bFilter: this.searching,            //searching
                bPaginate: this.pagination,         // have pages
                pageLength: this.pageLength,        //default how many we see
                bLengthChange: this.dynamicLength,  //drop down for # records
                "scrollY":        "300px",
                "scrollCollapse": this.isScroll,
                "bInfo": false
            });
        }
    }
</script>
