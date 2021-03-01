{{--<div class="col-lg-12 dna border"--}}
{{--     style="padding-top: 10px; margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">--}}

{{--    <div class="form-group required form-group{{ $errors->has('austr_method') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('austr_method', trans('labels.method').':', ['for' => 'austr_method', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            @if(isset($dna->austr_method))--}}
{{--                {{ Form::select('austr_method', $list_auto_method, null, ['id' => 'austr_method', 'class' => 'form-control mav-select', 'style' => 'width: 100%', 'placeholder' => trans('labels.select_method'), 'dusk'=>'dna-austr_method' ]) }}--}}
{{--            @else--}}
{{--                {{ Form::select('austr_method', $list_auto_method, $theUser->getProfileValue('default_auto_method'), ['id' => 'austr_method', 'class' => 'form-control mav-select', 'style' => 'width: 100%', 'dusk'=>'dna-austr_method' ]) }}--}}
{{--            @endif--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('austr_method'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('austr_method') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group">--}}
{{--        {!! Form::label('austr_request_date', trans('labels.request_date').':', ['for' => 'austr_request_date', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::date('austr_request_date', null, ['id' => 'austr_request_date', 'class' => 'col-md-12 form-control','dusk'=>'dna-austr_request_date']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--        </div>--}}

{{--    </div>--}}

{{--    <div class="form-group">--}}
{{--        {!! Form::label('austr_receive_date', trans('labels.receive_date').':', ['for' => 'austr_receive_date', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::date('austr_receive_date', null, ['id' => 'austr_receive_date', 'class' => 'col-md-12 form-control','dusk'=>'dna-austr_receive_date']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('austr_results_confidence') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('austr_results_confidence', trans('labels.results_status').':', ['for' => 'austr_results_confidence', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {{ Form::select('austr_results_confidence', $list_confidence, null, ['id' => 'austr_results_confidence', 'class' => 'form-control mav-select','placeholder' => trans('labels.select_attribute', ['attribute'=>'Results Confidence']),'style' => 'width: 100%','dusk'=>'dna-austr_results_confidence' ]) }}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('austr_results_confidence'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('austr_results_confidence') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('austr_sequence_number') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('austr_sequence_number', trans('labels.austr_sequence_number').':', ['for' => 'austr_sequence_number', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::text('austr_sequence_number', null, ['id' => 'austr_sequence_number', 'placeholder' => trans('messages.placeholder_mitoseqNumber'), 'class' => 'col-md-12 form-control','dusk'=>'dna-austr_sequence_number']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('austr_sequence_number'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('austr_sequence_number') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('austr_sequence_subgroup') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('austr_sequence_subgroup', trans('labels.austr_sequence_subgroup').':', ['for' => 'austr_sequence_subgroup', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::text('austr_sequence_subgroup', null, ['id' => 'austr_sequence_subgroup', 'placeholder' => trans('messages.placeholder_austr_subgroup'), 'class' => 'col-md-12 form-control','dusk'=>'dna-austr_sequence_subgroup']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('austr_sequence_subgroup'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('austr_sequence_subgroup') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('austr_sequence_similar') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('austr_sequence_similar', trans('labels.austr_sequence_similar').':', ['for' => 'austr_sequence_similar', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::text('austr_sequence_similar', null, ['id' => 'austr_sequence_similar', 'placeholder' => trans('messages.placeholder_mitoseqSimiliar'), 'class' => 'col-md-12 form-control','dusk'=>'dna-austr_sequence_similar']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('austr_sequence_similar'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('austr_sequence_similar') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('austr_num_loci') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('austr_num_loci', trans('labels.num_loci').':', ['for' => 'austr_num_loci', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::text('austr_num_loci', null, ['id' => 'austr_num_loci', 'placeholder' => trans('messages.placeholder_austr_loci'), 'class' => 'col-md-12 form-control','dusk'=>'dna-austr_num_loci']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('austr_num_loci'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('austr_num_loci') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('austr_loci') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('austr_loci', trans('labels.loci').':', ['for' => 'austr_loci', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::text('austr_loci', null, ['id' => 'austr_loci', 'placeholder' => trans('messages.placeholder_austr_confirmed_regions'), 'class' => 'col-md-12 form-control','dusk'=>'dna-austr_loci']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('austr_loci'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('austr_loci') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group">--}}
{{--        {!! Form::label('austr_mcc_date', trans('labels.mcc_date').':', ['for' => 'austr_mcc_date', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::date('austr_mcc_date', null, ['id' => 'austr_mcc_date', 'class' => 'col-md-12 form-control','dusk'=>'dna-austr_mcc_date']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--        </div>--}}
{{--    </div>--}}

    {{--        <div class="form-group{{ $errors->has('mito_haplogroup_id') ? ' has-error' : '' }}" >
            {!! Form::label('side', trans('Mito Haplogroup').':', ['for' => 'mito_haplogroup_id', 'class' => 'col-md-4 control-label']) !!}
                <div class="col-md-6">
                {{ Form::select('mito_haplogroup_id', $list_haplogroup, null, ['id' => 'mito_haplogroup_id', 'class' => 'form-control mav-select', 'placeholder' => 'Select Haplogroup','dusk'=>'dna-mito_haplogroup' ]) }}
                    <span class="validity"></span>
                @if ($errors->has('mito_haplogroup_id'))
                    <span class="help-block"><strong>{{ $errors->first('mito_haplogroup_id') }}</strong></span>
                @endif
                </div>
             </div>--}}
{{--</div>--}}

