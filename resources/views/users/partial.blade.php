@if ($CRUD_Action != 'Create')
    <div class="form-group required form-group{{ $errors->has('org_name') ? ' has-error' : '' }}" >
        {!! Form::label('org_name', trans('labels.org').':', ['for'=>"org_name",'class'=>'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::text('org_name', $user->org->name, ['id'=>'org_name','class'=>'col-md-12 form-control','required'=>'required','dusk'=>'user-organization']) !!}
            <span class="validity"></span>
            @if ($errors->has('org_name'))
                <span class="help-block"><strong>{{ $errors->first('org_name') }}</strong></span>
            @endif
        </div>
    </div>

    <div class="form-group form-group{{ $errors->has('projectlist[]') ? ' has-error' : '' }}" >
        {!! Form::label('projectlist', trans('labels.projects').':', ['for'=>"projectlist[]",'class'=>'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {{ Form::select('projectlist[]', $list_projects, null, ['id' => 'projects', 'class' => 'col-md-12 form-control projects mav-select', 'multiple', 'dusk' => 'user-project_list'])}}
            <span class="validity"></span>
            @if ($errors->has('projectlist[]'))
                <span class="help-block">
                    <strong>{{ $errors->first('projectlist[]') }}</strong>
                </span>
            @endif
        </div>
    </div>
@endif

<div class="form-group required form-group{{ $errors->has('first_name') ? ' has-error' : '' }}" >
    {!! Form::label('first_name', trans('labels.first_name').':', ['for'=>"first_name",'class'=>'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('first_name', null, ['id'=>'first_name','class'=>'col-md-12 form-control','placeholder' => 'John','required'=>'required','dusk'=>'user-first_name']) !!}
        <span class="validity"></span>
        @if ($errors->has('first_name'))
            <span class="help-block">
                <strong>{{ $errors->first('first_name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group required form-group{{ $errors->has('last_name') ? ' has-error' : '' }}" >
    {!! Form::label('last_name', trans('labels.last_name').':', ['for'=>"last_name",'class'=>'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('last_name', null, ['id'=>'last_name','class'=>'col-md-12 form-control','placeholder' => 'Smith', 'required'=>'required','dusk'=>'user-last_name']) !!}
        <span class="validity"></span>
        @if ($errors->has('last_name'))
            <span class="help-block">
                <strong>{{ $errors->first('last_name') }}</strong>
            </span>
        @endif
    </div>
</div>

@if( $CRUD_Action != 'Create')
    <div class="form-group form-group{{ $errors->has('display_name') ? ' has-error' : '' }}" >
        {!! Form::label('display_name', trans('labels.display_name').':', ['for'=>"display_name",'class'=>'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::text('display_name', null, ['id'=>'display_name','class'=>'col-md-12 form-control','placeholder' => 'John Smith','dusk'=>'user-display_name']) !!}
            <span class="validity"></span>
            @if ($errors->has('display_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('display_name') }}</strong>
                </span>
            @endif
        </div>
    </div>
@endif

<div class="form-group required form-group{{ $errors->has('email') ? ' has-error' : '' }}" >
    {!! Form::label('email', trans('labels.email_address').':', ['for'=>"email",'class'=>'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('email', null, ['id'=>"email",'class'=>'col-md-12 form-control','placeholder' => 'jsmith@gmail.com', 'required'=>'required','dusk'=>'user-email']) !!}
        <span class="validity"></span>
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group form-group{{ $errors->has('cell_phone') ? ' has-error' : '' }}" >
    {!! Form::label('cell_phone', trans('labels.cell_phone').':', ['for'=>"cell_phone",'class'=>'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('cell_phone', null, ['id'=>"cell_phone",'class'=>'col-md-12 form-control','placeholder' => '555-555-5555', 'onblur' => 'phonenumber(cell_phone)', 'maxlength'=>'12','dusk'=>'user-cell_phone']) !!}
        <span class="validity"></span>
        @if ($errors->has('cell_phone'))
            <span class="help-block">
                <strong>{{ $errors->first('cell_phone') }}</strong>
            </span>
        @endif
    </div>
</div>

@if($CRUD_Action != 'Create')
    <div class="form-group form-group{{ $errors->has('phone') ? ' has-error' : '' }}" >
        {!! Form::label('phone', trans('labels.alt_phone').':', ['for'=>"phone",'class'=>'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::text('phone', null, ['id'=>"phone",'class'=>'col-md-12 form-control','placeholder' => '777-777-7777', 'onblur' => 'phonenumber(phone)', 'maxlength'=>'12','dusk'=>'user-phone']) !!}
            <span class="validity"></span>
            @if ($errors->has('phone'))
                <span class="help-block">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
            @endif
        </div>
    </div>
@endif

<div class="form-group" >
    <div class="col-md-6 col-md-offset-4">
        <div class="checkbox" >
            <label>
                {{ Form::hidden('active', false) }}{{ Form::checkbox('active', true, old('active'),
                ['class'=>'form-control-checkbox','dusk'=>'user-active']) }} @lang('labels.active')
            </label>
        </div>
    </div>
</div>

<div class="form-group required form-group{{ $errors->has('role_id') ? ' has-error' : '' }}" >
    {!! Form::label('role_id', trans('labels.roles').':', ['for'=>"role",'class'=>'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {{ Form::select('role_id', $list_role, null, ['id'=>'role','class'=>'mav-select form-control controlForm','dusk'=>'user-role']) }}
        <span class="validity"></span>
        @if ($errors->has('role_id'))
            <span class="help-block">
                <strong>{{ $errors->first('role_id') }}</strong>
            </span>
        @endif
    </div>
</div>

@if($CRUD_Action != 'Create')
    <div class="form-group form-group{{ $errors->has('default_country') ? ' has-error' : '' }}" >
        {!! Form::label('default_country', trans('labels.default_country').':', ['for'=>"default_country",'class'=>'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {{ Form::select('default_country', $country_array, null, ['id' => 'default_country', 'class' => "mav-select form-control controlForm", 'dusk' => 'default_country'])}}
            <span class="validity"></span>
            @if ($errors->has('default_country'))
                <span class="help-block">
                    <strong>{{ $errors->first('default_country') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group form-group{{ $errors->has('default_language') ? ' has-error' : '' }}" >
        {!! Form::label('default_language', trans('labels.default_language').':', ['for'=>"default_language",'class'=>'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {{ Form::select('default_language', $language_codes, null, ['id' => 'default_language', 'class' => "mav-select form-control controlForm", 'dusk' => 'default_language'])}}
            <span class="validity"></span>
            @if ($errors->has('default_language'))
                <span class="help-block">
                    <strong>{{ $errors->first('default_language') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group form-group{{ $errors->has('default_timezone') ? ' has-error' : '' }}" >
        {!! Form::label('default_timezone', trans('labels.default_time_zone').':', ['for'=>"default_timezone",'class'=>'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {{ Form::select('default_timezone', $timezone_array, null, ['id' => 'default_timezone', 'class' => "mav-select form-control controlForm", 'dusk' => 'default_timezone'])}}
            <span class="validity"></span>
            @if ($errors->has('default_timezone'))
                <span class="help-block">
                    <strong>{{ $errors->first('default_timezone') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group form-group{{ $errors->has('instrumentlist[]') ? ' has-error' : '' }}" >
        {!! Form::label('instrumentlist', trans_choice('labels.instruments', 10).':', ['for'=>"instrumentlist[]",'class'=>'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {{ Form::select('instrumentlist[]', $list_instrument, null, ['id' => 'instruments', 'class' => 'col-md-12 form-control users mav-select', 'multiple', 'dusk' => 'user-instrument_list'])}}
            <span class="validity"></span>
            @if ($errors->has('instrumentlist[]'))
                <span class="help-block">
                    <strong>{{ $errors->first('instrumentlist[]') }}</strong>
                </span>
            @endif
        </div>
    </div>
@endif

@if($CRUD_Action == 'Create')
    <div class="form-group required form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        {{--<label class="col-md-4 control-label">@lang('labels.password'):</label>--}}
        {!! Form::label('password', trans('labels.password').':', ['for'=>"password",'class'=>'col-md-4 control-label']) !!}
        <div class="col-md-6">
            <input type="password" class="form-control" name="password" dusk="user-password">
            @if ($errors->has('password'))
                <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
            @endif
        </div>
    </div>

    <div class="form-group required form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        {!! Form::label('password_confirmation', trans('labels.confirm_password').':', ['for'=>"password_confirmation",'class'=>'col-md-4 control-label']) !!}
        <div class="col-md-6">
            <input type="password" class="form-control" name="password_confirmation" dusk="user-password_confirmation">
            @if ($errors->has('password_confirmation'))
                <span class="help-block"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
            @endif
        </div>
    </div>
@endif

@if ($CRUD_Action === 'Create')
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            {!! Form::button('<i class="fas fa-btn fa-save"></i>'.trans('labels.save'), ['type'=>'submit', 'class'=>'btn btn-primary','dusk'=>'user-save']) !!}
        </div>
    </div>
@else
    {{--View or Update--}}
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            @if ($CRUD_Action === 'Update')
                {!! Form::button('<i class="fas fa-btn fa-save"></i>'.trans('labels.save'), ['type'=>'submit', 'class'=>'btn btn-primary','dusk'=>'user-save']) !!}
            @endif

            @if ($CRUD_Action === 'Update')
                <a href= "{{ url('/users/' . $user->id . '/passwordbyadmin') }}" class="btn btn-primary"><i class="fas fa-btn fa-key"></i>@lang('labels.reset_password')</a>
            @else
                <a href= "" class="btn btn-secondary disabled"><i class="fas fa-btn fa-key"></i>@lang('labels.reset_password')</a>
            @endif

            @if ($CRUD_Action === 'Update')
                @if(!isset($user->last_login_at))
                    <a href= "" class="btn btn-secondary disabled"><i class="fas fa-btn fa-unlock"></i>@lang('labels.never_logged_in')</a>
                @elseif($last_user_activity_in_days > config('auth.login.maxInactiveDays'))
                    <a href= "{{ url('/users/' . $user->id . '/inactivitypasswordbyadmin') }}" class="btn btn-primary"><i class="fas fa-btn fa-user-lock"></i>@lang('labels.reset') @lang('labels.inactivity_lock', ['days'=>$last_user_activity_in_days])</a>
                @else
                    <a href= "" class="btn btn-secondary disabled"><i class="fas fa-btn fa-unlock"></i>@lang('labels.last_activity_at', ['at'=>Carbon::parse($user->last_login_at)->format('Y-m-d')])</a>
                @endif
            @else
                @if(!isset($user->last_login_at))
                    <a href= "" class="btn btn-secondary disabled"><i class="fas fa-btn fa-unlock"></i>@lang('labels.never_logged_in')</a>
                @elseif($last_user_activity_in_days > config('auth.login.maxInactiveDays'))
                    <a href= "" class="btn btn-secondary disabled"><i class="fas fa-btn fa-user-lock"></i>@lang('labels.reset') @lang('labels.inactivity_lock', ['days'=>$last_user_activity_in_days])</a>
                @else
                    <a href= "" class="btn btn-secondary disabled"><i class="fas fa-btn fa-unlock"></i>@lang('labels.last_activity_at', ['at'=>Carbon::parse($user->last_login_at)->format('Y-m-d')])</a>
                @endif
            @endif
        </div>
    </div>
@endif
