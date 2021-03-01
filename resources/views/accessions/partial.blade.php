{{  Form::hidden('org_id', $theOrg->id) }}
{{  Form::hidden('project_id', $theProject->id) }}

<div class="form-group required form-group">
    {!! Form::label('project_id', trans('labels.project').':', ['for' => 'type', 'class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('project_name', $theProject->name, ['class' => 'col-md-12 form-control', 'readonly' => 'true','dusk'=>'accession-project-name']) !!}
    </div>
</div>

{{--<div class="form-group" >
    <div class="col-md-6 col-md-offset-4">
        <div class="checkbox">
            <label>{{ Form::hidden('consolidated_an', false) }}{{ Form::checkbox('consolidated_an', true, old('consolidated_an'),
                ['class' => 'form-control-checkbox','dusk' =>'se-consolidated_an']) }}Consolidated AN
            </label>
        </div>
    </div>
</div>--}}

<div class="form-group required form-group">
    {!! Form::label('number', trans('labels.number').':', ['for' => 'number', 'class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('number',null, ['class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_accessionNumber'), 'required' => 'required','dusk'=>'accession-number']) !!}
        <span class="validity"></span>
    </div>
</div>
<div class="form-group">
    {!! Form::label('provenance1', trans('labels.provenance1').':', ['for' => 'provenance1', 'class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('provenance1', null, ['class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_provenance1'), 'dusk'=>'accession-provenance1']) !!}
        <span class="validity"></span>
    </div>
</div>
<div class="form-group">
    {!! Form::label('provenance2', trans('labels.provenance2').':', ['for' => 'provenance2', 'class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('provenance2', null, ['class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_provenance2'), 'dusk'=>'accession-provenance2']) !!}
        <span class="validity"></span>
    </div>
</div>

@if ($CRUD_Action != 'View')
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            {!! Form::button('<i class="fas fa-btn fa-save"></i>'.trans('labels.save'), ['type' => 'submit', 'class' => 'btn btn-primary','dusk'=>'accession-save']) !!}
        </div>
    </div>
@endif

@if(isset($currentlyUsed))
    <div class="alert alert-warning"><h4>@lang('messages.model_in_use', ['model' => 'accession'])</h4></div>
@endif
