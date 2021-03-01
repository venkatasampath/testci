{{--{{ Form::model($theUser, array('action' => array('UsersController@updateGeneral', $theUser->id)), ['id' => 'userGeneralForm']) }}--}}

{{--<general :lines_options="{{$theUser->getProfileDisplayValues('lines_per_page')}}"--}}
{{--         :options="{{ $theUser->getProfileValue("welcome_screen_on_startup") }}"--}}
{{--         :disabled="false"--}}
{{--         :switcher="true"--}}
{{--></general>--}}

{{--<div class="form-group">--}}
{{--    {!! Form::label('lines_per_page', trans('labels.lines_per_page').':', ['for' => 'lines_per_page']) !!}--}}
{{--    <div>--}}
{{--    {{ Form::select('lines_per_page', json_decode($theUser->getProfileDisplayValues('lines_per_page')), $theUser->getProfileValue("lines_per_page"), ['id' => 'lines_per_page', 'class' => "mav-select form-control controlForm", 'style' => "width: 30%", 'dusk' => 'lines_per_page'])}}--}}
{{--        <p class="m-0 p-1"><small class="note">{{ $theUser->getProfileHelp('lines_per_page') }}</small></p>--}}
{{--    </div>--}}
{{--</div>--}}

{{--@dump(json_decode($theUser->getProfileDisplayValues('lines_per_page')))--}}


{{--<div class="form-group">--}}
{{--    <div class="checkbox">--}}
{{--        <label>{{ Form::checkbox('welcome_screen_on_startup', 1, $theUser->getProfileValue("welcome_screen_on_startup"), ['id' => 'welcome_screen_on_startup', 'dusk' => 'show_welcome_screen']) }} <b>@lang('labels.welcome_screen_on_startup')</b></label>--}}
{{--        <p class="m-0 p-1"><small class="note">{{ $theUser->getProfileHelp('welcome_screen_on_startup') }}</small></p>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<div class="form-group">--}}
{{--    <div class="checkbox">--}}
{{--        <label>{{ Form::checkbox('ui_right_sidebar_slideout_help', 1, $theUser->getProfileValue("ui_right_sidebar_slideout_help"), ['id' => 'ui_right_sidebar_slideout_help', 'dusk' => 'ui_right_sidebar_slideout_help']) }} <b>@lang('labels.help_slideout')</b></label>--}}
{{--        <p class="m-0 p-1"><small class="note">{{ $theUser->getProfileHelp('ui_right_sidebar_slideout_help') }}</small></p>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<button id="generalFormButton" class="btn btn-primary" type="submit" form="userGeneralForm" dusk="update_general">@lang('labels.update')</button>--}}
{{--{!! Form::close() !!}--}}

{{--@section('footer')--}}
{{--    @parent--}}
{{--    <script>--}}
{{--        // AJAX Request--}}
{{--        $(document).ready(function() {--}}
{{--            $('#generalFormButton').click(function(e){--}}
{{--                e.preventDefault(e);--}}

{{--                // Validating checkbox--}}
{{--                var ui_right_sidebar_slideout_help = $("#ui_right_sidebar_slideout_help");--}}
{{--                if (ui_right_sidebar_slideout_help.is(":checked")) {--}}
{{--                    ui_right_sidebar_slideout_help = 1;--}}
{{--                } else {--}}
{{--                    ui_right_sidebar_slideout_help = 0;--}}
{{--                }--}}

{{--                // Validating checkbox--}}
{{--                var welcome_screen_on_startup = $("#welcome_screen_on_startup");--}}
{{--                if (welcome_screen_on_startup.is(":checked")) {--}}
{{--                    welcome_screen_on_startup = 1;--}}
{{--                } else {--}}
{{--                    welcome_screen_on_startup = 0;--}}
{{--                }--}}

{{--                $.ajax({--}}
{{--                    type:"POST",--}}
{{--                    url: '{{ URL::action ('UsersController@updateGeneral', $theUser->id) }}',--}}
{{--                    data:  {lines_per_page: $("#lines_per_page").val(),--}}
{{--                        welcome_screen_on_startup: welcome_screen_on_startup,--}}
{{--                        ui_right_sidebar_slideout_help: ui_right_sidebar_slideout_help},--}}
{{--                    success: function(data){--}}
{{--                        console.log(data);--}}
{{--                        messageText = "Update Successful";--}}
{{--                        setFlashMessage("success", messageText);--}}
{{--                    },--}}
{{--                    error: function(){--}}
{{--                        messageText = "General Update Failed - Contact Your System Administrator";--}}
{{--                        setFlashMessage("fail", messageText);--}}
{{--                    }--}}
{{--                })--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}
