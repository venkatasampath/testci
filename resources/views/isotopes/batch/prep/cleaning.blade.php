<div class="iso-batch-process border" style="padding-top: 10px; margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('labeling_tubes', false) }}{{ Form::checkbox('labeling_tubes', true, old('labeling_tubes'),
                    ['class' => 'form-control-checkbox cleanbox','dusk' =>'iso-labeling_tubes']) }}@lang('labels.labeling_tubes')
                </label>
            </div>
        </div>
    </div>

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('rsc', false) }}{{ Form::checkbox('rsc', true, old('rsc'),
                    ['class' => 'form-control-checkbox cleanbox','dusk' =>'iso-rsc']) }}@lang('labels.rsc')
                </label>
            </div>
        </div>
    </div>

    @if ($isotopeBatch->rsc)
        <div class="form-group">
            {!! Form::label('cleaning_start_date', trans('Start Date').':', ['for'=>'cleaning_start_date', 'class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::date('cleaning_start_date', null, ['class'=>'col-md-4 form-control clean','readonly'=>'readonly','dusk'=>'iso-cleaning_start_date']) !!}
                <span class="validity"></span>
            </div>
        </div>
    @endif

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('rinse_samples', false) }}{{ Form::checkbox('rinse_samples', true, old('rinse_samples'),
                    ['class' => 'form-control-checkbox cleanbox','dusk' =>'iso-rinse_samples']) }}@lang('labels.rinse_samples')
                </label>
            </div>
        </div>
    </div>

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('sonicate_samples_dh2o_cycle1', false) }}{{ Form::checkbox('sonicate_samples_dh2o_cycle1', true, old('sonicate_samples_dh2o_cycle1'),
                    ['class' => 'form-control-checkbox cleanbox','dusk' =>'iso-sonicate_samples_dh2o_cycle1']) }}@lang('labels.sonicate_samples_dh2o_cycle1')
                </label>
            </div>
        </div>
    </div>

{{--    @if ($isotopeBatch->sonicate_samples_dh2o_cycle1)--}}
{{--        <div class="form-group">--}}
{{--            {!! Form::label('sonicate_samples_dh2o_cycle1_start_date', trans('Sonicate Samples dH2O Cycle1 Start Date').':', ['for'=>'sonicate_samples_dh2o_cycle1_start_date', 'class' => 'col-md-4 control-label']) !!}--}}
{{--            <div class="col-md-6">--}}
{{--                {!! Form::date('sonicate_samples_dh2o_cycle1_start_date', null, ['class'=>'col-md-4 form-control clean','readonly'=>'readonly','dusk'=>'iso-sonicate_samples_dh2o_cycle1_start_date']) !!}--}}
{{--                <span class="validity"></span>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('sonicate_samples_dh2o_cycle2', false) }}{{ Form::checkbox('sonicate_samples_dh2o_cycle2', true, old('sonicate_samples_dh2o_cycle2'),
                    ['class' => 'form-control-checkbox cleanbox','dusk' =>'iso-sonicate_samples_dh2o_cycle2']) }}@lang('labels.sonicate_samples_dh2o_cycle2')
                </label>
            </div>
        </div>
    </div>

{{--    @if ($isotopeBatch->sonicate_samples_dh2o_cycle2)--}}
{{--        <div class="form-group">--}}
{{--            {!! Form::label('sonicate_samples_dh2o_cycle2_start_date', trans('Sonicate Samples dH2O Cycle2 Start Date').':', ['for'=>'sonicate_samples_dh2o_cycle2_start_date', 'class' => 'col-md-4 control-label']) !!}--}}
{{--            <div class="col-md-6">--}}
{{--                {!! Form::date('sonicate_samples_dh2o_cycle2_start_date', null, ['class'=>'col-md-4 form-control clean','readonly'=>'readonly','dusk'=>'iso-sonicate_samples_dh2o_cycle2_start_date']) !!}--}}
{{--                <span class="validity"></span>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('sonicate_samples_ethanol95', false) }}{{ Form::checkbox('sonicate_samples_ethanol95', true, old('sonicate_samples_ethanol95'),
                    ['class' => 'form-control-checkbox cleanbox','dusk' =>'iso-sonicate_samples_ethanol95']) }}@lang('labels.sonicate_samples_ethanol95')
                </label>
            </div>
        </div>
    </div>

{{--    @if ($isotopeBatch->sonicate_samples_ethanol95)--}}
{{--        <div class="form-group">--}}
{{--            {!! Form::label('sonicate_samples_ethanol95_start_date', trans('Sonicate Samples 95% Ethanol Start Date').':', ['for'=>'sonicate_samples_ethanol95_start_date', 'class' => 'col-md-4 control-label']) !!}--}}
{{--            <div class="col-md-6">--}}
{{--                {!! Form::date('sonicate_samples_ethanol95_start_date', null, ['class'=>'col-md-4 form-control clean','readonly'=>'readonly','dusk'=>'iso-sonicate_samples_ethanol95_start_date']) !!}--}}
{{--                <span class="validity"></span>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('sonicate_samples_ethanol100', false) }}{{ Form::checkbox('sonicate_samples_ethanol100', true, old('sonicate_samples_ethanol100'),
                    ['class' => 'form-control-checkbox cleanbox','dusk' =>'iso-sonicate_samples_ethanol100']) }}@lang('labels.sonicate_samples_ethanol100')
                </label>
            </div>
        </div>
    </div>

{{--    @if ($isotopeBatch->sonicate_samples_ethanol100)--}}
{{--        <div class="form-group">--}}
{{--            {!! Form::label('sonicate_samples_ethanol100_start_date', trans('Sonicate Samples 100% Ethanol Start Date').':', ['for'=>'sonicate_samples_ethanol100_start_date', 'class' => 'col-md-4 control-label']) !!}--}}
{{--            <div class="col-md-6">--}}
{{--                {!! Form::date('sonicate_samples_ethanol100_start_date', null, ['class'=>'col-md-4 form-control clean','readonly'=>'readonly','dusk'=>'iso-sonicate_samples_ethanol100_start_date']) !!}--}}
{{--                <span class="validity"></span>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('dry_samples_start', false) }}{{ Form::checkbox('dry_samples_start', true, old('dry_samples_start'),
                    ['class' => 'form-control-checkbox cleanbox','dusk' =>'iso-dry_samples_start']) }}@lang('labels.dry_samples_start')
                </label>
            </div>
        </div>
    </div>

    @if ($isotopeBatch->dry_samples_start)
{{--    <div class="form-group">--}}
{{--        {!! Form::label('dry_samples_start_date', trans('Dry Samples Start Date').':', ['for'=>'dry_samples_start_date', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::date('dry_samples_start_date', null, ['class'=>'col-md-4 form-control clean','readonly'=>'readonly','dusk'=>'iso-dry_samples_start_date']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('dry_samples_end', false) }}{{ Form::checkbox('dry_samples_end', true, old('dry_samples_end'),
                    ['class' => 'form-control-checkbox cleanbox','dusk' =>'iso-dry_samples_end']) }}@lang('labels.dry_samples_end')
                </label>
            </div>
        </div>
    </div>
    @endif

    @if ($isotopeBatch->dry_samples_end)
    <div class="form-group">
        {!! Form::label('dry_samples_end_date', trans('End Date').':', ['for'=>'dry_samples_end_date', 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::date('dry_samples_end_date', null, ['class' => 'col-md-4 form-control clean','readonly'=>'readonly','dusk'=>'iso-dry_samples_end_date']) !!}
            <span class="validity"></span>
        </div>
    </div>
    @endif

    @if($isotopeBatch->count_weight_samples_cleaned < $isotopeBatch->count_samples)
    <div class="alert alert-warning"><h4>
        <div class="form-group">
            {!! Form::label('', 'Count Samples = '.$isotopeBatch->count_samples) !!}<br>
            {!! Form::label('', 'Count Samples Weight Cleaned = '.$isotopeBatch->count_weight_samples_cleaned) !!}
        </div>
    </h4></div>
    @else
    <div class="alert alert-success"><h4>
        <div class="form-group">
            {!! Form::label('', 'Count Samples = '.$isotopeBatch->count_samples) !!}<br>
            {!! Form::label('', 'Count Samples Weight Cleaned = '.$isotopeBatch->count_weight_samples_cleaned) !!}
        </div>
    </h4></div>
    @endif
</div>
