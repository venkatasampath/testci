{{--<div class="row">--}}
{{--    <div class="col-md-8">--}}
{{--        {{ Form::model($theUser, array('action' => array('UsersController@updateProfile', $theUser->id)), ['id' => 'profile_form'])}}--}}

{{--            <profile--}}
{{--                    :disabled="false"--}}
{{--                    :displayNameLabel= "'Name:'"--}}
{{--                    :emailLabel= "Email:'"--}}
{{--                    :userRoleLabel="Role:'"--}}
{{--                    :cellPhonePlaceholder= "555-555-5555"--}}
{{--                    :cellPhoneLabel= "'Cell Phone:'"--}}
{{--                    :altPhonePlaceholder=  "777-777-7777"--}}
{{--                    :altPhoneLabel= "'Alt Phone:'"--}}
{{--                    :slackChannelPlaceholder= "'https://slack.com/myChannel'",--}}
{{--                    :slackChannelLabel= "'Slack Channel:'",--}}
{{--                    :display_name="{{ $theUser->display_name}} "--}}
{{--                    :default_email="{{json_encode($theUser->email)}}"--}}
{{--                    :role="{{json_encode($theUser->role->name)}}"--}}
{{--                    :cell_phone="{{ json_encode($theUser->cell_phone}}"--}}
{{--                    :phone="{{ json_encode($theUser->phone}}"--}}
{{--                    :slack_channel="{{ json_encode($theUser->slack_channel}}"--}}
{{--                    :profile_photo="{{json_encode($theUser->avatar}}"--}}
{{--                    :user_id="{{$theUser->id}}"--}}
{{--                    :base_url="{{json_encode(url('/'))}}">--}}
{{--            </profile>--}}

{{--        <div class="form-group">--}}
{{--            {!! Form::label('display_name', trans('labels.display_name').':', ['for' => 'display_name']) !!}--}}
{{--            {!! Form::text('display_name', $theUser->display_name, ['id'=> 'display_name', 'class' => 'form-control controlForm', 'dusk' => 'name_text']) !!}--}}
{{--        </div>--}}

{{--        <div class="form-group">--}}
{{--            {!! Form::label('email', trans('labels.email').':', ['for' => 'email']) !!}--}}
{{--            {!! Form::text('email', $theUser->email, ['class' => 'form-control controlForm', 'readonly']) !!}--}}
{{--        </div>--}}

{{--        <div class="form-group">--}}
{{--            {!! Form::label('role', trans('labels.role').':', ['for' => 'role']) !!}--}}
{{--            {!! Form::text('role', $theUser->role['name'], ['class' => 'form-control controlForm', 'readonly']) !!}--}}
{{--        </div>--}}
{{--        <div id="phone_errorDiv" style="width: 37%; background-color: #ff5e5e;">--}}
{{--            <p id="phone_error" style="color: #030126;"></p>--}}
{{--        </div>--}}
{{--        <div class="form-group">--}}
{{--            {!! Form::label('cell_phone', trans('labels.cell_phone').':', ['for' => 'cell_phone']) !!}--}}
{{--            {!! Form::text('cell_phone', $theUser->cell_phone, ['id' => 'cell_phone', 'class' => 'form-control controlForm', 'placeholder' => '555-555-5555', 'onblur' => 'phonenumber(cell_phone)', 'maxlength'=>'12', 'dusk' => 'cell_phone']) !!}--}}
{{--        </div>--}}

{{--        <div class="form-group">--}}
{{--            {!! Form::label('phone', trans('labels.alt_phone').':', ['for' => 'phone']) !!}--}}
{{--            {!! Form::text('phone', $theUser->phone, ['id' => 'phone','class' => 'form-control controlForm', 'placeholder' => '777-777-7777', 'onblur' => 'phonenumber(phone)', 'maxlength'=>'12', 'dusk' => 'phone']) !!}--}}
{{--        </div>--}}

{{--        <div class="form-group">--}}
{{--            {!! Form::label('slack_channel', trans('labels.slack_channel').':', ['for' => 'slack_channel']) !!}--}}
{{--            {!! Form::text('slack_channel', $theUser->slack_channel, ['id' => 'slack_channel','class' => 'form-control controlForm', 'placeholder' => 'https://slack.com/myChannel', 'dusk' => 'slack_channel']) !!}--}}
{{--        </div>--}}

{{--        <button form="profile_form" id="profile-submit" class="btn btn-primary" type="submit" dusk="update_profile">@lang('labels.update')> fgfhfg</button>--}}
{{--        {{ Form::close() }}--}}
{{--    </div>--}}
{{--    <div class="col-md-4">--}}
{{--        <div style="margin-top: 18px;">--}}
{{--            {{ Form::open(array('action' => array('UsersController@uploadProfileImage', $theUser->id), 'enctype' => 'multipart/form-data', 'files' => true), ['id' => 'profileImageForm']) }}--}}
{{--            <div class="form-group">--}}
{{--                <div style="text-align: center">--}}
{{--                    {!! Form::label('profile_photo', trans('labels.profile_photo'), ['for' => 'profile_photo']) !!}--}}
{{--                </div>--}}
{{--                <div style="text-align: left;">--}}
{{--                    <img class="rounded mx-auto d-block" src="{{ $theUser->avatar }}" width="200" height="200" alt="avatar">--}}
{{--                </div>--}}
{{--                <div style="margin-top: 15px; text-align: center">--}}
{{--                    <label class="btn btn-secondary btn-file" style="color: whitesmoke;">--}}
{{--                        @lang('labels.upload_new_photo')--}}
{{--                        {!! Form::file('image', ['id' => "upload-profile-picture",  'class' => 'image', 'style' => "display: none;", 'onchange' => "javascript:this.form.submit();"]) !!}--}}
{{--                    </label>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            {!! Form::close() !!}--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

{{--@section('footer')--}}
{{--    @parent--}}
{{--    <script>--}}
{{--        // Dynamic Phone Validation--}}
{{--        $('#phone, #cell_phone').keyup(function(e) {--}}
{{--            if ((this.value.length < 8) && (e.keyCode > 47 && e.keyCode < 58) || (e.keyCode < 106 && e.keyCode > 95)) {--}}
{{--                this.value = this.value.replace(/(\d{3})\-?/g, '$1-');--}}
{{--                return true;--}}
{{--            }--}}
{{--            //remove all chars, except dash and digits--}}
{{--            this.value = this.value.replace(/[^\-0-9]/g, '');--}}
{{--        });--}}

{{--        // Checks Phone is 10 Digits--}}
{{--        function phonenumber(inputtxt) {--}}
{{--            var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;--}}
{{--            if(inputtxt.value.match(phoneno)) {--}}
{{--                document.getElementById("phone_errorDiv").style.display = "none";--}}
{{--                return true;--}}
{{--            }--}}
{{--            else {--}}
{{--                document.getElementById("phone_errorDiv").style.display = "block";--}}
{{--                document.getElementById("phone_error").innerHTML = "Please Use  555-555-5555  Format for Phone Numbers";--}}
{{--                return false;--}}
{{--            }--}}
{{--        }--}}

{{--        // AJAX Request--}}
{{--        $(document).ready(function() {--}}
{{--            $('#profile-submit').click(function(e){--}}
{{--                e.preventDefault(e);--}}
{{--                $.ajax({--}}
{{--                    type:"POST",--}}
{{--                    url: '{{ URL::action ('UsersController@updateProfile', $theUser->id) }}',--}}
{{--                    data:  {display_name: $("#display_name").val(),--}}
{{--                        phone: $("#phone").val(),--}}
{{--                        cell_phone: $("#cell_phone").val(),--}}
{{--                        slack_channel: $("#slack_channel").val()},--}}
{{--                    success: function(data){--}}

{{--                        messageText = "Profile Update Successful";--}}
{{--                        setFlashMessage("success", messageText);--}}
{{--                    },--}}
{{--                    error: function(){--}}
{{--                        messageText = "Profile Update Failed - Contact Your System Administrator";--}}
{{--                        setFlashMessage("fail", messageText);--}}
{{--                    }--}}
{{--                })--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}
