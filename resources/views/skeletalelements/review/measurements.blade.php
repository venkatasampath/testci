<div class='col-md-12 float-right'>
    <h2><a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/measurements') }}">@lang('labels.measurements')</a></h2>
    <a class="help" data-trigger="click" data-toggle="tooltip" data-html="true" data-title='{{trans('messages.review_measurements_help')}}'><i class="far fa-lg fa-question-circle" style="padding-right: 10px; color: #3097D1;"></i></a>
    {!! Form::model($skeletalelement, [ 'method' => 'POST', 'action' => ['SkeletalElementsController@storeReviewMeasurements', $skeletalelement->id]]) !!}
        {{ csrf_field() }}

        <div class="form-group row">
            <label class="col-md-2 offset-6 control-label">@lang('labels.initial')</label>
            <label class="col-md-2 control-label">@lang('labels.review')</label>
        </div>

        @foreach ($measurements as $key=>$current)
            <fieldset class="measurements" data-m-help_url="{{$current->help_url}}">
                {!! Form::label('measure', $current->display_name, ['class' => 'col-md-6 control-label']) !!}
                <div class="col-md-2 form-group">
                    {!! Form::hidden('measurements['.$current->id.'][id]', $current->id) !!}
                    @if($skeletalelement->measurements()->where('measurement_id', $current->id)->get()->count() == 1)
                        {!! Form::number('measurements['.$current->id.'][measure]', $skeletalelement->getMeasure($current->id), ['class' => 'col-md-12 form-control', 'min' => '0', 'step' => '0.01', 'disabled'=>'disabled']) !!}
                    @else
                        {!! Form::number('measurements['.$current->id.'][measure]', null, ['class' => 'col-md-12 form-control', 'min' => '0', 'step' => '0.01', 'disabled'=>'disabled']) !!}
                    @endif
                </div>
                <div class="col-md-2 form-group">
                    {!! Form::hidden('measurements['.$current->id.'][id]', $current->id) !!}
                    @if(array_key_exists($current->id, $reviewMeasurements))
                        {!! Form::number('measurementsreview['.$current->id.'][measure]', $reviewMeasurements[$current->id], ['class' => 'col-md-12 form-control', 'min' => '0', 'step' => '0.01','dusk'=>"review-measurement-1-{$key}", 'disabled' => !$SaveButton]) !!}
                    @else
                        {!! Form::number('measurementsreview['.$current->id.'][measure]', null, ['class' => 'col-md-12 form-control', 'min' => '0', 'step' => '0.01','dusk'=>"review-measurement-2-{$key}", 'disabled' => !$SaveButton]) !!}
                    @endif

                </div>
                <div class="col-md-1 form-group">
                    {!! Form::label('uom', $theOrg->getProfileValue('org_length_unit_of_measure'), ['class' => 'control-label']) !!}
                </div>

            </fieldset>
        @endforeach

    <div class="d-inline-flex btn-group row col-md-offset-4" role="group">
        @if( $SaveButton )
            <div class="btn-group mr-3" role="group" aria-label="Save">
                {!! Form::button('<i class="fas fa-btn fa-save"></i>Save', ['type' => 'submit', 'name'=>'action', 'value'=>'Save', 'class' => 'btn btn-primary','dusk'=>'review-measurement-save']) !!}
            </div>
        @endif

        @if( $AcceptButton )
            <div class="btn-group mr-3" role="group" aria-label="Accept">
                {!! Form::button('<i class="fas fa-btn fa-save"></i>Accept', ['type' => 'submit', 'name'=>'action', 'value'=>'Accept', 'class' => 'btn btn-primary']) !!}

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

    <script>
        (function change_url() {
            var help_url = $("fieldset.measurements").data("m-help_url");

            $('#help-info').attr('src', help_url);

            if ($('#control-sidebar-theme-tab').hasClass('active')) {
                $('#control-sidebar-theme-tab').removeClass('active');
                $('#control-sidebar-help-tab').toggleClass('active');
            }
        })();
    </script>
</div>

