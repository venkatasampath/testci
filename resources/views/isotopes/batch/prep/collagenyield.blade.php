<div class="iso-batch-process border" style="padding-top: 10px; margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('combined_samples_weight', false) }}{{ Form::checkbox('combined_samples_weight', true, old('combined_samples_weight'),
                    ['class' => 'form-control-checkbox','dusk' =>'iso-combined_samples_weight']) }}@lang('labels.combined_samples_weight')
                </label>
            </div>
        </div>
    </div>

    @if($isotopeBatch->count_weight_collagen < $isotopeBatch->count_samples)
    <div class="alert alert-warning"><h4>
        <div class="form-group">
            {!! Form::label('', 'Count Samples = '.$isotopeBatch->count_samples) !!}<br>
            {!! Form::label('', 'Count Samples Weight Cleaned = '.$isotopeBatch->count_weight_samples_cleaned) !!}<br>
            {!! Form::label('', 'Count Samples with Collagen Weight = '.$isotopeBatch->count_weight_collagen) !!}
        </div>
    </h4></div>
    @else
    <div class="alert alert-success"><h4>
        <div class="form-group">
            {!! Form::label('', 'Count Samples = '.$isotopeBatch->count_samples) !!}<br>
            {!! Form::label('', 'Count Samples Weight Cleaned = '.$isotopeBatch->count_weight_samples_cleaned) !!}<br>
            {!! Form::label('', 'Count Samples with Collagen Weight = '.$isotopeBatch->count_weight_collagen) !!}
        </div>
    </h4></div>
    @endif
</div>
