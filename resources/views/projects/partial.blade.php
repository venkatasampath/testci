@if ($CRUD_Action != 'Create')
    <div class="form-group required form-group{{ $errors->has('org_name') ? ' has-error' : '' }}" >
                {!! Form::label('org_name', trans('labels.org').':', ['for'=>'org_name', 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
                        {!! Form::text('org_name', $project->org->name, ['id' => 'org_name', 'placeholder' => 'DPAA', 'class' => 'col-md-12 form-control', 'required' => 'required','dusk' =>'project-org_name']) !!}
            <span class="validity"></span>
            @if ($errors->has('org_name'))
                <span class="help-block"><strong>{{ $errors->first('org_name') }}</strong></span>
            @endif
        </div>
    </div>
@endif

<div class="form-group required form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    {!! Form::label('name', trans('labels.name').':', ['for'=>'name', 'class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
    @if($CRUD_Action == 'Create')
                        {!! Form::text('name', null, ['placeholder' => 'CORA Demo', 'class' => 'col-md-12 form-control', 'required' => 'required','dusk' =>'project-name']) !!}
        @else
                        {!! Form::text('name', null, ['placeholder' => 'CORA Demo', 'class' => 'col-md-12 form-control', 'readonly', 'required' => 'required','dusk' =>'project-name']) !!}
        @endif
        <span class="validity"></span>
        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group required form-group{{ $errors->has('description') ? ' has-error' : '' }}">
    {!! Form::label('description', trans('labels.description').':', ['for'=>'description', 'class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
                {!! Form::text('description', null, ['placeholder' => 'CoRA Demo Project', 'class' => 'col-md-12 form-control', 'required' => 'required','dusk' =>'project-description']) !!}
        <span class="validity"></span>
        @if ($errors->has('description'))
            <span class="help-block">
                <strong>{{ $errors->first('description') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group required form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">
    {!! Form::label('status_id', trans('labels.status').':', ['for'=>'status_id', 'class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
                {{ Form::select('status_id', $list_projectstatus, null, ['id' => 'type', 'class' => 'form-control mav-select','required' => 'required','dusk' =>'project-status']) }}
        <span class="validity"></span>
        @if ($errors->has('status_id'))
            <span class="help-block">
                <strong>{{ $errors->first('status_id') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group required form-group">
        {!! Form::label('start_date', trans('Start Date').':', ['for'=>'start_date', 'class' => 'col-md-4 control-label']) !!}
    @if ($CRUD_Action == 'Create')
        <div class="col-md-6">
                        {!! Form::date('start_date',Carbon::now(), ['class' => 'col-md-12 form-control', 'required' => 'required','dusk'=>'project-start_date']) !!}
            <span class="validity"></span>
        </div>
    @else
        <div class="col-md-6">
                        {!! Form::date('start_date', null, ['class' => 'col-md-12 form-control', 'required' => 'required','dusk'=>'project-start_date']) !!}
            <span class="validity"></span>
        </div>
    @endif
</div>

<div class="form-group required form-group{{ $errors->has('manager_id') ? ' has-error' : '' }}">
    {!! Form::label('manager_id', trans('Manager').':', ['for'=>'manager_id', 'class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
                {{ Form::select('manager_id', $list_manager, null, ['id' => 'type', 'class' => 'form-control mav-select','dusk' =>'project-manager_id', 'required'=>'required']) }}
        @if ($errors->has('manager_id'))
            <span class="help-block">
                <strong>{{ $errors->first('manager_id') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group required form-group{{ $errors->has('geo_lat') ? ' has-error' : '' }}" >
    {!! Form::label('geo_lat', 'Geo Latitude:', ['for'=>'geo_lat', 'class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
                {!! Form::number('geo_lat', null, ['placeholder' => '41.2473820', 'class' => 'col-md-12 form-control','dusk' =>'project-geo_lat','width'=>'5em','step'=>"any", 'required' => 'required']) !!}
        <span class="validity"></span>
        @if ($errors->has('geo_lat'))
            <span class="help-block"><strong>{{ $errors->first('geo_lat') }}</strong></span>
        @endif
    </div>
</div>

<div class="form-group required form-group{{ $errors->has('geo_long') ? ' has-error' : '' }}" >
    {!! Form::label('geo_long', 'Geo Longitude:', ['for'=>'geo_long', 'class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
                {!! Form::number('geo_long', null, ['placeholder' => '-96.0167990', 'class' => 'col-md-12 form-control','dusk' =>'project-geo_long','width'=>'5em','step'=>"any", 'required' => 'required']) !!}
        <span class="validity"></span>
        @if ($errors->has('geo_long'))
            <span class="help-block"><strong>{{ $errors->first('geo_long') }}</strong></span>
        @endif
    </div>
</div>

<div class="form-group {{ $errors->has('slack_channel') ? ' has-error' : '' }}">
    {!! Form::label('slack_channel', trans('labels.slack_channel').':', ['for'=>'slack_channel', 'class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
                {!! Form::text('slack_channel', null, ['placeholder' => 'https://slack.com/projecturl', 'class' => 'col-md-12 form-control','dusk' =>'project-slack_channel']) !!}
        <span class="validity"></span>
        @if ($errors->has('slack_channel'))
            <span class="help-block">
                <strong>{{ $errors->first('slack_channel') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group">
        {!! Form::label('latest_mcc_date', trans('Latest MCC Date').':', ['for'=>'latest_mcc_date', 'class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
                {!! Form::date('latest_mcc_date', null, ['class' => 'col-md-12 form-control', 'dusk'=>'project-latest_mcc_date']) !!}
        <span class="validity"></span>
    </div>
</div>

<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
        <div class="checkbox">
            <label>
                                {{ Form::hidden('public', false) }}{{ Form::checkbox('public', true, old('public'),

                                ['class' => 'form-control-checkbox','dusk' =>'project-public']) }} @lang('labels.public')
            </label>
        </div>
    </div>
</div>

<div class="form-group" >
    <div class="col-md-6 col-md-offset-4">
        <div class="checkbox">
            <label>
                                {{ Form::hidden('allow_user_accession_create', false) }}{{ Form::checkbox('allow_user_accession_create', true, old('allow_user_accession_create'),
                                ['class' => 'form-control-checkbox','dusk' =>'se-allow_user_accession_create']) }}@lang('labels.users_create_accessions')
            </label>
        </div>
    </div>
</div>

<div class="form-group" >
        {!! Form::label('users', trans('labels.assigned_users').':', ['for'=>'assigned_users', 'class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
            {!! Form::select('userlist[]', $list_user, null, ['id' => 'users', 'class' => 'form-control users mav-select', 'multiple','dusk'=>'project-user_list']) !!}
    </div>
</div>

@if($CRUD_Action != 'Create')
    <div class="form-group">
            {!! Form::label('instruments', trans('labels.assigned_instruments').':', ['for' => 'instruments', 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">

                    {!! Form::select('instrumentlist[]', $list_instrument, null, ['id' => 'instruments', 'class' => 'col-md-12 form-control instruments mav-select', 'multiple', 'disabled', 'dusk'=>'project-instrument_list']) !!}
        </div>
    </div>
@endif

{{--@if ($CRUD_Action != 'View')--}}
{{--    <div class="form-group">--}}
{{--        <div class="col-md-6 col-md-offset-4">--}}
{{--            {!! Form::button('<i class="fas fa-btn fa-save"></i>'.trans('labels.save'), ['type' => 'submit', 'class' => 'btn btn-primary', 'dusk' =>'project-save']) !!}--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endif--}}

@if ($CRUD_Action === 'Create')
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            {!! Form::button('<i class="fas fa-btn fa-save"></i>'.trans('labels.save'), ['type' => 'submit', 'class' => 'btn btn-primary', 'dusk' =>'project-save']) !!}
        </div>
    </div>
@else
    {{--View or Update--}}
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            @if ($CRUD_Action === 'Update')
                {!! Form::button('<i class="fas fa-btn fa-save"></i>'.trans('labels.save'), ['type' => 'submit', 'class' => 'btn btn-primary', 'dusk' =>'project-save']) !!}
            @endif
        </div>
    </div>
@endif