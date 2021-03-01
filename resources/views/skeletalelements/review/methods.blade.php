<div class="card">
    <div class="card-header" style="height: 35px;">
        <div class="float-left">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$methodType}}" class="">{{$methodType}}<span class="caret"></span></a>
        </div>
    </div>
    <div id="collapse{{$methodType}}" class="card-collapse card-body {{ count($methods) ? "" : "collapse" }}">
    @if(count($methods) > 0)
        @foreach($methods as $method)
            @if ($method->uses_feature_score)
            <div class="col-md-10">
                <h3><a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/methods/'.$method->id) }}">{{$method->name}}</a></h3>
                <fieldset>
                    <div class="col-md-10 form-group">
                        <label class="col-md-3 offset-6 control-label">@lang('labels.initial')</label>
                        <label class="col-md-3 control-label">@lang('labels.review')</label>
                    </div>
                </fieldset>
                @foreach ($method->features as $current)
                    <fieldset>
                        <div class="col-md-10 form-group features">
                            {!! Form::label('feature', $current->display_name . ':', ['class' => 'col-md-6 control-label']) !!}
                            <div class="col-md-3">
                                {!! Form::hidden('features['.$current->id.'][se_id]', $skeletalelement->id) !!}
                                {!! Form::hidden('features['.$current->id.'][id]', $current->id) !!}
                                {!! Form::hidden('features['.$current->id.'][method_id]', $current->method_id) !!}
                                @if($skeletalelement->methodfeatures()->where('method_feature_id', $current->id)->get()->count() == 1)
                                    {!! Form::text('features['.$current->id.'][score]', $skeletalelement->methodfeaturesById($current->id)->pivot->score, ['class' => 'col-md-12 form-control', 'disabled'=>'disabled']) !!}
                                @else
                                    {!! Form::text('features['.$current->id.'][score]', null, ['class' => 'col-md-12 form-control', 'disabled'=>'disabled']) !!}
                                @endif
                            </div>
                            <div class='col-md-3'>
                                {!! Form::hidden('featuresreview['.$current->id.'][se_id]', $skeletalelement->id) !!}
                                {!! Form::hidden('featuresreview['.$current->id.'][id]', $current->id) !!}
                                {!! Form::hidden('featuresreview['.$current->id.'][method_id]', $current->method_id) !!}
                                @if(!empty($reviewMethods['methods'][$current->method_id]['features'][$current->id]))
                                    @if(isset($current->display_values))
                                        {!! Form::select('featurereview[methods]['.$current->method_id.'][features]['.$current->id.'][score]', json_decode($current->display_values), $reviewMethods['methods'][$current->method_id]['features'][$current->id]['score'], ['class' => 'col-md-12 form-control mav-select', 'placeholder' => trans('labels.select_option'), 'disabled' => !$SaveButton] ) !!}
                                    @else
                                        {!! Form::text('featurereview[methods]['.$current->method_id.'][features]['.$current->id.'][score]', $reviewMethods['methods'][$current->method_id]['features'][$current->id]['score'], ['class' => 'col-md-12 form-control', 'disabled' => !$SaveButton]) !!}
                                    @endif
                                @else
                                    @if(isset($current->display_values))
                                        {!! Form::select('featurereview[methods]['.$current->method_id.'][features]['.$current->id.'][score]', json_decode($current->display_values), null, ['class' => 'col-md-12 form-control mav-select', 'placeholder' => trans('labels.select_option'), 'disabled' => !$SaveButton] ) !!}
                                    @else
                                        {!! Form::text('featurereview[methods]['.$current->method_id.'][features]['.$current->id.'][score]', null, ['class' => 'col-md-12 form-control', 'disabled' => !$SaveButton]) !!}
                                    @endif
                                @endif
                            </div>
                        </div>
                    </fieldset>
                @endforeach
            </div>
            @endif
        @endforeach
        <!-- 
        <div class="col-md-4">
            <div style="text-align: center;"><img src="{{ $skeletalelement->skeletalbone->getImage('methods') }}"></div>
        </div>
        --> 
    @else
    <p>@lang('messages.no_methods_entered')</p>
    @endif

    </div>
</div>
<br/>

