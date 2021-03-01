{{--<div class="col-lg-12 dna border" style="padding-top: 10px; margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">--}}

{{--    <div class="form-group required form-group{{ $errors->has('ystr_method') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('ystr_method', trans('labels.method').':', ['for' => 'ystr_method', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            @if(isset($dna->ystr_method))--}}
{{--                {{ Form::select('ystr_method', $list_y_method, null, ['id' => 'ystr_method', 'class' => 'form-control mav-select', 'style' => 'width: 100%', 'placeholder' => trans('labels.select_method'), 'dusk'=>'dna-ystr_method' ]) }}--}}
{{--            @else--}}
{{--                {{ Form::select('ystr_method', $list_y_method, $theUser->getProfileValue('default_y_method'), ['id' => 'ystr_method', 'class' => 'form-control mav-select', 'style' => 'width: 100%', 'style' => 'width: 100%', 'dusk'=>'dna-ystr_method' ]) }}--}}
{{--            @endif--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('ystr_method'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('ystr_method') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group">--}}
{{--        {!! Form::label('ystr_request_date', trans('labels.request_date').':', ['for' => 'ystr_request_date', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::date('ystr_request_date', null, ['id' => 'ystr_request_date', 'class' => 'col-md-12 form-control','dusk'=>'dna-ystr_request_date']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group">--}}
{{--        {!! Form::label('ystr_receive_date', trans('labels.receive_date').':', ['for' => 'ystr_receive_date', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::date('ystr_receive_date', null, ['id' => 'ystr_receive_date', 'class' => 'col-md-12 form-control','dusk'=>'dna-ystr_receive_date']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('ystr_results_confidence') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('ystr_results_confidence', trans('labels.results_status').':', ['for' => 'ystr_results_confidence', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {{ Form::select('ystr_results_confidence', $list_confidence, null, ['id' => 'ystr_results_confidence', 'class' => 'form-control mav-select','placeholder' => trans('labels.select_attribute', ['attribute'=>'Results Confidence']), 'style' => 'width: 100%','dusk'=>'dna-ystr_results_confidence' ]) }}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('ystr_results_confidence'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('ystr_results_confidence') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('ystr_sequence_number') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('ystr_sequence_number', trans('labels.ystr_sequence_number').':', ['for' => 'ystr_sequence_number', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::text('ystr_sequence_number', null, ['id' => 'ystr_sequence_number', 'placeholder' => trans('messages.placeholder_mitoseqNumber'), 'class' => 'col-md-12 form-control','dusk'=>'dna-ystr_sequence_number']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('ystr_sequence_number'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('ystr_sequence_number') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('ystr_sequence_similar') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('ystr_sequence_similar', trans('labels.ystr_sequence_similar').':', ['for' => 'ystr_sequence_similar', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::text('ystr_sequence_similar', null, ['id' => 'ystr_sequence_similar', 'placeholder' => trans('messages.placeholder_mitoseqSimiliar'), 'class' => 'col-md-12 form-control','dusk'=>'dna-ystr_sequence_similar']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('ystr_sequence_similar'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('ystr_sequence_similar') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div>--}}
{{--        <div class="form-group{{ $errors->has('ystr_match_count') ? ' has-error' : '' }}">--}}
{{--            {!! Form::label('ystr_match_count', trans('labels.ystr_match_count').' / '. trans('labels.population_frequency').':', ['for' => 'ystr_match_count', 'class' => 'col-md-4 control-label']) !!}--}}
{{--            <div class="col-md-6">--}}
{{--                {!! Form::text('ystr_match_count', null, ['id' => 'ystr_match_count', 'placeholder' => trans('messages.placeholder_mitomatch'), 'class' => 'col-md-5 form-control','dusk'=>'dna-ystr_match_count']) !!}--}}
{{--                --}}{{--<span class="validity"></span>--}}
{{--                @if ($errors->has('ystr_match_count'))--}}
{{--                    <span class="help-block"><strong>{{ $errors->first('ystr_match_count') }}</strong></span>--}}
{{--                @endif--}}

{{--                {!! Form::label('slash', ' / ', ['for' => '/', 'class' => 'col-md-2 control-label', 'style' => 'text-align: center;']) !!}--}}

{{--                {!! Form::text('ystr_total_count', null, ['id' => 'ystr_total_count', 'placeholder' => trans('messages.placeholder_mitototal'), 'class' => 'col-md-5 form-control','dusk'=>'dna-ystr_total_count']) !!}--}}
{{--                <span class="validity"></span>--}}
{{--                @if ($errors->has('ystr_total_count'))--}}
{{--                    <span class="help-block"><strong>{{ $errors->first('mito_total_count') }}</strong></span>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('ystr_num_loci') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('ystr_num_loci', trans('labels.num_loci').':', ['for' => 'ystr_num_loci', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::text('ystr_num_loci', null, ['id' => 'ystr_num_loci', 'placeholder' => trans('messages.placeholder_ystr_loci'), 'class' => 'col-md-12 form-control','dusk'=>'dna-ystr_num_loci']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('ystr_num_loci'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('ystr_num_loci') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('ystr_loci') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('ystr_loci', trans('labels.loci').':', ['for' => 'ystr_loci', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::text('ystr_loci', null, ['id' => 'ystr_loci', 'placeholder' => trans('messages.placeholder_ystr_confirmed_regions'), 'class' => 'col-md-12 form-control','dusk'=>'dna-ystr_loci']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('ystr_loci'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('ystr_loci') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('ystr_haplogroup') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('ystr_haplogroup', trans('Y Haplogroup').':', ['for' => 'ystr_haplogroup', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {{ Form::select('ystr_haplogroup', $list_y_haplogroup, null, ['id' => 'ystr_haplogroup', 'class' => 'form-control mav-select', 'style' => 'width: 100%', 'placeholder' => 'Select Haplogroup','dusk'=>'dna-y_haplogroup' ]) }}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('ystr_haplogroup'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('ystr_haplogroup') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}


{{--    <div class="form-group">--}}
{{--        {!! Form::label('ystr_mcc_date', trans('labels.mcc_date').':', ['for' => 'ystr_mcc_date', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::date('ystr_mcc_date', null, ['id' => 'ystr_mcc_date', 'class' => 'col-md-12 form-control','dusk'=>'dna-ystr_mcc_date']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

