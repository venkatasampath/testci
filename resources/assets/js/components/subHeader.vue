<template>
    <div class="container-fluid">
    <section class="row subHeader">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="margin:0">
                    <a v-on:click="onClickButton()" style="float: right" title="Close this Panel">
                        <i class="far fa-times-circle fa-lg" ></i>
                    </a>
                    Customize Widget Visibility
                    <!--<i class="fa fa-plus-square fa-lg" style="float: right"></i>-->
                </div>
                <div class="card-body" id="widgetsUL">
                    <p>
                        Select the charts you would like to have visible on the dashboard below.
                    </p>
                    <div class="row">
                        <div class="col-3">
                            <ul class="list-group">
                                <li class="list-group-item" v-for="widget in widgetsList_Col6">
                                    <div>
                                        <input
                                                class="form-check-input"
                                                type="checkbox"
                                                :value="widget.id"
                                                :checked="widget.visible"
                                                v-on:change="visibility_Col6_Changed(widget.id)"
                                        >
                                    </div>
                                    <div style="padding-left:15px;">
                                        {{widget.name}}
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-3">
                            <ul class="list-group">
                                <li class="list-group-item" v-for="widget in widgetsList_Col4">
                                    <div>
                                        <input
                                                class="form-check-input"
                                                type="checkbox"
                                                :value="widget.id"
                                                :checked="widget.visible"
                                                v-on:change="visibility_Col4_Changed(widget.id)"
                                        >
                                    </div>
                                    <div style="padding-left:15px;">
                                        {{widget.name}}
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <ul class="list-group">
                                <li class="list-group-item" v-for="widget in widgetsList_Col3">
                                    <div>
                                        <input
                                                class="form-check-input"
                                                type="checkbox"
                                                :value="widget.id"
                                                :checked="widget.visible"
                                                v-on:change="visibility_Col3_Changed(widget.id)"
                                        >
                                    </div>
                                    <div style="padding-left:15px;">
                                        {{widget.name}}
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-3">
                            <ul class="list-group">
                                <li class="list-group-item" v-for="widget in widgetsList_Col12">
                                    <div>
                                        <input
                                                class="form-check-input"
                                                type="checkbox"
                                                :value="widget.id"
                                                :checked="widget.visible"
                                                v-on:change="visibility_Col12_Changed(widget.id)"
                                        >
                                    </div>
                                    <div style="padding-left:15px;">
                                        {{widget.name}}
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
</template>

<script>
    export default {
        name: 'subHeader',
        props:['widgetList','IsPanelVisible'],
        computed: {
            widgetsList_Col6: function () {
                return this.widgetList.filter(x => x.size === 6)
            },
            widgetsList_Col4: function () {
                return this.widgetList.filter(x => x.size === 4)
            },
            widgetsList_Col3: function () {
                return this.widgetList.filter(x => x.size === 3)
            },
            widgetsList_Col12: function () {
                return this.widgetList.filter(x => x.size === 12)
            }
        },
        methods:{
            visibility_Col6_Changed: function (id) {
                var el= this.widgetsList_Col6.filter(x => x.id === id)[0];
                el.visible = !el.visible;
            },
            visibility_Col4_Changed: function (id) {
                var el= this.widgetsList_Col4.filter(x => x.id === id)[0];
                el.visible = !el.visible;
            },
            visibility_Col3_Changed: function (id) {
                var el= this.widgetsList_Col3.filter(x => x.id === id)[0];
                el.visible = !el.visible;
            },
            visibility_Col12_Changed: function (id) {
                var el= this.widgetsList_Col12.filter(x => x.id === id)[0];
                el.visible = !el.visible;
            },
            onClickButton (event) {
                this.$emit('clicked', false)
            }
        }
    }
</script>

<style>
    .subHeader .card-header {
        cursor: pointer;
    }
    #widgetsUL  ul li input{
        padding-left: 10px!important;
    }
</style>