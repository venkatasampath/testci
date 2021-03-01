@extends('skeletalelements.associations.common')

@section('association-content')
    <div id="Vue-Anomaly">
{{--        {!! Form::model($skeletalelement, ['class' => 'form-horizontal', 'method' => 'POST', 'action' => ['SkeletalElementsController@associateanomalys', $skeletalelement->id]]) !!}{{ csrf_field() }}--}}

        <div class="card">
            <div class="card-header" style="height: 35px;">{{$heading}}
                <div class="float-right">
                    @if($CRUD_Action == 'View' || $CRUD_Action == 'Update')
                        <button type="button" dusk="se-anomalys-menu" class="btn btn-default btn-primary dropdown-toggle"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @lang('labels.actions')
                        </button>
                        @if($CRUD_Action == 'View')
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/associateanomalys') }}"><i class="fas fa-fw fa-btn fa-edit"></i>@lang('labels.edit')</a></li>
                            </ul>
                        @elseif($CRUD_Action == 'Update')
                            <ul class="dropdown-menu">
                                <li><a dusk="se-anomalys-update" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/anomalys') }}"><i class="fas fa-fw fa-btn fa-undo"></i>@lang('labels.discard_changes')</a></li>
                            </ul>
                        @endif
                    @endif
                </div>
            </div>
        </div>

{{--        <div class="card-body">--}}
{{--            <div class="row">--}}
{{--                <div class="col-lg-12 form-group anomalys" >--}}
{{--                        <br><label class="col-md-4 control-label">@lang('labels.anomalies'):</label>--}}
{{--                        @dump($list_anomaly)--}}
{{--                        {!! Form::select('anomalylist[]', $list_anomaly, null, ['id' => 'anomalys', 'class' => 'form-control anomalys mav-select', 'multiple', 'style' => 'width: 60%; margin-top: 10px;','dusk'=>'se-anomaly-list']) !!}--}}
{{--                </div>--}}
                @if($CRUD_Action != 'View')
                    <div>
                        <v-app>
                            <v-container class="grey lighten-5">
                                <v-row no-gutters>
                                    <v-col>
                                        <v-card dark tile flat>
                                            <anomalies :options="{{$list_anomaly}}" :disabled="false"></anomalies>
                                        </v-card>
                                        <div>
                                            <v-btn color="primary" id="anomaly">Save Anomaly Information</v-btn>
                                        </div>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-app>
                    </div>

                @elseif($CRUD_Action == 'View')
                    <div>
                        <v-app>
                            <v-container class="grey lighten-5">
                                <v-row no-gutters>
                                    <v-col>
                                        <v-card dark tile flat>
                                            <anomalies :options="{{$list_anomaly}}" :disabled="true"></anomalies>
                                        </v-card>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-app>
                    </div>

                @endif
{{--            </div>--}}
{{--        </div>--}}
    </div>
{{--    {!! Form::close() !!}--}}
@endsection

{{--@section('footer')--}}
{{--    @parent--}}
{{--    @include ('common._footer', ['CRUD_Action' => $CRUD_Action, 'includeStyle' => true, 'includeScript' => true])--}}

{{--    <style>--}}
{{--        div.v-application--wrap{--}}
{{--            min-height: 0;--}}
{{--        }--}}
{{--    </style>--}}
{{--@endsection--}}