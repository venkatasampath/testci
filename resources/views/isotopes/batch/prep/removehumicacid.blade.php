<div class="iso-batch-process border" style="padding-top: 10px; margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('rha_treatment_start', false) }}{{ Form::checkbox('rha_treatment_start', true, old('rha_treatment_start'),
                    ['class' => 'form-control-checkbox rhabox','dusk' =>'iso-rha_treatment_start']) }}@lang('labels.rha_treatment_start')
                </label>
            </div>
        </div>
    </div>

    @if ($isotopeBatch->rha_treatment_start)
    <div class="form-group">
        {!! Form::label('rha_treatment_start_date', trans('Removing Humic Acids Start Date').':', ['for'=>'rha_treatment_start_date', 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::date('rha_treatment_start_date', null, ['class' => 'col-md-4 form-control rha','readonly'=>'readonly','dusk'=>'iso-rha_treatment_start_date']) !!}
            <span class="validity"></span>
        </div>
    </div>
    @endif

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('rha_sample_rinse1_start', false) }}{{ Form::checkbox('rha_sample_rinse1_start', true, old('rha_sample_rinse1_start'),
                    ['class' => 'form-control-checkbox rhabox','dusk' =>'iso-rha_sample_rinse1_start']) }}@lang('labels.rha_sample_rinse1_start')
                </label>
            </div>
        </div>
    </div>

    @if ($isotopeBatch->rha_sample_rinse1_start)
    <div class="form-group">
        {!! Form::label('rha_sample_rinse1_start_date', trans('Rinse 1 Start Date').':', ['for'=>'rha_sample_rinse1_start_date', 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::date('rha_sample_rinse1_start_date', null, ['class'=>'col-md-4 form-control rha','readonly'=>'readonly','dusk'=>'iso-rha_sample_rinse1_start_date']) !!}
            <span class="validity"></span>
        </div>
    </div>

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('rha_sample_rinse1_end', false) }}{{ Form::checkbox('rha_sample_rinse1_end', true, old('rha_sample_rinse1_end'),
                    ['class' => 'form-control-checkbox rhabox','dusk' =>'iso-rha_sample_rinse1_end']) }}@lang('labels.rha_sample_rinse1_end')
                </label>
            </div>
        </div>
    </div>
    @endif

    @if ($isotopeBatch->rha_sample_rinse1_end)
        <div class="form-group">
            {!! Form::label('rha_sample_rinse1_end_date', trans('Rinse 1 End Date').':', ['for'=>'rha_sample_rinse1_end_date', 'class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::date('rha_sample_rinse1_end_date', null, ['class' => 'col-md-4 form-control rha','readonly'=>'readonly','dusk'=>'iso-rha_rinse1_end_date']) !!}
                <span class="validity"></span>
            </div>
        </div>
    @endif

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('rha_sample_rinse2_start', false) }}{{ Form::checkbox('rha_sample_rinse2_start', true, old('rha_sample_rinse2_start'),
                    ['class' => 'form-control-checkbox rhabox','dusk' =>'iso-rha_sample_rinse2_start']) }}@lang('labels.rha_sample_rinse2_start')
                </label>
            </div>
        </div>
    </div>

    @if ($isotopeBatch->rha_sample_rinse2_start)
    <div class="form-group">
        {!! Form::label('rha_sample_rinse2_start_date', trans('Rinse 2 Start Date').':', ['for'=>'rha_sample_rinse2_start_date', 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::date('rha_sample_rinse2_start_date', null, ['class' => 'col-md-4 form-control rha','readonly'=>'readonly','dusk'=>'iso-rha_sample_rinse2_start_date']) !!}
            <span class="validity"></span>
        </div>
    </div>

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('rha_sample_rinse2_end', false) }}{{ Form::checkbox('rha_sample_rinse2_end', true, old('rha_sample_rinse2_end'),
                    ['class' => 'form-control-checkbox rhabox','dusk' =>'iso-rha_sample_rinse2_end']) }}@lang('labels.rha_sample_rinse2_end')
                </label>
            </div>
        </div>
    </div>
    @endif

    @if ($isotopeBatch->rha_sample_rinse2_end)
        <div class="form-group">
            {!! Form::label('rha_sample_rinse2_end_date', trans('Rinse 2 End Date').':', ['for'=>'rha_sample_rinse2_end_date', 'class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::date('rha_sample_rinse2_end_date', null, ['class' => 'col-md-4 form-control rha','readonly'=>'readonly','dusk'=>'iso-rha_rinse2_end_date']) !!}
                <span class="validity"></span>
            </div>
        </div>
    @endif

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('rha_sample_rinse3_start', false) }}{{ Form::checkbox('rha_sample_rinse3_start', true, old('rha_sample_rinse3_start'),
                    ['class' => 'form-control-checkbox rhabox','dusk' =>'iso-rha_sample_rinse3_start']) }}@lang('labels.rha_sample_rinse3_start')
                </label>
            </div>
        </div>
    </div>

    @if ($isotopeBatch->rha_sample_rinse3_start)
    <div class="form-group">
        {!! Form::label('rha_sample_rinse3_start_date', trans('Rinse 3 Start Date').':', ['for'=>'rha_sample_rinse3_start_date', 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::date('rha_sample_rinse3_start_date', null, ['class' => 'col-md-4 form-control rha','readonly'=>'readonly','dusk'=>'iso-rha_sample_rinse3_start_date']) !!}
            <span class="validity"></span>
        </div>
    </div>

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('rha_sample_rinse3_end', false) }}{{ Form::checkbox('rha_sample_rinse3_end', true, old('rha_sample_rinse3_end'),
                    ['class' => 'form-control-checkbox rhabox','dusk' =>'iso-rha_sample_rinse3_end']) }}@lang('labels.rha_sample_rinse3_end')
                </label>
            </div>
        </div>
    </div>
    @endif

    @if ($isotopeBatch->rha_sample_rinse3_end)
    <div class="form-group">
        {!! Form::label('rha_sample_rinse3_end_date', trans('Rinse 3 End Date').':', ['for'=>'rha_sample_rinse3_end_date', 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::date('rha_sample_rinse3_end_date', null, ['class' => 'col-md-4 form-control rha','readonly'=>'readonly','dusk'=>'iso-rha_sample_rinse3_end_date']) !!}
            <span class="validity"></span>
        </div>
    </div>
    @endif

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('rha_sample_rinse4_start', false) }}{{ Form::checkbox('rha_sample_rinse4_start', true, old('rha_sample_rinse4_start'),
                    ['class' => 'form-control-checkbox rhabox','dusk' =>'iso-rha_sample_rinse4_start']) }}@lang('labels.rha_sample_rinse4_start')
                </label>
            </div>
        </div>
    </div>

    @if ($isotopeBatch->rha_sample_rinse4_start)
    <div class="form-group">
        {!! Form::label('rha_sample_rinse4_start_date', trans('Rinse 4 Start Date').':', ['for'=>'rha_sample_rinse4_start_date', 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::date('rha_sample_rinse4_start_date', null, ['class' => 'col-md-4 form-control rha','readonly'=>'readonly','dusk'=>'iso-rha_sample_rinse4_start_date']) !!}
            <span class="validity"></span>
        </div>
    </div>

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('rha_sample_rinse4_end', false) }}{{ Form::checkbox('rha_sample_rinse4_end', true, old('rha_sample_rinse4_end'),
                ['class' => 'form-control-checkbox rhabox','dusk' =>'iso-rha_sample_rinse4_end']) }}@lang('labels.rha_sample_rinse4_end')
                </label>
            </div>
        </div>
    </div>
    @endif

    @if ($isotopeBatch->rha_sample_rinse4_end)
    <div class="form-group">
        {!! Form::label('rha_sample_rinse4_end_date', trans('Rinse 4 End Date').':', ['for'=>'rha_sample_rinse4_end_date', 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::date('rha_sample_rinse4_end_date', null, ['class' => 'col-md-4 form-control rha','readonly'=>'readonly','dusk'=>'iso-rha_sample_rinse4_end_date']) !!}
            <span class="validity"></span>
        </div>
    </div>
    @endif

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('rha_sample_rinse5_start', false) }}{{ Form::checkbox('rha_sample_rinse5_start', true, old('rha_sample_rinse5_start'),
                    ['class' => 'form-control-checkbox rhabox','dusk' =>'iso-rha_sample_rinse5_start']) }}@lang('labels.rha_sample_rinse5_start')
                </label>
            </div>
        </div>
    </div>

    @if ($isotopeBatch->rha_sample_rinse5_start)
    <div class="form-group">
        {!! Form::label('rha_sample_rinse5_start_date', trans('Rinse 5 Start Date').':', ['for'=>'rha_sample_rinse5_start_date', 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::date('rha_sample_rinse5_start_date', null, ['class' => 'col-md-4 form-control rha','readonly'=>'readonly','dusk'=>'iso-rha_sample_rinse5_start_date']) !!}
            <span class="validity"></span>
        </div>
    </div>

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                {{ Form::hidden('rha_sample_rinse5_end', false) }}{{ Form::checkbox('rha_sample_rinse5_end', true, old('rha_sample_rinse5_end'),
                ['class' => 'form-control-checkbox rhabox','dusk' =>'iso-rha_sample_rinse5_end']) }}@lang('labels.rha_sample_rinse5_end')
                </label>
            </div>
        </div>
    </div>
    @endif

    @if ($isotopeBatch->rha_sample_rinse5_end)
    <div class="form-group">
        {!! Form::label('rha_sample_rinse5_end_date', trans('Rinse 5 End Date').':', ['for'=>'rha_sample_rinse5_end_date', 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::date('rha_sample_rinse5_end_date', null, ['class' => 'col-md-4 form-control rha','readonly'=>'readonly','dusk'=>'iso-rha_sample_rinse5_end_date']) !!}
            <span class="validity"></span>
        </div>
    </div>

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('rha_treatment_end', false) }}{{ Form::checkbox('rha_treatment_end', true, old('rha_treatment_end'),
            ['class' => 'form-control-checkbox rhabox','dusk' =>'iso-rha_treatment_end']) }}@lang('labels.rha_treatment_end')
                </label>
            </div>
        </div>
    </div>
    @endif

    @if($isotopeBatch->rha_treatment_end)
    <div class="form-group">
        {!! Form::label('rha_treatment_end_date', trans('Removing Humic Acids End Date').':', ['for'=>'rha_treatment_end_date', 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::date('rha_treatment_end_date', null, ['class' => 'col-md-4 form-control rha','dusk'=>'iso-rha_treatment_end_date']) !!}
            <span class="validity"></span>
        </div>
    </div>
    @endif
</div>