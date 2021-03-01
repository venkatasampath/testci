<div class="card">
    <div class="card-header" style="height: 35px;">
        <div class="float-left">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTrauma" class="">Trauma<span class="caret"></span></a>
        </div>
    </div>
    <div id="collapseTrauma" class="card-collapse card-body collapse">
        
        
    @if(!empty($traumas) && count($traumas) > 0)
        <div class="col-md-10">
            <fieldset>
                    <div class="form-group">
                        <label class="col-md-4 offset-2">@lang('labels.initial')</label>
                        <label class="col-md-4">@lang('labels.review')</label>
                    </div>
            </fieldset>
        @foreach($traumas as $idx => $trauma)
            
            <fieldset>
                <div class="form-group">
                    
                    <label class="col-md-2 control-label">Zone: </label>
                    <div class="col-md-4">
                        <input type='hidden' name="traumas[original][se_trauma_id][{{$trauma->pivot->id}}][zone]" value='{{$trauma->pivot->zone_id}}'/>
                        {{ Form::select('traumas[original][se_trauma_id]['.$trauma->pivot->id.'][zone]', $list_zone, $trauma->pivot->zone_id, ['id' => 'zone_id', 'class' => 'form-control mav-select', 'disabled']) }}
                    </div>
                    <div class="col-md-4">
                        {{ Form::select('traumas[review][se_trauma_id]['.$trauma->pivot->id.'][zone]', $list_zone, !empty($pathologyReview['trauma']['se_trauma_id'][$trauma->pivot->id]['zone']) ? $pathologyReview['trauma']['se_trauma_id'][$trauma->pivot->id]['zone'] : null, ['id' => 'zone_id', 'class' => 'form-control mav-select', 'placeholder' => 'Select Zone', 'disabled' => !$SaveButton]) }}
                    </div>
                </div>
                
                <div class="form-group">
                    
                    <label class="col-md-2 control-label">Trauma: </label>
                    <div class="col-md-4">
                        <input type='hidden' name="traumas[original][se_trauma_id][{{$trauma->pivot->id}}][traumaid]" value='{{$trauma->pivot->trauma_id}}'/>
                        {{ Form::select('traumas[original][se_trauma_id]['.$trauma->pivot->id.'][traumaid]', $list_trauma, $trauma->pivot->trauma_id, ['id' => 'trauma_id', 'class' => 'form-control mav-select', 'disabled']) }}
                    </div>
                    <div class="col-md-4">
                        {{ Form::select('traumas[review][se_trauma_id]['.$trauma->pivot->id.'][traumaid]', $list_trauma, !empty($pathologyReview['trauma']['se_trauma_id'][$trauma->pivot->id]['traumaid']) ? $pathologyReview['trauma']['se_trauma_id'][$trauma->pivot->id]['traumaid'] : null, ['id' => 'pathology_id', 'class' => 'form-control mav-select', 'placeholder'=>'Select Trauma', 'disabled' => !$SaveButton]) }}
                    </div>
                </div>
                
                <div class="form-group">
                    
                    <label class="col-md-2 control-label">Additional Info: </label>
                    <div class="col-md-4">
                        <input type='hidden' name="traumas[original][se_trauma_id][{{$trauma->pivot->id}}][additionalinfo]" value='{{$trauma->pivot->additional_information}}'/>
                        {!! Form::textarea('traumas[original][se_trauma_id]['.$trauma->pivot->id.'][additionalinfo]', $trauma->pivot->additional_information, ['class' => 'form-control', 'disabled']) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Form::textarea('traumas[review][se_trauma_id]['.$trauma->pivot->id.'][additionalinfo]', !empty($pathologyReview['trauma']['se_trauma_id'][$trauma->pivot->id]['additionalinfo']) ? $pathologyReview['trauma']['se_trauma_id'][$trauma->pivot->id]['additionalinfo'] : null, ['class' => 'col-md-6 form-control', 'disabled' => !$SaveButton]) !!}
                    </div>
                </div>
            </fieldset>
            @if ($idx < (count($traumas) - 1))
            <hr style='height: 12px; border: 0; box-shadow:  inset 0 12px 12px -12px rgba(0, 0, 0, 0.5);'/>
            @endif
            
        @endforeach
        </div>

    @else
    <p>No traumas have been entered.</p>
    @endif

    </div>
</div>
<br/>