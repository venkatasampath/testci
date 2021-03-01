<div class='col-md-12 float-right'>
    <h2>
        @lang('labels.associations') -
        @if($skeletalelement->skeletalbone->articulated)
            <a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/articulations') }}">@lang('labels.articulations')</a>
        @endif
        @if($skeletalelement->skeletalbone->paired)
            <a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/pairs') }}">@lang('labels.pair_matching')</a>
        @endif
        <a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/refits') }}">@lang('labels.refits')</a>
    </h2>
    <a class="help" data-trigger="click" data-toggle="tooltip" data-html="true" data-title='{{trans('messages.review_articulations_help')}}'><i class="far fa-lg fa-question-circle" style="padding-right: 10px; color: #3097D1;"></i></a>
    {!! Form::model($skeletalelement, ['method' => 'POST', 'action' => ['SkeletalElementsController@storeReviewAssociations', $skeletalelement->id]]) !!}
        {{ csrf_field() }}

        @if($skeletalelement->skeletalbone->articulated)
            @include('skeletalelements.review.articulations')
        @endif
        @if($skeletalelement->skeletalbone->paired)
            @include('skeletalelements.review.pairmatching')
        @endif
        @include('skeletalelements.review.refits')

    <div class="d-inline-flex btn-group row col-md-offset-4" role="group">
        {{--    <div class="btn-group mr-3" role="group" aria-label="Notify Examiner">--}}
        {{--        <button type="button" class="btn btn-primary"><i class="fas fa-btn fa-paper-plane"></i> Notify Analyst</button>--}}
        {{--    </div>--}}

        {!! Form::close() !!}

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