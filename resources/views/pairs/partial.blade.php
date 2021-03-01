<div class="form-group form-group{{ $errors->has('compare_method') ? ' has-error' : '' }}" >
    {!! Form::label('compare_method', @trans('labels.compare_method').':', ['for'=>"compare_method",'class'=>'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('compare_method', $pairInfo->pivot->compare_method, ['id'=>'compare_method','class'=>'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_compare_method'), 'disabled', 'dusk' =>'se-pair-match-method']) !!}
        <span class="validity"></span>
        @if ($errors->has('compare_method'))
            <span class="help-block"><strong>{{ $errors->first('compare_method') }}</strong></span>
        @endif
    </div>
</div>

<div class="form-group form-group{{ $errors->has('measurements_used') ? ' has-error' : '' }}" >
    {!! Form::label('measurements_used', @trans('labels.measurements_used').':', ['for'=>"measurements_used",'class'=>'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('measurements_used', $pairInfo->pivot->measurements_used, ['id'=>'measurements_used','class'=>'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_measurements_used'), 'disabled', 'dusk' =>'se-pair-measurements-used']) !!}
        <span class="validity"></span>
        @if ($errors->has('measurements_used'))
            <span class="help-block"><strong>{{ $errors->first('measurements_used') }}</strong></span>
        @endif
    </div>
</div>

<div class="form-group form-group{{ $errors->has('num_measurements') ? ' has-error' : '' }}" >
    {!! Form::label('num_measurements', @trans('labels.num_measurements').':', ['for'=>"num_measurements",'class'=>'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('num_measurements', $pairInfo->pivot->num_measurements, ['id'=>'num_measurements','class'=>'col-md-12 form-control', 'step'=>'1', 'placeholder' => trans('messages.placeholder_num_measurements'), 'disabled', 'dusk' =>'se-pair-num-measurements']) !!}
        <span class="validity"></span>
        @if ($errors->has('num_measurements'))
            <span class="help-block"><strong>{{ $errors->first('num_measurements') }}</strong></span>
        @endif
    </div>
</div>

<div class="form-group form-group{{ $errors->has('sample_size') ? ' has-error' : '' }}" >
    {!! Form::label('sample_size', @trans('labels.sample_size').':', ['for'=>"sample_size",'class'=>'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('sample_size', $pairInfo->pivot->sample_size, ['id'=>'sample_size','class'=>'col-md-12 form-control', 'step'=>'1', 'placeholder' => trans('messages.placeholder_sample_size'), 'disabled', 'dusk' =>'se-pair-sample-size']) !!}
        <span class="validity"></span>
        @if ($errors->has('sample_size'))
            <span class="help-block"><strong>{{ $errors->first('sample_size') }}</strong></span>
        @endif
    </div>
</div>

<div class="form-group form-group{{ $errors->has('pvalue') ? ' has-error' : '' }}" >
    {!! Form::label('pvalue', @trans('labels.pvalue').':', ['for'=>"pvalue",'class'=>'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('pvalue', $pairInfo->pivot->pvalue, ['id'=>'pvalue','class'=>'col-md-12 form-control', 'step'=>'0.01', 'placeholder' => trans('messages.placeholder_pvalue'), 'disabled', 'dusk' =>'se-pair-pvalue']) !!}
        <span class="validity"></span>
        @if ($errors->has('pvalue'))
            <span class="help-block"><strong>{{ $errors->first('pvalue') }}</strong></span>
        @endif
    </div>
</div>

<div class="form-group form-group{{ $errors->has('mean') ? ' has-error' : '' }}" >
    {!! Form::label('mean', @trans('labels.mean').':', ['for'=>"mean",'class'=>'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('mean', $pairInfo->pivot->mean, ['id'=>'mean','class'=>'col-md-12 form-control', 'step'=>'0.01', 'placeholder' => trans('messages.placeholder_mean'), 'disabled', 'dusk' =>'se-pair-mean']) !!}
        <span class="validity"></span>
        @if ($errors->has('mean'))
            <span class="help-block"><strong>{{ $errors->first('mean') }}</strong></span>
        @endif
    </div>
</div>

<div class="form-group form-group{{ $errors->has('sd') ? ' has-error' : '' }}" >
    {!! Form::label('sd', @trans('labels.sd').':', ['for'=>"sd",'class'=>'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('sd', $pairInfo->pivot->sd, ['id'=>'sd','class'=>'col-md-12 form-control', 'step'=>'0.01', 'placeholder' => trans('messages.placeholder_sd'), 'disabled', 'dusk' =>'se-pair-sd']) !!}
        <span class="validity"></span>
        @if ($errors->has('sd'))
            <span class="help-block"><strong>{{ $errors->first('sd') }}</strong></span>
        @endif
    </div>
</div>

<div class="form-group form-group{{ $errors->has('elimination_reason') ? ' has-error' : '' }}" >
    {!! Form::label('elimination_reason', @trans('labels.elimination_reason').':', ['for'=>"elimination_reason",'class'=>'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('elimination_reason',$elimination_reasons, $pairInfo->pivot->elimination_reason, ['id'=>'elimination_reason','class'=>'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_elimination_reason'), 'dusk' =>'se-pair-elimination-reason']) !!}
        <span class="validity"></span>
        @if ($errors->has('elimination_reason'))
            <span class="help-block"><strong>{{ $errors->first('elimination_reason') }}</strong></span>
        @endif
    </div>
</div>

<div class="form-group form-group{{ $errors->has('elimination_date') ? ' has-error' : '' }}" >
    {!! Form::label('elimination_date', @trans('labels.elimination_date').':', ['for'=>"elimination_date",'class'=>'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('elimination_date', $pairInfo->pivot->elimination_date, ['id'=>'elimination_date','class'=>'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_elimination_date'), 'disabled', 'dusk' =>'se-pair-elimination-date']) !!}
        <span class="validity"></span>
        @if ($errors->has('elimination_date'))
            <span class="help-block"><strong>{{ $errors->first('elimination_date') }}</strong></span>
        @endif
    </div>
</div>



@if($CRUD_Action != 'View')
    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            {!! Form::button('<i class="fas fa-btn fa-save"></i>Save', ['type' => 'submit', 'class' => 'btn btn-primary', 'dusk' => 'se-save']) !!}
        </div>
    </div>
@endif