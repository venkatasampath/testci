<div class="card">
    <div class="card-header" style="height: 35px;">
        <div class="float-left">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapsePathology" class="">@lang('labels.pathology')<span class="caret"></span></a>
        </div>
    </div>
    <div id="collapsePathology" class="card-collapse card-body collapse">
    
    @if(!empty($pathologys) && count($pathologys) > 0)
        <fieldset>
            <div class="col-md-10">
                <div class="form-group">
                    <label class="col-md-4 offset-2">@lang('labels.initial')</label>
                    <label class="col-md-4">@lang('labels.review')</label>
                </div>
            </div>
        </fieldset>
        
        <div class="col-md-10">
        @foreach($pathologys as $idx => $pathology)
            
            <fieldset>
                <div class="form-group">
                    
                    <label class="col-md-2 control-label">@lang('labels.zone'): </label>
                    <div class="col-md-4">
                        <input type='hidden' name="pathologys[original][se_pathology_id][{{$pathology->pivot->id}}][zone]" value='{{$pathology->pivot->zone_id}}'/>
                        {{ Form::select('pathologys[original][se_pathology_id]['.$pathology->pivot->id.'][zone]', $list_zone, $pathology->pivot->zone_id, ['id' => 'zone_id', 'class' => 'form-control mav-select', 'disabled']) }}
                    </div>
                    <div class="col-md-4">
                        {{ Form::select('pathologys[review][se_pathology_id]['.$pathology->pivot->id.'][zone]', $list_zone, !empty($pathologyReview['pathology']['se_pathology_id'][$pathology->pivot->id]['zone']) ? $pathologyReview['pathology']['se_pathology_id'][$pathology->pivot->id]['zone'] : null, ['id' => 'zone_id_review', 'class' => 'form-control mav-select', 'placeholder' => 'Select Zone', 'disabled' => !$SaveButton]) }}
                    </div>
                </div>
                
                <div class="form-group">
                    
                    <label class="col-md-2 control-label">@lang('labels.pathology'): </label>
                    <div class="col-md-4">
                        <input type='hidden' name="pathologys[original][se_pathology_id][{{$pathology->pivot->id}}][pathologyid]" value='{{$pathology->pivot->pathology_id}}'/>
                        {{ Form::select('pathologys[original][se_pathology_id]['.$pathology->pivot->id.'][pathologyid]', $list_pathology, $pathology->pivot->pathology_id, ['id' => 'pathology_id', 'class' => 'form-control mav-select', 'disabled']) }}
                    </div>
                    <div class="col-md-4">
                        {{ Form::select('pathologys[review][se_pathology_id]['.$pathology->pivot->id.'][pathologyid]', $list_pathology, !empty($pathologyReview['pathology']['se_pathology_id'][$pathology->pivot->id]['pathologyid']) ? $pathologyReview['pathology']['se_pathology_id'][$pathology->pivot->id]['pathologyid'] : null, ['id' => 'pathology_id_review', 'class' => 'form-control mav-select', 'placeholder'=>'Select Pathology', 'disabled' => !$SaveButton]) }}
                    </div>
                </div>
                
                <div class="form-group">
                    
                    <label class="col-md-2 control-label">@lang('labels.additional_information'): </label>
                    <div class="col-md-4">
                        <input type='hidden' name="pathologys[original][se_pathology_id][{{$pathology->pivot->id}}][additionalinfo]" value='{{$pathology->pivot->additional_information}}'/>
                        {!! Form::textarea('pathologys[original][se_pathology_id]['.$pathology->pivot->id.'][additionalinfo]', $pathology->pivot->additional_information, ['class' => 'form-control', 'disabled']) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Form::textarea('pathologys[review][se_pathology_id]['.$pathology->pivot->id.'][additionalinfo]', !empty($pathologyReview['pathology']['se_pathology_id'][$pathology->pivot->id]['additionalinfo']) ? $pathologyReview['pathology']['se_pathology_id'][$pathology->pivot->id]['additionalinfo'] : null, ['class' => 'col-md-6 form-control', 'disabled' => !$SaveButton]) !!}
                    </div>
                </div>
            </fieldset>
            @if ($idx < (count($pathologys) - 1))
            <hr style='height: 12px; border: 0; box-shadow:  inset 0 12px 12px -12px rgba(0, 0, 0, 0.5);'/>
            @endif
        @endforeach
        </div>

    @else
    <p>@lang('messages.no_pathologies_entered')</p>
    @endif

    </div>
</div>
<br/>