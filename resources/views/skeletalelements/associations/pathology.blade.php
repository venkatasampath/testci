@extends('skeletalelements.associations.common')

@section('association-content')
    {!! Form::model($pathology, ['class' => 'form-horizontal', 'method' => 'POST', 'action' => ['SkeletalElementsController@associatepathology', $skeletalelement->id]]) !!}{{ csrf_field() }}
    <div class="card">
        <div class="card-header" style="height: 35px;">{{$heading}}
            <div class="float-right">
                @if($CRUD_Action == 'View' || $CRUD_Action == 'Update')
                    <button type="button" dusk="se-pathology-menu" class="btn btn-default btn-primary dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @lang('labels.actions')
                    </button>
                    @if($CRUD_Action == 'View')
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/pathologys') }}"><i class="fas fa-fw fa-btn fa-list-alt"></i>@lang('labels.all')</a></li>
                            <li><a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/pathologys/'.$pathology->pivot->id.'/edit') }}"><i class="fas fa-fw fa-btn fa-edit"></i>@lang('labels.edit')</a></li>
                        </ul>
                    @elseif($CRUD_Action == 'Update')
                        <ul class="dropdown-menu">
                            <li><a dusk="se-pathology-update" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/pathologys/'.$pathology->pivot->id) }}"><i class="fas fa-fw fa-btn fa-undo"></i>@lang('labels.discard_changes')</a></li>
                        </ul>
                    @endif
                @endif
            </div>
        </div>
        <div class="card-body">
                <div class="form-group{{ $errors->has('zone') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">@lang('labels.zone'):</label>
                    @if($CRUD_Action != 'Create')
                        <div class="col-md-6">{!! Form::select('zonelist[]', $list_zone, $pathology->pivot->zone_id, ['id' => 'zonelist', 'class' => 'form-control mav-select','multiple', 'style' => 'width: 60%; margin-top: 10px;','dusk'=>'se-pathology-zone']) !!}</div>
                    @else
                        <Zone :options_object="{{$list_zone}}" :disabled="false" :autocomplete="true"></Zone>
{{--                        <div class="col-md-6">{!! Form::select('zonelist[]', $list_zone, null, ['id' => 'zonelist', 'class' => 'form-control mav-select','multiple', 'style' => 'width: 60%; margin-top: 10px;','dusk'=>'se-pathology-zone']) !!}</div>--}}
                    @endif
                </div>
                <div class="form-group{{ $errors->has('pathology') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">@lang('labels.pathology'):</label>
                    @if($CRUD_Action != 'Create')
                        <div class="col-md-6">{{ Form::select('pathology_id', $list_pathology, $pathology->pivot->pathology_id, ['id' => 'pathology_id', 'class' => 'form-control mav-select', 'placeholder' => 'Select Pathology','dusk'=>'se-pathology']) }}</div>
                    @else
                        <div class="col-md-6">{{ Form::select('pathology_id', $list_pathology, null, ['id' => 'pathology_id', 'class' => 'form-control mav-select', 'placeholder' => 'Select Pathology','dusk'=>'se-pathology']) }}</div>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('additional_information') ? ' has-error' : '' }}">
                    {!! Form::label('additional_information', 'Additional Information:', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        @if($CRUD_Action != 'Create')
                            {!! Form::textarea('additional_information', $pathology->pivot->additional_information, ['class' => 'col-md-12 form-control','dusk'=>'se-pathology-additional_info']) !!}
                        @else
                            {!! Form::textarea('additional_information', null, ['class' => 'col-md-12 form-control','dusk'=>'se-pathology-additional_info']) !!}
                        @endif
                        @if ($errors->has('additional_information'))
                            <span class="help-block"><strong>{{ $errors->first('additional_information') }}</strong></span>
                        @endif
                    </div>
                </div>
            @if($CRUD_Action != 'View')
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-5" >
                        {!! Form::button('<i class="fas fa-btn fa-save"></i>Save', ['type' => 'submit', 'class' => 'btn btn-primary','dusk'=>'se-pathology-save']) !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('footer')
    @parent
    @include ('common._footer', ['CRUD_Action' => $CRUD_Action, 'includeStyle' => true, 'includeScript' => true])
    <script>
        $(document).ready(function($) {
            $('select#sb, select#side, select#completeness').select2();
            $('select#zone_id, select#pathology_id').select2();
        });
    </script>
@endsection
