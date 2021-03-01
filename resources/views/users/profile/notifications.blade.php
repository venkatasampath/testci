{{--<h5><b>@lang('labels.notify_me_when')</b></h5>--}}
{{--{{ Form::model($theUser, array('action' => array('UsersController@updateNotifications', $theUser->id)), ['id' => 'notifications_form']) }}--}}
{{--<div class="form-group p-3" style="border: 1px solid #e8ebed;">--}}
{{--<notification--}}
{{--        :notify_options="{{$theUser->getProfileValue("notify_export_import_completion")}}"--}}
{{--        :switcher="true">--}}
{{--</notification>--}}
{{--</div>--}}
{{--:notifyJobText="{{ $theUser->getProfileHelp('notify_export_import_completion') }}"--}}
{{--:notifyReviewText="{{ $theUser->getProfileHelp('notify_se_review_completion') }}"--}}
{{--    <div class="checkbox">--}}
{{--        <label style="margin: 0;">{{ Form::checkbox('notify_export_import_completion', 1, $theUser->getProfileValue("notify_export_import_completion"), ['id' => 'notify_export_import_completion', 'dusk' => 'complete_data_transfer_job']) }} <b>@lang('labels.data_transfer_job_completes')</b></label>--}}
{{--        <p class="m-0 p-1"><small class="note">{{ $theUser->getProfileHelp('notify_export_import_completion') }}</small></p>--}}
{{--    </div>--}}

{{--    <div class="checkbox">--}}
{{--        <label style="margin: 0;">{{ Form::checkbox('notify_se_review_completion', 1, $theUser->getProfileValue("notify_se_review_completion"), ['id' => 'notify_se_review_completion', 'dusk' => 'complete_remains_review']) }} <b>@lang('labels.remains_review_completes')</b></label>--}}
{{--        <p class="m-0 p-1"><small class="note">{{ $theUser->getProfileHelp('notify_se_review_completion') }}</small></p>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<h5><b>@lang('labels.notification_methods')</b></h5>--}}
{{--<div class="form-group p-3" style="border: 1px solid #e8ebed;">--}}
{{--    <div class="checkbox">--}}
{{--        <label style="margin: 0;">{{ Form::checkbox('notify_via_email', 1, $theUser->getProfileValue("notify_via_email"), ['id' => 'notify_via_email', 'dusk' => 'email_notification']) }} <b>@lang('labels.email')</b></label>--}}
{{--        <p class="m-0 p-1"><small class="note">{{ $theUser->getProfileHelp('notify_via_email') }}</small></p>--}}
{{--    </div>--}}

{{--    <div class="form-group">--}}
{{--        {!! Form::text('email', $theUser->email, ['class' => 'form-control controlForm', 'readonly', 'style' => 'width:30%;']) !!}--}}
{{--    </div>--}}

{{--    <div class="checkbox">--}}
{{--        <label style="margin: 0;">{{ Form::checkbox('notify_via_sms', 1, $theUser->getProfileValue("notify_via_sms"), ['id' => 'notify_via_sms', 'dusk' => 'sms_notification']) }} <b>@lang('labels.sms_to_mobile')</b></label>--}}
{{--        <p class="m-0 p-1"><small class="note">{{ $theUser->getProfileHelp('notify_via_sms') }}</small></p>--}}
{{--    </div>--}}

{{--    <div class="form-group">--}}
{{--        {!! Form::text('cell_phone', $theUser->cell_phone, ['id' => 'cell_phone', 'class' => 'form-control controlForm', 'readonly', 'style' => 'width:30%;', 'placeholder' => '555-555-5555', 'onblur' => 'phonenumber(cell_phone)', 'maxlength'=>'12', 'dusk' => 'cell_phone']) !!}--}}
{{--    </div>--}}

{{--    <div class="checkbox">--}}
{{--        <label style="margin: 0;">{{ Form::checkbox('notify_via_slack', 1, $theUser->getProfileValue("notify_via_slack"), ['id' => 'notify_via_slack', 'dusk' => 'slack_notification']) }} <b>@lang('labels.slack_notification')</b></label>--}}
{{--        <p class="m-0 p-1"><small class="note">{{ $theUser->getProfileHelp('notify_via_slack') }}</small></p>--}}
{{--    </div>--}}

{{--    <div class="form-group">--}}
{{--        {!! Form::text('slack_channel', $theUser->slack_channel, ['id' => 'slack_channel','class' => 'form-control controlForm', 'readonly', 'placeholder' => 'https://slack.com/myChannel', 'style' => 'width:30%;', 'dusk' => 'slack_channel']) !!}--}}
{{--    </div>--}}
{{--</div>--}}

{{--<button form="notifications_form" class="btn btn-primary" id="notifications-submit" type="submit"  dusk="update_notifications">@lang('labels.update')</button>--}}
{{--{!! Form::close() !!}--}}

{{--@section('footer')--}}
{{--    @parent--}}
{{--    <script>--}}
{{--        // AJAX Request--}}
{{--        $(document).ready(function() {--}}
{{--            $('#notifications-submit').click(function(e){--}}
{{--                e.preventDefault(e);--}}
{{--                // Validating checkbox--}}
{{--                var notify_export_import_completion = $("#notify_export_import_completion");--}}
{{--                if (notify_export_import_completion.is(":checked")) {--}}
{{--                    notify_export_import_completion = 1;--}}
{{--                } else {--}}
{{--                    notify_export_import_completion = 0;--}}
{{--                }--}}
{{--                var notify_se_review_completion = $("#notify_se_review_completion");--}}
{{--                if (notify_se_review_completion.is(":checked")) {--}}
{{--                    notify_se_review_completion = 1;--}}
{{--                } else {--}}
{{--                    notify_se_review_completion = 0;--}}
{{--                }--}}
{{--                var notify_via_email = $("#notify_via_email");--}}
{{--                if (notify_via_email.is(":checked")) {--}}
{{--                    notify_via_email = 1;--}}
{{--                } else {--}}
{{--                    notify_via_email = 0;--}}
{{--                }--}}
{{--                var notify_via_sms = $("#notify_via_sms");--}}
{{--                if (notify_via_sms.is(":checked")) {--}}
{{--                    notify_via_sms = 1;--}}
{{--                } else {--}}
{{--                    notify_via_sms = 0;--}}
{{--                }--}}
{{--                var notify_via_slack = $("#notify_via_slack");--}}
{{--                if (notify_via_slack.is(":checked")) {--}}
{{--                    notify_via_slack = 1;--}}
{{--                } else {--}}
{{--                    notify_via_slack = 0;--}}
{{--                }--}}
{{--                $.ajax({--}}
{{--                    type:"POST",--}}
{{--                    url: '{{ URL::action ('UsersController@updateNotifications', $theUser->id) }}',--}}
{{--                    data:  {notify_export_import_completion: notify_export_import_completion, notify_se_review_completion: notify_se_review_completion,--}}
{{--                        notify_via_email: notify_via_email, notify_via_sms: notify_via_sms, notify_via_slack: notify_via_slack},--}}
{{--                    success: function(data){--}}
{{--                        console.log(data);--}}
{{--                        messageText = "Update Successful";--}}
{{--                        setFlashMessage("success", messageText);--}}
{{--                    },--}}
{{--                    error: function(){--}}
{{--                        messageText = "Notifications Update Failed - Contact Your System Administrator";--}}
{{--                        setFlashMessage("fail", messageText);--}}
{{--                    }--}}
{{--                })--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}
