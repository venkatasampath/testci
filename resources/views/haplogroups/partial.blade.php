<div class="form-group required form-group{{ $errors->has('type') ? ' has-error' : '' }}">
    {!! Form::label('type', trans('labels.type').':', ['for'=>'type', 'class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {{ Form::select('type', $list_type, null, ['id' => 'type', 'class' => 'form-control mav-select','required' => 'required','dusk' =>'type']) }}
        <span class="validity"></span>
        @if ($errors->has('type'))
            <span class="help-block">
                <strong>{{ $errors->first('type') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group required form-group{{ $errors->has('letter') ? ' has-error' : '' }}">
    {!! Form::label('letter', trans('labels.letter').':', ['for'=>'letter', 'class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('letter', null, ['placeholder' => '', 'class' => 'col-md-12 form-control', 'required' => 'required','dusk' =>'letter']) !!}
        <span class="validity"></span>
        @if ($errors->has('letter'))
            <span class="help-block">
                <strong>{{ $errors->first('letter') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group form-group{{ $errors->has('subgroup') ? ' has-error' : '' }}">
    {!! Form::label('subgroup', trans('labels.subgroup').':', ['for'=>'subgroup', 'class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('subgroup', null, ['placeholder' => '', 'class' => 'col-md-12 form-control', 'dusk' =>'subgroup']) !!}
        <span class="validity"></span>
        @if ($errors->has('subgroup'))
            <span class="help-block">
                <strong>{{ $errors->first('subgroup') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group form-group{{ $errors->has('ancestry') ? ' has-error' : '' }}">
    {!! Form::label('ancestry', trans('labels.ancestry').':', ['for'=>'ancestry', 'class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('ancestry', $list_ancestry, null, ['placeholder' => '', 'class' => 'form-control mav-select', 'dusk' =>'ancestry']) !!}
        <span class="validity"></span>
        @if ($errors->has('ancestry'))
            <span class="help-block">
                <strong>{{ $errors->first('ancestry') }}</strong>
            </span>
        @endif
    </div>
</div>

@if ($CRUD_Action != 'View')
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            {!! Form::button('<i class="fas fa-btn fa-save"></i>'.trans('labels.save'), ['type' => 'submit', 'class' => 'btn btn-primary','dusk'=>'haplogroup-save']) !!}
        </div>
    </div>
@endif