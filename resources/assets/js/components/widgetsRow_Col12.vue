<template>
    <!--This is for widgets with size 12-->
    <section class="row">
        <div class="col-md-12" v-for="widget in widgetsList_Col12" v-if="widget.visible">
            <div class="card" style="margin-bottom: 10px;">
                <div class="card-header" style="margin:0">
                    <div style="float:left">
                        {{widget.name}}
                    </div>
                    <div style="float: right">
                        <a data-toggle="tooltip" :title="widget.chartHelp" style="padding-right:.25em;"><i class="far fa-lg fa-question-circle"></i></a>
                        <a data-toggle="collapse" :data-target="'#widget12_'+widget.id" style="padding-right:.25em;"><i class="far fa-lg fa-minus-square"></i></a>
                        <a v-on:click="HideWidget(widget.id)"><i class="far fa-times-circle fa-lg"></i></a>
                    </div>
                </div>
                <div class="card-body collapse show widget" :id="'widget12_'+widget.id">
                    <div v-if="widget.type == 'Bar'">
                        <barchart
                                v-bind:data-values= 'widget.dataValues'
                                v-bind:chart-class= '"widget12_"+widget.id'
                                v-bind:chart-colors="widget.chartColors"
                                v-bind:chart-labels="widget.chartLabels"
                                v-bind:chart-type="widget.chartType"
                                v-bind:dataset-label="widget.datasetLabel">
                        </barchart>
                    </div>
                    <div v-if="widget.type == 'StackedBar'">
                        <stackedbarchart
                                v-bind:chart-id= '"widget12_"+widget.id'
                                v-bind:chart-class= 'widget.dataType'
                                v-bind:chart-type="widget.chartType"
                                v-bind:filteredlist="widget.dataValues"
                                v-bind:search-list="widget.dataList"
                                v-bind:labels="widget.chartLabels">
                        </stackedbarchart>
                    </div>
                    <div v-if="widget.type == 'Pie'">
                        <piechart
                                v-bind:data-values= 'widget.dataValues'
                                v-bind:chart-class= '"widget12_"+widget.id'
                                v-bind:chart-colors="widget.chartColors"
                                v-bind:chart-labels="widget.chartLabels">
                        </piechart>
                    </div>
                    <div v-if="widget.type == 'Line'">
                        <linechart
                                v-bind:chart-class= '"widget12_"+widget.id'
                                v-bind:dataset= 'widget.dataValues'
                                v-bind:labels="widget.chartLabels">
                        </linechart>
                    </div>
                    <div v-if="widget.type == 'Map'">
                        <googlemap
                                v-bind:calculated-class= '"widget12_"+widget.id'
                                v-bind:project-details-array='widget.dataValues'>
                        </googlemap>
                    </div>
                    <div v-if="widget.type == 'Table'">
                        <div v-if="widget.dataValues[0]">
                            <datatable
                                    v-bind:chart-class= '"widget12_"+widget.id'
                                    v-bind:labels= 'widget.chartLabels'
                                    v-bind:table-object= 'widget.dataValues'
                                    v-bind:columns= 'widget.datasetLabel'
                                    v-bind:table= '"widget12table_"+widget.id'
                            ></datatable>
                        </div>
                        <div v-else> No Records.</div>
                    </div>
                    <div class="row" style="margin-top:5px;" v-if="widget.type != 'Table' && widget.type != 'Map'">
                        <div class="col-md-3" style="float:left">
                            <a :href="'/drilldown/' + widget.id"class="btn btn-primary disabled" >View Details</a>
                        </div>
                        <div class="col-md-9" >
                            <div class="updatedInfo">
                                Last Updated At: {{widget.updatedDatetime}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
    export default {
        name: 'widgetsRow_Col12',
        props:['widgetList'],
        computed: {
            widgetsList_Col12: function () {
                return this.widgetList.filter(x => x.size === 12)
            }
        },
        methods:{
            HideWidget:function (id) {
                var el= this.widgetsList_Col12.filter(x => x.id === id)[0];
                el.visible = false;
            }
        }
    }
</script>

<style>
    .card-header a{
        cursor: pointer;
    }
    #widgetsUL  ul li input{
        padding-left: 10px!important;
    }
    .updatedInfo {
        opacity: 0.5;
        font-size:90%;
        position:absolute;
        bottom:0;
        right:5px;
    }
    @media (max-width: 480px) {
        .updatedInfo {
            position: relative;
        }
    }
</style>