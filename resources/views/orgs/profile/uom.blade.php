{{ Form::model($theUser, array('action' => array('UsersController@updateOrgMeasurements')), ['id' => 'projects_form']) }}
<div class="form-group w-50">
    {!! Form::label('mass_unit', trans('labels.mass_unit').':', ['for' => 'mass_unit']) !!}
    <div>
        {{ Form::select('org_mass_unit_of_measure', json_decode($theOrg->getProfileDisplayValues('org_mass_unit_of_measure')), $theOrg->getProfileValue('org_mass_unit_of_measure'), ['id'=>'org_mass_unit_of_measure', 'class'=>'form-control controlForm mav-select', 'style' => "width: 30%", 'dusk'=>'org_mass_unit_of_measure']) }}
    </div>
    <p class="m-0 p-1"><small class="note">{{ $theOrg->getProfileHelp('org_mass_unit_of_measure') }}</small></p>
</div>

<div class="form-group w-50">
    {!! Form::label('length_unit', trans('labels.length_unit').':', ['for' => 'length_unit']) !!}
    <div>
        {{ Form::select('org_length_unit_of_measure', json_decode($theOrg->getProfileDisplayValues('org_length_unit_of_measure')), $theOrg->getProfileValue('org_length_unit_of_measure'), ['id'=>'org_length_unit_of_measure', 'class'=>'form-control controlForm mav-select', 'style' => "width: 30%", 'dusk'=>'org_length_unit_of_measure']) }}
    </div>
    <p class="m-0 p-1"><small class="note">{{ $theOrg->getProfileHelp('org_length_unit_of_measure') }}</small></p>
</div>

<button form="uom_form" id="uom-submit" class="btn btn-primary" type="submit" dusk="update_profile_uom"><i class="fas fa-btn fa-save"></i>@lang('labels.update')</button>
{{ Form::close() }}

@section('footer')
    @parent
    <script>
        // AJAX Request
        $(document).ready(function() {
            $('#uom-submit').click(function(e){
                e.preventDefault(e);

                $.ajax({
                    type:"POST",
                    url: '{{ URL::action ('UsersController@updateOrgMeasurements') }}',
                    data:  {org_mass_unit_of_measure: $("#org_mass_unit_of_measure").val(),
                        org_length_unit_of_measure: $("#org_length_unit_of_measure").val()},
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
