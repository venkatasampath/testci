{{--{{ Form::model($theUser, array('action' => array('UsersController@updateProjects', $theUser->id)), ['id' => 'projects_form']) }}--}}
{{--<div class="form-group p-3" style="border: 1px solid #e8ebed;">--}}
{{--    {!! Form::label('default_project', trans('labels.default_project').':', ['for' => 'default_project']) !!}--}}
{{--    <div>--}}
{{--    --}}{{--{{ Form::select('default_project', json_decode($theUser->getProfileDisplayValues('default_project')), $theUser->getProfileValue('default_project'), ['id' => 'default_project', 'class' => 'mav-select form-control controlForm', 'style' => 'width: 30%', 'dusk' => 'default_project']) }}--}}
{{--    {{ Form::select('default_project', $list_projects, $theUser->getProfileValue('default_project'), ['id' => 'default_project', 'class' => 'mav-select form-control controlForm', 'style' => 'width: 30%', 'dusk' => 'default_project']) }}--}}
{{--        <userproject :default_project_options="{{$list_projects}}"></userproject>--}}
{{--    </div>--}}
{{--    <p class="m-0 p-1"><small class="note">{{ $theUser->getProfileHelp('default_project') }}</small></p>--}}
{{--</div>--}}

{{--<h4 style="margin-top: 8px; border-bottom: 1px solid #e8ebed;"><b>@lang('labels.skeletal_elements')</b></h4>--}}
{{--<div class="form-group">--}}
{{--    <userspecimen :se_new_redirect_url_options="{{$theUser->getProfileDisplayValues('se_new_redirect_url')}}"></userspecimen>--}}
{{--</div>--}}
{{--<div class="form-group w-50">--}}
{{--    <Accession :options="{{$list_accession}}" label="Accession" :disabled="true"></Accession>--}}
{{--    {!! Form::label('accession_number', trans('labels.accession_number').':', ['for' => 'accession_number']) !!}--}}
{{--    {!! Form::text('accession', $theUser->getProfileValue("accession"), ['id' => 'accession', 'class' => 'form-control controlForm', 'dusk' => 'accession']) !!}--}}
{{--    <p class="m-0 p-1"><small class="note">{{ $theUser->getProfileHelp('accession') }}</small></p>--}}
{{--</div>--}}
{{--<div class="form-group w-50">--}}
{{--    <Provenance1 :options="{{$list_provenance1}}" label="Provenance1"></Provenance1>--}}
{{--    {!! Form::label('provenance1', trans('labels.provenance1').':', ['for' => 'provenance1']) !!}--}}
{{--    {!! Form::text('provenance1', $theUser->getProfileValue("provenance1"), ['id' => 'provenance1', 'class' => 'form-control controlForm', 'dusk' => 'provenance1']) !!}--}}
{{--    <p class="m-0 p-1"><small class="note">{{ $theUser->getProfileHelp('provenance1') }}</small></p>--}}
{{--</div>--}}
{{--<div class="form-group w-50">--}}
{{--    <Provenance2 :options="{{ $list_provenance2}}" label="Provenance2" ></Provenance2>--}}
{{--    {!! Form::label('provenance2', trans('labels.provenance2').':', ['for' => 'provenance2']) !!}--}}
{{--    {!! Form::text('provenance2', $theUser->getProfileValue("provenance2"), ['id' => 'provenance2', 'class' => 'form-control controlForm', 'dusk' => 'provenance2']) !!}--}}
{{--    <p class="m-0 p-1"><small class="note">{{ $theUser->getProfileHelp('provenance2') }}</small></p>--}}
{{--</div>--}}
{{--<div class="form-group w-50">--}}

{{--    {!! Form::label('mru_list_skeletalelements', trans('labels.mru_list_skeletalelements').':', ['for' => 'mru_list_skeletalelements']) !!}--}}
{{--    {!! Form::text('mru_list_skeletalelements', $theUser->getProfileValue("mru_list_skeletalelements"), ['id' => 'mru_list_skeletalelements', 'class' => 'form-control controlForm', 'onblur' => 'lessThanTwenty(mru_list_skeletalelements)',  'maxlength' => '2', 'dusk' => 'mru_list_skeletalelements']) !!}--}}
{{--    <p class="m-0 p-1"><small class="note">{{ $theUser->getProfileHelp('mru_list_skeletalelements') }}</small></p>--}}
{{--</div>--}}
{{--<div class="form-group">--}}
{{--    {!! Form::label('se_new_redirect_url', trans('labels.se_new_redirect_url').':', ['for' => 'se_new_redirect_url']) !!}--}}
{{--    <div>--}}
{{--    {{ Form::select('se_new_redirect_url', json_decode($theUser->getProfileDisplayValues('se_new_redirect_url')), $theUser->getProfileValue('se_new_redirect_url'), ['id' => 'se_new_redirect_url', 'class' => 'mav-select form-control controlForm', 'style' => 'width: 30%', 'dusk' => 'se_new_redirect_url']) }}--}}
{{--    </div>--}}
{{--    <p class="m-0 p-1"><small class="note">{{ $theUser->getProfileHelp('se_new_redirect_url') }}</small></p>--}}
{{--</div>--}}

{{--<h4 style="margin-top: 8px; border-bottom: 1px solid #e8ebed;"><b>@lang('labels.dna')</b></h4>--}}
{{--<div class="form-group">--}}
{{--    <lab :options="{{$theUser->getProfileDisplayValues('default_lab')}}" label="{{$theUser->getProfileValue('default_lab')}}"></lab>--}}
{{--<div class="form-group">--}}
{{--    {!! Form::label('default_lab', trans('labels.default_lab').':', ['for' => 'default_lab']) !!}--}}
{{--    <div>--}}
{{--    {{ Form::select('default_lab', json_decode($theUser->getProfileDisplayValues('default_lab')), $theUser->getProfileValue('default_lab'), ['id' => 'default_lab', 'class' => 'mav-select form-control controlForm', 'style' => 'width: 30%', 'dusk' => 'default_laboratory']) }}--}}
{{--    </div>--}}
{{--    <p class="m-0 p-1"><small class="note">{{ $theUser->getProfileHelp('default_lab') }}</small></p>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
{{--    <method :options="{{$theUser->getProfileDisplayValues('default_mito_method')}}" label="{{$theUser->getProfileValue('default_mito_method')}}"></method>--}}
{{--    {!! Form::label('default_mito_method', trans('labels.default_mito_method').':', ['for' => 'default_mito_method']) !!}--}}
{{--    <div>--}}
{{--    {{ Form::select('default_mito_method', json_decode($theUser->getProfileDisplayValues('default_mito_method')), $theUser->getProfileValue('default_mito_method'), ['id' => 'default_mito_method', 'class' => 'mav-select form-control controlForm', 'style' => 'width: 30%', 'dusk' => 'default_mito_method']) }}--}}
{{--    </div>--}}
{{--    <p class="m-0 p-1"><small class="note">{{ $theUser->getProfileHelp('default_mito_method') }}</small></p>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
{{--    <method :options="{{$theUser->getProfileDisplayValues('default_y_method')}}" label="{{$theUser->getProfileValue('default_y_method')}}"></method>--}}
{{--    {!! Form::label('default_y_method', trans('labels.default_y_method').':', ['for' => 'default_y_method']) !!}--}}
{{--    <div>--}}
{{--        {{ Form::select('default_y_method', json_decode($theUser->getProfileDisplayValues('default_y_method')), $theUser->getProfileValue('default_y_method'), ['id' => 'default_y_method', 'class' => 'mav-select form-control controlForm', 'style' => 'width: 30%', 'dusk' => 'default_y_method']) }}--}}
{{--    </div>--}}
{{--    <p class="m-0 p-1"><small class="note">{{ $theUser->getProfileHelp('default_y_method') }}</small></p>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
{{--    <method :options="{{$theUser->getProfileDisplayValues('default_auto_method')}}" label="{{$theUser->getProfileValue('default_auto_method')}}"></method>--}}
{{--    {!! Form::label('default_auto_method', trans('labels.default_auto_method').':', ['for' => 'default_auto_method']) !!}--}}
{{--    <div>--}}
{{--        {{ Form::select('default_auto_method', json_decode($theUser->getProfileDisplayValues('default_auto_method')), $theUser->getProfileValue('default_auto_method'), ['id' => 'default_auto_method', 'class' => 'mav-select form-control controlForm', 'style' => 'width: 30%', 'dusk' => 'default_auto_method']) }}--}}
{{--    </div>--}}
{{--    <p class="m-0 p-1"><small class="note">{{ $theUser->getProfileHelp('default_auto_method') }}</small></p>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
{{--    <userdna :switcher="true" :options="1"></userdna>--}}
{{--    <div class="checkbox">--}}
{{--        <label>{{ Form::checkbox('consensus_dna_use_old', 1, $theUser->getProfileValue("consensus_dna_use_old"), ['id' => 'consensus_dna_use_old', 'dusk' => 'consensus_dna_use_old']) }} <b>@lang('labels.consensus_dna_use_old')</b></label>--}}
{{--        <p class="m-0 p-1"><small class="note">{{ $theUser->getProfileHelp('consensus_dna_use_old') }}</small></p>--}}
{{--    </div>--}}
{{--</div>--}}
{{--</div>--}}

{{--<h4 style="margin-top: 8px; border-bottom: 1px solid #e8ebed;"><b>@lang('labels.search_options')</b></h4>--}}
{{--<div class="form-group">--}}
{{--    <usersearch :search_options="{{$theUser->getProfileDisplayValues('default_search_option')}}" :options="1" :switcher="true"></usersearch>--}}
{{--</div>--}}
{{--<div class="form-group">--}}
{{--    {!! Form::label('default_search_option', trans('labels.default_search_option').':', ['for' => 'default_search_option']) !!}--}}
{{--    <div>--}}
{{--    {{ Form::select('default_search_option', json_decode($theUser->getProfileDisplayValues('default_search_option')), $theUser->getProfileValue('default_search_option'), ['id' => 'default_search_option', 'class' => 'mav-select form-control controlForm', 'style' => 'width: 30%','dusk' => 'default_search_option']) }}--}}
{{--    </div>--}}
{{--    <p class="m-0 p-1"><small class="note">{{ $theUser->getProfileHelp('default_search_option') }}</small></p>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
{{--    <div class="checkbox">--}}
{{--        <label>{{ Form::checkbox('user_save_last_search_by', 1, $theUser->getProfileValue("user_save_last_search_by"), ['id' => 'user_save_last_search_by', 'dusk' => 'se_user_save_last_search_by']) }} <b>@lang('labels.user_save_last_search_by')</b></label>--}}
{{--        <p class="m-0 p-1"><small class="note">{{ $theUser->getProfileHelp('user_save_last_search_by') }}</small></p>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
{{--    <div class="checkbox">--}}
{{--        <label>{{ Form::checkbox('se_search_open_in_new_browser_tab', 1, $theUser->getProfileValue("se_search_open_in_new_browser_tab"), ['id' => 'se_search_open_in_new_browser_tab', 'dusk' => 'se_search_open_in_new_browser_tab']) }} <b>@lang('labels.search_open_new_browser')</b></label>--}}
{{--        <p class="m-0 p-1"><small class="note">{{ $theUser->getProfileHelp('se_search_open_in_new_browser_tab') }}</small></p>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<button form="projects_form" class="btn btn-primary" id="project-submit" type="submit"  dusk="update_projects">@lang('labels.update')</button>--}}
{{--{{ Form::close() }}--}}

{{--@section('footer')--}}
{{--    @parent--}}
{{--    <script>--}}
{{--        // AJAX Request--}}
{{--        import Usersearch from "../../../assets/js/components/users/profile/project/UserSearch";--}}
{{--        $(document).ready(function() {--}}
{{--            $('#project-submit').click(function(e){--}}
{{--                e.preventDefault(e);--}}

{{--                // Validating checkbox--}}
{{--                var se_search_open_in_new_browser_tab = $("#se_search_open_in_new_browser_tab");--}}
{{--                if (se_search_open_in_new_browser_tab.is(":checked")) {--}}
{{--                    se_search_open_in_new_browser_tab = 1;--}}
{{--                } else {--}}
{{--                    se_search_open_in_new_browser_tab = 0;--}}
{{--                }--}}

{{--                var user_save_last_search_by = $("#user_save_last_search_by");--}}
{{--                if (user_save_last_search_by.is(":checked")) {--}}
{{--                    user_save_last_search_by = 1;--}}
{{--                } else {--}}
{{--                    user_save_last_search_by = 0;--}}
{{--                }--}}

{{--                var consensus_dna_use_old = $("#consensus_dna_use_old");--}}
{{--                if (consensus_dna_use_old.is(":checked")) {--}}
{{--                    consensus_dna_use_old = 1;--}}
{{--                } else {--}}
{{--                    consensus_dna_use_old = 0;--}}
{{--                }--}}

{{--                $.ajax({--}}
{{--                    type:"POST",--}}
{{--                    url: '{{ URL::action ('UsersController@updateProjects', $theUser->id) }}',--}}
{{--                    data:  {default_project: $("#default_project").val(),--}}
{{--                        accession: $("#accession").val(),--}}
{{--                        provenance1: $("#provenance1").val(),--}}
{{--                        provenance2: $("#provenance2").val(),--}}
{{--                        mru_list_skeletalelements: $("#mru_list_skeletalelements").val(),--}}
{{--                        se_new_redirect_url: $("#se_new_redirect_url").val(),--}}
{{--                        default_lab: $("#default_lab").val(),--}}
{{--                        default_mito_method: $("#default_mito_method").val(),--}}
{{--                        default_y_method: $("#default_y_method").val(),--}}
{{--                        default_auto_method: $("#default_auto_method").val(),--}}
{{--                        default_search_option: $("#default_search_option").val(),--}}
{{--                        user_save_last_search_by: user_save_last_search_by,--}}
{{--                        consensus_dna_use_old: consensus_dna_use_old,--}}
{{--                        se_search_open_in_new_browser_tab: se_search_open_in_new_browser_tab},--}}
{{--                    success: function(data){--}}
{{--                        console.log(data);--}}
{{--                        messageText = "Projects Update Successful";--}}
{{--                        setFlashMessage("success", messageText);--}}
{{--                    },--}}
{{--                    error: function(){--}}
{{--                        messageText = "Projects Update Failed - Contact Your System Administrator";--}}
{{--                        setFlashMessage("fail", messageText);--}}
{{--                    }--}}
{{--                })--}}
{{--            });--}}
{{--        });--}}
{{--        export default {--}}
{{--            components: {Usersearch}--}}
{{--        }--}}
{{--    </script>--}}
{{--@endsection--}}


