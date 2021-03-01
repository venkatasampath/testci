<div class="card ">
    <div class="card-header" style="height: 35px;">
        <div class="float-left">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseRefits" class="">@lang('labels.refits')<span class="caret"></span></a>
        </div>
    </div>
    <div id="collapseRefits" class="card-collapse card-body {{ count($skeletalelement->refits) ? "" : "collapse" }}">
        <div class="col-md-10">
            <div class="form-group refits">
                <label class="col-md-4 control-label">@lang('labels.initial'): </label>
                {!! Form::select('refitslist[]', $list_se_refits, $refits, ['id' => 'refits', 'class' => 'form-control refits mav-select', 'multiple', 'style' => 'width: 60%; margin-top: 10px;', 'disabled'=>'disabled']) !!}
            </div>
            <div class="form-group refits">
                <label class="col-md-4 control-label">@lang('labels.review'): </label>
                {!! Form::select('refitsreviewlist[]', $list_se_refits, !empty($refitsReviewList) ? $refitsReviewList : null, ['id' => 'refits_review', 'class' => 'form-control refits mav-select', 'multiple', 'style' => 'width: 60%; margin-top: 10px;','dusk'=>'review-articulation-review', 'disabled' => !$SaveButton]) !!}
            </div>
        </div>
        <br/>
        <div class="d-inline-flex btn-group row col-md-offset-4" role="group">
            @if( $SaveButton )
                <div class="btn-group mr-3" role="group" aria-label="Save">
                    {!! Form::button('<i class="fas fa-btn fa-save"></i>Save', ['type' => 'submit', 'name'=>'action', 'value'=>'saveRefits', 'class' => 'btn btn-primary','dusk'=>'review-associations-save']) !!}
                </div>
            @endif
            @if( $AcceptButton )
                <div class="btn-group mr-3" role="group" aria-label="Accept">
                    {!! Form::button('<i class="fas fa-btn fa-save"></i>Accept', ['type' => 'submit', 'name'=>'action', 'value'=>'acceptRefits', 'class' => 'btn btn-primary']) !!}
                </div>
            @endif
        </div>
        <br/>
    </div>
</div>
<br/>