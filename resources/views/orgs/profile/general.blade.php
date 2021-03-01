{{ Form::model($theUser, array('action' => array('UsersController@updateOrgGeneral')), ['id' => 'org_general']) }}
<div class="form-group w-50">
    {!! Form::label('welcome_screen_url', trans('labels.welcome_screen_url').':', ['for' => 'welcome_screen_url']) !!}
    {!! Form::text('welcome_screen_url', ($theOrg->getProfileValue('welcome_screen_url')), ['id'=> 'welcome_screen_url', 'class' => 'form-control', 'dusk' => 'welcome_screen_url'])  !!}
    <p class="m-0 p-1"><small class="note">{{ $theOrg->getProfileHelp('welcome_screen_url') }}</small></p>
</div>

<div class="form-group w-50">
    <div class="checkbox">
        <label>{{ Form::checkbox('add_cora_demo_project_for_new_users', 1, $theOrg->getProfileValue("add_cora_demo_project_for_new_users"), ['id' => 'add_cora_demo_project_for_new_users', 'dusk' => 'add_cora_demo_project_for_new_users']) }}<b>@lang('labels.add_demo_project')</b></label>
        <p class="m-0 p-1"><small class="note">{{ $theOrg->getProfileHelp('add_cora_demo_project_for_new_users') }}</small></p>
    </div>
</div>

<button id="orgGeneral" class="btn btn-primary" type="submit" form="org_general" dusk="update_profile_general"><i class="fas fa-btn fa-save"></i>@lang('labels.update')</button>
{!! Form::close() !!}

@section('footer')
    @parent
    <script>
        // AJAX Request
        $(document).ready(function() {
            $('#orgGeneral').click(function(e){
                e.preventDefault(e);

                // Validating checkbox
                var add_cora_demo_project_for_new_users = $("#add_cora_demo_project_for_new_users");
                if (add_cora_demo_project_for_new_users.is(":checked")) {
                    add_cora_demo_project_for_new_users = 1;
                } else {
                    add_cora_demo_project_for_new_users = 0;
                }

                $.ajax({
                    type:"POST",
                    url: '{{ URL::action ('UsersController@updateOrgGeneral') }}',
                    data:  {welcome_screen_url: $("#welcome_screen_url").val(),
                        add_cora_demo_project_for_new_users: add_cora_demo_project_for_new_users,},
                    success: function(data){
                        console.log(data);
                        messageText = "Update Successful";
                        setFlashMessage("success", messageText);
                    },
                    error: function(){
                        messageText = "General Update Failed - Contact Your System Administrator";
                        setFlashMessage("fail", messageText);
                    }
                })
            });
        });
    </script>
@endsection
