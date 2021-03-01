{{--{{  Form::hidden('se_id', $skeletalelement->id) }}--}}
{{--{{  Form::hidden('sb_id', $skeletalelement->skeletalbone->id) }}--}}

{{--<div class="form-group required form-group{{ $errors->has('sample_number') ? ' has-error' : '' }}" >--}}
{{--    {!! Form::label('sample_number', trans('labels.dna_sample_number').':', ['for' => 'sample_number', 'class' => 'col-md-4 control-label']) !!}--}}
{{--    <div class="col-md-6">--}}
{{--        @if($CRUD_Action == 'Create')--}}
{{--            {!! Form::text('sample_number', null, ['id' => 'sample_number', 'placeholder' => trans('messages.placeholder_sampleNumber'), 'class' => 'col-md-12 form-control', 'required' => 'required', 'dusk'=>'dna-sample_number']) !!}--}}
{{--        @else--}}
{{--            {!! Form::text('sample_number', null, ['id' => 'sample_number', 'placeholder' => trans('messages.placeholder_sampleNumber'), 'class' => 'col-md-12 form-control', 'readonly', 'required' => 'required', 'dusk'=>'dna-sample_number']) !!}--}}
{{--        @endif--}}
{{--        <span class="validity"></span>--}}
{{--        @if ($errors->has('sample_number'))--}}
{{--            <span class="help-block"><strong>{{ $errors->first('sample_number') }}</strong></span>--}}
{{--        @endif--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="form-group required form-group{{ $errors->has('lab_id') ? ' has-error' : '' }}" >--}}
{{--    {!! Form::label('side', trans('labels.lab').':', ['for' => 'lab_id', 'class' => 'col-md-4 control-label']) !!}--}}
{{--    <div class="col-md-6">--}}
{{--        @if(isset($dna->lab_id))--}}
{{--            {{ Form::select('lab_id', $list_lab, null, ['id' => 'lab_id', 'class' => 'form-control mav-select','dusk'=>'dna-lab' ]) }}--}}
{{--        @else--}}
{{--            {{ Form::select('lab_id', $list_lab, $theUser->getProfileValue('default_lab'), ['id' => 'lab_id', 'class' => 'form-control mav-select','dusk'=>'dna-lab' ]) }}--}}
{{--        @endif--}}
{{--        <span class="validity"></span>--}}
{{--        @if ($errors->has('side'))--}}
{{--            <span class="help-block"><strong>{{ $errors->first('lab_id') }}</strong></span>--}}
{{--        @endif--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="form-group{{ $errors->has('external_case_id') ? ' has-error' : '' }}" >--}}
{{--    {!! Form::label('external_case_id', trans('labels.external_case_#').':', ['for' => 'external_case_id', 'class' => 'col-md-4 control-label']) !!}--}}
{{--    <div class="col-md-6">--}}
{{--        {!! Form::text('external_case_id', null, ['id' => 'external_case_id', 'placeholder' => trans('messages.placeholder_externalID'), 'class' => 'col-md-12 form-control','dusk'=>'dna-external_case']) !!}--}}
{{--        <span class="validity"></span>--}}
{{--        @if ($errors->has('external_case_id'))--}}
{{--            <span class="help-block"><strong>{{ $errors->first('external_case_id') }}</strong></span>--}}
{{--        @endif--}}
{{--    </div>--}}
{{--</div>--}}

{{--@if($CRUD_Action != 'Create')--}}
{{--    <div class="form-group">--}}
{{--        {!! Form::label('btb_request_date', trans('labels.btb_request_date').':', ['for' => 'btb_request_date', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::date('btb_request_date', null, ['id' => 'btb_request_date', 'class' => 'col-md-12 form-control','dusk'=>'dna-btb_request_date']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="form-group">--}}
{{--        {!! Form::label('btb_results_date', trans('labels.btb_results_date').':', ['for' => 'btb_results_date', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::date('btb_results_date', null, ['id' => 'btb_results_date', 'class' => 'col-md-12 form-control','dusk'=>'dna-btb_results_date']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="form-group" >--}}
{{--        <div class="col-md-6 col-md-offset-4">--}}
{{--            <div class="checkbox">--}}
{{--                <label>{{ Form::hidden('resample_indicator', false) }}{{ Form::checkbox('resample_indicator', true, old('resample_indicator'),--}}
{{--                ['class' => 'form-control-checkbox','dusk' =>'dna-resample_indicator']) }} Recommended for Resampling?--}}
{{--                </label>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="form-group{{ $errors->has('disposition') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('disposition', trans('labels.disposition').':', ['for' => 'disposition', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {{ Form::select('disposition', $list_disposition, null, ['id' => 'disposition', 'class' => 'form-control mav-select','placeholder' => trans('labels.select_disposition', ['disposition'=>'Disposition']),'dusk'=>'dna-disposition' ]) }}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('disposition'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('disposition') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="form-group{{ $errors->has('sample_condition') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('sample_condition', trans('labels.sample_condition').':', ['for' => 'sample_condition', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {{ Form::select('sample_condition', $list_sample_condition, null, ['id' => 'sample_condition', 'class' => 'form-control mav-select','placeholder' => trans('labels.select_sample_condition', ['sample_condition'=>'Sample Condition']),'dusk'=>'dna-sample_condition' ]) }}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('sample_condition'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('sample_condition') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="form-group{{ $errors->has('weight_sample_remaining') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('weight_sample_remaining', trans('labels.weight_sample_remaining'), ['for'=>"weight_sample_remaining", 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-3">--}}
{{--            {!! Form::number('weight_sample_remaining', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'weight_sample_remaining','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('weight_sample_remaining'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('weight_sample_remaining') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--        {!! Form::label('uom', "mm", ['class' => 'control-label']) !!}--}}
{{--    </div>--}}

{{--    @include('dnas.dnapartial')--}}

{{--@endif--}}

{{--@if($CRUD_Action != 'View')--}}
{{--    <div class="form-group" >--}}
{{--        <div class="col-md-6 col-md-offset-5">--}}
{{--            {!! Form::button('<i class="fas fa-btn fa-save"></i>Save', ['type' => 'submit', 'class' => 'btn btn-primary','dusk'=>'dna-save']) !!}--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endif--}}

{{--@section('footer')--}}
{{--    @parent--}}
{{--    <style>--}}
{{--        li#nav-dna { background-color: lightgray; }--}}
{{--    </style>--}}
{{--@endsection--}}