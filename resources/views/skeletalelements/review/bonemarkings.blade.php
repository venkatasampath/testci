<div class='col-md-12 float-right'>
    <h2>
        <a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/pathologys') }}">@lang('labels.pathology')</a>
        <a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/traumas') }}">@lang('labels.trauma')</a>
        @if($skeletalelement->skeletalbone->hasAnomalys())
        <a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/anomalys') }}">@lang('labels.anomaly')</a>
        @endif
    </h2>
    <a class="help" data-trigger="click" data-toggle="tooltip" data-html="true" data-title='{{trans('messages.review_pathology_help')}}'><i class="far fa-lg fa-question-circle" style="padding-right: 10px; color: #3097D1;"></i></a>
    {!! Form::model($skeletalelement, ['class' => 'form-horizontal', 'method' => 'POST', 'action' => ['SkeletalElementsController@storeReviewPathology', $skeletalelement->id]]) !!}
        {{ csrf_field() }}

        @include ('skeletalelements.review.pathology', ['skeletalelement' => $skeletalelement])
        @if(!empty($origPathologys))
            @include ('skeletalelements.review.pathology', ['methodType' => 'Age', 'skeletalelement' => $skeletalelement, 'methods'=>$origAgeMethods, 'reviewMethods'=>$reviewMethods])
        @endif

        @include ('skeletalelements.review.trauma', ['skeletalelement' => $skeletalelement])
        @if(!empty($origTraumas))
            @include ('skeletalelements.review.trauma', ['methodType' => 'Sex', 'skeletalelement' => $skeletalelement, 'methods'=>$origSexMethods, 'reviewMethods'=>$reviewMethods])
        @endif

        @if($skeletalelement->skeletalbone->hasAnomalys())
            @include ('skeletalelements.review.anomaly', ['skeletalelement' => $skeletalelement])
        @endif
        {{--
        @if(!empty($origAnomolys))
            @include ('skeletalelements.review.anomoly', ['methodType' => 'Ancestry', 'skeletalelement' => $skeletalelement, 'methods'=>$origAncestryMethods, 'reviewMethods'=>$reviewMethods])
        @endif
        --}}
        <br/>

    <div class="d-inline-flex btn-group row col-md-offset-4" role="group">
        @if( $SaveButton )
            <div class="btn-group mr-3" role="group" aria-label="Save">
                {!! Form::button('<i class="fas fa-btn fa-save"></i>Save', ['type' => 'submit', 'class' => 'btn btn-primary', 'dusk'=>'review-pathology-save']) !!}
            </div>
        @endif
        {!! Form::close() !!}

        @if( $AcceptButton )
            {!! Form::model($skeletalelement, [ 'method' => 'POST', 'action' => ['SkeletalElementsController@storeAcceptReviewPathology', $skeletalelement->id]]) !!}
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