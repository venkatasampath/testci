@if ($CRUD_Action != 'Create')
    <div class="form-group required form-group{{ $errors->has('org_name') ? ' has-error' : '' }}" >
        {!! Form::label('org_name', trans('labels.org').':', ['for' => 'org_name', 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::text('org_name', $instrument->org->name, ['id' => 'org_name', 'class' => 'col-md-12 form-control', 'required' => 'required','dusk' =>'instrument-org_name']) !!}
            <span class="validity"></span>
            @if ($errors->has('org_name'))
                <span class="help-block"><strong>{{ $errors->first('org_name') }}</strong></span>
            @endif
        </div>
    </div>
@endif

<div class="form-group required form-group{{ $errors->has('code') ? ' has-error' : '' }}" >
    {!! Form::label('name', trans('labels.code').':', ['for' => 'code', 'class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('code', null, ['id' => 'code', 'class' => 'col-md-12 form-control', 'required' => 'required','dusk' =>'instrument-name']) !!}
        <span class="validity"></span>
        @if ($errors->has('code'))
            <span class="help-block">
                <strong>{{ $errors->first('code') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group required form-group{{ $errors->has('category') ? ' has-error' : '' }}">
    {!! Form::label('category', trans('labels.category').':', ['for' => 'category', 'class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('category', null, ['id' => 'category', 'class' => 'col-md-12 form-control', 'required' => 'required','dusk' =>'instrument-category']) !!}
        <span class="validity"></span>
        @if ($errors->has('category'))
            <span class="help-block">
                <strong>{{ $errors->first('category') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group required form-group{{ $errors->has('module') ? ' has-error' : '' }}" >
    {!! Form::label('module', trans('labels.module').':', ['for' => 'module', 'class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('module', null, ['id' => 'module', 'class' => 'col-md-12 form-control', 'required' => 'required','dusk' =>'instrument-module']) !!}
        <span class="validity"></span>
        @if ($errors->has('module'))
            <span class="help-block">
                <strong>{{ $errors->first('module') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('reference') ? ' has-error' : '' }}" >
    {!! Form::label('reference', trans('labels.reference').':', ['for' => 'reference', 'class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('reference', null, ['id' => 'reference', 'class' => 'col-md-12 form-control','dusk' =>'instrument-reference']) !!}
        <span class="validity"></span>
        @if ($errors->has('reference'))
            <span class="help-block">
                <strong>{{ $errors->first('reference') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('userlist[]') ? ' has-error' : '' }}">
    {!! Form::label('userlist', trans('labels.assigned_users').':', ['for' => 'userlist[]', 'class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('userlist[]', $list_user, null, ['id' => 'users', 'class' => 'col-md-12 form-control users mav-select', 'multiple','dusk'=>'instrument-user_list']) !!}
        <span class="validity"></span>
        @if ($errors->has('userlist[]'))
            <span class="help-block">
                <strong>{{ $errors->first('userlist[]') }}</strong>
            </span>
        @endif
    </div>
</div>

@if ($CRUD_Action != 'View')
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            {!! Form::button('<i class="fas fa-btn fa-save"></i>'.trans('labels.save'), ['type' => 'submit', 'class' => 'btn btn-primary','dusk' =>'instrument-save']) !!}
        </div>
    </div>
@endif