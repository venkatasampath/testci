{{ Form::model($theUser, array('action' => array('UsersController@updateOrgLocalization')), ['id' => 'localization_form'])}}
<div class="form-group">
    {!! Form::label('home_country', trans('labels.home_country').':', ['for' => 'home_country']) !!}
    <div>
    {{ Form::select('country', $country_array, $theOrg->default_country, ['id' => 'default_country', 'class' => 'mav-select form-control controlForm', 'style' => "width: 30%", 'dusk' => 'default_country'])}}
    </div>
</div>

<div class="form-group">
    {!! Form::label('default_language', trans('labels.default_language').':', ['for' => 'default_language']) !!}
    <div>
    {{ Form::select('language', $language_codes, $theOrg->default_language, ['id' => 'default_language', 'class' => 'mav-select form-control controlForm', 'style' => "width: 30%", 'dusk' => 'default_language'])}}
    </div>
</div>

<div class="form-group">
    {!! Form::label('default_timezone', trans('labels.default_time_zone').':', ['for' => 'default_timezone']) !!}
    <div>
    {{ Form::select('timezone', $timezone_array, $theOrg->default_timezone, ['id' => 'default_timezone', 'class' => "mav-select form-control controlForm", 'style' => "width: 30%", 'dusk' => 'default_timezone'])}}
    </div>
</div>

<button form="localization_form" class="btn btn-primary" id="localization-submit" type="submit" dusk="update_profile_localization"><i class="fas fa-btn fa-save"></i>@lang('labels.update')</button>
{!! Form::close() !!}

@section('footer')
    @parent
    <script>
        // AJAX Request
        $(document).ready(function() {
            $('#localization-submit').click(function(e){
                e.preventDefault(e);
                $.ajax({
                    type:"POST",
                    url: '{{ URL::action ('UsersController@updateOrgLocalization') }}',
                    data: {default_country: $("#default_country").val(),
                        default_language: $("#default_language").val(),
                        default_timezone: $("#default_timezone").val(),},
                    success: function(data){
                        console.log(data);
                        messageText = "Localization Settings Updated Successfully";
                        setFlashMessage("success", messageText);
                    },
                    error: function(){
                        messageText = "Localization Settings Update Failed - Contact Your System Administrator";
                        setFlashMessage("fail", messageText);
                    }
                })
            });
        });
    </script>
@endsection
