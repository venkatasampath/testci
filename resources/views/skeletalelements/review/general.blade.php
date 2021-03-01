<div>
    <h2><a href="{{ url('/skeletalelements/'.$skeletalelement->id) }}">@lang('labels.general')</a></h2>
    <a class="help" data-trigger="click" data-toggle="tooltip" data-html="true" data-title='{{trans('messages.review_general_help')}}'><i class="far fa-lg fa-question-circle" style="padding-right: 10px; color: #3097D1;"></i></a>
</div>
{!! Form::model($skeletalelement, [ 'method' => 'POST', 'action' => ['SkeletalElementsController@storeReviewGeneral', $skeletalelement->id]]) !!}
    {{ csrf_field() }}
    <div class="form-group row">
        <label class="col-md-4 offset-3 control-label">@lang('labels.initial')</label>
        <label class="col-md-4 control-label">@lang('labels.review')</label>
    </div>
    <div class="form-group row">
        <label class="col-md-3 control-label">@lang('labels.bone'): </label>
        <div class="col-md-4">
            {{ Form::select('sb_id', $list_sb, null, ['id' => 'sb', 'class' => 'form-control', 'disabled']) }}
        </div>
        <div class="col-md-4">
            {{ Form::select('sb_id_review', $list_sb, !empty($reviewGenerals['sb_id_review']) ? $reviewGenerals['sb_id_review'] : null, ['id' => 'sb_review', 'class' => 'form-control mav-select','placeholder' => 'Select Bone' , 'dusk'=>'review-general-bone', 'disabled' => !$SaveButton]) }}
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-3 control-label">@lang('labels.side'): </label>
        <div class="col-md-4">
            {{ Form::select('side', $list_side, null, ['id' => 'side', 'class' => 'form-control', 'disabled']) }}
        </div>
        <div class="col-md-4">
            {{ Form::select('side_review', $list_side, !empty($reviewGenerals['side_review']) ? $reviewGenerals['side_review'] : null, ['id' => 'side_review', 'class' => 'form-control mav-select','placeholder' => 'Select Side', 'dusk'=>'review-general-side', 'disabled' => !$SaveButton]) }}
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-3 control-label">@lang('labels.completeness'): </label>
        <div class="col-md-4">
            {{ Form::select('completeness', $list_completeness, null, ['id' => 'completeness', 'class' => 'form-control', 'disabled']) }}
        </div>
        <div class="col-md-4">
            {{ Form::select('completeness_review', $list_completeness, !empty($reviewGenerals['completeness_review']) ? $reviewGenerals['completeness_review'] : null, ['id' => 'completeness_review', 'class' => 'form-control mav-select','placeholder' => 'Select Completeness', 'dusk'=>'review-general-completeness', 'disabled' => !$SaveButton]) }}
        </div>
    </div>

    @if ($skeletalelement->sb->countable) <!-- If Specimen is Countable (display Count and Mass -->
    <div class="form-group row"><!-- Count -->
        {!! Form::label('count', 'Count:', ['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::number('count', null, ['class' => 'col-md-12 form-control', 'disabled', 'placeholder' => trans('messages.placeholder_count'), 'dusk' =>'se-count','width'=>'5em','min'=>0,'max'=>10000,'step'=>1])!!}
            <span class="validility"></span>
            @if ($errors->has('count'))
                <span class="help-block"><strong>{{ $errors->first('count') }}</strong></span>
            @endif
        </div>
        <div class="col-md-4"><!-- If count review is present in reviewGenerals then populate it otherwise null-->
            {!! Form::number('count_review', !empty($reviewGenerals['count_review']) ? $reviewGenerals['count_review']: null, ['class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_count'), 'dusk' =>'se-count','width'=>'5em','min'=>0,'max'=>10000,'step'=>1]) !!}
            @if ($errors->has('count_review'))
                <span class="help-block"><strong>{{ $errors->first('count_review') }}</strong></span>
            @endif
        </div>
    </div>
    <div class="form-group row"><!-- Mass-->
        {!! Form::label('mass', 'Mass:', ['for'=>"mass", 'class' => 'col-md-3 control-label']) !!}
        <div class="col-md-4">
            {!! Form::number('mass', null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'disabled', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}
            @if ($errors->has('mass'))
                <span class="help-block"><strong>{{ $errors->first('mass') }}</strong></span>
            @endif
        </div>
        <div class="col-md-4"> <!-- If mass review is present in reviewGenerals then populate it otherwise null-->
            {!! Form::number('mass_review', !empty($reviewGenerals['mass_review']) ? $reviewGenerals['mass_review']: null, ['id' => 'mass', 'class' => 'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_mass'), 'dusk' =>'se-mass','width'=>'5em','min'=>0,'max'=>10000,'step'=>"any"]) !!}
            @if ($errors->has('mass_review'))
                <span class="help-block"><strong>{{ $errors->first('mass_review') }}</strong></span>
            @endif
        </div>
    </div>
    @endif <!-- If Specimen is Countable (display Count and Mass -->

    <br>
<div class="d-inline-flex btn-group row col-md-offset-4" role="group">
    @if($SaveButton)
        <div class="btn-group mr-3" role="group" aria-label="Save">
            {!! Form::button('<i class="fas fa-btn fa-save"></i> Save', ['type' => 'submit', 'class' => 'btn btn-primary', 'dusk'=>'review-general-save']) !!}
        </div>
    @endif
    {!! Form::close() !!}

    @if($AcceptButton)
        {!! Form::model($skeletalelement, [ 'method' => 'POST', 'action' => ['SkeletalElementsController@storeAcceptReviewGeneral', $skeletalelement->id]]) !!}
        {{ csrf_field() }}
        <div class="btn-group mr-3" role="group" aria-label="Accept">
            {!! Form::button('<i class="fas fa-btn fa-thumbs-up"></i>Accept', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
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

<script src="{{ mix('js/app.js') }}"></script>