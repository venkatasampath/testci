{{ Form::model($theUser, array('action' => array('UsersController@updateOrgApiKeys')), ['id' => 'projects_form']) }}
<div class="form-group w-50">
    {!! Form::label('slack_webhook', trans('labels.slack_webhook').':', ['for' => 'slack_webhook']) !!}
    {!! Form::text('org_api_slack_webhook', ($theOrg->getProfileValue('org_api_slack_webhook')), ['id'=> 'org_api_slack_webhook', 'class' => 'form-control', 'dusk' => 'org_api_slack_webhook'])  !!}
    <p class="m-0 p-1"><small class="note">{{ $theOrg->getProfileHelp('org_api_slack_webhook') }}</small></p>
</div>

<div class="form-group w-50">
    {!! Form::label('slack_channel', trans('labels.slack_channel').':', ['for' => 'slack_channel']) !!}
    {!! Form::text('org_api_slack_channel', ($theOrg->getProfileValue('org_api_slack_channel')), ['id'=> 'org_api_slack_channel', 'class' => 'form-control', 'dusk' => 'org_api_slack_channel'])  !!}
    <p class="m-0 p-1"><small class="note">{{ $theOrg->getProfileHelp('org_api_slack_channel') }}</small></p>
</div>

<div class="form-group w-50">
    {!! Form::label('google_maps', trans('labels.google_maps').':', ['for' => 'google_maps']) !!}
    {!! Form::text('org_api_google_maps', ($theOrg->getProfileValue('org_api_google_maps')), ['id'=> 'org_api_google_maps', 'class' => 'form-control', 'dusk' => 'org_api_google_maps'])  !!}
    <p class="m-0 p-1"><small class="note">{{ $theOrg->getProfileHelp('org_api_google_maps') }}</small></p>
</div>

<button form="apikeys_form" id="apikeys-submit" class="btn btn-primary" type="submit" dusk="update_profile"><i class="fas fa-btn fa-save"></i>@lang('labels.update')</button>
{{ Form::close() }}

@section('footer')
    @parent
    <script>
    // AJAX Request
    $(document).ready(function() {
        $('#apikeys-submit').click(function(e){
            e.preventDefault(e);
            $.ajax({
                type:"POST",
                url: '{{ URL::action ('UsersController@updateOrgApiKeys') }}',
                data:  {org_api_slack_channel: $("#org_api_slack_channel").val(),
                    org_api_slack_webhook: $("#org_api_slack_webhook").val(),
                    org_api_google_maps: $("#org_api_google_maps").val() },
                success: function(data){
                    console.log(data);
                    messageText = "Profile Update Successful";
                    setFlashMessage("success", messageText);
                },
                error: function(){
                    messageText = "Profile Update Failed - Contact Your System Administrator";
                    setFlashMessage("fail", messageText);
                }
            })
        });
    });
    </script>
@endsection

