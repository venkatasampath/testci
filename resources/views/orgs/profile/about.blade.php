{{ Form::open(array('action' => array('UsersController@updateOrgAbout')), ['id' => 'org_about'])}}

<div class=" form-group w-50">
    {!! Form::label('org_name', trans('labels.organization_name').':', ['for' => 'org_name']) !!}
    {!! Form::text('org_name', $theOrg->name, ['id'=> 'org_name', 'class' => 'form-control', 'dusk' => 'name_text']) !!}
</div>

<div class=" form-group w-50">
    {!! Form::label('org_acronym', trans('labels.organization_acronym').':', ['for' => 'org_acronym']) !!}
    {!! Form::text('org_acronym', $theOrg->acronym, ['id'=>'org_acronym', 'class' => 'form-control', 'dusk' => 'org_acronym', 'readonly']) !!}
</div>

<div class=" form-group w-50">
    {!! Form::label('org_description', trans('labels.organization_description').':', ['for' => 'org_description']) !!}
    {!! Form::textarea('org_description', $theOrg->description, ['id' => 'org_description','class' => 'form-control controlForm', 'dusk' => 'org_description']) !!}
</div>

<div class=" form-group w-50">
    {!! Form::label('address', trans('labels.address').':', ['for' => 'address']) !!}
    {!! Form::text('address', $theOrg->address, ['id'=> 'address', 'class' => 'form-control', 'dusk' => 'address']) !!}
</div>

<div class=" form-group w-50">
    {!! Form::label('city', trans('labels.city').':', ['for' => 'city']) !!}
    {!! Form::text('city', $theOrg->city, ['id'=> 'city', 'class' => 'form-control', 'dusk' => 'city']) !!}
</div>

<div class=" form-group w-50">
    {!! Form::label('state', trans('labels.state').':', ['for' => 'state']) !!}
    {!! Form::text('state', $theOrg->state, ['id'=> 'state', 'class' => 'form-control', 'dusk' => 'state']) !!}
</div>

<div class=" form-group w-50">
    {!! Form::label('zip', trans('labels.zip').':', ['for' => 'zip']) !!}
    {!! Form::text('zip', $theOrg->zip, ['id'=> 'zip', 'class' => 'form-control',  'dusk' => 'zip']) !!}
</div>

<div class=" form-group w-50">
    {!! Form::label('website', trans('labels.website_url').':', ['for' => 'website']) !!}
    {!! Form::text('website', $theOrg->website, ['id'=> 'website', 'class' => 'form-control', 'dusk' => 'website']) !!}
</div>

<div class=" form-group w-50">
    {!! Form::label('phone', trans('labels.phone').':', ['for' => 'phone']) !!}
    {!! Form::text('phone', $theOrg->phone, ['placeholder' => '555-555-5555', 'onblur' => 'phonenumber(cell_phone)', 'maxlength'=>'12', 'id'=> 'phone', 'class' => 'form-control', 'dusk' => 'phone']) !!}
</div>

<div class=" form-group w-50">
    {!! Form::label('tfphone', trans('labels.toll_free_phone').':', ['for' => 'tfphone']) !!}
    {!! Form::text('tfphone', $theOrg->toll_free, ['placeholder' => '555-555-5555', 'onblur' => 'phonenumber(cell_phone)', 'maxlength'=>'12', 'id'=> 'tfphone', 'class' => 'form-control', 'dusk' => 'tfphone']) !!}
</div>

<div class=" form-group w-50">
    {!! Form::label('fax', trans('labels.fax').':', ['for' => 'fax']) !!}
    {!! Form::text('fax', $theOrg->fax, ['placeholder' => '555-555-5555', 'onblur' => 'phonenumber(cell_phone)', 'maxlength'=>'12', 'id'=> 'fax', 'class' => 'form-control', 'dusk' => 'fax']) !!}
</div>

<div class=" form-group w-50">
    {!! Form::label('contact_name', trans('labels.contact_name').':', ['for' => 'contact_name']) !!}
    {!! Form::text('contact_name', $theOrg->contact_name, ['placeholder' => 'John Doe', 'id'=> 'contact_name', 'class' => 'form-control', 'dusk' => 'contact_name']) !!}
</div>

<div class=" form-group w-50">
    {!! Form::label('contact_email', trans('labels.contact_email').':', ['for' => 'contact_email']) !!}
    {!! Form::text('contact_email', $theOrg->contact_email, ['placeholder' => 'johndoe@gmail.com', 'id'=> 'contact_email', 'class' => 'form-control', 'dusk' => 'contact_email']) !!}
</div>

<div class=" form-group w-50">
    {!! Form::label('latitude', trans('labels.geo_lat').':', ['for' => 'latitude']) !!}
    {!! Form::text('lat', $theOrg->geo_lat, ['id'=> 'lat', 'class' => 'form-control',  'dusk' => 'lat']) !!}
</div>

<div class=" form-group w-50">
    {!! Form::label('longitude', trans('labels.geo_long').':', ['for' => 'longitude']) !!}
    {!! Form::text('long', $theOrg->geo_long, ['id'=> 'long', 'class' => 'form-control', 'dusk' => 'long']) !!}
</div>

<button form="org_about" id="org-about-submit" class="btn btn-primary" type="submit" dusk="update_profile"><i class="fas fa-btn fa-save"></i>@lang('labels.update')</button>
{{ Form::close() }}

@section('footer')
    @parent
    <script>
        // AJAX Request
        $(document).ready(function() {
            $('#org-about-submit').click(function(e){
                e.preventDefault(e);
                $.ajax({
                    type:"POST",
                    url: '{{ URL::action ('UsersController@updateOrgAbout', Auth::user()) }}',
                    data:  {org_name: $("#org_name").val(),
                        org_description: $("#org_description").val(),
                        address: $("#address").val(),
                        city: $("#city").val(),
                        state: $("#state").val(),
                        zip: $("#zip").val(),
                        website: $("#website").val(),
                        phone: $("#phone").val(),
                        tfphone: $("#tfphone").val(),
                        fax: $("#fax").val(),
                        lat: $("#lat").val(),
                        long: $("#long").val()},
                    success: function(data){
                        console.log(data);
                        messageText = "Profile Update Successful";
                        setFlashMessage("success", messageText);
                    },
                    error: function(){
                        messageText = "Organization Update Failed - Contact Your System Administrator";
                        setFlashMessage("fail", messageText);
                    }
                })
            });
        });

        // Dynamic Phone Validation
        $('#phone, #tfphone, #fax').keyup(function(e) {
            if ((this.value.length < 8) && (e.keyCode > 47 && e.keyCode < 58) || (e.keyCode < 106 && e.keyCode > 95)) {
                this.value = this.value.replace(/(\d{3})\-?/g, '$1-');
                return true;
            }
            //remove all chars, except dash and digits
            this.value = this.value.replace(/[^\-0-9]/g, '');
        });
    </script>
@endsection
