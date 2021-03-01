@extends('skeletalelements.associations.common')
@section('association-content')
{{--    {!! Form::model($skeletalelement, ['class' => '', 'method' => 'POST', 'action' => ['SkeletalElementsController@associatemethod', $skeletalelement->id, $method->id]]) !!}{{ csrf_field() }}--}}
    <div class="card ">
{{--        <div class="card-header" style="height: 35px;">{{ $method->type }} @lang('labels.method') - {{ $method->name }}:{{ $method->submethod }} - <a href="{{ $method->help_url }}" target="_blank"><i class="far fa-btn fa-fw fa-lg fa-question-circle"></i></a>--}}
            <div class="float-right">
{{--                <button dusk="actions-button" type="button" class="btn btn-default btn-primary dropdown-toggle"--}}
{{--                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                    @lang('labels.actions')--}}
{{--                </button>--}}
                <ul class="dropdown-menu">

                    @if ($method->type == "Age")
                        <li><a dusk="actions-all-menu" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/age') }}"><i class="fas fa-fw fa-btn fa-list-alt"></i>@lang('labels.all')</a></li>
                    @elseif ($method->type == "Sex")
                        <li><a dusk="actions-all-menu" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/sex') }}"><i class="fas fa-fw fa-btn fa-list-alt"></i>@lang('labels.all')</a></li>
                    @elseif ($method->type == "Stature")
                        <li><a dusk="actions-all-menu" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/stature') }}"><i class="fas fa-fw fa-btn fa-list-alt"></i>@lang('labels.all')</a></li>
                    @elseif ($method->type == "Ancestry")
                        <li><a dusk="actions-all-menu" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/ancestry') }}"><i class="fas fa-fw fa-btn fa-list-alt"></i>@lang('labels.all')</a></li>
                    @endif
                    @if($CRUD_Action == 'View')
                        <li><a dusk="actions-edit-menu" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/methods/'.$method->id.'/edit') }}"><i class="fas fa-fw fa-btn far fa-edit"></i>@lang('labels.edit')</a></li></ul>
                @elseif($CRUD_Action == 'Update')
                    <li><a dusk="actions-discard-changes-menu" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/methods/'.$method->id) }}"><i class="fas fa-fw fa-btn fa-undo"></i>@lang('labels.discard_changes')</a></li>
                    @endif
                    </ul>
            </div>
        </div>
        {{-- Method that uses a feature score system --}}
        @if ($method->uses_feature_score && $method->features->count() != 0)
            <div class="card-body">
                <div class="row">
                    @if ( $CRUD_Action != 'View')
                        <div class="col-md-12">
                            <div class="col-sm-12 form-group">
                                <div class="col-sm-6 col-sm-offset-3" >
                                    <br>
                                    <!-- Method Feature -->
                                    <methodfeature :options="{{$method->features}}" types="{{ $method->type }}" name="{{ $method->name }}"
                                                   submethod="{{ $method->submethod }}"
                                                   helphref="{{ $method->help_url }}" :disabled="false"
                                                   :specimen_id="{{$skeletalelement->id}}"
                                                   :base_url="{{json_encode(url('/'))}}" action="{{$CRUD_Action}}"
                                    >
                                    </methodfeature>
                                </div>
                            </div>
                        </div>
                    @endif
                        @if ( $CRUD_Action == 'View')
                            <div class="col-md-12">
                                <div class="col-sm-12 form-group">
                                    <div class="col-sm-6 col-sm-offset-3" >
                                        <br>
                                        <!-- Method Feature-->
                                        <methodfeature :options="{{$method->features}}"
                                                       types="{{ $method->type }}" name="{{ $method->name }}"
                                                       submethod="{{ $method->submethod }}" helphref="{{ $method->help_url }}"
                                                       :specimen_id="{{$skeletalelement->id}}"
                                                       :base_url="{{json_encode(url('/'))}}" :disabled="true" action="{{$CRUD_Action}}"
                                        >

                                        </methodfeature>
                                    </div>
                                </div>
                            </div>
                        @endif
                </div>
            </div>

        @else
            <div class="alert alert-danger">
                <h4>@lang('messages.error_missing_method_feature_scoring_setup', ['bonename'=>$skeletalelement->sb->name, 'methodtype'=>$method->type, 'methodname'=>$method->name])</h4>
                <h4>@lang('messages.please_contact_sys_admin')</h4>
            </div>
        @endif
    </div>
    {!! Form::close() !!}
@endsection

@section('footer')
    @parent
    @include ('common._footer', ['CRUD_Action' => $CRUD_Action, 'includeStyle' => true, 'includeScript' => true])
    <script>
        $(document).ready(function($) {
            $('select#sb, select#side, select#completeness').select2();
            $('select#feature_groups').on('change', function() {
                if (this.value !== null && this.value !== "") {
                    var groups = this.value;
                    $('fieldset.fg').hide();
                    $('fieldset.'+groups).show();
                } else {
                    $('fieldset.fg').show();
                }
            });
            var value =  $('#controlSlideoutHelp').data("value-check");
            if(value == true){
                open_panel();
            }
        });

        function open_panel() {
            var help_url =  $("fieldset.fg").data("m-help_url");
            $('#help-info').attr('src', help_url);
            $('.control-sidebar').toggleClass('control-sidebar-open');
            $('#control-sidebar-theme-tab').removeClass('active');
            $('#control-sidebar-help-tab').toggleClass('active');
        };
    </script>
@endsection
