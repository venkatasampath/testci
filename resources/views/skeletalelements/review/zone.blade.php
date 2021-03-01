<div class='col-md-12 float-right'>
    <h2><a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/zones/view') }}">@lang('labels.zones')</a></h2>
    <a class="help" data-trigger="click" data-toggle="tooltip" data-html="true" data-title='{{trans('messages.review_zones_help')}}'><i class="far fa-lg fa-question-circle" style="padding-right: 10px; color: #3097D1;"></i></a>
    {!! Form::model($skeletalelement, ['method' => 'POST', 'action' => ['SkeletalElementsController@storeReviewZones', $skeletalelement->id]]) !!}
        {{ csrf_field() }}

        <div class="form-group row">
            <label class="col-md-5 control-label">@lang('labels.initial')</label>
            <label class="col-md-5 control-label">@lang('labels.review')</label>
        </div>

        <div class="col-md-12">
            @foreach ($zones as $key=>$current)
                <fieldset class="zones" data-m-help_url="{{$current->help_url}}">
                    {!! Form::hidden('zones['.$current->id.'][id]', $current->id) !!}
                    <div class="checkbox-inline disabled col-md-5">
                        @if($skeletalelement->zones()->where('zone_id', $current->id)->get()->count() == 1)
                            {{ Form::hidden('zones['.$current->id.'][presence]', false) }}
                            {{ Form::checkbox('zones['.$current->id.'][presence]', true, $skeletalelement->getPresence($current->id), ['disabled']) }}
                            <label>{{$current->display_name}}</label>
                        @else
                            {{ Form::hidden('zones['.$current->id.'][presence]', false) }}
                            {{ Form::checkbox('zones['.$current->id.'][presence]', true, null,['disabled']) }}
                            <label>{{$current->display_name}}</label>
                        @endif
                    </div>
                    <div class="checkbox-inline col-md-5">
                        {{ Form::hidden('zonesreview['.$current->id.'][presence]', false) }}
                        {{ Form::checkbox('zonesreview['.$current->id.'][presence]', true, in_array($current->id, $zonesreview),['dusk'=>"review-zone-{$key}", 'disabled' => !$SaveButton]) }}
                        <label>{{$current->display_name}}</label>
                    </div>
                </fieldset>
            @endforeach
        </div>
    <div class="d-inline-flex btn-group row col-md-offset-4 pt-6" role="group">
        @if( $SaveButton )
            <div class="btn-group mr-2" role="group" aria-label="Save">
                {!! Form::button('<i class="fas fa-btn fa-save"></i>Save', ['type' => 'submit', 'name'=>'action', 'value'=>'Save', 'class' => 'btn btn-primary','dusk'=>'review-zone-save']) !!}
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
            var help_url = $("fieldset.zones").data("m-help_url");
            $('#help-info').attr('src', help_url);

            if ($('#control-sidebar-theme-tab').hasClass('active')) {
                $('#control-sidebar-theme-tab').removeClass('active');
                $('#control-sidebar-help-tab').toggleClass('active');
            }
        })();
    </script>
</div>