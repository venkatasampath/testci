<div class="card ">
    <div class="card-header" style="height: 35px;">
        <div class="float-left">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseMorphologys" class="">@lang('labels.morphologys')<span class="caret"></span></a>
        </div>
    </div>
    <div id="collapseMorphologys" class="card-collapse card-body {{ count($skeletalelement->morphologys) ? "" : "collapse" }}">
        <div class="col-md-10">
            <div class="form-group morphologys">
                <label class="col-md-4 control-label">@lang('labels.initial'): </label>
                {!! Form::select('morphologyslist[]', $list_se_morphologys, $morphologys, ['id' => 'morphologys', 'class' => 'form-control morphologys mav-select', 'multiple', 'style' => 'width: 60%; margin-top: 10px;', 'disabled'=>'disabled']) !!}
            </div>
            <div class="form-group morphologys">
                <label class="col-md-4 control-label">@lang('labels.review'): </label>
                {!! Form::select('morphologysreviewlist[]', $list_se_morphologys, !empty($articulationsReviewList['morphologys']) ? $articulationsReviewList['morphologys'] : null, ['id' => 'morphologys_review', 'class' => 'form-control morphologys mav-select', 'multiple', 'style' => 'width: 60%; margin-top: 10px;','dusk'=>'review-articulation-review', 'disabled' => !$SaveButton]) !!}
            </div>
        </div>
    </div>
</div>
<br/>