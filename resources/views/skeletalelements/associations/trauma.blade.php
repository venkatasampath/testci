@extends('skeletalelements.associations.common')

@section('association-content')
        <div class="card-body">
                <div class="form-group{{ $errors->has('trauma') ? ' has-error' : '' }}">
                    @if($CRUD_Action != 'Create')
                        <div>
                            <v-app>
                                <v-container class="grey lighten-5">
                                    <v-row no-gutters>
                                        <v-col>
                                            <v-card>
                                                <trauma :disabled="true" :options="{{$list_trauma}}" :dusk="'se-trauma-trauma'"></trauma>
                                            </v-card>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-app>
                        </div>
                    @else
                        <div id="pathologies-information">
                            <v-app id="inspire">
                                <v-card>
                                    <v-toolbar flat color="primary" dark>
                                        <v-toolbar-title >Pathologies</v-toolbar-title>
                                    </v-toolbar>
                                    <v-tabs>
                                        <v-tab>
                                            Trauma Information
                                        </v-tab>
                                        <v-tab>
                                            Pathology Information
                                        </v-tab>
                                        <v-tab>
                                            Anomalies Information
                                        </v-tab>
{{--                                        Trauma Vertical Tabs--}}
                                        <v-tab-item>
                                            <v-card flat>
                                                <div id="trauma-information">
                                                    <v-app id="inspire">
                                                        <v-card>
                                                            <v-tabs vertical class="trauma-tabs">
                                                                <v-tab id="createTab">
                                                                    Create New Trauma
                                                                </v-tab>
                                                                <v-tab id="viewTab">
                                                                    View Trauma
                                                                </v-tab>
                                                                <v-tab-item>
                                                                    <v-card flat>
                                                                        <zone :options_object="{{$list_zone}}" :disabled="false" :autocomplete ="true" :deletedchips ="true"></zone>
                                                                        <trauma :disabled="false" :options="{{$list_trauma}}" :dusk="'se-trauma-trauma'"></trauma>
                                                                        <additionalinformation :disabled="false" :dusk="'se-trauma-additional_info'"></additionalinformation>
                                                                        <div>
                                                                            <v-btn color="primary" id="traumaInfo">Save Trauma Information</v-btn>
                                                                        </div>
                                                                    </v-card>
                                                                </v-tab-item>
                                                                <v-tab-item>
                                                                    <v-card flat>
                                                                        <cruddatatable
                                                                                :tableheadertext="'{{trans('labels.trauma')}}'"
                                                                                :tablealign="'left'"
                                                                                :tablesortable="false"
                                                                                :tablevalue="'name'"
                                                                                :tableitems="{{$skeletalelement->traumas}}"
                                                                        >
                                                                        </cruddatatable>
                                                                    </v-card>
                                                                </v-tab-item>
                                                            </v-tabs>
                                                        </v-card>
                                                    </v-app>
                                                </div>
                                            </v-card>
                                        </v-tab-item>
{{--                                        Pathology Vertical Tabs--}}
                                        <v-tab-item>
                                            <div id="pathology-information">
                                                <v-app id="inspire">
                                                    <v-card>
                                                        <v-tabs vertical class="pathology-tabs">
                                                            <v-tab>
                                                                Create New Pathology
                                                            </v-tab>
                                                            <v-tab-item>
                                                                <v-card flat>
                                                                    <zone :options_object="{{$list_zone}}" :disabled="false" :autocomplete ="true" :deletedChips="true"></zone>
{{--                                                                    <pathologies :options="{{$list_pathology}}" :disabled="false" :dusk="'se-pathology'"></pathologies>--}}
                                                                    <additionalinformation :disabled="false" :dusk="'se-pathology-additional_info'"></additionalinformation>
                                                                    <div>
                                                                        <v-btn color="primary" id="pathologyInfo">Save Pathology Information</v-btn>
                                                                    </div>
                                                                </v-card>
                                                            </v-tab-item>
                                                        </v-tabs>
                                                    </v-card>
                                                </v-app>
                                            </div>
                                        </v-tab-item>

{{--                                        Anomalies Vertical Tabs--}}
                                        <v-tab-item>
                                            <div id="pathology-information">
                                                <v-app id="inspire">
                                                    <v-card>
                                                        <v-tabs vertical class="anomalies-tabs">
                                                            <v-tab>
                                                                Anomalies
                                                            </v-tab>

                                                            <v-tab-item>
                                                                <v-card flat>
{{--                                                                    <anomalies :options="{{$list_anomaly}}" :disabled="true"></anomalies>--}}
                                                                    <div>
                                                                        <v-btn color="primary" id="anomaliesInfo">Save Anomalies Information</v-btn>
                                                                    </div>
                                                                </v-card>
                                                            </v-tab-item>
                                                        </v-tabs>
                                                    </v-card>
                                                </v-app>
                                            </div>
                                        </v-tab-item>
                                    </v-tabs>
                                </v-card>
                            </v-app>
                        </div>
                 @endif
                </div>
                <div class="form-group{{ $errors->has('additional_information') ? ' has-error' : '' }}">
{{--                    {!! Form::label('additional_information', 'Additional Information:', ['class' => 'col-md-4 control-label']) !!}--}}
                    <div class="col-md-6">
                        @if($CRUD_Action != 'Create')
                            <div>
                                <v-app>
                                    <v-container class="grey lighten-5">
                                        <v-row no-gutters>
                                            <v-col>
                                                <v-card>
                                                    <additionalinformation :disabled="true" :dusk="'se-trauma-additional_info'"></additionalinformation>
                                                </v-card>
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                </v-app>
                            </div>
{{--                            {!! Form::textarea('additional_information', $trauma->pivot->additional_information, ['class' => 'col-md-12 form-control','dusk'=>'se-trauma-additional_info']) !!}--}}
                        @else
{{--                            <div>--}}
{{--                                <v-app>--}}
{{--                                    <v-container class="grey lighten-5">--}}
{{--                                        <v-row no-gutters>--}}
{{--                                            <v-col>--}}
{{--                                                <v-card>--}}
{{--                                                    <additionalinformation :disabled="false" :dusk="'se-trauma-additional_info'"></additionalinformation>--}}
{{--                                                </v-card>--}}
{{--                                            </v-col>--}}
{{--                                        </v-row>--}}
{{--                                    </v-container>--}}
{{--                                </v-app>--}}
{{--                            </div>--}}
{{--                            {!! Form::textarea('additional_information', null, ['class' => 'col-md-12 form-control','dusk'=>'se-trauma-additional_info']) !!}--}}
                        @endif
                        @if ($errors->has('additional_information'))
{{--                                <div>--}}
{{--                                    <v-app>--}}
{{--                                        <v-container class="grey lighten-5">--}}
{{--                                            <v-row no-gutters>--}}
{{--                                                <v-col>--}}
{{--                                                    <v-card>--}}
{{--                                                        <additionalinformation :disabled="false" :dusk="'se-trauma-additional_info'"></additionalinformation>--}}
{{--                                                    </v-card>--}}
{{--                                                </v-col>--}}
{{--                                            </v-row>--}}
{{--                                        </v-container>--}}
{{--                                    </v-app>--}}
{{--                                </div>--}}
{{--                                <span class="form-text text-muted"><strong>{{ $errors->first('additional_information') }}</strong></span>--}}
                        @endif
                    </div>
                </div>
            @if($CRUD_Action != 'View')
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-5" >
                        {!! Form::button('<i class="fas fa-btn fa-save"></i>Save', ['type' => 'submit', 'class' => 'btn btn-primary','dusk'=>'se-trauma-save']) !!}
                    </div>
                </div>
            @endif
        </div>

    {!! Form::close() !!}
@endsection

@section('footer')
    @parent
    @include ('common._footer', ['CRUD_Action' => $CRUD_Action, 'includeStyle' => true, 'includeScript' => true])

    <style>
        div.trauma-tabs [role="tab"] {
            justify-content: flex-start;
        }
        div.pathology-tabs [role="tab"] {
            justify-content: flex-start;
        }
        div.anomalies-tabs [role="tab"] {
            justify-content: flex-start;
        }
    </style>
@endsection
