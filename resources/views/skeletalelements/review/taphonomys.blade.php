<div class='col-md-12 float-right'>
    <h2><a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/taphonomys') }}">@lang('labels.taphonomy')</a></h2>
    <a class="help" data-trigger="click" data-toggle="tooltip" data-html="true" data-title='{{trans('messages.review_taphonomy_help')}}'><i class="far fa-lg fa-question-circle" style="padding-right: 10px; color: #3097D1;"></i></a>

    {!! Form::model($skeletalelement, [ 'method' => 'POST', 'action' => ['SkeletalElementsController@storeReviewTaphonomys', $skeletalelement->id]]) !!}
    {{ csrf_field() }}

        <div class="col-md-12 form-group taphonomys">
            <label class="col-md-4 control-label">@lang('labels.initial'): </label>
            {!! Form::select('taphonomylist[]', $list_taphonomy, null, ['id' => 'taphonomys', 'class' => 'form-control taphonomys mav-select', 'multiple', 'style' => 'width: 60%; margin-top: 10px;', 'disabled'=>'disabled']) !!}
        </div>
        <div class="col-md-12 form-group taphonomys">
            <label class="col-md-4 control-label">@lang('labels.review'): </label>
            {!! Form::select('taphonomyreviewlist[]', $list_taphonomy, !empty($taphonomyreviewlist) ? $taphonomyreviewlist : null, ['id' => 'taphonomysReview', 'class' => 'form-control taphonomys mav-select', 'multiple' => true, 'style' => 'width: 60%; margin-top: 10px;','dusk'=>'review-taphonomy_review', 'disabled' => !$SaveButton]) !!}
        </div>

    <div class="d-inline-flex btn-group row col-md-offset-4" role="group">
        @if( $SaveButton )
            <div class="btn-group mr-3" role="group" aria-label="Save">
                {!! Form::button('<i class="fas fa-btn fa-save"></i>Save', ['type' => 'submit', 'class' => 'btn btn-primary', 'dusk'=>'review-taphonomy-save']) !!}
            </div>
        @endif
                {!! Form::close() !!}

        @if( $AcceptButton )
            {!! Form::model($skeletalelement, [ 'method' => 'POST', 'action' => ['SkeletalElementsController@storeAcceptReviewTaphonomys', $skeletalelement->id]]) !!}
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
</div>

<script src="{{ mix('js/app.js') }}"></script>