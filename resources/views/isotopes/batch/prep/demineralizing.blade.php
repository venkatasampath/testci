<div class="iso-batch-process border" style="padding-top: 10px; margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('demineralizing_treatment_start', false) }}{{ Form::checkbox('demineralizing_treatment_start', true, old('demineralizing_treatment_start'),
                    ['class' => 'form-control-checkbox deminbox','dusk' =>'iso-demineralizing_treatment_start']) }}@lang('labels.demineralizing_treatment_start')
                </label>
            </div>
        </div>
    </div>

    @if ($isotopeBatch->demineralizing_treatment_start)
    <div class="form-group">
        {!! Form::label('demineralizing_treatment_start_date', trans('Demineralizing Treatment Start Date').':', ['for'=>'demineralizing_treatment_start_date', 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::date('demineralizing_treatment_start_date', null, ['class'=>'col-md-4 form-control demin','readonly'=>'readonly','dusk'=>'iso-demineralizing_treatment_start_date']) !!}
            <span class="validity"></span>
        </div>
    </div>

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('demineralizing_treatment_end', false) }}{{ Form::checkbox('demineralizing_treatment_end', true, old('demineralizing_treatment_end'),
                ['class' => 'form-control-checkbox deminbox','dusk' =>'iso-demineralizing_treatment_end']) }}@lang('labels.demineralizing_treatment_end')
                </label>
            </div>
        </div>
    </div>
    @endif

    @if ($isotopeBatch->demineralizing_treatment_end)
    <div class="form-group">
        {!! Form::label('demineralizing_treatment_end_date', trans('Demineralizing Treatment End Date').':', ['for'=>'demineralizing_treatment_end_date', 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::date('demineralizing_treatment_end_date', null, ['class' => 'col-md-4 form-control demin','readonly'=>'readonly','dusk'=>'iso-demineralizing_treatment_end_date']) !!}
            <span class="validity"></span>
        </div>
    </div>
    @endif

    @if ($isotopeBatch->demineralizing_treatment_start && $isotopeBatch->demineralizing_treatment_end)
    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('rinse_demineralized_samples', false) }}{{ Form::checkbox('rinse_demineralized_samples', true, old('rinse_demineralized_samples'),
                    ['class' => 'form-control-checkbox deminbox','dusk' =>'iso-rinse_demineralized_samples']) }}@lang('labels.rinse_demineralized_samples')
                </label>
            </div>
        </div>
    </div>
    @endif
</div>