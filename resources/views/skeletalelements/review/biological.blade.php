<h2>
    @lang('labels.biological_profile') -
    @if($skeletalelement->skeletalbone->hasMethodsByType('Age'))
    <a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/age') }}">@lang('labels.age')</a>
    @endif
    @if($skeletalelement->skeletalbone->hasMethodsByType('Sex'))
    <a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/sex') }}">@lang('labels.sex')</a>
    @endif
    @if($skeletalelement->skeletalbone->hasMethodsByType('Ancestry'))
    <a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/ancestry') }}">@lang('labels.ancestry')</a>
    @endif
</h2>
<a class="help" data-trigger="click" data-toggle="tooltip" data-html="true" data-title='{{trans('messages.review_biological_help')}}'><i class="far fa-lg fa-question-circle" style="padding-right: 10px; color: #3097D1;"></i></a>
{!! Form::model($skeletalelement, [ 'method' => 'POST', 'action' => ['SkeletalElementsController@storeReviewBiologicalProfile', $skeletalelement->id]]) !!}
{{ csrf_field() }}

@if($skeletalelement->skeletalbone->hasMethodsByType('Age') && !empty($origAgeMethods))
    @include ('skeletalelements.review.methods', ['methodType' => 'Age', 'skeletalelement' => $skeletalelement, 'methods'=>$origAgeMethods, 'reviewMethods'=>$reviewMethods])
@endif

@if($skeletalelement->skeletalbone->hasMethodsByType('Sex') && !empty($origSexMethods))
    @include ('skeletalelements.review.methods', ['methodType' => 'Sex', 'skeletalelement' => $skeletalelement, 'methods'=>$origSexMethods, 'reviewMethods'=>$reviewMethods])
@endif

@if($skeletalelement->skeletalbone->hasMethodsByType('Ancestry') && !empty($origAncestryMethods))
    @include ('skeletalelements.review.methods', ['methodType' => 'Ancestry', 'skeletalelement' => $skeletalelement, 'methods'=>$origAncestryMethods, 'reviewMethods'=>$reviewMethods])
@endif

<br/>
@if($skeletalelement->skeletalbone->hasMethods())
    <div class="d-inline-flex btn-group row col-md-offset-4" role="group">
        @if($SaveButton)
            <div class="btn-group mr-3" role="group" aria-label="Save">
                {!! Form::button('<i class="fas fa-btn fa-save"></i>Save', ['type' => 'submit', 'class' => 'btn btn-primary', 'dusk'=>'review-biological_profile-save']) !!}
            </div>
        @endif
        {!! Form::close() !!}

        @if($AcceptButton)
            {!! Form::model($skeletalelement, [ 'method' => 'POST', 'action' => ['SkeletalElementsController@storeAcceptReviewBiologicalProfile', $skeletalelement->id]]) !!}
            {{csrf_field()}}
            <div class="btn-group mr-3" role="group" aria-label="Accept">
                {!! Form::button('<i class="fas fa-btn fa-save"></i>Accept', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        @endif

        {{--            <div class="btn-group mr-3" role="group" aria-label="Notify Examiner">--}}
        {{--                <button type="button" class="btn btn-primary"><i class="fas fa-btn fa-paper-plane"></i> Notify Analyst</button>--}}
        {{--            </div>--}}

        @if($ReviewComplete)
            {!! Form::model($skeletalelement, ['method'=> 'POST', 'action' => ['SkeletalElementsController@ReviewCompleteStateButton', $skeletalelement->id]]) !!}
            {{ csrf_field() }}
            <div class="btn-group mr-3" role="group" aria-label="Reviewed">
                {!! Form::button(' '.($skeletalelement->reviewed)==1 ? '<i class="fas fa-history"></i> Undo Review':'<i class="fas fa-btn fa-check-double"></i> Reviewed', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
        @endif
    </div>
@endif
<script src="{{ mix('js/app.js') }}"></script>