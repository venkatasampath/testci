<div class="iso-batch-process border" style="padding-top: 10px; margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('fdc_on', false) }}{{ Form::checkbox('fdc_on', true, old('fdc_on'),
                    ['class' => 'form-control-checkbox fdbox','dusk' =>'iso-fdc_on']) }}@lang('labels.fdc_on')
                </label>
            </div>
        </div>
    </div>

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('fdc_samples_start', false) }}{{ Form::checkbox('fdc_samples_start', true, old('fdc_samples_start'),
                    ['class' => 'form-control-checkbox fdbox','dusk' =>'iso-fdc_samples_start']) }}@lang('labels.fdc_samples_start')
                </label>
            </div>
        </div>
    </div>

    @if ($isotopeBatch->fdc_samples_start)
    <div class="form-group">
        {!! Form::label('fdc_samples_start_date', trans('Freeze-Dry Samples Start Date').':', ['for'=>'fdc_samples_start_date', 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::date('fdc_samples_start_date', null, ['class' => 'col-md-4 form-control fd','readonly'=>'readonly','dusk'=>'iso-fdc_samples_start_date']) !!}
            <span class="validity"></span>
        </div>
    </div>
    @endif

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('fdc_samples_end', false) }}{{ Form::checkbox('fdc_samples_end', true, old('fdc_samples_end'),
                    ['class' => 'form-control-checkbox fdbox','dusk' =>'iso-fdc_samples_end']) }}@lang('labels.fdc_samples_end')
                </label>
            </div>
        </div>
    </div>

    @if ($isotopeBatch->fdc_samples_end)
    <div class="form-group">
        {!! Form::label('fdc_samples_end_date', trans('Freeze-Dry Samples End Date').':', ['for'=>'fdc_samples_end_date', 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::date('fdc_samples_end_date', null, ['class' => 'col-md-4 form-control fd','readonly'=>'readonly','dusk'=>'iso-fdc_samples_end_date']) !!}
            <span class="validity"></span>
        </div>
    </div>
    @endif
</div>
