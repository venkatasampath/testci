<h2><a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/dnas') }}">@lang('labels.dna_profile')</a></h2>
<a class="help" data-trigger="click" data-toggle="tooltip" data-html="true" data-title='{{trans('messages.review_dna_help')}}'><i class="far fa-lg fa-question-circle" style="padding-right: 10px; color: #3097D1;"></i></a>

<div class='col-md-12 float-right'>
    {!! Form::model($skeletalelement->dnas, ['method' => 'POST', 'action' => ['SkeletalElementsController@storeReviewDNA', $skeletalelement->id], 'id'=>'dnaForm']) !!}
    {{ csrf_field() }}
    @if(!empty($dnas) && count($dnas) > 0)
        @foreach($dnas as $dna)
            <div class="card">
                <div class="card-header" style="height: 35px;">
                    <div class="float-left">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseDNA{{$dna->sample_number}}" class="">{{ $dna->sample_number }}
                            <span class="caret"></span></a>
                    </div>
                </div>
                <div id="collapseDNA{{$dna->sample_number}}" class="card-collapse card-body collapse">
                    <div class="col-md-10">
                        <h3><a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/dnas/'.$dna->id) }}">{{$dna->sample_number}}</a></h3>
                        <fieldset>
                            <div class="form-group row">
                                <label class="col-md-4 offset-4 control-label">@lang('labels.initial')</label>
                                <label class="col-md-4 control-label">@lang('labels.review')</label>
                            </div>
                            <div class="form-group{{ $errors->has('lab_id') ? ' has-error' : '' }} row">
                                {!! Form::label('lab_id', trans('labels.lab_id') . ':', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-4 ">
                                    <input type='hidden' name='dnas[original][se_dna_id][{{$dna->id}}][lab_id]' value='{{$dna->lab_id}}'/>
                                    {!! Form::text('dnas[original][se_dna_id]['.$dna->id.'][lab_id]', $dna->lab_id, ['class' => 'col-md-12 form-control', 'disabled']) !!}
                                    @if ($errors->has('lab_id'))
                                        <span class="help-block"><strong>{{ $errors->first('lab_id') }}</strong></span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    {!! Form::text('dnas[review][se_dna_id]['.$dna->id.'][lab_id]', !empty($dnaReview[$dna->id]['lab_id']) ? $dnaReview[$dna->id]['lab_id'] : null, ['class' => 'col-md-12 form-control', 'dusk'=>'review-dna_profile-lab_id', 'disabled' => !$SaveButton]) !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('method') ? ' has-error' : '' }} row">
                                {!! Form::label('method', trans('labels.method').':', ['for' => 'method', 'class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-4">
                                    <input type='hidden' name="dnas[original][se_dna_id][{{$dna->id}}][method]" value='{{$dna->method}}'/>
                                    {{ Form::select('dnas[original][se_dna_id]['.$dna->id.'][method]', $list_method, null, ['id' => 'method', 'disabled'=>'disabled', 'class' => 'form-control','dusk'=>'dna-method' ]) }}
                                    @if ($errors->has('method'))
                                        <span class="help-block"><strong>{{ $errors->first('method') }}</strong></span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    {{ Form::select('dnas[review][se_dna_id]['.$dna->id.'][method]', $list_method, !empty($dnaReview[$dna->id]['method']) ? $dnaReview[$dna->id]['method'] : null, ['id' => 'method', 'class' => 'form-control mav-select','style'=>'', 'placeholder' => 'Select Method', 'dusk'=>'review-method', 'disabled' => !$SaveButton]) }}
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('external_case_id') ? ' has-error' : '' }} row">
                                {!! Form::label('external_case_id', trans('labels.external_case_#') . ':', ['for' => 'external_case_id', 'class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-4">
                                    <input type='hidden' name="dnas[original][se_dna_id][{{$dna->id}}][external_case_id]" value='{{$dna->external_case_id}}'/>
                                    {!! Form::text('dnas[original][se_dna_id]['.$dna->id.'][external_case_id]', $dna->external_case_id, ['id' => 'external_case_id', 'class' => 'col-md-12 form-control','disabled'=>'disabled', 'dusk'=>'dna-external_case']) !!}
                                    @if ($errors->has('external_case_id'))
                                        <span class="help-block"><strong>{{ $errors->first('external_case_id') }}</strong></span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    {!! Form::text('dnas[review][se_dna_id]['.$dna->id.'][external_case_id]', !empty($dnaReview[$dna->id]['external_case_id']) ? $dnaReview[$dna->id]['external_case_id'] : null, ['class' => 'col-md-12 form-control' , 'dusk'=>'review-dna_external_case_id', 'disabled' => !$SaveButton]) !!}
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('sample_number') ? ' has-error' : '' }} row">
                                {!! Form::label('sample_number', trans('labels.dna_sample_number') . ':', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-4">
                                    <input type='hidden' name="dnas[original][se_dna_id][{{$dna->id}}][sample_number]" value='{{$dna->sample_number}}'/>
                                    {!! Form::text('dnas[original][se_dna_id]['.$dna->id.'][sample_number]', $dna->sample_number, ['class' => 'col-md-12 form-control', 'disabled'=>'disabled']) !!}
                                    @if ($errors->has('sample_number'))
                                        <span class="help-block"><strong>{{ $errors->first('sample_number') }}</strong></span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    {!! Form::text('dnas[review][se_dna_id]['.$dna->id.'][sample_number]', !empty($dnaReview[$dna->id]['sample_number']) ? $dnaReview[$dna->id]['sample_number'] : null, ['class' => 'col-md-12 form-control' , 'dusk'=>'review-dna_sample_number', 'disabled' => !$SaveButton]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                {!! Form::label('mito_receive_date', trans('labels.receive_date') . ':', ['for' => 'mito_receive_date', 'class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-4">
                                    <input type='hidden' name="dnas[original][se_dna_id][{{$dna->id}}][mito_receive_date]" value='{{$dna->mito_receive_date}}'/>
                                    {!! Form::date('dnas[original][se_dna_id]['.$dna->id.'][mito_receive_date]', $dna->mito_receive_date, ['id' => 'mito_receive_date', 'class' => 'col-md-12 form-control', 'disabled' => 'disabled', 'dusk'=>'dna-mito_receive_date']) !!}
                                </div>
                                <div class="col-md-4">
                                    {!! Form::date('dnas[review][se_dna_id]['.$dna->id.'][mito_receive_date]', !empty($dnaReview[$dna->id]['mito_receive_date']) ? $dnaReview[$dna->id]['mito_receive_date'] : null, ['class' => 'col-md-12 form-control', 'dusk'=>'review-mito_receive_date', 'disabled' => !$SaveButton]) !!}
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('results_confidence') ? ' has-error' : '' }} row">
                                {!! Form::label('results_confidence', trans('labels.results_status').':', ['for' => 'results_confidence', 'class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-4">
                                    <input type='hidden' name="dnas[original][se_dna_id][{{$dna->id}}][results_confidence]" value='{{$dna->results_confidence}}'/>
                                    {{ Form::select('dnas[original][se_dna_id]['.$dna->id.'][results_confidence]', $list_confidence, $dna->results_confidence, ['id' => 'results_confidence','disabled'=>'disabled', 'class' => 'form-control', 'placeholder' => 'Select Confidence','dusk'=>'dna-results_confidence' ]) }}
                                    @if ($errors->has('results_confidence'))
                                        <span class="help-block"><strong>{{ $errors->first('results_confidence') }}</strong></span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    {{ Form::select('dnas[review][se_dna_id]['.$dna->id.'][results_confidence]', $list_confidence, !empty($dnaReview[$dna->id]['results_confidence']) ? $dnaReview[$dna->id]['results_confidence'] : null, ['id' => 'results_confidence', 'class' => 'form-control mav-select','style'=>'', 'placeholder' => 'Select Confidence', 'dusk'=>'review-results_confidence', 'disabled' => !$SaveButton]) }}
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('mito_sequence_number') ? ' has-error' : '' }} row">
                                {!! Form::label('mito_sequence_number', trans('labels.mito_sequence_number').':', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-4">
                                    <input type='hidden' name="dnas[original][se_dna_id][{{$dna->id}}][mito_sequence_number]" value='{{$dna->mito_sequence_number}}'/>
                                    {!! Form::text('dnas[original][se_dna_id]['.$dna->id.'][mito_sequence_number]', $dna->mito_sequence_number, ['class' => 'col-md-12 form-control', 'disabled'=>'disabled']) !!}
                                    @if ($errors->has('mito_sequence_number'))
                                        <span class="help-block"><strong>{{ $errors->first('mito_sequence_number') }}</strong></span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    {!! Form::text('dnas[review][se_dna_id]['.$dna->id.'][mito_sequence_number]', !empty($dnaReview[$dna->id]['mito_sequence_number']) ? $dnaReview[$dna->id]['mito_sequence_number'] : null, ['class' => 'col-md-12 form-control', 'dusk'=>'review-dna-mito_squence_number', 'disabled' => !$SaveButton]) !!}
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('mito_sequence_subgroup') ? ' has-error' : '' }} row">
                                {!! Form::label('mito_sequence_subgroup', trans('labels.mito_sequence_subgroup').':', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-4">
                                    <input type='hidden' name="dnas[original][se_dna_id][{{$dna->id}}][mito_sequence_subgroup]" value='{{$dna->mito_sequence_subgroup}}'/>
                                    {!! Form::text('dnas[original][se_dna_id]['.$dna->id.'][mito_sequence_subgroup]', $dna->mito_sequence_subgroup, ['class' => 'col-md-12 form-control', 'disabled'=>'disabled']) !!}
                                    @if ($errors->has('mito_sequence_subgroup'))
                                        <span class="help-block"><strong>{{ $errors->first('mito_sequence_subgroup') }}</strong></span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    {!! Form::text('dnas[review][se_dna_id]['.$dna->id.'][mito_sequence_subgroup]', !empty($dnaReview[$dna->id]['mito_sequence_subgroup']) ? $dnaReview[$dna->id]['mito_sequence_subgroup'] : null, ['class' => 'col-md-12 form-control', 'dusk'=>'review-dna_mito_sequence_subgroup', 'disabled' => !$SaveButton]) !!}
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('mito_sequence_similar') ? ' has-error' : '' }} row">
                                {!! Form::label('mito_sequence_similar', trans('labels.mito_sequence_similar').':', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-4">
                                    <input type='hidden' name="dnas[original][se_dna_id][{{$dna->id}}][mito_sequence_similar]" value='{{$dna->mito_sequence_similar}}'/>
                                    {!! Form::text('dnas[original][se_dna_id]['.$dna->id.'][mito_sequence_similar]', $dna->mito_sequence_similar, ['class' => 'col-md-12 form-control', 'disabled'=>'disabled']) !!}
                                    @if ($errors->has('mito_sequence_similar'))
                                        <span class="help-block"><strong>{{ $errors->first('mito_sequence_similar') }}</strong></span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    {!! Form::text('dnas[review][se_dna_id]['.$dna->id.'][mito_sequence_similar]', !empty($dnaReview[$dna->id]['mito_sequence_similar']) ? $dnaReview[$dna->id]['mito_sequence_similar'] : null, ['class' => 'col-md-12 form-control', 'dusk'=>'review-dna_mito_sequence_similar', 'disabled' => !$SaveButton]) !!}
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('num_loci') ? ' has-error' : '' }} row">
                                {!! Form::label('num_loci', trans('labels.num_loci').':', ['for' => 'num_loci', 'class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-4">
                                    <input type='hidden' name="dnas[original][se_dna_id][{{$dna->id}}][num_loci]" value='{{$dna->num_loci}}'/>
                                    {!! Form::text('dnas[original][se_dna_id]['.$dna->id.'][num_loci]', $dna->num_loci, ['id' => 'num_loci', 'class' => 'col-md-12 form-control', 'disabled' => 'disabled', 'dusk'=>'dna-num_loci']) !!}
                                    @if ($errors->has('num_loci'))
                                        <span class="help-block"><strong>{{ $errors->first('num_loci') }}</strong></span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    {!! Form::text('dnas[review][se_dna_id]['.$dna->id.'][num_loci]', !empty($dnaReview[$dna->id]['num_loci']) ? $dnaReview[$dna->id]['num_loci'] : null, ['class' => 'col-md-12 form-control', 'dusk'=>'review-num_loci', 'disabled' => !$SaveButton]) !!}
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('mito_match_count') ? ' has-error' : '' }} row">
                                {!! Form::label('mito_match_count', trans('labels.mito_match_count').':', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-4">
                                    <input type='hidden' name="dnas[original][se_dna_id][{{$dna->id}}][mito_match_count]" value='{{$dna->mito_match_count}}'/>
                                    {!! Form::text('dnas[original][se_dna_id]['.$dna->id.'][mito_match_count]', $dna->mito_match_count, ['class' => 'col-md-12 form-control', 'disabled'=>'disabled']) !!}
                                    @if ($errors->has('mito_match_count'))
                                        <span class="help-block"><strong>{{ $errors->first('mito_match_count') }}</strong></span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    {!! Form::text('dnas[review][se_dna_id]['.$dna->id.'][mito_match_count]', !empty($dnaReview[$dna->id]['mito_match_count']) ? $dnaReview[$dna->id]['mito_match_count'] : null, ['class' => 'col-md-12 form-control', 'dusk'=>'review-dna_mito_match_count', 'disabled' => !$SaveButton]) !!}
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('mito_total_count') ? ' has-error' : '' }} row">
                                {!! Form::label('mito_total_count', trans('labels.mito_total_count').':', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-4">
                                    <input type='hidden' name="dnas[original][se_dna_id][{{$dna->id}}][mito_total_count]" value='{{$dna->mito_total_count}}'/>
                                    {!! Form::text('dnas[original][se_dna_id]['.$dna->id.'][mito_total_count]', $dna->mito_total_count, ['class' => 'col-md-12 form-control', 'disabled'=>'disabled']) !!}
                                    @if ($errors->has('mito_total_count'))
                                        <span class="help-block"><strong>{{ $errors->first('mito_total_count') }}</strong></span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    {!! Form::text('dnas[review][se_dna_id]['.$dna->id.'][mito_total_count]', !empty($dnaReview[$dna->id]['mito_total_count']) ? $dnaReview[$dna->id]['mito_total_count'] : null, ['class' => 'col-md-12 form-control', 'dusk'=>'review-dna_mito_total_count', 'disabled' => !$SaveButton]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                {!! Form::label('mcc_date', trans('labels.mcc_date').':', ['for' => 'mcc_date', 'class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-4">
                                    <input type='hidden' name="dnas[original][se_dna_id][{{$dna->id}}][mcc_date]" value='{{$dna->mcc_date}}'/>
                                    {!! Form::date('dnas[original][se_dna_id]['.$dna->id.'][mcc_date]', $dna->mcc_date, ['id' => 'mcc_date', 'class' => 'col-md-12 form-control', 'disabled' => 'disabled', 'dusk'=>'dna-mcc_date']) !!}
                                </div>
                                <div class="col-md-4">
                                    {!! Form::date('dnas[review][se_dna_id]['.$dna->id.'][mcc_date]', !empty($dnaReview[$dna->id]['mcc_date']) ? $dnaReview[$dna->id]['mcc_date'] : null, ['class' => 'col-md-12 form-control', 'dusk'=>'review-mcc_date', 'disabled' => !$SaveButton]) !!}
                                </div>
                            </div>

                            <br>
                        </fieldset>
                    </div>
                </div>
            </div>
            <br>
        @endforeach
    @else
        <p>@lang('messages.no_dnas_entered')</p>
    @endif
    <div class="d-inline-flex btn-group row col-md-offset-4" role="group">
        @if( $SaveButton )
            <div class="btn-group mr-3" role="group" aria-label="Save">
                {!! Form::button('<i class="fas fa-btn fa-save"></i>Save', ['type' => 'submit', 'class' => 'btn btn-primary' , 'dusk'=>'review-dna_profile-save']) !!}
            </div>
        @endif

        {!! Form::close() !!}

        @if( $AcceptButton )
            {!! Form::model($skeletalelement, [ 'method' => 'POST', 'action' => ['SkeletalElementsController@storeAcceptReviewDNA', $skeletalelement->id]]) !!}
            {{ csrf_field() }}
            <div class="btn-group mr-3" role="group" aria-label="Accept">
                {!! Form::button('<i class="fas fa-btn fa-save"></i>Accept', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        @endif

        {{--    <div class="btn-group mr-3" role="group" aria-label="Notify Examiner">--}}
        {{--        <button type="button" class="btn btn-primary"><i class="fas fa-btn fa-paper-plane"></i> Notify Analyst</button>--}}
        {{--    </div>--}}

        @if($ReviewComplete)
            {!! Form::model($skeletalelement, ['method'=> 'POST', 'action' => ['SkeletalElementsController@ReviewCompleteStateButton', $skeletalelement->id]]) !!}
            {{ csrf_field() }}
            <div class="btn-group mr-3" role="group" aria-label="Reviewed">
                {!! Form::button(' '.($skeletalelement->reviewed)==1 ? '<i class="fas fa-history"></i> Undo Review':'<i class="fas fa-btn fa-check-double"></i> Reviewed', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
        @endif
    </div>
</div><!-- end dna col -->

<script src="{{ mix('js/app.js') }}"></script>
