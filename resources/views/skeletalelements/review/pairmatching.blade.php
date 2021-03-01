<div class="card ">
    <div class="card-header" style="height: 35px;">
        <div class="float-left">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapsePairMatching" class="">@lang('labels.pair_matching')<span class="caret"></span></a>
        </div>
    </div>
    <div id="collapsePairMatching" class="card-collapse card-body {{ count($skeletalelement->pairs) ? "" : "collapse" }}">
        <div class="col-md-10">
            <div class="form-group pairmatching">
                <label class="col-md-4 control-label">@lang('labels.initial'): </label>
                {!! Form::select('pairmatchinglist[]', $list_se_pair_matches, $pair_matches, ['id' => 'pairmatching', 'class' => 'form-control pairmatching mav-select', 'multiple', 'style' => 'width: 60%; margin-top: 10px;', 'disabled'=>'disabled']) !!}
            </div>
            <div class="form-group pairmatching">
                <label class="col-md-4 control-label">@lang('labels.review'): </label>
                {!! Form::select('pairmatchingreviewlist[]', $list_se_pair_matches, !empty($paiMatchesReviewList) ? $paiMatchesReviewList : null, ['id' => 'refits_review', 'class' => 'form-control refits mav-select', 'multiple', 'style' => 'width: 60%; margin-top: 10px;','dusk'=>'review-articulation-review', 'disabled' => !$SaveButton]) !!}
            </div>
        </div>
        <br/>
        <div class="d-inline-flex btn-group row col-md-offset-4" role="group">
            @if( $SaveButton )
                <div class="btn-group mr-3" role="group" aria-label="Save">
                    {!! Form::button('<i class="fas fa-btn fa-save"></i>Save', ['type' => 'submit', 'name'=>'action', 'value'=>'savePairMatching', 'class' => 'btn btn-primary','dusk'=>'review-associations-save']) !!}
                </div>
            @endif

            @if( $AcceptButton )
                <div class="btn-group mr-3" role="group" aria-label="Accept">
                    {!! Form::button('<i class="fas fa-btn fa-save"></i>Accept', ['type' => 'submit', 'name'=>'action', 'value'=>'acceptPairMatching', 'class' => 'btn btn-primary']) !!}
                </div>
            @endif
        </div>
        <br/>
    </div>
</div>
<br/>