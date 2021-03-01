@php
    $defaultLabID = $theUser->getProfileValue('default_lab');
@endphp

<div class="col-lg-12 form-group dna">
{{--    {{  Form::hidden('se_id', $skeletalelement->id) }}--}}
{{--    {{  Form::hidden('sb_id', $skeletalelement->skeletalbone->id) }}--}}

{{--    <div class="form-group required form-group{{ $errors->has('lab_id') ? ' has-error' : '' }}" >--}}
{{--    {!! Form::label('side', trans('Lab').':', ['for' => 'lab_id', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--        @if(isset($isotope->lab_id))--}}
{{--                {{ Form::select('lab_id', $list_lab, null, ['id' => 'lab_id', 'class' => 'form-control mav-select','dusk'=>'dna-lab' ]) }}--}}

{{--            @else--}}
{{--            {{ Form::select('lab_id', $list_lab, $defaultLabID, ['id' => 'lab_id', 'class' => 'form-control mav-select','dusk'=>'dna-lab' ]) }}--}}
{{--        @endif--}}
{{--            <span class="validity"></span>--}}
{{--        @if ($errors->has('side'))--}}
{{--            <span class="help-block"><strong>{{ $errors->first('lab_id') }}</strong></span>--}}
{{--        @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('external_case_id') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('external_case_id', 'External Case #:', ['for' => 'external_case_id', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::text('external_case_id', null, ['id' => 'external_case_id', 'placeholder' => trans('messages.placeholder_externalID'), 'class' => 'col-md-12 form-control','dusk'=>'dna-external_case']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('external_case_id'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('external_case_id') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group required form-group{{ $errors->has('sample_number') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('sample_number', 'Isotope Sample Number:', ['for' => 'sample_number', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            @if($CRUD_Action == 'Create')--}}
{{--                {!! Form::text('sample_number', null, ['id' => 'sample_number', 'placeholder' => trans('messages.placeholder_sampleNumber'), 'class' => 'col-md-12 form-control', 'required' => 'required', 'dusk'=>'dna-sample_number']) !!}--}}
{{--            @else--}}
{{--                {!! Form::text('sample_number', null, ['id' => 'sample_number', 'placeholder' => trans('messages.placeholder_sampleNumber'), 'class' => 'col-md-12 form-control', 'readonly', 'required' => 'required', 'dusk'=>'dna-sample_number']) !!}--}}
{{--            @endif--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('sample_number'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('sample_number') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    @if($CRUD_Action != 'Create')--}}
{{--        <div class="form-group form-group{{ $errors->has('batch_id') ? ' has-error' : '' }}" >--}}
{{--            {!! Form::label('Batch', trans('Batch').':', ['for' => 'batch_id', 'class' => 'col-md-4 control-label']) !!}--}}
{{--            <div class="col-md-6">--}}
{{--                {{ Form::select('batch_id', $list_isotope_batches, null, ['id' => 'batch_id', 'class' => 'form-control mav-select','dusk'=>'dna-batch_id' ]) }}--}}
{{--                <span class="validity"></span>--}}
{{--                @if ($errors->has('batch_id'))--}}
{{--                    <span class="help-block"><strong>{{ $errors->first('batch_id') }}</strong></span>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="form-group{{ $errors->has('results_confidence') ? ' has-error' : '' }}">--}}
{{--            {!! Form::label('results_confidence', trans('labels.results_status').':', ['for' => 'results_confidence', 'class' => 'col-md-4 control-label']) !!}--}}
{{--            <div class="col-md-6">--}}
{{--                {{ Form::select('results_confidence', $list_confidence, null, ['id' => 'results_confidence', 'class' => 'form-control mav-select','style' => 'width: 100%','dusk'=>'isotope-results_confidence' ]) }}--}}
{{--                <span class="validity"></span>--}}
{{--                @if ($errors->has('results_confidence'))--}}
{{--                    <span class="help-block"><strong>{{ $errors->first('results_confidence') }}</strong></span>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="form-group{{ $errors->has('weight_sample_cleaned') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('weight_sample_cleaned', 'Weight Sample Cleaned:', ['for'=>"weight_sample_cleaned", 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-3">--}}
{{--            {!! Form::number('weight_sample_cleaned', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('weight_sample_cleaned'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('weight_sample_cleaned') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--        {!! Form::label('uom', $theOrg->getProfileValue('org_mass_unit_of_measure'), ['class' => 'control-label']) !!}--}}
{{--    </div>--}}

{{--    <div class="form-group">--}}
{{--        {!! Form::label('demineralizing_start_date', 'Demineralizing Start Date:', ['for' => 'demineralizing_start_date', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::date('demineralizing_start_date', null, ['id' => 'demineralizing_start_date', 'readonly', 'class' => 'col-md-12 form-control','dusk'=>'dna-demineralizing_start_date']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="form-group">--}}
{{--        {!! Form::label('demineralizing_end_date', 'Demineralizing End Date:', ['for' => 'demineralizing_end_date', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::date('demineralizing_end_date', null, ['id' => 'demineralizing_end_date', 'readonly', 'class' => 'col-md-12 form-control','dusk'=>'dna-demineralizing_end_date']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('weight_vial_lid') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('weight_vial_lid', 'Weight Vial and Lid:', ['for'=>"weight_vial_lid", 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-3">--}}
{{--            {!! Form::number('weight_vial_lid', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('weight_vial_lid'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('weight_vial_lid') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--        {!! Form::label('uom', $theOrg->getProfileValue('org_mass_unit_of_measure'), ['class' => 'control-label']) !!}--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('weight_sample_vial_lid') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('weight_sample_vial_lid', 'Weight Sample, Vial and Lid:', ['for'=>"weight_sample_vial_lid", 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-3">--}}
{{--            {!! Form::number('weight_sample_vial_lid', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('weight_sample_vial_lid'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('weight_sample_vial_lid') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--        {!! Form::label('uom', $theOrg->getProfileValue('org_mass_unit_of_measure'), ['class' => 'control-label']) !!}--}}
{{--    </div>--}}

{{--    Calculated field--}}
{{--    <div class="form-group{{ $errors->has('weight_collagen') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('weight_collagen', 'Weight Collagen:', ['for'=>"weight_collagen", 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-3">--}}
{{--            {!! Form::number('weight_collagen', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('weight_collagen'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('weight_collagen') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--        {!! Form::label('uom', $theOrg->getProfileValue('org_mass_unit_of_measure'), ['class' => 'control-label']) !!}--}}
{{--    </div>--}}

{{--    Calculated field--}}
{{--    <div class="form-group{{ $errors->has('yield_collagen') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('yield_collagen', 'Yield Collagen:', ['for'=>"yield_collagen", 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-3">--}}
{{--            {!! Form::number('yield_collagen', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('yield_collagen'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('yield_collagen') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--        {!! Form::label('uom', "%", ['class' => 'control-label']) !!}--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('collagen_weight_used_for_analysis') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('collagen_weight_used_for_analysis', 'Collagen Weight used for Analysis:', ['for'=>"collagen_weight_used_for_analysis", 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-3">--}}
{{--            {!! Form::number('collagen_weight_used_for_analysis', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('collagen_weight_used_for_analysis'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('collagen_weight_used_for_analysis') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--        {!! Form::label('uom', "mg", ['class' => 'control-label']) !!}--}}
{{--    </div>--}}
{{--    <div class="form-group{{ $errors->has('analysis_requested') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('analysis_requested', 'Analysis Requested:', ['for' => 'analysis_requested', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::text('analysis_requested', null, ['id' => 'analysis_requested', 'placeholder' => trans('messages.placeholder_externalID'), 'class' => 'col-md-12 form-control','dusk'=>'dna-external_case']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('analysis_requested'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('analysis_requested') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="form-group{{ $errors->has('well_location') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('well_location', 'Well Location:', ['for' => 'well_location', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::text('well_location', null, ['id' => 'well_location', 'placeholder' => trans('messages.placeholder_externalID'), 'class' => 'col-md-12 form-control','dusk'=>'dna-external_case']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('well_location'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('well_location') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    Measurements of Carbon/Nitrogen/Oxygen/Sulphur content in specimen--}}
{{--    <div class="form-group{{ $errors->has('c_delta') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('c_delta', 'Carbon Delta:', ['for'=>"c_delta", 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-3">--}}
{{--            {!! Form::number('c_delta', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>-100,'max'=>100,'step'=>"any"]) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('c_delta'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('c_delta') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--        {!! Form::label('uom', "ug", ['class' => 'control-label']) !!}--}}
{{--    </div>--}}
{{--    <div class="form-group{{ $errors->has('c_weight') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('c_weight', 'Carbon Weight:', ['for'=>"c_weight", 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-3">--}}
{{--            {!! Form::number('c_weight', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('c_weight'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('c_weight') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--        {!! Form::label('uom', "ug", ['class' => 'control-label']) !!}--}}
{{--    </div>--}}
{{--    <div class="form-group{{ $errors->has('c_percent') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('c_percent', 'Carbon Percentage:', ['for'=>"c_percent", 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-3">--}}
{{--            {!! Form::number('c_percent', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('c_percent'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('c_percent') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--        {!! Form::label('uom', "%", ['class' => 'control-label']) !!}--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('n_delta') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('n_delta', 'Nitrogen Delta:', ['for'=>"n_delta", 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-3">--}}
{{--            {!! Form::number('n_delta', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>-100,'max'=>100,'step'=>"any"]) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('n_delta'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('n_delta') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--        {!! Form::label('uom', "ug", ['class' => 'control-label']) !!}--}}
{{--    </div>--}}
{{--    <div class="form-group{{ $errors->has('n_weight') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('n_weight', 'Nitrogen Weight:', ['for'=>"n_weight", 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-3">--}}
{{--            {!! Form::number('n_weight', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('n_weight'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('n_weight') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--        {!! Form::label('uom', "ug", ['class' => 'control-label']) !!}--}}
{{--    </div>--}}
{{--    <div class="form-group{{ $errors->has('n_percent') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('n_percent', 'Nitrogen Percentage:', ['for'=>"n_percent", 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-3">--}}
{{--            {!! Form::number('n_percent', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('n_percent'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('n_percent') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--        {!! Form::label('uom', "%", ['class' => 'control-label']) !!}--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('c_to_n_ratio') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('c_to_n_ratio', 'Carbon/Nitrogen Ratio:', ['for'=>"c_to_n_ratio", 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-3">--}}
{{--            {!! Form::number('c_to_n_ratio', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('c_to_n_ratio'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('c_to_n_ratio') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--        {!! Form::label('uom', "%", ['class' => 'control-label']) !!}--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('o_delta') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('o_delta', 'Oxygen Delta:', ['for'=>"o_delta", 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-3">--}}
{{--            {!! Form::number('o_delta', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>-100,'max'=>100,'step'=>"any"]) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('o_delta'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('o_delta') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--        {!! Form::label('uom', "ug", ['class' => 'control-label']) !!}--}}
{{--    </div>--}}
{{--    <div class="form-group{{ $errors->has('o_weight') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('o_weight', 'Oxygen Weight:', ['for'=>"o_weight", 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-3">--}}
{{--            {!! Form::number('o_weight', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('o_weight'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('o_weight') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--        {!! Form::label('uom', "ug", ['class' => 'control-label']) !!}--}}
{{--    </div>--}}
{{--    <div class="form-group{{ $errors->has('o_percent') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('o_percent', 'Oxygen Percentage:', ['for'=>"o_percent", 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-3">--}}
{{--            {!! Form::number('o_percent', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('o_percent'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('o_percent') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--        {!! Form::label('uom', "%", ['class' => 'control-label']) !!}--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('c_to_o_ratio') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('c_to_o_ratio', 'Carbon/Oxygen Ratio:', ['for'=>"c_to_o_ratio", 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-3">--}}
{{--            {!! Form::number('c_to_o_ratio', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('c_to_o_ratio'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('c_to_o_ratio') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--        {!! Form::label('uom', "%", ['class' => 'control-label']) !!}--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('s_delta') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('s_delta', 'Sulphur Delta:', ['for'=>"s_delta", 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-3">--}}
{{--            {!! Form::number('s_delta', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>-100,'max'=>100,'step'=>"any"]) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('s_delta'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('s_delta') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--        {!! Form::label('uom', "ug", ['class' => 'control-label']) !!}--}}
{{--    </div>--}}
{{--    <div class="form-group{{ $errors->has('s_weight') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('s_weight', 'Sulphur Weight:', ['for'=>"s_weight", 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-3">--}}
{{--            {!! Form::number('s_weight', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('s_weight'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('s_weight') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--        {!! Form::label('uom', "ug", ['class' => 'control-label']) !!}--}}
{{--    </div>--}}
{{--    <div class="form-group{{ $errors->has('s_percent') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('s_percent', 'Sulphur Percentage:', ['for'=>"s_percent", 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-3">--}}
{{--            {!! Form::number('s_percent', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('s_percent'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('s_percent') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--        {!! Form::label('uom', "%", ['class' => 'control-label']) !!}--}}
{{--    </div>--}}
{{--        @php--}}
{{--            $defaultLabID = $theUser->getProfileValue('default_lab');--}}
{{--        @endphp--}}

{{--        <div class="col-lg-12 form-group dna">--}}
{{--            {{  Form::hidden('se_id', $skeletalelement->id) }}--}}
{{--            {{  Form::hidden('sb_id', $skeletalelement->skeletalbone->id) }}--}}

{{--            <div class="form-group required form-group{{ $errors->has('lab_id') ? ' has-error' : '' }}" >--}}
{{--                {!! Form::label('side', trans('Lab').':', ['for' => 'lab_id', 'class' => 'col-md-4 control-label']) !!}--}}
{{--                <div class="col-md-6">--}}
{{--                    @if(isset($isotope->lab_id))--}}
{{--                        {{ Form::select('lab_id', $list_lab, null, ['id' => 'lab_id', 'class' => 'form-control mav-select','dusk'=>'dna-lab' ]) }}--}}

{{--                    @else--}}
{{--                        {{ Form::select('lab_id', $list_lab, $defaultLabID, ['id' => 'lab_id', 'class' => 'form-control mav-select','dusk'=>'dna-lab' ]) }}--}}
{{--                    @endif--}}
{{--                    <span class="validity"></span>--}}
{{--                    @if ($errors->has('side'))--}}
{{--                        <span class="help-block"><strong>{{ $errors->first('lab_id') }}</strong></span>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="form-group{{ $errors->has('external_case_id') ? ' has-error' : '' }}" >--}}
{{--                {!! Form::label('external_case_id', 'External Case #:', ['for' => 'external_case_id', 'class' => 'col-md-4 control-label']) !!}--}}
{{--                <div class="col-md-6">--}}
{{--                    {!! Form::text('external_case_id', null, ['id' => 'external_case_id', 'placeholder' => trans('messages.placeholder_externalID'), 'class' => 'col-md-12 form-control','dusk'=>'dna-external_case']) !!}--}}
{{--                    <span class="validity"></span>--}}
{{--                    @if ($errors->has('external_case_id'))--}}
{{--                        <span class="help-block"><strong>{{ $errors->first('external_case_id') }}</strong></span>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="form-group required form-group{{ $errors->has('sample_number') ? ' has-error' : '' }}" >--}}
{{--                {!! Form::label('sample_number', 'Isotope Sample Number:', ['for' => 'sample_number', 'class' => 'col-md-4 control-label']) !!}--}}
{{--                <div class="col-md-6">--}}
{{--                    @if($CRUD_Action == 'Create')--}}
{{--                        {!! Form::text('sample_number', null, ['id' => 'sample_number', 'placeholder' => trans('messages.placeholder_sampleNumber'), 'class' => 'col-md-12 form-control', 'required' => 'required', 'dusk'=>'dna-sample_number']) !!}--}}
{{--                    @else--}}
{{--                        {!! Form::text('sample_number', null, ['id' => 'sample_number', 'placeholder' => trans('messages.placeholder_sampleNumber'), 'class' => 'col-md-12 form-control', 'readonly', 'required' => 'required', 'dusk'=>'dna-sample_number']) !!}--}}
{{--                    @endif--}}
{{--                    <span class="validity"></span>--}}
{{--                    @if ($errors->has('sample_number'))--}}
{{--                        <span class="help-block"><strong>{{ $errors->first('sample_number') }}</strong></span>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            @if($CRUD_Action != 'Create')--}}
{{--                <div class="form-group form-group{{ $errors->has('batch_id') ? ' has-error' : '' }}" >--}}
{{--                    {!! Form::label('Batch', trans('Batch').':', ['for' => 'batch_id', 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-6">--}}
{{--                        {{ Form::select('batch_id', $list_isotope_batches, null, ['id' => 'batch_id', 'class' => 'form-control mav-select','dusk'=>'dna-batch_id' ]) }}--}}
{{--                        <span class="validity"></span>--}}
{{--                        @if ($errors->has('batch_id'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('batch_id') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="form-group{{ $errors->has('results_confidence') ? ' has-error' : '' }}">--}}
{{--                    {!! Form::label('results_confidence', trans('labels.results_status').':', ['for' => 'results_confidence', 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-6">--}}
{{--                        {{ Form::select('results_confidence', $list_confidence, null, ['id' => 'results_confidence', 'class' => 'form-control mav-select','style' => 'width: 100%','dusk'=>'isotope-results_confidence' ]) }}--}}
{{--                        <span class="validity"></span>--}}
{{--                        @if ($errors->has('results_confidence'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('results_confidence') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="form-group{{ $errors->has('weight_sample_cleaned') ? ' has-error' : '' }}" >--}}
{{--                    {!! Form::label('weight_sample_cleaned', 'Weight Sample Cleaned:', ['for'=>"weight_sample_cleaned", 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-3">--}}
{{--                        {!! Form::number('weight_sample_cleaned', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--                        <span class="validity"></span>--}}
{{--                        @if ($errors->has('weight_sample_cleaned'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('weight_sample_cleaned') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    {!! Form::label('uom', $theOrg->getProfileValue('org_mass_unit_of_measure'), ['class' => 'control-label']) !!}--}}
{{--                </div>--}}

{{--                <div class="form-group">--}}
{{--                    {!! Form::label('demineralizing_start_date', 'Demineralizing Start Date:', ['for' => 'demineralizing_start_date', 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-6">--}}
{{--                        {!! Form::date('demineralizing_start_date', null, ['id' => 'demineralizing_start_date', 'readonly', 'class' => 'col-md-12 form-control','dusk'=>'dna-demineralizing_start_date']) !!}--}}
{{--                        <span class="validity"></span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="form-group">--}}
{{--                    {!! Form::label('demineralizing_end_date', 'Demineralizing End Date:', ['for' => 'demineralizing_end_date', 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-6">--}}
{{--                        {!! Form::date('demineralizing_end_date', null, ['id' => 'demineralizing_end_date', 'readonly', 'class' => 'col-md-12 form-control','dusk'=>'dna-demineralizing_end_date']) !!}--}}
{{--                        <span class="validity"></span>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="form-group{{ $errors->has('weight_vial_lid') ? ' has-error' : '' }}" >--}}
{{--                    {!! Form::label('weight_vial_lid', 'Weight Vial and Lid:', ['for'=>"weight_vial_lid", 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-3">--}}
{{--                        {!! Form::number('weight_vial_lid', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--                        <span class="validity"></span>--}}
{{--                        @if ($errors->has('weight_vial_lid'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('weight_vial_lid') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    {!! Form::label('uom', $theOrg->getProfileValue('org_mass_unit_of_measure'), ['class' => 'control-label']) !!}--}}
{{--                </div>--}}

{{--                <div class="form-group{{ $errors->has('weight_sample_vial_lid') ? ' has-error' : '' }}" >--}}
{{--                    {!! Form::label('weight_sample_vial_lid', 'Weight Sample, Vial and Lid:', ['for'=>"weight_sample_vial_lid", 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-3">--}}
{{--                        {!! Form::number('weight_sample_vial_lid', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--                        <span class="validity"></span>--}}
{{--                        @if ($errors->has('weight_sample_vial_lid'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('weight_sample_vial_lid') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    {!! Form::label('uom', $theOrg->getProfileValue('org_mass_unit_of_measure'), ['class' => 'control-label']) !!}--}}
{{--                </div>--}}

{{--                Calculated field--}}
{{--                <div class="form-group{{ $errors->has('weight_collagen') ? ' has-error' : '' }}" >--}}
{{--                    {!! Form::label('weight_collagen', 'Weight Collagen:', ['for'=>"weight_collagen", 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-3">--}}
{{--                        {!! Form::number('weight_collagen', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--                        <span class="validity"></span>--}}
{{--                        @if ($errors->has('weight_collagen'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('weight_collagen') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    {!! Form::label('uom', $theOrg->getProfileValue('org_mass_unit_of_measure'), ['class' => 'control-label']) !!}--}}
{{--                </div>--}}

{{--                Calculated field--}}
{{--                <div class="form-group{{ $errors->has('yield_collagen') ? ' has-error' : '' }}" >--}}
{{--                    {!! Form::label('yield_collagen', 'Yield Collagen:', ['for'=>"yield_collagen", 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-3">--}}
{{--                        {!! Form::number('yield_collagen', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--                        <span class="validity"></span>--}}
{{--                        @if ($errors->has('yield_collagen'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('yield_collagen') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    {!! Form::label('uom', "%", ['class' => 'control-label']) !!}--}}
{{--                </div>--}}

{{--                <div class="form-group{{ $errors->has('collagen_weight_used_for_analysis') ? ' has-error' : '' }}" >--}}
{{--                    {!! Form::label('collagen_weight_used_for_analysis', 'Collagen Weight used for Analysis:', ['for'=>"collagen_weight_used_for_analysis", 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-3">--}}
{{--                        {!! Form::number('collagen_weight_used_for_analysis', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--                        <span class="validity"></span>--}}
{{--                        @if ($errors->has('collagen_weight_used_for_analysis'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('collagen_weight_used_for_analysis') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    {!! Form::label('uom', "mg", ['class' => 'control-label']) !!}--}}
{{--                </div>--}}
{{--                <div class="form-group{{ $errors->has('analysis_requested') ? ' has-error' : '' }}" >--}}
{{--                    {!! Form::label('analysis_requested', 'Analysis Requested:', ['for' => 'analysis_requested', 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-6">--}}
{{--                        {!! Form::text('analysis_requested', null, ['id' => 'analysis_requested', 'placeholder' => trans('messages.placeholder_externalID'), 'class' => 'col-md-12 form-control','dusk'=>'dna-external_case']) !!}--}}
{{--                        <span class="validity"></span>--}}
{{--                        @if ($errors->has('analysis_requested'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('analysis_requested') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="form-group{{ $errors->has('well_location') ? ' has-error' : '' }}" >--}}
{{--                    {!! Form::label('well_location', 'Well Location:', ['for' => 'well_location', 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-6">--}}
{{--                        {!! Form::text('well_location', null, ['id' => 'well_location', 'placeholder' => trans('messages.placeholder_externalID'), 'class' => 'col-md-12 form-control','dusk'=>'dna-external_case']) !!}--}}
{{--                        <span class="validity"></span>--}}
{{--                        @if ($errors->has('well_location'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('well_location') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                Measurements of Carbon/Nitrogen/Oxygen/Sulphur content in specimen--}}
{{--                <div class="form-group{{ $errors->has('c_delta') ? ' has-error' : '' }}" >--}}
{{--                    {!! Form::label('c_delta', 'Carbon Delta:', ['for'=>"c_delta", 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-3">--}}
{{--                        {!! Form::number('c_delta', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>-100,'max'=>100,'step'=>"any"]) !!}--}}
{{--                        <span class="validity"></span>--}}
{{--                        @if ($errors->has('c_delta'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('c_delta') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    {!! Form::label('uom', "ug", ['class' => 'control-label']) !!}--}}
{{--                </div>--}}
{{--                <div class="form-group{{ $errors->has('c_weight') ? ' has-error' : '' }}" >--}}
{{--                    {!! Form::label('c_weight', 'Carbon Weight:', ['for'=>"c_weight", 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-3">--}}
{{--                        {!! Form::number('c_weight', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--                        <span class="validity"></span>--}}
{{--                        @if ($errors->has('c_weight'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('c_weight') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    {!! Form::label('uom', "ug", ['class' => 'control-label']) !!}--}}
{{--                </div>--}}
{{--                <div class="form-group{{ $errors->has('c_percent') ? ' has-error' : '' }}" >--}}
{{--                    {!! Form::label('c_percent', 'Carbon Percentage:', ['for'=>"c_percent", 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-3">--}}
{{--                        {!! Form::number('c_percent', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--                        <span class="validity"></span>--}}
{{--                        @if ($errors->has('c_percent'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('c_percent') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    {!! Form::label('uom', "%", ['class' => 'control-label']) !!}--}}
{{--                </div>--}}

{{--                <div class="form-group{{ $errors->has('n_delta') ? ' has-error' : '' }}" >--}}
{{--                    {!! Form::label('n_delta', 'Nitrogen Delta:', ['for'=>"n_delta", 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-3">--}}
{{--                        {!! Form::number('n_delta', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>-100,'max'=>100,'step'=>"any"]) !!}--}}
{{--                        <span class="validity"></span>--}}
{{--                        @if ($errors->has('n_delta'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('n_delta') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    {!! Form::label('uom', "ug", ['class' => 'control-label']) !!}--}}
{{--                </div>--}}
{{--                <div class="form-group{{ $errors->has('n_weight') ? ' has-error' : '' }}" >--}}
{{--                    {!! Form::label('n_weight', 'Nitrogen Weight:', ['for'=>"n_weight", 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-3">--}}
{{--                        {!! Form::number('n_weight', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--                        <span class="validity"></span>--}}
{{--                        @if ($errors->has('n_weight'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('n_weight') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    {!! Form::label('uom', "ug", ['class' => 'control-label']) !!}--}}
{{--                </div>--}}
{{--                <div class="form-group{{ $errors->has('n_percent') ? ' has-error' : '' }}" >--}}
{{--                    {!! Form::label('n_percent', 'Nitrogen Percentage:', ['for'=>"n_percent", 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-3">--}}
{{--                        {!! Form::number('n_percent', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--                        <span class="validity"></span>--}}
{{--                        @if ($errors->has('n_percent'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('n_percent') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    {!! Form::label('uom', "%", ['class' => 'control-label']) !!}--}}
{{--                </div>--}}

{{--                <div class="form-group{{ $errors->has('c_to_n_ratio') ? ' has-error' : '' }}" >--}}
{{--                    {!! Form::label('c_to_n_ratio', 'Carbon/Nitrogen Ratio:', ['for'=>"c_to_n_ratio", 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-3">--}}
{{--                        {!! Form::number('c_to_n_ratio', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--                        <span class="validity"></span>--}}
{{--                        @if ($errors->has('c_to_n_ratio'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('c_to_n_ratio') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    {!! Form::label('uom', "%", ['class' => 'control-label']) !!}--}}
{{--                </div>--}}

{{--                <div class="form-group{{ $errors->has('o_delta') ? ' has-error' : '' }}" >--}}
{{--                    {!! Form::label('o_delta', 'Oxygen Delta:', ['for'=>"o_delta", 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-3">--}}
{{--                        {!! Form::number('o_delta', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>-100,'max'=>100,'step'=>"any"]) !!}--}}
{{--                        <span class="validity"></span>--}}
{{--                        @if ($errors->has('o_delta'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('o_delta') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    {!! Form::label('uom', "ug", ['class' => 'control-label']) !!}--}}
{{--                </div>--}}
{{--                <div class="form-group{{ $errors->has('o_weight') ? ' has-error' : '' }}" >--}}
{{--                    {!! Form::label('o_weight', 'Oxygen Weight:', ['for'=>"o_weight", 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-3">--}}
{{--                        {!! Form::number('o_weight', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--                        <span class="validity"></span>--}}
{{--                        @if ($errors->has('o_weight'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('o_weight') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    {!! Form::label('uom', "ug", ['class' => 'control-label']) !!}--}}
{{--                </div>--}}
{{--                <div class="form-group{{ $errors->has('o_percent') ? ' has-error' : '' }}" >--}}
{{--                    {!! Form::label('o_percent', 'Oxygen Percentage:', ['for'=>"o_percent", 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-3">--}}
{{--                        {!! Form::number('o_percent', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--                        <span class="validity"></span>--}}
{{--                        @if ($errors->has('o_percent'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('o_percent') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    {!! Form::label('uom', "%", ['class' => 'control-label']) !!}--}}
{{--                </div>--}}

{{--                <div class="form-group{{ $errors->has('c_to_o_ratio') ? ' has-error' : '' }}" >--}}
{{--                    {!! Form::label('c_to_o_ratio', 'Carbon/Oxygen Ratio:', ['for'=>"c_to_o_ratio", 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-3">--}}
{{--                        {!! Form::number('c_to_o_ratio', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--                        <span class="validity"></span>--}}
{{--                        @if ($errors->has('c_to_o_ratio'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('c_to_o_ratio') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    {!! Form::label('uom', "%", ['class' => 'control-label']) !!}--}}
{{--                </div>--}}

{{--                <div class="form-group{{ $errors->has('s_delta') ? ' has-error' : '' }}" >--}}
{{--                    {!! Form::label('s_delta', 'Sulphur Delta:', ['for'=>"s_delta", 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-3">--}}
{{--                        {!! Form::number('s_delta', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>-100,'max'=>100,'step'=>"any"]) !!}--}}
{{--                        <span class="validity"></span>--}}
{{--                        @if ($errors->has('s_delta'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('s_delta') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    {!! Form::label('uom', "ug", ['class' => 'control-label']) !!}--}}
{{--                </div>--}}
{{--                <div class="form-group{{ $errors->has('s_weight') ? ' has-error' : '' }}" >--}}
{{--                    {!! Form::label('s_weight', 'Sulphur Weight:', ['for'=>"s_weight", 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-3">--}}
{{--                        {!! Form::number('s_weight', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--                        <span class="validity"></span>--}}
{{--                        @if ($errors->has('s_weight'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('s_weight') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    {!! Form::label('uom', "ug", ['class' => 'control-label']) !!}--}}
{{--                </div>--}}
{{--                <div class="form-group{{ $errors->has('s_percent') ? ' has-error' : '' }}" >--}}
{{--                    {!! Form::label('s_percent', 'Sulphur Percentage:', ['for'=>"s_percent", 'class' => 'col-md-4 control-label']) !!}--}}
{{--                    <div class="col-md-3">--}}
{{--                        {!! Form::number('s_percent', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--                        <span class="validity"></span>--}}
{{--                        @if ($errors->has('s_percent'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('s_percent') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    {!! Form::label('uom', "%", ['class' => 'control-label']) !!}--}}
{{--                </div>--}}

{{--            @endif--}}

{{--            @if($CRUD_Action != 'View')--}}
{{--                <div class="form-group" >--}}
{{--                    <div class="col-md-6 col-md-offset-5">--}}
{{--                        {!! Form::button('<i class="fas fa-btn fa-save"></i>Save', ['type' => 'submit', 'class' => 'btn btn-primary','dusk'=>'dna-save']) !!}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        </div>--}}

{{--    @endif--}}

{{--    @if($CRUD_Action != 'View')--}}
{{--        <div class="form-group" >--}}
{{--            <div class="col-md-6 col-md-offset-5">--}}
{{--                {!! Form::button('<i class="fas fa-btn fa-save"></i>Save', ['type' => 'submit', 'class' => 'btn btn-primary','dusk'=>'dna-save']) !!}--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}
</div>


