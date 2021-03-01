<div class="iso-batch-process border" style="padding-top: 10px; margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('sc_clean_vials_and_lids', false) }}{{ Form::checkbox('sc_clean_vials_and_lids', true, old('sc_clean_vials_and_lids'),
                    ['class' => 'form-control-checkbox solubox','dusk' =>'iso-sc_clean_vials_and_lids']) }}@lang('labels.sc_clean_vials_and_lids')
                </label>
            </div>
        </div>
    </div>

    @if ($isotopeBatch->sc_clean_vials_and_lids)
    <div class="form-group">
        {!! Form::label('sc_clean_vials_and_lids_date', trans('Clean Vials and Lids Date').':', ['for'=>'sc_clean_vials_and_lids_date', 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::date('sc_clean_vials_and_lids_date', null, ['class' => 'col-md-4 form-control solu','readonly'=>'readonly','dusk'=>'iso-sc_clean_vials_and_lids_date']) !!}
            <span class="validity"></span>
        </div>
    </div>
    @endif

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('sc_add_solubale', false) }}{{ Form::checkbox('sc_add_solubale', true, old('sc_add_solubale'),
                    ['class' => 'form-control-checkbox solubox','dusk' =>'iso-sc_add_solubale']) }}@lang('labels.sc_add_solubale')
                </label>
            </div>
        </div>
    </div>

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('sc_place_in_oven', false) }}{{ Form::checkbox('sc_place_in_oven', true, old('sc_place_in_oven'),
                    ['class' => 'form-control-checkbox solubox','dusk' =>'iso-sc_place_in_oven']) }}@lang('labels.sc_place_in_oven')
                </label>
            </div>
        </div>
    </div>


    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('sc_centrifuge_tubes', false) }}{{ Form::checkbox('sc_centrifuge_tubes', true, old('sc_centrifuge_tubes'),
                    ['class' => 'form-control-checkbox solubox','dusk' =>'iso-sc_centrifuge_tubes']) }}@lang('labels.sc_centrifuge_tubes')
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('sc_num_acid_heat_treatment', 'Number of Acid-Heat Treatments:', ['for'=>"sc_num_acid_heat_treatment", 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-3">
            {!! Form::number('sc_num_acid_heat_treatment', null, ['id' => 'sc_num_acid_heat_treatment', 'class' => 'col-md-9 form-control solu','dusk' =>'iso-sc_num_acid_heat_treatment','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('sc_num_collagen_transfers', 'Number of Collagen Transfers:', ['for'=>"sc_num_collagen_transfers", 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-3">
            {!! Form::number('sc_num_collagen_transfers', null, ['id' => 'sc_num_collagen_transfers', 'class' => 'col-md-9 form-control solu','dusk' =>'iso-sc_num_collagen_transfers','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}
        </div>
    </div>

    <div class="form-group" >
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::hidden('sc_freeze_vials', false) }}{{ Form::checkbox('sc_freeze_vials', true, old('sc_freeze_vials'),
                    ['class' => 'form-control-checkbox solubox','dusk' =>'iso-sc_freeze_vials']) }}@lang('labels.sc_freeze_vials')
                </label>
            </div>
        </div>
    </div>

    @if ($isotopeBatch->sc_freeze_vials)
    <div class="form-group">
        {!! Form::label('sc_freeze_vials_date', trans('Freeze Vials Date').':', ['for'=>'sc_freeze_vials_date', 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::date('sc_freeze_vials_date', null, ['class' => 'col-md-4 form-control solu','readonly'=>'readonly','dusk'=>'iso-sc_freeze_vials_date']) !!}
            <span class="validity"></span>
        </div>
    </div>
    @endif
</div>
